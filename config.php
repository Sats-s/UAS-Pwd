<?php
session_start();

// Konfigurasi Database
$host = "localhost";
$username = "root";
$password = "";
$database = "spbu_db";

// Koneksi ke database
$conn = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set timezone buat Timer
date_default_timezone_set('Asia/Jakarta');
?>