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
        $this->auth   = new Authenticator();
        $this->tokens = new ApiToken();
    }

    // POST /api/session/login
    public function apiLogin(): void //generamos el token
    {
        if (!is_api_request()) {
            abort(404);
        }

        $raw  = file_get_contents('php://input');
        $data = json_decode($raw, true);

        if (!is_array($data)) {
            $data = $_POST;
        }

        $email    = $data['email']    ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            json_response(['error' => 'email y password son obligatorios'], 400);
        }

        $signedIn = $this->auth->attempt($email, $password);

        if (!$signedIn) {
            json_response(['error' => 'Credenciales incorrectas'], 401);
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
            abort(404);
        }

        $token = get_bearer_token();

        if (!$token) {
            json_response(['error' => 'Token no proporcionado'], 400);
        }

        $this->tokens->deleteToken($token);

        json_response(['message' => 'Sesión REST cerrada correctamente']);
    }
}
