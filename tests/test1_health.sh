#!/bin/bash
response=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:8081/)
if [ "$response" -eq 200 ]; then
  echo "PASS: App is up (status $response)"
  exit 0
else
  echo "FAIL: App returned status $response"
  exit 1
fi