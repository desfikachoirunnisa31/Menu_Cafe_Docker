CREATE DATABASE cafe_db;
USE cafe_db;

CREATE TABLE menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_menu VARCHAR(100),
    harga INT,
    gambar VARCHAR(255), -- Nanti diarahkan ke Cloud Storage/Object Storage
    kategori VARCHAR(50) NOT NULL
);

INSERT INTO menu (nama_menu, harga, gambar, kategori) VALUES 
('Es Kopi Kenangan', 18000, 'kopi.jpg', 'Minuman'),
('Croissant Keju', 25000, 'croissant.jpg', 'Makanan');