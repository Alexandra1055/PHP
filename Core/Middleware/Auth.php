<?php

namespace Core\Middleware;

use Core\ApiToken;
use Core\RequestContext;
use Core\Response;

class Auth
{
    public function handle(): void{
        if (RequestContext::isApi()) { //api
            $token = get_bearer_token();

            if (!$token) {
                Response::json(['error' => 'Token no proporcionado'], Response::UNAUTHORIZED);
            }

            $tokens = new ApiToken();
            $userId = $tokens->userIdFromToken($token);

            if (!$userId) {
                Response::json(['error' => 'Token inválido o caducado'], Response::UNAUTHORIZED);
            }

            RequestContext::setUserId((int) $userId);
            RequestContext::setToken($token);
            return;
        }

        if (!($_SESSION['user'] ?? false)) { //web
            header('location: /');
            exit();
        }

        if (isset($_SESSION['user']['id'])) {
            RequestContext::setUserId((int)$_SESSION['user']['id']);
        }
    }
}
