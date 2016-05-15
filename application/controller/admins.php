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

    public function add() {
		$institutions=$this->model->getAllInstitutions();
		require APP . 'view/_templates/header.php';
		if (!$_POST || !isset($_POST['AddAdmin'])) {
            require APP . 'view/admins/addadmin.php';
            require APP . 'view/_templates/footer.php';
			die();
        }

		if(!empty($_POST['InstitutionId']))
		{
			$Rank = 1;
			$InstId = $_POST['InstitutionId'];
		}
		else 
		{
			$Rank=2;
			$InstId = $this->model->getInstId_by_id($_SESSION['admin_id']);
		}
        $admin = $this->model;
        $admin->initialize_add(
			$_POST['admin_UserName'],
			$_POST['admin_LastName'],
            $_POST['admin_CNP'],
            $_POST['admin_Password'],
            $_POST['admin_RepeatPassword'],
			$InstId,
			$Rank);

        $success = $admin->add_admin();

        if ($success) {
            header('location: ' . URL . 'admins/index');
            die();
        }
        else {
            $validation_errors = $admin->validation_errors;
            require APP . 'view/admins/addadmin.php';
            require APP . 'view/_templates/footer.php';
        }
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
