/*
Navicat MySQL Data Transfer

Source Server         : kinerja
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_kinerja

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-15 11:44:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for level
-- ----------------------------
DROP TABLE IF EXISTS `level`;
CREATE TABLE `level` (
  `id_level` int(5) NOT NULL,
  `level` varchar(30) NOT NULL,
  PRIMARY KEY (`id_level`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of level
-- ----------------------------
INSERT INTO `level` VALUES ('1', 'Administrator');
INSERT INTO `level` VALUES ('2', 'Direktur Utama');
INSERT INTO `level` VALUES ('3', 'Direktur Keuangan & Umum');
INSERT INTO `level` VALUES ('4', 'Kepala Unit');
INSERT INTO `level` VALUES ('5', 'Karyawan');
