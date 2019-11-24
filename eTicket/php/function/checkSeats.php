<?php 

require_once '../../config.php';
require_once 'connection.php';
require_once 'db.php';
require_once 'session.php';

startSession();

$response = array('status' => "", 'message' => "");

if(isLogged()==false){
    
    /* protection for html ispection by not authenticated user */
    $response['status'] = 'timeout';
    $response['message'] = 'You are not authenticated, please login';
    
    echo json_encode($response);
    return;
    
}  

if (! isset($_POST['bookings'])) {
    return;
}

$data = json_decode(stripslashes($_POST['bookings']));

$con = connect_from_ajax();

if($con==false)
    return;

mysqli_begin_transaction($con); /* _______________________TRANSACTION 1 BEGIN____________ */
mysqli_autocommit($con, FALSE);

for ($i = 0; $i < sizeof($data); $i ++) {
    
    $res_id = explode('-', $data[$i]);
    
    if(checkLimit($res_id[0], $res_id[1])==false){
        echo json_encode($response);
        
        mysqli_rollback($con);
        mysqli_autocommit($con, TRUE);
        mysqli_close($con);
        
        return;
    }
    
    $result = getSeatStatus($con, $res_id[0], $res_id[1]); // Lock table
    
    if($result==false)
        return;
        
    
    //se il posto esiste, sia che sia prenotato o comprato da altri devo fallire l'acquisto
    if ($result[0] == - 1) {
        
        insertBookSeat($con, $res_id[0], $res_id[1]);
        
    }
    
    
}

mysqli_autocommit($con, TRUE);
mysqli_close($con);
        
echo json_encode($response);


?>