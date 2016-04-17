<?php

class Inmates extends Controller {

  public function index() {

    $inmates = $this->model->getAllInmates();
    require APP . 'view/_templates/header.php';
    require APP . 'view/inmates/index.php';
    require APP . 'view/_templates/footer.php';
  }

  public function new() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/inmates/new.php';
    require APP . 'view/_templates/footer.php';
  }

  public function create() {
    require APP . 'view/_templates/header.php';
    require APP . 'view/inmates/create.php';
    require APP . 'view/_templates/footer.php';
  }
}
