<?php
// Menggunakan kredensial database cloud Neon (Singapore)
$host = getenv('DB_HOST') ?: "ep-young-brook-b3uxx070.c-4.ap-southeast-1.aws.neon.tech";
$port = getenv('DB_PORT') ?: "5432";
$db   = getenv('DB_NAME') ?: "neondb";
$user = getenv('DB_USER') ?: "neondb_owner";
$pass = getenv('DB_PASS') ?: "npg_3QveZ2ECmkgT";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db;sslmode=require", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}