#!/bin/bash
TIMESTAMP=$(date +%s)
MENU_NAME="TestMenu_$TIMESTAMP"

curl -s -X POST http://localhost:8081/tambah.php \
  -d "nama_menu=$MENU_NAME" \
  -d "harga=10000" \
  -d "kategori=Minuman" > /dev/null

sleep 1

response=$(curl -s http://localhost:8081/index.php)
if echo "$response" | grep -q "$MENU_NAME"; then
  echo "PASS: New menu item successfully added and retrieved"
  exit 0
else
  echo "FAIL: New menu item not found after POST"
  exit 1
fi
