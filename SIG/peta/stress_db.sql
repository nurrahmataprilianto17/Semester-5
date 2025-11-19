-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 19 Nov 2025 pada 22.28
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stress_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `jalan_rusak`
--

CREATE TABLE `jalan_rusak` (
  `id` int NOT NULL,
  `lat_awal` double NOT NULL,
  `lng_awal` double NOT NULL,
  `lat_akhir` double DEFAULT NULL,
  `lng_akhir` double DEFAULT NULL,
  `tingkat_kerusakan` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `foto` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_validasi` enum('menunggu','valid','ditolak') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'menunggu',
  `nama_pelapor` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kontak` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_lapor` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jalan_rusak`
--

INSERT INTO `jalan_rusak` (`id`, `lat_awal`, `lng_awal`, `lat_akhir`, `lng_akhir`, `tingkat_kerusakan`, `deskripsi`, `foto`, `status_validasi`, `nama_pelapor`, `kontak`, `tanggal_lapor`) VALUES
(2, -4.3545, 119.9211, -4.3552, 119.9245, 'sedang', 'Aspal hancur dan berlubang', 'foto1.jpg\r\n', 'valid', 'Warga Lemba', NULL, '2025-11-09 18:26:48'),
(3, -4.351, 119.93, NULL, NULL, 'berat', 'Jalan bergelombang', NULL, 'menunggu', 'Pelapor Tes', NULL, '2025-11-09 18:26:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `status` enum('Menunggu','Divalidasi','Ditolak') DEFAULT 'Menunggu',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'admin', 'nurrahmataprilianto17@gmail.com', 'MbsvqjaE4+l7UuJqs074AAKRpFgWDssNbz8R1SNDzFo=', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `jalan_rusak`
--
ALTER TABLE `jalan_rusak`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jalan_rusak`
--
ALTER TABLE `jalan_rusak`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
