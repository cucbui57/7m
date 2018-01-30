/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : banhangdadung

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-01-31 03:19:25
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `access`
-- ----------------------------
DROP TABLE IF EXISTS `access`;
CREATE TABLE `access` (
  `id_group_name` int(11) NOT NULL,
  `id_function` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id_group_name`,`id_function`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of access
-- ----------------------------

-- ----------------------------
-- Table structure for `bill`
-- ----------------------------
DROP TABLE IF EXISTS `bill`;
CREATE TABLE `bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_order` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_deliv` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bill
-- ----------------------------

-- ----------------------------
-- Table structure for `cart`
-- ----------------------------
DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `size` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cart
-- ----------------------------

-- ----------------------------
-- Table structure for `function`
-- ----------------------------
DROP TABLE IF EXISTS `function`;
CREATE TABLE `function` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of function
-- ----------------------------
INSERT INTO `function` VALUES ('1', 'Xem trang admin', 'admin-user_index');
INSERT INTO `function` VALUES ('2', 'Xem danh sách tài khoản', 'admin-user_list');
INSERT INTO `function` VALUES ('3', 'Sửa thông tin tài khoản', 'admin-user_edit');
INSERT INTO `function` VALUES ('4', 'Thêm tài khoản', 'admin-user_add');
INSERT INTO `function` VALUES ('5', 'Xóa tài khoản', 'admin-user_delete');
INSERT INTO `function` VALUES ('6', 'Xem danh sách Nhóm tài khoản', 'admin-group_list');
INSERT INTO `function` VALUES ('7', 'Sửa nhóm tài khoản', 'admin-group_edit');
INSERT INTO `function` VALUES ('8', 'Phân quyền sử dụng', 'admin-group_permission');
INSERT INTO `function` VALUES ('9', 'Xem danh sách sản phẩm', 'admin-product_list');
INSERT INTO `function` VALUES ('10', 'Xoá sản phẩm', 'admin-product_delete');
INSERT INTO `function` VALUES ('11', 'Thêm sản phẩm', 'admin-product_add');
INSERT INTO `function` VALUES ('12', 'Sửa sản phẩm', 'admin-product_edit');
INSERT INTO `function` VALUES ('13', 'Xem danh sách cửa hàng', 'admin-store_list');
INSERT INTO `function` VALUES ('14', 'Thêm cửa hàng', 'admin-store_add');
INSERT INTO `function` VALUES ('15', 'Sửa cửa hàng', 'admin-store_edit');
INSERT INTO `function` VALUES ('16', 'Xoá cửa hàng', 'admin-store_delete');
INSERT INTO `function` VALUES ('17', 'Xem danh sách đơn hàng', 'admin-order_list');

-- ----------------------------
-- Table structure for `group_user`
-- ----------------------------
DROP TABLE IF EXISTS `group_user`;
CREATE TABLE `group_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of group_user
-- ----------------------------
INSERT INTO `group_user` VALUES ('1', 'admin');
INSERT INTO `group_user` VALUES ('2', 'Cửa hàng');
INSERT INTO `group_user` VALUES ('3', 'Thành viên');
INSERT INTO `group_user` VALUES ('4', 'Khách');

-- ----------------------------
-- Table structure for `product`
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `price` int(11) NOT NULL,
  `description` text CHARACTER SET ucs2,
  `supplier_id` int(11) NOT NULL,
  `url_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `promotion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of product
-- ----------------------------

-- ----------------------------
-- Table structure for `product_type`
-- ----------------------------
DROP TABLE IF EXISTS `product_type`;
CREATE TABLE `product_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_type
-- ----------------------------
INSERT INTO `product_type` VALUES ('1', 'THIÊT BỊ ĐIỆN TỬ');
INSERT INTO `product_type` VALUES ('2', 'PHỤ KIỆN ĐIỆN TỬ');
INSERT INTO `product_type` VALUES ('3', 'CHĂM SÓC & LÀM ĐẸP');
INSERT INTO `product_type` VALUES ('4', 'THỜI TRANG NỮ');
INSERT INTO `product_type` VALUES ('5', 'THỜI TRANG NAM');
INSERT INTO `product_type` VALUES ('6', 'PHỤ KIỆN THỜI TRANG');
INSERT INTO `product_type` VALUES ('7', 'THỂ THAO & DU LỊCH');

-- ----------------------------
-- Table structure for `supplier`
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `address` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=ujis;

-- ----------------------------
-- Records of supplier
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET latin1 NOT NULL,
  `fullname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `detail_address` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `ward` varchar(255) CHARACTER SET utf8 NOT NULL,
  `district` varchar(255) CHARACTER SET utf8 NOT NULL,
  `city` varchar(255) CHARACTER SET utf8 NOT NULL,
  `phone_number` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `id_group_user` int(11) NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('2', 'admin', 'admin', 'demo', null, '', '', '', '', '1', '');
