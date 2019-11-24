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
if (! isset($_POST['bookings'])) {
    return;
}

$flag = 0;
$data = json_decode(stripslashes($_POST['bookings']));

$con = connect_from_ajax();

if($con==false)
    return;

mysqli_begin_transaction($con); /* _______________________TRANSACTION 1 BEGIN____________ */
mysqli_autocommit($con, FALSE);

// controllo per ogni posto che ho prenotato, se è stato rubato da qualcuno
for ($i = 0; $i < sizeof($data); $i ++) {

    $res_id = explode('-', $data[$i]);

    if (checkLimit($res_id[0], $res_id[1]) == false) {
        echo json_encode($response);
        mysqli_rollback($con);
        mysqli_autocommit($con, TRUE);
        mysqli_close($con);

        return;
    }

    $result = getSeatStatus($con, $res_id[0], $res_id[1]); // Lock table

    if ($result == false)
        return;

    // se il posto esiste, sia che sia prenotato o comprato da altri devo fallire l'acquisto
    if ($result[0] != - 1) {

        if ($_SESSION['name'] != $result[1]) {

            $flag = 1;
            break;
        } else {
            if (updateBuySeat($con, $res_id[0], $res_id[1]) == false)
                return;
        }
    } else { // se il posto non esiste, lo compro comunque

        if (insertBuySeat($con, $res_id[0], $res_id[1]) == false)
            return;
    }
}

if ($flag == 0) {

    /* if the sell of all my booked seat successed */
    $response['status'] = 'success';
    $response['message'] = 'Your seats ticket has been bought successfully';
    mysqli_commit($con); /* _______________________TRANSACTION 1 END____________ */
} else {

    /*
     * if only one of my seat has been stolen, rollback every seat i already bought before the one
     * who failed
     */

    $response['status'] = 'error';
    $response['message'] = 'Sorry some of your bookings have been stolen by someone';

    mysqli_rollback($con); /* _______________________TRANSACTION 1 ROLLBACK____________ */

    mysqli_begin_transaction($con); /* ________TRANSACTION 2 BEGIN____________ */

    /* free all the seat that you have booked, but only the one that has not been stolen */
    for ($i = 0; $i < sizeof($data); $i ++) {

        $res_id = explode('-', $data[$i]);

        $result = getSeatStatus($con, $res_id[0], $res_id[1]); // lock Table

        if ($result == false)
            return;

        /* check if i'm unbooking only the seat that has not been stolen */
        if ($result[0] != - 1) {
            if ($result[1] == $_SESSION['name'])
                if (unbookSeat($con, $res_id[0], $res_id[1]) == false)
                    return;
        }
    }

    mysqli_commit($con); /* ________TRANSACTION 2 END____________ */
}

mysqli_autocommit($con, TRUE);
mysqli_close($con);

echo json_encode($response);

?>

