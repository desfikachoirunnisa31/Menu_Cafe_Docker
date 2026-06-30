<?php 
session_start();
include 'config.php'; 

// Default filter tanggal (hari ini)
$tgl_mulai = isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : date('Y-m-d');
$tgl_selesai = isset($_GET['tgl_selesai']) ? $_GET['tgl_selesai'] : date('Y-m-d');

// Query ambil data transaksi detail
$query = mysqli_query($conn, "SELECT t.*, GROUP_CONCAT(m.nama_menu SEPARATOR ', ') as list_menu 
    FROM transaksi t 
    JOIN detail_transaksi d ON t.id_transaksi = d.id_transaksi
    JOIN menu m ON d.id_menu = m.id
    WHERE DATE(t.tanggal_transaksi) BETWEEN '$tgl_mulai' AND '$tgl_selesai'
    GROUP BY t.id_transaksi 
    ORDER BY t.tanggal_transaksi DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Detail Omzet - Cafe Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4><i class="bi bi-file-earmark-bar-graph me-2"></i>Laporan Omzet Detail</h4>
        <a href="admin.php" class="btn btn-secondary btn-sm">Kembali ke Dashboard</a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Dari Tanggal</label>
                    <input type="date" name="tgl_mulai" class="form-control" value="<?= $tgl_mulai ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Sampai Tanggal</label>
                    <input type="date" name="tgl_selesai" class="form-control" value="<?= $tgl_selesai ?>">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-filter"></i> Filter</button>
                    <button type="button" onclick="exportExcel()" class="btn btn-success"><i class="bi bi-file-earmark-excel"></i> Unduh Excel</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle" id="tabelLaporan">
                    <thead class="table-dark">
                        <tr>
                            <th>Waktu</th>
                            <th>ID Transaksi</th>
                            <th>Menu yang Dibeli</th>
                            <th>Total Bayar</th>
                            <th>Tunai</th>
                            <th>Kembalian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $grand_total = 0;
                        while($row = mysqli_fetch_assoc($query)): 
                            $grand_total += $row['total_bayar'];
                        ?>
                        <tr>
                            <td><?= date('d/m/Y H:i', strtotime($row['tanggal_transaksi'])) ?></td>
                            <td>#<?= $row['id_transaksi'] ?></td>
                            <td><small><?= $row['list_menu'] ?></small></td>
                            <td class="fw-bold">Rp <?= number_format($row['total_bayar'], 0, ',', '.') ?></td>
                            <td>Rp <?= number_format($row['uang_bayar'], 0, ',', '.') ?></td>
                            <td>Rp <?= number_format($row['uang_kembali'], 0, ',', '.') ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="3" class="text-end">TOTAL OMZET PERIODE INI:</td>
                            <td colspan="3" class="text-primary fs-5">Rp <?= number_format($grand_total, 0, ',', '.') ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/table2excel@1.0.4/dist/table2excel.min.js"></script>
<script>
    function exportExcel() {
        var table2excel = new Table2excel();
        table2excel.export(document.querySelectorAll("#tabelLaporan"), "Laporan_Omzet_Cafe");
    }
</script>

</body>
</html>