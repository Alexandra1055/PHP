<?php
namespace Core;

class ApiToken
{
    private Database $db;
    private int $timeLiveTokens; //para ver el tiempo que le queda al token

    public function __construct(int $timeLiveTokens = 3600)
    {
        $this->db = App::resolve(Database::class);
        $this->timeLiveTokens = $timeLiveTokens;
    }

    public function generateForUser(int $userId): string //crea un token para el usuario
    {

        $token = bin2hex(random_bytes(32));

        $expiresAt = (new \DateTimeImmutable(
            "+{$this->timeLiveTokens} seconds"))
        ->format("Y-m-d H:i:s")
        ;

        $this->db->query(
            'INSERT INTO api_tokens (user_id, token, expires_at)
                    VALUES (:user_id, :token, :expires_at)',
            [
                'user_id' => $userId,
                'token' => $token,
                'expires_at'=>$expiresAt,
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
            ->query('SELECT user_id, expiresAt FROM api_tokens WHERE token = :token LIMIT 1',
                ['token' => $token])
            ->find();

        if (!$row) {
            return null;
        }

        $expiresAt = strtotime($row['expiresAt']);
        if($expiresAt!==false && $expiresAt < time()) {
            $this->deleteToken($token);
            return null;
        }//elimino cuando caduque el token

        return (int)$row['user_id'];
    }

    public function deleteToken(string $token): void //elimina el token de la base de datos
    {
        $this->db->query(
            'DELETE FROM api_tokens WHERE token = :token',
            ['token' => $token]
        );
    }

    public function deleteAllTokensForUser(int $userID):void{
        $this->db->query(
            'DELETE FROM api_tokens WHERE user_id=:user_id',
            ['user_id' => $userID]
        );
    }
}