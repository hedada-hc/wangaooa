/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : oa

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2018-01-11 16:42:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `add_goods`
-- ----------------------------
DROP TABLE IF EXISTS `add_goods`;
CREATE TABLE `add_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of add_goods
-- ----------------------------
INSERT INTO `add_goods` VALUES ('27', '1', '9', '3', '2', '2018-01-08 15:43:20', '2018-01-08 07:43:20');
INSERT INTO `add_goods` VALUES ('28', '1', '8', '3', '5', '2018-01-08 15:43:20', '2018-01-08 07:43:20');
INSERT INTO `add_goods` VALUES ('29', '1', '10', '3', '1', '2018-01-08 15:43:20', '2018-01-08 07:43:20');
INSERT INTO `add_goods` VALUES ('30', '1', '9', '4', '2', '2018-01-08 15:43:52', '2018-01-08 07:43:52');
INSERT INTO `add_goods` VALUES ('31', '1', '8', '4', '5', '2018-01-08 15:43:52', '2018-01-08 07:43:52');
INSERT INTO `add_goods` VALUES ('32', '1', '10', '4', '1', '2018-01-08 15:43:52', '2018-01-08 07:43:52');
INSERT INTO `add_goods` VALUES ('33', '1', '4', '4', '1', '2018-01-08 15:43:52', '2018-01-08 07:43:52');

-- ----------------------------
-- Table structure for `alcs`
-- ----------------------------
DROP TABLE IF EXISTS `alcs`;
CREATE TABLE `alcs` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '针对哪个用户',
  `order` json DEFAULT NULL,
  `cates` tinyint(1) DEFAULT '0' COMMENT '0无权限、1可查看、2可新增、3可删除',
  `user` tinyint(1) DEFAULT '0' COMMENT '0无权限、1可以新增、2可增删改查',
  `goods` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '0-3需要检查权限 5管理员权限无需检查',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of alcs
-- ----------------------------
INSERT INTO `alcs` VALUES ('3', '3', '[\"order_name\", \"name\", \"address\", \"phone\", \"wechat\", \"total_price\", \"price\", \"pay_status\", \"pay_method\", \"source\", \"remark\", \"express\", \"number\", \"express_status\", \"goods_id\", \"add_goods\", \"rep_count\"]', '0', '3', '3', '0', '2018-01-11 13:36:20');
INSERT INTO `alcs` VALUES ('2', '2', '[\"rep_count\", \"add_goods\", \"goods_id\", \"express_status\", \"number\", \"express\", \"remark\", \"order_name\", \"name\", \"address\", \"phone\", \"wechat\", \"total_price\", \"price\", \"pay_status\", \"pay_method\", \"source\"]', '3', '3', '1', '1', '2018-01-11 10:01:16');

-- ----------------------------
-- Table structure for `cates`
-- ----------------------------
DROP TABLE IF EXISTS `cates`;
CREATE TABLE `cates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate_goods_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品id逗号分隔',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '套餐名称',
  `price` decimal(8,2) NOT NULL COMMENT '套餐价格',
  `user_id` int(11) NOT NULL COMMENT '套餐添加者',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of cates
-- ----------------------------
INSERT INTO `cates` VALUES ('1', '25,26,27', '测试套餐', '2888.00', '1', '2018-01-04 09:05:18', '2018-01-04 09:05:18');
INSERT INTO `cates` VALUES ('2', '28,29,30,31', '2018套餐', '2888.00', '1', '2018-01-06 09:35:49', '2018-01-06 09:35:49');
INSERT INTO `cates` VALUES ('3', '32,33,34,35', '男性3个周期', '3899.00', '1', '2018-01-06 09:38:17', '2018-01-06 09:38:17');

-- ----------------------------
-- Table structure for `cate_goods`
-- ----------------------------
DROP TABLE IF EXISTS `cate_goods`;
CREATE TABLE `cate_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品id',
  `stock` int(11) NOT NULL COMMENT '商品数量',
  `user_id` int(11) NOT NULL COMMENT '添加者',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of cate_goods
-- ----------------------------
INSERT INTO `cate_goods` VALUES ('25', '3', '1', '1', '2018-01-04 09:05:18', '2018-01-04 09:05:18');
INSERT INTO `cate_goods` VALUES ('26', '9', '1', '1', '2018-01-04 09:05:18', '2018-01-04 09:05:18');
INSERT INTO `cate_goods` VALUES ('27', '9', '2', '1', '2018-01-04 09:05:18', '2018-01-04 09:05:18');
INSERT INTO `cate_goods` VALUES ('28', '3', '2', '1', '2018-01-06 09:35:49', '2018-01-06 09:35:49');
INSERT INTO `cate_goods` VALUES ('29', '8', '1', '1', '2018-01-06 09:35:49', '2018-01-06 09:35:49');
INSERT INTO `cate_goods` VALUES ('30', '9', '1', '1', '2018-01-06 09:35:49', '2018-01-06 09:35:49');
INSERT INTO `cate_goods` VALUES ('31', '10', '1', '1', '2018-01-06 09:35:49', '2018-01-06 09:35:49');
INSERT INTO `cate_goods` VALUES ('32', '3', '3', '1', '2018-01-06 09:38:17', '2018-01-06 09:38:17');
INSERT INTO `cate_goods` VALUES ('33', '9', '3', '1', '2018-01-06 09:38:17', '2018-01-06 09:38:17');
INSERT INTO `cate_goods` VALUES ('34', '7', '3', '1', '2018-01-06 09:38:17', '2018-01-06 09:38:17');
INSERT INTO `cate_goods` VALUES ('35', '6', '1', '1', '2018-01-06 09:38:17', '2018-01-06 09:38:17');

-- ----------------------------
-- Table structure for `goods`
-- ----------------------------
DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品名称',
  `spec` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '规格',
  `stock` int(11) NOT NULL COMMENT '库存',
  `price` decimal(8,2) NOT NULL COMMENT '商品价格',
  `user_id` int(11) NOT NULL COMMENT '添加者',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of goods
-- ----------------------------
INSERT INTO `goods` VALUES ('3', '高丽参', '500kg', '9958', '188.00', '1', '2018-01-04 08:12:57', '2018-01-09 01:58:48');
INSERT INTO `goods` VALUES ('4', '养生茶', '250kg', '9999', '598.00', '1', '2018-01-04 08:15:45', '2018-01-08 07:43:52');
INSERT INTO `goods` VALUES ('5', '女膏', '100kg', '10000', '88.00', '1', '2018-01-04 08:16:08', '2018-01-04 08:16:08');
INSERT INTO `goods` VALUES ('6', '养生搭档', '500kg', '9989', '688.00', '1', '2018-01-04 08:16:28', '2018-01-09 01:56:37');
INSERT INTO `goods` VALUES ('7', '强身贴', '100kg', '9967', '128.00', '1', '2018-01-04 08:16:51', '2018-01-09 01:56:37');
INSERT INTO `goods` VALUES ('8', '黄元膏', '250kg', '9954', '389.00', '1', '2018-01-04 08:17:17', '2018-01-08 08:53:22');
INSERT INTO `goods` VALUES ('9', '无糖黄元膏', '250kg', '9944', '589.00', '1', '2018-01-04 08:17:44', '2018-01-09 01:58:48');
INSERT INTO `goods` VALUES ('10', '黄精膏', '250kg', '9994', '389.00', '1', '2018-01-04 08:18:01', '2018-01-08 08:53:22');
INSERT INTO `goods` VALUES ('11', '至尊黄元膏', '500kg', '10000', '899.00', '1', '2018-01-04 08:18:26', '2018-01-04 08:18:26');

-- ----------------------------
-- Table structure for `migrations`
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_000000_create_users_table', '2');
INSERT INTO `migrations` VALUES ('3', '2017_12_23_094335_create_alcs_table', '3');
INSERT INTO `migrations` VALUES ('4', '2017_12_23_094554_create_orders_table', '4');
INSERT INTO `migrations` VALUES ('5', '2017_12_25_023722_create_goods_table', '4');
INSERT INTO `migrations` VALUES ('6', '2017_12_25_023740_create_cates_table', '4');
INSERT INTO `migrations` VALUES ('7', '2017_12_25_032847_create_cate_goods_table', '4');

-- ----------------------------
-- Table structure for `orders`
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '订单关联员工id',
  `order_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '收货人姓名',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '收货地址',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '手机号码',
  `wechat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '微信号',
  `total_price` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单价格',
  `pay_status` tinyint(4) NOT NULL COMMENT '支付状态',
  `pay_method` tinyint(4) NOT NULL COMMENT '0微信1支付宝2银行转账3信用卡',
  `source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单来源',
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单备注',
  `express` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '快递公司',
  `number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '快递单号',
  `express_status` tinyint(4) NOT NULL COMMENT '快递状态',
  `goods_id` int(11) NOT NULL COMMENT '主商品id',
  `add_goods` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '附加商品id 逗号分隔',
  `rep_count` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES ('7', '1', '附送黄原膏子啊', '何冲', '湖北省武汉市洪山区光谷', '13618662117', 'kmkm1554', '2888', '600', '3', '1', '微信', '块咔发货啊卵子', null, null, '0', '1', '', null, '2018-01-09 01:58:48', '2018-01-09 01:58:48');
INSERT INTO `orders` VALUES ('3', '1', '单买黄原膏', '李四', '北京市朝阳区马泉营', '18866668888', 'aas1111', '1889', '200', '3', '2', '微信', '明天发货送个勺子', '申通快递', '5126622645', '2', '0', '27,28,29', null, '2018-01-09 10:30:35', '2018-01-09 02:30:35');
INSERT INTO `orders` VALUES ('6', '1', '男性3个周期', '李辰', '湖北省武汉市洪山区', '13618662117', 'klll4171515', '3899', '500', '3', '2', '微信', '测试测试测试', null, null, '0', '3', '', '2', '2018-01-09 14:10:57', '2018-01-09 14:10:57');

-- ----------------------------
-- Table structure for `password_resets`
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_username_index` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wechat_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alc_id` int(11) DEFAULT NULL,
  `super_id` int(11) DEFAULT '1',
  `status` tinyint(4) DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('2', 'admin', '$2y$10$HYz6RZLrbc8TRk7yQ/dfd.CR91RPrwfVMHjuh7Pf7aVT5Wm1f9LBe', null, '2', '2', '0', null, '2017-12-26 09:36:25', '2018-01-11 10:01:16');
INSERT INTO `users` VALUES ('3', '何冲', '$2y$10$zS62TgNXw5xLrNaumr8NieJ004zi7Nr5ixSuRBVD3S9Og7EiSJmGe', null, '3', '2', '2', null, '2017-12-26 09:49:31', '2018-01-11 13:36:20');
INSERT INTO `users` VALUES ('4', '李辰瑶', '$2y$10$VTc5cm9hMr92OAmWQVad/O2paCQ8gJRwjuMZWirOgziSSKPPwcY2G', null, null, '3', '0', null, '2017-12-31 02:49:31', '2017-12-31 02:49:31');
