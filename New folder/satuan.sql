/*
Navicat MySQL Data Transfer

Source Server         : kinerja
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_kinerja

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-15 11:46:51
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for satuan
-- ----------------------------
DROP TABLE IF EXISTS `satuan`;
CREATE TABLE `satuan` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `satuan` varchar(20) DEFAULT NULL,
  `definisi` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of satuan
-- ----------------------------
INSERT INTO `satuan` VALUES ('1', '%', 'Persen');
INSERT INTO `satuan` VALUES ('2', 'Bh', 'Buah');
INSERT INTO `satuan` VALUES ('3', 'Hr', 'Hari');
INSERT INTO `satuan` VALUES ('4', 'Buku', 'Buku');
INSERT INTO `satuan` VALUES ('6', 'Rp. (M)', 'Rupiah (Milyar)');
INSERT INTO `satuan` VALUES ('7', 'Rp. (Jt)', 'Rupiah (Juta)');
INSERT INTO `satuan` VALUES ('8', 'Kontak', 'Buku Kontrak');
INSERT INTO `satuan` VALUES ('9', 'Unit', 'Unit');
INSERT INTO `satuan` VALUES ('10', 'Customer', 'Customer');
INSERT INTO `satuan` VALUES ('11', 'Jam/Org/Th', 'Jumlah Jam  Orang Pertahun');
INSERT INTO `satuan` VALUES ('12', 'Jt Rp/Org/Th', 'Jt Rp/Org/Th');
INSERT INTO `satuan` VALUES ('13', 'Jumlah', 'Jumlah');
INSERT INTO `satuan` VALUES ('14', 'Tgl', 'Target Tanggal dalam setiap bulan');
