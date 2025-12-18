-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 17 Okt 2025 pada 13.39
-- Versi server: 8.0.30
-- Versi PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_spj_app`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int UNSIGNED NOT NULL,
  `pesananID` int UNSIGNED NOT NULL,
  `userID` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int NOT NULL,
  `price` int NOT NULL,
  `total` int NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `pesananID`, `userID`, `name`, `amount`, `price`, `total`, `unit`, `deleted_at`) VALUES
(1, 1, 1, 'qsq', 1, 1221121, 1221121, 'paket', NULL),
(2, 2, 1, 'wef', 2, 23, 46, 'paket', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bendahara`
--

CREATE TABLE `bendahara` (
  `id` int UNSIGNED NOT NULL,
  `received_from` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userID` int UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bendahara`
--

INSERT INTO `bendahara` (`id`, `received_from`, `name`, `type`, `nip`, `userID`, `deleted_at`) VALUES
(1, 'Bendahara', 'Tes Bendahara', 'Bendahara BOS', '1234567890', 1, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `expenditures`
--

CREATE TABLE `expenditures` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` int NOT NULL,
  `qty` int NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` int UNSIGNED NOT NULL,
  `userID` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` date NOT NULL,
  `deadline` date NOT NULL,
  `info` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kegiatan`
--

INSERT INTO `kegiatan` (`id`, `userID`, `name`, `order`, `deadline`, `info`, `deleted_at`) VALUES
(1, 1, 'Pengadaan Komputer', '2025-10-17', '2025-10-24', 'Pengadaan perangkat komputer untuk lab', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kepsek`
--

CREATE TABLE `kepsek` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `school` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userID` int UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kepsek`
--

INSERT INTO `kepsek` (`id`, `name`, `nip`, `year`, `school`, `address`, `userID`, `deleted_at`) VALUES
(1, 'Tes Kepsek', '1987654321', '2025', 'SMKN 1 Talaga', 'Jl. Sekolah No. 20', 1, '2025-10-17 04:52:23'),
(2, 'eds', '2131231231313', '2008', 'dghfddbfd', 'sadasd', 1, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `letterheads`
--

CREATE TABLE `letterheads` (
  `id` int UNSIGNED NOT NULL,
  `userID` int UNSIGNED NOT NULL,
  `main_institution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_institution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `field` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address1` text COLLATE utf8mb4_unicode_ci,
  `address2` text COLLATE utf8mb4_unicode_ci,
  `no_telp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npsn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `letterheads`
--

INSERT INTO `letterheads` (`id`, `userID`, `main_institution`, `sub_institution`, `name`, `field`, `address1`, `address2`, `no_telp`, `fax`, `pos`, `npsn`, `website`, `email`, `logo`, `created_at`, `updated_at`) VALUES
(1, 1, 'ztfed', 'fdb', 'zfb', 'zfdbzfdb', 'fbfzdbfdb', 'zfdbzdbdf', '312413', '23234', '234323432', '234234', 'https://fdhb.com', 'dummyguru@gmail.com', '1760701573_f.png', '2025-10-17 04:46:13', '2025-10-17 04:46:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_03_22_023357_create_internal_table', 1),
(5, '2025_03_22_023757_create_letterheads_table', 1),
(6, '2025_03_22_024629_create_eksternal_table', 1),
(7, '2025_08_23_221730_create_expenditures_table', 1),
(8, '2025_10_14_000000_add_letterheadid_to_pesanan', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penerima`
--

CREATE TABLE `penerima` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userID` int UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penerima`
--

INSERT INTO `penerima` (`id`, `name`, `nip`, `position`, `userID`, `deleted_at`) VALUES
(1, 'Penerima Barang', '1122334455', 'Staff ICT', 1, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penyedia`
--

CREATE TABLE `penyedia` (
  `id` int UNSIGNED NOT NULL,
  `userID` int UNSIGNED NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `npwp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account` bigint NOT NULL,
  `delegation_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delegate_position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penyedia`
--

INSERT INTO `penyedia` (`id`, `userID`, `company`, `npwp`, `address`, `post_code`, `bank`, `account`, `delegation_name`, `delegate_position`, `deleted_at`) VALUES
(1, 1, 'CV Techira Indonesia', '123456789012345', 'Jl. Teknologi No. 1', '402122', 'BRI', 9876543210, 'Najmy', 'Direktur', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int UNSIGNED NOT NULL,
  `userID` int UNSIGNED NOT NULL,
  `invoice_num` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_num` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note_num` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bast_num` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_num` int NOT NULL,
  `tax` int DEFAULT NULL,
  `shipping_cost` int DEFAULT NULL,
  `profit` int DEFAULT NULL,
  `total` int DEFAULT NULL,
  `kegiatanID` int UNSIGNED DEFAULT NULL,
  `penyediaID` int UNSIGNED DEFAULT NULL,
  `penerimaID` int UNSIGNED DEFAULT NULL,
  `bendaharaID` int UNSIGNED DEFAULT NULL,
  `kepsekID` int UNSIGNED DEFAULT NULL,
  `letterheadID` int UNSIGNED DEFAULT NULL,
  `order_date` date NOT NULL,
  `paid` date NOT NULL,
  `billing` date DEFAULT NULL,
  `accepted` date NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id`, `userID`, `invoice_num`, `order_num`, `note_num`, `bast_num`, `type_num`, `tax`, `shipping_cost`, `profit`, `total`, `kegiatanID`, `penyediaID`, `penerimaID`, `bendaharaID`, `kepsekID`, `letterheadID`, `order_date`, `paid`, `billing`, `accepted`, `pic`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, '001', '001', '001', '001', 1, 85478, 12, NULL, 1221121, 1, 1, 1, 1, 2, NULL, '2025-10-17', '2025-10-19', '2025-10-18', '2025-10-20', 'sas', NULL, '2025-10-17 04:47:44', '2025-10-17 05:02:26'),
(2, 1, '23', '002', '124', '412', 1, 11, 123, NULL, 46, 1, 1, 1, 1, 2, NULL, '2025-10-17', '2025-10-19', '2025-10-18', '2025-10-20', '12', NULL, '2025-10-17 05:45:30', '2025-10-17 05:45:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('kjeUqRawzIB7lGjR6hEMMCFo1SNEqa7J1EJEHL8k', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiZ3d5MU1HbXc0Q2x3dExBNEFtakVUbGRzWVIxdDlnT3BlNXZxcldmWCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZWtzdGVybmFsL3Blc2FuYW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NDoiZGF0YSI7YToxNzp7czo5OiJvcmRlcl9udW0iO3M6MzoiMDAyIjtzOjExOiJpbnZvaWNlX251bSI7czoyOiIyMyI7czo4OiJub3RlX251bSI7czozOiIxMjQiO3M6ODoiYmFzdF9udW0iO3M6MzoiNDEyIjtzOjg6ImtlcHNla0lEIjtzOjE6IjIiO3M6MTE6ImJlbmRhaGFyYUlEIjtzOjE6IjEiO3M6MTA6InBlbmVyaW1hSUQiO3M6MToiMSI7czoxMDoia2VnaWF0YW5JRCI7czoxOiIxIjtzOjEwOiJwZW55ZWRpYUlEIjtzOjE6IjEiO3M6MTA6Im9yZGVyX2RhdGUiO3M6MTA6IjIwMjUtMTAtMTciO3M6NzoiYmlsbGluZyI7czoxMDoiMjAyNS0xMC0xOCI7czo0OiJwYWlkIjtzOjEwOiIyMDI1LTEwLTE5IjtzOjg6ImFjY2VwdGVkIjtzOjEwOiIyMDI1LTEwLTIwIjtzOjg6InR5cGVfbnVtIjtzOjE6IjEiO3M6MzoidGF4IjtzOjI6IjI0IjtzOjEzOiJzaGlwcGluZ19jb3N0IjtzOjM6IjEyMyI7czozOiJwaWMiO3M6MjoiMTIiO319', 1760705131);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `namalengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `namalengkap`, `level`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin_utama', 'Admin Utama', 'admin', '$2y$12$78M9p4YlcVy886P9xUBncO120r.pq7TJFQvdCxTRisKPL8nf7tljm', NULL, '2025-10-17 04:44:54', '2025-10-17 04:44:54'),
(2, 'admin_1', 'Admin Satu', 'admin', '$2y$12$PBUw.VpZWzNF3rrHEXbWKuOIHJ8N0nUdvQB2MntiLgwcpqeFVv3DO', NULL, '2025-10-17 04:44:54', '2025-10-17 04:44:54'),
(3, 'admin_2', 'Admin Dua', 'admin', '$2y$12$w9NYafpoW/tiAx6JjAalD.AVbiveD7bRpGYGczQaEYOrBYRjoRGuq', NULL, '2025-10-17 04:44:55', '2025-10-17 04:44:55'),
(4, 'admin_3', 'Admin Tiga', 'admin', '$2y$12$6uniBBXVkRYeQrfYbkCui.Xok.WnYu270HCeDara6JecCm7UjVCmO', NULL, '2025-10-17 04:44:55', '2025-10-17 04:44:55');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `barang_pesananid_foreign` (`pesananID`),
  ADD KEY `barang_userid_foreign` (`userID`);

--
-- Indeks untuk tabel `bendahara`
--
ALTER TABLE `bendahara`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bendahara_userid_foreign` (`userID`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `expenditures`
--
ALTER TABLE `expenditures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenditures_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kegiatan_userid_foreign` (`userID`);

--
-- Indeks untuk tabel `kepsek`
--
ALTER TABLE `kepsek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kepsek_userid_foreign` (`userID`);

--
-- Indeks untuk tabel `letterheads`
--
ALTER TABLE `letterheads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `letterheads_userid_foreign` (`userID`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `penerima`
--
ALTER TABLE `penerima`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penerima_userid_foreign` (`userID`);

--
-- Indeks untuk tabel `penyedia`
--
ALTER TABLE `penyedia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penyedia_userid_foreign` (`userID`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanan_kegiatanid_foreign` (`kegiatanID`),
  ADD KEY `pesanan_penyediaid_foreign` (`penyediaID`),
  ADD KEY `pesanan_penerimaid_foreign` (`penerimaID`),
  ADD KEY `pesanan_bendaharaid_foreign` (`bendaharaID`),
  ADD KEY `pesanan_kepsekid_foreign` (`kepsekID`),
  ADD KEY `pesanan_letterheadid_foreign` (`letterheadID`),
  ADD KEY `pesanan_userid_foreign` (`userID`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `bendahara`
--
ALTER TABLE `bendahara`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `expenditures`
--
ALTER TABLE `expenditures`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kepsek`
--
ALTER TABLE `kepsek`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `letterheads`
--
ALTER TABLE `letterheads`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `penerima`
--
ALTER TABLE `penerima`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `penyedia`
--
ALTER TABLE `penyedia`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_pesananid_foreign` FOREIGN KEY (`pesananID`) REFERENCES `pesanan` (`id`),
  ADD CONSTRAINT `barang_userid_foreign` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `bendahara`
--
ALTER TABLE `bendahara`
  ADD CONSTRAINT `bendahara_userid_foreign` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `expenditures`
--
ALTER TABLE `expenditures`
  ADD CONSTRAINT `expenditures_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD CONSTRAINT `kegiatan_userid_foreign` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `kepsek`
--
ALTER TABLE `kepsek`
  ADD CONSTRAINT `kepsek_userid_foreign` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `letterheads`
--
ALTER TABLE `letterheads`
  ADD CONSTRAINT `letterheads_userid_foreign` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `penerima`
--
ALTER TABLE `penerima`
  ADD CONSTRAINT `penerima_userid_foreign` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `penyedia`
--
ALTER TABLE `penyedia`
  ADD CONSTRAINT `penyedia_userid_foreign` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_bendaharaid_foreign` FOREIGN KEY (`bendaharaID`) REFERENCES `bendahara` (`id`),
  ADD CONSTRAINT `pesanan_kegiatanid_foreign` FOREIGN KEY (`kegiatanID`) REFERENCES `kegiatan` (`id`),
  ADD CONSTRAINT `pesanan_kepsekid_foreign` FOREIGN KEY (`kepsekID`) REFERENCES `kepsek` (`id`),
  ADD CONSTRAINT `pesanan_letterheadid_foreign` FOREIGN KEY (`letterheadID`) REFERENCES `letterheads` (`id`),
  ADD CONSTRAINT `pesanan_penerimaid_foreign` FOREIGN KEY (`penerimaID`) REFERENCES `penerima` (`id`),
  ADD CONSTRAINT `pesanan_penyediaid_foreign` FOREIGN KEY (`penyediaID`) REFERENCES `penyedia` (`id`),
  ADD CONSTRAINT `pesanan_userid_foreign` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
