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
    $id_image = generateUuidV4();
    $id_category = $_POST["id_category"];
    $name = $_POST["name"];
    $price = str_replace(",", "", $_POST["price"]);

    $imageUploaded = isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK;
    if ($imageUploaded) {
        $imagePath = $_FILES['image']['tmp_name'];
        $imageType = mime_content_type($imagePath);
        $imagedata = addslashes(file_get_contents($imagePath));
            
        $query = "INSERT INTO images (`id`, `imagetype`, `imagedata`) VALUES ('$id_image', '$imageType', '$imagedata')";
        $result = mysqli_query($connection, $query);

        if (!$result) {
            echo "ERROR, gagal menyimpan gambar: " . mysqli_error($connection);
            exit();
        }
    }

    $query = "INSERT INTO inventory (`id`, `id_category`, `id_image`, `name`, `stock`, `price`) VALUES ('$uuid', '$id_category', '$id_image', '$name', 0, '$price')";
    $result = mysqli_query($connection, $query);

    if ($result) {
        echo '<script>alert("Data berhasil ditambahkan."); window.location.href="../../index.php?menu=inventory"</script>';
    } else {
        echo "ERROR, data gagal disimpan: " . mysqli_error($connection);
    }
} else if ($_GET['act' ] == 'update') {
    $id = $_GET['id'];
    $id_image = $_POST["id_image"];
    $new_id_image = generateUuidV4();
    $newIdCategory = $_POST["id_category"];
    $newName = $_POST["name"];
    $newPrice = str_replace(",", "", $_POST["price"]);
    $imageUploaded = isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK;
    
    if ($imageUploaded) {
        $imagePath = $_FILES['image']['tmp_name'];
        $imageType = mime_content_type($imagePath);
        $imagedata = addslashes(file_get_contents($imagePath));

        $resultDelete = mysqli_query($connection, "DELETE FROM images WHERE id = '$id_image'");
        if (!$resultDelete) {
            echo "ERROR, gagal update saat delete gambar: " . mysqli_error($connection);
            exit();
        }

        $resultSave = mysqli_query($connection, "INSERT INTO images (`id`, `imagetype`, `imagedata`) VALUES ('$new_id_image', '$imageType', '$imagedata')");
        if (!$resultSave) {
            echo "ERROR, gagal update saat simpan gambar: " . mysqli_error($connection);
            exit();
        }

        $result = mysqli_query($connection, "UPDATE inventory SET `id_category` = '$newIdCategory', `id_image` = '$new_id_image', `name` = '$newName', `price` = '$newPrice' WHERE id = '$id'");
        if ($result) {
            echo '<script>alert("Data berhasil diupdate."); window.location.href="../../index.php?menu=inventory"</script>';
        } else {
            echo "ERROR, data gagal diupdate?". mysqli_error($connection);
        }
    } else {
        $query = "UPDATE inventory SET `id_category` = '$newIdCategory', `name` = '$newName', `price` = '$newPrice' WHERE id = '$id'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            echo '<script>alert("Data berhasil diupdate."); window.location.href="../../index.php?menu=inventory"</script>';
        } else {
            echo "ERROR, data gagal diupdate". mysqli_error($connection);
        }
    }
} else if ($_GET['act' ] == 'delete') {
    $id = $_GET['id'];

    $querySelect = "SELECT id_image FROM inventory WHERE id ='$id'";
    $resultSelect = mysqli_query($connection, $querySelect);

    if ($resultSelect && mysqli_num_rows($resultSelect) > 0) {
        $row = mysqli_fetch_assoc($resultSelect);
        $id_image = $row['id_image'];

        $queryDeleteInventory = "DELETE FROM inventory WHERE id ='$id'";
        $resultDeleteInventory = mysqli_query($connection, $queryDeleteInventory);

        $queryDeleteImage = "DELETE FROM images WHERE id ='$id_image'";
        $resultDeleteImage = mysqli_query($connection, $queryDeleteImage);

        if ($resultDeleteInventory && $resultDeleteImage) {
            echo '<script>alert("Data berhasil dihapus."); window.location.href="../../index.php?menu=inventory"</script>';
        } else {
            echo "ERROR, data gagal dihapus: " . mysqli_error($connection);
        }
    }
} else if ($_GET['act' ] == 'search') {
    if (!isset($_GET['searchTerm'])) { 
        $query = "SELECT * FROM inventory LIMIT 10"; 

        $resultSelect = mysqli_query($connection, $query);
        $json = [];

        while ($row = $resultSelect->fetch_assoc()) {
            $name = $row['name'];
            $stock = $row['stock'];

            $json[] = ['id' => $row['id'], 'text' => "$stock - $name"];
        }
    } else {
        $search = $_GET['searchTerm'];
        $query = "SELECT * FROM inventory WHERE name LIKE '%".$search."%' LIMIT 10"; 
        
        $resultSelect = mysqli_query($connection, $query);
        $json = [];

        while ($row = $resultSelect->fetch_assoc()) {
            $name = $row['name'];
            $stock = $row['stock'];

            $json[] = ['id' => $row['id'], 'text' => "$stock - $name"];
        }
    }

    echo json_encode($json);
}
?>