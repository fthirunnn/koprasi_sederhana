<?php
include 'config.php';
checkLogin();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Koperasi MTS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <?php include 'header.php'; ?>
            
            <div class="content">
                <h2>Dashboard Koperasi MTS</h2>
                <div class="dashboard-cards">
                    <div class="card">
                        <h3>Total Anggota</h3>
                        <p>
                            <?php
                            $result = $conn->query("SELECT COUNT(*) as total FROM anggota");
                            $row = $result->fetch_assoc();
                            echo $row['total'];
                            ?>
                        </p>
                    </div>
                    <div class="card">
                        <h3>Total Karyawan</h3>
                        <p>
                            <?php
                            $result = $conn->query("SELECT COUNT(*) as total FROM pengurus_inti");
                            echo $result->fetch_assoc()['total'];
                            ?>
                        </p>
                    </div>
                    <div class="card">
                        <h3>Total Pinjaman</h3>
                        <p>
                            <?php
                            $result = $conn->query("SELECT SUM(jumlah_pinjaman) as total FROM pinjaman");
                            $total = $result->fetch_assoc()['total'];
                            echo $total ? 'Rp ' . number_format($total, 0, ',', '.') : 'Rp 0';
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>