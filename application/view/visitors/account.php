<?php
//in principiu asta ar trebui sa fie pe fiecare pagina dar imi da eroare
// session_start();


if(!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in'])){
    //User not logged in. Redirect them back to the login.php page.
    //header('Location:login.php');
    exit;
}

echo 'Congratulations! You are logged in!';