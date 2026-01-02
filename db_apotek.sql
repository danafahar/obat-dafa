-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Des 2025 pada 16.21
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
-- Database: `db_apotek`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_login`
--

CREATE TABLE `tbl_login` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `level` enum('admin','user','operator') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_login`
--

INSERT INTO `tbl_login` (`id`, `username`, `password`, `nama_lengkap`, `level`) VALUES
(20, 'tahu12@gmail.com', '9dff9b72881cd1d1e87e1940c0aa2bed', 'dafa', 'admin'),
(21, 'danafahar25@gmail.com', '15330ee5358a3208379f56f49ff05541', 'Dana Fahar Arya Putra', 'admin'),
(22, 'qilla06', '13f5341ee3fa1dab498f828914bd7185', 'Qilla', 'operator');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_obat`
--

CREATE TABLE `tbl_obat` (
  `id_obat` int(11) NOT NULL,
  `kode_obat` varchar(100) NOT NULL,
  `merek_obat` varchar(100) NOT NULL,
  `jenis_obat` enum('Generik','Paten') NOT NULL,
  `tanggal_masuk` varchar(11) NOT NULL,
  `exp` varchar(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_obat`
--

INSERT INTO `tbl_obat` (`id_obat`, `kode_obat`, `merek_obat`, `jenis_obat`, `tanggal_masuk`, `exp`, `created_at`) VALUES
(5, '11', 'Migra', 'Paten', '2026-01-09', '2025-12-26', '2025-12-07 17:08:01'),
(6, 'OBT02', 'Paramex', 'Paten', '2025-12-01', '2025-12-31', '2025-12-08 08:39:20'),
(8, 'OBT1', 'Antangin', 'Generik', '2025-12-11', '2026-12-12', '2025-12-11 09:48:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_obat_rusak`
--

CREATE TABLE `tbl_obat_rusak` (
  `id_rusak` int(11) NOT NULL,
  `id_obat` int(11) NOT NULL,
  `jumlah_rusak` int(11) NOT NULL,
  `alasan_rusak` enum('Kadaluarsa','Kemasan Rusak','Terkena Air','Cacat Produksi','Lainnya') NOT NULL,
  `tanggal_rusak` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_obat_rusak`
--

INSERT INTO `tbl_obat_rusak` (`id_rusak`, `id_obat`, `jumlah_rusak`, `alasan_rusak`, `tanggal_rusak`, `keterangan`, `id_user`, `created_at`) VALUES
(7, 5, 100, 'Kemasan Rusak', '2025-12-10', 'tijjj', 21, '2025-12-10 16:42:48'),
(8, 5, 10, 'Cacat Produksi', '2025-12-11', 'HHAHHAHHAHA', 21, '2025-12-11 07:00:19'),
(9, 6, 100, 'Kadaluarsa', '2025-12-11', 'JELEK', 21, '2025-12-11 09:05:37'),
(10, 6, 500, 'Kadaluarsa', '2025-12-11', 'jjjj', 21, '2025-12-11 09:32:41'),
(11, 8, 5, 'Kadaluarsa', '2025-12-11', 'ygyyuy', 21, '2025-12-11 09:49:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_stok_obat`
--

CREATE TABLE `tbl_stok_obat` (
  `id_stok` int(11) NOT NULL,
  `id_obat` int(11) NOT NULL,
  `jumlah_stok` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_stok_obat`
--

INSERT INTO `tbl_stok_obat` (`id_stok`, `id_obat`, `jumlah_stok`, `harga_beli`, `harga_jual`) VALUES
(4, 5, 190, 3200, 3000),
(5, 6, 400, 1000, 20000),
(7, 8, 5, 10, 10);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_login`
--
ALTER TABLE `tbl_login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `tbl_obat`
--
ALTER TABLE `tbl_obat`
  ADD PRIMARY KEY (`id_obat`);

--
-- Indeks untuk tabel `tbl_obat_rusak`
--
ALTER TABLE `tbl_obat_rusak`
  ADD PRIMARY KEY (`id_rusak`),
  ADD KEY `id_obat` (`id_obat`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `tbl_stok_obat`
--
ALTER TABLE `tbl_stok_obat`
  ADD PRIMARY KEY (`id_stok`),
  ADD KEY `id_obat` (`id_obat`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_login`
--
ALTER TABLE `tbl_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `tbl_obat`
--
ALTER TABLE `tbl_obat`
  MODIFY `id_obat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tbl_obat_rusak`
--
ALTER TABLE `tbl_obat_rusak`
  MODIFY `id_rusak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tbl_stok_obat`
--
ALTER TABLE `tbl_stok_obat`
  MODIFY `id_stok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_obat_rusak`
--
ALTER TABLE `tbl_obat_rusak`
  ADD CONSTRAINT `tbl_obat_rusak_ibfk_1` FOREIGN KEY (`id_obat`) REFERENCES `tbl_obat` (`id_obat`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_obat_rusak_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `tbl_login` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
