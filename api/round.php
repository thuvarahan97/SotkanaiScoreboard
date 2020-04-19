<?php include_once 'header.php'; ?>

<?php

if (isset($_GET['round_id']) && !empty($_GET['round_id'])) {
    $round_id = $_GET['round_id'];

    $query = mysqli_query($mysqli, "SELECT A.*, E.competition_id, E.competition_name, F.district_id, F.district_name, B.school_id_1, B.school_id_2, C.school_name AS school_name_1, D.school_name AS school_name_2 FROM tbl_rounds A LEFT OUTER JOIN tbl_rounds_schools B USING (round_id) LEFT OUTER JOIN tbl_schools C ON B.school_id_1 = C.school_id LEFT OUTER JOIN tbl_schools D ON B.school_id_2 = D.school_id INNER JOIN tbl_competitions E ON A.competition_id = E.competition_id LEFT OUTER JOIN tbl_districts F ON E.district_id = F.district_id WHERE round_id = '$round_id'");

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
                        <?php if ($row['round_status'] == '1') { ?>
                        <td style="color: green;">Active</td>
                        <?php } elseif ($row['round_status'] == '0') { ?>
                        <td style="color: red;">Inactive</td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="table-data-feature">
                                <a class="item" data-toggle="tooltip" data-placement="top" title="Edit Round" href="edit.round.php?id=<?php echo $round_id;?>&page=round">
                                    <i class="zmdi zmdi-edit"></i>
                                </a>
                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete Round" round_id="<?php echo $round_id;?>" id="delete_round">
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
                                <a class="item" data-toggle="tooltip" data-placement="top" title="Add Judge" style="background-color: #63c76a;" href="add.round.judge.php?id=<?php echo $round_id;?>&name=<?php echo $row['round_name'];?>">
                                    <i class="zmdi zmdi-plus" style="color: #FFF;"></i>
                                </a>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $query = mysqli_query($mysqli, "SELECT B.judge_id, B.judge_name FROM `tbl_rounds_judges` A INNER JOIN `tbl_judges` B ON A.judge_id = B.judge_id WHERE A.round_id = '$round_id'");

                    if (mysqli_num_rows($query) > 0) {
                        $num = 0;
                        while ($row = mysqli_fetch_array($query)) {
                            $num += 1;

                    ?>

                    <tr class="tr-shadow">
                        <td><?php echo ($num); ?></td>
                        <td><?php echo ($row['judge_id']); ?></td>

                        <?php if ($row['judge_name'] != "" && !empty($row['judge_name'])) { ?>
                        <td><?php echo ($row['judge_name']); ?></td>
                        <?php } else { ?>
                        <td><i>Unavailable</i></td>
                        <?php } ?>
                        
                        <td>
                            <div class="table-data-feature">
                                <button class="item" data-toggle="tooltip" data-placement="top" title="Remove Judge" judge_id="<?php echo $row['judge_id'];?>" id="remove_judge">
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
            <table class="table table-borderless table-data3 scores-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>மாணவர் பெயர்</th>
                        <th>நடுவர்</th>
                        <th>பொருள்</th>
                        <th>சமயோசிதம்</th>
                        <th>அழகியல்</th>
                        <th>தொனி</th>
                        <th>நிலை</th>
                        <th>மொழிவளம்</th>
                        <th>மொத்தப் புள்ளிகள்</th>
                    </tr>
                </thead>
                <tbody>

                    <!--------------------- SCHOOL 1 ------------------->

                    <?php

                    $query = mysqli_query($mysqli, "SELECT COUNT(*) AS `count` FROM ((SELECT F.school_id, E.student_id, B.student_name AS `name`, D.judge_id, D.judge_name, A.score_1, A.score_2, A.score_3, A.score_4, A.score_5, A.score_6, A.total_score FROM tbl_student_scores A INNER JOIN tbl_students B USING (student_id) INNER JOIN tbl_rounds_judges C ON A.judge_id = C.judge_id INNER JOIN tbl_judges D ON C.judge_id = D.judge_id INNER JOIN tbl_students E ON A.student_id = E.student_id INNER JOIN tbl_schools F ON E.school_id = F.school_id WHERE A.round_id='$round_id') UNION (SELECT F.school_id, 'ZZZ' AS student_id, 'Overall' AS `name`, D.judge_id, D.judge_name, A.score_1, A.score_2, A.score_3, A.score_4, A.score_5, A.score_6, A.total_score FROM tbl_school_overall_scores A INNER JOIN tbl_schools B USING (school_id) INNER JOIN tbl_rounds_judges C ON A.judge_id = C.judge_id INNER JOIN tbl_judges D ON C.judge_id = D.judge_id INNER JOIN tbl_schools F ON A.school_id = F.school_id WHERE A.round_id='$round_id')) S ORDER BY school_id, student_id, `judge_id`");

                    $row = mysqli_fetch_array($query);
                    
                    if ($row['count'] > 0) { ?>

                    <?php

                    $query = mysqli_query($mysqli, "SELECT school_id, `name`, `judge_id`, `judge_name`, score_1, score_2, score_3, score_4, score_5, score_6, total_score FROM ((SELECT F.school_id, E.student_id, B.student_name AS `name`, D.judge_id, D.judge_name, A.score_1, A.score_2, A.score_3, A.score_4, A.score_5, A.score_6, A.total_score FROM tbl_student_scores A INNER JOIN tbl_students B USING (student_id) INNER JOIN tbl_rounds_judges C ON A.judge_id = C.judge_id INNER JOIN tbl_judges D ON C.judge_id = D.judge_id INNER JOIN tbl_students E ON A.student_id = E.student_id INNER JOIN tbl_schools F ON E.school_id = F.school_id WHERE A.round_id='$round_id' AND F.school_id = '$school_id_1') UNION (SELECT F.school_id, 'ZZZ' AS student_id, 'Overall' AS `name`, D.judge_id, D.judge_name, A.score_1, A.score_2, A.score_3, A.score_4, A.score_5, A.score_6, A.total_score FROM tbl_school_overall_scores A INNER JOIN tbl_schools B USING (school_id) INNER JOIN tbl_rounds_judges C ON A.judge_id = C.judge_id INNER JOIN tbl_judges D ON C.judge_id = D.judge_id INNER JOIN tbl_schools F ON A.school_id = F.school_id WHERE A.round_id='$round_id' AND F.school_id = '$school_id_1')) S ORDER BY school_id, student_id, `judge_id`");

                    if (mysqli_num_rows($query) > 0) {
                        $num = 0;
                        $total_scores = 0;
                        $scores_array = array();
                        while ($row = mysqli_fetch_array($query)) {
                            $data = array(
                                'name' => $row['name'],
                                'judge_id' => $row['judge_id'],
                                'judge_name' => $row['judge_name'],
                                'score_1' => $row['score_1'],
                                'score_2' => $row['score_2'],
                                'score_3' => $row['score_3'],
                                'score_4' => $row['score_4'],
                                'score_5' => $row['score_5'],
                                'score_6' => $row['score_6'],
                                'total_score' => $row['total_score']
                            );
                            array_push($scores_array, $data);
                            $total_scores += $row['total_score'];
                        }
                        
                    ?>

                    <tr class="tr-shadow">
                        <td colspan="9" style="color: blue; text-align: left; background-color: #f7f7f7;"><?php echo $school_name_1;?></td>
                        <td class="text-right" style="color: green; text-align: left; background-color: #f7f7f7; font-weight: bold;"><?php echo $total_scores;?></td>
                    </tr>
                    
                    <?php foreach($scores_array as $row){ $num += 1; ?>

                    <tr>
                        <td><?php echo $num;?></td>
                        <td><?php echo $row['name'];?></td>
                        <td title="<?php echo $row['judge_name'];?>"><?php echo $row['judge_id'];?></td>
                        <td><?php echo $row['score_1'];?></td>
                        <td><?php echo $row['score_2'];?></td>
                        <td><?php echo $row['score_3'];?></td>
                        <td><?php echo $row['score_4'];?></td>
                        <td><?php echo $row['score_5'];?></td>
                        <td><?php echo $row['score_6'];?></td>
                        <td><?php echo $row['total_score'];?></td>
                    </tr>

                    <?php } ?>
                    
                    <tr style="height: 5px; background: transparent;"></tr>
                
                    <?php } ?>

                    <!--------------------- END SCHOOL 1 ------------------->

                    <!--------------------- SCHOOL 2 ------------------->

                    <?php

                    $query = mysqli_query($mysqli, "SELECT school_id, `name`, `judge_id`, `judge_name`, score_1, score_2, score_3, score_4, score_5, score_6, total_score FROM ((SELECT F.school_id, E.student_id, B.student_name AS `name`, D.judge_id, D.judge_name, A.score_1, A.score_2, A.score_3, A.score_4, A.score_5, A.score_6, A.total_score FROM tbl_student_scores A INNER JOIN tbl_students B USING (student_id) INNER JOIN tbl_rounds_judges C ON A.judge_id = C.judge_id INNER JOIN tbl_judges D ON C.judge_id = D.judge_id INNER JOIN tbl_students E ON A.student_id = E.student_id INNER JOIN tbl_schools F ON E.school_id = F.school_id WHERE A.round_id='$round_id' AND F.school_id = '$school_id_2') UNION (SELECT F.school_id, 'ZZZ' AS student_id, 'Overall' AS `name`, D.judge_id, D.judge_name, A.score_1, A.score_2, A.score_3, A.score_4, A.score_5, A.score_6, A.total_score FROM tbl_school_overall_scores A INNER JOIN tbl_schools B USING (school_id) INNER JOIN tbl_rounds_judges C ON A.judge_id = C.judge_id INNER JOIN tbl_judges D ON C.judge_id = D.judge_id INNER JOIN tbl_schools F ON A.school_id = F.school_id WHERE A.round_id='$round_id' AND F.school_id = '$school_id_2')) S ORDER BY school_id, student_id, `judge_id`");

                    if (mysqli_num_rows($query) > 0) {
                        $num = 0;
                        $total_scores = 0;
                        $scores_array = array();
                        while ($row = mysqli_fetch_array($query)) {
                            $data = array(
                                'name' => $row['name'],
                                'judge_id' => $row['judge_id'],
                                'judge_name' => $row['judge_name'],
                                'score_1' => $row['score_1'],
                                'score_2' => $row['score_2'],
                                'score_3' => $row['score_3'],
                                'score_4' => $row['score_4'],
                                'score_5' => $row['score_5'],
                                'score_6' => $row['score_6'],
                                'total_score' => $row['total_score']
                            );
                            array_push($scores_array, $data);
                            $total_scores += $row['total_score'];
                        }
                    ?>

                    <tr class="tr-shadow">
                        <td colspan="9" style="color: blue; text-align: left; background-color: #f7f7f7;"><?php echo $school_name_2;?></td>
                        <td class="text-right" style="color: green; text-align: left; background-color: #f7f7f7; font-weight: bold;"><?php echo $total_scores;?></td>
                    </tr>
                    
                    <?php foreach($scores_array as $row){ $num += 1; ?>

                    <tr>
                        <td><?php echo $num;?></td>
                        <td><?php echo $row['name'];?></td>
                        <td title="<?php echo $row['judge_name'];?>"><?php echo $row['judge_id'];?></td>
                        <td><?php echo $row['score_1'];?></td>
                        <td><?php echo $row['score_2'];?></td>
                        <td><?php echo $row['score_3'];?></td>
                        <td><?php echo $row['score_4'];?></td>
                        <td><?php echo $row['score_5'];?></td>
                        <td><?php echo $row['score_6'];?></td>
                        <td><?php echo $row['total_score'];?></td>
                    </tr>

                    <?php }} ?>

                    <!--------------------- END SCHOOL 2 ------------------->

                    <?php } else { ?>

                    <tr class="tr-shadow">
                        <td colspan="10" style="text-align: center;">No results found.</td>
                    </tr>

                    <?php } ?>

                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE-->
    </div>
</div>

<?php include_once 'footer.php'; ?>

<script>
    $(document).on("click","#delete_round",function(){
        const round_id = $(this).attr("round_id");

        if (confirm("Do you want to delete this round?")) {
            $.ajax({
                url:"delete.round.php",
                type:"post",
                data:{id:round_id},
                success:function(output){
                    if (output) {
                        location.replace('competitions.php');
                    }
                    else {
                        alert("Process failed.");
                    }
                }
            });
        }
    });
    
    $(document).on("click","#remove_judge",function(){
        const round_id = <?php echo $round_id;?>;
        const judge_id = $(this).attr("judge_id");

        if (confirm("Do you want to remove this judge?")) {
            $.ajax({
                url:"delete.round.judge.php",
                type:"post",
                data:{round_id: round_id, judge_id: judge_id},
                success:function(output){
                    if (output) {
                        location.reload();
                    }
                    else {
                        alert("Process failed.");
                    }
                }
            });
        }
    });
</script>