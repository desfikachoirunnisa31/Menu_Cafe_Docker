<?php 
session_start();
include 'config.php'; 

// Jika keranjang kosong, arahkan kembali ke katalog
if (empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Cafe Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .card { border-radius: 15px; }
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-cart3 me-2"></i>Daftar Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Menu</th>
                                    <th>Harga</th>
                                    <th class="text-center">Jumlah</th>
                                    <th>Subtotal</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $total = 0;
                                foreach ($_SESSION['cart'] as $id => $jumlah) {
                                    $res = mysqli_query($conn, "SELECT * FROM menu WHERE id='$id'");
                                    $row = mysqli_fetch_assoc($res);
                                    $subtotal = $row['harga'] * $jumlah;
                                    $total += $subtotal;
                                ?>
                                <tr>
                                    <td>
                                        <span class="fw-bold"><?= $row['nama_menu'] ?></span><br>
                                        <small class="text-muted"><?= $row['kategori'] ?></small>
                                    </td>
                                    <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                                    <td class="text-center">
                                        <div class="btn-group border rounded">
                                            <a href="keranjang.php?id=<?= $id ?>&aksi=kurang" class="btn btn-sm btn-white">-</a>
                                            <span class="px-3 py-1 bg-white"><?= $jumlah ?></span>
                                            <a href="keranjang.php?id=<?= $id ?>&aksi=tambah" class="btn btn-sm btn-white">+</a>
                                        </div>
                                    </td>
                                    <td class="fw-bold">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                                    <td class="text-center">
                                        <a href="keranjang.php?id=<?= $id ?>&aksi=hapus" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <a href="index.php" class="btn btn-outline-primary rounded-pill">
                            <i class="bi bi-arrow-left me-1"></i> Tambah Menu Lagi
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-primary text-white">
                <div class="card-body p-4">
                    <h5 class="text-white-50">Total Pembayaran</h5>
                    <h2 class="fw-bold mb-4">Rp <?= number_format($total, 0, ',', '.') ?></h2>
                    
                    <hr class="bg-white">
                    
                    <form action="simpan_transaksi.php" method="POST" id="formBayar">
                        <input type="hidden" name="total_bayar" value="<?= $total ?>">
                        <input type="hidden" name="uang_kembali" id="input_kembali" value="0">
                        
                        <div class="mb-3">
                            <label class="form-label">Uang Tunai Pelanggan</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-0 text-primary fw-bold">Rp</span>
                                <input type="number" name="uang_bayar" id="bayar" class="form-control border-0" placeholder="0" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Kembalian</label>
                            <h3 id="kembalian" class="fw-bold text-warning">Rp 0</h3>
                        </div>

                        <button type="button" onclick="konfirmasiBayar()" class="btn btn-light btn-lg w-100 fw-bold shadow-sm rounded-pill py-3">
                            <i class="bi bi-printer me-2"></i>BAYAR & CETAK
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const total = <?= $total ?>;
    const inputBayar = document.getElementById('bayar');
    const displayKembalian = document.getElementById('kembalian');
    const hiddenKembali = document.getElementById('input_kembali');

    // Listener untuk menghitung kembalian secara real-time
    inputBayar.addEventListener('input', function() {
        let bayar = parseInt(this.value) || 0;
        let sisa = bayar - total;
        
        if (sisa >= 0) {
            displayKembalian.innerText = "Rp " + sisa.toLocaleString('id-ID');
            hiddenKembali.value = sisa;
        } else {
            displayKembalian.innerText = "Rp 0";
            hiddenKembali.value = 0;
        }
    });

    // Fungsi Validasi sebelum Submit
    function konfirmasiBayar() {
        let bayar = parseInt(inputBayar.value) || 0;

        if (bayar < total) {
            Swal.fire({
                icon: 'error',
                title: 'Uang Kurang!',
                text: 'Nominal pembayaran tidak mencukupi total belanja.',
                confirmButtonColor: '#0d6efd'
            });
        } else {
            Swal.fire({
                title: 'Konfirmasi Pembayaran',
                text: "Lanjutkan proses transaksi dan cetak struk?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6e7881',
                confirmButtonText: 'Ya, Proses!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formBayar').submit();
                }
            });
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>