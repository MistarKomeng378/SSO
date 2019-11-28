/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50539
Source Host           : 127.0.0.1:3306
Source Database       : kinerja

Target Server Type    : MYSQL
Target Server Version : 50539
File Encoding         : 65001

Date: 2019-05-29 07:51:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for profit_margin
-- ----------------------------
DROP TABLE IF EXISTS `profit_margin`;
CREATE TABLE `profit_margin` (
  `id_margin` int(10) NOT NULL AUTO_INCREMENT,
  `cc` varchar(30) DEFAULT NULL,
  `pendapatan` varchar(20) DEFAULT '0',
  `hpp` varchar(20) DEFAULT NULL,
  `margin` varchar(20) DEFAULT '0',
  `bulan` varchar(5) DEFAULT NULL,
  `tahun` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`id_margin`),
  KEY `indek_pmargin` (`cc`,`pendapatan`,`hpp`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of profit_margin
-- ----------------------------
INSERT INTO `profit_margin` VALUES ('38', 'KB', '3', '2', '33.33', '1', '2019');
INSERT INTO `profit_margin` VALUES ('39', 'KB', '4', '5', '-25.00', '2', '2019');
INSERT INTO `profit_margin` VALUES ('40', 'KB', '2', '2', '0.00', '3', '2019');
INSERT INTO `profit_margin` VALUES ('41', 'KB', '5', '4', '20.00', '4', '2019');
INSERT INTO `profit_margin` VALUES ('42', 'KB', '6', '2', '66.67', '5', '2019');
INSERT INTO `profit_margin` VALUES ('43', 'KB', '3', '', '100.00', '6', '2019');
INSERT INTO `profit_margin` VALUES ('44', 'KB', '', '', '0.00', '7', '2019');
INSERT INTO `profit_margin` VALUES ('45', 'KB', '', '', '0.00', '8', '2019');
INSERT INTO `profit_margin` VALUES ('46', 'KB', '', '', '0.00', '9', '2019');
INSERT INTO `profit_margin` VALUES ('47', 'KB', '', '', '0.00', '10', '2019');
INSERT INTO `profit_margin` VALUES ('48', 'KB', '', '', '0.00', '11', '2019');
INSERT INTO `profit_margin` VALUES ('49', 'KB', '', '', '0.00', '12', '2019');
INSERT INTO `profit_margin` VALUES ('50', 'KH', '1', '1', '0.00', '1', '2019');
INSERT INTO `profit_margin` VALUES ('51', 'KH', '1', '0', '100.00', '2', '2019');
INSERT INTO `profit_margin` VALUES ('52', 'KH', '2', '2', '0.00', '3', '2019');
INSERT INTO `profit_margin` VALUES ('53', 'KH', '3', '2', '33.33', '4', '2019');
INSERT INTO `profit_margin` VALUES ('54', 'KH', '4', '4', '0.00', '5', '2019');
INSERT INTO `profit_margin` VALUES ('55', 'KH', '3', '', '100.00', '6', '2019');
INSERT INTO `profit_margin` VALUES ('56', 'KH', '2', '', '100.00', '7', '2019');
INSERT INTO `profit_margin` VALUES ('57', 'KH', '', '', '0.00', '8', '2019');
INSERT INTO `profit_margin` VALUES ('58', 'KH', '', '', '0.00', '9', '2019');
INSERT INTO `profit_margin` VALUES ('59', 'KH', '', '', '0.00', '10', '2019');
INSERT INTO `profit_margin` VALUES ('60', 'KH', '', '', '0.00', '11', '2019');
INSERT INTO `profit_margin` VALUES ('61', 'KH', '', '', '0.00', '12', '2019');
