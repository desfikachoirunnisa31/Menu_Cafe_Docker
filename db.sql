USE cafe_db;

CREATE TABLE IF NOT EXISTS menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_menu VARCHAR(100),
    harga INT,
    gambar VARCHAR(255),
    kategori VARCHAR(50) NOT NULL
);

INSERT INTO menu (nama_menu, harga, gambar, kategori) VALUES 
('Es Kopi Kenangan', 18000, 'kopi.jpg', 'Minuman'),
('Croissant Keju', 25000, 'croissant.jpg', 'Makanan');