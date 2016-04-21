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
  
  
  
  public function register() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/visitors/register.php';
    require APP . 'view/_templates/footer.php';
  }
 
 
 }

?>
