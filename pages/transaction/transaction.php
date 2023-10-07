<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- /.card-header -->
                <div class="card">
                <div class="card-header">
                    <!-- <h3 class="card-title">DataTable with default features</h3> -->
                    <a href="index.php?menu=transaction_detail" class="btn btn-primary"><i class="fa fa-plus" style="margin-right: 5px;"></i> Tambah transaksi</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Transaksi</th>
                        <th>Tanggal</th>
                        <th>Total Item</th>
                        <th>Total Harga</th>
                        <th>Inputer</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "conf/connection.php";
                        
                        $no = 0;
                        $query = mysqli_query($connection, 
                        "SELECT
                            trx.`id`,
                            trx.`id_user`,
                            trx.`date`,
                            usr.`username` AS username,
                            trx.`created_at`,
                            trx.`updated_at`,
                            (
                                SELECT SUM(detail.`amount` * inv.`price`)
                                FROM `transaction_detail` detail
                                LEFT JOIN `inventory` inv ON detail.`id_inventory` = inv.`id`
                                WHERE detail.`id_transaction` = trx.`id`
                            ) AS total_price,
                            (
                                SELECT SUM(detail.`amount`)
                                FROM `transaction_detail` detail
                                WHERE detail.`id_transaction` = trx.`id`
                            ) AS total_item
                        FROM
                            `transaction` trx
                        LEFT JOIN `user` usr ON
                            trx.`id_user` = usr.`id`
                        ORDER BY
                            trx.`created_at` DESC;                    
                        ");
                        
                        while ($row = mysqli_fetch_assoc($query)) {
                        ?>

                        <tr>
                            <td><?php echo $no = $no + 1; ?></td>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['total_item']; ?></td>
                            <td><?php echo number_format($row['total_price'], 0, ',', '.'); ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td>
                                <!-- <a href="#" class="btn btn-primary" role="button" title="Lihat Detaiil" data-toggle="modal" data-target="#detail<?php echo $no; ?>"><i class="fas fa-eye"></i></a> -->
                                <button class="open-detail-modal" data-id-transaction="<?php echo $row['id']; ?>">Lihat Detail</button>

                                <!-- Modal detail -->
                                <div class="modal fade" id="detailModal" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail Transaksi</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body" style="overflow-x:auto;">
                                                <!-- Tempatkan tabel hasil query di sini -->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal detail -->

                            </td>
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
        </div>
    </div>
</section>