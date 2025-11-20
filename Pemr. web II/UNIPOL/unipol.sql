-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 20 Nov 2025 pada 08.53
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
-- Basis data: `unipol`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosen`
--

CREATE TABLE `dosen` (
  `NIDN` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `Nama` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `JenisKelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_general_ci NOT NULL,
  `Homebase` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dosen`
--

INSERT INTO `dosen` (`NIDN`, `Nama`, `JenisKelamin`, `Homebase`) VALUES
('jhjhg', 'bjhgjh', 'Perempuan', 'Teknik Informatika'),
('rgfh', 'dg', 'Laki-laki', 'Teknik Informatika'),
('vhjgj', 'nbmnb', 'Perempuan', 'Teknik Informatika');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int NOT NULL,
  `NIDN` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `kodeMK` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `hari` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `jam` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `ruangan` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `Nim` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `Nama` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `Prodi` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `JenisKelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_general_ci NOT NULL,
  `Angkatan` year NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`Nim`, `Nama`, `Prodi`, `JenisKelamin`, `Angkatan`) VALUES
('02304049', 'LIAN', 'Teknik Informatika', 'Laki-laki', '2021'),
('32432', 'ghhgfjhg', 'Teknik Informatika', 'Laki-laki', '2023'),
('ytjyf', 'ffgf', 'Teknik Informatika', 'Laki-laki', '2005');

-- --------------------------------------------------------

--
-- Struktur dari tabel `matakuliah`
--

CREATE TABLE `matakuliah` (
  `kodeMK` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `Matakuliah` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `SKS` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `matakuliah`
--

INSERT INTO `matakuliah` (`kodeMK`, `Matakuliah`, `SKS`) VALUES
('t5', 'gjhgj', 500);

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`NIDN`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `NIDN` (`NIDN`),
  ADD KEY `kodeMK` (`kodeMK`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`Nim`);

--
-- Indeks untuk tabel `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD PRIMARY KEY (`kodeMK`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`NIDN`) REFERENCES `dosen` (`NIDN`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jadwal_ibfk_2` FOREIGN KEY (`kodeMK`) REFERENCES `matakuliah` (`kodeMK`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
