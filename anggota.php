<?php
include 'config.php';
checkLogin();

$success = '';
$error = '';

// Tambah anggota
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah'])) {
    $nama = sanitize($_POST['nama_anggota']);
    $alamat = sanitize($_POST['alamat']);
    $no_telp = sanitize($_POST['no_telp_anggota']);
    
    $sql = "INSERT INTO anggota (nama_anggota, alamat, no_telp_anggota) 
            VALUES ('$nama', '$alamat', '$no_telp')";
    
    if ($conn->query($sql) === TRUE) {
        $success = "Data anggota berhasil ditambahkan!";
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Edit anggota
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $id = sanitize($_POST['id_anggota']);
    $nama = sanitize($_POST['nama_anggota']);
    $alamat = sanitize($_POST['alamat']);
    $no_telp = sanitize($_POST['no_telp_anggota']);
    
    $sql = "UPDATE anggota SET 
            nama_anggota = '$nama', 
            alamat = '$alamat', 
            no_telp_anggota = '$no_telp' 
            WHERE id_anggota = $id";
    
    if ($conn->query($sql) === TRUE) {
        $success = "Data anggota berhasil diupdate!";
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Hapus anggota
if (isset($_GET['hapus'])) {
    $id = sanitize($_GET['hapus']);
    $sql = "DELETE FROM anggota WHERE id_anggota = $id";
    
    if ($conn->query($sql) === TRUE) {
        $success = "Data anggota berhasil dihapus!";
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Ambil data untuk edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = sanitize($_GET['edit']);
    $result = $conn->query("SELECT * FROM anggota WHERE id_anggota = $id");
    if ($result->num_rows == 1) {
        $edit_data = $result->fetch_assoc();
    }
}

// Ambil data anggota
$anggota = $conn->query("SELECT * FROM anggota ORDER BY id_anggota DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota - Koperasi MTS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <?php include 'header.php'; ?>
            
            <div class="content">
                <h2>Data Anggota</h2>
                
                <?php if ($success): ?>
                    <div class="success-message"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <?php if ($error): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <div class="card">
                    <h3><?php echo $edit_data ? 'Edit Anggota' : 'Tambah Anggota Baru'; ?></h3>
                    <form method="POST" action="">
                        <?php if ($edit_data): ?>
                            <input type="hidden" name="id_anggota" value="<?php echo $edit_data['id_anggota']; ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="id_anggota">ID Anggota:</label>
                            <input type="text" id="id_anggota" name="id_anggota" 
                                   value="<?php echo $edit_data ? $edit_data['id_anggota'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_anggota">Nama Anggota:</label>
                            <input type="text" id="nama_anggota" name="nama_anggota" 
                                   value="<?php echo $edit_data ? $edit_data['nama_anggota'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat:</label>
                            <textarea id="alamat" name="alamat" required><?php echo $edit_data ? $edit_data['alamat'] : ''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="no_telp_anggota">No. Telepon:</label>
                            <input type="number" id="no_telp_anggota" name="no_telp_anggota" 
                                   value="<?php echo $edit_data ? $edit_data['no_telp_anggota'] : ''; ?>" required>
                        </div>
                        
                        <?php if ($edit_data): ?>
                            <button type="submit" name="edit" class="btn-primary">Update Anggota</button>
                            <a href="anggota.php" class="btn-secondary">Batal</a>
                        <?php else: ?>
                            <button type="submit" name="tambah" class="btn-primary">Tambah Anggota</button>
                        <?php endif; ?>
                    </form>
                </div>
                
                <div class="card">
                    <h3>Daftar Anggota</h3>
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
                            <?php while ($row = $anggota->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id_anggota']; ?></td>
                                <td><?php echo $row['nama_anggota']; ?></td>
                                <td><?php echo $row['alamat']; ?></td>
                                <td><?php echo $row['no_telp_anggota']; ?></td>
                                <td class="action-buttons">
                                    <a href="anggota.php?edit=<?php echo $row['id_anggota']; ?>" 
                                       class="btn-edit">Edit</a>
                                    <a href="anggota.php?hapus=<?php echo $row['id_anggota']; ?>" 
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