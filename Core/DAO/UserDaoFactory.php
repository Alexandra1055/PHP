<?php

namespace Core\DAO;


use Core\App;
use Core\Database;

class UserDaoFactory
{
    public static function create(): UserDao
    {
        $db = App::resolve(Database::class);
        return new UserDaoPdo($db);
    }
}