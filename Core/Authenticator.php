<?php

namespace Core;

class Authenticator{
    public function attempt($email, $password){ //funcion de intentar

        $user = App::resolve(Database::class)
            ->query('select * from users where email = :email', [
            'email' => $email
        ])->find();


        if($user) {
            //para verificar nuestra contraseña encriptada
            if(password_verify($password, $user['password'])) {
                $this->login($user);

                return true;
            }
        }
        return false;
    }
    public function login($user){
        $_SESSION['user']= [
            'id' => $user['id'],
            'email' => $user['email']
        ];

        session_regenerate_id(true);
    }

    public function logout(){
      Session::destroy();
    }

    public function currentUserId(): ?int
    {
        return Session::get('user')['id'] ?? null;
    }
}