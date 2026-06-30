#!/bin/bash
# Automated test sederhana untuk MENU_CAFE
# Mengecek apakah endpoint health.php merespons dengan status 200 (OK)
# Bisa dijalankan lokal: bash tests/test.sh (setelah docker compose up -d)

set -e

URL="http://localhost:8080/health.php"

echo "Menjalankan test endpoint: $URL"

RESPONSE=$(curl -s -o /dev/null -w "%{http_code}" "$URL")

if [ "$RESPONSE" -eq 200 ]; then
  echo "✅ Test berhasil: endpoint health.php mengembalikan status 200"
  exit 0
else
  echo "❌ Test gagal: endpoint health.php mengembalikan status $RESPONSE (diharapkan 200)"
  exit 1
fi