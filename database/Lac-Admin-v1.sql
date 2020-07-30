/*
 Navicat Premium Data Transfer

 Source Server         : 330657
 Source Server Type    : MySQL
 Source Server Version : 50717
 Source Host           : localhost:3306
 Source Schema         : laravel-admin-cms

 Target Server Type    : MySQL
 Target Server Version : 50717
 File Encoding         : 65001

 Date: 12/06/2020 16:46:04
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `permission` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_menu
-- ----------------------------
INSERT INTO `admin_menu` VALUES (1, 0, 1, '首页', 'fa-bar-chart', '/', NULL, NULL, '2019-11-08 16:01:42');
INSERT INTO `admin_menu` VALUES (2, 0, 2, '系统管理', 'fa-tasks', NULL, NULL, NULL, '2019-11-08 16:02:04');
INSERT INTO `admin_menu` VALUES (3, 2, 3, '管理员', 'fa-users', 'auth/users', NULL, NULL, '2019-11-24 12:56:55');
INSERT INTO `admin_menu` VALUES (4, 2, 4, '角色管理', 'fa-user', 'auth/roles', 'auth.management', NULL, '2019-12-23 17:34:17');
INSERT INTO `admin_menu` VALUES (5, 2, 5, '权限管理', 'fa-ban', 'auth/permissions', NULL, NULL, '2019-11-08 16:02:42');
INSERT INTO `admin_menu` VALUES (6, 2, 6, '菜单管理', 'fa-bars', 'auth/menu', NULL, NULL, '2019-11-08 16:02:48');
INSERT INTO `admin_menu` VALUES (7, 2, 7, '日志管理', 'fa-history', 'auth/logs', 'auth.management', NULL, '2019-12-23 17:33:13');
INSERT INTO `admin_menu` VALUES (8, 9, 13, '工作室管理', 'fa-american-sign-language-interpreting', '/z_studios', 'studios', '2019-11-08 16:08:30', '2020-01-03 23:00:00');
INSERT INTO `admin_menu` VALUES (9, 0, 8, '公司管理', 'fa-bank', NULL, NULL, '2019-11-08 16:09:52', '2019-11-08 17:26:03');
INSERT INTO `admin_menu` VALUES (10, 0, 17, '用户管理', 'fa-user-md', NULL, 'usernumber', '2019-11-08 16:11:47', '2020-01-03 23:00:00');
INSERT INTO `admin_menu` VALUES (11, 10, 18, '会员管理', 'fa-user', '/z_usernumbers', 'usernumber', '2019-11-08 16:12:30', '2020-01-03 23:00:00');
INSERT INTO `admin_menu` VALUES (12, 9, 10, '分公司管理', 'fa-building-o', '/z_branchoffices', 'branchoffices', '2019-11-08 17:02:28', '2019-11-24 13:28:16');
INSERT INTO `admin_menu` VALUES (13, 9, 9, '事业部管理', 'fa-binoculars', '/z_businessunits', NULL, '2019-11-08 17:02:58', '2019-12-10 11:57:00');
INSERT INTO `admin_menu` VALUES (14, 0, 20, '内容管理', 'fa-codepen', NULL, 'article', '2019-11-17 15:46:31', '2020-01-03 23:00:00');
INSERT INTO `admin_menu` VALUES (15, 14, 22, '商品管理', 'fa-shopping-bag', '/z_edus', 'article', '2019-11-17 15:51:02', '2020-01-03 23:00:00');
INSERT INTO `admin_menu` VALUES (16, 14, 21, '分类管理', 'fa-align-center', '/z_categorys', 'article', '2019-11-18 12:33:48', '2020-01-03 23:00:00');
INSERT INTO `admin_menu` VALUES (17, 14, 24, '广告图管理', 'fa-area-chart', '/z_ads', 'article', '2019-11-23 22:16:35', '2020-01-03 23:00:00');
INSERT INTO `admin_menu` VALUES (18, 9, 16, '用户提现管理', 'fa-bars', '/z_user_withdraws', 'userwithdraws', '2019-11-25 11:04:54', '2020-01-03 23:00:00');
INSERT INTO `admin_menu` VALUES (19, 9, 15, '工作室提现管理', 'fa-credit-card-alt', '/z_stud_withdraws', 'studwithdraws', '2019-11-25 14:30:44', '2020-01-03 23:00:00');
INSERT INTO `admin_menu` VALUES (20, 10, 19, '订单管理', 'fa-clipboard', 'z_payorders', 'order', '2019-11-27 22:07:55', '2020-01-03 23:00:00');
INSERT INTO `admin_menu` VALUES (22, 9, 14, '工作室余额记录', 'fa-bars', '/z_stud_price_logs', 'studwithdraws', '2019-12-05 23:14:42', '2020-01-03 23:00:00');
INSERT INTO `admin_menu` VALUES (23, 9, 12, '分公司余额明细', 'fa-bars', '/z_bran_price_logs', 'branchofficePrice', '2019-12-09 23:56:38', '2020-01-04 21:15:29');
INSERT INTO `admin_menu` VALUES (24, 14, 23, '课时管理', 'fa-bars', '/z_classes', 'article', '2019-12-25 19:07:20', '2020-01-03 23:00:00');
INSERT INTO `admin_menu` VALUES (25, 9, 11, '分公司提现管理', 'fa-credit-card-alt', '/z_bran_withdraws', 'branchofficePrice', '2020-01-03 22:59:46', '2020-01-03 23:07:45');

-- ----------------------------
-- Table structure for admin_operation_log
-- ----------------------------
DROP TABLE IF EXISTS `admin_operation_log`;
CREATE TABLE `admin_operation_log`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `admin_operation_log_user_id_index`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 234 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;


-- ----------------------------
-- Table structure for admin_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_permissions`;
CREATE TABLE `admin_permissions`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_method` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `http_path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admin_permissions_name_unique`(`name`) USING BTREE,
  UNIQUE INDEX `admin_permissions_slug_unique`(`slug`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_permissions
-- ----------------------------
INSERT INTO `admin_permissions` VALUES (1, 'All permission', '*', '', '*', NULL, NULL);
INSERT INTO `admin_permissions` VALUES (2, '后台控制面板', 'dashboard', 'GET', '/', NULL, '2019-11-10 06:48:04');
INSERT INTO `admin_permissions` VALUES (3, '后台登录管理', 'auth.login', '', '/auth/login\r\n/auth/logout', NULL, '2019-11-10 06:52:45');
INSERT INTO `admin_permissions` VALUES (4, '管理员信息设置', 'auth.setting', 'GET,PUT', '/auth/setting', NULL, '2019-11-10 06:47:50');
INSERT INTO `admin_permissions` VALUES (5, '系统权限管理', 'auth.management', '', '/auth/users\r\n/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs', NULL, '2019-11-24 12:59:34');
INSERT INTO `admin_permissions` VALUES (7, '会员管理', 'usernumber', '', '/z_usernumbers*', '2019-11-10 06:50:06', '2019-11-24 01:29:25');
INSERT INTO `admin_permissions` VALUES (8, '内容管理', 'article', '', '/z_edus*\r\n/z_categorys*\r\n/z_ads*\r\n/z_classes*', '2019-11-17 15:48:37', '2019-12-26 00:09:01');
INSERT INTO `admin_permissions` VALUES (11, '工作室管理', 'studios', '', '/z_studios*', '2019-11-24 12:43:08', '2019-11-24 12:43:08');
INSERT INTO `admin_permissions` VALUES (12, '管理员系统权限管理', 'adminuser', '', '/auth/users*\r\n/auth/roles*', '2019-11-24 12:49:51', '2019-12-23 17:32:38');
INSERT INTO `admin_permissions` VALUES (13, '事业部管理', 'businessunits', '', '/z_businessunits*', '2019-11-24 13:25:49', '2019-11-24 13:25:49');
INSERT INTO `admin_permissions` VALUES (14, '分公司管理', 'branchoffices', '', '/z_branchoffices*', '2019-11-24 13:26:30', '2019-12-14 17:24:04');
INSERT INTO `admin_permissions` VALUES (15, '用户提现管理', 'userwithdraws', '', '/z_user_withdraws*', '2019-11-28 14:21:26', '2019-12-03 00:58:30');
INSERT INTO `admin_permissions` VALUES (16, '订单信息管理', 'order', '', '/z_payorders*', '2019-11-28 14:34:57', '2019-11-28 14:34:57');
INSERT INTO `admin_permissions` VALUES (17, '工作室提现管理，工作室余额明细', 'studwithdraws', '', '/z_stud_withdraws*\r\n/z_stud_price_logs*', '2019-12-02 20:58:05', '2019-12-05 23:27:24');
INSERT INTO `admin_permissions` VALUES (18, '分公司提现管理，分公司余额记录', 'branchofficePrice', '', '/z_bran_price_logs*\r\n/z_bran_withdraws*', '2019-12-14 17:23:48', '2020-01-03 23:01:04');

-- ----------------------------
-- Table structure for admin_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_menu`;
CREATE TABLE `admin_role_menu`  (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `admin_role_menu_role_id_menu_id_index`(`role_id`, `menu_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_role_menu
-- ----------------------------
INSERT INTO `admin_role_menu` VALUES (1, 2, NULL, NULL);
INSERT INTO `admin_role_menu` VALUES (2, 9, NULL, NULL);
INSERT INTO `admin_role_menu` VALUES (2, 2, NULL, NULL);
INSERT INTO `admin_role_menu` VALUES (2, 3, NULL, NULL);
INSERT INTO `admin_role_menu` VALUES (1, 5, NULL, NULL);
INSERT INTO `admin_role_menu` VALUES (1, 6, NULL, NULL);
INSERT INTO `admin_role_menu` VALUES (2, 12, NULL, NULL);
INSERT INTO `admin_role_menu` VALUES (3, 9, NULL, NULL);
INSERT INTO `admin_role_menu` VALUES (4, 9, NULL, NULL);
INSERT INTO `admin_role_menu` VALUES (1, 13, NULL, NULL);

-- ----------------------------
-- Table structure for admin_role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_permissions`;
CREATE TABLE `admin_role_permissions`  (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `admin_role_permissions_role_id_permission_id_index`(`role_id`, `permission_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_role_permissions
-- ----------------------------
INSERT INTO `admin_role_permissions` VALUES (1, 1, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (2, 4, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (2, 2, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (2, 7, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (2, 8, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (2, 11, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (2, 12, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (3, 7, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (3, 11, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (3, 2, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (2, 13, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (2, 14, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (4, 2, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (4, 7, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (2, 15, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (2, 16, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (2, 17, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (4, 17, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (3, 18, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (2, 18, NULL, NULL);
INSERT INTO `admin_role_permissions` VALUES (3, 14, NULL, NULL);

-- ----------------------------
-- Table structure for admin_role_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_users`;
CREATE TABLE `admin_role_users`  (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `admin_role_users_role_id_user_id_index`(`role_id`, `user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_role_users
-- ----------------------------
INSERT INTO `admin_role_users` VALUES (1, 1, NULL, NULL);
INSERT INTO `admin_role_users` VALUES (2, 2, NULL, NULL);
INSERT INTO `admin_role_users` VALUES (3, 3, NULL, NULL);
INSERT INTO `admin_role_users` VALUES (4, 4, NULL, NULL);

-- ----------------------------
-- Table structure for admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `admin_roles`;
CREATE TABLE `admin_roles`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admin_roles_name_unique`(`name`) USING BTREE,
  UNIQUE INDEX `admin_roles_slug_unique`(`slug`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_roles
-- ----------------------------
INSERT INTO `admin_roles` VALUES (1, 'Administrator', 'administrator', '2019-11-08 15:54:17', '2019-11-08 15:54:17');
INSERT INTO `admin_roles` VALUES (2, '系统管理员', 'admin', '2019-11-10 05:58:08', '2019-11-10 05:58:08');
INSERT INTO `admin_roles` VALUES (3, '分公司', 'branchoffices', '2019-11-24 13:22:35', '2019-11-24 13:28:53');
INSERT INTO `admin_roles` VALUES (4, '工作室', 'studios', '2019-11-24 13:30:50', '2019-11-24 13:30:50');

-- ----------------------------
-- Table structure for admin_user_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_user_permissions`;
CREATE TABLE `admin_user_permissions`  (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  INDEX `admin_user_permissions_user_id_permission_id_index`(`user_id`, `permission_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for admin_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admin_users_username_unique`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin_users
-- ----------------------------
INSERT INTO `admin_users` VALUES (1, 'super', '$2y$10$CEFeMcnlUbhvv4UkttZ6wOFfLL1SpTLHy8UCeLTMOQfE94wAGmz8m', 'Administrator', 'images/default.jpg', 'mazEPRkkwtatDW4gb4yXjqieP5NfGLlNa5tpqVBx3v3M8uSrGqZKqqpJZ9AH', '2019-11-08 15:54:17', '2020-06-12 16:01:14');
INSERT INTO `admin_users` VALUES (2, 'admin', '$2y$10$Y/eJQmsdisaOfWZUD61LM.1NGsm6EXNIlZBXo2QLzLxkYgIr7WzBu', '系统管理员', '', 'yq8LrE8Cl2zUQ7wJf3Sal1AsffW33KHTwijOSm2dPXuhJWVon6H0ZS06q7YD', '2019-11-10 05:59:14', '2020-06-12 16:00:56');
INSERT INTO `admin_users` VALUES (3, '13522841833', '$2y$10$BGN639aspBqR18rfthLu9.sZx.n86tRmTpUVCm0ovkfG.umlC1jtO', '分公司管理员', NULL, '9VxEljV9ErrhYDdrlsp3FWwUnCQQPJCp6pZf86VCYaG3am8v6kH9OzA7b3AC', '2019-11-24 13:36:12', '2020-06-12 15:59:17');
INSERT INTO `admin_users` VALUES (4, '13522841844', '$2y$10$vk7JU9ZaBEE139M9/gq/jORzam5BeCzKmEujS85VtKVScmeO61/.C', '工作室管理员', NULL, 'iRopLjH2NeuyYbVcxtSxKNf19no0RgoWcksw5P7iWcv8oKwSumb69P9sqfTt', '2019-11-24 13:52:20', '2020-06-12 15:59:22');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED NULL DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `jobs_queue_reserved_reserved_at_index`(`queue`, `reserved`, `reserved_at`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for zads
-- ----------------------------
DROP TABLE IF EXISTS `zads`;
CREATE TABLE `zads`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `classid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分类',
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '标题',
  `desc` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '详情',
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '大图',
  `ordernum` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '广告调用管理' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for zbran_withdraws
-- ----------------------------
DROP TABLE IF EXISTS `zbran_withdraws`;
CREATE TABLE `zbran_withdraws`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `bran_id` int(11) NULL DEFAULT 0 COMMENT 'id',
  `price` decimal(8, 2) NULL DEFAULT 0.00 COMMENT '提现金额',
  `ord` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '提现单号',
  `type` int(11) NULL DEFAULT 0 COMMENT '提现类型 1 微信 2支付宝',
  `zfbkahao` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '提现类型 1 微信 2支付宝',
  `status` int(11) NULL DEFAULT 0 COMMENT '提现状态，1 待审核 2已通过 3已驳回',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '分公司提现管理' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for zbranchoffice_price_logs
-- ----------------------------
DROP TABLE IF EXISTS `zbranchoffice_price_logs`;
CREATE TABLE `zbranchoffice_price_logs`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT 0 COMMENT '用户id',
  `price` decimal(8, 2) NULL DEFAULT 0.00 COMMENT '数量',
  `yueprice` decimal(8, 2) NULL DEFAULT 0.00 COMMENT '操作后余额',
  `info` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '做什么',
  `type` int(11) NOT NULL DEFAULT 0 COMMENT '[\'默认\', \'收入\', \'支出\', \'驳回\']',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci COMMENT = '分公司余额明细表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for zbranchoffices
-- ----------------------------
DROP TABLE IF EXISTS `zbranchoffices`;
CREATE TABLE `zbranchoffices`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '账号',
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密码',
  `gongsi` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '公司名称',
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '公司电话',
  `fuzeren` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '公司负责人',
  `price` decimal(8, 2) NOT NULL DEFAULT 0.00 COMMENT '余额',
  `ysrprice` decimal(8, 2) NOT NULL DEFAULT 0.00 COMMENT '已收入',
  `yzcprice` decimal(8, 2) NOT NULL DEFAULT 0.00 COMMENT '已支出',
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '公司地址',
  `address_latlnt` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '公司地址经纬度',
  `gzsnum` int(11) NULL DEFAULT NULL COMMENT '工作室数量',
  `busi_id` int(11) NULL DEFAULT NULL COMMENT '所属事业部',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '分公司管理' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for zbusinessunits
-- ----------------------------
DROP TABLE IF EXISTS `zbusinessunits`;
CREATE TABLE `zbusinessunits`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '事业部名称',
  `mch_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商户号',
  `mch_api_key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商户秘钥',
  `mch_cert` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商户证书',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '事业部管理' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for zcategories
-- ----------------------------
DROP TABLE IF EXISTS `zcategories`;
CREATE TABLE `zcategories`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL COMMENT '上级id',
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '详情',
  `logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '图片',
  `order` int(11) NULL DEFAULT NULL COMMENT '排序',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '内容',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '分类管理' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for zclasses
-- ----------------------------
DROP TABLE IF EXISTS `zclasses`;
CREATE TABLE `zclasses`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `edu_id` int(11) NOT NULL COMMENT '课程id',
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '课时名称',
  `video` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '课时视频',
  `status` int(11) NOT NULL COMMENT '课时状态',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '课时管理' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for zcollections
-- ----------------------------
DROP TABLE IF EXISTS `zcollections`;
CREATE TABLE `zcollections`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `shop_id` int(11) NOT NULL COMMENT '商品id',
  `status` int(11) NOT NULL COMMENT '状态 1 收藏 0 取消',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '收藏记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for zedus
-- ----------------------------
DROP TABLE IF EXISTS `zedus`;
CREATE TABLE `zedus`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `classid` int(11) NOT NULL COMMENT '课程分类',
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标题',
  `lsname` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '老师名称',
  `img` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '图片',
  `fhy_fee` decimal(8, 2) NULL DEFAULT NULL COMMENT '非会员价格',
  `vip_fee` decimal(8, 2) NULL DEFAULT NULL COMMENT '会员价格',
  `svip_fee` decimal(8, 2) NULL DEFAULT NULL COMMENT '会员价格',
  `uone_fee` decimal(8, 2) NULL DEFAULT NULL COMMENT '一级返利金额',
  `utwo_fee` decimal(8, 2) NULL DEFAULT NULL COMMENT '二级返利金额',
  `three_fee` decimal(8, 2) NULL DEFAULT NULL COMMENT '三级级返利金额',
  `stud_fee` decimal(8, 2) NULL DEFAULT NULL COMMENT '工作室返利金额',
  `branone_fee` decimal(8, 2) NULL DEFAULT NULL COMMENT '一级分公司返利金额',
  `brantwo_fee` decimal(8, 2) NULL DEFAULT NULL COMMENT '二级分公司返利金额',
  `busi_fee` decimal(8, 2) NULL DEFAULT NULL COMMENT '事业部总公司金额',
  `attributes` int(11) NOT NULL DEFAULT 0 COMMENT '属性',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '状态',
  `desc` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '简介',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL COMMENT '内容',
  `ordernum` int(11) NOT NULL DEFAULT 0 COMMENT '状态',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `vip_uone_fee` decimal(8, 2) NULL DEFAULT NULL,
  `vip_utwo_fee` decimal(8, 2) NULL DEFAULT NULL,
  `vip_stud_fee` decimal(8, 2) NULL DEFAULT NULL,
  `vip_branone_fee` decimal(8, 2) NULL DEFAULT NULL,
  `svip_uone_fee` decimal(8, 2) NULL DEFAULT NULL,
  `svip_utwo_fee` decimal(8, 2) NULL DEFAULT NULL,
  `svip_stud_fee` decimal(8, 2) NULL DEFAULT NULL,
  `svip_branone_fee` decimal(8, 2) NULL DEFAULT NULL,
  `shop_type` int(11) NOT NULL DEFAULT 0 COMMENT '商品类型',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '商品管理-返利金额设置' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for zpayorders
-- ----------------------------
DROP TABLE IF EXISTS `zpayorders`;
CREATE TABLE `zpayorders`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT 0,
  `shop_id` int(11) NOT NULL DEFAULT 0 COMMENT '关联商品id',
  `desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0' COMMENT '订单详情',
  `fee` decimal(8, 2) NOT NULL DEFAULT 0.00 COMMENT '金额',
  `transaction_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '返回流水单号',
  `payord` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '单号',
  `status` int(11) NOT NULL COMMENT '状态 【status】 1=待支付 2=已支付 3=已退款',
  `paycreatetime` timestamp(0) NULL DEFAULT NULL COMMENT '支付时间',
  `createtime` timestamp(0) NULL DEFAULT NULL COMMENT '发起时间 ',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户支付订单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for zstud_price_logs
-- ----------------------------
DROP TABLE IF EXISTS `zstud_price_logs`;
CREATE TABLE `zstud_price_logs`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT 0 COMMENT '用户id',
  `price` decimal(8, 2) NULL DEFAULT 0.00 COMMENT '数量',
  `yueprice` decimal(8, 2) NULL DEFAULT 0.00 COMMENT '操作后余额',
  `info` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '做什么',
  `type` int(11) NOT NULL DEFAULT 0 COMMENT '[\'默认\', \'收入\', \'支出\', \'驳回\']',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci COMMENT = '工作室余额明细表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for zstud_withdraws
-- ----------------------------
DROP TABLE IF EXISTS `zstud_withdraws`;
CREATE TABLE `zstud_withdraws`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `stud_id` int(11) NULL DEFAULT 0 COMMENT '工作室id',
  `price` decimal(8, 2) NULL DEFAULT 0.00 COMMENT '提现金额',
  `ord` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '提现单号',
  `type` int(11) NULL DEFAULT 0 COMMENT '提现类型 1 微信 2支付宝',
  `zfbkahao` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '提现类型 1 微信 2支付宝',
  `status` int(11) NULL DEFAULT 0 COMMENT '提现状态，1 待审核 2已通过 3已驳回',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '工作室提现记录' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for zstudios
-- ----------------------------
DROP TABLE IF EXISTS `zstudios`;
CREATE TABLE `zstudios`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `stud_fid` int(11) NULL DEFAULT NULL COMMENT '上级工作室',
  `bran_id_one` int(11) NOT NULL COMMENT '原分公司',
  `bran_id_two` int(11) NULL DEFAULT NULL COMMENT '转移分公司',
  `number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '账号',
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '密码',
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '工作室地址',
  `address_latlnt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '工作室地址经纬度',
  `fuzeren` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '' COMMENT '工作室负责人',
  `numbernum` int(11) NULL DEFAULT 0 COMMENT '会员数量',
  `numstud` int(11) NULL DEFAULT 0 COMMENT '工作室数量',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '工作室电话',
  `price` decimal(8, 0) NULL DEFAULT 0 COMMENT '余额',
  `yzcprice` decimal(8, 0) NULL DEFAULT 0 COMMENT '账户已支出',
  `ysrprice` decimal(8, 0) NULL DEFAULT 0 COMMENT '账户已收入',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '工作室状态 [\'未开放\'， \'开放\']',
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '工作室' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for zuser_price_logs
-- ----------------------------
DROP TABLE IF EXISTS `zuser_price_logs`;
CREATE TABLE `zuser_price_logs`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT 0 COMMENT '用户id',
  `price` decimal(8, 2) NULL DEFAULT 0.00 COMMENT '数量',
  `yueprice` decimal(8, 2) NULL DEFAULT 0.00 COMMENT '操作后余额',
  `info` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '做什么',
  `type` int(11) NOT NULL DEFAULT 0 COMMENT '[\'默认\', \'收入\', \'支出\', \'驳回\']',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci COMMENT = '微信小程序用户余额明细表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for zuser_withdraws
-- ----------------------------
DROP TABLE IF EXISTS `zuser_withdraws`;
CREATE TABLE `zuser_withdraws`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) NULL DEFAULT NULL COMMENT '用户id',
  `price` decimal(8, 2) NULL DEFAULT NULL COMMENT '提现金额',
  `type` int(11) NULL DEFAULT NULL COMMENT '提现类型 1 微信 2 支付宝',
  `ord` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '订单号',
  `zfbkahao` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '支付宝卡号',
  `status` int(11) NULL DEFAULT NULL COMMENT '提现状态，1 待提现 2已提现',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '提现记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for zuseraddres
-- ----------------------------
DROP TABLE IF EXISTS `zuseraddres`;
CREATE TABLE `zuseraddres`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `mobile` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `addr` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_at` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `status` int(11) NULL DEFAULT 0 COMMENT '默认地址 1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = '用户收货地址' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for zuserformids
-- ----------------------------
DROP TABLE IF EXISTS `zuserformids`;
CREATE TABLE `zuserformids`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `formid` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT '用户小程序form提交获取',
  `uid` int(11) NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = '用户 formid 管理表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for zusernumbers
-- ----------------------------
DROP TABLE IF EXISTS `zusernumbers`;
CREATE TABLE `zusernumbers`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ysstud_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '原始工作室',
  `stud_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '所属服务工作室',
  `phonenumber` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '手机号',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '密码',
  `relname` varchar(33) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '姓名',
  `idcard` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '身份证号',
  `childname` varchar(33) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '孩子姓名',
  `childidcard` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '孩子身份证',
  `price` decimal(9, 0) NULL DEFAULT 0 COMMENT '余额',
  `yzcprice` decimal(9, 0) NULL DEFAULT 0 COMMENT '已支出',
  `ysrprice` decimal(9, 0) NULL DEFAULT 0 COMMENT '已收入',
  `reg_createtime` datetime(0) NULL DEFAULT NULL COMMENT '注册时间',
  `recent_createtime` datetime(0) NULL DEFAULT NULL COMMENT '最近登录时间',
  `invite_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '邀请码',
  `invite_code_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '邀请码二维码',
  `uid_onelevel` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '一级上级用户id',
  `uid_twolevel` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '二级上级会员id',
  `level` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '用户级别 1普通会员 2付费会员',
  `sorts` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '0' COMMENT '层级',
  `deep` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '所在层次',
  `usernum` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '我的会员数量',
  `openid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '微信openid',
  `unionid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '微信唯一unionid',
  `newsession_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '调用信息秘钥',
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `bran_id` int(10) UNSIGNED NULL DEFAULT 0 COMMENT '所属分公司',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '用户管理' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for zuserwxinfos
-- ----------------------------
DROP TABLE IF EXISTS `zuserwxinfos`;
CREATE TABLE `zuserwxinfos`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `openid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickname` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatarurl` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci COMMENT = '微信信息关联' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
