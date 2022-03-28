-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Mar 2022 pada 18.21
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pesantren`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `account`
--

CREATE TABLE `account` (
  `pkey` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(255) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `account`
--

INSERT INTO `account` (`pkey`, `username`, `name`, `password`, `role`, `img`) VALUES
(1, 'admin', 'admin', '0192023a7bbd73250516f069df18b500', 1, ''),
(8, 'adminn2', 'test', '168a8200e51fa1ae2605c701ac533c50', 2, ''),
(10, 'Atik', 'Atik Muawanah', '16e509d56d598bc309f0adc9e3d6903b', 2, ''),
(11, 'guru', 'guru', 'd41d8cd98f00b204e9800998ecf8427e', 2, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `account_detail`
--

CREATE TABLE `account_detail` (
  `pkey` int(11) NOT NULL,
  `refkey` int(11) DEFAULT NULL,
  `classkey` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `class`
--

CREATE TABLE `class` (
  `pkey` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `level`
--

CREATE TABLE `level` (
  `pkey` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `level`
--

INSERT INTO `level` (`pkey`, `name`) VALUES
(2, 'Lancar'),
(1, 'kurang Lancar'),
(3, 'Belum Hafalan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `memori`
--

CREATE TABLE `memori` (
  `pkey` int(11) NOT NULL,
  `classkey` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `memori_detail`
--

CREATE TABLE `memori_detail` (
  `pkey` int(11) NOT NULL,
  `memorikey` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `profile_company`
--

CREATE TABLE `profile_company` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `titlelogin` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `profile_company`
--

INSERT INTO `profile_company` (`id`, `name`, `alamat`, `telepon`, `phone`, `titlelogin`, `logo`, `title`) VALUES
(1, 'MI AL-IKHLAS BAKAUHENI', 'testing', '2345423', '234532', 'MI Al-Ikhlas', 'logo.jpeg', 'SISTEM INFORMASI HAFALAN SISWA');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `pkey` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`pkey`, `name`) VALUES
(1, 'Super Admin'),
(2, 'Guru');

-- --------------------------------------------------------

--
-- Struktur dari tabel `students`
--

CREATE TABLE `students` (
  `pkey` int(11) NOT NULL,
  `nis` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `birthday` varchar(255) DEFAULT NULL,
  `birthdaynoted` varchar(255) DEFAULT NULL,
  `classkey` int(11) DEFAULT NULL,
  `father` varchar(255) DEFAULT NULL,
  `mother` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `student_detail`
--

CREATE TABLE `student_detail` (
  `pkey` int(11) NOT NULL,
  `studentkey` int(11) DEFAULT NULL,
  `memorikey` int(11) DEFAULT NULL,
  `detailmemorikey` int(11) DEFAULT NULL,
  `levelkey` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`pkey`);

--
-- Indeks untuk tabel `account_detail`
--
ALTER TABLE `account_detail`
  ADD KEY `pkey` (`pkey`);

--
-- Indeks untuk tabel `class`
--
ALTER TABLE `class`
  ADD KEY `pkey` (`pkey`);

--
-- Indeks untuk tabel `level`
--
ALTER TABLE `level`
  ADD KEY `pkey` (`pkey`);

--
-- Indeks untuk tabel `memori`
--
ALTER TABLE `memori`
  ADD KEY `pkey` (`pkey`);

--
-- Indeks untuk tabel `memori_detail`
--
ALTER TABLE `memori_detail`
  ADD KEY `pkey` (`pkey`);

--
-- Indeks untuk tabel `profile_company`
--
ALTER TABLE `profile_company`
  ADD KEY `id` (`id`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD KEY `pkey` (`pkey`);

--
-- Indeks untuk tabel `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`pkey`);

--
-- Indeks untuk tabel `student_detail`
--
ALTER TABLE `student_detail`
  ADD KEY `pkey` (`pkey`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `account`
--
ALTER TABLE `account`
  MODIFY `pkey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `account_detail`
--
ALTER TABLE `account_detail`
  MODIFY `pkey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `class`
--
ALTER TABLE `class`
  MODIFY `pkey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `level`
--
ALTER TABLE `level`
  MODIFY `pkey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `memori`
--
ALTER TABLE `memori`
  MODIFY `pkey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `memori_detail`
--
ALTER TABLE `memori_detail`
  MODIFY `pkey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `profile_company`
--
ALTER TABLE `profile_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `pkey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `students`
--
ALTER TABLE `students`
  MODIFY `pkey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT untuk tabel `student_detail`
--
ALTER TABLE `student_detail`
  MODIFY `pkey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1051;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
