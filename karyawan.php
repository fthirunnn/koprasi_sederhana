<?php
include 'config.php';
checkLogin();

$success = '';
$error = '';

// Tambah karyawan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah'])) {
    $nama = sanitize($_POST['nama_karyawan']);
    $alamat = sanitize($_POST['alamat']);
    $no_telp = sanitize($_POST['no_telp_karyawan']);
    
    $sql = "INSERT INTO pengurus_inti (nama_karyawan, alamat, no_telp_karyawan) 
            VALUES ('$nama', '$alamat', '$no_telp')";
    
    if ($conn->query($sql) === TRUE) {
        $success = "Data karyawan berhasil ditambahkan!";
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Edit karyawan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $id = sanitize($_POST['id_karyawan']);
    $nama = sanitize($_POST['nama_karyawan']);
    $alamat = sanitize($_POST['alamat']);
    $no_telp = sanitize($_POST['no_telp_karyawan']);
    
    $sql = "UPDATE pengurus_inti SET 
            nama_karyawan = '$nama', 
            alamat = '$alamat', 
            no_telp_karyawan = '$no_telp' 
            WHERE id_karyawan = $id";
    
    if ($conn->query($sql) === TRUE) {
        $success = "Data karyawan berhasil diupdate!";
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Hapus karyawan
if (isset($_GET['hapus'])) {
    $id = sanitize($_GET['hapus']);
    $sql = "DELETE FROM pengurus_inti WHERE id_karyawan = $id";
    
    if ($conn->query($sql) === TRUE) {
        $success = "Data karyawan berhasil dihapus!";
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Ambil data untuk edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = sanitize($_GET['edit']);
    $result = $conn->query("SELECT * FROM pengurus_inti WHERE id_karyawan = $id");
    if ($result->num_rows == 1) {
        $edit_data = $result->fetch_assoc();
    }
}

// Ambil data karyawan
$karyawan = $conn->query("SELECT * FROM pengurus_inti ORDER BY id_karyawan DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan - Koperasi MTS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <?php include 'header.php'; ?>
            
            <div class="content">
                <h2>Data Karyawan</h2>
                
                <?php if ($success): ?>
                    <div class="success-message"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <div class="card">
                    <h3><?php echo $edit_data ? 'Edit Karyawan' : 'Tambah Karyawan Baru'; ?></h3>
                    <form method="POST" action="">
                        <?php if ($edit_data): ?>
                            <input type="hidden" name="id_karyawan" value="<?php echo $edit_data['id_karyawan']; ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="id_karyawan">ID Karyawan:</label>
                            <input type="text" id="id_karyawan" name="id_karyawan" 
                                   value="<?php echo $edit_data ? $edit_data['id_karyawan'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_karyawan">Nama Karyawan:</label>
                            <input type="text" id="nama_karyawan" name="nama_karyawan" 
                                   value="<?php echo $edit_data ? $edit_data['nama_karyawan'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat:</label>
                            <textarea id="alamat" name="alamat" required><?php echo $edit_data ? $edit_data['alamat'] : ''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="no_telp_karyawan">No. Telepon:</label>
                            <input type="number" id="no_telp_karyawan" name="no_telp_karyawan" 
                                   value="<?php echo $edit_data ? $edit_data['no_telp_karyawan'] : ''; ?>" required>
                        </div>
                        
                        <?php if ($edit_data): ?>
                            <button type="submit" name="edit" class="btn-primary">Update Karyawan</button>
                            <a href="karyawan.php" class="btn-secondary">Batal</a>
                        <?php else: ?>
                            <button type="submit" name="tambah" class="btn-primary">Tambah Karyawan</button>
                        <?php endif; ?>
                    </form>
                </div>
                
                <div class="card">
                    <h3>Daftar Karyawan</h3>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No. Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $karyawan->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id_karyawan']; ?></td>
                                <td><?php echo $row['nama_karyawan']; ?></td>
                                <td><?php echo $row['alamat']; ?></td>
                                <td><?php echo $row['no_telp_karyawan']; ?></td>
                                <td class="action-buttons">
                                    <a href="karyawan.php?edit=<?php echo $row['id_karyawan']; ?>" 
                                       class="btn-edit">Edit</a>
                                    <a href="karyawan.php?hapus=<?php echo $row['id_karyawan']; ?>" 
                                       class="btn-danger" 
                                       onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>