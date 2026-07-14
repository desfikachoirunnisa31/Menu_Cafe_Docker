#!/bin/bash
# Automated test komprehensif untuk MENU_CAFE
# Menjalankan 3 skrip pengujian sebagai Quality Gate UAS

set -e

echo "=== MENJALANKAN PIPELINE TEST AUTOMATION ==="

echo "Mengeksekusi TEST 1: Validasi Endpoint Health..."
bash tests/test1_health.sh

echo "Mengeksekusi TEST 2: Validasi Koneksi Database..."
bash tests/test2_db_connection.sh

echo "Mengeksekusi TEST 3: Validasi Operasi CRUD (Tambah Menu)..."
bash tests/test3_add_menu.sh

echo "=== [SUCCESS] SEMUA PENGUJIAN OTOMATIS BERHASIL DILALUI ==="
exit 0