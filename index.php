<?php 
include 'config.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Kasir - Cafe Digital</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-amber-50/30 text-slate-800 min-h-screen">

    <!-- NAVBAR PREMIUM HORIZONTAL -->
    <nav class="bg-slate-900 shadow-lg sticky top-0 z-50 w-full border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Kiri: Logo -->
                <div class="flex items-center gap-2">
                    <span class="text-xl font-bold text-amber-500 tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-mug-hot"></i> CAFE DIGITAL
                    </span>
                </div>
                <!-- Kanan: Navigasi Menu -->
                <div class="flex items-center gap-4">
                    <a href="keranjang.php" class="text-slate-300 hover:text-amber-500 transition-colors p-2 flex items-center gap-1 bg-slate-800 rounded-xl px-4 py-2 border border-slate-700/50">
                        <i class="fa-solid fa-shopping-basket text-amber-500"></i>
                        <span class="text-xs font-medium">Keranjang Belanja</span>
                    </a>
                    <a href="admin.php" class="px-4 py-2 rounded-xl border border-amber-500 text-amber-500 hover:bg-amber-500 hover:text-slate-900 font-semibold text-xs transition-all duration-300">
                        <i class="fa-solid fa-user-gear mr-1"></i> Mode Admin
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- KONTEN UTAMA HALAMAN -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        
        <!-- Bar Pencarian & Judul -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">Menu Katalog</h2>
                <p class="text-sm text-slate-500 mt-1">Pilih menu favorit pelanggan hari ini.</p>
            </div>
            
            <div class="w-full md:max-w-md">
                <form action="" method="GET" class="relative flex items-center w-full">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input type="text" name="cari" 
                           class="w-full pl-11 pr-24 py-2.5 bg-white border border-slate-200 rounded-full text-sm shadow-sm placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all" 
                           placeholder="Cari nama menu..." 
                           value="<?= isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : '' ?>">
                    <button type="submit" class="absolute right-1.5 top-1.5 bottom-1.5 bg-amber-600 hover:bg-amber-700 text-white font-medium text-xs px-5 rounded-full transition-colors shadow-sm">
                        Cari
                    </button>
                </form>
            </div>
        </div>

        <!-- Filter Kategori Kapsul -->
        <div class="flex gap-2 mb-8 overflow-x-auto pb-2 scrollbar-hide">
            <a href="index.php" class="px-5 py-2 whitespace-nowrap bg-white text-slate-700 font-medium text-sm rounded-full border border-slate-200 shadow-sm hover:border-amber-500 hover:text-amber-600 transition-all">
                Semua
            </a>
            <a href="index.php?kat=Makanan" class="px-5 py-2 whitespace-nowrap bg-white text-slate-700 font-medium text-sm rounded-full border border-slate-200 shadow-sm hover:border-amber-500 hover:text-amber-600 transition-all">
                🍔 Makanan
            </a>
            <a href="index.php?kat=Minuman" class="px-5 py-2 whitespace-nowrap bg-white text-slate-700 font-medium text-sm rounded-full border border-slate-200 shadow-sm hover:border-amber-500 hover:text-amber-600 transition-all">
                🍹 Minuman
            </a>
            <a href="index.php?kat=Snack" class="px-5 py-2 whitespace-nowrap bg-white text-slate-700 font-medium text-sm rounded-full border border-slate-200 shadow-sm hover:border-amber-500 hover:text-amber-600 transition-all">
                🍿 Snack
            </a>
        </div>

        <!-- Grid Menu Produk Premium -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php
            $where = "";
            if(isset($_GET['cari'])){
                $cari = mysqli_real_escape_string($conn, $_GET['cari']);
                $where = " WHERE nama_menu LIKE '%$cari%'";
            }
            if(isset($_GET['kat'])){
                $kat = mysqli_real_escape_string($conn, $_GET['kat']);
                $where = " WHERE kategori = '$kat'";
            }

            $query = mysqli_query($conn, "SELECT * FROM menu $where ORDER BY id DESC");
            
            if(mysqli_num_rows($query) > 0){
                while($row = mysqli_fetch_assoc($query)) :
                    // Penentuan placeholder dinamis berdasarkan kategori jika file gambar tidak terbaca
                    $fallback_text = urlencode($row['nama_menu']);
                    $placeholder = "https://placehold.co/500x400/f8fafc/64748b?text=" . $fallback_text;
            ?>
            <div class="bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between overflow-hidden relative group">
                
                <!-- Tag Kategori Mini -->
                <span class="absolute top-3 right-3 bg-slate-900/80 backdrop-blur-sm text-white text-[10px] font-semibold px-2.5 py-1 rounded-full z-10 tracking-wider">
                    <?= $row['kategori'] ?>
                </span>
                
                <!-- Kontainer Gambar -->
                <div class="w-full h-48 bg-slate-100 overflow-hidden relative">
                <img src="assets/img/<?php echo $row['gambar']; ?>" 
                    alt="<?php echo $row['nama_menu']; ?>" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                 onerror="this.src='https://placehold.co/500x400/f8fafc/64748b?text=<?php echo urlencode($row['nama_menu']); ?>'">
                </div>
                
                <!-- Detail Menu & Tombol Beli -->
                <div class="p-5 flex flex-col flex-grow">
                    <h5 class="text-base font-bold text-slate-800 tracking-tight line-clamp-1 mb-1">
                        <?= $row['nama_menu'] ?>
                    </h5>
                    <p class="text-emerald-600 font-bold text-sm mb-4">
                        Rp <?= number_format($row['harga'], 0, ',', '.') ?>
                    </p>
                    
                    <a href="keranjang.php?id=<?php echo $row['id']; ?>&aksi=tambah" 
                       class="w-full mt-auto py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-semibold text-xs rounded-xl transition-colors shadow-md inline-flex items-center justify-center gap-2">
                        <i class="fa-solid fa-plus text-[10px]"></i> Tambah Ke Pesanan
                    </a>
                </div>
            </div>
            <?php 
                endwhile; 
            } else {
                echo "
                <div class='col-span-full text-center py-16 flex flex-col items-center justify-center bg-white rounded-2xl border border-dashed border-slate-200 shadow-sm'>
                    <i class='fa-solid fa-bowl-food text-slate-300 text-4xl mb-3'></i>
                    <h4 class='text-slate-600 font-medium'>Menu tidak ditemukan.</h4>
                    <p class='text-xs text-slate-400 mt-0.5'>Coba gunakan kata kunci pencarian yang lain.</p>
                </div>";
            }
            ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-100 py-6 text-center text-xs text-slate-400 mt-12 w-full">
        <p>&copy; 2026 Cafe Digital POS System</p>
    </footer>

</body>
</html>