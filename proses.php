<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config.php';

// --- LOGIKA TAMBAH MENU ---
if (isset($_POST['tambah'])) {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama_menu']);
    $harga    = $_POST['harga'];
    $kategori = $_POST['kategori'];
    
    // Cek file gambar
    if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] == 4) {
        die("Error: Silakan pilih gambar terlebih dahulu.");
    }

    $foto = $_FILES['gambar']['name'];
    $tmp  = $_FILES['gambar']['tmp_name'];
    $dir  = "assets/img/";

    // Buat folder jika belum ada
    if (!is_dir($dir)) { mkdir($dir, 0777, true); }

    // Beri nama unik agar tidak bentrok
    $foto_baru = date('dmYHis') . "_" . str_replace(' ', '_', $foto);
    $path = $dir . $foto_baru;

    if (move_uploaded_file($tmp, $path)) {
        $query = "INSERT INTO menu (nama_menu, harga, gambar, kategori) VALUES ('$nama', '$harga', '$foto_baru', '$kategori')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['pesan'] = "Menu <strong>$nama</strong> berhasil ditambahkan!";
            $_SESSION['warna'] = "success";
            header("Location: admin.php");
            exit();
        }
    } else {
        die("Gagal upload gambar. Cek izin folder assets/img.");
    }
}

// --- LOGIKA HAPUS MENU ---
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    
    // Ambil data gambar untuk dihapus dari folder
    $ambil = mysqli_query($conn, "SELECT gambar FROM menu WHERE id='$id'");
    $data = mysqli_fetch_assoc($ambil);
    
    if ($data) {
        if (file_exists("assets/img/" . $data['gambar'])) {
            unlink("assets/img/" . $data['gambar']);
        }
        
        if (mysqli_query($conn, "DELETE FROM menu WHERE id='$id'")) {
            $_SESSION['pesan'] = "Menu telah berhasil dihapus!";
            $_SESSION['warna'] = "success"; // Tetap success karena operasi berhasil
            header("Location: admin.php");
            exit();
        }
    }
}
// --- LOGIKA EDIT MENU ---
if (isset($_POST['edit'])) {
    $id       = $_POST['id'];
    $nama     = mysqli_real_escape_string($conn, $_POST['nama_menu']);
    $harga    = $_POST['harga'];
    $kategori = $_POST['kategori'];
    
    $foto     = $_FILES['gambar']['name'];
    $tmp      = $_FILES['gambar']['tmp_name'];

    // Jika user mengupload foto baru
    if ($foto != "") {
        $dir = "assets/img/";
        $foto_baru = date('dmYHis') . "_" . str_replace(' ', '_', $foto);
        
        // Hapus foto lama agar folder tidak penuh sampah
        $ambil = mysqli_query($conn, "SELECT gambar FROM menu WHERE id='$id'");
        $data  = mysqli_fetch_assoc($ambil);
        if (file_exists($dir . $data['gambar'])) {
            unlink($dir . $data['gambar']);
        }

        move_uploaded_file($tmp, $dir . $foto_baru);
        $query = "UPDATE menu SET nama_menu='$nama', harga='$harga', kategori='$kategori', gambar='$foto_baru' WHERE id='$id'";
    } else {
        // Jika user TIDAK ganti foto
        $query = "UPDATE menu SET nama_menu='$nama', harga='$harga', kategori='$kategori' WHERE id='$id'";
    }

    if (mysqli_query($conn, $query)) {
        $_SESSION['pesan'] = "Menu <strong>$nama</strong> berhasil diperbarui!";
        $_SESSION['warna'] = "success";
        header("Location: admin.php");
        exit();
    }
}
?>