<?php

class test extends Controller {

 
  public function index() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/test/index.php';
    require APP . 'view/_templates/footer.php';
  }
  
  
   public function register() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/test/register.php';
    require APP . 'view/_templates/footer.php';
  }
  
    public function account() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/test/account.php';
    require APP . 'view/_templates/footer.php';
  }
  
  public function addguard() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/test/addguard.php';
    require APP . 'view/_templates/footer.php';
  }
  public function addadmin() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/test/addadmin.php';
    require APP . 'view/_templates/footer.php';
  }
 
 }

?>
