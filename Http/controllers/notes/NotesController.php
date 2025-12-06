<?php

namespace Http\controllers\notes;

use Core\App;
use Core\Authenticator;
use Core\ApiToken;
use Core\DAO\NoteDaoFactory;
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

    private function requireAuth(): void //verificamos que el usuario este autenticado
    {
        if ($this->isApi()) {
            $tokenService = new ApiToken();
            $token        = get_bearer_token();
            $userId       = $tokenService->userIdFromToken($token);

            if (!$userId) {
                json_response(['error' => 'Token inválido o no proporcionado'], 401);
            }

            $this->currentUserId = $userId;
        } else {
            if ($this->currentUserId === null) {
                redirect('/login');
            }
        }
    }

    private function authorizeNoteOwner(array $note): void //verificamos que la nota pertenezca al usuario logeado
    {
        if ($note['user_id'] != $this->currentUserId) {
            if ($this->isApi()) {
                json_response(['error' => 'No autorizado'], 403);
            } else {
                authorize(false);
            }
        }
    }

    public function index(): void //get
    {
        $this->requireAuth();

        $notes = $this->noteDao->getAllByUserId($this->currentUserId);

        if ($this->isApi()) {
            json_response(['notes' => $notes]);
        } else {
            view("notes/index.view.php", [
                'heading' => 'Mis Notas',
                'notes'   => $notes
            ]);
        }
    }

    public function show(): void //get
    {
        $this->requireAuth();

        $id = (int)($_GET['id'] ?? 0);

        if ($id === 0) {
            if ($this->isApi()) {
                json_response(['error' => 'ID requerido'], 400);
            } else {
                abort(404);
            }
            return;
        }

        $note = $this->noteDao->findById($id);

        if (!$note) {
            if ($this->isApi()) {
                json_response(['error' => 'Nota no encontrada'], 404);
            } else {
                abort(404);
            }
            return;
        }

        $this->authorizeNoteOwner($note);

        if ($this->isApi()) {
            json_response(['note' => $note]);
        } else {
            view("notes/show.view.php", [
                'heading' => 'Nota',
                'note'    => $note,
            ]);
        }
    }

    public function create(): void //get formulario html
    {
        $this->requireAuth();

        if ($this->isApi()) {
            json_response(['error' => 'No disponible en API'], 405);
        }

        view('notes/create.view.php', [
            'heading' => 'Crear nota',
            'errors'  => [],
        ]);
    }

    public function store(): void //post
    {
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
                json_response(['errors' => $errors], 422);
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
            json_response(['message' => 'Nota creada correctamente'], 201);
        } else {
            redirect('/notes');
        }
    }

    public function edit(): void //get formulario html
    {
        $this->requireAuth();

        if ($this->isApi()) {
            json_response(['error' => 'No disponible en API'], 405);
        }

        $id = (int)($_GET['id'] ?? 0);
        if ($id === 0) {
            abort(404);
        }

        $note = $this->noteDao->findById($id);
        if (!$note) {
            abort(404);
        }

        $this->authorizeNoteOwner($note);

        view('notes/edit.view.php', [
            'heading' => 'Editar nota',
            'errors'  => [],
            'note'    => $note,
        ]);
    }

    public function update(): void //put o patch
    {
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
                json_response(['error' => 'ID requerido'], 400);
            } else {
                abort(404);
            }
            return;
        }

        $note = $this->noteDao->findById($id);
        if (!$note) {
            if ($this->isApi()) {
                json_response(['error' => 'Nota no encontrada'], 404);
            } else {
                abort(404);
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
                json_response(['errors' => $errors], 422);
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
            json_response(['message' => 'Nota actualizada']);
        } else {
            redirect('/notes');
        }
    }

    public function destroy(): void //delete
    {
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
                json_response(['error' => 'ID requerido'], 400);
            } else {
                abort(404);
            }
            return;
        }

        $note = $this->noteDao->findById($id);
        if (!$note) {
            if ($this->isApi()) {
                json_response(['error' => 'Nota no encontrada'], 404);
            } else {
                abort(404);
            }
            return;
        }

        $this->authorizeNoteOwner($note);

        $this->noteDao->delete($id);

        if ($this->isApi()) {
            json_response(['message' => 'Nota eliminada']);
        } else {
            redirect('/notes');
        }
    }
}
