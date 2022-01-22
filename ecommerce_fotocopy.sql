-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Jan 2022 pada 10.56
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce_fotocopy`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` varchar(255) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `stock` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `terjual` bigint(20) NOT NULL,
  `dilihat` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `jenis`, `nama`, `harga`, `stock`, `gambar`, `deskripsi`, `terjual`, `dilihat`, `created_at`, `updated_at`) VALUES
('furniture', 'kitchen_set', 'Furniture', 10000000, 3, 'furniture-1642788480-image-1.jpg', 'asdfghjkl', 2, 8, '2022-01-21 18:08:00', '2022-01-22 06:26:48'),
('furniture-2', 'kitchen_set', 'Furniture', 20000000, 2, 'furniture-2-1642832939-image-1.jpg', 'Qwerty', 2, 5, '2022-01-22 06:28:59', '2022-01-22 09:50:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_img`
--

CREATE TABLE `barang_img` (
  `id` bigint(20) NOT NULL,
  `id_barang` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `barang_img`
--

INSERT INTO `barang_img` (`id`, `id_barang`, `gambar`, `created_at`, `updated_at`) VALUES
(10, 'furniture', 'furniture-1642788480-image-1.jpg', '2022-01-21 18:08:00', '2022-01-21 18:08:00'),
(11, 'furniture', 'furniture-1642788637-image-2.jpg', '2022-01-21 18:08:00', '2022-01-21 18:10:37'),
(12, 'furniture', 'furniture-1642788480-image-3.jpg', '2022-01-21 18:08:00', '2022-01-21 18:08:00'),
(13, 'furniture-2', 'furniture-2-1642832939-image-1.jpg', '2022-01-22 06:28:59', '2022-01-22 06:28:59'),
(14, 'furniture-2', 'furniture-2-1642832939-image-2.jpg', '2022-01-22 06:28:59', '2022-01-22 06:28:59'),
(15, 'furniture-2', 'furniture-2-1642832939-image-3.jpg', '2022-01-22 06:28:59', '2022-01-22 06:28:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `confirm_regis`
--

CREATE TABLE `confirm_regis` (
  `id` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `telp` varchar(30) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `code` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id` bigint(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `barang_id` varchar(50) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total` varchar(100) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` bigint(20) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `jenis` varchar(20) NOT NULL,
  `notif` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `is_read` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `notifikasi`
--

INSERT INTO `notifikasi` (`id`, `user_id`, `jenis`, `notif`, `url`, `is_read`, `created_at`, `updated_at`) VALUES
(222, '36', 'pesanan', 'Pesananmu telah dikonfirmasi oleh admin', '/pesanan/3601224207', 1, '2022-01-21 18:17:10', '2022-01-22 08:03:26'),
(223, '36', 'pembayaran', 'Pembayaran telah divalidasi', '/pesanan/3601224207', 1, '2022-01-21 18:18:48', '2022-01-22 08:03:26'),
(224, '36', 'pesanan', 'Pesananmu sedang dikirim ke Bekasi', '/pesanan/3601224207', 1, '2022-01-21 18:18:56', '2022-01-22 08:03:26'),
(225, '36', 'pesanan', 'Pesananmu telah tiba di tujuan, pesanan selesai', '/pesanan/3601224207', 1, '2022-01-21 18:19:04', '2022-01-22 08:03:26'),
(226, '36', 'pesanan', 'Pesananmu telah dikonfirmasi oleh admin', '/pesanan/3601227458', 1, '2022-01-21 19:33:43', '2022-01-22 08:03:26'),
(227, '36', 'pembayaran', 'Pembayaran telah divalidasi', '/pesanan/3601227458', 1, '2022-01-21 19:34:45', '2022-01-22 08:03:26'),
(228, '36', 'pesanan', 'Pesananmu sedang dikirim ke Bekasi', '/pesanan/3601227458', 1, '2022-01-21 19:34:59', '2022-01-22 08:03:26'),
(229, '36', 'pesanan', 'Pesananmu telah tiba di tujuan, pesanan selesai', '/pesanan/3601227458', 1, '2022-01-21 19:35:10', '2022-01-22 08:03:26'),
(230, '36', 'pesanan', 'Pesananmu telah dikonfirmasi oleh admin', '/pesanan/3601221086', 1, '2022-01-22 07:31:11', '2022-01-22 08:03:26'),
(231, '36', 'pesanan', 'Pesananmu telah dikonfirmasi oleh admin', '/pesanan/3601221720', 1, '2022-01-22 07:53:26', '2022-01-22 08:03:26'),
(232, '36', 'pembayaran', 'Pembayaran telah divalidasi', '/pesanan/3601221720', 1, '2022-01-22 08:03:04', '2022-01-22 08:03:26'),
(233, '36', 'pesanan', 'Pesananmu sedang dikirim ke Bekasi', '/pesanan/3601221720', 1, '2022-01-22 08:03:13', '2022-01-22 08:03:26'),
(234, '36', 'pesanan', 'Pesananmu telah tiba di tujuan, pesanan selesai', '/pesanan/3601221720', 1, '2022-01-22 08:03:20', '2022-01-22 08:03:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id` varchar(25) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `telp` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `ongkir` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `konfirmasi` datetime DEFAULT NULL,
  `menunggu_validasi` datetime DEFAULT NULL,
  `validasi` datetime DEFAULT NULL,
  `pengiriman` datetime DEFAULT NULL,
  `tiba_di_tujuan` datetime DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `alasan_batal` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id`, `user_id`, `nama`, `telp`, `alamat`, `ongkir`, `total`, `status`, `konfirmasi`, `menunggu_validasi`, `validasi`, `pengiriman`, `tiba_di_tujuan`, `bukti_pembayaran`, `alasan_batal`, `created_at`, `updated_at`) VALUES
('3601221086', '36', 'Tes', '12333', 'Bekasi', 200000, 20200000, 'konfirmasi', '2022-01-22 14:31:11', NULL, NULL, NULL, NULL, NULL, NULL, '2022-01-22 07:00:20', '2022-01-22 07:31:11'),
('3601221720', '36', 'Tes', '12333', 'Bekasi', 250000, 20250000, 'selesai', '2022-01-22 14:53:26', '2022-01-22 15:02:44', '2022-01-22 15:03:04', '2022-01-22 15:03:13', '2022-01-22 15:03:20', 'contoh_3601221720.jpg', NULL, '2022-01-22 07:33:41', '2022-01-22 08:03:20'),
('3601227458', '36', 'Tes', '12333', 'Bekasi', NULL, 10000000, 'selesai', '2022-01-22 02:33:43', '2022-01-22 02:34:36', '2022-01-22 02:34:45', '2022-01-22 02:34:59', '2022-01-22 02:35:10', 'contoh_2606081378_3601227458.jpg', NULL, '2022-01-21 19:33:34', '2022-01-21 19:35:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan_barang`
--

CREATE TABLE `pesanan_barang` (
  `id` bigint(20) NOT NULL,
  `pesanan_id` varchar(50) NOT NULL,
  `barang_id` varchar(50) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` varchar(50) DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `total` varchar(50) DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `terjual` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pesanan_barang`
--

INSERT INTO `pesanan_barang` (`id`, `pesanan_id`, `barang_id`, `nama`, `harga`, `jumlah`, `total`, `gambar`, `url`, `terjual`, `created_at`, `updated_at`) VALUES
(147, '3601227458', 'furniture', 'Furniture', '10000000', 1, '10000000', 'furniture-1642788480-image-1.jpg', '/produk/furniture', 'terjual', '2022-01-21 19:33:34', '2022-01-21 19:34:45'),
(148, '3601221086', 'furniture-2', 'Furniture', '20000000', 1, '20000000', 'furniture-2-1642832939-image-1.jpg', '/produk/furniture-2', NULL, '2022-01-22 07:00:20', '2022-01-22 07:00:20'),
(149, '3601221720', 'furniture-2', 'Furniture', '20000000', 1, '20000000', 'furniture-2-1642832939-image-1.jpg', '/produk/furniture-2', 'terjual', '2022-01-22 07:33:41', '2022-01-22 08:03:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telp` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `telp`, `alamat`, `email`, `image`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(30, 'Admin', '081313131313', 'Bekasi Utara', 'admin@admin.com', NULL, NULL, '$2y$10$8zGFQ2nSWPE07QFBxjQqlul3DuSrTn/sp7.x.k5wcXH6Vwb6XXRda', 'admin', NULL, '2021-05-26 07:51:19', '2021-05-26 07:51:19'),
(36, 'Tes', '12333', 'Bekasi', 'tes@tes.com', NULL, NULL, '$2y$10$FJAybp6ON1p6neCR/OWSpOuKCOeTB2Vz7cq.o53Y/qNSVJRVYRXIm', 'user', NULL, '2022-01-19 15:29:16', '2022-01-19 15:29:16');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `barang_img`
--
ALTER TABLE `barang_img`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `confirm_regis`
--
ALTER TABLE `confirm_regis`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pesanan_barang`
--
ALTER TABLE `pesanan_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang_img`
--
ALTER TABLE `barang_img`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235;

--
-- AUTO_INCREMENT untuk tabel `pesanan_barang`
--
ALTER TABLE `pesanan_barang`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
