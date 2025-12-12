<?php

namespace Core\DAO;

interface UserDao{
    public function getUserById($id);
    public function getAllTokens();

}