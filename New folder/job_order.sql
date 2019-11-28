/*
Navicat MySQL Data Transfer

Source Server         : kinerja
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_kinerja

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-15 11:43:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for job_order
-- ----------------------------
DROP TABLE IF EXISTS `job_order`;
CREATE TABLE `job_order` (
  `id_jo` varchar(10) NOT NULL,
  `aktifitas` text NOT NULL,
  `atasan` varchar(10) NOT NULL,
  `tembusan` text NOT NULL,
  `tgl_mulai` date NOT NULL,
  `jam_mulai` char(10) NOT NULL,
  `tgl_selesai` date NOT NULL,
  `jam_selesai` char(10) DEFAULT NULL,
  `lampiran` varchar(100) NOT NULL,
  `ket` text NOT NULL,
  PRIMARY KEY (`id_jo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of job_order
-- ----------------------------
