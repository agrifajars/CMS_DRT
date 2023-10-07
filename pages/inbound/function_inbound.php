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
    session_start();

    $uuid = generateUuidV4();
    $id_inventory = $_POST["id_inventory"];
    $id_supplier = $_POST["id_supplier"];
    $id_user = $_SESSION['user_id'];
    $session_user = $_SESSION['user_id'];
    $amount = $_POST["amount"];
    $price = str_replace(",", "", $_POST["price"]);

    $formatted_date = $_POST["date"];
    $timestamp = strtotime($formatted_date);

    if ($timestamp !== false) {
        $formatted_date = date('Y-m-d H:i:s', $timestamp);
    }

    $query = "INSERT INTO inbound (`id`, `id_inventory`, `id_supplier`, `id_user`, `date`, `amount`, `purchase_price`) VALUES ('$uuid', '$id_inventory', '$id_supplier', '$id_user', '$formatted_date', $amount, $price)";
    $queryUpdateStock = "UPDATE inventory SET stock = stock + $amount WHERE id = '$id_inventory'";
    
    $result = mysqli_query($connection, $query);
    $resultUpdateStock = mysqli_query($connection, $queryUpdateStock);

    if ($result && $resultUpdateStock) {
        echo '<script>alert("Data berhasil ditambahkan."); window.location.href="../../index.php?menu=inbound"</script>';
    } else {
        echo "ERROR, data gagal disimpan". mysqli_error($connection);
    }
} else if ($_GET['act' ] == 'update') {
    // $id = $_GET['id'];
    // $newCategory = $_POST["category"];

    // // Query INSERT untuk menyimpan data ke dalam tabel
    // $query = "UPDATE category SET `category` = '$newCategory' WHERE id = '$id'";

    // // Menjalankan kueri INSERT
    // $result = mysqli_query($connection, $query);

    // if ($result) {
    //     echo '<script>alert("Data berhasil diupdate."); window.location.href="../../index.php?menu=category"</script>';
    // } else {
    //     echo "ERROR, data gagal diupdate". mysqli_error($connection);
    // }
} else if ($_GET['act' ] == 'delete'){
    // $id = $_GET['id'];
    // $query = ("DELETE FROM category WHERE id ='$id'");

    // $result = mysqli_query($connection, $query);

    // if ($result) {
    //     echo '<script>alert("Data berhasil dihapus."); window.location.href="../../index.php?menu=category"</script>';
    // } else {
    //     echo "ERROR, data gagal dihapus". mysqli_error($connection);
    // }
} else {
    
}
?>