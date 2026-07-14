#!/bin/bash
response=$(curl -s http://localhost:8081/index.php)
if echo "$response" | grep -q "Es Kopi Kenangan"; then
  echo "PASS: Database connection working, menu data found"
  exit 0
else
  echo "FAIL: Menu data not found — DB connection may be broken"
  exit 1
fi