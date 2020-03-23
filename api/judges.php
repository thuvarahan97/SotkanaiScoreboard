<?php include_once 'header.php'; ?>

<div class="row">
    <div class="col-md-12">
        <!-- DATA TABLE -->
        <h3 class="title-5 m-b-35">judges</h3>
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
                        <th>title</th>
                        <!-- <th>email</th> -->
                        <!-- <th>description</th> -->
                        <!-- <th>date</th> -->
                        <th>status</th>
                        <th>district</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $query = mysqli_query($mysqli, "SELECT * FROM `tbl_users`");
                
                    if (mysqli_num_rows($query) > 0) {
                        $num = 0;
                        while ($row = mysqli_fetch_array($query)) {
                            $num += 1;
                    ?>

                    <tr class="tr-shadow">
                        <td><?php echo ($num); ?></td>
                        <td><?php echo ($row['user_id']); ?></td>
                        <!-- <td>
                            <span class="block-email">lori@example.com</span>
                        </td> -->
                        <!-- <td class="desc">Samsung S8 Black</td> -->
                        <!-- <td>2018-09-27 02:12</td> -->
                        <td>
                            <span class="status--process">Processed</span>
                        </td>
                        <td><?php echo ($row['user_name']); ?></td>
                        <td>
                            <div class="table-data-feature">
                                <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="zmdi zmdi-edit"></i>
                                </button>
                                <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
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