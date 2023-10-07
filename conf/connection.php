<?php
// Konfigurasi koneksi ke database
$host = "localhost"; // Host database (biasanya localhost)
$username = "root"; // Username database
$password = ""; // Password database (biasanya kosong)
$database = "db_bengkel_drt"; // Nama database

// Membuat koneksi ke database
$connection = mysqli_connect($host, $username, $password, $database);

// Memeriksa apakah koneksi berhasil
if (!$connection) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

?>
