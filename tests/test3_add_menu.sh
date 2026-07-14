#!/bin/bash
TIMESTAMP=$(date +%s)
MENU_NAME="TestMenu_$TIMESTAMP"

# Create a temporary test image
echo "test" > /tmp/test_image.jpg

curl -s -X POST http://localhost:8081/proses.php \
  -F "nama_menu=$MENU_NAME" \
  -F "harga=10000" \
  -F "kategori=Minuman" \
  -F "gambar=@/tmp/test_image.jpg" \
  -F "tambah=1" > /dev/null

sleep 1

response=$(curl -s http://localhost:8081/index.php)
if echo "$response" | grep -q "$MENU_NAME"; then
  echo "PASS: New menu item successfully added and retrieved"
  exit 0
else
  echo "FAIL: New menu item not found after POST"
  exit 1
fi