/*
Navicat MySQL Data Transfer

Source Server         : kinerja
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_kinerja

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-15 11:47:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for target_rkap
-- ----------------------------
DROP TABLE IF EXISTS `target_rkap`;
CREATE TABLE `target_rkap` (
  `id_kpi` char(10) NOT NULL,
  `id_perspektif` char(10) NOT NULL,
  `bulan` int(2) NOT NULL,
  `tahun` int(4) NOT NULL,
  `satuan` varchar(15) NOT NULL,
  `target_rkap` varchar(15) NOT NULL,
  PRIMARY KEY (`id_kpi`,`tahun`,`bulan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of target_rkap
-- ----------------------------
INSERT INTO `target_rkap` VALUES ('', '0', '0', '2017', '', '');
INSERT INTO `target_rkap` VALUES ('', '0', '1', '2017', '', '');
INSERT INTO `target_rkap` VALUES ('', '0', '2', '2017', '', '');
INSERT INTO `target_rkap` VALUES ('', '0', '3', '2017', '', '');
INSERT INTO `target_rkap` VALUES ('', '0', '4', '2017', '', '');
INSERT INTO `target_rkap` VALUES ('1', '0', '1', '2017', 'Rp. M', '2.41');
INSERT INTO `target_rkap` VALUES ('1', '0', '2', '2017', 'Rp. M', '0.45');
INSERT INTO `target_rkap` VALUES ('1', '0', '3', '2017', 'Rp. M', '4.962');
INSERT INTO `target_rkap` VALUES ('1', '0', '4', '2017', 'Rp. M', '5.756');
INSERT INTO `target_rkap` VALUES ('1', '0', '5', '2017', 'Rp. M', '3.541');
INSERT INTO `target_rkap` VALUES ('1', '0', '6', '2017', 'Rp. M', '170.06');
INSERT INTO `target_rkap` VALUES ('1', '0', '7', '2017', 'Rp. M', '10.067');
INSERT INTO `target_rkap` VALUES ('1', '0', '8', '2017', 'Rp. M', '4.976');
INSERT INTO `target_rkap` VALUES ('1', '0', '9', '2017', 'Rp. M', '6.177');
INSERT INTO `target_rkap` VALUES ('1', '0', '10', '2017', 'Rp. M', '6.577');
INSERT INTO `target_rkap` VALUES ('1', '0', '11', '2017', 'Rp. M', '2.217');
INSERT INTO `target_rkap` VALUES ('1', '0', '12', '2017', 'Rp. M', '8.867');
INSERT INTO `target_rkap` VALUES ('2', '0', '1', '2017', 'Rp. M', '4.831');
INSERT INTO `target_rkap` VALUES ('2', '0', '2', '2017', 'Rp. M', '5.811');
INSERT INTO `target_rkap` VALUES ('2', '0', '3', '2017', 'Rp. M', '13.007');
INSERT INTO `target_rkap` VALUES ('2', '0', '4', '2017', 'Rp. M', '9.49');
INSERT INTO `target_rkap` VALUES ('2', '0', '5', '2017', 'Rp. M', '6.905');
INSERT INTO `target_rkap` VALUES ('2', '0', '6', '2017', 'Rp. M', '10.883');
INSERT INTO `target_rkap` VALUES ('2', '0', '7', '2017', 'Rp. M', '8.541');
INSERT INTO `target_rkap` VALUES ('2', '0', '8', '2017', 'Rp. M', '10.773');
INSERT INTO `target_rkap` VALUES ('2', '0', '9', '2017', 'Rp. M', '32.091');
INSERT INTO `target_rkap` VALUES ('2', '0', '10', '2017', 'Rp. M', '12.319');
INSERT INTO `target_rkap` VALUES ('2', '0', '11', '2017', 'Rp. M', '7.823');
INSERT INTO `target_rkap` VALUES ('2', '0', '12', '2017', 'Rp. M', '38.386');
INSERT INTO `target_rkap` VALUES ('3', '0', '1', '2017', '%', '41.8');
INSERT INTO `target_rkap` VALUES ('3', '0', '2', '2017', '%', '40.5');
INSERT INTO `target_rkap` VALUES ('3', '0', '3', '2017', '%', '39.2');
INSERT INTO `target_rkap` VALUES ('3', '0', '4', '2017', '%', '38.2');
INSERT INTO `target_rkap` VALUES ('3', '0', '5', '2017', '%', '38.2');
INSERT INTO `target_rkap` VALUES ('3', '0', '6', '2017', '%', '38.2');
INSERT INTO `target_rkap` VALUES ('3', '0', '7', '2017', '%', '35.3');
INSERT INTO `target_rkap` VALUES ('3', '0', '8', '2017', '%', '36.3');
INSERT INTO `target_rkap` VALUES ('3', '0', '9', '2017', '%', '26');
INSERT INTO `target_rkap` VALUES ('3', '0', '10', '2017', '%', '26');
INSERT INTO `target_rkap` VALUES ('3', '0', '11', '2017', '%', '33');
INSERT INTO `target_rkap` VALUES ('3', '0', '12', '2017', '%', '26');
INSERT INTO `target_rkap` VALUES ('4', '0', '1', '2017', 'Karyawan', '256');
INSERT INTO `target_rkap` VALUES ('4', '0', '2', '2017', 'Karyawan', '256');
INSERT INTO `target_rkap` VALUES ('4', '0', '3', '2017', 'Karyawan', '256');
INSERT INTO `target_rkap` VALUES ('4', '0', '4', '2017', 'Karyawan', '256');
INSERT INTO `target_rkap` VALUES ('4', '0', '5', '2017', 'Karyawan', '256');
INSERT INTO `target_rkap` VALUES ('4', '0', '6', '2017', 'Karyawan', '256');
INSERT INTO `target_rkap` VALUES ('4', '0', '7', '2017', 'Karyawan', '256');
INSERT INTO `target_rkap` VALUES ('4', '0', '8', '2017', 'Karyawan', '256');
INSERT INTO `target_rkap` VALUES ('4', '0', '9', '2017', 'Karyawan', '256');
INSERT INTO `target_rkap` VALUES ('4', '0', '10', '2017', 'Karyawan', '256');
INSERT INTO `target_rkap` VALUES ('4', '0', '11', '2017', 'Karyawan', '256');
INSERT INTO `target_rkap` VALUES ('4', '0', '12', '2017', 'Karyawan', '256');
INSERT INTO `target_rkap` VALUES ('I-1', '7.1', '1', '2017', '%', '2');
INSERT INTO `target_rkap` VALUES ('I-1', '7.1', '2', '2017', '%', '3');
INSERT INTO `target_rkap` VALUES ('I-1', '7.1', '3', '2017', '%', '5');
INSERT INTO `target_rkap` VALUES ('I-1', '7.1', '4', '2017', '%', '7');
INSERT INTO `target_rkap` VALUES ('I-1', '7.1', '5', '2017', '%', '5');
INSERT INTO `target_rkap` VALUES ('I-1', '7.1', '6', '2017', '%', '6');
INSERT INTO `target_rkap` VALUES ('I-1', '7.1', '7', '2017', '%', '6');
INSERT INTO `target_rkap` VALUES ('I-1', '7.1', '8', '2017', '%', '5');
INSERT INTO `target_rkap` VALUES ('I-1', '7.1', '9', '2017', '%', '16');
INSERT INTO `target_rkap` VALUES ('I-1', '7.1', '10', '2017', '%', '6');
INSERT INTO `target_rkap` VALUES ('I-1', '7.1', '11', '2017', '%', '4');
INSERT INTO `target_rkap` VALUES ('I-1', '7.1', '12', '2017', '%', '30');
INSERT INTO `target_rkap` VALUES ('I-2', '7.1', '1', '2017', '%', '4.36');
INSERT INTO `target_rkap` VALUES ('I-2', '7.1', '2', '2017', '%', '8.51');
INSERT INTO `target_rkap` VALUES ('I-2', '7.1', '3', '2017', '%', '7.48');
INSERT INTO `target_rkap` VALUES ('I-2', '7.1', '4', '2017', '%', '6.79');
INSERT INTO `target_rkap` VALUES ('I-2', '7.1', '5', '2017', '%', '6.79');
INSERT INTO `target_rkap` VALUES ('I-2', '7.1', '6', '2017', '%', '6.79');
INSERT INTO `target_rkap` VALUES ('I-2', '7.1', '7', '2017', '%', '9.68');
INSERT INTO `target_rkap` VALUES ('I-2', '7.1', '8', '2017', '%', '6.78');
INSERT INTO `target_rkap` VALUES ('I-2', '7.1', '9', '2017', '%', '15.15');
INSERT INTO `target_rkap` VALUES ('I-2', '7.1', '10', '2017', '%', '9.1');
INSERT INTO `target_rkap` VALUES ('I-2', '7.1', '11', '2017', '%', '6.79');
INSERT INTO `target_rkap` VALUES ('I-2', '7.1', '12', '2017', '%', '6.79');
INSERT INTO `target_rkap` VALUES ('II-1', '7.2', '1', '2017', 'Cust', '0');
INSERT INTO `target_rkap` VALUES ('II-1', '7.2', '2', '2017', 'Cust', '3');
INSERT INTO `target_rkap` VALUES ('II-1', '7.2', '3', '2017', 'Cust', '1');
INSERT INTO `target_rkap` VALUES ('II-1', '7.2', '4', '2017', 'Cust', '3');
INSERT INTO `target_rkap` VALUES ('II-1', '7.2', '5', '2017', 'Cust', '1');
INSERT INTO `target_rkap` VALUES ('II-1', '7.2', '6', '2017', 'Cust', '4');
INSERT INTO `target_rkap` VALUES ('II-1', '7.2', '7', '2017', 'Cust', '0');
INSERT INTO `target_rkap` VALUES ('II-1', '7.2', '8', '2017', 'Cust', '3');
INSERT INTO `target_rkap` VALUES ('II-1', '7.2', '9', '2017', 'Cust', '1');
INSERT INTO `target_rkap` VALUES ('II-1', '7.2', '10', '2017', 'Cust', '3');
INSERT INTO `target_rkap` VALUES ('II-1', '7.2', '11', '2017', 'Cust', '2');
INSERT INTO `target_rkap` VALUES ('II-1', '7.2', '12', '2017', 'Cust', '4');
INSERT INTO `target_rkap` VALUES ('II-2', '7.2', '1', '2017', '%', '99');
INSERT INTO `target_rkap` VALUES ('II-2', '7.2', '2', '2017', '%', '99');
INSERT INTO `target_rkap` VALUES ('II-2', '7.2', '3', '2017', '%', '99');
INSERT INTO `target_rkap` VALUES ('II-2', '7.2', '4', '2017', '%', '99');
INSERT INTO `target_rkap` VALUES ('II-2', '7.2', '5', '2017', '%', '99');
INSERT INTO `target_rkap` VALUES ('II-2', '7.2', '6', '2017', '%', '99');
INSERT INTO `target_rkap` VALUES ('II-2', '7.2', '7', '2017', '%', '99');
INSERT INTO `target_rkap` VALUES ('II-2', '7.2', '8', '2017', '%', '99');
INSERT INTO `target_rkap` VALUES ('II-2', '7.2', '9', '2017', '%', '99');
INSERT INTO `target_rkap` VALUES ('II-2', '7.2', '10', '2017', '%', '99');
INSERT INTO `target_rkap` VALUES ('II-2', '7.2', '11', '2017', '%', '99');
INSERT INTO `target_rkap` VALUES ('II-2', '7.2', '12', '2017', '%', '99');
INSERT INTO `target_rkap` VALUES ('II-3', '7.2', '1', '2017', 'Cust', '0');
INSERT INTO `target_rkap` VALUES ('II-3', '7.2', '2', '2017', 'Cust', '0');
INSERT INTO `target_rkap` VALUES ('II-3', '7.2', '3', '2017', 'Cust', '0');
INSERT INTO `target_rkap` VALUES ('II-3', '7.2', '4', '2017', 'Cust', '0');
INSERT INTO `target_rkap` VALUES ('II-3', '7.2', '5', '2017', 'Cust', '3');
INSERT INTO `target_rkap` VALUES ('II-3', '7.2', '6', '2017', 'Cust', '0');
INSERT INTO `target_rkap` VALUES ('II-3', '7.2', '7', '2017', 'Cust', '0');
INSERT INTO `target_rkap` VALUES ('II-3', '7.2', '8', '2017', 'Cust', '2');
INSERT INTO `target_rkap` VALUES ('II-3', '7.2', '9', '2017', 'Cust', '0');
INSERT INTO `target_rkap` VALUES ('II-3', '7.2', '10', '2017', 'Cust', '3');
INSERT INTO `target_rkap` VALUES ('II-3', '7.2', '11', '2017', 'Cust', '0');
INSERT INTO `target_rkap` VALUES ('II-3', '7.2', '12', '2017', 'Cust', '0');
INSERT INTO `target_rkap` VALUES ('III-1', '7.3', '1', '2017', 'Jt Rp/Org/Th', '18.87');
INSERT INTO `target_rkap` VALUES ('III-1', '7.3', '2', '2017', 'Jt Rp/Org/Th', '22.7');
INSERT INTO `target_rkap` VALUES ('III-1', '7.3', '3', '2017', 'Jt Rp/Org/Th', '50.81');
INSERT INTO `target_rkap` VALUES ('III-1', '7.3', '4', '2017', 'Jt Rp/Org/Th', '37.07');
INSERT INTO `target_rkap` VALUES ('III-1', '7.3', '5', '2017', 'Jt Rp/Org/Th', '26.97');
INSERT INTO `target_rkap` VALUES ('III-1', '7.3', '6', '2017', 'Jt Rp/Org/Th', '42.51');
INSERT INTO `target_rkap` VALUES ('III-1', '7.3', '7', '2017', 'Jt Rp/Org/Th', '33.37');
INSERT INTO `target_rkap` VALUES ('III-1', '7.3', '8', '2017', 'Jt Rp/Org/Th', '42.08');
INSERT INTO `target_rkap` VALUES ('III-1', '7.3', '9', '2017', 'Jt Rp/Org/Th', '125.36');
INSERT INTO `target_rkap` VALUES ('III-1', '7.3', '10', '2017', 'Jt Rp/Org/Th', '48.12');
INSERT INTO `target_rkap` VALUES ('III-1', '7.3', '11', '2017', 'Jt Rp/Org/Th', '30.56');
INSERT INTO `target_rkap` VALUES ('III-1', '7.3', '12', '2017', 'Jt Rp/Org/Th', '149.94');
INSERT INTO `target_rkap` VALUES ('III-2', '7.3', '1', '2017', 'Jam/Org/Th', '3');
INSERT INTO `target_rkap` VALUES ('III-2', '7.3', '2', '2017', 'Jam/Org/Th', '3');
INSERT INTO `target_rkap` VALUES ('III-2', '7.3', '3', '2017', 'Jam/Org/Th', '6');
INSERT INTO `target_rkap` VALUES ('III-2', '7.3', '4', '2017', 'Jam/Org/Th', '6');
INSERT INTO `target_rkap` VALUES ('III-2', '7.3', '5', '2017', 'Jam/Org/Th', '6');
INSERT INTO `target_rkap` VALUES ('III-2', '7.3', '6', '2017', 'Jam/Org/Th', '6');
INSERT INTO `target_rkap` VALUES ('III-2', '7.3', '7', '2017', 'Jam/Org/Th', '6');
INSERT INTO `target_rkap` VALUES ('III-2', '7.3', '8', '2017', 'Jam/Org/Th', '6');
INSERT INTO `target_rkap` VALUES ('III-2', '7.3', '9', '2017', 'Jam/Org/Th', '7');
INSERT INTO `target_rkap` VALUES ('III-2', '7.3', '10', '2017', 'Jam/Org/Th', '7');
INSERT INTO `target_rkap` VALUES ('III-2', '7.3', '11', '2017', 'Jam/Org/Th', '7');
INSERT INTO `target_rkap` VALUES ('III-2', '7.3', '12', '2017', 'Jam/Org/Th', '7');
INSERT INTO `target_rkap` VALUES ('IV-1', '7.4', '1', '2017', '%', '0');
INSERT INTO `target_rkap` VALUES ('IV-1', '7.4', '2', '2017', '%', '0');
INSERT INTO `target_rkap` VALUES ('IV-1', '7.4', '3', '2017', '%', '0');
INSERT INTO `target_rkap` VALUES ('IV-1', '7.4', '4', '2017', '%', '0');
INSERT INTO `target_rkap` VALUES ('IV-1', '7.4', '5', '2017', '%', '0');
INSERT INTO `target_rkap` VALUES ('IV-1', '7.4', '6', '2017', '%', '1.94');
INSERT INTO `target_rkap` VALUES ('IV-1', '7.4', '7', '2017', '%', '9.39');
INSERT INTO `target_rkap` VALUES ('IV-1', '7.4', '8', '2017', '%', '12.60');
INSERT INTO `target_rkap` VALUES ('IV-1', '7.4', '9', '2017', '%', '13.57');
INSERT INTO `target_rkap` VALUES ('IV-1', '7.4', '10', '2017', '%', '22.18');
INSERT INTO `target_rkap` VALUES ('IV-1', '7.4', '11', '2017', '%', '22.18');
INSERT INTO `target_rkap` VALUES ('IV-1', '7.4', '12', '2017', '%', '18.14');
INSERT INTO `target_rkap` VALUES ('IV-2', '7.4', '1', '2017', '%', '8');
INSERT INTO `target_rkap` VALUES ('IV-2', '7.4', '2', '2017', '%', '7.64');
INSERT INTO `target_rkap` VALUES ('IV-2', '7.4', '3', '2017', '%', '');
INSERT INTO `target_rkap` VALUES ('IV-2', '7.4', '4', '2017', '%', '0');
INSERT INTO `target_rkap` VALUES ('IV-2', '7.4', '5', '2017', '%', '12.49');
INSERT INTO `target_rkap` VALUES ('IV-2', '7.4', '6', '2017', '%', '13.09');
INSERT INTO `target_rkap` VALUES ('IV-2', '7.4', '7', '2017', '%', '24.36');
INSERT INTO `target_rkap` VALUES ('IV-2', '7.4', '8', '2017', '%', '0');
INSERT INTO `target_rkap` VALUES ('IV-2', '7.4', '9', '2017', '%', '0');
INSERT INTO `target_rkap` VALUES ('IV-2', '7.4', '10', '2017', '%', '15,15');
INSERT INTO `target_rkap` VALUES ('IV-2', '7.4', '11', '2017', '%', '12.36');
INSERT INTO `target_rkap` VALUES ('IV-2', '7.4', '12', '2017', '%', '6.91');
INSERT INTO `target_rkap` VALUES ('V-1', '7.5', '1', '2017', '%', '-13.5');
INSERT INTO `target_rkap` VALUES ('V-1', '7.5', '2', '2017', '%', '-8.1');
INSERT INTO `target_rkap` VALUES ('V-1', '7.5', '3', '2017', '%', '1.5');
INSERT INTO `target_rkap` VALUES ('V-1', '7.5', '4', '2017', '%', '2.0');
INSERT INTO `target_rkap` VALUES ('V-1', '7.5', '5', '2017', '%', '0.2');
INSERT INTO `target_rkap` VALUES ('V-1', '7.5', '6', '2017', '%', '0.7');
INSERT INTO `target_rkap` VALUES ('V-1', '7.5', '7', '2017', '%', '0.8');
INSERT INTO `target_rkap` VALUES ('V-1', '7.5', '8', '2017', '%', '1.4');
INSERT INTO `target_rkap` VALUES ('V-1', '7.5', '9', '2017', '%', '3.0');
INSERT INTO `target_rkap` VALUES ('V-1', '7.5', '10', '2017', '%', '3.3');
INSERT INTO `target_rkap` VALUES ('V-1', '7.5', '11', '2017', '%', '3.7');
INSERT INTO `target_rkap` VALUES ('V-1', '7.5', '12', '2017', '%', '4.7');
INSERT INTO `target_rkap` VALUES ('V-2', '7.5', '1', '2017', '%', '7.1');
INSERT INTO `target_rkap` VALUES ('V-2', '7.5', '2', '2017', '%', '7.1');
INSERT INTO `target_rkap` VALUES ('V-2', '7.5', '3', '2017', '%', '7.1');
INSERT INTO `target_rkap` VALUES ('V-2', '7.5', '4', '2017', '%', '5.6');
INSERT INTO `target_rkap` VALUES ('V-2', '7.5', '5', '2017', '%', '5.6');
INSERT INTO `target_rkap` VALUES ('V-2', '7.5', '6', '2017', '%', '5.6');
INSERT INTO `target_rkap` VALUES ('V-2', '7.5', '7', '2017', '%', '9.0');
INSERT INTO `target_rkap` VALUES ('V-2', '7.5', '8', '2017', '%', '9.0');
INSERT INTO `target_rkap` VALUES ('V-2', '7.5', '9', '2017', '%', '9.0');
INSERT INTO `target_rkap` VALUES ('V-2', '7.5', '10', '2017', '%', '10.3');
INSERT INTO `target_rkap` VALUES ('V-2', '7.5', '11', '2017', '%', '10.3');
INSERT INTO `target_rkap` VALUES ('V-2', '7.5', '12', '2017', '%', '10.3');
INSERT INTO `target_rkap` VALUES ('V-3', '7.5', '1', '2017', '%', '-2.4');
INSERT INTO `target_rkap` VALUES ('V-3', '7.5', '2', '2017', '%', '-0.8');
INSERT INTO `target_rkap` VALUES ('V-3', '7.5', '3', '2017', '%', '4.5');
INSERT INTO `target_rkap` VALUES ('V-3', '7.5', '4', '2017', '%', '0.8');
INSERT INTO `target_rkap` VALUES ('V-3', '7.5', '5', '2017', '%', '0.3');
INSERT INTO `target_rkap` VALUES ('V-3', '7.5', '6', '2017', '%', '1.2');
INSERT INTO `target_rkap` VALUES ('V-3', '7.5', '7', '2017', '%', '1.6');
INSERT INTO `target_rkap` VALUES ('V-3', '7.5', '8', '2017', '%', '3.4');
INSERT INTO `target_rkap` VALUES ('V-3', '7.5', '9', '2017', '%', '3.4');
INSERT INTO `target_rkap` VALUES ('V-3', '7.5', '10', '2017', '%', '3.6');
INSERT INTO `target_rkap` VALUES ('V-3', '7.5', '11', '2017', '%', '14.1');
INSERT INTO `target_rkap` VALUES ('V-3', '7.5', '12', '2017', '%', '4.2');
INSERT INTO `target_rkap` VALUES ('V-4', '7.5', '1', '2017', '%', '177.2');
INSERT INTO `target_rkap` VALUES ('V-4', '7.5', '2', '2017', '%', '176.8');
INSERT INTO `target_rkap` VALUES ('V-4', '7.5', '3', '2017', '%', '181.4');
INSERT INTO `target_rkap` VALUES ('V-4', '7.5', '4', '2017', '%', '178');
INSERT INTO `target_rkap` VALUES ('V-4', '7.5', '5', '2017', '%', '178');
INSERT INTO `target_rkap` VALUES ('V-4', '7.5', '6', '2017', '%', '178');
INSERT INTO `target_rkap` VALUES ('V-4', '7.5', '7', '2017', '%', '169.6');
INSERT INTO `target_rkap` VALUES ('V-4', '7.5', '8', '2017', '%', '171.8');
INSERT INTO `target_rkap` VALUES ('V-4', '7.5', '9', '2017', '%', '140.7');
INSERT INTO `target_rkap` VALUES ('V-4', '7.5', '10', '2017', '%', '187.7');
INSERT INTO `target_rkap` VALUES ('V-4', '7.5', '11', '2017', '%', '184.9');
INSERT INTO `target_rkap` VALUES ('V-4', '7.5', '12', '2017', '%', '187.7');
INSERT INTO `target_rkap` VALUES ('V-5', '7.5', '1', '2017', 'Hari', '202');
INSERT INTO `target_rkap` VALUES ('V-5', '7.5', '2', '2017', 'Hari', '202');
INSERT INTO `target_rkap` VALUES ('V-5', '7.5', '3', '2017', 'Hari', '202');
INSERT INTO `target_rkap` VALUES ('V-5', '7.5', '4', '2017', 'Hari', '123');
INSERT INTO `target_rkap` VALUES ('V-5', '7.5', '5', '2017', 'Hari', '202');
INSERT INTO `target_rkap` VALUES ('V-5', '7.5', '6', '2017', 'Hari', '202');
INSERT INTO `target_rkap` VALUES ('V-5', '7.5', '7', '2017', 'Hari', '202');
INSERT INTO `target_rkap` VALUES ('V-5', '7.5', '8', '2017', 'Hari', '202');
INSERT INTO `target_rkap` VALUES ('V-5', '7.5', '9', '2017', 'Hari', '178');
INSERT INTO `target_rkap` VALUES ('V-5', '7.5', '10', '2017', 'Hari', '110');
INSERT INTO `target_rkap` VALUES ('V-5', '7.5', '11', '2017', 'Hari', '120');
INSERT INTO `target_rkap` VALUES ('V-5', '7.5', '12', '2017', 'Hari', '110');
INSERT INTO `target_rkap` VALUES ('V-6', '7.5', '1', '2017', 'Rp. M', '0.685');
INSERT INTO `target_rkap` VALUES ('V-6', '7.5', '2', '2017', 'Rp. M', '1.126');
INSERT INTO `target_rkap` VALUES ('V-6', '7.5', '3', '2017', 'Rp. M', '7.101');
INSERT INTO `target_rkap` VALUES ('V-6', '7.5', '4', '2017', 'Rp. M', '2.021');
INSERT INTO `target_rkap` VALUES ('V-6', '7.5', '5', '2017', 'Rp. M', '2.382');
INSERT INTO `target_rkap` VALUES ('V-6', '7.5', '6', '2017', 'Rp. M', '3.402');
INSERT INTO `target_rkap` VALUES ('V-6', '7.5', '7', '2017', 'Rp. M', '2.192');
INSERT INTO `target_rkap` VALUES ('V-6', '7.5', '8', '2017', 'Rp. M', '2.542');
INSERT INTO `target_rkap` VALUES ('V-6', '7.5', '9', '2017', 'Rp. M', '25.542');
INSERT INTO `target_rkap` VALUES ('V-6', '7.5', '10', '2017', 'Rp. M', '5.496');
INSERT INTO `target_rkap` VALUES ('V-6', '7.5', '11', '2017', 'Rp. M', '2.896');
INSERT INTO `target_rkap` VALUES ('V-6', '7.5', '12', '2017', 'Rp. M', '32.942');
INSERT INTO `target_rkap` VALUES ('V-7', '7.5', '1', '2017', '%', '119');
INSERT INTO `target_rkap` VALUES ('V-7', '7.5', '2', '2017', '%', '119');
INSERT INTO `target_rkap` VALUES ('V-7', '7.5', '3', '2017', '%', '119');
INSERT INTO `target_rkap` VALUES ('V-7', '7.5', '4', '2017', '%', '102');
INSERT INTO `target_rkap` VALUES ('V-7', '7.5', '5', '2017', '%', '102');
INSERT INTO `target_rkap` VALUES ('V-7', '7.5', '6', '2017', '%', '102');
INSERT INTO `target_rkap` VALUES ('V-7', '7.5', '7', '2017', '%', '115');
INSERT INTO `target_rkap` VALUES ('V-7', '7.5', '8', '2017', '%', '115');
INSERT INTO `target_rkap` VALUES ('V-7', '7.5', '9', '2017', '%', '115');
INSERT INTO `target_rkap` VALUES ('V-7', '7.5', '10', '2017', '%', '124');
INSERT INTO `target_rkap` VALUES ('V-7', '7.5', '11', '2017', '%', '124');
INSERT INTO `target_rkap` VALUES ('V-7', '7.5', '12', '2017', '%', '124');
INSERT INTO `target_rkap` VALUES ('V-8', '7.5', '1', '2017', '%', '98.1');
INSERT INTO `target_rkap` VALUES ('V-8', '7.5', '2', '2017', '%', '98.1');
INSERT INTO `target_rkap` VALUES ('V-8', '7.5', '3', '2017', '%', '98.1');
INSERT INTO `target_rkap` VALUES ('V-8', '7.5', '4', '2017', '%', '98.5');
INSERT INTO `target_rkap` VALUES ('V-8', '7.5', '5', '2017', '%', '98.5');
INSERT INTO `target_rkap` VALUES ('V-8', '7.5', '6', '2017', '%', '98.5');
INSERT INTO `target_rkap` VALUES ('V-8', '7.5', '7', '2017', '%', '94.7');
INSERT INTO `target_rkap` VALUES ('V-8', '7.5', '8', '2017', '%', '94.7');
INSERT INTO `target_rkap` VALUES ('V-8', '7.5', '9', '2017', '%', '94.7');
INSERT INTO `target_rkap` VALUES ('V-8', '7.5', '10', '2017', '%', '92.9');
INSERT INTO `target_rkap` VALUES ('V-8', '7.5', '11', '2017', '%', '92.9');
INSERT INTO `target_rkap` VALUES ('V-8', '7.5', '12', '2017', '%', '92.9');
