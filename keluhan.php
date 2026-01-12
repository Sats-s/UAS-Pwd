<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sampaikan Keluhan - SPBU Pertamina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="fas fa-comment-dots"></i> FORM
            </a>
            <div class="navbar-nav ms-auto">
                <a href="index.php" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-home me-1"></i> Kembali
                </a>
            </div>
        </div>
    </nav>
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="mb-0">
                            <i class="fas fa-headset me-2"></i>
                            FORM PENGADUAN KELUHAN
                        </h4>
                        <p class="mb-0">SPBU Pertamina Peduli</p>
                    </div>
                    
                    <div class="card-body">
                        <?php if(isset($_GET['success'])): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                Terima kasih! Keluhan Anda telah berhasil disampaikan.
                                <br>
                                <small>Tim kami akan segera menindaklanjuti keluhan Anda.</small>
                            </div>
                        <?php endif; ?>
                        
                        <form action="keluhan_action.php" method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label">
                                        <i class="fas fa-user text-danger me-1"></i> Nama Lengkap *
                                    </label>
                                    <input type="text" class="form-control" id="nama" name="nama" 
                                           placeholder="Masukkan nama lengkap" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope text-danger me-1"></i> Email
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           placeholder="contoh@email.com">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">
                                    <i class="fas fa-phone text-danger me-1"></i> Nomor Handphone *
                                </label>
                                <input type="tel" class="form-control" id="no_hp" name="no_hp" 
                                       placeholder="08xxxxxxxxxx" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="jenis_keluhan" class="form-label">
                                    <i class="fas fa-list text-danger me-1"></i> Jenis Keluhan *
                                </label>
                                <select class="form-select" id="jenis_keluhan" name="jenis_keluhan" required>
                                    <option value=""> Pilih Jenis Keluhan </option>
                                    <option value="Pelayanan">Pelayanan Kurang Memuaskan</option>
                                    <option value="Fasilitas">Fasilitas Tidak Lengkap</option>
                                    <option value="Kebersihan">Kebersihan Area SPBU</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">
                                    <i class="fas fa-comment-dots text-danger me-1"></i> Deskripsi Keluhan *
                                </label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" 
                                          rows="5" placeholder="Jelaskan keluhan Anda secara detail..." 
                                          required></textarea>
                                <div class="form-text">
                                    Berikan kami masukkan kritik atau saran agar dapat membantu kami lebih baik kedepannya! 
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-danger btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i> KIRIM KELUHAN
                                </button>
                                <a href="index.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i> BATAL
                                </a>
                            </div>
                        </form>
                    </div>
                    
                    <div class="card-footer bg-light">
                        <div class="row">
                            <div class="col-md-6">
                                <h6><i class="fas fa-info-circle text-primary me-2"></i>Informasi</h6>
                                <p class="small mb-0">
                                       Setiap Pengaduan selalu diawasi
                                </p>
                            </div>
                            <div class="col-md-6 text-end">
                                <h6><i class="fas fa-phone-alt text-success me-2"></i>Kontak</h6>
                                <p class="small mb-0">
                                    +62-813-256-748
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