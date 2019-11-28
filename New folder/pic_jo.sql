/*
Navicat MySQL Data Transfer

Source Server         : kinerja
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_kinerja

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-15 11:45:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pic_jo
-- ----------------------------
DROP TABLE IF EXISTS `pic_jo`;
CREATE TABLE `pic_jo` (
  `id_pic` int(5) NOT NULL AUTO_INCREMENT,
  `id_jo` varchar(10) NOT NULL,
  `pic` text NOT NULL,
  PRIMARY KEY (`id_pic`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of pic_jo
-- ----------------------------
INSERT INTO `pic_jo` VALUES ('21', 'JO16100001', '90496');
INSERT INTO `pic_jo` VALUES ('22', 'JO16100002', '90268');
