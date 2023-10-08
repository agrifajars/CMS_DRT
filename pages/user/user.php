<section class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-12">
            <!-- /.card-header -->
            <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" <?php if ($_SESSION['role'] !== 'admin') echo 'disabled'; ?> data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus" style="margin-right: 5px;"></i> Tambah data</button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="datatable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Nomor Telfon</th>
                    <th>Alamat</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    include "conf/connection.php";
                    
                    $no = 0;
                    $query = mysqli_query($connection, "SELECT * FROM user ORDER BY created_at DESC");
                    
                    while ($row = mysqli_fetch_assoc($query)) {
                    ?>

                    <tr>
                        <td><?php echo $no = $no + 1; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td>
                            <?php 
                            if ($_SESSION['role'] == 'admin') {
                                echo $row['password'];
                            } else {
                                echo "*****";
                            }
                            ?>
                        </td>

                        <td><?php echo $row['phone_number']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td><?php echo ucfirst($row['role']); ?></td>
                        <td>
                            <button type="button" class="btn btn-success" <?php if ($_SESSION['role'] !== 'admin') echo 'disabled'; ?> data-toggle="modal" data-target="#updateuser<?php echo $no; ?>">Update</button>
                            <button type="button" class="btn btn-danger" <?php if ($_SESSION['role'] !== 'admin') echo 'disabled'; ?> data-toggle="modal" data-target="#deleteuser<?php echo $no; ?>">Hapus</button>

                            <!-- modal delete -->
                            <div class="modal fade" id="deleteuser<?php echo $no; ?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Confirmation</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h5 align="center">Apakah anda yakin ingin menghapus user <?php echo $row['name']; ?>?</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="nodelete" type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                                            <a href="pages/user/function_user.php?act=delete&id=<?= $row['id']; ?>" class="btn btn-primary">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- modal delete -->

                            <!-- model edit -->
                            <div class="modal fade" id="updateuser<?php echo $no; ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Update user</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" method="post" action="pages/user/function_user.php?act=update&id=<?= $row['id']; ?>">
                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="Masukan nama lengkap" value="<?php echo $row['name']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukan username" value="<?php echo $row['username']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input type="text" class="form-control" id="password" name="password" placeholder="Masukan password" value="<?php echo $row['password']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nomor Telfon</label>
                                                    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Masukan nomor telfon : 0857708282" value="<?php echo $row['phone_number']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Alamat</label>
                                                    <textarea class="form-control" rows="3" id="address" name="address" placeholder="Masukan alamat" required><?php echo $row['address']; ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>Pilih role</label>
                                                    <div class="form-group">
                                                        <select class="form-control" name="role">
                                                            <option value="admin"<?php if ($row['role'] == 'admin') echo ' selected'; ?>>Admin</option>
                                                            <option value="user"<?php if ($row['role'] == 'user') echo ' selected'; ?>>User</option>
                                                        </select>
                                                    </div>
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
                    <h5 class="modal-title">Tambah user baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" method="post" action="pages/user/function_user.php?act=add">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukan nama lengkap" required>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Masukan username" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" class="form-control" id="password" name="password" placeholder="Masukan password" required>
                        </div>
                        <div class="form-group">
                            <label>Nomor Telfon</label>
                            <input type="text" pattern="^\d{10,12}$" class="form-control" id="phone_number" name="phone_number" placeholder="Masukan nomor telfon : 0857708282" required>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" rows="3" id="address" name="address" placeholder="Masukan alamat" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Pilih role</label>
                            <div class="form-group">
                                <select class="form-control" name="role">
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
</section>
