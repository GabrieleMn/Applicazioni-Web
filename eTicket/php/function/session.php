<?php

function startSession()
{
    if (! isset($_SESSION)) {
        session_start();
    }
}

function isLogged()
{
    if (! isset($_SESSION['loggedin'])) {
        return false;
    }

    $expiration_time = 2*60; // 2 minuti

    if (isset($_SESSION['name'])) {
        $now = time();
        // If more than $expiration_time passed we logout and return false
        if ($now - $_SESSION['time'] > $expiration_time) {
            DestroySession();
            return false;
        }
        // Update timestamp
        $_SESSION['time'] = $now;
        return true;
    }
    // If we never logged in
    return false;
}

function DestroySession()
{
    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 3600 * 24, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        session_destroy();
    }
}

?>