<?php

class Admins extends Controller {

    public function login() 
    {
        require APP . 'view/_templates/header.php';
        require APP . 'view/admins/login.php';
        require APP . 'view/_templates/footer.php';
    }

    public function index() {	

        require APP . 'view/_templates/header.php';
        require APP . 'view/admins/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function addguard() {
        require APP . 'view/_templates/header.php';
        require APP . 'view/admins/addguard.php';
        require APP . 'view/_templates/footer.php';
    }
    public function addadmin() {
        require APP . 'view/_templates/header.php';
        require APP . 'view/admins/addadmin.php';
        require APP . 'view/_templates/footer.php';
    }

    public function deleteadmin() {
        require APP . 'view/_templates/header.php';
        require APP . 'view/admins/deleteadmin.php';
        require APP . 'view/_templates/footer.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header('location: ' . URL . 'admins/index');
        die();
    }
}
