
<?php
session_start(); 
if(session_destroy())
{

//redirect catre pagina de login
header('Location:index.php' );
}
?>