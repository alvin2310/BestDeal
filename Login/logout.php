<?php
session_start();

if(isset($_SESSION['user_id'])){
    session_destroy();  //Is Used To Destroy Specified Session
    header('Location: ../index.php');
}

?>