<?php
namespace Core;

class ApiToken
{
    private Database $db;

    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }

    public function generateForUser(int $userId): string //crea un token para el usuario
    {

        $token = bin2hex(random_bytes(32));

        $this->db->query(
            'INSERT INTO api_tokens (user_id, token) VALUES (:user_id, :token)',
            [
                'user_id' => $userId,
                'token' => $token,
            ]
        );

        return $token;
    }

    public function userIdFromToken(?string $token): ?int //busca el user id a partir del token
    {
        if (!$token) {
            return null;
        }

        $row = $this->db
            ->query('SELECT user_id FROM api_tokens WHERE token = :token LIMIT 1', [
                'token' => $token
            ])
            ->find();

        if (!$row) {
            return null;
        }

        return (int)$row['user_id'];
    }

    public function deleteToken(string $token): void //elimina el token de la base de datos
    {
        $this->db->query(
            'DELETE FROM api_tokens WHERE token = :token',
            ['token' => $token]
        );
    }
}