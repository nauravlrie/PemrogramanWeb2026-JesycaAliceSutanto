<?php
// Kredensial Database Cloud Supabase (PostgreSQL)
$host = getenv('DB_HOST') ?: "aws-0-ap-northeast-1.pooler.supabase.com";
$port = getenv('DB_PORT') ?: "5432";
$db   = getenv('DB_NAME') ?: "postgres";
$user = getenv('DB_USER') ?: "postgres.kglqmrgbxumkcsxgfdzh";
$pass = getenv('DB_PASS') ?: "KATA_SANDI_SUPABASE_TOHRU";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db;sslmode=require", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}