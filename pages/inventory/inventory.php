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
                    <th>Nama Barang</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Foto Barang</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    include "conf/connection.php";
                    
                    $no = 0;
                    $query = mysqli_query($connection, 
                        "SELECT
                            i.`id`,
                            i.`id_image`,
                            i.`id_category`,
                            c.`category`,
                            i.`name`,
                            i.`stock`,
                            i.`price`,
                            i.`created_at`,
                            i.`updated_at`,
                            im.`imagetype`,
                            im.`imagedata`
                        FROM
                            `inventory` i
                        LEFT JOIN
                            `category` c
                        ON
                            i.`id_category` = c.`id`
                        LEFT JOIN
                            `images` im
                        ON
                            i.`id_image` = im.`id`
                        ORDER BY
                            i.`created_at` DESC;"
                    );
                    
                    while ($row = mysqli_fetch_assoc($query)) {
                    ?>

                    <tr>
                        <td><?php echo $no = $no + 1; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['stock']; ?></td>
                        <td><?php echo number_format($row['price'], 0, ',', '.'); ?></td>
                        <td><img src="pages/image.php?id=<?php echo $row['id_image']; ?>" width="150" height="150" /></td>
                        <td>
                            <a href="#" class="btn btn-success" role="button" title="Ubah Data" data-toggle="modal" data-target="#updatecategory<?php echo $no; ?>">Update</a>
                            <!-- <a href="#" class="btn btn-danger" role="button" title="Hapus Data" data-toggle="modal" data-target="#deletecategory<?php echo $no; ?>"><i class="fas fa-trash"></i></a> -->

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
                                            <h5 align="center">Apakah anda yakin ingin menghapus barang <?php echo $row['name']; ?>?</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="nodelete" type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancel</button>
                                            <a href="pages/inventory/function_inventory.php?act=delete&id=<?= $row['id']; ?>" class="btn btn-primary">Delete</a>
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
                                            <h5 class="modal-title">Update inventory</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" method="post" action="pages/inventory/function_inventory.php?act=update&id=<?= $row['id']; ?>" enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <label>Kategori Barang</label>
                                                    <select class="form-control" name="id_category">
                                                        <?php
                                                            $queryCat = mysqli_query($connection, "SELECT * FROM category ORDER BY category DESC");
                                                            
                                                            while ($rowCat = mysqli_fetch_assoc($queryCat)) {
                                                        ?>
                                                        <option value="<?php echo $rowCat['id']; ?>" <?php if ($rowCat['id'] == $row['id_category']) echo ' selected'; ?>><?php echo $rowCat['category']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama Barang</label>
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="Masukan nama barang" value="<?php echo $row['name']; ?>" required>
                                                </div>

                                                <div class="form-group">
                                                    <label>Harga Barang</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <a>Rp</a>   
                                                            </span>
                                                        </div>
                                                        <input type="text" name="price" class="form-control" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')" value="<?php echo number_format($row['price'], 0, ',', '.'); ?>" required/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="image" name="image" onchange="readURL(this, `imageupdate<?php echo $no; ?>`, `filelabel<?php echo $no; ?>`);" accept=".png, .jpg, .jpeg">
                                                            <label class="custom-file-label" for="image" id="filelabel<?php echo $no; ?>">Pilih file</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <img id="imageupdate<?php echo $no; ?>" width="100%"/>
                                                </div>
                                                
                                                <input type="hidden" name="id_image" value="<?php echo $row['id_image']; ?>">
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
                    <h5 class="modal-title">Tambah barang baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" method="post" action="pages/inventory/function_inventory.php?act=add" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Kategori Barang</label>
                            <div class="form-group">
                                <select class="form-control" name="id_category">
                                    <?php
                                        include "conf/connection.php";
                                        
                                        $no = 0;
                                        $query = mysqli_query($connection, "SELECT * FROM category ORDER BY category DESC");
                                        
                                        while ($row = mysqli_fetch_assoc($query)) {
                                    ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['category']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukan nama barang" required>
                        </div>

                        <div class="form-group">
                            <label>Harga Barang</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <a>Rp</a>   
                                    </span>
                                </div>
                                <input type="text" name="price" class="form-control" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')" required/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image" name="image" onchange="readURL(this, `imagesave`, `filelabel`);" accept=".png, .jpg, .jpeg">
                                    <label class="custom-file-label" for="image" id="filelabel">Pilih file</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <img id="imagesave" width="100%"/>
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
</section>

<script>
function readURL(input, imageID, fileLabel) {
    var label = document.getElementById(fileLabel);
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#' + imageID).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
        label.innerText = input.files[0].name;
    }
}

</script>