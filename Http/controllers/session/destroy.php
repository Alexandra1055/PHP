<?php
//log out del usuario

use Core\Authenticator;
use Http\Forms\LoginForm;

$auth = new Authenticator();
$auth->logout();

header('location: /');
exit();
