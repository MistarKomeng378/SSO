/*
Navicat MySQL Data Transfer

Source Server         : kinerja
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_kinerja

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-15 11:47:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tahun
-- ----------------------------
DROP TABLE IF EXISTS `tahun`;
CREATE TABLE `tahun` (
  `id_tahun` int(11) NOT NULL AUTO_INCREMENT,
  `tahun` int(4) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id_tahun`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tahun
-- ----------------------------
INSERT INTO `tahun` VALUES ('2', '2017', '0');
INSERT INTO `tahun` VALUES ('3', '2018', '0');
INSERT INTO `tahun` VALUES ('5', '2019', '1');
