<?php
require_once 'config.php';

// Cek apakah user sudah login
if(!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Hitung statistik
$query_keluhan = "SELECT COUNT(*) as total, 
                  SUM(CASE WHEN status = 'baru' THEN 1 ELSE 0 END) as baru,
                  SUM(CASE WHEN status = 'diproses' THEN 1 ELSE 0 END) as diproses,
                  SUM(CASE WHEN status = 'selesai' THEN 1 ELSE 0 END) as selesai
                  FROM keluhan";
$result_keluhan = mysqli_query($conn, $query_keluhan);
$stat_keluhan = mysqli_fetch_assoc($result_keluhan);

$query_stok = "SELECT COUNT(*) as total, SUM(stok_liter) as total_liter FROM stok_bensin";
$result_stok = mysqli_query($conn, $query_stok);
$stat_stok = mysqli_fetch_assoc($result_stok);

// Ambil keluhan terbaru
$query_keluhan_baru = "SELECT * FROM keluhan WHERE status = 'baru' ORDER BY created_at DESC LIMIT 5";
$result_keluhan_baru = mysqli_query($conn, $query_keluhan_baru);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">
                <i class="fas fa-tachometer-alt"></i> Menu Dashboard
            </a>
        </div>
    </nav>
    
    <div class="container-fluid mt-3">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="list-group">
                    <a href="dashboard.php" class="list-group-item list-group-item-action active">
                        <i class="fas fa-home me-2"></i>Dashboard
                    </a>
                    <a href="update_stok.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-gas-pump me-2"></i>Update Stok Bensin
                    </a>
                    <a href="keluhan_view.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-comments me-2"></i>Kelola Keluhan
                    </a>
                    <a href="index.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-globe me-2"></i>Halaman Utama
                    </a>
                    <a href="logout.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-sign-out-alt"></i>Logout
                    </a>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9">
                <!-- Statistik -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Keluhan</h5>
                                <h2><?php echo $stat_keluhan['total']; ?></h2>
                                <p><i class="fas fa-comment me-2"></i>Data Keluhan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h5 class="card-title">Keluhan Baru</h5>
                                <h2><?php echo $stat_keluhan['baru']; ?></h2>
                                <p><i class="fas fa-clock me-2"></i>Belum diproses</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title">Diproses</h5>
                                <h2><?php echo $stat_keluhan['diproses']; ?></h2>
                                <p><i class="fas fa-cog me-2"></i>Sedang diproses</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">Selesai</h5>
                                <h2><?php echo $stat_keluhan['selesai']; ?></h2>
                                <p><i class="fas fa-check me-2"></i>Telah diselesaikan</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Keluhan Baru -->
                <div class="card mb-4">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            Keluhan Terbaru 
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if(mysqli_num_rows($result_keluhan_baru) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Jenis Keluhan</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($keluhan = mysqli_fetch_assoc($result_keluhan_baru)): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($keluhan['nama_pelanggan']); ?></td>
                                            <td><?php echo htmlspecialchars($keluhan['jenis_keluhan']); ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($keluhan['created_at'])); ?></td>
                                            <td>
                                                <span class="badge bg-warning"><?php echo $keluhan['status']; ?></span>
                                            </td>
                                            <td>
                                                <a href="keluhan_view.php?action=detail&id=<?php echo $keluhan['id']; ?>" 
                                                   class="btn btn-sm btn-info text-white">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-center text-muted">Tidak ada keluhan baru</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="fas fa-gas-pump me-2"></i>Update Stok</h5>
                            </div>
                            <div class="card-body text-center">
                                <p>Perbarui stok bensin secara cepat</p>
                                <a href="update_stok.php" class="btn btn-success btn-lg">
                                    <i class="fas fa-edit me-2"></i>Update Stok Bensin
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-warning text-white">
                                <h5 class="mb-0"><i class="fas fa-comments me-2"></i>Kelola Keluhan</h5>
                            </div>
                            <div class="card-body text-center">
                                <p>Lihat dan tanggapi keluhan pelanggan</p>
                                <a href="keluhan_view.php" class="btn btn-warning btn-lg text-white">
                                    <i class="fas fa-list me-2"></i>Kelola Semua Keluhan
                                </a>
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

    <script src="path/ke/animasi.js?v=2"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($conn);?>
