<?php

namespace Core\DAO;

use Core\DAO\UserDao;
use Core\App;
use Core\Database;

class UserDaoFactory
{
    public static function create(): UserDao
    {
        $db = App::resolve(Database::class);
        return new UserDaoPdo($db);
    }
}//como el note de arriba, para futuras implementaciones de UserDao