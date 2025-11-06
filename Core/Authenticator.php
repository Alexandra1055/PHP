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
                $this->login(['email' => $email]);

                return true;
            }
        }
        return false;
    }
    public function login($user){
        $_SESSION['user']= [
            'email' => $user['email']
        ];

        session_regenerate_id(true);
    }

    public function logout(){
        $_SESSION=[]; //vaciamos

        session_destroy(); //destruimos el archivo de sesion

        $params = session_get_cookie_params(); //esto devuelve una array con la ruta y el domino de la sesion
        setcookie('PHPSESSID', '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
//tiempo menos 1h, solo lo estas situando en el pasado. Podriamos omitir serure y httponly si queremos

    }
}