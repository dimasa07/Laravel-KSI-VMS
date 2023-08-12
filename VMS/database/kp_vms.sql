/*
SQLyog Community v13.1.6 (64 bit)
MySQL - 10.4.24-MariaDB : Database - kp_vms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`kp_vms` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `kp_vms`;

/*Table structure for table `akun` */

DROP TABLE IF EXISTS `akun`;

CREATE TABLE `akun` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role` enum('TAMU','ADMIN','FRONT OFFICE') COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `akun_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `akun` */

insert  into `akun`(`id`,`role`,`username`,`password`) values 
(1,'ADMIN','admin','admin'),
(2,'FRONT OFFICE','frontoffice','frontoffice'),
(4,'TAMU','tamu2','tamu2'),
(5,'TAMU','tamu3','tamu3'),
(6,'TAMU','tamu4','tamu4'),
(27,'TAMU','tamu','tamu');

/*Table structure for table `buku_tamu` */

DROP TABLE IF EXISTS `buku_tamu`;

CREATE TABLE `buku_tamu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_front_office` int(10) unsigned NOT NULL,
  `id_permintaan` int(10) unsigned NOT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `buku_tamu_id_permintaan_unique` (`id_permintaan`),
  KEY `buku_tamu_id_front_office_foreign` (`id_front_office`),
  CONSTRAINT `buku_tamu_id_front_office_foreign` FOREIGN KEY (`id_front_office`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `buku_tamu_id_permintaan_foreign` FOREIGN KEY (`id_permintaan`) REFERENCES `permintaan_bertamu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `buku_tamu` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2019_12_14_000001_create_personal_access_tokens_table',1),
(2,'2022_09_23_094402_create_akun_table',1),
(3,'2022_09_24_051135_create_tamu_table',1),
(4,'2022_09_25_163714_create_pegawai_table',1),
(5,'2022_09_25_164613_create_permintaan_bertamu_table',1),
(6,'2022_09_25_164654_create_buku_tamu_table',1);

/*Table structure for table `pegawai` */

DROP TABLE IF EXISTS `pegawai`;

CREATE TABLE `pegawai` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_akun` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pegawai_nip_unique` (`nip`),
  KEY `pegawai_id_akun_foreign` (`id_akun`),
  CONSTRAINT `pegawai_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akun` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `pegawai` */

insert  into `pegawai`(`id`,`nip`,`nama`,`no_telepon`,`email`,`jabatan`,`alamat`,`id_akun`) values 
(1,'1','ADMIN','0812345678','adminA@gmail.com','ADMIN','Dago Biru',1),
(2,'101','FRONT OFFICE','081234567101','fo@gmail.com','FRONT OFFICE','Dago Biru',2),
(17,'1001','Drs. H. YUDI ABDURAHMAN M.Si',NULL,NULL,NULL,NULL,NULL),
(18,'1002','CECEP HENDRAWAN SIP',NULL,NULL,NULL,NULL,NULL),
(19,'1003','DRA ANYA ROSMIATI SOERYA',NULL,NULL,NULL,NULL,NULL),
(20,'1004','IWAN RIDWAN, S.IKom., M.A.P',NULL,NULL,NULL,NULL,NULL),
(21,'1005','ASEP ROCHMANSYAH  S.Si.  MAP',NULL,NULL,NULL,NULL,NULL),
(22,'1006','SANTI ROSMAYANTI  S.STP',NULL,NULL,NULL,NULL,NULL),
(23,'1007','LUSIANTO, S.Kom.  M.Si',NULL,NULL,NULL,NULL,NULL),
(24,'1008','DRA.HJ SRI LESTARI M.SI',NULL,NULL,NULL,NULL,NULL),
(25,'1009','DRA YUSI ROSILAWATI M.A.P.',NULL,NULL,NULL,NULL,NULL),
(26,'1010','MILKI TEGUH BAGJA IRAWAN  ST. MM',NULL,NULL,NULL,NULL,NULL),
(27,'1011','Dra. SUSI SUSTIAWATI',NULL,NULL,NULL,NULL,NULL),
(28,'1012','RINRIN DESTIATI ST',NULL,NULL,NULL,NULL,NULL),
(29,'1013','MUHAMAD AKBAR PAHLA KS, ST',NULL,NULL,NULL,NULL,NULL),
(30,'1014','IIS AISYAH MARWATI SE MM',NULL,NULL,NULL,NULL,NULL),
(31,'1015','ADHIE NUR INDRA SIP',NULL,NULL,NULL,NULL,NULL),
(32,'1016','ANGGA SURA SENDANA.  S.KOM M.SI',NULL,NULL,NULL,NULL,NULL),
(33,'1017','MOCHAMAD TAUFIK S.KOM',NULL,NULL,NULL,NULL,NULL),
(34,'1018','SITI SARIBELLA SAB',NULL,NULL,NULL,NULL,NULL),
(35,'1019','LILIS TUTI SUHAETI S.SOS',NULL,NULL,NULL,NULL,NULL),
(36,'1020','DANI RAMDANI  S.TP',NULL,NULL,NULL,NULL,NULL),
(37,'1021','MOH ANDRI ADRIANSAH S.SOS',NULL,NULL,NULL,NULL,NULL),
(38,'1022','DEDI PERMANA',NULL,NULL,NULL,NULL,NULL),
(39,'1023','NYIMAS AYU KIKIE ZAKIYAH  S.Si',NULL,NULL,NULL,NULL,NULL),
(40,'1024','DJUFRIJANI.S.SI',NULL,NULL,NULL,NULL,NULL),
(41,'1025','IRWAN KURNIAWAN  AMD',NULL,NULL,NULL,NULL,NULL),
(42,'1026','MALA HESTI PURWANI  S.A.B',NULL,NULL,NULL,NULL,NULL),
(43,'1027','DADANG MUHAMAD GOJALI S.I.P',NULL,NULL,NULL,NULL,NULL),
(44,'1028','AHMAD NURZEIN',NULL,NULL,NULL,NULL,NULL),
(45,'1029','RIZQI RIVANI SYAFEI  S.KOM',NULL,NULL,NULL,NULL,NULL),
(46,'1030','MUHAMMAD IMAM SAMPURNA, ST',NULL,NULL,NULL,NULL,NULL),
(47,'1031','T MOHAMMAD BAKTI FATIHANA, S.KOM',NULL,NULL,NULL,NULL,NULL),
(48,'1032','RIMA DIANI, S.SI.KOM',NULL,NULL,NULL,NULL,NULL),
(49,'1033','DHEA YULIANTY, SE',NULL,NULL,NULL,NULL,NULL),
(50,'1034','HILMAN DEWA DARMAWAN, S.SI',NULL,NULL,NULL,NULL,NULL),
(51,'1035','ADITYA MAHENDRA',NULL,NULL,NULL,NULL,NULL),
(52,'1036','AAM JAMALUDIN',NULL,NULL,NULL,NULL,NULL),
(53,'1037','MOHAMAD SOPIAN',NULL,NULL,NULL,NULL,NULL),
(54,'1038','ETI HARLIATI',NULL,NULL,NULL,NULL,NULL),
(55,'1039','ABUY SOBUR',NULL,NULL,NULL,NULL,NULL),
(56,'1040','GUGUN GUNAWAN, A.Md, A.Md',NULL,NULL,NULL,NULL,NULL),
(57,'1041','AHMAD MULYANA, A.Md',NULL,NULL,NULL,NULL,NULL),
(58,'1042','AGUS',NULL,NULL,NULL,NULL,NULL),
(59,'1043','INDRA GUNAWAN SUJANA, A.Md',NULL,NULL,NULL,NULL,NULL),
(60,'1044','SUTISNA',NULL,NULL,NULL,NULL,NULL),
(61,'1045','RICKA RIYANTY',NULL,NULL,NULL,NULL,NULL),
(62,'1046','RULLY NURSETIADI, A.Md',NULL,NULL,NULL,NULL,NULL),
(63,'1047','DESSY WULANSARI',NULL,NULL,NULL,NULL,NULL),
(64,'1048','MUHAMAD ADAM IBRAHIM',NULL,NULL,NULL,NULL,NULL),
(65,'1049','SUHENDAR',NULL,NULL,NULL,NULL,NULL),
(66,'1050','ISMAIL',NULL,NULL,NULL,NULL,NULL),
(67,'1051','TOHA',NULL,NULL,NULL,NULL,NULL),
(68,'1052','RAHMAT SUHENDAR',NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `permintaan_bertamu` */

DROP TABLE IF EXISTS `permintaan_bertamu`;

CREATE TABLE `permintaan_bertamu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_tamu` int(10) unsigned NOT NULL,
  `id_front_office` int(10) unsigned DEFAULT NULL,
  `id_admin` int(10) unsigned DEFAULT NULL,
  `id_pegawai` int(10) unsigned NOT NULL,
  `keperluan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktu_bertamu` datetime DEFAULT NULL,
  `waktu_pengiriman` datetime DEFAULT NULL,
  `waktu_pemeriksaan` datetime DEFAULT NULL,
  `status` enum('BELUM DIPERIKSA','DISETUJUI','DITOLAK','KADALUARSA') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BELUM DIPERIKSA',
  `batas_waktu` int(10) unsigned DEFAULT NULL,
  `pesan_ditolak` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permintaan_bertamu_id_admin_foreign` (`id_admin`),
  KEY `permintaan_bertamu_id_pegawai_foreign` (`id_pegawai`),
  KEY `permintaan_bertamu_id_tamu_foreign` (`id_tamu`),
  KEY `id_front_office` (`id_front_office`),
  CONSTRAINT `permintaan_bertamu_ibfk_1` FOREIGN KEY (`id_front_office`) REFERENCES `pegawai` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `permintaan_bertamu_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permintaan_bertamu_id_pegawai_foreign` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permintaan_bertamu_id_tamu_foreign` FOREIGN KEY (`id_tamu`) REFERENCES `tamu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permintaan_bertamu` */

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `tamu` */

DROP TABLE IF EXISTS `tamu`;

CREATE TABLE `tamu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_akun` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tamu_nik_unique` (`nik`),
  KEY `tamu_id_akun_foreign` (`id_akun`),
  CONSTRAINT `tamu_id_akun_foreign` FOREIGN KEY (`id_akun`) REFERENCES `akun` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tamu` */

insert  into `tamu`(`id`,`nik`,`nama`,`no_telepon`,`email`,`alamat`,`id_akun`) values 
(1,'10001','TAMU 1',NULL,NULL,NULL,27),
(2,'10002','TAMU 2','0891289221','tam','Dago',4),
(3,'10003','TAMU 3','08989189212','tamu3@gmail.com','Soreang',5),
(4,'10004','TAMU 4','08989282222','tamu4@gmail.com','Dago',6);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
