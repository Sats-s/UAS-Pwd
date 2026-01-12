<?php
require_once 'config.php';

// Cek apakah user sudah login
if(!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Loop melalui semua data yang dikirim
    foreach($_POST['stok'] as $id => $stok_liter) {
        $id = mysqli_real_escape_string($conn, $id);
        $stok_liter = mysqli_real_escape_string($conn, $stok_liter);
        $harga = mysqli_real_escape_string($conn, $_POST['harga'][$id]);
        
        // Update stok di database
        $query = "UPDATE stok_bensin 
                 SET stok_liter = '$stok_liter', 
                     harga_per_liter = '$harga'
                 WHERE id = '$id'";
        mysqli_query($conn, $query);
    }
    
    header("Location: update_stok.php?success=1");
    exit();
} else {
    header("Location: update_stok.php");
    exit();
}
?>