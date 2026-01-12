-- Buat database
CREATE DATABASE IF NOT EXISTS spbu_db;
USE spbu_db;

-- Tabel untuk karyawan (admin)
CREATE TABLE karyawan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel stok bensin
CREATE TABLE stok_bensin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    jenis_bensin VARCHAR(50) NOT NULL,
    harga_per_liter INT NOT NULL,
    stok_liter DECIMAL(10,2) NOT NULL,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel keluhan
CREATE TABLE keluhan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_pelanggan VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    no_hp VARCHAR(20),
    jenis_keluhan VARCHAR(50) NOT NULL,
    deskripsi TEXT NOT NULL,
    status ENUM('baru', 'diproses', 'selesai') DEFAULT 'baru',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert admin user
INSERT INTO karyawan (username, password, nama) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator');

-- Insert data stok awal
INSERT INTO stok_bensin (jenis_bensin, harga_per_liter, stok_liter) VALUES
('Pertalite', 10000, 5000.00),
('Pertamax', 12500, 3000.00),
('Pertamax Turbo', 14000, 2000.00),
('Solar', 6800, 4000.00);
