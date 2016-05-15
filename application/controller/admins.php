<?php

class Admins extends Controller {

    public function login() 
    {
        require APP . 'view/_templates/header.php';
        require APP . 'view/admins/login.php';
        require APP . 'view/_templates/footer.php';
    }

    public function index() {	
		$admins=$this->model->getAllAdmins();
		$ranks = ['super admin', 'admin', 'guard'];    
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

       public function delete($id) {
        $success = $this->model->destroy($id);
        if ($success) {
            header('location: ' . URL . 'admins/index');
            die();
        }
        else {
            // TODO: add flash message
            header('location: ' . URL . 'errorz/index');
            die();
        }
    }

    public function edit() {
        session_start();

        $admin_db = $this->model->find_by_id($_SESSION['admin_id']);
        $cache = (array) $admin_db;
        require APP . 'view/_templates/header.php';
        require APP . 'view/admins/edit.php';
        require APP . 'view/_templates/footer.php';
    }

    public function update() {
        session_start();

        if (!$_POST || !isset($_POST['Update'])) {
            header('location: ' . URL . 'admins/edit');
            die();
        }

        $admin = $this->model;
        $admin->initialize(
            $_SESSION['admin_id'],
            trim($_POST['UserName']),
            $_POST['OldPassword'],
            $_POST['Password'],
            $_POST['RepeatPassword']
        );

        $success = $admin->update();

        if ($success) {
            header('location: ' . URL . 'admins/edit');
            die();
        }
        else {
            $validation_errors = $admin->validation_errors;
            require APP . 'view/_templates/header.php';
            require APP . 'view/admins/edit.php';
            require APP . 'view/_templates/footer.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('location: ' . URL . 'admins/index');
        die();
    }
}
