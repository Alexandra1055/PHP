<?php

namespace Http\controllers\notes;

use Core\Authenticator;
use Core\DAO\NoteDaoFactory;
use Core\Validator;

class NotesController{
    private $noteDao;
    private Authenticator $auth;
    private ?int $currentUserId;

    public function __construct()
    {
        $this->noteDao = NoteDaoFactory::create();
        $this->auth= new Authenticator();
        $this->currentUserId = $this->auth->currentUserId();
    }
    private function requireAuth(): void
    {
        if ($this->currentUserId === null) {
            redirect('/login');
        }
    }

    private function authorizeNoteOwner(array $note): void
    {
        authorize($note['user_id'] == $this->currentUserId);
    }
    public function index(): void
    {
        $this->requireAuth();

        $notes = $this->noteDao->getAllByUser($this->currentUserId);

        view("notes/index.view.php", [
            'heading' => 'Mis Notas',
            'notes'   => $notes
        ]);
    }

    public function show(array $params): void
    {
        $this->requireAuth();

        $note = $this->noteDao->findById((int)$params['id']);

        if (!$note) {
            abort(404);
        }

        $this->authorizeNoteOwner($note);

        view("notes/show.view.php", [
            'heading' => 'Nota',
            'note'    => $note,
        ]);
    }

    public function store(): void
    {
        $this->requireAuth();

        $errors = [];

        if (!Validator::string($_POST['body'], 1, 1000)) {
            $errors['body'] = 'El texto debe tener máximo 1000 caracteres';
        }

        if (!empty($errors)) {
            view('notes/create.view.php', [
                'heading' => 'Crear nota',
                'errors'  => $errors,
            ]);
            return;
        }

        $this->noteDao->create($_POST['body'], $this->currentUserId);

        redirect('/notes');
    }

    public function edit(): void
    {
        $this->requireAuth();

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

    public function update(): void
    {
        $this->requireAuth();

        $id = (int)($_POST['id'] ?? 0);
        if ($id === 0) {
            abort(404);
        }

        $note = $this->noteDao->findById($id);
        if (!$note) {
            abort(404);
        }

        $this->authorizeNoteOwner($note);

        $errors = [];

        if (!Validator::string($_POST['body'], 1, 1000)) {
            $errors['body'] = 'El texto debe tener máximo 1000 caracteres';
        }

        if (!empty($errors)) {
            view('notes/edit.view.php', [
                'heading' => 'Editar nota',
                'errors'  => $errors,
                'note'    => $note,
            ]);
            return;
        }

        $this->noteDao->update($id, $_POST['body']);

        redirect('/notes');
    }

    public function destroy(): void
    {
        $this->requireAuth();

        $id = (int)($_POST['id'] ?? 0);
        if ($id === 0) {
            abort(404);
        }

        $note = $this->noteDao->findById($id);
        if (!$note) {
            abort(404);
        }

        $this->authorizeNoteOwner($note);

        $this->noteDao->delete($id);

        redirect('/notes');
    }
}