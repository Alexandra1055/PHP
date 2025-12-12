<?php

namespace Core\DAO;

use Core\DAO\UserDao;
use Core\Database;

class UserDaoPdo implements UserDao
{
    private Database $db;
    public function __construct(Database $db){
        $this->db = $db;
    }

    public function findById(int $id): ?array
    {
        $user = $this->db
            ->query('SELECT * FROM users WHERE id = :id', ['id' => $id])
            ->find();

        return $user ? $user : null;
    }

    public function updateUser(int $id, array $data): void
    {
        $allowed = ['full_name', 'phone', 'birthdate']; //atributos que se pueden actualizar, para no tocar los demas

        $setParts = [];
        $params   = ['id' => $id];

        foreach ($allowed as $column) {
            if (array_key_exists($column, $data)) {
                $setParts[]      = "{$column} = :{$column}";
                $params[$column] = $data[$column]; // puede ser null
            }
        }

        if (empty($setParts)) {
            return;
        }

        $sql = 'UPDATE users SET ' . implode(', ', $setParts) . ' WHERE id = :id';

        $this->db->query($sql, $params);
    }
}