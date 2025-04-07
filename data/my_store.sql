-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table my_store.account
CREATE TABLE IF NOT EXISTS `account` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.account: ~3 rows (approximately)
INSERT INTO `account` (`id`, `username`, `password`, `role`) VALUES
	(1, 'Hoanganh779', '$2y$10$V5rAOPA7btFnkzWk.B5L2u2HTNdWS/4WbrS0BusVoixF593hL/hgO', 'admin'),
	(2, 'User1', '$2y$12$Ok/rOMLBCgdT5uVllNBAY.ah2fNxWtA3nWZo2RRTzIUpZxoPV1lvy', 'user'),
	(3, 'Admin', '$2y$12$kmjIgFzrEDqBLX1uHATrvOx0KoHIz7WdVelL/x1QEnK/JQWYThnEe', 'admin');

-- Dumping structure for table my_store.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.category: ~4 rows (approximately)
INSERT INTO `category` (`id`, `name`, `description`) VALUES
	(4, 'Trà Trái Cây', 'Trái Cây'),
	(5, 'Trà Sữa', 'Trà &amp; Sữa'),
	(6, 'Cà Phê', 'Cà Phê'),
	(7, 'Đá Xay', 'Đá Xay');

-- Dumping structure for table my_store.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.orders: ~2 rows (approximately)
INSERT INTO `orders` (`id`, `name`, `phone`, `address`, `created_at`) VALUES
	(1, 'Nguyễn Hoàng Anh', '0968119957', '72 Ninh Hưng 2 , Chà Là , Dương Minh Châu ,Tây Ninh', '2025-03-22 13:03:35'),
	(2, 'Nguyễn Hoàng Long', '0968119957', '72 Ninh Hưng 2 , Chà Là , Dương Minh Châu ,Tây Ninh', '2025-03-27 03:21:45');

-- Dumping structure for table my_store.order_details
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_details_chk_1` CHECK ((`quantity` > 0)),
  CONSTRAINT `order_details_chk_2` CHECK ((`price` >= 0))
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.order_details: ~4 rows (approximately)
INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
	(1, 1, 11, 2, 55000.00),
	(2, 1, 10, 12, 45000.00),
	(3, 2, 9, 6, 65000.00),
	(4, 2, 8, 6, 55000.00);

-- Dumping structure for table my_store.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.product: ~8 rows (approximately)
INSERT INTO `product` (`id`, `name`, `description`, `price`, `image`, `category_id`) VALUES
	(8, 'Hồng trà đào', 'Hương vị trà cùng vị đào thơm ngon', 55000.00, 'uploads/67dd15117a75e-hongtradao.png', 4),
	(9, 'Trà sữa phúc long', 'Hương vị trà được tinh chọn từ những vườn trà tốt nhất cùng các chú bò chất lượng', 65000.00, 'uploads/67dd1592be918-trasuaphuclong.png', 5),
	(10, 'Bạc xỉu', 'Một lượng sữa lớn cùng 1 chút cà phê', 45000.00, 'uploads/67dd15f951ccd-bacxiu.png', 6),
	(11, 'Matcha đá xay', 'Cảm nhật hương vị matcha the mát', 55000.00, 'uploads/67dd164bc37a1-matchadaxay.png', 7),
	(26, 'Trà Lucky', 'Trà kết hợp với vị cam mang đậm chất riêng', 55000.00, 'uploads/67e50ad714af8-tralucky.png', 4),
	(27, 'Cà phê đá xay', 'Hương vị mới công thức được kết hợp giữ cà phê truyền thống và đá xay', 50000.00, 'uploads/67e50b72cc08e-8a92bb4b37c012-cafe5mon01.png', 6),
	(28, 'Trà sữa matcha', 'Vị trà sữa kết hợp với matcha ', 65000.00, 'uploads/67e50bbd878b6-matcha-milktea.png', 5),
	(29, 'Chanh đá xay', 'Hương vị chanh giúp tăng sự the mát trong từng ngụm đá xay', 60000.00, 'uploads/67e50e8d990cc-chanhdaxay.png', 7);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
