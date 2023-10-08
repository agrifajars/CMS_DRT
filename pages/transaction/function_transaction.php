<?php
include '../../conf/connection.php';

session_start();
if (isset($_SESSION['user_id']) == 0){
    echo '<script>alert("Anda harus login terlebih dahulu!"); window.location.href="login.php"</script>';
}
//Generate UUID
function generateUuidV4() {
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0F | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3F | 0x80);

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}


if ($_GET['act'] == 'add') {    
    $uuid = generateUuidV4();
    $id_transaction = $_GET['id_transaction'];
    $id_inventory = $_POST['id_inventory'];
    $id_user = $_SESSION['user_id'];
    $amount = $_POST['amount'];

    // Query untuk mendapatkan jumlah stok inventaris berdasarkan id_inventory
    $queryCheckStock = "SELECT `stock` FROM `inventory` WHERE `id` = '$id_inventory'";
    $resultCheckStock = mysqli_query($connection, $queryCheckStock);

    $row = mysqli_fetch_assoc($resultCheckStock);
    $stock = $row['stock'];

    if ($amount <= $stock) {
        $query = "INSERT INTO `transaction_detail`(`id`, `id_transaction`, `id_inventory`, `id_user`, `amount`) VALUES ('$uuid','$id_transaction','$id_inventory','$id_user',$amount)";
        $result = mysqli_query($connection, $query);

        if ($result) {
            echo '<script>window.location.href="../../index.php?menu=transaction_detail"</script>';
        } else {
            echo "ERROR, data gagal disimpan". mysqli_error($connection);
        }
    } else {
        echo '<script>alert("Stock barang yang dipilih tidak cukup."); window.location.href="../../index.php?menu=transaction_detail"</script>';
    }

} else if ($_GET['act' ] == 'save_session') {
    $id_transaction = $_GET['id_transaction'];
    $id_user = $_SESSION['user_id'];
    $service = str_replace(",", "", $_POST["service"]);
    $currentDateTime = date('Y-m-d H:i:s');
    
    $query = "INSERT INTO `transaction`(`id`, `id_user`, `date`, `service`) VALUES ('$id_transaction','$id_user','$currentDateTime', '$service')";
    $result = mysqli_query($connection, $query);

    if ($result) {
        unset($_SESSION['id_transaction']);

        echo '<script>alert("Data berhasil disimpan."); window.location.href="../../index.php?menu=transaction"</script>';
    } else {
        echo "ERROR, data gagal disimpan". mysqli_error($connection);
    }
} else if ($_GET['act' ] == 'update') {
    $id = $_GET['id'];

    $query = "UPDATE `transaction` SET `status` = 'paid' WHERE id = '$id'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo '<script>alert("Data berhasil diupdate."); window.location.href="../../index.php?menu=transaction"</script>';
    } else {
        echo "ERROR, data gagal diupdate". mysqli_error($connection);
    }
} else if ($_GET['act' ] == 'delete_session') {
    $id_transaction = $_GET['id_transaction'];

    $query = "DELETE FROM `transaction_detail` WHERE id_transaction = '$id_transaction'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        unset($_SESSION['id_transaction']);

        echo '<script>window.location.href="../../index.php?menu=transaction"</script>';
    } else {
        echo "ERROR, data gagal dihapus". mysqli_error($connection);
    }
} else if ($_GET['act' ] == 'get'){
    // Query SQL untuk mengambil data detail transaksi berdasarkan ID transaksi
    $id_transaction = $_GET['id_transaction'];
    $query = "SELECT
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
        WHERE
            trd.`id_transaction` = '$id_transaction'
        ORDER BY
            trd.`created_at` DESC;";
    $result = mysqli_query($connection, $query);

    if ($result->num_rows > 0) {
        // Mulai membuat tabel HTML
        echo '<table>';
        echo '<thead>';
        echo 
        '<tr>
            <th>Kategori</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Harga</th>
        </tr>';
        echo '</thead>';
        echo '<tbody>';
    
        $totalHarga = 0; // Inisialisasi total harga
    
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['category'] . '</td>';
            echo '<td>' . $row['name'] . '</td>';
            echo '<td>' . $row['amount'] . '</td>';
            echo '<td>' . number_format($row['price'], 0, ',', '.') . '</td>';
            echo '</tr>';
    
            // Tambahkan harga item ke total harga
            $totalHarga += ($row['amount'] * $row['price']);
        }
    
        echo '</tbody>';
        echo '</table>';
    
        // Tampilkan total harga di luar tabel
        echo '<div style="margin-top: 20px;" class="float-right">Total Biaya : ' . number_format($totalHarga, 0, ',', '.') . '</div>';
    } else {
        echo 'Tidak ada data detail transaksi.';
    }
}
?>