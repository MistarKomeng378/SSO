/*
Navicat MySQL Data Transfer

Source Server         : kinerja
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_kinerja

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-15 11:46:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for save_pass
-- ----------------------------
DROP TABLE IF EXISTS `save_pass`;
CREATE TABLE `save_pass` (
  `no` int(3) NOT NULL AUTO_INCREMENT,
  `nik` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of save_pass
-- ----------------------------
INSERT INTO `save_pass` VALUES ('1', 'afriyadi.sauqi', 'sauqisauqi27');
INSERT INTO `save_pass` VALUES ('2', 'afriyadi.sauqi', 'sauqisauqi27');
