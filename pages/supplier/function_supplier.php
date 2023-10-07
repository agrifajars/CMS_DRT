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
    $phone_number = $_POST["phone_number"];
    $email = $_POST["email"];
    $address = $_POST["address"];

    $query = "INSERT INTO supplier (`id`, `name`, `phone_number`, `email`, `address`) VALUES ('$uuid', '$name', '$phone_number', '$email', '$address')";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo '<script>alert("Data berhasil ditambahkan."); window.location.href="../../index.php?menu=supplier"</script>';
    } else {
        echo "ERROR, data gagal disimpan". mysqli_error($connection);
    }
} else if ($_GET['act' ] == 'update') {
    $id = $_GET['id'];
    $newName = $_POST["name"];
    $newPhoneNumber = $_POST["phone_number"];
    $newEmail = $_POST["email"];
    $newAddress = $_POST["address"];

    $query = "UPDATE supplier SET `name` = '$newName', `phone_number` = '$newPhoneNumber', `email` = '$newEmail', `address` = '$newAddress' WHERE id = '$id'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo '<script>alert("Data berhasil diupdate."); window.location.href="../../index.php?menu=supplier"</script>';
    } else {
        echo "ERROR, data gagal diupdate". mysqli_error($connection);
    }
} else if ($_GET['act' ] == 'delete'){
    $id = $_GET['id'];
    $query = ("DELETE FROM supplier WHERE id ='$id'");

    $result = mysqli_query($connection, $query);

    if ($result) {
        echo '<script>alert("Data berhasil dihapus."); window.location.href="../../index.php?menu=supplier"</script>';
    } else {
        echo "ERROR, data gagal dihapus". mysqli_error($connection);
    }
} else if ($_GET['act' ] == 'search') {
    if (!isset($_GET['searchTerm'])) { 
        $query = "SELECT * FROM supplier LIMIT 10"; 

        $resultSelect = mysqli_query($connection, $query);
        $json = [];

        while ($row = $resultSelect->fetch_assoc()) {
            $json[] = ['id'=>$row['id'], 'text'=> $row['name']];
        }
    } else {
        $search = $_GET['searchTerm'];
        $query = "SELECT * FROM supplier WHERE name LIKE '%".$search."%' LIMIT 10"; 
        
        $resultSelect = mysqli_query($connection, $query);
        $json = [];

        while ($row = $resultSelect->fetch_assoc()) {
            $json[] = ['id'=>$row['id'], 'text'=> $row['name']];
        }
    }

    echo json_encode($json);
}
?>