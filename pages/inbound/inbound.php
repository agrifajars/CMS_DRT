<section class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-12">
            <!-- /.card-header -->
            <div class="card">
            <div class="card-header">
                <!-- <h3 class="card-title">DataTable with default features</h3> -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah data</button>
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
                    <th>Pemasok</th>
                    <th>Inputer</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    include "conf/connection.php";
                    
                    $no = 0;
                    $query = mysqli_query($connection, 
                        "SELECT
                            inb.`id`,
                            inb.`amount`,
                            supp.`id` AS supplier_id,
                            supp.`name` AS supplier_name,
                            inv.`id` AS inventory_id,
                            inv.`name` AS inventory_name,
                            inv.`id_category`,
                            cat.`category`,
                            inv.`stock`,
                            usr.`id` AS user_id,
                            usr.`username` AS username,
                            inv.`created_at`,
                            inv.`updated_at`
                        FROM
                            `inbound` inb
                        LEFT JOIN `inventory` inv ON
                            inb.`id_inventory` = inv.`id`
                        LEFT JOIN `category` cat ON
                            inv.`id_category` = cat.`id`
                        LEFT JOIN `supplier` supp ON
                            inb.`id_supplier` = supp.`id`
                        LEFT JOIN `user` usr ON
                            inb.`id_user` = usr.`id`
                        ORDER BY
                            inb.`created_at` DESC;
                        "
                    );
                    
                    while ($row = mysqli_fetch_assoc($query)) {
                    ?>

                    <tr>
                        <td><?php echo $no = $no + 1; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['inventory_name']; ?></td>
                        <td><?php echo number_format($row['amount'], 0, ',', '.'); ?></td>
                        <td><?php echo $row['supplier_name']; ?></td>
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
                    <h5 class="modal-title">Tambah data barang masuk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" method="post" action="pages/inbound/function_inbound.php?act=add">
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <select id="search_inventory" name="id_inventory" class="form-control" required></select>
                        </div>
                        <div class="form-group">
                            <label>Nama Supplier</label>
                            <select id="search_supplier" name="id_supplier" class="form-control" required></select>
                        </div>
                        <div class="form-group">
                            <label>Waktu & Tanggal Barang Datang</label>
                            <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                <input type="text" name="date" class="form-control datetimepicker-input" data-target="#reservationdatetime" required/>
                                <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
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