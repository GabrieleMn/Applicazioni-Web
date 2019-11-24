<?php
require_once '../../config.php';
require_once 'connection.php';
require_once 'db.php';
require_once 'session.php';

startSession();

$response = array(
    'status' => "",
    'message' => ""
);

if (isLogged() == false) {

    $response['status'] = 'timeout';
    $response['message'] = 'You are not authenticated, please login';
    echo json_encode($response);

    return;
}

if (! isset($_POST['row']) || ! isset($_POST['col'])) {
    return;
}

$row = $_POST['row'];
$col = $_POST['col'];

if (checkLimit($row, $col) == false) {
    echo json_encode($response);
    return;
}

$con = connect_from_ajax();

if($con==false)
    return;

mysqli_begin_transaction($con); /* _______________________TRANSACTION BEGIN___________ */
mysqli_autocommit($con, FALSE);

$result = getSeatStatus($con, $row, $col); // lock table

if($result==false)
    return;

if ($result[0] != 2) { // se il posto non è stato comprato

    if ($result[0] == 1){ // posto prenotato, posso rubarlo
        
        if(updateBookSeat($con, $row, $col)==false)
            return;
    }
    else{ // posto non esistente, quindi libero
        if(insertBookSeat($con, $row, $col)==false)
            return;
    }

    $response['status'] = 'success';
    $response['message'] = 'Your seat has successfully been booked';
} else {

    // posto comprato, fallisce il book
    $response['status'] = 'error2';
    $response['message'] = 'Sorry, the seat has already been bought';
}

mysqli_commit($con); /* __________________________________TRANSACTION END_____________ */

mysqli_autocommit($con, TRUE);
mysqli_close($con);

echo json_encode($response);

?>