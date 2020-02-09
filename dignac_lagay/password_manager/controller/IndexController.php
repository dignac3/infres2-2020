<?php

include dirname(__FILE__).'/../model/services/UserService.php';
include dirname(__FILE__).'/../model/services/PasswordService.php';
include dirname(__FILE__).'/../model/connection.php';

class IndexController
{

    private $mysqli;
    private $userService;
    private $passwordService;
    private $templater;

    /**
     * IndexController constructor.
     * @param $templater
     */
    public function __construct($templater)
    {
        $this->templater = $templater;
        $this->mysqli = getConnection();
        $this->userService = new UserService($this->mysqli);
        $this->passwordService = new PasswordService($this->mysqli);
    }


    public function getIndex()
    {

        $template = $this->templater->load("index.php");

        return $template->render();
    }

    public function getLogin()
    {
        $template = $this->templater->load("login.php");

        return $template->render();
    }

    public function postLogin($request) {
        $connected = 0;
        $uuid = bin2hex(random_bytes(16));
        $challenge = $request["challenge"];

        $user = $this->userService->getUserByMail($request['i_email']);
        if (!$user) {
            $granted = 0;
            return;
        }
        $stored_password = $user->master_password;
        $salted_password = $_SESSION["login_challenge"] . $stored_password;

        $server_challenge = hash("sha256", $salted_password);

        $challenge == $server_challenge ? $granted = 1 : $granted = 0;

        if ($granted) {
            $connected = $this->userService->updateUUID($uuid, $request['i_email']);

            $_SESSION["session_id"] = $uuid;
        }

        if ($connected) {
            $this->templater->addGlobal('session', $_SESSION);
            $template = $this->templater->load("index.php");
            return $template->render(['connected' => $connected]);
        } else {
            $template = $this->templater->load("login.php");
            return $template->render(['connected' => false]);
        }
    }

    public function getRegister() {
        $template = $this->templater->load("register.php");

        return $template->render();

    }

    public function postRegister($request)
    {
        $created = $this->userService->register($request['i_email'], $request['i_pwd']);

        if ($created) {
            $template = $this->templater->load("login.php");
            return $template->render(['created' => $created]);
        } else {
            $template = $this->templater->load("register.php");
            return $template->render(['error' => true]);
        }

    }

    public function getPasswordList()
    {
        $uuid = $_SESSION["session_id"];
        $user = $this->userService->getUserIdByUUID($uuid);

        $passwords = $this->passwordService->getPasswords($user->id);
        $template = $this->templater->load("list_passwords.php");
        return $template->render(['passwords' => $passwords]);
    }

    public function getPasswordForm() {
        $template = $this->templater->load("add_password.html");
        return $template->render();
    }

    public function postCreatePassword($request)
    {

        $uuid = $_SESSION["session_id"];
        $user = $this->userService->getUserIdByUUID($uuid);

        $this->passwordService->createPassword($user->id, $_POST['i_label'], $_POST['i_login'], $_POST['i_password']);
        return $this->getPasswordList();
    }
}

?>