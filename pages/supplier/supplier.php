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
                    <th>Nama</th>
                    <th>Nomor Telfon</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    include "conf/connection.php";
                    
                    $no = 0;
                    $query = mysqli_query($connection, "SELECT * FROM supplier ORDER BY created_at DESC");
                    
                    while ($row = mysqli_fetch_assoc($query)) {
                    ?>

                    <tr>
                        <td><?php echo $no = $no + 1; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['phone_number']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td>
                            <a href="#" class="btn btn-success" role="button" title="Ubah Data" data-toggle="modal" data-target="#updatesupplier<?php echo $no; ?>"><i class="fas fa-edit"></i></a>
                            <a href="#" class="btn btn-danger" role="button" title="Hapus Data" data-toggle="modal" data-target="#deletesupplier<?php echo $no; ?>"><i class="fas fa-trash"></i></a>

                            <!-- modal delete -->
                            <div class="modal fade" id="deletesupplier<?php echo $no; ?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Confirmation</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h5 align="center">Apakah anda yakin ingin menghapus supplier <?php echo $row['name']; ?>?</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="nodelete" type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                                            <a href="pages/supplier/function_supplier.php?act=delete&id=<?= $row['id']; ?>" class="btn btn-primary">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- modal delete -->

                            <!-- model edit -->
                            <div class="modal fade" id="updatesupplier<?php echo $no; ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Update Supplier</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" method="post" action="pages/supplier/function_supplier.php?act=update&id=<?= $row['id']; ?>">
                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="Masukan nama supplier" value="<?php echo $row['name']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                <label>Nomor Telfon</label>
                                                    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Masukan nomor telfon : 0857708282" value="<?php echo $row['phone_number']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" placeholder="Masukan email" value="<?php echo $row['email']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Alamat</label>
                                                    <textarea class="form-control" rows="3" id="address" name="address" placeholder="Masukan alamat" required><?php echo $row['address']; ?></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                            </div>
                            <!-- model edit -->
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
    <!-- /.container-fluid -->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" method="post" action="pages/supplier/function_supplier.php?act=add">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukan nama supplier" required>
                        </div>
                        <div class="form-group">
                            <label>Nomor Telfon</label>
                            <input type="text" pattern="^\d{10,12}$" class="form-control" id="phone_number" name="phone_number" placeholder="Masukan nomor telfon : 0857708282" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Masukan email" required>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" rows="3" id="address" name="address" placeholder="Masukan alamat" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
</section>
