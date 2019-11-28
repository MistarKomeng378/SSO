/*
Navicat MySQL Data Transfer

Source Server         : kinerja
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_kinerja

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-15 11:43:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for bobot_pi
-- ----------------------------
DROP TABLE IF EXISTS `bobot_pi`;
CREATE TABLE `bobot_pi` (
  `id_srk` char(10) NOT NULL,
  `bobot_thd_pi` int(5) NOT NULL,
  `bobot_rk` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of bobot_pi
-- ----------------------------
INSERT INTO `bobot_pi` VALUES ('', '0', '0');
INSERT INTO `bobot_pi` VALUES ('50', '100', '0');
INSERT INTO `bobot_pi` VALUES ('134', '100', '0');
INSERT INTO `bobot_pi` VALUES ('120', '100', '0');
INSERT INTO `bobot_pi` VALUES ('174', '100', '0');
INSERT INTO `bobot_pi` VALUES ('161', '100', '0');
INSERT INTO `bobot_pi` VALUES ('148', '100', '0');
