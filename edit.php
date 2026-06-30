<?php 
session_start();
include 'config.php';

// Ambil ID dari URL
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM menu WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (mysqli_num_rows($query) < 1) {
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Menu - Cafe Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-warning text-dark py-3">
                        <h5 class="m-0 fw-bold">Edit Menu Produk</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="proses.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $data['id']; ?>">

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Menu</label>
                                <input type="text" name="nama_menu" class="form-control" value="<?= $data['nama_menu']; ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Harga (Rp)</label>
                                <input type="number" name="harga" class="form-control" value="<?= $data['harga']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Kategori</label>
                                <select name="kategori" class="form-select">
                                    <option value="Makanan" <?= ($data['kategori'] == 'Makanan') ? 'selected' : ''; ?>>Makanan</option>
                                    <option value="Minuman" <?= ($data['kategori'] == 'Minuman') ? 'selected' : ''; ?>>Minuman</option>
                                    <option value="Snack" <?= ($data['kategori'] == 'Snack') ? 'selected' : ''; ?>>Snack</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Foto Saat Ini</label><br>
                                <img src="assets/img/<?= $data['gambar']; ?>" width="120" class="rounded shadow-sm mb-2">
                                <input type="file" name="gambar" class="form-control">
                                <small class="text-muted">*Kosongkan jika tidak ingin mengganti foto</small>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" name="edit" class="btn btn-warning fw-bold">Simpan Perubahan</button>
                                <a href="admin.php" class="btn btn-light border">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>