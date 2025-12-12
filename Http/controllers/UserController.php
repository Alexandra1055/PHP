<?php

namespace Http\controllers;

use Core\ApiToken;
use Core\DAO\UserDao;
use Core\DAO\UserDaoFactory;
use Core\Response;
use Core\Validator;
class UserController
{
    private ApiToken $tokens;
    private UserDao $userDao;

    public function __construct(){
        $this->tokens = new ApiToken();
        $this->userDao = UserDaoFactory::create();
    }


    private function requireApiAuth(): int{ //devolvemos la id del usuario
        if(!is_api_request()){
            abort(Response::NOT_FOUND);
        }
        $token = get_bearer_token();
        $userId = $this->tokens->userIdFromToken($token);

        if(!$userId){
            Response::json(['error' => 'Token inválido o no proporcionado'],
                Response::UNAUTHORIZED);
        }
        return $userId;
    }

    public function showMe(): void{ // GET /api/users/me
        $userId = $this->requireApiAuth();

        $user = $this->userDao->findById($userId);

        if (!$user) {
            Response::json(['error' => 'Usuario no encontrado'],
                Response::NOT_FOUND);
        }

        Response::json(['user' => $user]);
    }

    public function updateMe(): void{ //PATCH /api/users/me
        $userId = $this->requireApiAuth();

        $data = json_decode(file_get_contents('php://input'),true)??[];

        $errors = [];
        $updateData = [];

        if(array_key_exists('full_name', $data)){
            $fullName = $data['full_name'];
            if($fullName !== null && !Validator::string($fullName,1,100)){
                $errors['full_name'] = 'El nombre debe tener entre 1 y 100 caracteres';
            } else {
                $updateData['full_name'] = $fullName;
            }
        }

        if (array_key_exists('phone', $data)) {
            $phone = $data['phone'];
            if ($phone !== null && !Validator::string($phone, 5, 20)) {
                $errors['phone'] = 'El teléfono debe tener entre 5 y 20 caracteres';
            } else {
                $updateData['phone'] = $phone;
            }
        }
        if (array_key_exists('birthdate', $data)) {
            $birthdate = $data['birthdate'];

            if ($birthdate !== null) {
                $date = \DateTime::createFromFormat('Y-m-d', $birthdate);
                if (!$date || $date->format('Y-m-d') !== $birthdate) {
                    $errors['birthdate'] = 'La fecha debe tener el formato YYYY-MM-DD';
                } else {
                    $updateData['birthdate'] = $birthdate;
                }
            } else {
                $updateData['birthdate'] = null; //asi si pongo null, se guarda null en la bd
            }
        }

        if (!empty($errors)) {
            Response::json(['errors' => $errors], 422);
        }

        if (empty($updateData)) {
            Response::json(
                ['error' => 'No se ha enviado ningún dato para actualizar'],
                Response::BAD_REQUEST
            );
        }

        $this->userDao->updateUser($userId, $updateData);

        Response::json(['message' => 'Datos de usuario actualizados']);
    }
}