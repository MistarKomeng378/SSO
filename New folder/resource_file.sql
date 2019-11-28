/*
Navicat MySQL Data Transfer

Source Server         : kinerja
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_kinerja

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-15 11:46:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for resource_file
-- ----------------------------
DROP TABLE IF EXISTS `resource_file`;
CREATE TABLE `resource_file` (
  `id_resource` int(10) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) DEFAULT NULL,
  `size` int(5) DEFAULT NULL,
  `type` varchar(15) DEFAULT NULL,
  `dir` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_resource`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of resource_file
-- ----------------------------
INSERT INTO `resource_file` VALUES ('36', 'Manual book SSO  Penilaian Karyawan 2019.pdf', '810697', 'application/pdf', 'upload');
