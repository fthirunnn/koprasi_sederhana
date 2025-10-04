-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Okt 2025 pada 14.17
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `koeperasi_mts`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(9) NOT NULL,
  `nama_anggota` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `no_telp_anggota` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengurus_inti`
--

CREATE TABLE `pengurus_inti` (
  `id_karyawan` int(9) NOT NULL,
  `nama_karyawan` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `no_telp_karyawan` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pinjaman`
--

CREATE TABLE `pinjaman` (
  `id_pinjaman` int(9) NOT NULL,
  `id_anggota` int(9) NOT NULL,
  `id_karyawan` int(9) NOT NULL,
  `jumlah_pinjaman` int(12) NOT NULL,
  `tanggal_pinjaman` date NOT NULL,
  `jatuh_tempo` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `simpanan_pokok`
--

CREATE TABLE `simpanan_pokok` (
  `id_simpanan_pokok` int(9) NOT NULL,
  `id_anggota` int(9) NOT NULL,
  `id_karyawan` int(9) NOT NULL,
  `jumlah_simpanan_pokok` int(12) NOT NULL,
  `tanggal_simpanan_pokok` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `simpanan_sukarela`
--

CREATE TABLE `simpanan_sukarela` (
  `id_simpanan_sukarela` int(9) NOT NULL,
  `id_anggota` int(9) NOT NULL,
  `id_karyawan` int(9) NOT NULL,
  `jumlah_simpanan_sukarela` int(12) NOT NULL,
  `tanggal_simpanan_sukarela` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `simpanan_wajib`
--

CREATE TABLE `simpanan_wajib` (
  `id_simpanan_wajib` int(9) NOT NULL,
  `id_anggota` int(9) NOT NULL,
  `id_karyawan` int(9) NOT NULL,
  `jumlah_simpanan_wajib` int(12) NOT NULL,
  `tanggal_simpanan_wajib` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(9) NOT NULL,
  `id_admin` tinyint(1) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`);

--
-- Indeks untuk tabel `pengurus_inti`
--
ALTER TABLE `pengurus_inti`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indeks untuk tabel `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD PRIMARY KEY (`id_pinjaman`),
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- Indeks untuk tabel `simpanan_pokok`
--
ALTER TABLE `simpanan_pokok`
  ADD PRIMARY KEY (`id_simpanan_pokok`),
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- Indeks untuk tabel `simpanan_sukarela`
--
ALTER TABLE `simpanan_sukarela`
  ADD PRIMARY KEY (`id_simpanan_sukarela`),
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- Indeks untuk tabel `simpanan_wajib`
--
ALTER TABLE `simpanan_wajib`
  ADD PRIMARY KEY (`id_simpanan_wajib`),
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengurus_inti`
--
ALTER TABLE `pengurus_inti`
  MODIFY `id_karyawan` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pinjaman`
--
ALTER TABLE `pinjaman`
  MODIFY `id_pinjaman` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `simpanan_pokok`
--
ALTER TABLE `simpanan_pokok`
  MODIFY `id_simpanan_pokok` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `simpanan_sukarela`
--
ALTER TABLE `simpanan_sukarela`
  MODIFY `id_simpanan_sukarela` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `simpanan_wajib`
--
ALTER TABLE `simpanan_wajib`
  MODIFY `id_simpanan_wajib` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(9) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD CONSTRAINT `pinjaman_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `pengurus_inti` (`id_karyawan`) ON DELETE CASCADE,
  ADD CONSTRAINT `pinjaman_ibfk_2` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `simpanan_pokok`
--
ALTER TABLE `simpanan_pokok`
  ADD CONSTRAINT `simpanan_pokok_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `pengurus_inti` (`id_karyawan`) ON DELETE CASCADE,
  ADD CONSTRAINT `simpanan_pokok_ibfk_2` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `simpanan_sukarela`
--
ALTER TABLE `simpanan_sukarela`
  ADD CONSTRAINT `simpanan_sukarela_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `pengurus_inti` (`id_karyawan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `simpanan_sukarela_ibfk_2` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `simpanan_wajib`
--
ALTER TABLE `simpanan_wajib`
  ADD CONSTRAINT `simpanan_wajib_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `pengurus_inti` (`id_karyawan`) ON DELETE CASCADE,
  ADD CONSTRAINT `simpanan_wajib_ibfk_2` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;