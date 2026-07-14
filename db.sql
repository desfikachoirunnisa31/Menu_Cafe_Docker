CREATE DATABASE IF NOT EXISTS cafe_db;
USE cafe_db;

CREATE TABLE IF NOT EXISTS menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_menu VARCHAR(100),
    harga INT,
    gambar VARCHAR(255),
    kategori VARCHAR(50) NOT NULL
);

-- TAMBAHKAN TABEL TRANSAKSI DI BAWAH INI
CREATE TABLE IF NOT EXISTS transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_harga INT NOT NULL
);

-- Data bawaan untuk menu
INSERT INTO menu (nama_menu, harga, gambar, kategori) VALUES 
('Es Kopi Kenangan', 18000, 'kopi.jpg', 'Minuman'),
('Croissant Keju', 25000, 'croissant.jpg', 'Makanan')
ON DUPLICATE KEY UPDATE nama_menu=nama_menu;

-- Data bawaan untuk transaksi (agar query SUM di admin.php tidak kosong/error)
INSERT INTO transaksi (total_harga) VALUES (43000);