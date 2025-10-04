<?php
// sidebar.php
?>
<div class="sidebar">
    <div class="logo">
        <h2>Koperasi MTS</h2>
    </div>
    <ul class="menu">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="anggota.php">Data Anggota</a></li>
        <li><a href="karyawan.php">Data Karyawan</a></li>
        <li><a href="pinjaman.php">Data Pinjaman</a></li>
        <li class="submenu">
            <a href="#">Simpanan <span class="arrow">▼</span></a>
            <ul class="submenu-items">
                <li><a href="simpanan_pokok.php">Simpanan Pokok</a></li>
                <li><a href="simpanan_wajib.php">Simpanan Wajib</a></li>
                <li><a href="simpanan_sukarela.php">Simpanan Sukarela</a></li>
            </ul>
        </li>
    </ul>
</div>