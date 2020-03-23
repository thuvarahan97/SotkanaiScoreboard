<?php include_once 'header.php'; ?>

<div class="row">
    <div class="col-md-12">
        <!-- DATA TABLE -->
        <h3 class="title-5 m-b-35">Schools & Students</h3>
        <div class="table-data__tool">
            <div class="table-data__tool-right">
                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                    <i class="zmdi zmdi-plus"></i>add item</button>
            </div>
        </div>
        <div class="table-responsive table-responsive-data2">
            <table class="table table-data2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>school</th>
                        <!-- <th>email</th> -->
                        <!-- <th>description</th> -->
                        <!-- <th>date</th> -->
                        <!-- <th>status</th> -->
                        <th>district</th>
                        <th>students</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $query = mysqli_query($mysqli, "SELECT A.*, B.district_name, GROUP_CONCAT(C.student_id ORDER BY C.student_id ASC) AS student_ids, GROUP_CONCAT(C.student_name ORDER BY C.student_id ASC) AS student_names FROM `tbl_schools` A LEFT OUTER JOIN `tbl_districts` B USING (district_id) INNER JOIN `tbl_students` C USING (school_id) GROUP BY A.school_id ORDER BY A.school_id ASC");
                
                    if (mysqli_num_rows($query) > 0) {
                        $num = 0;
                        while ($row = mysqli_fetch_array($query)) {
                            $num += 1;
                            $student_ids = explode(",", $row['student_ids']);
                            $student_names = explode (",", $row['student_names']);
                    ?>

                    <tr class="tr-shadow">
                        <td><?php echo ($num); ?></td>
                        <td><?php echo ($row['school_name']); ?></td>
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
                                    <?php for ($x = 0; $x < sizeof($student_names); $x++) { ?>
                                    <tr>
                                        <td><?php echo ($x + 1); ?></td>
                                        <td><?php echo ($student_names[$x]); ?></td>
                                        <td>
                                            <div class="table-data-feature">
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Edit Student">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </button>
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete Student">
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
                                <button class="item" data-toggle="tooltip" data-placement="top" title="Add Student">
                                    <i class="zmdi zmdi-plus"></i>
                                </button>
                                <button class="item" data-toggle="tooltip" data-placement="top" title="Edit School">
                                    <i class="zmdi zmdi-edit"></i>
                                </button>
                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete School">
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