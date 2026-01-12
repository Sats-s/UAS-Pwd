<?php
require_once 'config.php';

// Ambil data stok bensin terbaru
$query_stok = "SELECT * FROM stok_bensin ORDER BY jenis_bensin";
$result_stok = mysqli_query($conn, $query_stok);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPBU Pertamina - Situs Resmi</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <img src="assets/logo.png" alt="Logo Pertamina" height="50">
                Pertamina Krapyak
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="keluhan.php"><i class="fas fa-comment-dots"></i> Formulir</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                    </li>
                    <?php if(isset($_SESSION['admin'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php"><i class="fas fa-globe me-2"></i>Dashboard</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center mb-5">
                <h1 class="text-danger fw-bold">Stok Terupdate dari SPBU Pertamina</h1>
                <p class="lead">Stok Selalu Terupdate Setiap Hari</p>
            </div>
            
            <!-- Display Stok Bensin -->
            <div class="col-md-12 mb-5">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-gas-pump"></i> STOK TERKINI
                            <span class="badge bg-light text-danger float-end">
                                Update: <?php echo date('d-m-Y'); ?>
                            </span>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php while($stok = mysqli_fetch_assoc($result_stok)): ?>
                            <div class="col-md-3 mb-3">
                                <div class="card h-100 border-danger">
                                    <div class="card-body text-center">
                                        <h5 class="card-title text-danger"><?php echo $stok['jenis_bensin']; ?></h5>
                                        <div class="display-4 fw-bold text-success">
                                            <?php echo number_format($stok['stok_liter'], 0); ?>
                                        </div>
                                        <p class="card-text">Liter</p>
                                        <p class="text-muted">
                                            Harga: Rp <?php echo number_format($stok['harga_per_liter'], 0); ?>/liter
                                        </p>
                                        <?php 
                                        $percentage = ($stok['stok_liter'] / 10000) * 100;
                                        if($percentage < 20) {
                                            $color = "danger";
                                        } elseif($percentage < 50) {
                                            $color = "warning";
                                        } else {
                                            $color = "success";
                                        }
                                        ?>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-<?php echo $color; ?>" 
                                                 role="progressbar" 
                                                 style="width: <?php echo $percentage; ?>%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Informasi -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h4 class="mb-0">Fasilitas Kami</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <i class="fas fa-gas-pump text-danger me-2"></i>
                                Pengisian Bahan Bakar Harian
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-tire text-danger me-2"></i>
                                Pengisian Angin Ban
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-car-wash text-danger me-2"></i>
                                Mushola Bersih
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-tire text-danger me-2"></i>
                                Kamar Mandi Bersih
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Form Keluhan Terkait SPBU</h4>
                    </div>
                    <div class="card-body">
                        <p>SPBU Pertamina peduli dengan masukkan kritik dan saran dari setiap pelanggan untuk kedepannya. Jika ada yang kurang memuaskan seperti :</p>
                        <ul>
                            <li>Pelayanan kurang memuaskan</li>
                            <li>Kebersihan area SPBU</li>
                            <li>Bau tidak sedap sekitar SPBU</li>
                        </ul>
                        <a href="keluhan.php" class="btn btn-danger btn-lg w-100">
                            <i class="fas fa-comment-dots me-2"></i>FORM
                        </a>
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
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
    <!-- Ganti dengan Font Awesome kit Anda atau gunan CDN -->
</body>
</html>
<?php mysqli_close($conn); ?>