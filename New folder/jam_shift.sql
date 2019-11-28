/*
Navicat MySQL Data Transfer

Source Server         : kinerja
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_kinerja

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-15 11:43:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for jam_shift
-- ----------------------------
DROP TABLE IF EXISTS `jam_shift`;
CREATE TABLE `jam_shift` (
  `id_jam` int(5) NOT NULL AUTO_INCREMENT,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `overtime` time DEFAULT NULL,
  PRIMARY KEY (`id_jam`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of jam_shift
-- ----------------------------
INSERT INTO `jam_shift` VALUES ('1', '22:00:00', '06:00:00', '08:00:00');
INSERT INTO `jam_shift` VALUES ('2', '06:00:00', '14:00:00', '16:00:00');
INSERT INTO `jam_shift` VALUES ('3', '14:00:00', '22:00:00', '00:00:00');
