/*
Navicat MySQL Data Transfer

Source Server         : kinerja
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_kinerja

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-15 11:44:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for m_perspektif
-- ----------------------------
DROP TABLE IF EXISTS `m_perspektif`;
CREATE TABLE `m_perspektif` (
  `id_perspektif` int(2) NOT NULL AUTO_INCREMENT,
  `perspektif` varchar(100) NOT NULL,
  PRIMARY KEY (`id_perspektif`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of m_perspektif
-- ----------------------------
INSERT INTO `m_perspektif` VALUES ('1', 'FINANSIAL');
INSERT INTO `m_perspektif` VALUES ('2', 'PELANGGAN');
INSERT INTO `m_perspektif` VALUES ('3', 'OPERASIONAL');
INSERT INTO `m_perspektif` VALUES ('4', 'HUMAN CAPITAL');
