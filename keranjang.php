<?php
session_start();
include 'config.php';

$id = $_GET['id'];
$aksi = $_GET['aksi'];

// Jika aksi tambah
if ($aksi == "tambah") {
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += 1; // Jika sudah ada, tambah jumlahnya
    } else {
        $_SESSION['cart'][$id] = 1; // Jika belum ada, set 1
    }
}

// Jika aksi kurang
if ($aksi == "kurang") {
    if ($_SESSION['cart'][$id] > 1) {
        $_SESSION['cart'][$id] -= 1;
    } else {
        unset($_SESSION['cart'][$id]);
    }
}

// Jika aksi hapus semua
if ($aksi == "hapus") {
    unset($_SESSION['cart'][$id]);
}

header("Location: checkout.php");
?>