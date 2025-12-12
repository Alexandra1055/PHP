<?php
namespace Core\DAO;

interface UserDao
{
    public function findById(int $id): ?array;

    public function updateUser(int $id, array $data): void; //asi data seria un array asociativo(clave-valor) con los campos a actualizar

}