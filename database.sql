-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: wisata-nganjuk
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin@gmail.com','202cb962ac59075b964b07152d234b70');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event` (
  `id` int NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  `tanggal` date DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (1,'Symphony Budaya Religi & Ngaji Bareng Gus Iqdam','Pemerintah Kabupaten Nganjuk mematangkan persiapan kegiatan Symphony Budaya Religi bersama Gus Iqdam.\r\n\r\nAgenda ini akan digelar pada hari Rabu, 22 April 2026 jam 18.00 WIB di halaman GOR Bung Karno Nganjuk.\r\nAgenda ini merupakan bagian dari peringatan hari jadi ke-1089 Kabupaten Nganjuk dengan mengusung tema ΓÇ£Harmoni Bumi Anjuk Ladang, Melesat, dan SejahteraΓÇ¥.','2026-04-22','Halaman GOR Bung Karno. Menampilkan musik religi dan Gus Iqdam.','1777436619_FotoJet-53-1137886000.webp'),(2,'NGAJI BARENG GUS KAUTSAR ','Dalam rangka memeriahkan Hari Jadi Nganjuk ke-1089, mari bersama-sama kita hadir dalam majelis ilmu dan shalawat bersama Gus Kautsar.\r\nMari kita raih keberkahan, mempererat tali silaturahmi, dan berdoa demi terwujudnya Harmoni Bumi Anjuk Ladang yang Melesat dan Sejahtera.','2026-04-28','Masjid Nurul Huda, Tanjunganom ΓÇô Nganjuk','1777440126_hq720 (1).jpg'),(3,'Festival Pu Tajum Mengawal Sejarah Berdirinya Bumi Anjuk Ladang','Sebuah festival budaya untuk mengenang sejarah, melestarikan tradisi, serta mengangkat potensi seni dan UMKM lokal.','2026-04-23','Halaman Kantor Kecamatan Ngetos','1777440246_e333f2452736a89aad0df3b058af8b11.jpg'),(4,'TASYAKURAN MASSAL 1088 TUMPENG Dalam rangka memperingati Hari Jadi Nganjuk ke-1088,',' yuk ramaikan dan meriahkan momen penuh syukur ini bersama-sama!','2026-04-27','Sepanjang Jl. A. Yani Utara ΓÇô sekitaran Alun-alun Nganjuk','1777440427_J1JKoXW4b2dAePfwdth0NQWTL5kIW4fRlD7iGw9D.jpg');
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kuliner`
--

DROP TABLE IF EXISTS `kuliner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kuliner` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_kuliner` varchar(100) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  `jam_buka` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kuliner`
--

LOCK TABLES `kuliner` WRITE;
/*!40000 ALTER TABLE `kuliner` DISABLE KEYS */;
INSERT INTO `kuliner` VALUES (3,'Nasi Becek dan Sate Kambing Khas Nganjuk','Jl. DR. Soetomo No.5, Bogo Kidul, Bogo, Kec. Nganjuk, Kabupaten Nganjuk','1777437662_47558f6d-bb7f-4575-8eb1-0888949ce951-3433108699.jpeg','Nasi becek adalah salah satu kuliner khas Nganjuk. Nasi becek terdiri dari nasi putih yang disiram kuah gule kambing dan diberi setusuk kambing. Tak lupa ditambahkan irisan kubis biar makin nikmat. Salah satu penjual kuliner khas yang legend yaitu warung Nasi Becek dan Sate Kambing Khas Nganjuk yang sudah berjualan sejak tahun 1950. Warung ini jadi langganan semua wisatawan dan bahkan tokoh nasional saat mampir ke Nganjuk.',' Senin-Minggu 09.00-21.00 WIB'),(4,'Tumpang Pecel Barokah','Jl. Kertosono - Lengkong No.27, Banaran, Kec. Kertosono, Kabupaten Nganjuk','1777439355_05193149-76d0-4d82-839f-ffda3c4a58a0_Go-Biz_20230626_124614.jpeg','Kalau sudah di Nganjuk gak boleh skip sama kuliner satu ini. Pecel emang enak disantap pakai apa saja, tapi kalau sudah ditambahkan sambal tumpang, kenikmatan itu jadi mutlak. Nah kalau ke Nganjuk, salah satu tempat makan pecel yang terkenal dengan sambal tumpangnya adalah warung Barokah. Tempatnya luas dan pilihan lauknya melimpah. Mulai tempe, telor sampai sate-satean ada.','Senin-Minggu 17.00-01.00 WIB'),(5,'Soto Pak Yon','Jalan Ahmad Yani, Nganjuk','1777439446_Pakyon-3447316750.webp','Salah satu kuliner legend di Nganjuk yaitu Soto Pak Yon yang sudah ada sejak tahun 1985. Soto Pak Yon terkenal karena memadukan cita rasa soto dan kare. Kuahnya kuning kental bersantan hampir mirip kare. Perpaduan antara soto dan kare ini yang mungkin tidak akan bisa kamu temukan di tempat lain. Ada beberapa varian menu di sini yaitu soto ayam, soto daging dan nasi pecel. Kalau pesan soto, kamu bisa tambah lauk ceker, sayap atau kepala ayam. Kalau masih kurang tersedia telor puyuh, usus dan ampela ayam yang bisa kamu tambahkan ke mangkok.','Senin-Minggu 08.30 WIB-habis'),(6,' Kerupuk Pecel Bu Penik','Jl. Merapi, RT.01/RW.01, Besuk, Sukorejo, Kec. Loceret, Kabupaten Nganjuk','1777439547_55602a130423bddb5b8b4567.jpeg','Cuma di Nganjuk, ada olahan kuliner unik yaitu krupuk yang disajikan bersama pecel sebagai pengganti nasi atau lontong. Krucel, kependekan dari kerupuk pecel, disajikan bersama tambahan sayur-sayuran dan gorengan. Tak lupa ditambah siraman bumbu pecel di atasnya. Jangan lupa pesan es rujak buat hidangan penutup setelah makan kerupuk pecel. Harganya murah meriah cuma Rp6.000 aja per porsi. Kalau tambah gorengan, harganya mulai Rp1.000','Senin-Minggu 08.30-14.30 WIB'),(7,' Nasi Banting Warung Dipo','Jl. Ahmad Yani No.123, Payaman, Kec. Nganjuk, Kabupaten Nganjuk','1777439673_hq720.jpg','Kalau pingin makan yang ringan buat sarapan, kamu bisa cobain nasi banting khas Nganjuk. Sejatinya nasi banting adalah nasi bungkus yang di dalamnya berisi aneka lauk. Umumnya sebungkus nasi banting berisi nasi, mie goreng dan olahan tempe. Tak lupa sebagai teman makan ada aneka gorengan yang siap menemani. Kalau di Nganjuk kamu bisa beli nasi banting di Warung Dipo yang legendary.','Senin-Minggu 04.00-15.00 WIB'),(8,'Warung Mie Pak Tomie','Jl. Jenderal Gatot Subroto No.7, Kauman, Kec. Nganjuk, Kabupaten Nganjuk','1777439751_59ebcede0fc33-warung-mie-pak-tomie_1265_711.webp','Konon katanya warung mie Pak Tomie ini udah ada sejak tahun 1980. Penyajian makanan di sini masih tradisional menggunakan arang yang menambah cita rasa masakan. Soal menu, di sini kamu bisa pilih mie goreng, mie godok, mie nyemek dan nasi mawut serta nasi goreng. Biar makin nikmat, makanan yang kamu pesan bakal ditambahkan taburan bawang goreng dan acar. Auto kangen kampung halaman.','Senin-Minggu 10.00-01.00 WIB.');
/*!40000 ALTER TABLE `kuliner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Rizky','user@gmail.com','202cb962ac59075b964b07152d234b70'),(2,'jawa','jawa@gmail.com','$2y$10$xznIz3ZMfXTthqWZLktrAOBb9.uyW4ZGU.sp6hVYIN/qNph1QFn9W');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wisata`
--

DROP TABLE IF EXISTS `wisata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wisata` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `deskripsi` text,
  `lokasi` varchar(100) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `gambar` varchar(100) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wisata`
--

LOCK TABLES `wisata` WRITE;
/*!40000 ALTER TABLE `wisata` DISABLE KEYS */;
INSERT INTO `wisata` VALUES (5,'Wisata Nganjuk Jolotundo Glamping & Edu Park','cocok untuk nongkrong dan berbincang bincang dengan keluarga','Jalan Raya Bajulan Loceret, Plakat, Bajulan, Kec. Loceret, Kabupaten Nganjuk, Jawa Timur 64471','alam','1777353582_Jolotundo.jpeg','-7.5930','111.8492'),(6,'Air Terjun Roro Kuning','Air Terjun Roro Kuning-Indonesia adalah air terjun yang berada sekitar 27ΓÇô30 km selatan Kota Nganjuk, di ketinggian 600 m dpl dan memiliki tinggi antara 10ΓÇô15 m. Air terjun ini mengalir dari tiga sumber di sekitar Gunung Wilis yang mengalir merambat di sela-sela bebatuan padas di bawah pepohonan hutan pinus. Kemudian menjadi air terjun yang membentuk trisula. Dan karena proses mengalirnya itulah maka masyarakat Desa Bajulan menamakan air terjun merambat.','Unnamed Rd, Nglarangan, Bajulan, Kec. Loceret, Kabupaten Nganjuk, Jawa Timur 64471','alam','image-22-1024x681.png','7.779646','111.843955'),(7,'Air Terjun Sedudo','Obyek wisata air terjun di Nganjuk yang satu ini adalah salah satu air terjun yang fantastis di Indonesia. Ketinggiannya mencapai 105 Meter, berada di ketinggian dataran sekitar 1.438 Mdpl jadi udaranya dingin khas pegunungan ya gaes.\r\n\r\nLokasinya berada di Desa Ngliman yang ada di Kec Sawahan Kota Nganjuk Jawa Timur. Di tempat wisata alamdi Nganjuk ini anda akan mendapatkan pesona keindahan alam yang menakjubkan. Anda bisa sampai ke obyek wisata ini dengan mudah karena akses jalan. Dan transportasi yang baik juga sudah bisa anda nikmati untuk bisa sampai ke obyek wisata murah di Nganjuk ini. Air terjun ini juga di keramatkan oleh penduduk sekitar karena konon ada energi supranatural dari air terjun ini. Jadi tetap menjaga kesopanan ya gaes.','Jl. Sedudo, Hutan, Sawahan, Kec. Sawahan, Kabupaten Nganjuk, Jawa Timur 64475','alam','sepasangcarrier 1.jpg','-7.781032','111.757512'),(8,'Air Terjun Singokromo','Obyek wisata air terjun yang satu ini memang sangat indah. Ketinggian air terjun ini hanya 20 meter.\r\n\r\nTetapi pemandangan yang menawan bisa anda nikmati di tempat rekreasi di Nganjuk ini. Jadi sayang sekali jika liburan anda di kota Nganjuk tanpa mengunjungi obyek wisata yang satu ini.\r\n\r\nLokasi air terjun Singokromo ini berada di Desa Ngliman. Desa yang satu ini terletak di Kecamatan Sawahan, Kab Nganjuk Jawa Timur.\r\n\r\nObyek wisata di Nganjuk yang murah ini masih alami. Sehingga akses jalannya belum baik dan sedikit menyulitkan perjalanan anda menuju air terjun Singokromo ini.\r\nJarak lokasi air terjun ini dari Kota Nganjuk hanya berjarak sekitar 3 Km saja, jadi lumayan dekat gaes. Lokasinya pun berdekatan dengan lokasi air terjun Sedudo yang terkenal itu, jadi anda harus menyambanginya ya','Hutan, Ngliman, Kec. Sawahan, Kabupaten Nganjuk, Jawa Timur 64475','alam','images.jpeg','-7.777658','111.766675'),(9,'Goa Margo Tresno','Lokasi Goa ini ada di Desa Sugih Waras, Kecamatan Ngluyu, Kabupaten Nganjuk, tepatnya di Dusun Cabean. Goa dengan suasana mistis dan magis bisa anda jumpai di goa Margo ini. Di dalam goa ini belum ada fasilitas penerangan sehingga suasananya masih gelap dan di huni ribuan hewan malam yaitu kelelawar. Lokasi wisata goa di Nganjuk ini ada didalam hutan jati yang berada di kawasan Pegunungan Kendeng. Di kawasan goa ini anda juga bisa mandi di kolam yang ada di depan Goa. Menikmati airnya yang segar dan bersih pastinya akan mengobati lelahnya perjalanan anda menuju goa Margo ini. Jadi sangat menarik untuk anda kunjungi bukan?','HW3P+H5V, Hutan, Ngluyu, Kec. Ngluyu, Kabupaten Nganjuk, Jawa Timur 64452','alam','Margo_Tresno_Cave_9.jpg','-7.445850','111.935468'),(10,'Taman Anjuk Ladang','Tempat wisata keluarga di Nganjuk ini ada di dekat Stadion Anjuk Ladang Nganjuk. Dari pusat kota berjarak sekitar 2 km ke selatan. jadi sangat dekat bukan? Di tempat piknik di nganjuk ini anda bisa jogging karena ada jogging track. Serta ada camping area yang bisa di gunakan untuk berkemah. Ada beberapa hewan koleksi di taman ini yang bisa anda lihat seperti burung, rusa, kera dan yang lainnya. Sangat cocok untuk destinasi liburan anda dan keluarga.','Jl. Anjuk Ladang Lapak No.12, Ploso, Kec. Nganjuk, Kabupaten Nganjuk, Jawa Timur','buatan','2671722200.webp','','');
/*!40000 ALTER TABLE `wisata` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-17 16:32:00

-- --------------------------------------------------------
-- Table structure for table `reviews`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipe` varchar(20) NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `komentar` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
