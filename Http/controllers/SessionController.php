<?php

namespace Http\controllers;

use Core\ApiToken;
use Core\Authenticator;
use Core\RequestContext;
use Core\Response;

class SessionController
{
    private Authenticator $auth;
    private ApiToken $tokens;

    public function __construct(){
        $this->auth = new Authenticator();
        $this->tokens = new ApiToken();
    }

    // POST
    public function apiLogin(): void{
        if (!RequestContext::isApi()) {
            abort(Response::NOT_FOUND);
        }

        $raw  = file_get_contents('php://input');
        $data = json_decode($raw, true);

        if (!is_array($data)) {
            $data = $_POST ?? [];
        }

        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            Response::json(['error' => 'email y password son obligatorios'], Response::BAD_REQUEST);
        }

        if (!$this->auth->attempt($email, $password)) {
            Response::json(['error' => 'Credenciales incorrectas'], Response::UNAUTHORIZED);
        }

        $userId = (int) $this->auth->currentUserId();
        $token  = $this->tokens->generateForUser($userId);

        Response::json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $userId,
                'email'=> $email,
            ],
        ]);
    }

    // DELETE
    public function apiLogout(): void{
        if (!RequestContext::isApi()) {
            abort(Response::NOT_FOUND);
        }

        $token = RequestContext::token();

        if (!$token) {
            Response::json(['error' => 'Token no proporcionado'], Response::UNAUTHORIZED);
        }

        $this->tokens->deleteToken($token);

        Response::json(['message' => 'Sesión REST cerrada correctamente']);
    }

    // DELETE ALL
    public function apiLogoutAll(): void{
        if (!RequestContext::isApi()) {
            abort(Response::NOT_FOUND);
        }

        $userId = RequestContext::userId();

        if (!$userId) {
            Response::json(['error' => 'No autenticado'], Response::UNAUTHORIZED);
        }

        $this->tokens->deleteAllTokensForUser((int) $userId);

        Response::json(['message' => 'Se cerraron todas las sesiones correctamente']);
    }
}
