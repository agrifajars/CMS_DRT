<?php
session_start();
include '../../conf/connection.php';

if ($_GET['act'] == 'login') {
    // // Tangkap data dari formulir
    $username = $_POST["username"];
    $password = $_POST["password"];

    // $check = mysqli_query($connection, "SELECT * FROM user WHERE username = '$username' AND password = md5('$password')");
    $check = mysqli_query($connection, "SELECT * FROM user WHERE username = '$username' AND password = '$password'");
    if(mysqli_num_rows($check) >= 1) {
        while($row = mysqli_fetch_array($check)) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = $row['role'];

            $username = $row['username'];
            ?>
            <script>
                alert("Selamat datang <?= $username; ?> !"); window.location.href="../../index.php?menu=homepage";
            </script>
            <?php
            exit(); // Penting: Menghentikan eksekusi lebih lanjut
        }
    } else {
        ?>
        <script>
            alert("Username atau pasword salah, periksa kembali.");
            window.location.href="../../login.php";
        </script>
        <?php
        exit();
    }
} else if ($_GET['act'] == 'logout') {
    $session_user = $_SESSION['user_id'];

    if (isset($session_user)){   
        session_destroy(); 
        echo '<script>alert("Anda telah logout!"); window.location.href="../../login.php"</script>';
    }
} else { }
?>