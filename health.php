<?php
// Endpoint sederhana untuk automated testing / quality gate.
// Tidak bergantung pada koneksi database, jadi aman dipakai
// untuk memastikan container & web server berjalan dengan baik.

header('Content-Type: application/json');
echo json_encode([
    "status" => "healthy"
]);