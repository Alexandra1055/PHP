<?php

namespace Http\controllers\notes;

use Core\DAO\NoteDaoFactory;
use Core\RequestContext;
use Core\Response;
use Core\Validator;

class NotesController
{
    private $noteDao;

    public function __construct(){
        $this->noteDao = NoteDaoFactory::create();
    }

    private function isApi(): bool{
        return RequestContext::isApi();
    }
    private function currentUserId(): int{
        $userId = RequestContext::userId();

        if (!$userId) {
            if ($this->isApi()) {
                Response::json(['error' => 'No autenticado'], Response::UNAUTHORIZED);
            } else {
                redirect('/login');
            }
        }

        return (int) $userId;
    }

    private function authorizeNoteOwner(array $note, int $userId): void{
        if (($note['user_id'] ?? null) != $userId) {
            if ($this->isApi()) {
                Response::json(['error' => 'No autorizado'], Response::FORBIDDEN);
            } else {
                authorize(false);
            }
        }
    }

    // GET /notes (WEB) y GET /api/notes (API)
    public function index(): void{
        $userId = $this->currentUserId();

        $notes = $this->noteDao->getAllByUserId($userId);

        if ($this->isApi()) {
            Response::json(['notes' => $notes]);
        } else {
            view("notes/index.view.php", [
                'heading' => 'Mis Notas',
                'notes' => $notes
            ]);
        }
    }

    // GET /note?id=1 (WEB) y GET /api/note?id=1 (API)
    public function show(): void{
        $userId = $this->currentUserId();

        $id = (int) ($_GET['id'] ?? 0);

        if ($id === 0) {
            if ($this->isApi()) {
                Response::json(['error' => 'ID requerido'], Response::BAD_REQUEST);
            } else {
                abort(Response::NOT_FOUND);
            }
            return;
        }

        $note = $this->noteDao->findById($id);

        if (!$note) {
            if ($this->isApi()) {
                Response::json(['error' => 'Nota no encontrada'], Response::NOT_FOUND);
            } else {
                abort(Response::NOT_FOUND);
            }
            return;
        }

        $this->authorizeNoteOwner($note, $userId);

        if ($this->isApi()) {
            Response::json(['note' => $note]);
        } else {
            view("notes/show.view.php", [
                'heading' => 'Nota',
                'note' => $note,
            ]);
        }
    }

    // GET /notes/create (WEB)
    public function create(): void{
        // En WEB la ruta ya debe llevar ->only('auth')
        $this->currentUserId();

        if ($this->isApi()) {
            Response::json(['error' => 'No disponible en API'], 405);
        }

        view('notes/create.view.php', [
            'heading'=> 'Crear nota',
            'errors' => [],
        ]);
    }

    // POST /notes (WEB) y POST /api/notes (API)
    public function store(): void{
        $userId = $this->currentUserId();

        if ($this->isApi()) {
            $raw  = file_get_contents('php://input');
            $data = json_decode($raw, true) ?? [];
            $body = $data['body'] ?? '';
        } else {
            $body = $_POST['body'] ?? '';
        }

        $errors = [];

        if (!Validator::string($body, 1, 1000)) {
            $errors['body'] = 'El texto debe tener máximo 1000 caracteres';
        }

        if (!empty($errors)) {
            if ($this->isApi()) {
                Response::json(['errors' => $errors], 422);
            } else {
                view('notes/create.view.php', [
                    'heading' => 'Crear nota',
                    'errors' => $errors,
                ]);
            }
            return;
        }

        $this->noteDao->create($body, $userId);

        if ($this->isApi()) {
            Response::json(['message' => 'Nota creada correctamente'], 201);
        } else {
            redirect('/notes');
        }
    }

    // GET /note/edit?id=1 (WEB)
    public function edit(): void{
        $userId = $this->currentUserId();

        if ($this->isApi()) {
            Response::json(['error' => 'No disponible en API'], 405);
        }

        $id = (int) ($_GET['id'] ?? 0);
        if ($id === 0) {
            abort(Response::NOT_FOUND);
        }

        $note = $this->noteDao->findById($id);
        if (!$note) {
            abort(Response::NOT_FOUND);
        }

        $this->authorizeNoteOwner($note, $userId);

        view('notes/edit.view.php', [
            'heading' => 'Editar nota',
            'errors'  => [],
            'note'    => $note,
        ]);
    }

    // PATCH /note (WEB) y PUT/PATCH /api/note (API)
    public function update(): void{
        $userId = $this->currentUserId();

        if ($this->isApi()) {
            $raw = file_get_contents('php://input');
            $data = json_decode($raw, true) ?? [];
            $id = isset($data['id']) ? (int) $data['id'] : 0;
            $body = $data['body'] ?? '';
        } else {
            $id = (int) ($_POST['id'] ?? 0);
            $body = $_POST['body'] ?? '';
        }

        if ($id === 0) {
            if ($this->isApi()) {
                Response::json(['error' => 'ID requerido'], Response::BAD_REQUEST);
            } else {
                abort(Response::NOT_FOUND);
            }
            return;
        }

        $note = $this->noteDao->findById($id);
        if (!$note) {
            if ($this->isApi()) {
                Response::json(['error' => 'Nota no encontrada'], Response::NOT_FOUND);
            } else {
                abort(Response::NOT_FOUND);
            }
            return;
        }

        $this->authorizeNoteOwner($note, $userId);

        $errors = [];

        if (!Validator::string($body, 1, 1000)) {
            $errors['body'] = 'El texto debe tener máximo 1000 caracteres';
        }

        if (!empty($errors)) {
            if ($this->isApi()) {
                Response::json(['errors' => $errors], 422);
            } else {
                view('notes/edit.view.php', [
                    'heading'=> 'Editar nota',
                    'errors' => $errors,
                    'note' => $note,
                ]);
            }
            return;
        }

        $this->noteDao->update($id, $body);

        if ($this->isApi()) {
            Response::json(['message' => 'Nota actualizada']);
        } else {
            redirect('/notes');
        }
    }

    // DELETE /note (WEB) y DELETE /api/note (API)
    public function destroy(): void
    {
        $userId = $this->currentUserId();

        if ($this->isApi()) {
            $raw  = file_get_contents('php://input');
            $data = json_decode($raw, true) ?? [];
            $id   = isset($data['id']) ? (int) $data['id'] : 0;

            if ($id === 0) {
                $id = (int) ($_GET['id'] ?? 0);
            }
        } else {
            $id = (int) ($_POST['id'] ?? 0);
        }

        if ($id === 0) {
            if ($this->isApi()) {
                Response::json(['error' => 'ID requerido'], Response::BAD_REQUEST);
            } else {
                abort(Response::NOT_FOUND);
            }
            return;
        }

        $note = $this->noteDao->findById($id);
        if (!$note) {
            if ($this->isApi()) {
                Response::json(['error' => 'Nota no encontrada'], Response::NOT_FOUND);
            } else {
                abort(Response::NOT_FOUND);
            }
            return;
        }

        $this->authorizeNoteOwner($note, $userId);

        $this->noteDao->delete($id);

        if ($this->isApi()) {
            Response::json(['message' => 'Nota eliminada']);
        } else {
            redirect('/notes');
        }
    }
}
