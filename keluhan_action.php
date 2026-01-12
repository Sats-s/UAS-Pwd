<?php
require_once 'config.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $jenis_keluhan = mysqli_real_escape_string($conn, $_POST['jenis_keluhan']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    
    // Insert ke database
    $query = "INSERT INTO keluhan (nama_pelanggan, email, no_hp, jenis_keluhan, deskripsi, status) 
              VALUES ('$nama', '$email', '$no_hp', '$jenis_keluhan', '$deskripsi', 'baru')";
    
    if(mysqli_query($conn, $query)) {
        header("Location: keluhan.php?success=1");
        exit();
    } else {
        die("Error: " . mysqli_error($conn));
    }
} else {
    header("Location: keluhan.php");
    exit();
}
?>