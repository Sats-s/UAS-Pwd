<?php
require_once 'config.php';

// Cek apakah user sudah login
if(!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Ambil data stok saat ini
$query = "SELECT * FROM stok_bensin ORDER BY jenis_bensin";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">
                <i class="fas fa-gas-pump"></i> UPDATE STOK BENSIN
            </a>
            <div class="navbar-nav ms-auto">
                <a href="dashboard.php" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-edit me-2"></i>
                            Perbarui Stok Bensin
                        </h4>
                        <p class="mb-0 small">Update stok terbaru untuk ditampilkan di halaman utama</p>
                    </div>
                    
                    <div class="card-body">
                        <?php if(isset($_GET['success'])): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                Stok berhasil diperbarui!
                            </div>
                        <?php endif; ?>
                        
                        <form action="update_stok_action.php" method="POST">
                            <?php while($stok = mysqli_fetch_assoc($result)): ?>
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0 text-success">
                                        <?php echo $stok['jenis_bensin']; ?>
                                    </h5>
                                    <small class="text-muted">
                                        Stok saat ini: <?php echo number_format($stok['stok_liter'], 2); ?> liter
                                    </small>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Harga per Liter (Rp)</label>
                                            <input type="number" class="form-control" 
                                                   name="harga[<?php echo $stok['id']; ?>]" 
                                                   value="<?php echo $stok['harga_per_liter']; ?>"
                                                   min="0" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Stok Baru (liter)</label>
                                            <input type="number" class="form-control" 
                                                   name="stok[<?php echo $stok['id']; ?>]" 
                                                   value="<?php echo $stok['stok_liter']; ?>"
                                                   step="0.01" min="0" required>
                                            <div class="form-text">
                                                Masukkan jumlah stok dalam liter
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="jenis[<?php echo $stok['id']; ?>]" 
                                           value="<?php echo $stok['jenis_bensin']; ?>">
                                </div>
                            </div>
                            <?php endwhile; ?>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-save me-2"></i> SIMPAN PERUBAHAN
                                </button>
                                <a href="dashboard.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i> BATAL
                                </a>
                            </div>
                        </form>
                    </div>
                    
                    <div class="card-footer bg-light">
                        <div class="row">
                            <div class="col-md-6">
                                <h6><i class="fas fa-info-circle text-success me-2"></i>Catatan:</h6>
                                <p class="small mb-0">
                                    Stok yang diupdate akan langsung muncul di halaman utama
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="bg-danger text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>SPBU PERTAMINA KRAPYAK</h5>
                    <p>Jl. Siliwangi No.576, Purwoyoso, Kec. Ngaliyan, Kota Semarang, Jawa Tengah 50184</p>
                    <p>Telepon: +62-813-256-748</p>
                    <p>Email: spbukrapyak@gmail.com</p>
                </div>
                <div class="col-md-6 text-end">
                    <h5>Jam Operasional</h5>
                    <p>24 Jam Non-Stop</p>
                    <p>Selalu Buka Setiap Saat</p>  
                </div>
            </div>
            <hr class="bg-light">
            <div class="text-center">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> SPBU Pertamina Krapyak  </p>
            </div>
        </div>
    </footer>
    
    <script src="js/animasi.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>