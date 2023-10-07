<?php
include "conf/connection.php";

$query = mysqli_query($connection, 
                        "SELECT 
                        (SELECT COUNT(*) FROM inventory) AS total_inventory,
                        (SELECT COUNT(*) FROM user) AS total_user,
                        (SELECT COUNT(*) FROM transaction) AS total_transactions,
                        SUM(td.amount * i.price) AS total_price
                    FROM 
                        transaction_detail AS td
                    INNER JOIN 
                        inventory AS i ON td.id_inventory = i.id;"
                    );
                    
                    while ($row = mysqli_fetch_assoc($query)) {
                ?>
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
            <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                <div class="inner">
                    <h3><?php echo $row['total_inventory']; ?></h3>

                    <p>Inventory</p>
                </div>
                <div class="icon">
                    <i class="nav-icon fas fa-box"></i>
                </div>
                    <a href="index.php?menu=inventory" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?php echo number_format($row['total_user'], 0, ',', '.'); ?></h3>

                        <p>Jumlah user</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                    <a href="index.php?menu=user" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?php echo number_format($row['total_transactions'], 0, ',', '.'); ?></h3>

                        <p>Transaksi</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="index.php?menu=transaction" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?php echo number_format($row['total_price'], 0, ',', '.'); ?></h3>

                        <p>Pendapatan</p>
                    </div>

                    <div class="icon">
                    <i class="nav-icon fas fa-dollar-sign"></i>

                    </div>
                    <a href="index.php?menu=outbound" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        <!-- ./col -->
        </div>
        <!-- /.row -->
    </div>
</section>
<?php } ?>