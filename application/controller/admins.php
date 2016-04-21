<?php

class admins extends Controller {

  public function index() {}
    require APP . 'view/_templates/header.php';
    require APP . 'view/admins/index.php';
    require APP . 'view/_templates/footer.php';
  }

  public function addadmin() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/admins/addadmin.php';
    require APP . 'view/_templates/footer.php';
  }


}
