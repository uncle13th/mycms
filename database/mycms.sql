-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        5.7.26 - MySQL Community Server (GPL)
-- 服务器操作系统:                      Win64
-- HeidiSQL 版本:                  12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- 导出 mycms 的数据库结构
CREATE DATABASE IF NOT EXISTS `mycms` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `mycms`;

-- 导出  表 mycms.admins 结构
CREATE TABLE IF NOT EXISTS `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_super` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_username_unique` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  mycms.admins 的数据：1 rows
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` (`id`, `name`, `username`, `password`, `avatar`, `is_super`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'admin', 'admin', '$2y$10$RgciGvCdsMAq5FgOWkeiZuFiCd9R/V.0ap33lqNADnsO7tUr2Ek0a', NULL, 1, 'xVB3gGXflmLs5FbNbb6PWG6DGsG8vxJX5dBSH59BpQQRWzhnzH7SLhutzSto', '2024-12-24 17:18:54', '2024-12-25 09:31:55', NULL);
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;

-- 导出  表 mycms.categories 结构
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  mycms.categories 的数据：~4 rows (大约)
INSERT INTO `categories` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
	(1, '手机数码', '手机、平板电脑等数码产品', 1, '2024-12-25 16:56:45', '2024-12-25 16:56:45'),
	(2, '电脑办公', '笔记本电脑、打印机等办公设备', 1, '2024-12-25 16:56:45', '2024-12-25 16:56:45'),
	(3, '家用电器', '电视、冰箱、洗衣机等家电产品', 1, '2024-12-25 16:56:45', '2024-12-25 16:56:45'),
	(4, '服装服饰', '男装、女装、童装等服装类', 1, '2024-12-25 16:56:45', '2024-12-25 16:56:45');

-- 导出  表 mycms.migrations 结构
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  mycms.migrations 的数据：0 rows
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- 导出  表 mycms.products 结构
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'zh_cn',
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  mycms.products 的数据：~12 rows (大约)
INSERT INTO `products` (`id`, `name`, `category_id`, `language`, `image_url`, `description`, `content`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'iPhone 14 Pro', 1, 'zh_CN', 'https://picsum.photos/200/200?random=1', NULL, 'iPhone 14 Pro 256GB 暗紫色 5G全网通手机', 1, '2024-12-25 16:56:45', '2024-12-25 16:56:45'),
	(2, 'MacBook Pro', 2, 'en', 'https://picsum.photos/200/200?random=2', NULL, '2023款 MacBook Pro 14英寸 M2芯片', 1, '2024-12-25 16:56:45', '2024-12-25 16:56:45'),
	(3, '华为 Mate 60', 1, 'zh_CN', 'https://picsum.photos/200/200?random=3', NULL, '华为 Mate 60 Pro 12GB+512GB 雅黑色', 1, '2024-12-25 16:56:45', '2024-12-25 16:56:45'),
	(4, '戴尔显示器', 2, 'zh_CN', 'https://picsum.photos/200/200?random=4', NULL, '戴尔 27英寸 2K高清显示器 IPS屏', 1, '2024-12-25 16:56:45', '2024-12-25 16:56:45'),
	(5, '海尔冰箱', 3, 'zh_CN', 'https://picsum.photos/200/200?random=5', NULL, '海尔 325升 变频风冷无霜三门冰箱', 1, '2024-12-25 16:56:45', '2024-12-25 16:56:45'),
	(6, '小米电视', 3, 'zh_CN', 'https://picsum.photos/200/200?random=6', NULL, '小米电视 65英寸 4K超高清 智能电视', 0, '2024-12-25 16:56:45', '2024-12-25 16:56:45'),
	(7, 'Nike运动鞋', 4, 'zh_CN', 'https://picsum.photos/200/200?random=7', NULL, 'Nike Air Max 运动鞋 休闲跑步鞋', 1, '2024-12-25 16:56:45', '2024-12-25 16:56:45'),
	(8, '联想笔记本', 2, 'zh_CN', 'https://picsum.photos/200/200?random=8', NULL, '联想 ThinkPad E14 14英寸商务笔记本', 1, '2024-12-25 16:56:45', '2024-12-25 16:56:45'),
	(9, '索尼相机', 1, 'zh_TW', 'https://picsum.photos/200/200?random=9', NULL, '索尼 Alpha 7M4 全画幅微单相机', 0, '2024-12-25 16:56:45', '2024-12-25 16:56:45'),
	(10, '三星手机', 1, 'zh_CN', 'https://picsum.photos/200/200?random=10', NULL, '三星 Galaxy S23 Ultra 12GB+256GB', 1, '2024-12-25 16:56:45', '2024-12-25 16:56:45'),
	(11, '华硕主板', 2, 'zh_CN', 'https://picsum.photos/200/200?random=11', NULL, '华硕 ROG STRIX B760-A 游戏主板', 1, '2024-12-25 16:56:45', '2024-12-25 16:56:45'),
	(12, '格力空调', 3, 'zh_CN', 'https://picsum.photos/200/200?random=12', NULL, '格力 1.5匹 变频冷暖 壁挂式空调', 1, '2024-12-25 16:56:45', '2024-12-25 16:56:45');

-- 导出  表 mycms.users 结构
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在导出表  mycms.users 的数据：0 rows
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
