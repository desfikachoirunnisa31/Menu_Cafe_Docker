<?php
include 'config.php';

// Pastikan ID ada di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID Transaksi tidak ditemukan.");
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Ambil data transaksi
$query = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_transaksi = '$id'");
$t = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan di database
if (!$t) {
    die("Data transaksi tidak ditemukan di database. Cek apakah ID: $id benar-benar masuk ke tabel transaksi.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Struk - <?= $id ?></title>
    <style>
        body { 
            font-family: 'Courier New', Courier, monospace; 
            width: 300px; 
            margin: 0 auto; 
            padding: 20px;
            color: #000;
        }
        .text-center { text-align: center; }
        hr { border-top: 1px dashed #000; }
        table { width: 100%; font-size: 14px; }
        .footer { margin-top: 20px; font-size: 12px; }
        
        /* Menghilangkan header/footer browser saat cetak */
        @media print {
            @page { margin: 0; }
            body { margin: 1.6cm; }
        }
    </style>
</head>
<body onload="window.print(); setTimeout(function(){ window.location.href = 'index.php'; }, 2000);">
    <div class="text-center">
        <h3 style="margin-bottom: 5px;">CAFE DIGITAL</h3>
        <p style="margin: 0;">Jl. Sudirman No. 123</p>
        <p style="margin: 5px 0;"><?= date('d/m/Y H:i', strtotime($t['tanggal_transaksi'])) ?></p>
        <p style="margin: 0;">ID: #<?= $id ?></p>
    </div>
    <hr>
    <table>
        <?php
        // Query detail dengan Join ke tabel menu
        $detail = mysqli_query($conn, "SELECT d.*, m.nama_menu FROM detail_transaksi d JOIN menu m ON d.id_menu = m.id WHERE d.id_transaksi = '$id'");
        
        if (mysqli_num_rows($detail) == 0) {
            echo "<tr><td colspan='2' class='text-center'>Detail item kosong</td></tr>";
        }

        while($d = mysqli_fetch_assoc($detail)){
            echo "<tr>
                    <td>{$d['nama_menu']}<br><small>{$d['jumlah']} x ".number_format($d['subtotal']/$d['jumlah'])."</small></td>
                    <td align='right' valign='top'>".number_format($d['subtotal'])."</td>
                  </tr>";
        }
        ?>
    </table>
    <hr>
    <table>
        <tr><td><strong>TOTAL</strong></td><td align='right'><strong>Rp <?= number_format($t['total_bayar']) ?></strong></td></tr>
        <tr><td>BAYAR</td><td align='right'>Rp <?= number_format($t['uang_bayar']) ?></td></tr>
        <tr style="color: red;"><td>KEMBALI</td><td align='right'>Rp <?= number_format($t['uang_kembali']) ?></td></tr>
    </table>
    <hr>
    <div class="text-center footer">
        <p>Terima Kasih Atas Kunjungan Anda!</p>
        <p>Barang yang sudah dibeli<br>tidak dapat ditukar/dikembalikan.</p>
    </div>
</body>
</html>