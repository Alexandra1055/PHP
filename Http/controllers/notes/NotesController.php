<?php

namespace Http\controllers\notes;

use Core\Authenticator;
use Core\ApiToken;
use Core\DAO\NoteDaoFactory;
use Core\Response;
use Core\Validator;

class NotesController
{
    private $noteDao;
    private Authenticator $auth;
    private ?int $currentUserId;

    public function __construct()
    {
        $this->noteDao       = NoteDaoFactory::create();
        $this->auth          = new Authenticator();
        $this->currentUserId = $this->auth->currentUserId();
    }

    private function isApi(): bool
    {
        return is_api_request();
    }

    private function requireAuth(): void{// Verificamos que el usuario esté autenticado
        if ($this->isApi()) {
            $tokenService = new ApiToken();
            $token        = get_bearer_token();
            $userId       = $tokenService->userIdFromToken($token);

            if (!$userId) {
                Response::json(['error' => 'Token inválido o no proporcionado'], Response::UNAUTHORIZED);
            }

            $this->currentUserId = $userId;
        } else {
            if ($this->currentUserId === null) {
                redirect('/login');
            }
        }
    }


    private function authorizeNoteOwner(array $note): void{// Verificamos que la nota pertenezca al usuario logueado
        if ($note['user_id'] != $this->currentUserId) {
            if ($this->isApi()) {
                Response::json(['error' => 'No autorizado'], Response::FORBIDDEN);
            } else {
                authorize(false);
            }
        }
    }

    public function index(): void{//GET /notes y GET /api/notes
        $this->requireAuth();

        $notes = $this->noteDao->getAllByUserId($this->currentUserId);

        if ($this->isApi()) {
            Response::json(['notes' => $notes]);
        } else {
            view("notes/index.view.php", [
                'heading' => 'Mis Notas',
                'notes'   => $notes
            ]);
        }
    }

    public function show(): void{//GET /note y GET /api/note
        $this->requireAuth();

        $id = (int)($_GET['id'] ?? 0);

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

        $this->authorizeNoteOwner($note);

        if ($this->isApi()) {
            Response::json(['note' => $note]);
        } else {
            view("notes/show.view.php", [
                'heading' => 'Nota',
                'note'    => $note,
            ]);
        }
    }

    public function create(): void{//GET /notes/create HTML
        $this->requireAuth();

        if ($this->isApi()) {
            Response::json(['error' => 'No disponible en API'], 405);
        }

        view('notes/create.view.php', [
            'heading' => 'Crear nota',
            'errors'  => [],
        ]);
    }

    public function store(): void{//POST /notes y POST /api/notes
        $this->requireAuth();

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
                    'errors'  => $errors,
                ]);
            }
            return;
        }

        $this->noteDao->create($body, $this->currentUserId);

        if ($this->isApi()) {
            Response::json(['message' => 'Nota creada correctamente'], 201);
        } else {
            redirect('/notes');
        }
    }

    public function edit(): void{//GET /note/edit HTML
        $this->requireAuth();

        if ($this->isApi()) {
            Response::json(['error' => 'No disponible en API'], 405);
        }

        $id = (int)($_GET['id'] ?? 0);
        if ($id === 0) {
            abort(Response::NOT_FOUND);
        }

        $note = $this->noteDao->findById($id);
        if (!$note) {
            abort(Response::NOT_FOUND);
        }

        $this->authorizeNoteOwner($note);

        view('notes/edit.view.php', [
            'heading' => 'Editar nota',
            'errors'  => [],
            'note'    => $note,
        ]);
    }

    public function update(): void{//PATCH /note y PUT/PATCH /api/note
        $this->requireAuth();

        if ($this->isApi()) {
            $raw  = file_get_contents('php://input');
            $data = json_decode($raw, true) ?? [];
            $id   = isset($data['id']) ? (int)$data['id'] : 0;
            $body = $data['body'] ?? '';
        } else {
            $id   = (int)($_POST['id'] ?? 0);
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

        $this->authorizeNoteOwner($note);

        $errors = [];

        if (!Validator::string($body, 1, 1000)) {
            $errors['body'] = 'El texto debe tener máximo 1000 caracteres';
        }

        if (!empty($errors)) {
            if ($this->isApi()) {
                Response::json(['errors' => $errors], 422);
            } else {
                view('notes/edit.view.php', [
                    'heading' => 'Editar nota',
                    'errors'  => $errors,
                    'note'    => $note,
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

    public function destroy(): void{//DELETE /note y DELETE /api/note
        $this->requireAuth();

        if ($this->isApi()) {
            $raw  = file_get_contents('php://input');
            $data = json_decode($raw, true) ?? [];
            $id   = isset($data['id']) ? (int)$data['id'] : 0;

            if ($id === 0) {
                $id = (int)($_GET['id'] ?? 0);
            }
        } else {
            $id = (int)($_POST['id'] ?? 0);
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

        $this->authorizeNoteOwner($note);

        $this->noteDao->delete($id);

        if ($this->isApi()) {
            Response::json(['message' => 'Nota eliminada']);
        } else {
            redirect('/notes');
        }
    }
}
