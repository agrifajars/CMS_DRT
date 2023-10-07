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
    $name = $_POST["name"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $phone_number = $_POST["phone_number"];
    $address = $_POST["address"];
    $role = $_POST["role"];

    $query = "INSERT INTO user (`id`, `name`, `username`, `password`, `phone_number`, `address`, `role`) VALUES ('$uuid', '$name', '$username', '$password', '$phone_number', '$address', '$role')";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo '<script>alert("Data berhasil ditambahkan."); window.location.href="../../index.php?menu=user"</script>';
    } else {
        echo "ERROR, data gagal disimpan". mysqli_error($connection);
    }
} else if ($_GET['act' ] == 'update') {
    $id = $_GET['id'];
    
    $newName = $_POST["name"];
    $newUsername = $_POST["username"];
    $newPassword = $_POST["password"];
    $newPhoneNumber = $_POST["phone_number"];
    $newAddress = $_POST["address"];
    $newRole = $_POST["role"];

    $query = "UPDATE user SET `name` = '$newName', `username` = '$newUsername', `password` = '$newPassword', `phone_number` = '$newPhoneNumber', `address` = '$newAddress', `role` = '$newRole' WHERE id = '$id'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo '<script>alert("Data berhasil diupdate."); window.location.href="../../index.php?menu=user"</script>';
    } else {
        echo "ERROR, data gagal diupdate". mysqli_error($connection);
    }
} else if ($_GET['act' ] == 'delete'){
    $id = $_GET['id'];
    $query = ("DELETE FROM user WHERE id ='$id'");

    $result = mysqli_query($connection, $query);

    if ($result) {
        echo '<script>alert("Data berhasil dihapus."); window.location.href="../../index.php?menu=user"</script>';
    } else {
        echo "ERROR, data gagal dihapus". mysqli_error($connection);
    }
} else {
    
}
?>