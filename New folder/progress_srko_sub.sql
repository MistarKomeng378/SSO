/*
Navicat MySQL Data Transfer

Source Server         : kinerja
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_kinerja

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-15 11:46:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for progress_srko_sub
-- ----------------------------
DROP TABLE IF EXISTS `progress_srko_sub`;
CREATE TABLE `progress_srko_sub` (
  `id_gca` varchar(15) NOT NULL,
  `id_srko` int(10) NOT NULL,
  `cc` varchar(10) NOT NULL,
  `bulan` int(2) NOT NULL,
  `tahun` int(4) NOT NULL,
  `progress` varchar(15) NOT NULL,
  PRIMARY KEY (`id_gca`,`id_srko`,`bulan`,`tahun`,`cc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of progress_srko_sub
-- ----------------------------
INSERT INTO `progress_srko_sub` VALUES ('100022', '129', 'KB', '6', '2017', '3.9673046251994');
INSERT INTO `progress_srko_sub` VALUES ('100069', '129', 'KB', '6', '2017', '4.4293015332197');
INSERT INTO `progress_srko_sub` VALUES ('100184', '129', 'KB', '6', '2017', '0');
INSERT INTO `progress_srko_sub` VALUES ('100284', '129', 'KB', '6', '2017', '0');
INSERT INTO `progress_srko_sub` VALUES ('100352', '129', 'KB', '6', '2017', '1.049042748492');
INSERT INTO `progress_srko_sub` VALUES ('100641', '129', 'KB', '6', '2017', '0');
INSERT INTO `progress_srko_sub` VALUES ('100839', '129', 'KB', '6', '2017', '0');
INSERT INTO `progress_srko_sub` VALUES ('100897', '129', 'KB', '6', '2017', '0');
INSERT INTO `progress_srko_sub` VALUES ('100944', '129', 'KB', '6', '2017', '0');
INSERT INTO `progress_srko_sub` VALUES ('100966', '129', 'KB', '6', '2017', '55.298683414359');
INSERT INTO `progress_srko_sub` VALUES ('101232', '129', 'KB', '6', '2017', '0');
INSERT INTO `progress_srko_sub` VALUES ('101236', '129', 'KB', '6', '2017', '0');
INSERT INTO `progress_srko_sub` VALUES ('101245', '129', 'KB', '6', '2017', '');
INSERT INTO `progress_srko_sub` VALUES ('101246', '129', 'KB', '6', '2017', '');
INSERT INTO `progress_srko_sub` VALUES ('101247', '129', 'KB', '6', '2017', '');
INSERT INTO `progress_srko_sub` VALUES ('101567', '129', 'KB', '6', '2017', '12.836042928488');
