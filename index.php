<?php 
include 'config.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Kasir - Cafe Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        .card-menu { 
            border: none; 
            border-radius: 15px; 
            transition: transform 0.3s shadow 0.3s; 
            overflow: hidden;
        }
        .card-menu:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 10px 20px rgba(0,0,0,0.1); 
        }
        .img-container { height: 180px; overflow: hidden; }
        .img-container img { object-fit: cover; width: 100%; height: 100%; }
        .harga { color: #2ecc71; font-weight: 600; font-size: 1.1rem; }
        .badge-category { position: absolute; top: 10px; right: 10px; }
        .search-bar { border-radius: 25px; padding-left: 20px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">☕ CAFE DIGITAL</a>
        <a href="admin.php" class="btn btn-outline-light btn-sm">Mode Admin</a>
    </div>
</nav>

<div class="container">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold">Menu Katalog</h2>
            <p class="text-muted">Pilih menu favorit pelanggan hari ini.</p>
        </div>
        <div class="col-md-6">
            <form action="" method="GET">
                <div class="input-group">
                    <input type="text" name="cari" class="form-control search-bar" placeholder="Cari nama menu..." value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>">
                    <button class="btn btn-primary rounded-end-pill" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex gap-2 mb-4 overflow-auto pb-2">
        <a href="index.php" class="btn btn-white border shadow-sm rounded-pill">Semua</a>
        <a href="index.php?kat=Makanan" class="btn btn-white border shadow-sm rounded-pill">🍔 Makanan</a>
        <a href="index.php?kat=Minuman" class="btn btn-white border shadow-sm rounded-pill">🍹 Minuman</a>
        <a href="index.php?kat=Snack" class="btn btn-white border shadow-sm rounded-pill">🍿 Snack</a>
    </div>

    <div class="row">
        <?php
        // Logika Pencarian & Filter
        $where = "";
        if(isset($_GET['cari'])){
            $cari = $_GET['cari'];
            $where = " WHERE nama_menu LIKE '%$cari%'";
        }
        if(isset($_GET['kat'])){
            $kat = $_GET['kat'];
            $where = " WHERE kategori = '$kat'";
        }

        $query = mysqli_query($conn, "SELECT * FROM menu $where ORDER BY id DESC");
        
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)) :
        ?>
        <div class="col-6 col-md-4 col-lg-3 mb-4">
            <div class="card card-menu shadow-sm h-100">
                <div class="img-container position-relative">
                    <span class="badge bg-dark badge-category opacity-75"><?= $row['kategori'] ?></span>
                    <img src="assets/img/<?= $row['gambar'] ?>" alt="<?= $row['nama_menu'] ?>" onerror="this.src='https://placehold.co/400x300?text=No+Image'">
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold mb-1 text-truncate"><?= $row['nama_menu'] ?></h5>
                    <p class="harga mb-3">Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
                    <a href="keranjang.php?id=<?= $row['id']; ?>&aksi=tambah" class="btn btn-primary mt-auto rounded-pill w-100">
    + Tambah Ke Pesanan
</a>
                </div>
            </div>
        </div>
        <?php 
            endwhile; 
        } else {
            echo "<div class='col-12 text-center py-5'><h4>Menu tidak ditemukan.</h4></div>";
        }
        ?>
    </div>
</div>

<footer class="py-4 text-center text-muted">
    <p>&copy; 2026 Cafe Digital POS System</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>