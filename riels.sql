-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Jan 2026 pada 05.30
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `riels`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detil_pemesanan`
--

CREATE TABLE `detil_pemesanan` (
  `DETIL_PEMESANAN` int(11) NOT NULL,
  `ID_PESANAN` int(11) DEFAULT NULL,
  `ID_MENU` varchar(30) DEFAULT NULL,
  `QTY` int(11) DEFAULT NULL,
  `SUBTOTAL` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detil_pemesanan`
--

INSERT INTO `detil_pemesanan` (`DETIL_PEMESANAN`, `ID_PESANAN`, `ID_MENU`, `QTY`, `SUBTOTAL`) VALUES
(108622, 6542, 'M03', 2, 40000.00),
(110135, 7138, 'M03', 1, 20000.00),
(115102, 7643, 'M02', 1, 25000.00),
(118867, 3938, 'M02', 1, 25000.00),
(119704, 1491, 'M03', 1, 23000.00),
(122577, 2155, 'M02', 1, 25000.00),
(124466, 3660, 'MI2', 1, 22000.00),
(132120, 6703, 'M02', 1, 25000.00),
(135801, 5583, 'M01', 1, 21999.00),
(149937, 4720, 'M01', 1, 21999.00),
(153685, 3758, 'M02', 1, 25000.00),
(175048, 3681, 'M02', 1, 25000.00),
(175171, 9096, 'M02', 1, 25000.00),
(175424, 3865, 'M02', 1, 25000.00),
(194202, 7348, 'M02', 1, 25000.00),
(197188, 1576, 'M02', 1, 25000.00),
(203653, 3664, 'M03', 1, 20000.00),
(218496, 2269, 'M2502', 1, 25000.00),
(229663, 8238, 'M02', 1, 25000.00),
(245365, 4539, 'M03', 1, 20000.00),
(251234, 2269, 'M03', 1, 23000.00),
(255593, 6955, 'M01', 1, 21999.00),
(260666, 7664, 'M02', 1, 25000.00),
(265211, 8796, 'M02', 1, 25000.00),
(274383, 9055, 'M01', 1, 21999.00),
(276353, 1274, 'M01', 2, 43998.00),
(302803, 8823, 'M1981', 1, 22000.00),
(314038, 4274, 'M01', 1, 21999.00),
(319061, 9071, 'MA2', 1, 37000.00),
(319222, 3865, 'M03', 3, 60000.00),
(343951, 6643, 'MA2', 1, 37000.00),
(346110, 5958, 'MA2', 1, 37000.00),
(351601, 5736, 'M03', 1, 20000.00),
(364491, 1360, 'M02', 1, 32000.00),
(381036, 3765, 'M03', 2, 40000.00),
(382196, 3239, 'MI2', 1, 22000.00),
(383674, 4720, 'M02', 1, 25000.00),
(390889, 5082, 'M02', 1, 25000.00),
(406438, 4544, 'M02', 2, 50000.00),
(411505, 6097, 'M01', 1, 21999.00),
(420241, 1274, 'M03', 3, 60000.00),
(421407, 6105, 'M01', 1, 21999.00),
(427206, 7959, 'MI2', 1, 22000.00),
(448789, 2042, 'M02', 1, 25000.00),
(454005, 8796, 'M03', 2, 40000.00),
(468654, 7303, 'MA2', 1, 37000.00),
(476336, 6331, 'M03', 1, 23000.00),
(477929, 4075, 'M03', 1, 20000.00),
(488786, 9271, 'M02', 1, 25000.00),
(490304, 3018, 'M02', 1, 25000.00),
(493036, 8862, 'M02', 1, 25000.00),
(494491, 3865, 'MI2', 1, 22000.00),
(495491, 5941, 'M02', 1, 25000.00),
(502498, 8783, 'M01', 1, 21999.00),
(506935, 7195, 'M02', 1, 25000.00),
(513755, 4246, 'M03', 1, 20000.00),
(517212, 4698, 'M1090', 1, 28000.00),
(522373, 4618, 'M02', 2, 50000.00),
(523102, 4620, 'M02', 1, 25000.00),
(529154, 8714, 'M02', 2, 50000.00),
(537661, 3589, 'M03', 3, 60000.00),
(544649, 3239, 'M02', 1, 25000.00),
(567337, 1700, 'M03', 1, 20000.00),
(570598, 6560, 'M02', 1, 32000.00),
(571785, 6643, 'M02', 1, 25000.00),
(576287, 5772, 'M1981', 2, 44000.00),
(596181, 6149, 'M02', 1, 25000.00),
(600935, 1480, 'M02', 1, 25000.00),
(604715, 6874, 'M02', 1, 25000.00),
(613268, 7234, 'M01', 1, 21999.00),
(621094, 7542, 'M01', 1, 21999.00),
(644372, 1360, 'M9539', 1, 26000.00),
(657575, 6006, 'M02', 1, 25000.00),
(664988, 3172, 'M02', 1, 25000.00),
(677946, 4235, 'M02', 1, 25000.00),
(679084, 2380, 'M02', 1, 25000.00),
(685014, 8238, 'M03', 1, 20000.00),
(699591, 5437, 'M02', 1, 25000.00),
(707116, 8823, 'M2502', 1, 25000.00),
(728542, 1360, 'MA2', 1, 19000.00),
(736961, 2537, 'M03', 1, 20000.00),
(761086, 4254, 'M03', 1, 20000.00),
(770449, 3865, 'MA2', 2, 74000.00),
(773066, 6392, 'M01', 1, 21999.00),
(775536, 3681, 'M03', 2, 40000.00),
(777837, 9201, 'M01', 3, 65997.00),
(780102, 2269, 'M1981', 1, 22000.00),
(814209, 3135, 'M03', 1, 20000.00),
(821838, 5772, 'M2502', 2, 50000.00),
(837191, 1985, 'M01', 1, 21999.00),
(864165, 8823, 'M03', 1, 23000.00),
(864184, 3615, 'M03', 1, 23000.00),
(875822, 5830, 'M02', 1, 25000.00),
(881170, 5772, 'M2928', 1, 25000.00),
(887709, 7959, 'M02', 1, 25000.00),
(892097, 1274, 'M02', 5, 125000.00),
(899306, 5736, 'MI2', 1, 22000.00),
(928639, 4246, 'MA2', 1, 37000.00),
(952487, 8359, 'M02', 1, 25000.00),
(959883, 2741, 'M01', 1, 21999.00),
(972961, 9912, 'M03', 1, 20000.00),
(982128, 4748, 'M02', 1, 25000.00),
(986029, 8714, 'MA2', 5, 185000.00),
(995514, 6281, 'M01', 1, 21999.00),
(996344, 6542, 'MA2', 1, 37000.00),
(996669, 2843, 'MI2', 1, 22000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_menu`
--

CREATE TABLE `kategori_menu` (
  `ID_KATEGORI` varchar(100) NOT NULL,
  `NAMA_KATEGORI` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori_menu`
--

INSERT INTO `kategori_menu` (`ID_KATEGORI`, `NAMA_KATEGORI`) VALUES
('K01', 'SNACK'),
('K02', 'MAKANAN'),
('K03', 'MINUMAN');

-- --------------------------------------------------------

--
-- Struktur dari tabel `meja`
--

CREATE TABLE `meja` (
  `ID_MEJA` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `meja`
--

INSERT INTO `meja` (`ID_MEJA`) VALUES
('A1'),
('A2'),
('A3'),
('A4'),
('A5'),
('A6');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `ID_MENU` varchar(30) NOT NULL,
  `NAMA_MENU` varchar(100) DEFAULT NULL,
  `HARGA_SATUAN` decimal(12,2) DEFAULT NULL,
  `ID_KATEGORI` varchar(100) DEFAULT NULL,
  `STATUS_TESEDIA` varchar(20) DEFAULT NULL,
  `FOTO` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`ID_MENU`, `NAMA_MENU`, `HARGA_SATUAN`, `ID_KATEGORI`, `STATUS_TESEDIA`, `FOTO`) VALUES
('M01', 'Rice Bowl Karage', 37000.00, 'K01', 'tersedia', '1769613354_rbl.jpeg'),
('M02', 'Nasi Goreng Biasa', 32000.00, 'K01', 'tersedia', '1769613462_crg.jpeg'),
('M03', 'Mie Instant Kuah Spicy Cheese', 23000.00, 'K01', 'tersedia', '1769614324_intas.jpeg'),
('M1090', 'Churros', 28000.00, 'K03', 'tersedia', '1769613708_crs.jpeg'),
('M1882', 'Kopi Susu Oreo', 28000.00, 'K02', 'tersedia', '1769614454_oer.jpeg'),
('M1981', 'Riels Siganture', 22000.00, 'K02', 'tersedia', '1769614384_siga.jpeg'),
('M2502', 'Korean Banana Milk', 25000.00, 'K02', 'tersedia', '1769614532_banana.jpeg'),
('M2928', 'Matcha Latte', 25000.00, 'K02', 'tersedia', '1769614708_maytt.jpeg'),
('M2932', 'Pangsit Tulang Rangu', 26000.00, 'K03', 'tersedia', '1769613793_pangsit.jpeg'),
('M6110', 'Indomie Carbonara', 26000.00, 'K01', 'tersedia', '1769613952_indo.jpeg'),
('M8956', 'Rice Bowl Katsu', 37000.00, 'K01', 'tersedia', '1769614595_kat.jpeg'),
('M9509', 'Tahu Cabe Garam', 20000.00, 'K03', 'tersedia', '1769613676_tahu.jpeg'),
('M9539', 'Cireng Bumbu Rujak', 26000.00, 'K03', 'tersedia', '1769613864_cir.jpeg'),
('MA1', 'Americano', 18000.00, 'K02', 'tersedia', '1769613998_AME.jpeg'),
('MA2', 'Latte', 19000.00, 'K02', 'tersedia', '1769614119_late.jpeg'),
('MI2', 'Kentang Goreng', 22000.00, 'K03', 'tersedia', '1769613563_ktg.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `metode_pembayaran`
--

CREATE TABLE `metode_pembayaran` (
  `ID_METODE` varchar(4) NOT NULL,
  `NAMA_METODE` varchar(50) DEFAULT NULL,
  `QR_BAYAR` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `metode_pembayaran`
--

INSERT INTO `metode_pembayaran` (`ID_METODE`, `NAMA_METODE`, `QR_BAYAR`) VALUES
('Q01', 'QRIS', '/assets/qr/qris_coffee1.png'),
('Q02', 'TUNAI', '/assets/qr/qris_coffee3.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `ID_PELANGGAN` varchar(5) NOT NULL,
  `NAMA_PELANGGAN` varchar(100) DEFAULT NULL,
  `NO_HP` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`ID_PELANGGAN`, `NAMA_PELANGGAN`, `NO_HP`) VALUES
('P01', 'Salim', 6285792334553),
('P02', 'Cahya', 6285276508282),
('P03', 'Aliyya', 628510921244),
('P1093', 'cahya', 32432),
('P1128', 'agus', 34343),
('P1223', 'ER', 33),
('P1248', 'ER', 33),
('P1268', 'gsu', 8888888),
('P1362', 'agus', 88152100889),
('P1601', 'ER', 33),
('P1688', 'ER', 33),
('P1859', 'Tono Sumenep', 8232323231),
('P1943', 'GF', 5),
('P2284', 'ER', 33),
('P2371', 'ER', 33),
('P2380', 'budi', 3333),
('P2675', 'gusep', 8881232132),
('P2983', 'gusep', 8881232132),
('P3131', 'ER', 33),
('P3207', 'gusep', 8881232132),
('P3387', 'cahya', 32432),
('P3405', 'ER', 33),
('P3844', 'dsdsa', 34545),
('P3854', 'ooo', 999),
('P5187', 'budi', 3333),
('P5286', 'sugus', 811523833),
('P5315', 'ee', 4444),
('P5674', 'cahya', 32432),
('P5973', 'budi', 3333),
('P6819', 'cahya', 32432),
('P7058', 'joko', 888888777),
('P7114', 'Tono Sumenep', 8812317323),
('P7472', 'sumanto', 882222),
('P7906', 'anto', 676765),
('P8025', 'budi', 3333),
('P8177', 'cahya', 32432),
('P8295', 'agus', 8813232332),
('P8856', 'budi', 3333),
('P9094', 'cahya', 32432),
('P9146', 'ere', 5654),
('P9150', 'Tono Sumenep', 8812317323),
('P9457', 'ER', 33),
('P9555', 'ER', 33),
('P9679', 'ER', 33);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `ID_PEMBAYARAN` varchar(7) NOT NULL,
  `ID_PESANAN` int(11) DEFAULT NULL,
  `ID_METODE` varchar(4) DEFAULT NULL,
  `STATUS_PEMBAYARAN` varchar(20) DEFAULT NULL,
  `WAKTU_PEMBAYARAN` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`ID_PEMBAYARAN`, `ID_PESANAN`, `ID_METODE`, `STATUS_PEMBAYARAN`, `WAKTU_PEMBAYARAN`) VALUES
('B1106', 3172, 'Q02', 'Lunas', '2026-01-21 07:58:50.000000'),
('B1121', 2741, 'Q01', 'Lunas', '2026-01-28 14:26:17.000000'),
('B1204', 4274, 'Q02', 'Lunas', '2026-01-27 04:46:59.000000'),
('B1627', 3589, 'Q02', 'Lunas', '2026-01-21 09:01:58.000000'),
('B1804', 4748, 'Q02', 'Lunas', '2026-01-28 15:06:50.000000'),
('B1831', 7542, 'Q01', 'Lunas', '2026-01-27 16:22:42.000000'),
('B2027', 4698, 'Q01', 'Lunas', '2026-01-28 16:03:20.000000'),
('B2123', 8359, 'Q01', 'Lunas', '2026-01-27 16:47:05.000000'),
('B2242', 5941, 'Q02', 'Lunas', '2026-01-21 08:18:10.000000'),
('B2517', 6955, 'Q02', 'Lunas', '2026-01-27 04:47:35.000000'),
('B2977', 1491, 'Q01', 'Lunas', '2026-01-28 16:08:37.000000'),
('B3155', 6097, 'Q02', 'Lunas', '2026-01-27 04:47:24.000000'),
('B3403', 3765, 'Q02', 'Lunas', '2026-01-21 07:59:57.000000'),
('B3433', 2843, 'Q02', 'Lunas', '2026-01-27 13:34:36.000000'),
('B3505', 7643, 'Q02', 'Lunas', '2026-01-27 16:20:10.000000'),
('B3739', 6542, 'Q02', 'Lunas', '2026-01-21 08:29:26.000000'),
('B4012', 4075, 'Q02', 'Lunas', '2026-01-21 08:23:05.000000'),
('B4201', 5830, 'Q02', 'Lunas', '2026-01-27 16:20:03.000000'),
('B4218', 8783, 'Q02', 'Lunas', '2026-01-27 14:18:15.000000'),
('B4506', 3615, 'Q02', 'Lunas', '2026-01-28 16:07:02.000000'),
('B4547', 6281, 'Q01', 'Lunas', '2026-01-27 16:28:06.000000'),
('B4580', 7643, 'Q02', 'Lunas', '2026-01-27 16:20:09.000000'),
('B4834', 8862, 'Q01', 'Lunas', '2026-01-27 16:34:51.000000'),
('B4845', 6331, 'Q01', 'Lunas', '2026-01-28 16:04:51.000000'),
('B4917', 6874, 'Q02', 'Lunas', '2026-01-27 16:20:06.000000'),
('B5245', 4620, 'Q02', 'Lunas', '2026-01-27 14:20:18.000000'),
('B5429', 9071, 'Q02', 'Lunas', '2026-01-21 08:29:46.000000'),
('B5571', 6105, 'Q02', 'Lunas', '2026-01-27 04:47:30.000000'),
('B5575', 5583, 'Q02', 'Lunas', '2026-01-27 04:47:07.000000'),
('B5609', 3239, 'Q02', 'Lunas', '2026-01-21 09:01:48.000000'),
('B5654', 8796, 'Q02', 'Lunas', '2026-01-21 09:21:26.000000'),
('B5826', 3664, 'Q02', 'Lunas', '2026-01-21 08:31:41.000000'),
('B5862', 7303, 'Q02', 'Lunas', '2026-01-21 08:41:46.000000'),
('B6060', 1985, 'Q02', 'Lunas', '2026-01-27 04:46:28.000000'),
('B6149', 9096, 'Q02', 'Lunas', '2026-01-27 16:20:13.000000'),
('B6336', 3681, 'Q01', 'Lunas', '2026-01-28 14:46:01.000000'),
('B6400', 4720, 'Q02', 'Lunas', '2026-01-28 13:28:54.000000'),
('B6918', 2269, 'Q01', 'Lunas', '2026-01-28 16:12:01.000000'),
('B6976', 8823, 'Q01', 'Lunas', '2026-01-28 15:46:56.000000'),
('B6978', 6643, 'Q02', 'Lunas', '2026-01-21 08:29:42.000000'),
('B7114', 1274, 'Q01', 'Lunas', '2026-01-28 14:49:10.000000'),
('B7332', 3135, 'Q02', 'Lunas', '2026-01-21 09:01:40.000000'),
('B7640', 9201, 'Q02', 'Lunas', '2026-01-27 04:47:40.000000'),
('B7704', 8714, 'Q02', 'Lunas', '2026-01-21 09:37:15.000000'),
('B7782', 9912, 'Q02', 'Lunas', '2026-01-21 08:38:30.000000'),
('B7812', 7138, 'Q02', 'Lunas', '2026-01-21 08:23:52.000000'),
('B7842', 7234, 'Q02', 'Lunas', '2026-01-27 05:13:52.000000'),
('B7990', 3758, 'Q02', 'Lunas', '2026-01-27 16:19:59.000000'),
('B8025', 3865, 'Q02', 'Lunas', '2026-01-27 16:35:01.000000'),
('B8089', 3660, 'Q02', 'Lunas', '2026-01-27 16:17:45.000000'),
('B8148', 5772, 'Q01', 'Lunas', '2026-01-28 15:39:47.000000'),
('B8168', 2155, 'Q02', 'Lunas', '2026-01-21 08:39:32.000000'),
('B8331', 1700, 'Q02', 'Lunas', '2026-01-27 16:17:41.000000'),
('B8524', 2042, 'Q02', 'Lunas', '2026-01-21 08:15:23.000000'),
('B8532', 7195, 'Q02', 'Lunas', '2026-01-27 17:25:13.000000'),
('B8820', 4235, 'Q02', 'Lunas', '2026-01-27 16:28:29.000000'),
('B9122', 5736, 'Q02', 'Lunas', '2026-01-21 08:29:17.000000'),
('B9285', 5437, 'Q01', 'Lunas', '2026-01-27 17:06:14.000000'),
('B9363', 6560, 'Q01', 'Lunas', '2026-01-28 16:07:43.000000'),
('B9443', 4075, 'Q02', 'Lunas', '2026-01-21 07:45:18.000000'),
('B9651', 3615, 'Q01', 'Lunas', '2026-01-28 16:05:29.000000'),
('B9669', 1360, 'Q02', 'Lunas', '2026-01-28 15:51:12.000000'),
('B9800', 6392, 'Q02', 'Lunas', '2026-01-27 13:54:37.000000'),
('B9831', 2537, 'Q02', 'Lunas', '2026-01-21 08:36:26.000000'),
('B9894', 6703, 'Q01', 'Lunas', '2026-01-27 16:22:25.000000'),
('B9940', 9055, 'Q02', 'Lunas', '2026-01-27 14:19:15.000000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemesanan`
--

CREATE TABLE `pemesanan` (
  `ID_PESANAN` int(11) NOT NULL,
  `ID_PELANGGAN` varchar(5) DEFAULT NULL,
  `TOTAL_BAYAR` decimal(12,2) DEFAULT NULL,
  `ID_MEJA` varchar(3) DEFAULT NULL,
  `STATUS_PESANAN` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pemesanan`
--

INSERT INTO `pemesanan` (`ID_PESANAN`, `ID_PELANGGAN`, `TOTAL_BAYAR`, `ID_MEJA`, `STATUS_PESANAN`) VALUES
(1274, 'P8177', 228998.00, 'A5', 'Selesai'),
(1360, 'P9150', 77000.00, 'A5', 'Selesai'),
(1480, 'P01', 25000.00, 'A1', 'Selesai'),
(1491, 'P8025', 23000.00, 'A5', 'Selesai'),
(1576, NULL, 25000.00, 'A1', 'Selesai'),
(1700, NULL, 20000.00, 'A1', 'Selesai'),
(1985, NULL, 21999.00, 'A5', 'Selesai'),
(2042, 'P01', 25000.00, 'A1', 'Selesai'),
(2155, 'P01', 25000.00, 'A1', 'Selesai'),
(2269, 'P1859', 70000.00, 'A5', 'Proses'),
(2380, NULL, 25000.00, 'A2', 'Selesai'),
(2537, 'P01', 20000.00, 'A1', 'Selesai'),
(2741, 'P1093', 21999.00, 'A5', 'Selesai'),
(2843, NULL, 22000.00, 'A5', 'Selesai'),
(3018, NULL, 25000.00, 'A1', 'Selesai'),
(3135, 'P01', 20000.00, 'A1', 'Selesai'),
(3172, 'P01', 25000.00, 'A1', 'Selesai'),
(3239, 'P01', 47000.00, 'A1', 'Selesai'),
(3589, 'P01', 60000.00, 'A1', 'Selesai'),
(3615, 'P2380', 23000.00, 'A5', 'Selesai'),
(3660, NULL, 22000.00, 'A1', 'Selesai'),
(3664, 'P01', 20000.00, 'A1', 'Selesai'),
(3681, 'P5674', 65000.00, 'A5', 'Selesai'),
(3758, NULL, 25000.00, 'A1', 'Selesai'),
(3765, 'P01', 40000.00, 'A1', 'Selesai'),
(3865, 'P2371', 181000.00, 'A1', 'Selesai'),
(3938, NULL, 25000.00, 'A1', 'Selesai'),
(4075, 'P01', 45000.00, 'A1', 'Selesai'),
(4235, 'P1688', 25000.00, 'A1', 'Selesai'),
(4246, 'P01', 57000.00, 'A1', 'Selesai'),
(4254, NULL, 20000.00, 'A2', 'Selesai'),
(4274, NULL, 21999.00, 'A1', 'Selesai'),
(4539, NULL, 20000.00, 'A2', 'Selesai'),
(4544, 'P01', 50000.00, 'A1', 'Selesai'),
(4618, NULL, 50000.00, 'A1', 'Antre'),
(4620, NULL, 25000.00, 'A1', 'Selesai'),
(4698, 'P5973', 28000.00, 'A5', 'Selesai'),
(4720, 'P2675', 46999.00, 'A1', 'Selesai'),
(4748, 'P6819', 25000.00, 'A5', 'Selesai'),
(5082, NULL, 25000.00, 'A2', 'Selesai'),
(5437, 'P3207', 25000.00, 'A1', 'Selesai'),
(5583, NULL, 21999.00, 'A5', 'Selesai'),
(5736, 'P01', 42000.00, 'A1', 'Selesai'),
(5772, 'P3387', 119000.00, 'A5', 'Selesai'),
(5830, NULL, 25000.00, 'A1', 'Selesai'),
(5941, 'P01', 25000.00, 'A1', 'Selesai'),
(5958, NULL, 37000.00, 'A2', 'Selesai'),
(6006, 'P01', 25000.00, 'A1', 'Selesai'),
(6097, NULL, 21999.00, 'A5', 'Selesai'),
(6105, NULL, 21999.00, 'A5', 'Selesai'),
(6149, NULL, 25000.00, 'A1', 'Selesai'),
(6281, 'P1248', 21999.00, 'A1', 'Selesai'),
(6331, 'P8856', 23000.00, 'A5', 'Selesai'),
(6392, NULL, 21999.00, 'A1', 'Selesai'),
(6542, 'P01', 77000.00, 'A1', 'Selesai'),
(6560, 'P5187', 32000.00, 'A5', 'Selesai'),
(6643, 'P01', 62000.00, 'A1', 'Selesai'),
(6703, 'P2284', 25000.00, 'A1', 'Selesai'),
(6874, NULL, 25000.00, 'A1', 'Selesai'),
(6955, NULL, 21999.00, 'A1', 'Selesai'),
(7138, 'P01', 20000.00, 'A1', 'Selesai'),
(7195, 'P2983', 25000.00, 'A1', 'Selesai'),
(7234, NULL, 21999.00, 'A5', 'Selesai'),
(7303, 'P01', 37000.00, 'A1', 'Selesai'),
(7348, 'P9094', 25000.00, 'A5', 'Selesai'),
(7542, 'P9679', 21999.00, 'A1', 'Selesai'),
(7643, NULL, 25000.00, 'A1', 'Selesai'),
(7664, 'P01', 25000.00, 'A1', 'Selesai'),
(7959, NULL, 47000.00, 'A1', 'Selesai'),
(8238, NULL, 45000.00, 'A2', 'Selesai'),
(8359, 'P3405', 25000.00, 'A1', 'Selesai'),
(8714, 'P01', 235000.00, 'A1', 'Selesai'),
(8783, NULL, 21999.00, 'A1', 'Selesai'),
(8796, 'P01', 65000.00, 'A1', 'Selesai'),
(8823, 'P7114', 70000.00, 'A5', 'Selesai'),
(8862, 'P9457', 25000.00, 'A1', 'Selesai'),
(9055, NULL, 21999.00, 'A1', 'Selesai'),
(9071, 'P01', 37000.00, 'A1', 'Selesai'),
(9096, NULL, 25000.00, 'A1', 'Selesai'),
(9201, NULL, 65997.00, 'A1', 'Selesai'),
(9271, NULL, 25000.00, 'A1', 'Antre'),
(9912, 'P01', 20000.00, 'A1', 'Selesai');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detil_pemesanan`
--
ALTER TABLE `detil_pemesanan`
  ADD PRIMARY KEY (`DETIL_PEMESANAN`),
  ADD KEY `FK_DETIL_PESAN` (`ID_PESANAN`),
  ADD KEY `FK_DETIL_MENU` (`ID_MENU`);

--
-- Indeks untuk tabel `kategori_menu`
--
ALTER TABLE `kategori_menu`
  ADD PRIMARY KEY (`ID_KATEGORI`);

--
-- Indeks untuk tabel `meja`
--
ALTER TABLE `meja`
  ADD PRIMARY KEY (`ID_MEJA`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`ID_MENU`),
  ADD KEY `FK_MENU_KATEGORI` (`ID_KATEGORI`);

--
-- Indeks untuk tabel `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  ADD PRIMARY KEY (`ID_METODE`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`ID_PELANGGAN`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`ID_PEMBAYARAN`),
  ADD KEY `FK_BAYAR_PESAN` (`ID_PESANAN`),
  ADD KEY `FK_BAYAR_METODE` (`ID_METODE`);

--
-- Indeks untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`ID_PESANAN`),
  ADD KEY `FK_PESAN_PELANGGAN` (`ID_PELANGGAN`),
  ADD KEY `FK_PESAN_MEJA` (`ID_MEJA`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detil_pemesanan`
--
ALTER TABLE `detil_pemesanan`
  ADD CONSTRAINT `FK_DETIL_MENU` FOREIGN KEY (`ID_MENU`) REFERENCES `menu` (`ID_MENU`),
  ADD CONSTRAINT `FK_DETIL_PESAN` FOREIGN KEY (`ID_PESANAN`) REFERENCES `pemesanan` (`ID_PESANAN`);

--
-- Ketidakleluasaan untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `FK_MENU_KATEGORI` FOREIGN KEY (`ID_KATEGORI`) REFERENCES `kategori_menu` (`ID_KATEGORI`);

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `FK_BAYAR_METODE` FOREIGN KEY (`ID_METODE`) REFERENCES `metode_pembayaran` (`ID_METODE`),
  ADD CONSTRAINT `FK_BAYAR_PESAN` FOREIGN KEY (`ID_PESANAN`) REFERENCES `pemesanan` (`ID_PESANAN`);

--
-- Ketidakleluasaan untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `FK_PESAN_MEJA` FOREIGN KEY (`ID_MEJA`) REFERENCES `meja` (`ID_MEJA`),
  ADD CONSTRAINT `FK_PESAN_PELANGGAN` FOREIGN KEY (`ID_PELANGGAN`) REFERENCES `pelanggan` (`ID_PELANGGAN`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
