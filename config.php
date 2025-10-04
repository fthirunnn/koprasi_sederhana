<?php
session_start();

// Konfigurasi database
$host = "127.0.0.1";
$username = "root";
$password = "";
$database = "koeprasi_mts";

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");

// Fungsi untuk mencegah SQL injection
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(strip_tags(trim($data))));
}

// Cek apakah user sudah login
function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

// Fungsi untuk handle database errors
function handleDatabaseError($conn, $message) {
    error_log("Database Error: " . $conn->error);
    return "Terjadi kesalahan sistem. Silakan coba lagi.";
}
?>