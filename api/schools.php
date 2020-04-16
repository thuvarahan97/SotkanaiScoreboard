<?php include_once 'header.php'; ?>

<div class="row">
    <div class="col-md-12">
        <!-- DATA TABLE -->
        <h3 class="title-5 m-b-35">Schools & Students</h3>
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
                        <th style="padding-right: 35px;">
                            <div class="table-data-feature">
                                <a class="item" href="add.school.php" data-toggle="tooltip" data-placement="top" title="Add School" style="background-color: #63c76a;">
                                    <i class="zmdi zmdi-plus" style="color: #FFF;"></i>
                                </a>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $query = mysqli_query($mysqli, "SELECT A.*, B.district_name, GROUP_CONCAT(C.student_id ORDER BY C.student_id ASC) AS student_ids, GROUP_CONCAT(C.student_name ORDER BY C.student_id ASC) AS student_names FROM `tbl_schools` A LEFT OUTER JOIN `tbl_districts` B USING (district_id) LEFT OUTER JOIN `tbl_students` C USING (school_id) GROUP BY A.school_id ORDER BY A.school_id ASC");
                
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
                            <?php if ($student_ids[0]!= '') { ?>
                            <table class="table">
                                <tbody>
                                    <?php for ($x = 0; $x < sizeof($student_names); $x++) { ?>
                                    <tr>
                                        <td><?php echo ($x + 1); ?></td>
                                        <td><?php echo ($student_names[$x]); ?></td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a class="item" data-toggle="tooltip" data-placement="top" title="Edit Student" href="edit.student.php?id=<?php echo $student_ids[$x];?>">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </a>
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete Student" student_id="<?php echo $student_ids[$x];?>" id="delete_student">
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
                                <a class="item" data-toggle="tooltip" data-placement="top" title="Add Student" href="add.student.php?id=<?php echo $row['school_id'];?>&name=<?php echo $row['school_name'];?>">
                                    <i class="zmdi zmdi-plus"></i>
                                </a>
                                <a class="item" data-toggle="tooltip" data-placement="top" title="Edit School" href="edit.school.php?id=<?php echo $row['school_id'];?>">
                                    <i class="zmdi zmdi-edit"></i>
                                </a>
                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete School" school_id="<?php echo $row['school_id'];?>" id="delete_school">
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
    $(document).on("click","#delete_school",function(){
        const school_id = $(this).attr("school_id");

        if (confirm("Do you want to delete this school?")) {
            $.ajax({
                url:"delete.school.php",
                type:"post",
                data:{id:school_id},
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

    $(document).on("click","#delete_student",function(){
        const student_id = $(this).attr("student_id");

        if (confirm("Do you want to delete this student?")) {
            $.ajax({
                url:"delete.student.php",
                type:"post",
                data:{id:student_id},
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