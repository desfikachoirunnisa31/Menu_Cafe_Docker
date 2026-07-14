<?php 
session_start();
include 'config.php'; 

// --- LOGIKA HITUNG STATISTIK ---
$tgl_hari_ini = date('Y-m-d');
$bulan_ini = date('m');
$tahun_ini = date('Y');

// 1. Omzet Hari Ini
$q_omzet_hari = mysqli_query($conn, "SELECT SUM(total_bayar) as omzet FROM transaksi WHERE DATE(tanggal_transaksi) = '$tgl_hari_ini'");
$d_omzet_hari = mysqli_fetch_assoc($q_omzet_hari);
$omzet_hari_ini = $d_omzet_hari['omzet'] ?? 0;

// 2. Omzet Bulan Ini
$q_omzet_bulan = mysqli_query($conn, "SELECT SUM(total_bayar) as omzet FROM transaksi WHERE MONTH(tanggal_transaksi) = '$bulan_ini' AND YEAR(tanggal_transaksi) = '$tahun_ini'");
$d_omzet_bulan = mysqli_fetch_assoc($q_omzet_bulan);
$omzet_bulan_ini = $d_omzet_bulan['omzet'] ?? 0;

// 3. Total Transaksi Hari Ini
$q_transaksi = mysqli_query($conn, "SELECT COUNT(id_transaksi) as total FROM transaksi WHERE DATE(tanggal_transaksi) = '$tgl_hari_ini'");
$d_transaksi = mysqli_fetch_assoc($q_transaksi);
$total_transaksi = $d_transaksi['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Cafe Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .card-stats { transition: transform 0.2s; border: none; cursor: pointer; }
        .card-stats:hover { transform: translateY(-5px); filter: brightness(95%); }
        .text-decoration-none:hover { color: initial; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#"><i class="bi bi-cup-hot-fill me-2"></i>Admin Cafe Digital</a>
        <div class="d-flex">
            <a href="index.php" class="btn btn-outline-light btn-sm me-2">Buka Kasir</a>
            <a href="logout.php" class="btn btn-danger btn-sm">Keluar</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <a href="laporan.php" class="text-decoration-none">
                <div class="card card-stats bg-primary text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 small">Omzet Hari Ini (Klik Detail)</h6>
                                <h3 class="fw-bold mb-0">Rp <?= number_format($omzet_hari_ini, 0, ',', '.') ?></h3>
                            </div>
                            <i class="bi bi-cash-stack fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="laporan.php" class="text-decoration-none">
                <div class="card card-stats bg-success text-white shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 small">Omzet Bulan Ini</h6>
                                <h3 class="fw-bold mb-0">Rp <?= number_format($omzet_bulan_ini, 0, ',', '.') ?></h3>
                            </div>
                            <i class="bi bi-graph-up-arrow fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card card-stats bg-warning text-dark shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-dark-50 small">Pesanan Hari Ini</h6>
                            <h3 class="fw-bold mb-0"><?= $total_transaksi ?> Transaksi</h3>
                        </div>
                        <i class="bi bi-cart-check fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold text-primary">Manajemen Daftar Menu</h5>
                    <a href="tambah.php" class="btn btn-primary btn-sm rounded-pill px-3">
                        <i class="bi bi-plus-lg"></i> Tambah Menu
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Nama Menu</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $query = mysqli_query($conn, "SELECT * FROM menu ORDER BY id DESC");
                                while($row = mysqli_fetch_assoc($query)) :
                                ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td>
                                        <img src="assets/img/<?= $row['gambar']; ?>" class="rounded shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td class="fw-bold"><?= $row['nama_menu']; ?></td>
                                    <td><span class="badge bg-secondary opacity-75"><?= $row['kategori']; ?></span></td>
                                    <td class="text-success fw-bold">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-outline-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                            <a href="proses.php?hapus=<?= $row['id']; ?>" class="btn btn-outline-danger btn-sm btn-hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php if (isset($_SESSION['pesan'])): ?>
<script>
    Swal.fire({
        icon: '<?= $_SESSION['warna']; ?>',
        title: 'Berhasil!',
        html: '<?= $_SESSION['pesan']; ?>',
        confirmButtonColor: '#0d6efd'
    });
</script>
<?php unset($_SESSION['pesan']); unset($_SESSION['warna']); endif; ?>

<script>
    // Konfirmasi Hapus
    document.querySelectorAll('.btn-hapus').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('href');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Menu yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6e7881',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    });
</script>
</body>
</html>
 