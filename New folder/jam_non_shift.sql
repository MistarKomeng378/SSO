/*
Navicat MySQL Data Transfer

Source Server         : kinerja
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_kinerja

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-15 11:43:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for jam_non_shift
-- ----------------------------
DROP TABLE IF EXISTS `jam_non_shift`;
CREATE TABLE `jam_non_shift` (
  `id_jam` int(2) NOT NULL AUTO_INCREMENT,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `overtime` time NOT NULL,
  `hari` char(5) NOT NULL,
  PRIMARY KEY (`id_jam`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of jam_non_shift
-- ----------------------------
INSERT INTO `jam_non_shift` VALUES ('1', '08:00:00', '16:30:00', '20:30:00', 'Mon');
INSERT INTO `jam_non_shift` VALUES ('2', '08:00:00', '16:30:00', '20:30:00', 'Tue');
INSERT INTO `jam_non_shift` VALUES ('3', '08:00:00', '16:30:00', '20:30:00', 'Wed');
INSERT INTO `jam_non_shift` VALUES ('4', '08:00:00', '16:30:00', '20:30:00', 'Thu');
INSERT INTO `jam_non_shift` VALUES ('5', '08:00:00', '17:00:00', '21:00:00', 'Fri');
INSERT INTO `jam_non_shift` VALUES ('6', '08:00:00', '16:30:00', '00:00:00', 'Sat');
INSERT INTO `jam_non_shift` VALUES ('7', '08:00:00', '16:30:00', '00:00:00', 'Sun');
