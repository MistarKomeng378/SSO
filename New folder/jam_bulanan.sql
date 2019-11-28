/*
Navicat MySQL Data Transfer

Source Server         : kinerja
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_kinerja

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-15 11:43:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for jam_bulanan
-- ----------------------------
DROP TABLE IF EXISTS `jam_bulanan`;
CREATE TABLE `jam_bulanan` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `bulan` int(2) NOT NULL,
  `tahun` int(4) NOT NULL,
  `hari_kerja` int(2) NOT NULL,
  `jam_bulanan` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of jam_bulanan
-- ----------------------------
INSERT INTO `jam_bulanan` VALUES ('1', '1', '2017', '22', '176');
INSERT INTO `jam_bulanan` VALUES ('2', '2', '2017', '20', '160');
INSERT INTO `jam_bulanan` VALUES ('3', '3', '2017', '22', '176');
INSERT INTO `jam_bulanan` VALUES ('4', '4', '2017', '18', '144');
INSERT INTO `jam_bulanan` VALUES ('5', '5', '2017', '20', '160');
INSERT INTO `jam_bulanan` VALUES ('6', '6', '2017', '18', '144');
INSERT INTO `jam_bulanan` VALUES ('7', '7', '2017', '21', '168');
INSERT INTO `jam_bulanan` VALUES ('8', '8', '2017', '22', '176');
INSERT INTO `jam_bulanan` VALUES ('9', '9', '2017', '19', '152');
INSERT INTO `jam_bulanan` VALUES ('10', '10', '2017', '22', '176');
INSERT INTO `jam_bulanan` VALUES ('11', '11', '2017', '22', '176');
INSERT INTO `jam_bulanan` VALUES ('12', '12', '2017', '18', '144');
INSERT INTO `jam_bulanan` VALUES ('13', '1', '2018', '22', '176');
INSERT INTO `jam_bulanan` VALUES ('14', '2', '2018', '19', '152');
INSERT INTO `jam_bulanan` VALUES ('15', '3', '2018', '21', '168');
INSERT INTO `jam_bulanan` VALUES ('16', '4', '2018', '21', '168');
INSERT INTO `jam_bulanan` VALUES ('17', '5', '2018', '20', '160');
INSERT INTO `jam_bulanan` VALUES ('18', '6', '2018', '15', '120');
INSERT INTO `jam_bulanan` VALUES ('19', '7', '2018', '22', '176');
INSERT INTO `jam_bulanan` VALUES ('20', '8', '2018', '21', '168');
INSERT INTO `jam_bulanan` VALUES ('21', '9', '2018', '19', '152');
INSERT INTO `jam_bulanan` VALUES ('22', '10', '2018', '23', '184');
INSERT INTO `jam_bulanan` VALUES ('23', '11', '2018', '21', '168');
INSERT INTO `jam_bulanan` VALUES ('24', '12', '2018', '19', '152');
INSERT INTO `jam_bulanan` VALUES ('25', '1', '2019', '23', '184');
INSERT INTO `jam_bulanan` VALUES ('26', '2', '2019', '20', '160');
INSERT INTO `jam_bulanan` VALUES ('27', '3', '2019', '21', '168');
INSERT INTO `jam_bulanan` VALUES ('28', '4', '2019', '22', '176');
INSERT INTO `jam_bulanan` VALUES ('29', '5', '2019', '23', '184');
INSERT INTO `jam_bulanan` VALUES ('30', '6', '2019', '20', '160');
INSERT INTO `jam_bulanan` VALUES ('31', '7', '2019', '23', '184');
INSERT INTO `jam_bulanan` VALUES ('32', '8', '2019', '22', '176');
INSERT INTO `jam_bulanan` VALUES ('33', '9', '2019', '21', '168');
INSERT INTO `jam_bulanan` VALUES ('34', '10', '2019', '23', '184');
INSERT INTO `jam_bulanan` VALUES ('35', '11', '2019', '21', '168');
INSERT INTO `jam_bulanan` VALUES ('36', '12', '2019', '22', '176');
