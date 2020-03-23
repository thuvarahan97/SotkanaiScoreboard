<?php include_once 'header.php'; ?>

<?php

if (isset($_GET['round_id']) && !empty($_GET['round_id'])) {
    $round_id = $_GET['round_id'];

    $query = mysqli_query($mysqli, "SELECT A.*, E.competition_id, E.competition_name, F.district_id, F.district_name, B.school_id_1, B.school_id_2, C.school_name AS school_name_1, D.school_name AS school_name_2 FROM tbl_rounds A LEFT OUTER JOIN tbl_rounds_schools B USING (round_id) INNER JOIN tbl_schools C ON B.school_id_1 = C.school_id INNER JOIN tbl_schools D ON B.school_id_2 = D.school_id INNER JOIN tbl_competitions E ON A.competition_id = E.competition_id LEFT OUTER JOIN tbl_districts F ON E.district_id = F.district_id WHERE round_id = '$round_id'");

    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);

        $school_id_1 = $row['school_id_1'];
        $school_id_2 = $row['school_id_2'];
        $school_name_1 = $row['school_name_1'];
        $school_name_2 = $row['school_name_2'];
    }
    else {
        echo '<script> location.replace("competitions.php"); </script>';
    }
}
else {
    echo '<script> location.replace("competitions.php"); </script>';
}

?>

<div class="row">
    <div class="col-lg-12">
        <h3 class="title-5 m-b-35">Round : <?php echo $row['round_name'];?></h3>
    </div>
</div>

<div class="row">

    <div class="col-lg-6">
        <div class="table-responsive">
            <table class="table table-data2 table-content-details">
                <tbody>
                    <tr>
                        <td>Competition:</td>
                        <td><?php echo $row['competition_name'];?></td>
                    </tr>
                    <tr>
                        <td>Round:</td>
                        <td><?php echo $row['round_name'];?></td>
                    </tr>
                    <tr>
                        <td>District:</td>
                        <?php if ($row['district_name'] != "" && !empty($row['district_name'])) { ?>
                        <td><?php echo $row['district_name'];?></td>
                        <?php } else { ?>
                        <td><i>Unavailable</i></td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td>School 1:</td>
                        <?php if ($school_id_1 != "" && !empty($school_id_1)) { ?>
                        <td><?php echo $school_name_1;?></td>
                        <?php } else { ?>
                        <td><i>Unavailable</i></td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td>School 2:</td>
                        <?php if ($school_id_2 != "" && !empty($school_id_2)) { ?>
                        <td><?php echo $school_name_2;?></td>
                        <?php } else { ?>
                        <td><i>Unavailable</i></td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td>Round Status:</td>
                        <?php if ($row['round_status'] == 1) { ?>
                        <td style="color: green;">Active</td>
                        <?php } else { ?>
                        <td style="color: red;">Inactive</td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="table-data-feature">
                                <button class="item" data-toggle="tooltip" data-placement="top" title="Edit Round">
                                    <i class="zmdi zmdi-edit"></i>
                                </button>
                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete Round">
                                    <i class="zmdi zmdi-delete"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-lg-6">
        <!-- DATA TABLE -->
        <div class="table-responsive">
            <table class="table table-data2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>judge id</th>
                        <th>judge name</th>
                        <th style="padding-right: 35px;">
                            <div class="table-data-feature">
                                <button class="item" data-toggle="tooltip" data-placement="top" title="Add Judge" style="background-color: #63c76a;">
                                    <i class="zmdi zmdi-plus" style="color: #FFF;"></i>
                                </button>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $query = mysqli_query($mysqli, "SELECT B.user_id, B.user_name FROM `tbl_rounds_judges` A INNER JOIN `tbl_users` B ON A.judge_id = B.user_id WHERE A.round_id = '$round_id'");

                    if (mysqli_num_rows($query) > 0) {
                        $num = 0;
                        while ($row = mysqli_fetch_array($query)) {
                            $num += 1;

                    ?>

                    <tr class="tr-shadow">
                        <td><?php echo ($num); ?></td>
                        <td><?php echo ($row['user_id']); ?></td>

                        <?php if ($row['user_name'] != "" && !empty($row['user_name'])) { ?>
                        <td><?php echo ($row['user_name']); ?></td>
                        <?php } else { ?>
                        <td><i>Unavailable</i></td>
                        <?php } ?>
                        
                        <td>
                            <div class="table-data-feature">
                                <button class="item" data-toggle="tooltip" data-placement="top" title="Remove Judge">
                                    <i class="zmdi zmdi-delete"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="spacer"></tr>

                    <?php }} else { ?>

                    <tr class="tr-shadow">
                        <td colspan="4" style="text-align: center;">No results found.</td>
                    </tr>

                    <?php } ?>

                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE -->
    </div>

</div>

<div class="row m-t-30">
    <div class="col-md-12">
        <!-- DATA TABLE-->
        <div class="table-responsive">
            <table class="table table-borderless table-data3">
                <thead>
                    <tr>
                        <th>name</th>
                        <th>judge</th>
                        <th>score 1</th>
                        <th>score 2</th>
                        <th>score 3</th>
                        <th>total score</th>
                    </tr>
                </thead>
                <tbody>

                    <!--------------------- SCHOOL 1 ------------------->

                    <?php

                    $query = mysqli_query($mysqli, "SELECT COUNT(*) AS `count` FROM ((SELECT F.school_id, E.student_id, B.student_name AS `name`, D.user_id, D.user_name, A.aspect1, A.aspect2, A.aspect3, A.total_score FROM tbl_student_scores A INNER JOIN tbl_students B USING (student_id) INNER JOIN tbl_rounds_judges C ON A.judge_id = C.judge_id INNER JOIN tbl_users D ON C.judge_id = D.user_id INNER JOIN tbl_students E ON A.student_id = E.student_id INNER JOIN tbl_schools F ON E.school_id = F.school_id WHERE A.round_id='$round_id') UNION (SELECT F.school_id, 'ZZZ' AS student_id, 'Overall' AS `name`, D.user_id, D.user_name, A.aspect1, A.aspect2, A.aspect3, A.total_score FROM tbl_school_overall_scores A INNER JOIN tbl_schools B USING (school_id) INNER JOIN tbl_rounds_judges C ON A.judge_id = C.judge_id INNER JOIN tbl_users D ON C.judge_id = D.user_id INNER JOIN tbl_schools F ON A.school_id = F.school_id WHERE A.round_id='$round_id')) S ORDER BY school_id, student_id, `user_id`");

                    $row = mysqli_fetch_array($query);
                    
                    if ($row['count'] > 0) { ?>

                    <?php

                    $query = mysqli_query($mysqli, "SELECT school_id, `name`, `user_id`, `user_name`, aspect1, aspect2, aspect3, total_score FROM ((SELECT F.school_id, E.student_id, B.student_name AS `name`, D.user_id, D.user_name, A.aspect1, A.aspect2, A.aspect3, A.total_score FROM tbl_student_scores A INNER JOIN tbl_students B USING (student_id) INNER JOIN tbl_rounds_judges C ON A.judge_id = C.judge_id INNER JOIN tbl_users D ON C.judge_id = D.user_id INNER JOIN tbl_students E ON A.student_id = E.student_id INNER JOIN tbl_schools F ON E.school_id = F.school_id WHERE A.round_id='$round_id' AND F.school_id = '$school_id_1') UNION (SELECT F.school_id, 'ZZZ' AS student_id, 'Overall' AS `name`, D.user_id, D.user_name, A.aspect1, A.aspect2, A.aspect3, A.total_score FROM tbl_school_overall_scores A INNER JOIN tbl_schools B USING (school_id) INNER JOIN tbl_rounds_judges C ON A.judge_id = C.judge_id INNER JOIN tbl_users D ON C.judge_id = D.user_id INNER JOIN tbl_schools F ON A.school_id = F.school_id WHERE A.round_id='$round_id' AND F.school_id = '$school_id_1')) S ORDER BY school_id, student_id, `user_id`");

                    if (mysqli_num_rows($query) > 0) {
                        $num = 0;

                    ?>

                    <tr class="tr-shadow">
                        <td colspan="6" style="color: blue; text-align: left; background-color: #f7f7f7;"><?php echo $school_name_1;?></td>
                    </tr>
                    
                    <?php while ($row = mysqli_fetch_array($query)) { ?>

                    <tr>
                        <td><?php echo $row['name'];?></td>
                        <td><?php echo $row['user_name'];?></td>
                        <td><?php echo $row['aspect1'];?></td>
                        <td><?php echo $row['aspect2'];?></td>
                        <td><?php echo $row['aspect3'];?></td>
                        <td><?php echo $row['total_score'];?></td>
                    </tr>

                    <?php } ?>
                    
                    <tr style="height: 5px; background: transparent;"></tr>
                
                    <?php } ?>

                    <!--------------------- END SCHOOL 1 ------------------->

                    <!--------------------- SCHOOL 2 ------------------->

                    <?php

                    $query = mysqli_query($mysqli, "SELECT school_id, `name`, `user_id`, `user_name`, aspect1, aspect2, aspect3, total_score FROM ((SELECT F.school_id, E.student_id, B.student_name AS `name`, D.user_id, D.user_name, A.aspect1, A.aspect2, A.aspect3, A.total_score FROM tbl_student_scores A INNER JOIN tbl_students B USING (student_id) INNER JOIN tbl_rounds_judges C ON A.judge_id = C.judge_id INNER JOIN tbl_users D ON C.judge_id = D.user_id INNER JOIN tbl_students E ON A.student_id = E.student_id INNER JOIN tbl_schools F ON E.school_id = F.school_id WHERE A.round_id='$round_id' AND F.school_id = '$school_id_2') UNION (SELECT F.school_id, 'ZZZ' AS student_id, 'overall' AS `name`, D.user_id, D.user_name, A.aspect1, A.aspect2, A.aspect3, A.total_score FROM tbl_school_overall_scores A INNER JOIN tbl_schools B USING (school_id) INNER JOIN tbl_rounds_judges C ON A.judge_id = C.judge_id INNER JOIN tbl_users D ON C.judge_id = D.user_id INNER JOIN tbl_schools F ON A.school_id = F.school_id WHERE A.round_id='$round_id' AND F.school_id = '$school_id_2')) S ORDER BY school_id, student_id, `user_id`");

                    if (mysqli_num_rows($query) > 0) {
                        $num = 0;

                    ?>

                    <tr class="tr-shadow">
                        <td colspan="6" style="color: blue; text-align: left; background-color: #f7f7f7;"><?php echo $school_name_2;?></td>
                    </tr>

                    <?php while ($row = mysqli_fetch_array($query)) { ?>

                    <tr>
                        <td><?php echo $row['name'];?></td>
                        <td><?php echo $row['user_name'];?></td>
                        <td><?php echo $row['aspect1'];?></td>
                        <td><?php echo $row['aspect2'];?></td>
                        <td><?php echo $row['aspect3'];?></td>
                        <td><?php echo $row['total_score'];?></td>
                    </tr>

                    <?php }} ?>

                    <!--------------------- END SCHOOL 2 ------------------->

                    <?php } else { ?>

                    <tr class="tr-shadow">
                        <td colspan="6" style="text-align: center;">No results found.</td>
                    </tr>

                    <?php } ?>

                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE-->
    </div>
</div>

<?php include_once 'footer.php'; ?>