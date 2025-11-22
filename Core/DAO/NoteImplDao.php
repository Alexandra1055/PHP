<?php

namespace Core\DAO;

use Core\Database;

class NoteImplDao implements NoteDao{
    private Database $db;
    public function __construct(Database $db)
    {
        $this->db = $db;
    }
    public function getAllByUserId(int $userId): array
    {
        return $this->db->query(
            "SELECT * FROM notes WHERE user_id = :user_id",[
                'user_id' => $userId
            ])->get();
    }

    public function findById(int $id): ?array
    {
        $note = $this->db
            ->query('SELECT * FROM notes WHERE id = :id', [
                'id' => $id
            ])
            ->find();

        return $note ?: null;
    }

    public function create(string $body, int $userId): void
    {
        $this->db->query(
            'INSERT INTO notes (body, user_id) VALUES (:body, :user_id)',
            [
                'body'    => $body,
                'user_id' => $userId,
            ]
        );
    }

    public function update(int $id, string $body): void
    {
        $this->db->query(
            'UPDATE notes SET body = :body WHERE id = :id',
            [
                'body' => $body,
                'id'   => $id,
            ]
        );
    }

    public function delete(int $id): void
    {
        $this->db->query(
            'DELETE FROM notes WHERE id = :id',
            [
                'id' => $id,
            ]
        );
    }
}