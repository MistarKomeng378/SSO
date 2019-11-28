/*
Navicat MySQL Data Transfer

Source Server         : kinerja
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_kinerja

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-15 11:44:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for libur_nasional
-- ----------------------------
DROP TABLE IF EXISTS `libur_nasional`;
CREATE TABLE `libur_nasional` (
  `id_libur` int(5) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_libur`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of libur_nasional
-- ----------------------------
INSERT INTO `libur_nasional` VALUES ('1', '2017-01-01', 'Tahun Baru 2017 Masehi');
INSERT INTO `libur_nasional` VALUES ('2', '2017-01-28', 'Tahun Baru Imlek 2568 Kongzili');
INSERT INTO `libur_nasional` VALUES ('3', '2017-03-28', 'Hari Raya Nyepi Tahun Baru Saka 1939');
INSERT INTO `libur_nasional` VALUES ('4', '2017-04-14', 'Wafat Isa Al Masih');
INSERT INTO `libur_nasional` VALUES ('5', '2017-04-24', 'Isra Miraj Nabi Muhammad SAW');
INSERT INTO `libur_nasional` VALUES ('6', '2017-05-01', 'Hari Buruh Internasional');
INSERT INTO `libur_nasional` VALUES ('7', '2017-05-11', 'Hari Raya Waisak 2561');
INSERT INTO `libur_nasional` VALUES ('8', '2017-05-25', 'Kenaikan Isa Al Masih');
INSERT INTO `libur_nasional` VALUES ('9', '2017-06-23', 'Cuti Bersama Hari Raya Idul Fitri 1438 Hijriah');
INSERT INTO `libur_nasional` VALUES ('10', '2017-06-24', 'Cuti Bersama Hari Raya Idul Fitri 1438 Hijriah');
INSERT INTO `libur_nasional` VALUES ('11', '2017-06-25', 'Hari Raya Idul Fitri 1438 Hijriah');
INSERT INTO `libur_nasional` VALUES ('12', '2017-06-26', 'Hari Raya Idul Fitri 1438 Hijriah');
INSERT INTO `libur_nasional` VALUES ('13', '2017-06-27', 'Cuti Bersama Hari Raya Idul Fitri 1438 Hijriah');
INSERT INTO `libur_nasional` VALUES ('14', '2017-06-28', 'Cuti Bersama Hari Raya Idul Fitri 1438 Hijriah');
INSERT INTO `libur_nasional` VALUES ('15', '2017-08-17', 'Hari Kemerdekaan Republik Indonesia');
INSERT INTO `libur_nasional` VALUES ('16', '2017-09-01', 'Hari Raya Idul Adha 1438 Hijriah');
INSERT INTO `libur_nasional` VALUES ('17', '2017-09-21', 'Tahun Baru Islam 1439 Hijriah');
INSERT INTO `libur_nasional` VALUES ('18', '2017-12-01', 'Maulid Nabi Muhammad SAW');
INSERT INTO `libur_nasional` VALUES ('19', '2017-12-25', 'Hari Raya Natal');
INSERT INTO `libur_nasional` VALUES ('20', '2017-12-26', 'Cuti Bersama Hari Raya Natal');
INSERT INTO `libur_nasional` VALUES ('21', '2018-01-01', 'Tahun Baru 2018 Masehi');
INSERT INTO `libur_nasional` VALUES ('22', '2018-02-16', 'Tahun Baru Imlek 2569 Kongzili');
INSERT INTO `libur_nasional` VALUES ('23', '2018-03-17', 'Hari Raya Nyepi Tahun Baru Saka 1940');
INSERT INTO `libur_nasional` VALUES ('24', '2018-03-30', 'Wafat Isa Al Masih');
INSERT INTO `libur_nasional` VALUES ('25', '2018-04-14', 'Isra Miraj Nabi Muhammad SAW');
INSERT INTO `libur_nasional` VALUES ('26', '2018-05-01', 'Hari Buruh Internasional');
INSERT INTO `libur_nasional` VALUES ('27', '2018-05-10', 'Kenaikan Isa Al Masih');
INSERT INTO `libur_nasional` VALUES ('28', '2018-05-29', 'Hari Raya Waisak 2562');
INSERT INTO `libur_nasional` VALUES ('29', '2018-06-01', 'Hari Lahir Pancasila');
INSERT INTO `libur_nasional` VALUES ('30', '2018-06-13', 'Cuti Bersama Hari Raya Idul Fitri 1439 Hijriah');
INSERT INTO `libur_nasional` VALUES ('31', '2018-06-14', 'Cuti Bersama Hari Raya Idul Fitri 1439 Hijriah');
INSERT INTO `libur_nasional` VALUES ('32', '2018-06-15', 'Hari Raya Idul Fitri 1439 Hijriah');
INSERT INTO `libur_nasional` VALUES ('33', '2018-06-16', 'Hari Raya Idul Fitri 1439 Hijriah');
INSERT INTO `libur_nasional` VALUES ('34', '2018-06-18', 'Cuti Bersama Hari Raya Idul Fitri 1439 Hijriah');
INSERT INTO `libur_nasional` VALUES ('35', '2018-06-19', 'Cuti Bersama Hari Raya Idul Fitri 1439 Hijriah');
INSERT INTO `libur_nasional` VALUES ('36', '2018-08-17', 'Hari Kemerdekaan Republik Indonesia');
INSERT INTO `libur_nasional` VALUES ('37', '2018-08-22', 'Hari Raya Idul Adha 1439 Hijriah');
INSERT INTO `libur_nasional` VALUES ('38', '2018-09-11', 'Tahun Baru Islam 1440 Hijriah');
INSERT INTO `libur_nasional` VALUES ('39', '2018-11-20', 'Maulid Nabi Muhammad SAW');
INSERT INTO `libur_nasional` VALUES ('40', '2018-12-25', 'Hari Raya Natal');
INSERT INTO `libur_nasional` VALUES ('41', '2018-12-24', 'Cuti Bersama Hari Raya Natal');
INSERT INTO `libur_nasional` VALUES ('42', '2019-01-01', 'Tahun Baru Masehi 2019');
