<?php

include '../conf/connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM images WHERE id = '$id'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);

    header("Content-type: " . $row["imagetype"]);
    echo $row["imagedata"];
}

mysqli_close($connection);
?>