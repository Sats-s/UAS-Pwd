<?php
require_once 'config.php';

// Jika karyawan belum login, redirect ke login
if(!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Proses update status keluhan
if(isset($_POST['update_status'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $query = "UPDATE keluhan SET status = '$status' WHERE id = '$id'";
    mysqli_query($conn, $query);
}

// Ambil semua keluhan
$query = "SELECT * FROM keluhan ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Keluhan - SPBU Pertamina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-danger">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">
                <i class="fas fa-comments"></i> KELOLA KELUHAN
            </a>
            <div class="navbar-nav ms-auto">
                <a href="dashboard.php" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-warning text-white">
                <h4 class="mb-0">
                    <i class="fas fa-list me-2"></i>
                    Daftar Keluhan Pelanggan
                </h4>
            </div>
            
            <div class="card-body">
                <?php if(mysqli_num_rows($result) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Kontak</th>
                                    <th>Jenis Keluhan</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; while($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
                                    <td>
                                        <?php if($row['email']): ?>
                                            <?php echo htmlspecialchars($row['email']); ?><br>
                                        <?php endif; ?>
                                        <?php echo htmlspecialchars($row['no_hp']); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['jenis_keluhan']); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
                                    <td>
                                        <?php 
                                        $badge_color = '';
                                        switch($row['status']) {
                                            case 'baru': $badge_color = 'warning'; break;
                                            case 'diproses': $badge_color = 'info'; break;
                                            case 'selesai': $badge_color = 'success'; break;
                                        }
                                        ?>
                                        <span class="badge bg-<?php echo $badge_color; ?>">
                                            <?php echo ucfirst($row['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-sm btn-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#detailModal<?php echo $row['id']; ?>">
                                            <i class="fas fa-eye"></i> Detail
                                        </button>
                                        
                                        <!-- Modal -->
                                        <div class="modal fade" id="detailModal<?php echo $row['id']; ?>" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title">
                                                            <i class="fas fa-file-alt me-2"></i>
                                                            Detail Keluhan
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <p><strong>Nama Pelanggan:</strong><br>
                                                                <?php echo htmlspecialchars($row['nama_pelanggan']); ?></p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p><strong>Tanggal:</strong><br>
                                                                <?php echo date('d F Y H:i', strtotime($row['created_at'])); ?></p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <p><strong>Email:</strong><br>
                                                                <?php echo $row['email'] ? htmlspecialchars($row['email']) : '-'; ?></p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p><strong>No. HP:</strong><br>
                                                                <?php echo htmlspecialchars($row['no_hp']); ?></p>
                                                            </div>
                                                        </div>
                                                        
                                                        <p><strong>Jenis Keluhan:</strong><br>
                                                        <?php echo htmlspecialchars($row['jenis_keluhan']); ?></p>
                                                        
                                                        <p><strong>Deskripsi Keluhan:</strong></p>
                                                        <div class="border p-3 bg-light">
                                                            <?php echo nl2br(htmlspecialchars($row['deskripsi'])); ?>
                                                        </div>
                                                        
                                                        <hr>
                                                        
                                                        <form method="POST" action="" class="mt-3">
                                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                            <div class="row align-items-center">
                                                                <div class="col-md-4">
                                                                    <label><strong>Update Status:</strong></label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <select name="status" class="form-select">
                                                                        <option value="baru" <?php echo $row['status'] == 'baru' ? 'selected' : ''; ?>>Baru</option>
                                                                        <option value="diproses" <?php echo $row['status'] == 'diproses' ? 'selected' : ''; ?>>Diproses</option>
                                                                        <option value="selesai" <?php echo $row['status'] == 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button type="submit" name="update_status" 
                                                                            class="btn btn-success">
                                                                        <i class="fas fa-save"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle me-2"></i>
                        Belum ada keluhan dari pelanggan.
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        <a href="dashboard.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
                        </a>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="keluhan.php" class="btn btn-outline-primary">
                            <i class="fas fa-plus me-2"></i> Form Keluhan Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>