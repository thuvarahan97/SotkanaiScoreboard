<?php include_once 'header.php'; ?>

<div class="row">
    <div class="col-md-12">
        <!-- DATA TABLE -->
        <h3 class="title-5 m-b-35">judges</h3>
        <div class="table-responsive table-responsive-data2">
            <table class="table table-data2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>judge id</th>
                        <!-- <th>email</th> -->
                        <!-- <th>description</th> -->
                        <!-- <th>date</th> -->
                        <!-- <th>status</th> -->
                        <th>judge name</th>
                        <th style="padding-right: 35px;">
                            <div class="table-data-feature">
                                <a href="add.judge.php" class="item" data-toggle="tooltip" data-placement="top" title="Add Judge" style="background-color: #63c76a;">
                                    <i class="zmdi zmdi-plus" style="color: #FFF;"></i>
                                </a>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $query = mysqli_query($mysqli, "SELECT * FROM `tbl_judges`");
                
                    if (mysqli_num_rows($query) > 0) {
                        $num = 0;
                        while ($row = mysqli_fetch_array($query)) {
                            $num += 1;
                    ?>

                    <tr class="tr-shadow">
                        <td><?php echo ($num); ?></td>
                        <td><?php echo ($row['judge_id']); ?></td>
                        <!-- <td>
                            <span class="block-email">lori@example.com</span>
                        </td> -->
                        <!-- <td class="desc">Samsung S8 Black</td> -->
                        <!-- <td>2018-09-27 02:12</td> -->
                        <!-- <td>
                            <span class="status--process">Processed</span>
                        </td> -->
                        <?php if ($row['judge_name'] != "" && !empty($row['judge_name'])) { ?>
                        <td><?php echo ($row['judge_name']);?></td>
                        <?php } else { ?>
                        <td><i>Unavailable</i></td>
                        <?php } ?>
                        <td>
                            <div class="table-data-feature">
                                <a class="item" data-toggle="tooltip" data-placement="top" title="Edit Judge" href="edit.judge.php?id=<?php echo urlencode($row['judge_id']);?>">
                                    <i class="zmdi zmdi-edit"></i>
                                </a>
                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete Judge" judge_id="<?php echo $row['judge_id'];?>" id="delete_judge">
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
    $(document).on("click","#delete_judge",function(){
        const judge_id = $(this).attr("judge_id");

        if (confirm("Do you want to delete this judge?")) {
            $.ajax({
                url:"delete.judge.php",
                type:"post",
                data:{id:judge_id},
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