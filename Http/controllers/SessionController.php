<?php

namespace Http\controllers;

use Core\ApiToken;
use Core\Authenticator;
use Core\Response;

class SessionController
{
    private Authenticator $auth;
    private ApiToken $tokens;

    public function __construct()
    {
        $this->auth = new Authenticator();
        $this->tokens = new ApiToken();
    }

    // POST /api/session/login
    public function apiLogin(): void //generamos el token
    {
        if (!is_api_request()) {
            abort(Response::NOT_FOUND);
        }

        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);

        if (!is_array($data)) {
            $data = $_POST;
        } // Si no es JSON válido, miramos en $_POST

        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            Response::json(
                ['error' => 'email y password son obligatorios'],
                Response::BAD_REQUEST
            );        }

        $signedIn = $this->auth->attempt($email, $password);

        if (!$signedIn) {
            Response::json(
                ['error' => 'Credenciales incorrectas'],
                Response::UNAUTHORIZED
            );
        }

        $userId = $this->auth->currentUserId();

        $token = $this->tokens->generateForUser($userId);

        Response::json([
            'token' => $token,
            'user'  => [
                'id'    => $userId,
                'email' => $email,
            ],
        ]); //devolvemos el token y los datos del usuario
    }

    // POST /api/session/logout
    public function apiLogout(): void //invalidamos el token
    {
        if (!is_api_request()) {
            abort(Response::NOT_FOUND);
        }

        $token = get_bearer_token();

        if (!$token) {
            Response::json(
                ['error' => 'Token no proporcionado'],
                Response::BAD_REQUEST
            );
        }

        $this->tokens->deleteToken($token);

        Response::json(['message' => 'Sesión REST cerrada correctamente']);
    }

    public function apuiLogoutAll(): void{
        if(!is_api_request()){
            abort(Response::NOT_FOUND);
        }

        $token = get_bearer_token();

        if(!$token){
            Response::json(
                ['errror' => 'Debes proporcionar un token válido']
            );
        }

        $userId = $this->tokens->userIdFromToken($token);

        if(!$userId){
            Response::json(
                ['error' => 'El token no es válido'],Response::UNAUTHORIZED
            );
        }

        $this->tokens->deleteAllTokensForUser(($userId));

        Response::json(
            ['mensaje' => 'Se han cerrado todas las sesiones del usuario correctamente']
        );
    }
}
