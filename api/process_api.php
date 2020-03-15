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

if ($postjson['aksi'] == "load_schools_students") {
    $user_id = $postjson['user_id'];

    $query = mysqli_query($mysqli, "SELECT DISTINCT A.round_id, A.round_name, A.school_id, A.school_name, A.student_id, A.student_name, B.judge_id FROM view_current_round A LEFT OUTER JOIN tbl_student_scores B ON A.round_id = B.round_id AND A.student_id = B.student_id AND B.judge_id = '$user_id' WHERE A.round_id = (SELECT round_id from view_current_round GROUP BY round_id ORDER BY round_id LIMIT 1)");

    while ($rows = mysqli_fetch_array($query)) {
        $data[] = array(
            'round_id' => $rows['round_id'],
            'school_id' => $rows['school_id'],
            'school_name' => $rows['school_name'],
            'student_id' => $rows['student_id'],
            'student_name' => $rows['student_name'],
            'judge_id' => $rows['judge_id']
        );
    }

    if ($query) {
        $result = json_encode(array('success'=>true, 'result'=>$data));
    }
    else {
        $result = json_encode(array('success'=>false));
    }

    echo $result;
}

if ($postjson['aksi'] == "submit_scores") {
    $user_id = $postjson['user_id'];
    $round_id = $postjson['round_id'];
    $school_id = $postjson['school_id'];
    $student_id = $postjson['student_id'];
    $score_1 = intval($postjson['score_1']);
    $score_2 = intval($postjson['score_2']);
    $score_3 = intval($postjson['score_3']);
    $total_score = $score_1 + $score_2 + $score_3;

    if ($student_id == '#overall') {
        $query = mysqli_query($mysqli, "INSERT INTO tbl_school_overall_scores (`school_id`, `round_id`, `judge_id`, `aspect1`, `aspect2`, `aspect3`, `total_score`) VALUES ('$school_id', '$round_id', '$user_id', '$score_1', '$score_2', '$score_3', '$total_score')");
    }
    else {
        $query = mysqli_query($mysqli, "INSERT INTO tbl_student_scores (`student_id`, `round_id`, `judge_id`, `aspect1`, `aspect2`, `aspect3`, `total_score`) VALUES ('$student_id', '$round_id', '$user_id', '$score_1', '$score_2', '$score_3', '$total_score')");
    }
    
    if ($query) {
        $result = json_encode(array('success'=>true));
    }
    else {
        $result = json_encode(array('success'=>false));
    }

    echo $result;
}

?>