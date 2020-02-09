<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

include_once 'router/Request.php';
include_once 'router/Router.php';
include_once 'controller/IndexController.php';
require_once 'vendor/autoload.php';

session_start();

$loader = new FilesystemLoader('template');

$templater = new Environment($loader,[]);

if (!isset($_SESSION["login_challenge"])) {
    $_SESSION["login_challenge"] = bin2hex(random_bytes(16));
}

$templater->addGlobal("session", $_SESSION);

$indexController = new IndexController($templater);

$router = new Router(new Request);

$router->get('/', function (){
    global $indexController;

    return $indexController->getIndex();

});

$router->get('/index', function (){
    global $indexController;

    return $indexController->getIndex();

});

$router->get('/register',function (){
    global $indexController;

    return $indexController->getRegister();
});

$router->get('/passwords', function () {
    global $indexController;

    return $indexController->getPasswordList();
});

$router->get('/passwords/new', function () {
    global $indexController;

    return $indexController->getPasswordForm();
});

$router->post('/passwords/new', function ($request) {
    global $indexController;

    return $indexController->postCreatePassword($request);
});

$router->post('/register',function ($request){
    global $indexController;

    return $indexController->postRegister($request->getBody());
});


$router->get('/login',function (){
    global $indexController;

    return $indexController->getLogin();


});

$router->post('/login',function ($request){
    global $indexController;

    return $indexController->postLogin($request->getBody());
});

$router->get('/logout',function (){
    session_destroy();
    global $indexController;

    return $indexController->getIndex();
});

?>