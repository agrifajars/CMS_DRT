<?php
    session_start();
    function generateUuidV4() {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0F | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3F | 0x80);
    
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    if ($_SESSION['id_transaction'] == null || $_SESSION['id_transaction'] == "")
        $_SESSION['id_transaction'] = generateUuidV4();

    $id_transaction = $_SESSION['id_transaction'];
    $res = mysqli_query($connection, "SELECT * FROM transaction_detail WHERE id_transaction = '$id_transaction'");
    $class = $res->num_rows > 0 ? 'margin-left: 5px' : 'margin-left: 5px; display: none';
?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-12">
            <!-- /.card-header -->
            <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus" style="margin-right: 5px;"></i> Tambah item</button>
                <a href="" class="btn btn-success" style="<?php echo $class?>" data-toggle="modal" data-target="#confirmation"><i class="fa fa-check" style="margin-right: 5px;"></i> Proses</a>
                <a href="" class="btn btn-danger float-right" style="margin-left: 5px;" data-toggle="modal" data-target="#delete"><i class="fa fa-times" style="margin-right: 5px;"></i> Batalkan</a>

                <!-- modal confirmation -->
                <div class="modal fade" id="confirmation" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirmation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h5 align="center">Apakah pesanannya sudah selesai? <br> Pastikan sebelum melanjutkan.</h5>
                            </div>
                            <div class="modal-footer">
                                <button id="nodelete" type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                                <a href="pages/transaction/function_transaction.php?act=save_session&id_transaction=<?= $_SESSION['id_transaction']; ?>" class="btn btn-primary">Yes</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal confirmation -->

                <!-- modal delete -->
                <div class="modal fade" id="delete" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirmation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h5 align="center">Apakah anda yakin pesanan akan dibatalkan?</h5>
                            </div>
                            <div class="modal-footer">
                                <button id="nodelete" type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                                <a href="pages/transaction/function_transaction.php?act=delete_session&id_transaction=<?= $_SESSION['id_transaction']; ?>" class="btn btn-primary">Yes</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal delte -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="datatable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    include "conf/connection.php";
                    
                    $no = 0;
                    $query = mysqli_query($connection, 
                        "SELECT
                            trd.`id`,
                            trd.`id_transaction`,
                            trd.`id_inventory`,
                            trd.`amount`,
                            inv.`name`,
                            inv.`price`,
                            cat.`category`
                        FROM
                            `transaction_detail` trd
                        LEFT JOIN `inventory` inv ON
                            trd.`id_inventory` = inv.`id`
                        LEFT JOIN `category` cat ON
                            cat.`id` = inv.`id_category`
                        WHERE trd.`id_transaction` = '" . $_SESSION['id_transaction'] . "'
                        ORDER BY
                            trd.`created_at` DESC;"
                    );
                    
                    while ($row = mysqli_fetch_assoc($query)) {
                    ?>

                    <tr>
                        <td><?php echo $no = $no + 1; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php echo number_format($row['price'], 0, ',', '.'); ?></td>
                        <td><?php echo number_format($row['price'] * $row['amount'], 0, ',', '.'); ?></td>
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
                    <h5 class="modal-title">Tambah item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" method="post" action="pages/transaction/function_transaction.php?act=add&id_transaction=<?= $_SESSION['id_transaction']; ?>">
                        <div class="form-group">
                            <label>Stock - Nama Barang</label>
                            <select id="search_inventory" name="id_inventory" class="form-control" required></select>
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" name="amount" class="form-control" min="0" maxlength="3" oninput="if (this.value.length > 3) this.value = '999';" required/>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
</section>