<?php

class visitors extends Controller {

 
  public function login() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/visitors/login.php';
    require APP . 'view/_templates/footer.php';
  }
  
  public function index() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/visitors/index.php';
    require APP . 'view/_templates/footer.php';
  }
  
  public function register() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/visitors/register.php';
    require APP . 'view/_templates/footer.php';
  }
 
  public function appointments() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/visitors/appointments.php';
    require APP . 'view/_templates/footer.php';
  }
  public function logout() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/visitors/logout.php';
    require APP . 'view/_templates/footer.php';
  }
 
  public function editaccount() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/visitors/editaccount.php';
    require APP . 'view/_templates/footer.php';
  }
 
 }

?>
