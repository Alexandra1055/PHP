<?php

namespace Core\Middleware;

use Core\RequestContext;

class Guest{
    public function handle(): void{
        if (RequestContext::isApi()) {
            return;
        } //asi no hago redirect con la api

        if ($_SESSION['user'] ?? false) {
            header('location: /');
            exit();
        }
    }
}
