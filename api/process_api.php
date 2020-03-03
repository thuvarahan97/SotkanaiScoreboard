<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization, Accept, X-Requested-With, x-xsrf-token');
header('Content-Type: application/json; charset=utf-8');

include "config.php";

$postjson = json_decode(file_get_contents('php://input'), true);

if ($postjson['aksi'] == "process_login") {
    $logindata = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM tbl_users WHERE user_id = '$postjson[user_id]'"));

    $data = array(
        'user_id' => $logindata['user_id']
    );

    if ($logindata) {
        $result = json_encode(array('success'=>true, 'result'=>$data));
    }
    else {
        $result = json_encode(array('success'=>false));
    }

    echo $result;
}

?>