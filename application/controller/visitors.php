<?php

class visitors extends Controller {

 
  public function index() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/visitors/index.php';
    require APP . 'view/_templates/footer.php';
  }
 
  public function account() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/visitors/account.php';
    require APP . 'view/_templates/footer.php';
  }
  
   public function appointment() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/visitors/appointment.php';
    require APP . 'view/_templates/footer.php';
  }
 
  public function visits() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/visitors/visits.php';
    require APP . 'view/_templates/footer.php';
  }
 
  public function editaccount() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/visitors/editaccount.php';
    require APP . 'view/_templates/footer.php';
  }
  
  public function register() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/visitors/register.php';
    require APP . 'view/_templates/footer.php';
  }
 
 
 }

?>
