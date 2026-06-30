<?php
session_start();
include 'config.php';

// Pastikan session cart ada dan data pembayaran terkirim dari checkout.php
if (isset($_POST['total_bayar']) && !empty($_SESSION['cart'])) {
    
    // Ambil dan bersihkan data dari POST untuk keamanan
    $total_bayar   = mysqli_real_escape_string($conn, $_POST['total_bayar']);
    $uang_bayar    = mysqli_real_escape_string($conn, $_POST['uang_bayar']);
    $uang_kembali  = mysqli_real_escape_string($conn, $_POST['uang_kembali']);
    $tanggal       = date('Y-m-d H:i:s');

    // 1. Simpan ke tabel transaksi (Data Utama/Header)
    $query_transaksi = "INSERT INTO transaksi (tanggal_transaksi, total_bayar, uang_bayar, uang_kembali) 
                        VALUES ('$tanggal', '$total_bayar', '$uang_bayar', '$uang_kembali')";
    
    if (mysqli_query($conn, $query_transaksi)) {
        // Ambil ID transaksi yang baru saja digenerate oleh database
        $id_transaksi = mysqli_insert_id($conn); 

        // 2. Simpan detail barang (Looping melalui isi keranjang belanja)
        foreach ($_SESSION['cart'] as $id_menu => $jumlah) {
            
            // Ambil harga terbaru dari database untuk memastikan validitas data
            $res_menu = mysqli_query($conn, "SELECT harga FROM menu WHERE id = '$id_menu'");
            $data_menu = mysqli_fetch_assoc($res_menu);
            
            if ($data_menu) {
                $harga = $data_menu['harga'];
                $subtotal = $harga * $jumlah;

                // Masukkan data ke tabel detail_transaksi
                $q_detail = "INSERT INTO detail_transaksi (id_transaksi, id_menu, jumlah, subtotal) 
                             VALUES ('$id_transaksi', '$id_menu', '$jumlah', '$subtotal')";
                
                if(!mysqli_query($conn, $q_detail)) {
                    // Jika gagal simpan detail, hentikan proses dan tampilkan pesan error
                    die("Gagal simpan detail transaksi: " . mysqli_error($conn));
                }
            }
        }

        // 3. Kosongkan keranjang setelah transaksi berhasil disimpan sepenuhnya
        unset($_SESSION['cart']);

        // 4. Arahkan ke halaman cetak struk dengan membawa ID transaksi
        header("Location: cetak.php?id=" . $id_transaksi);
        exit();
        
    } else {
        // Tampilkan pesan error jika penyimpanan data utama gagal
        die("Gagal simpan transaksi utama: " . mysqli_error($conn));
    }
} else {
    // Jika mencoba akses langsung atau data tidak valid, kembalikan ke index
    header("Location: index.php");
    exit();
}
?>