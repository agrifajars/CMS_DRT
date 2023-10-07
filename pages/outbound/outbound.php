<section class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-12">
            <!-- /.card-header -->
            <div class="card">
            <div class="card-header">
                <!-- <h3 class="card-title">DataTable with default features</h3> -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus" style="margin-right: 5px;"></i> Tambah data</button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>ID Transaksi</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Inputer</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    include "conf/connection.php";
                    
                    $no = 0;
                    $query = mysqli_query($connection, 
                    // "SELECT * FROM transaction_detail ORDER BY created_at DESC
                    // "
                    "SELECT
                            trd.`id`,
                            trd.`id_transaction`,
                            trd.`id_inventory`,
                            trd.`id_user`,
                            trd.`amount`,
                            trx.`date`,
                            usr.`username` AS username,
                            inv.`name`,
                            inv.`price`,
                            trd.`created_at`,
                            trd.`updated_at`
                        FROM
                            `transaction_detail` trd
                        LEFT JOIN `transaction` trx ON
                            trd.`id_transaction` = trx.`id`
                        LEFT JOIN `user` usr ON
                            trd.`id_user` = usr.`id`
                        LEFT JOIN `inventory` inv ON
                            trd.`id_inventory` = inv.`id`
                        ORDER BY
                            trd.`created_at` DESC;");
                    
                    while ($row = mysqli_fetch_assoc($query)) {
                    ?>

                    <tr>
                        <td><?php echo $no = $no + 1; ?></td>
                        <td><?php echo $row['id_transaction']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php echo number_format($row['price'] * $row['amount'], 0, ',', '.'); ?></td>
                        <td><?php echo $row['username']; ?></td>
                    </tr>

                    <?php } ?>
                </tbody>

                
                </table>
            </div>
            <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah kategori baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" method="post" action="pages/category/function_category.php?act=add">
                        <div class="form-group">
                            <label>Kategori Barang</label>
                            <input type="text" class="form-control" id="category" name="category" placeholder="Masukan kategori barang" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
</section>
