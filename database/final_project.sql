-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2024 at 02:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `final_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `parent_comment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `user_id`, `user_name`, `image`, `comment_text`, `created_at`, `parent_comment_id`) VALUES
(195, 128, 81, 'JEEN BUS', 'image/b6ae1ef9-af49-477b-9ca4-7686b5c42a7a.png', 'สนใจครับ', '2024-08-07 08:22:42', 0),
(220, 128, 1, 'pongsapak ploymaklam', 'image/EVs_02catrageuwu.gif', 'สนใจรองเท้าคู่นี้ครับ', '2024-08-15 12:21:06', 0),
(221, 128, 30, 'user 05', 'image/43680024_461808450994213_8369796343891230720_n.jpg', 'ได้เลยครับเจอกันที่จุดนัดพบตามที่ปักเลยครับ', '2024-08-15 17:43:14', 220),
(245, 128, 30, 'user 05', 'image/43680024_461808450994213_8369796343891230720_n.jpg', 'ขายจ้า', '2024-08-27 07:01:09', 0),
(274, 177, 1, 'pongsapak ploymaklam', 'image/EVs_02catrageuwu.gif', 'ลดได้ไหมครับ', '2024-09-04 07:34:23', 0),
(275, 177, 93, 'user 15', 'image/user_defalt_image/pngtree-women-cartoon-avatar-in-flat-style-png-image_6110776.png', 'ลดได้500ครับ', '2024-09-04 07:35:13', 274),
(276, 177, 1, 'pongsapak ploymaklam', 'image/EVs_02catrageuwu.gif', 'ได้ครับ', '2024-09-04 07:35:46', 275);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `location_id` int(255) NOT NULL,
  `location_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location_id`, `location_name`) VALUES
(2, 'อาคารศูนย์สังคมและพัฒนา'),
(3, 'อาคารหอประชุมสิริวรปัญญา'),
(4, 'อาคารกิจการนักศึกษา'),
(5, 'อาคาร 15 ชั้น '),
(6, 'อาคารศูนย์ภาษาและศูนย์คอมพิวเตอร์ (LI)'),
(7, 'สำนักวิทยบริการ'),
(8, 'คณะครุศาสตร์ (ใหม่) (EDU)'),
(9, 'คณะวิทยาศาสตร์และเทคโนโลยี (SC)'),
(10, 'คณะมนุษย์ศาสตร์และสังคมศาสตร์ (ใหม่) (HS)'),
(11, 'คณะวิทยาการจัดการ (โลจิสติก/Lo)'),
(12, 'คณะพยาบาลศาสตร์ (NU)'),
(13, 'สำนักคอมพิวเตอร์'),
(14, 'อาคาร A7 (A7)'),
(15, 'อาคารศูนย์ปฏิบัติการคอมพิวเตอร์ (C)'),
(16, 'อาคาร A3 (A3)'),
(17, 'คณะครุศาสตร์ (เก่า) (A5)'),
(18, 'ETB (ETB)'),
(19, 'ตึกทราวดี (ท)'),
(20, 'อาคารร้อยปีฝึกหัดครูไทย (อเนก)'),
(21, 'อาคาร A1 (A1)'),
(22, 'โรงอาหาร'),
(23, 'โรงเรียนสาธิต (ม.)'),
(24, 'อาคารหอพักนานาชาติ'),
(25, 'สระมรกต'),
(26, 'Sport Complex'),
(27, 'อาคาร A4 (A4)'),
(28, 'อาคาร A2 (A2)'),
(29, 'โรงอาหารใหม่'),
(30, 'วิศวะกรรมโยธา'),
(31, 'เกษตร (เกษตร)'),
(32, 'ศูนย์สาธิตการศึกษาปฐมวัย'),
(33, 'สระว่ายน้ำ'),
(34, 'อาคารศิษย์เก่า'),
(35, 'ศาลาเฟื้องฟ้า'),
(36, '7-11'),
(37, '(สอบถามในคอมเมนต์)');

-- --------------------------------------------------------

--
-- Table structure for table `notify`
--

CREATE TABLE `notify` (
  `id` int(255) NOT NULL,
  `notify_status` tinyint(1) NOT NULL,
  `titles` varchar(255) NOT NULL,
  `post_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `user_notify_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notify`
--

INSERT INTO `notify` (`id`, `notify_status`, `titles`, `post_id`, `user_id`, `user_notify_id`) VALUES
(88, 1, '', 154, 32, 81),
(114, 1, '', 153, 31, 1),
(115, 1, '', 153, 31, 1),
(122, 1, 'ปิดการซื้อขาย', 128, 81, 30),
(123, 1, '', 156, 82, 83),
(124, 1, '', 156, 82, 84),
(133, 1, '', 154, 32, 31),
(134, 1, '', 153, 32, 86),
(135, 1, '', 156, 82, 88),
(136, 1, '', 155, 26, 1),
(137, 1, '', 155, 26, 1),
(138, 1, '', 155, 26, 1),
(139, 1, '', 153, 32, 1),
(146, 1, '', 154, 32, 30),
(151, 1, '', 170, 89, 85),
(159, 1, '', 154, 32, 1),
(169, 1, 'ลบประกาศแล้ว', 175, 30, 1),
(191, 1, '', 177, 93, 1),
(192, 1, '', 177, 1, 93),
(193, 1, '', 177, 93, 1),
(194, 1, 'ปิดการซื้อขาย', 177, 1, 93);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `posts_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `type_id` int(11) NOT NULL,
  `sub_type_id` int(11) NOT NULL,
  `phone_number` varchar(10) NOT NULL,
  `location_id` int(255) NOT NULL,
  `Product_detail` varchar(255) NOT NULL,
  `type_buy_or_sell` varchar(255) NOT NULL,
  `product_price_type` varchar(255) NOT NULL,
  `product_price` varchar(255) NOT NULL,
  `Product_img` varchar(255) NOT NULL,
  `datasave` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`posts_id`, `product_name`, `type_id`, `sub_type_id`, `phone_number`, `location_id`, `Product_detail`, `type_buy_or_sell`, `product_price_type`, `product_price`, `Product_img`, `datasave`, `user_id`) VALUES
(122, 'จิตวิทยาสายดาร์ก', 1, 5, '0912345678', 19, 'มือ 1 ยังไม่ได้แกะซีล', 'ปิดการซื้อขาย', 'ราคาคงที่', '220', '[\"66a001ff55351.jpg\"]', '2024-08-12 14:33:14', 1),
(124, 'รถยนต์ไม่ใช้แล้ว', 5, 20, '0888888888', 13, 'เลขไมค์แค่ 30000 สภาพดีไม่ใช้แล้ว', 'ปิดการซื้อขาย', 'ราคาคงที่', '100000', '[\"66a005e67a24b.jpg\"]', '2024-08-15 18:45:33', 1),
(128, 'nike air jordan 1 x travis scott olive', 4, 14, '0131313441', 5, 'มือ1 size 9.5 us ซื้อมาใส่ไม่ได้', 'ขาย', 'ต่อรองได้', '40000', '[\"66a09d30c88e1.png\",\"66a09d30c8a95.jfif\",\"66a09d30c8c6d.jfif\",\"66a09d30c8ea0.jfif\",\"66a09d30c9037.jfif\",\"66a09d30c931c.jpg\",\"66d8190972d64.png\",\"66d8190972f2f.png\",\"66d81909730e6.jpg\",\"66d819097334d.jpg\",\"66d8193e1048d.jpg\",\"66d8193e10650.jpg\"]', '2024-09-04 08:24:30', 30),
(140, 'I phone 14 pro max', 2, 6, '0888888888', 37, 'ใช้งานแค่ปีเดียว อายุแบต86%', 'ขาย', 'ต่อรองได้', '30000', '[\"66a633135664f.jpg\",\"66a6331356809.jpg\",\"66a6331356a12.jpg\",\"66a6331356c1b.jpg\",\"66a6331356eab.jpg\"]', '2024-08-03 14:09:55', 75),
(151, 'Click150 สีเทา มือสองศูนย์ฯ ปี 2018 สภาพสวย', 5, 19, '0434534534', 3, '- ราคาเงินสด 39,000 บ. + ค่าโอน 1,000 บ.\r\n- ระยะไมล์ 36,203 กม.\r\n- รถมือสองสภาพเกรดทั่วไป\r\n- เครื่องดี สีสวย สภาพใช้งานได้\r\n- ระบบหัวฉีดใช้งานได้ปกติ\r\n- ระบบส่งกำลังด้วยสายพานใช้งานได้ปกติ', 'ขาย', 'ต่อรองได้', '39000', '[\"66b2e18913b6e.png\",\"66b2e18913e9f.png\",\"66b2e1891410c.png\",\"66b2e34a5b293.png\",\"66b2e34a5b4a4.jpg\",\"66b2e34a5b85c.jpg\",\"66b2e34a5bd5b.png\"]', '2024-08-07 03:00:26', 28),
(152, 'ตามหาโน๊ตบุ๊ครุ่นนี้ครับ', 2, 7, '0861617498', 37, 'ตามหาโน๊ตบุ๊คตามภาพครับ งบ 45000', 'ซื้อ', 'ราคาคงที่', '45000', '[\"66b2e72febb8b.png\",\"66b2e72febd59.jfif\"]', '2024-08-17 15:28:17', 31),
(153, 'ส่งต่อเสื้อผ้าแฟชั่น ', 3, 10, '0648941849', 5, 'ส่งต่อเสื้อผ้าแฟชั่น /แบรนด์ ตัวละ 50฿ \r\nไม่มีตำหนิ ขนาดระบุไว้ในภาพนะคะ \r\nตัวไหนขายแล้ว จะลบออกค่ะ', 'ขาย', 'ราคาคงที่', '50', '[\"66b2e82294d70.jpg\",\"66b2e82294f7e.jpg\",\"66b2e82295212.jpg\",\"66b2e82295507.jpg\",\"66b2e822956f3.jpg\"]', '2024-08-19 04:18:26', 32),
(154, 'louis vuitton clutch vintage', 3, 13, '0610910925', 14, 'สภาพมีตำหนินะคะ ราคารวมส่ง', 'ขาย', 'ต่อรองได้', '2000', '[\"66b2e9d5632ae.png\",\"66b2e9d56347b.png\",\"66b2e9d56360f.png\",\"66b2e9d56381c.jpg\",\"66b2e9d5681f2.png\",\"66b2e9d56bfde.jpg\"]', '2024-09-01 06:04:52', 32),
(155, 'ตามหาหนังสือเล่มนี้ค่ะ', 1, 5, '0816426426', 14, 'ตามหาหนังสือเล่มนี้ค่ะใครมีเสนอราคามาได้เลย', 'ซื้อ', 'ฟรี', '0', '[\"66b2ea46883ff.png\"]', '2024-08-17 15:28:38', 26),
(156, 'จักรยาน Giant รุ่น Escape ปี 2018', 5, 18, '0895612312', 25, '3x7 Gear Shimano\r\n\r\nใช้งานน้อยไม่ถึง 500 km รีบขายเพราะไปต่างประเทศ', 'ขาย', 'ต่อรองได้', '4650', '[\"66b2ecd468b13.jpg\",\"66b2ecd468cc6.png\",\"66b2ecd468ee9.png\",\"66b2ecd4690e7.jpg\"]', '2024-08-17 15:28:56', 82),
(164, 'adidas พื้นกั๊ม แท้ ? size 41.5 ยาว 26', 4, 14, '0564686259', 30, 'รองเท้า adidas ของแท้  พื้นกั๊มสีน้ำตาลเข้ม\r\n** ไม่ใช่รุ่นแซมบ้า ** สภาพดี พื้นเต็ม\r\nมีเก็บสีเล็กน้อย (ดูในรูป) size 41.5 ยาว 26', 'ขาย', 'ต่อรองได้', '490', '[\"66ce7a8fd47c7.jpg\",\"66ce7a8fd4cea.jpg\",\"66ce7a8fd502f.jpg\",\"66ce7a8fd52b3.jpg\",\"66ce7a8fd5554.jpg\"]', '2024-08-28 01:17:29', 86),
(165, 'ขายด่วน AirPodsPro ของแท้ มีประกันจาก Apple', 2, 9, '0564686259', 30, 'ขายขายขายขายขายขายขาย', 'ขาย', 'ต่อรองได้', '5300', '[\"66ce7b6347590.jpg\",\"66ce7b634796d.jpg\"]', '2024-08-28 01:20:35', 86),
(166, 'ขาย Forza 350 รถบ้านมือเดียวออกป้ายแดง', 5, 19, '0648941849', 35, 'ขาย Forza 350 ปี 2020 สภาพนางฟ้า รถบ้านออกป้ายแดงมือเดียว ไม่เคยซ่อมไม่เคยชน รับประกันหน้า 18 สะอาด สนใจมาดูรถได้ที่จอหอนครราชสีมา ผ่อนได้ถ้าเครดิตดี โทร 090-181-58 43 ID LINE ผมเบอร์นี้ครับ ส่งได้ทั่', 'ขาย', 'ราคาคงที่', '139000', '[\"66ce7ef9789b2.jpg\",\"66ce7ef978d41.jpg\",\"66ce7f0acaf34.jpg\",\"66ce7f872a4de.jpg\"]', '2024-08-28 01:38:15', 79),
(167, 'ตามหา Stussy 8 Ball Tee Pigment Dyed Natural', 3, 10, '0565449648', 32, 'ตามหาครับเสนอราคามาได้', 'ซื้อ', 'ฟรี', '0', '[\"66ce82cd2ad41.jfif\",\"66ce82cd2af76.jpg\"]', '2024-08-28 01:52:13', 88),
(168, 'Vintage Samurai Jack Shirt Y2K Anime Cartoon Network ', 3, 10, '080494984', 22, 'Size : 23” x 28.5” ( Size XL )\r\nCondition : 8.5/10', 'ขาย', 'ต่อรองได้', '2499', '[\"66ce83dba4fa3.jpg\",\"66ce83dba534c.jpg\",\"66ce83dba5904.jpg\",\"66ce83dbab0f0.jpg\",\"66ce83dbab6ac.jpg\"]', '2024-08-28 01:57:11', 85),
(170, 'ตามหา หนังสือ Harry Potter (ปกเก่า) แปลไทย ใครมีบอกหน่อยนะคะ?', 1, 3, '0846156848', 11, 'ตามหา หนังสือ Harry Potter (ปกเก่า) แปลไทย ใครมีบอกหน่อยนะคะ? ตามหา หนังสือ Harry Potter (ปกเก่า) แปลไทย ใครมีบอกหน่อยนะคะ?', 'ซื้อ', 'ฟรี', '0', '[\"66ce8745f2a39.jfif\",\"66ce8745f2e8e.jfif\"]', '2024-08-28 02:11:17', 89),
(171, 'ตามหา รองเท้าคัทชูหนังแก้ว แบบในรูป', 4, 16, '0846156848', 12, 'หา size : 43 ใครมีเสนอราคามาได้เลยคะ', 'ซื้อ', 'ฟรี', '0', '[\"66ce89fd28857.jfif\",\"66ce89fd28aaa.jpg\"]', '2024-08-28 02:23:09', 89),
(177, 'iPad air5 wifi และ Sim', 2, 8, '0564565464', 25, 'iPad air5 Wifi+Cellular\r\nอุปกรณ์ กล่องครบ\r\nแถมเคส\r\nใช้งานน้อย ติดฟิล์ม รอบเครื่อง และฟิล์มหน้า+หลัง\r\nสภาพเหมือนใหม่ ไม่ค่อยได้ใช้งาน', 'ปิดการซื้อขาย', 'ราคาคงที่', '17000', '[\"66d80d2db718d.png\",\"66d80d2db73bf.png\",\"66d80d2dbaea2.png\",\"66d80d2dbb1e7.png\"]', '2024-09-04 07:36:32', 93);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `rating_id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `ratings` tinyint(1) NOT NULL,
  `post_id` int(255) NOT NULL,
  `user_post_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`rating_id`, `user_id`, `ratings`, `post_id`, `user_post_id`) VALUES
(1, 1, 0, 144, 1),
(2, 1, 1, 140, 75),
(3, 1, 0, 128, 30),
(4, 1, 1, 122, 1),
(5, 79, 1, 128, 30),
(7, 31, 0, 151, 28),
(8, 23, 0, 140, 75),
(9, 30, 1, 128, 30),
(11, 75, 0, 151, 28),
(12, 1, 0, 153, 31),
(13, 83, 0, 155, 26),
(14, 83, 0, 153, 32),
(15, 30, 1, 159, 84),
(16, 1, 0, 155, 26),
(17, 1, 0, 154, 32),
(18, 1, 0, 171, 89);

-- --------------------------------------------------------

--
-- Table structure for table `sub_type`
--

CREATE TABLE `sub_type` (
  `sub_type_id` int(11) NOT NULL,
  `sub_type_name` varchar(255) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sub_type`
--

INSERT INTO `sub_type` (`sub_type_id`, `sub_type_name`, `type_id`) VALUES
(2, 'หนังสือเรียน', 1),
(3, 'หนังสือนิยาย', 1),
(4, 'หนังสือการ์ตูน', 1),
(5, 'หนังสืออื่นๆทั่วไป', 1),
(6, 'โทรศัพท์', 2),
(7, 'โน๊ตบุ๊ค', 2),
(8, 'ไอแพด', 2),
(9, 'อื่นๆ', 2),
(10, 'เสื้อ', 3),
(11, 'กางเกง', 3),
(12, 'ถุงเท้า', 3),
(13, 'อื่นๆ', 3),
(14, 'รองเท้าผ้าใบ', 4),
(15, 'รองเท้าแตะ', 4),
(16, 'รองเท้าคัทชู', 4),
(17, 'อื่นๆ', 4),
(18, 'จักรยาน', 5),
(19, 'มอเตอร์ไซต์', 5),
(20, 'รถยนต์', 5),
(21, 'อื่นๆ', 5),
(44, 'เก้าอี้', 29),
(45, 'โต๊ะ', 29);

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`type_id`, `type_name`) VALUES
(1, 'หนังสือ'),
(2, 'อุปกรณ์อิเล็กทรอนิกส์'),
(3, 'เครื่องแต่งกาย'),
(4, 'รองเท้า'),
(5, 'ยานพาหนะ'),
(29, 'เฟอรนิเจอร์');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_photo` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `user_tel` varchar(10) NOT NULL,
  `urole` varchar(255) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `email`, `password`, `user_photo`, `user_address`, `user_tel`, `urole`, `create_at`) VALUES
(1, 'pongsapak', 'ploymaklam', '644230048@webmail.npru.ac.th', '$2y$10$ByfYIXbPTQo.30IGfnf4rOBQIcmABJXXIemshrhqmeJk3fwNX0Yna', 'image/EVs_02catrageuwu.gif', '14/2 ต.หน้าเมือง อ.เมือง จ. ราชบุรี ', '0947959364', 'admin', '2024-02-19 18:54:48'),
(23, 'J!FZz', 'Peaa', 'ppongsapak12345@gmail.com', '$2y$10$duxuo7mn2HM07CzpHX342uRprnNh54T01t11/zXLRjnFU5N7pPvOK', '', '', '0', 'user', '2024-07-18 14:38:46'),
(26, 'user', '01', 'user01@gmail.com', '$2y$10$7TKaOBC9eOkR86WYxhyfWOW6Kzm2WMep./c1etF3OQzNl2S.txU8S', '', '', '0', 'user', '2024-07-23 18:58:52'),
(28, 'user', '03', 'user03@gmail.com', '$2y$10$aroJM4Q9NCXrVa9.Nhj9a.TPtpP13IEQl4NrdtZb9hsQs9K6JDHQG', '', '', '0', 'user', '2024-07-23 19:03:56'),
(30, 'user', '05', 'user05@gmail.com', '$2y$10$9BqXGJdaTtvmTny94toXjuxDJGkmmZZY6BYLv08XyIKvU6wpv51Fy', 'image/43680024_461808450994213_8369796343891230720_n.jpg', '', '0', 'user', '2024-07-23 19:08:00'),
(31, 'user', '06', 'user06@gmail.com', '$2y$10$m8X3j0fiW0Bc5C.ve1o4WOr1fWTgOetuKzDr0Amo5ynna3M9w9fJy', '', '', '0', 'user', '2024-07-23 19:11:31'),
(32, 'user', '07', 'user07@gmail.com', '$2y$10$4U0FMgDuiBFntQql.gxeZOXVj12.hez1NLc2PzuHEVGkfCytdADbe', '', '', '0', 'user', '2024-07-23 19:12:13'),
(75, 'user', '04', 'user04@gmail.com', '$2y$10$9dgTeV5zvIsaVppqfEAAAeKG3yCBiN0rS0dkilXKvJigehtHKCsxC', 'image/images (1).jfif', '', '0', 'user', '2024-07-28 11:49:53'),
(79, 'user', '02', 'user02@gmail.com', '$2y$10$XtiK2FXlKJQLqGKMwM6ctepunYdtIYD.sOwaOg/WMjzUjP52jGPKG', '', '', '0648941849', 'user', '2024-08-06 16:45:13'),
(81, 'JEEN', 'BUS', 'jeen@gmail.com', '$2y$10$9dxHis0WmVe9vKSLmrtzhuQuIG5ua917AQsma5QZoHYejMUvOm2ty', 'image/b6ae1ef9-af49-477b-9ca4-7686b5c42a7a.png', 'xxx xxxx xxx xxx ', '939211123', 'admin', '2024-08-07 06:34:20'),
(82, 'konlawich', 'thhawon', '644230003@webmail.npru.ac.th', '$2y$10$sjgyGagFPOJwoeVGTj/jce3x5FBXXBhvd3i1BBsElJo0B1YGWwv4W', 'image/d8ade030-4958-4b9c-8cdc-eb9b2e25117c.jpg', '', '985465452', 'user', '2024-08-07 08:33:19'),
(83, 'admin', 'admin', 'admin@gmail.com', '$2y$10$LrfGIvT82qHgHWCP1pdZpeBELm.dchp7MJJlhzWhfqJfTv3aspESG', 'image/test.jpg', '', '0', 'admin', '2024-08-09 06:00:47'),
(84, 'Clerk', 'Kent', 'superman@superhero.com', '$2y$10$J5hU5f.wWzVWpmIaj6Yufeehz927LSF5rg2UQyXaIzjGYWhT6jS1m', '', '', '0', 'user', '2024-08-20 09:45:14'),
(85, 'user', '09', 'user09@gmail.com', '$2y$10$fxWo6eSvz.gG.IsYB9RLSe/BBk6MRw4uEkKogbnXPOEd0PvIbNN3m', 'image/1012090.jpg', 'ต.ป่าไก่ อ.ปากท่อ จ.ราชบุรี', '080494984', 'user', '2024-08-20 16:13:16'),
(86, 'user', '08', 'user08@gmail.com', '$2y$10$yW8OEfaQR2N4UBDYjCfFseHgIqeIsM4N7vXQq7gmvSUV57QHDACf2', 'image/user_defalt_image/1127345.png', '15 ม1 ต. ปากไก่ อ. ปากท่อ', '0564686259', 'user', '2024-08-21 16:37:12'),
(88, 'user', '11', 'user11@gmail.com', '$2y$10$R8lLth/ym1Qhe/NtyU6/A.OanzQTsW0TJUfFeYm4eaUEfgip0V2.e', 'image/user_defalt_image/pngtree-women-cartoon-avatar-in-flat-style-png-image_6110776.png', 'ต.เมือง อ. หน้าเมือง จ.ราชบุรี', '0565449648', 'user', '2024-08-21 16:40:24'),
(89, 'user', '12', 'user12@gmail.com', '$2y$10$lQ01hRBS2.saXFuLUhb3oOaJuaO.EthVWdzsxI607JmrjnxX/zkdO', 'image/user_defalt_image/pngtree-cartoon-man-avatar-vector-ilustration-png-image_6111064.png', '18/4 ต. ดอนตะโก อ. เมือง จ.ราชบุรี', '0846156848', 'user', '2024-08-28 02:08:53'),
(91, 'user', '14', 'user14@gmail.com', '$2y$10$Itpf7qz0l6nloeuWeyvcIelSFHMjkQhCF8m8PKu.buYW/0fkZT8Xi', 'image/user_defalt_image/pngtree-cartoon-man-avatar-vector-ilustration-png-image_6111064.png', '18 ม5 ต. ปากไก่ อ. ปากท่อ', '0849556144', 'user', '2024-08-30 07:10:39'),
(93, 'user', '15', 'user15@gmail.com', '$2y$10$0a/vCoXwpNVTHfxGIrrrHebO6V0qhWHY45sSQ086U6xjvs6K/93gC', 'image/user_defalt_image/pngtree-women-cartoon-avatar-in-flat-style-png-image_6110776.png', '15/1ต..หน้าเมืองอ.เมืองจ.ราชบุรี', '0564565464', 'user', '2024-09-04 07:30:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `posts_id` (`post_id`) USING BTREE;

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `notify`
--
ALTER TABLE `notify`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `posts_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`posts_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `sub_type_id` (`sub_type_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `position_id` (`location_id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`rating_id`);

--
-- Indexes for table `sub_type`
--
ALTER TABLE `sub_type`
  ADD PRIMARY KEY (`sub_type_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=277;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `location_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=280;

--
-- AUTO_INCREMENT for table `notify`
--
ALTER TABLE `notify`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `posts_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `rating_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `sub_type`
--
ALTER TABLE `sub_type`
  MODIFY `sub_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`posts_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
