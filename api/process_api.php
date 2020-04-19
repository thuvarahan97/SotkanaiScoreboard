<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization, Accept, X-Requested-With, x-xsrf-token');
header('Content-Type: application/json; charset=utf-8');

include "config.php";

$postjson = json_decode(file_get_contents('php://input'), true);

if ($postjson['key'] == "process_login") {
    $logindata = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM tbl_judges WHERE judge_id = '$postjson[judge_id]'"));

    $data = array(
        'judge_id' => $logindata['judge_id'],
        'judge_name' => $logindata['judge_name']
    );

    if ($logindata) {
        $result = json_encode(array('success'=>true, 'result'=>$data));
    }
    else {
        $result = json_encode(array('success'=>false));
    }

    echo $result;
}

elseif ($postjson['key'] == "load_schools_students") {
    $judge_id = $postjson['judge_id'];

    $query = mysqli_query($mysqli, "SELECT DISTINCT A.round_id, A.round_name, A.school_id, A.school_name, A.student_id, A.student_name, B.judge_id AS student_judge_id, C.judge_id AS school_judge_id FROM view_current_round A INNER JOIN tbl_rounds_judges D ON A.round_id = D.round_id AND D.judge_id = '$judge_id' LEFT OUTER JOIN tbl_student_scores B ON A.round_id = B.round_id AND A.student_id = B.student_id AND B.judge_id = '$judge_id' LEFT OUTER JOIN tbl_school_overall_scores C ON A.round_id = C.round_id AND A.school_id = C.school_id AND C.judge_id = '$judge_id' WHERE A.round_id = (SELECT round_id from view_current_round GROUP BY round_id ORDER BY round_id LIMIT 1) ORDER BY A.school_id ASC, A.student_id ASC");

    if (mysqli_num_rows($query) > 0) {
        while ($rows = mysqli_fetch_array($query)) {
            $data[] = array(
                'round_id' => $rows['round_id'],
                'school_id' => $rows['school_id'],
                'school_name' => $rows['school_name'],
                'student_id' => $rows['student_id'],
                'student_name' => $rows['student_name'],
                'student_judge_id' => $rows['student_judge_id'],
                'school_judge_id' => $rows['school_judge_id']
            );
        }
    }
    else {
        $data = array();
    }
    
    if ($query) {
        $result = json_encode(array('success'=>true, 'result'=>$data));
    }
    else {
        $result = json_encode(array('success'=>false));
    }

    echo $result;
}

elseif ($postjson['key'] == "submit_scores") {
    $judge_id = $postjson['judge_id'];
    $round_id = $postjson['round_id'];
    $school_id = $postjson['school_id'];
    $student_id = $postjson['student_id'];
    $score_1 = intval($postjson['score_1']);
    $score_2 = intval($postjson['score_2']);
    $score_3 = intval($postjson['score_3']);
    $score_4 = intval($postjson['score_4']);
    $score_5 = intval($postjson['score_5']);
    $score_6 = intval($postjson['score_6']);
    $total_score = $score_1 + $score_2 + $score_3 + $score_4 + $score_5 + $score_6;

    if ($student_id == '#overall') {
        $query = mysqli_query($mysqli, "INSERT INTO tbl_school_overall_scores (`school_id`, `round_id`, `judge_id`, `score_1`, `score_2`, `score_3`, `score_4`, `score_5`, `score_6`, `total_score`) VALUES ('$school_id', '$round_id', '$judge_id', '$score_1', '$score_2', '$score_3', '$score_4', '$score_5', '$score_6', '$total_score')");
    }
    else {
        $query = mysqli_query($mysqli, "INSERT INTO tbl_student_scores (`student_id`, `round_id`, `judge_id`, `score_1`, `score_2`, `score_3`, `score_4`, `score_5`, `score_6`, `total_score`) VALUES ('$student_id', '$round_id', '$judge_id', '$score_1', '$score_2', '$score_3', '$score_4', '$score_5', '$score_6', '$total_score')");
    }
    
    if ($query) {
        $result = json_encode(array('success'=>true));
    }
    else {
        $result = json_encode(array('success'=>false));
    }

    echo $result;
}

elseif ($postjson['key'] == "save_judge_name") {
    $judge_id = $postjson['judge_id'];
    $judge_name = $postjson['judge_name'];

    $query = mysqli_query($mysqli, "UPDATE tbl_judges SET judge_name = '$judge_name' WHERE judge_id = '$judge_id'");
    
    if ($query) {
        $result = json_encode(array('success'=>true));
    }
    else {
        $result = json_encode(array('success'=>false));
    }

    echo $result;
}

?>