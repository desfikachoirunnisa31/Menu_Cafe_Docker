<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Tambah Menu</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h4 class="mb-4 text-center">Tambah Menu Baru</h4>
                        <form action="proses.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Nama Menu</label>
                                <input type="text" name="nama_menu" class="form-control" placeholder="Contoh: Espresso" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga (Rupiah)</label>
                                <input type="number" name="harga" class="form-control" placeholder="15000" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="kategori" class="form-select">
                                    <option value="Makanan">Makanan</option>
                                    <option value="Minuman">Minuman</option>
                                     <option value="Snack">Snack</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Upload Gambar Produk</label>
                                <input type="file" name="gambar" class="form-control" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" name="tambah" class="btn btn-primary">Simpan Produk</button>
                                <a href="admin.php" class="btn btn-light">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>