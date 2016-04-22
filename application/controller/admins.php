<?php

class admins extends Controller {

 
  public function index() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/admins/index.php';
    require APP . 'view/_templates/footer.php';
  }
  
  
   public function register() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/admins/register.php';
    require APP . 'view/_templates/footer.php';
  }
  
    public function account() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/admins/account.php';
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
 
 }

?>
