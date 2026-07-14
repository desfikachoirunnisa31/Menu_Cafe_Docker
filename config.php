<?php
// Membaca variabel environment dari Docker, jika tidak ada gunakan default lokal
$host     = getenv('DB_HOST')     ?: 'localhost';
$username = getenv('DB_USER')     ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';
$database = getenv('DB_NAME')     ?: 'cafe_db';
$port     = 3306; 

$conn = mysqli_connect($host, $username, $password, $database, $port);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>