<?php
include 'config.php';
checkLogin();

$success = '';
$error = '';

// Tambah pinjaman
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah'])) {
    $id_anggota = sanitize($_POST['id_anggota']);
    $id_karyawan = sanitize($_POST['id_karyawan']);
    $jumlah = sanitize($_POST['jumlah_pinjaman']);
    $tanggal = sanitize($_POST['tanggal_pinjaman']);
    $jatuh_tempo = sanitize($_POST['jatuh_tempo']);
    
    // Validasi data
    if (empty($id_anggota) || empty($id_karyawan) || empty($jumlah) || empty($tanggal) || empty($jatuh_tempo)) {
        $error = "Semua field harus diisi!";
    } else {
        $sql = "INSERT INTO pinjaman (id_anggota, id_karyawan, jumlah_pinjaman, tanggal_pinjaman, jatuh_tempo) 
                VALUES ('$id_anggota', '$id_karyawan', '$jumlah', '$tanggal', '$jatuh_tempo')";
        
        if ($conn->query($sql) === TRUE) {
            $success = "Data pinjaman berhasil ditambahkan!";
        } else {
            // Handle specific MySQL errors
            if ($conn->errno == 1062) {
                $error = "Data pinjaman untuk anggota ini sudah ada!";
            } else if ($conn->errno == 1452) {
                $error = "Data anggota atau karyawan tidak valid!";
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    }
}

// Edit pinjaman
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $id = sanitize($_POST['id_pinjaman']);
    $id_anggota = sanitize($_POST['id_anggota']);
    $id_karyawan = sanitize($_POST['id_karyawan']);
    $jumlah = sanitize($_POST['jumlah_pinjaman']);
    $tanggal = sanitize($_POST['tanggal_pinjaman']);
    $jatuh_tempo = sanitize($_POST['jatuh_tempo']);
    
    // Validasi data
    if (empty($id_anggota) || empty($id_karyawan) || empty($jumlah) || empty($tanggal) || empty($jatuh_tempo)) {
        $error = "Semua field harus diisi!";
    } else {
        $sql = "UPDATE pinjaman SET 
                id_anggota = '$id_anggota',
                id_karyawan = '$id_karyawan',
                jumlah_pinjaman = '$jumlah',
                tanggal_pinjaman = '$tanggal',
                jatuh_tempo = '$jatuh_tempo'
                WHERE id_pinjaman = $id";
        
        if ($conn->query($sql) === TRUE) {
            $success = "Data pinjaman berhasil diupdate!";
        } else {
            if ($conn->errno == 1452) {
                $error = "Data anggota atau karyawan tidak valid!";
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    }
}

// Hapus pinjaman
if (isset($_GET['hapus'])) {
    $id = sanitize($_GET['hapus']);
    $sql = "DELETE FROM pinjaman WHERE id_pinjaman = $id";
    
    if ($conn->query($sql) === TRUE) {
        $success = "Data pinjaman berhasil dihapus!";
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Ambil data untuk edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = sanitize($_GET['edit']);
    $result = $conn->query("SELECT * FROM pinjaman WHERE id_pinjaman = $id");
    if ($result->num_rows == 1) {
        $edit_data = $result->fetch_assoc();
    }
}

// Ambil data pinjaman dengan join
$pinjaman = $conn->query("
    SELECT p.*, a.nama_anggota, k.nama_karyawan 
    FROM pinjaman p 
    JOIN anggota a ON p.id_anggota = a.id_anggota 
    JOIN pengurus_inti k ON p.id_karyawan = k.id_karyawan 
    ORDER BY p.id_pinjaman DESC
");

// Ambil data untuk dropdown
$anggota = $conn->query("SELECT * FROM anggota");
$karyawan = $conn->query("SELECT * FROM pengurus_inti");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pinjaman - Koperasi MTS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <?php include 'header.php'; ?>
            
            <div class="content">
                <h2>Data Pinjaman</h2>
                
                <?php if ($success): ?>
                    <div class="success-message"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <div class="card">
                    <h3><?php echo $edit_data ? 'Edit Pinjaman' : 'Tambah Pinjaman Baru'; ?></h3>
                    <form method="POST" action="">
                        <?php if ($edit_data): ?>
                            <input type="hidden" name="id_pinjaman" value="<?php echo $edit_data['id_pinjaman']; ?>">
                        <?php endif; ?>
                        
                        <div class="form-group">
                            <label for="id_anggota">Anggota:</label>
                            <select id="id_anggota" name="id_anggota" required>
                                <option value="">Pilih Anggota</option>
                                <?php 
                                $anggota_result = $conn->query("SELECT * FROM anggota");
                                while ($row = $anggota_result->fetch_assoc()): 
                                ?>
                                <option value="<?php echo $row['id_anggota']; ?>"
                                    <?php echo ($edit_data && $edit_data['id_anggota'] == $row['id_anggota']) ? 'selected' : ''; ?>>
                                    <?php echo $row['nama_anggota']; ?>
                                </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_karyawan">Karyawan:</label>
                            <select id="id_karyawan" name="id_karyawan" required>
                                <option value="">Pilih Karyawan</option>
                                <?php 
                                $karyawan_result = $conn->query("SELECT * FROM pengurus_inti");
                                while ($row = $karyawan_result->fetch_assoc()): 
                                ?>
                                <option value="<?php echo $row['id_karyawan']; ?>"
                                    <?php echo ($edit_data && $edit_data['id_karyawan'] == $row['id_karyawan']) ? 'selected' : ''; ?>>
                                    <?php echo $row['nama_karyawan']; ?>
                                </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_pinjaman">Jumlah Pinjaman:</label>
                            <input type="number" id="jumlah_pinjaman" name="jumlah_pinjaman" 
                                   value="<?php echo $edit_data ? $edit_data['jumlah_pinjaman'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_pinjaman">Tanggal Pinjaman:</label>
                            <input type="date" id="tanggal_pinjaman" name="tanggal_pinjaman" 
                                   value="<?php echo $edit_data ? $edit_data['tanggal_pinjaman'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="jatuh_tempo">Jatuh Tempo:</label>
                            <input type="date" id="jatuh_tempo" name="jatuh_tempo" 
                                   value="<?php echo $edit_data ? $edit_data['jatuh_tempo'] : ''; ?>" required>
                        </div>
                        
                        <?php if ($edit_data): ?>
                            <button type="submit" name="edit" class="btn-primary">Update Pinjaman</button>
                            <a href="pinjaman.php" class="btn-secondary">Batal</a>
                        <?php else: ?>
                            <button type="submit" name="tambah" class="btn-primary">Tambah Pinjaman</button>
                        <?php endif; ?>
                    </form>
                </div>
                
                <div class="card">
                    <h3>Daftar Pinjaman</h3>
                    <?php if ($pinjaman->num_rows > 0): ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Anggota</th>
                                <th>Karyawan</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                                <th>Jatuh Tempo</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $pinjaman->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id_pinjaman']; ?></td>
                                <td><?php echo $row['nama_anggota']; ?></td>
                                <td><?php echo $row['nama_karyawan']; ?></td>
                                <td>Rp <?php echo number_format($row['jumlah_pinjaman'], 0, ',', '.'); ?></td>
                                <td><?php echo $row['tanggal_pinjaman']; ?></td>
                                <td><?php echo $row['jatuh_tempo']; ?></td>
                                <td class="action-buttons">
                                    <a href="pinjaman.php?edit=<?php echo $row['id_pinjaman']; ?>" 
                                       class="btn-edit">Edit</a>
                                    <a href="pinjaman.php?hapus=<?php echo $row['id_pinjaman']; ?>" 
                                       class="btn-danger" 
                                       onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <p>Belum ada data pinjaman.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>