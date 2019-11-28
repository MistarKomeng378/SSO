/*
Navicat MySQL Data Transfer

Source Server         : kinerja
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_kinerja

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-15 11:45:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for mskko
-- ----------------------------
DROP TABLE IF EXISTS `mskko`;
CREATE TABLE `mskko` (
  `id` char(10) NOT NULL,
  `CostCenter` char(6) NOT NULL,
  `uraian` varchar(100) DEFAULT NULL,
  `kd_unit` char(1) DEFAULT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`,`CostCenter`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of mskko
-- ----------------------------
INSERT INTO `mskko` VALUES ('0', 'M1000', 'Direktorat Utama', 'A', '1');
INSERT INTO `mskko` VALUES ('1.1', 'KB', 'SBU SAP', 'C', '1');
INSERT INTO `mskko` VALUES ('1.2', 'KH', 'SBU AB Non SAP', 'D', '1');
INSERT INTO `mskko` VALUES ('1.3', 'KD', 'SBU Infrastruktur IT', 'E', '1');
INSERT INTO `mskko` VALUES ('1.4', 'KJ', 'SBU Otomasi', 'F', '1');
INSERT INTO `mskko` VALUES ('1.5', 'KL', 'SBU EI', 'G', '0');
INSERT INTO `mskko` VALUES ('1.6', 'ALL', 'All SBU', null, '0');
INSERT INTO `mskko` VALUES ('2.1', 'M1300', 'Direktur', 'B', '1');
INSERT INTO `mskko` VALUES ('2.1.1', 'M4200', 'Divisi Keuangan', 'H', '1');
INSERT INTO `mskko` VALUES ('2.1.2', 'M4100', 'Divisi Human Capital', 'I', '1');
INSERT INTO `mskko` VALUES ('2.1.3', 'M4300', 'Divisi Corporate Transformation', 'J', '1');
INSERT INTO `mskko` VALUES ('3.1', 'M1001', 'Dinas Internal Auditor', 'K', '1');
INSERT INTO `mskko` VALUES ('3.2', 'KE', 'Dinas Logistik', 'L', '1');
INSERT INTO `mskko` VALUES ('3.3', 'M1002', 'Corporate Secretary', 'M', '1');
INSERT INTO `mskko` VALUES ('3.4', 'KF', 'Group Sales', 'N', '1');
INSERT INTO `mskko` VALUES ('4', 'AU', 'All Unit', null, '0');
