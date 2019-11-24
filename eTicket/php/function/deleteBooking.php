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

    /* protection for html ispection by not authenticated user */
    $response['status'] = 'timeout';
    $response['message'] = 'You are not authenticated, please login';
    echo json_encode($response);
    return;
}

/* protection from direct url inserting */
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

mysqli_begin_transaction($con); /* ___________TRANSACTION BEGIN___________ */
mysqli_autocommit($con, FALSE);

/* lock table */
$result = getSeatStatus($con, $row, $col);

if($result==false)
    return;
    

/* check if someone stole my booking before deleting */
if ($result[0] != - 1) {
    if ($result[0] == 1 && $_SESSION['name'] == $result[1]) {

        /* if it is still mine */
        if(unbookSeat($con, $row, $col)==false)
            return;

        $response['status'] = 'success';
        $response['message'] = 'Your seat has successfully been unbooked';
    } else if (($result[0] == 1 && $_SESSION['name'] != $result[1])) {

        /* if someone booked it */
        $response['status'] = 'error1';
        $response['message'] = 'Your booking has been stolen by someone!';
    } else if ($result[0] == 2 && $_SESSION['name'] != $result[1]) {

        /* if someone booked and bought it */
        $response['status'] = 'error2';
        $response['message'] = 'Your booking has been stolen and bought by someone';
    }
} else {
    $response['status'] = 'success2';
    $response['message'] = 'Your seat has already been unbooked';
}

mysqli_commit($con); /* ____________TRANSACTION END_____________ */
mysqli_autocommit($con, TRUE);
mysqli_close($con);

echo json_encode($response);

?>