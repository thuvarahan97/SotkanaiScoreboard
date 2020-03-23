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
                                <button class="item" data-toggle="tooltip" data-placement="top" title="Add Competition" style="background-color: #63c76a;">
                                    <i class="zmdi zmdi-plus" style="color: #FFF;"></i>
                                </button>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $query = mysqli_query($mysqli, "SELECT A.*, B.district_name, GROUP_CONCAT(C.round_id ORDER BY C.round_id ASC) AS round_ids, GROUP_CONCAT(C.round_name ORDER BY C.round_id ASC) AS round_names, GROUP_CONCAT(C.round_status ORDER BY C.round_id ASC) AS round_status FROM `tbl_competitions` A LEFT OUTER JOIN `tbl_districts` B USING (district_id) INNER JOIN `tbl_rounds` C USING (competition_id) GROUP BY A.competition_id ORDER BY A.competition_id ASC");
                
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
                            <table class="table">
                                <tbody>
                                    <?php for ($x = 0; $x < sizeof($round_names); $x++) { ?>
                                    <tr>
                                        <td><?php echo ($x + 1); ?></td>
                                        <td><a href="round.php?round_id=<?php echo $round_ids[$x]; ?>"><?php echo ($round_names[$x]); ?></a></td>
                                        <td>
                                            <div class="table-data-feature">
                                                <label class="switch switch-3d switch-success mr-2" style="vertical-align: middle;">
                                                    <input type="checkbox" class="switch-input" 
                                                        <?php if ($round_status[$x] == '0') { ?>
                                                            
                                                        <?php } elseif ($round_status[$x] == '1') { ?>
                                                            checked="true"
                                                        <?php } ?>
                                                    >
                                                    <span class="switch-label"></span>
                                                    <span class="switch-handle"></span>
                                                </label>
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Edit Round">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </button>
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete Round">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <div class="table-data-feature">
                                <button class="item" data-toggle="tooltip" data-placement="top" title="Add Round">
                                    <i class="zmdi zmdi-plus"></i>
                                </button>
                                <button class="item" data-toggle="tooltip" data-placement="top" title="Edit Competition">
                                    <i class="zmdi zmdi-edit"></i>
                                </button>
                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete Competition">
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