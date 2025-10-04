<?php
include 'config.php';
checkLogin();

$success = '';
$error = '';

// Tambah simpanan pokok
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah'])) {
    $id_anggota = sanitize($_POST['id_anggota']);
    $id_karyawan = sanitize($_POST['id_karyawan']);
    $jumlah = sanitize($_POST['jumlah_simpanan_pokok']);
    $tanggal = sanitize($_POST['tanggal_simpanan_pokok']);
    
    // Validasi data
    if (empty($id_anggota) || empty($id_karyawan) || empty($jumlah) || empty($tanggal)) {
        $error = "Semua field harus diisi!";
    } else {
        $sql = "INSERT INTO simpanan_pokok (id_anggota, id_karyawan, jumlah_simpanan_pokok, tanggal_simpanan_pokok) 
                VALUES ('$id_anggota', '$id_karyawan', '$jumlah', '$tanggal')";
        
        if ($conn->query($sql) === TRUE) {
            $success = "Data simpanan pokok berhasil ditambahkan!";
        } else {
            // Handle specific MySQL errors
            if ($conn->errno == 1452) {
                $error = "Data anggota atau karyawan tidak valid!";
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    }
}

// Edit simpanan pokok
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $id = sanitize($_POST['id_simpanan_pokok']);
    $id_anggota = sanitize($_POST['id_anggota']);
    $id_karyawan = sanitize($_POST['id_karyawan']);
    $jumlah = sanitize($_POST['jumlah_simpanan_pokok']);
    $tanggal = sanitize($_POST['tanggal_simpanan_pokok']);
    
    // Validasi data
    if (empty($id_anggota) || empty($id_karyawan) || empty($jumlah) || empty($tanggal)) {
        $error = "Semua field harus diisi!";
    } else {
        $sql = "UPDATE simpanan_pokok SET 
                id_anggota = '$id_anggota',
                id_karyawan = '$id_karyawan',
                jumlah_simpanan_pokok = '$jumlah',
                tanggal_simpanan_pokok = '$tanggal'
                WHERE id_simpanan_pokok = $id";
        
        if ($conn->query($sql) === TRUE) {
            $success = "Data simpanan pokok berhasil diupdate!";
        } else {
            if ($conn->errno == 1452) {
                $error = "Data anggota atau karyawan tidak valid!";
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    }
}

// Hapus simpanan pokok
if (isset($_GET['hapus'])) {
    $id = sanitize($_GET['hapus']);
    $sql = "DELETE FROM simpanan_pokok WHERE id_simpanan_pokok = $id";
    
    if ($conn->query($sql) === TRUE) {
        $success = "Data simpanan pokok berhasil dihapus!";
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Ambil data untuk edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = sanitize($_GET['edit']);
    $result = $conn->query("SELECT * FROM simpanan_pokok WHERE id_simpanan_pokok = $id");
    if ($result->num_rows == 1) {
        $edit_data = $result->fetch_assoc();
    }
}

// Ambil data simpanan pokok dengan join
$simpanan = $conn->query("
    SELECT s.*, a.nama_anggota, k.nama_karyawan 
    FROM simpanan_pokok s 
    JOIN anggota a ON s.id_anggota = a.id_anggota 
    JOIN pengurus_inti k ON s.id_karyawan = k.id_karyawan 
    ORDER BY s.id_simpanan_pokok DESC
");

// Ambil data untuk dropdown
$anggota_list = $conn->query("SELECT * FROM anggota");
$karyawan_list = $conn->query("SELECT * FROM pengurus_inti");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simpanan Pokok - Koperasi MTS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <?php include 'header.php'; ?>
            
            <div class="content">
                <h2>Simpanan Pokok</h2>
                
                <?php if ($success): ?>
                    <div class="success-message"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <div class="card">
                    <h3><?php echo $edit_data ? 'Edit Simpanan Pokok' : 'Tambah Simpanan Pokok'; ?></h3>
                    <form method="POST" action="">
                        <?php if ($edit_data): ?>
                            <input type="hidden" name="id_simpanan_pokok" value="<?php echo $edit_data['id_simpanan_pokok']; ?>">
                        <?php endif; ?>
                        
                        <div class="form-group">
                            <label for="id_anggota">Anggota:</label>
                            <select id="id_anggota" name="id_anggota" required>
                                <option value="">Pilih Anggota</option>
                                <?php while ($row = $anggota_list->fetch_assoc()): ?>
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
                                <?php while ($row = $karyawan_list->fetch_assoc()): ?>
                                <option value="<?php echo $row['id_karyawan']; ?>"
                                    <?php echo ($edit_data && $edit_data['id_karyawan'] == $row['id_karyawan']) ? 'selected' : ''; ?>>
                                    <?php echo $row['nama_karyawan']; ?>
                                </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_simpanan_pokok">Jumlah Simpanan:</label>
                            <input type="number" id="jumlah_simpanan_pokok" name="jumlah_simpanan_pokok" 
                                   value="<?php echo $edit_data ? $edit_data['jumlah_simpanan_pokok'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_simpanan_pokok">Tanggal:</label>
                            <input type="date" id="tanggal_simpanan_pokok" name="tanggal_simpanan_pokok" 
                                   value="<?php echo $edit_data ? $edit_data['tanggal_simpanan_pokok'] : ''; ?>" required>
                        </div>
                        
                        <?php if ($edit_data): ?>
                            <button type="submit" name="edit" class="btn-primary">Update Simpanan</button>
                            <a href="simpanan_pokok.php" class="btn-secondary">Batal</a>
                        <?php else: ?>
                            <button type="submit" name="tambah" class="btn-primary">Tambah Simpanan</button>
                        <?php endif; ?>
                    </form>
                </div>
                
                <div class="card">
                    <h3>Daftar Simpanan Pokok</h3>
                    <?php if ($simpanan->num_rows > 0): ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Anggota</th>
                                <th>Karyawan</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $simpanan->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id_simpanan_pokok']; ?></td>
                                <td><?php echo $row['nama_anggota']; ?></td>
                                <td><?php echo $row['nama_karyawan']; ?></td>
                                <td>Rp <?php echo number_format($row['jumlah_simpanan_pokok'], 0, ',', '.'); ?></td>
                                <td><?php echo $row['tanggal_simpanan_pokok']; ?></td>
                                <td class="action-buttons">
                                    <a href="simpanan_pokok.php?edit=<?php echo $row['id_simpanan_pokok']; ?>" 
                                       class="btn-edit">Edit</a>
                                    <a href="simpanan_pokok.php?hapus=<?php echo $row['id_simpanan_pokok']; ?>" 
                                       class="btn-danger" 
                                       onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                    <p>Belum ada data simpanan pokok.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>