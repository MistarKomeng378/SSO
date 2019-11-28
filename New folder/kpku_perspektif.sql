/*
Navicat MySQL Data Transfer

Source Server         : kinerja
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_kinerja

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-15 11:44:17
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for kpku_perspektif
-- ----------------------------
DROP TABLE IF EXISTS `kpku_perspektif`;
CREATE TABLE `kpku_perspektif` (
  `id_perspektif` char(10) NOT NULL,
  `tahun` int(4) DEFAULT NULL,
  `perspektif` text,
  PRIMARY KEY (`id_perspektif`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of kpku_perspektif
-- ----------------------------
INSERT INTO `kpku_perspektif` VALUES ('7.1', '2017', 'Efektifitas Produk dan Proses');
INSERT INTO `kpku_perspektif` VALUES ('7.2', '2017', 'Fokus Pelanggan');
INSERT INTO `kpku_perspektif` VALUES ('7.3', '2017', 'Fokus Tenaga Kerja');
INSERT INTO `kpku_perspektif` VALUES ('7.4', '2017', 'Kepemimpinan, Tata Kelola dan Tanggung Jawab Kemasyarakatan');
INSERT INTO `kpku_perspektif` VALUES ('7.5', '2017', 'Keuangan dan Pasar');
