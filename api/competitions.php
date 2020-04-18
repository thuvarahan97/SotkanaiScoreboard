<?php include_once 'header.php'; ?>

<div class="row">
    <div class="col-md-12">
        <!-- DATA TABLE -->
        <h3 class="title-5 m-b-35">Competitions & Rounds</h3>
        <div class="table-responsive table-responsive-data2">
            <table class="table table-data2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>title</th>
                        <!-- <th>email</th> -->
                        <!-- <th>description</th> -->
                        <!-- <th>date</th> -->
                        <!-- <th>status</th> -->
                        <th>district</th>
                        <th>rounds</th>
                        <th style="padding-right: 35px;">
                            <div class="table-data-feature">
                                <a class="item" href="add.competition.php" data-toggle="tooltip" data-placement="top" title="Add Competition" style="background-color: #63c76a;">
                                    <i class="zmdi zmdi-plus" style="color: #FFF;"></i>
                                </a>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $query = mysqli_query($mysqli, "SELECT A.*, B.district_name, GROUP_CONCAT(C.round_id ORDER BY C.round_id ASC) AS round_ids, GROUP_CONCAT(C.round_name ORDER BY C.round_id ASC) AS round_names, GROUP_CONCAT(C.round_status ORDER BY C.round_id ASC) AS round_status FROM `tbl_competitions` A LEFT OUTER JOIN `tbl_districts` B USING (district_id) LEFT OUTER JOIN `tbl_rounds` C USING (competition_id) GROUP BY A.competition_id ORDER BY A.competition_id ASC");
                
                    if (mysqli_num_rows($query) > 0) {
                        $num = 0;
                        while ($row = mysqli_fetch_array($query)) {
                            $num += 1;
                            $round_ids = explode(',', $row['round_ids']);
                            $round_names = explode (",", $row['round_names']);
                            $round_status = array_map('intval', explode (",", $row['round_status']));
                    ?>

                    <tr class="tr-shadow">
                        <td><?php echo ($num); ?></td>
                        <td><?php echo ($row['competition_name']); ?></td>
                        <!-- <td>
                            <span class="block-email">lori@example.com</span>
                        </td> -->
                        <!-- <td class="desc">Samsung S8 Black</td> -->
                        <!-- <td>2018-09-27 02:12</td> -->
                        <!-- <td>
                            <span class="status--process">Processed</span>
                        </td> -->
                        <td><?php echo ($row['district_name']); ?></td>
                        <td class="round-content">
                            <?php if ($round_ids[0]!= '') { ?>
                            <table class="table">
                                <tbody>
                                    <?php for ($x = 0; $x < sizeof($round_names); $x++) { ?>
                                    <tr>
                                        <td><?php echo ($x + 1); ?></td>
                                        <td><a href="round.php?round_id=<?php echo $round_ids[$x]; ?>"><?php echo ($round_names[$x]); ?></a></td>
                                        <td class="text-right"
                                            <?php if ($round_status[$x] == '1') {
                                                echo 'style="color: green;">Active';
                                            } elseif ($round_status[$x] == '0') {
                                                echo 'style="color: red;">Inactive';
                                            } ?>
                                        </td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a class="item" data-toggle="tooltip" data-placement="top" title="Edit Round" href="edit.round.php?id=<?php echo $round_ids[$x];?>">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </a>
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete Round" round_id="<?php echo $round_ids[$x];?>" id="delete_round">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php } else { echo "None"; } ?>
                        </td>
                        <td>
                            <div class="table-data-feature">
                                <a class="item" data-toggle="tooltip" data-placement="top" title="Add Round" href="add.round.php?id=<?php echo $row['competition_id'];?>&name=<?php echo $row['competition_name'];?>">
                                    <i class="zmdi zmdi-plus"></i>
                                </a>
                                <a class="item" data-toggle="tooltip" data-placement="top" title="Edit Competition" href="edit.competition.php?id=<?php echo $row['competition_id'];?>">
                                    <i class="zmdi zmdi-edit"></i>
                                </a>
                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete Competition" competition_id="<?php echo $row['competition_id'];?>" id="delete_competition">
                                    <i class="zmdi zmdi-delete"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="spacer"></tr>

                    <?php }} ?>

                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE -->
    </div>
</div>

<?php include_once 'footer.php'; ?>

<script>
    $(document).on("click","#delete_competition",function(){
        const competition_id = $(this).attr("competition_id");

        if (confirm("Do you want to delete this competition?")) {
            $.ajax({
                url:"delete.competition.php",
                type:"post",
                data:{id:competition_id},
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

    $(document).on("click","#delete_round",function(){
        const round_id = $(this).attr("round_id");

        if (confirm("Do you want to delete this round?")) {
            $.ajax({
                url:"delete.round.php",
                type:"post",
                data:{id:round_id},
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