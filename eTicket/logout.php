<?php

    require_once 'php/function/connection.php';
    require_once 'php/function/session.php';
    
    session_start();

    if(isset($_SESSION['loggedin']))
        DestroySession();
    
    header('Location: index.php');
    exit();
?>
