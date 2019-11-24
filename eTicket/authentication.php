<?php
require_once 'config.php';
require_once 'php/function/connection.php';
require_once 'php/function/session.php';
require_once 'php/function/db.php';

session_start();

$con = connect();

if (! isset($_POST['username'], $_POST['password'])) {

    die('Please fill both the username and password field!');
}

if ($_POST['type'] == 'Login') {

    login_user($con);
    
} else {
    
    $flag=false;

    if (! isset($_POST['username'], $_POST['password'])) {
        
        $flag=true;
        echo "<script type='text/javascript'> alert('Please complete the registration form!');
                                              window.location.href = 'login.php'
              </script>";
        
    }

    if (empty($_POST['username']) || empty($_POST['password'])) {
        
        $flag=true;
        echo "<script type='text/javascript'> alert('Please complete the registration form!');
                                              window.location.href = 'login.php'
              </script>";
    }

    if (! filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) {

        $flag=true;
        echo "<script type='text/javascript'> alert('Email is not valid!');
                                              window.location.href = 'login.php'
              </script>";
    }

    
    if (preg_match('/[a-z]/', $_POST['password']) == 0) {
        $flag=true;
        echo "<script type='text/javascript'> alert('Password must contain at least one lower case');
                                              window.location.href = 'login.php'
              </script>";
    } else if ((preg_match('/[A-Z]/', $_POST['password']) == 0) && (preg_match('/[0-9]/', $_POST['password']) == 0)) {
        $flag=true;
        echo "<script type='text/javascript'> alert('Password must contain at least one upper case and an upper case or digit');
                                              window.location.href = 'login.php'
              </script>";
    } else {
        
        if($flag==false)
            register_user($con);
    }
}

mysqli_close($con);

?>