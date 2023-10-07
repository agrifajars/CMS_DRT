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
                <table id="datatable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    include "conf/connection.php";
                    
                    $no = 0;
                    $query = mysqli_query($connection, "SELECT * FROM category ORDER BY created_at DESC");
                    
                    while ($row = mysqli_fetch_assoc($query)) {
                    ?>

                    <tr>
                        <td><?php echo $no = $no + 1; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td>
                            <a href="#" class="btn btn-success" role="button" title="Ubah Data" data-toggle="modal" data-target="#updatecategory<?php echo $no; ?>"><i class="fas fa-edit"></i></a>
                            <a href="#" class="btn btn-danger" role="button" title="Hapus Data" data-toggle="modal" data-target="#deletecategory<?php echo $no; ?>"><i class="fas fa-trash"></i></a>

                            <!-- modal delete -->
                            <div class="modal fade" id="deletecategory<?php echo $no; ?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Confirmation</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h5 align="center">Apakah anda yakin ingin menghapus kategori barang <?php echo $row['category']; ?>?</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="nodelete" type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                                            <a href="pages/category/function_category.php?act=delete&id=<?= $row['id']; ?>" class="btn btn-primary">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- modal delete -->

                            <!-- model edit -->
                            <div class="modal fade" id="updatecategory<?php echo $no; ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Update kategori</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" method="post" action="pages/category/function_category.php?act=update&id=<?= $row['id']; ?>">
                                                <div class="form-group">
                                                    <label>Kategori Barang</label>
                                                    <input type="text" class="form-control" id="category" name="category" placeholder="Masukan kategori barang" value="<?php echo $row['category']; ?>" required>
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
