/*
Navicat MySQL Data Transfer

Source Server         : kinerja
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_kinerja

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-15 11:43:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for integrasi
-- ----------------------------
DROP TABLE IF EXISTS `integrasi`;
CREATE TABLE `integrasi` (
  `id_integrasi` int(10) NOT NULL AUTO_INCREMENT,
  `id_srk` char(10) NOT NULL,
  `integrasi` text NOT NULL,
  PRIMARY KEY (`id_integrasi`)
) ENGINE=InnoDB AUTO_INCREMENT=460 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of integrasi
-- ----------------------------
INSERT INTO `integrasi` VALUES ('1', 'A01', 'a:1:{i:0;s:7:\"All SBU\";}');
INSERT INTO `integrasi` VALUES ('2', 'A02', 'a:1:{i:0;s:7:\"All SBU\";}');
INSERT INTO `integrasi` VALUES ('7', '', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('29', '50', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('43', '134', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('70', '120', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('90', '174', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('102', '161', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('116', '148', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('131', '133', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('132', '147', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('138', '132', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('140', '146', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('142', '1', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('149', '4', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('154', '6', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('155', '5', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('157', '8', 'a:3:{i:0;s:15:\"Divisi Keuangan\";i:1;s:20:\"Divisi Human Capital\";i:2;s:14:\"Dinas Logistik\";}');
INSERT INTO `integrasi` VALUES ('158', '9', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('159', '10', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('162', '13', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('163', '14', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('164', '15', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('165', '16', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('166', '17', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('168', '19', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('174', '23', 'a:2:{i:0;s:15:\"Divisi Keuangan\";i:1;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('175', '21', 'a:3:{i:0;s:7:\"All SBU\";i:1;s:15:\"Divisi Keuangan\";i:2;s:31:\"Divisi Corporate Transformation\";}');
INSERT INTO `integrasi` VALUES ('176', '24', 'a:1:{i:0;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('177', '11', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('178', '12', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('180', '18', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('181', '20', 'a:3:{i:0;s:15:\"Divisi Keuangan\";i:1;s:14:\"Dinas Logistik\";i:2;s:19:\"Corporate Secretary\";}');
INSERT INTO `integrasi` VALUES ('182', '7', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('184', '33', 'a:2:{i:0;s:14:\"SBU AB Non SAP\";i:1;s:20:\"SBU Infrastruktur IT\";}');
INSERT INTO `integrasi` VALUES ('186', '34', 'a:1:{i:0;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('187', '26', 'a:1:{i:0;s:7:\"All SBU\";}');
INSERT INTO `integrasi` VALUES ('188', '27', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('189', '28', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('190', '29', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('191', '30', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('192', '31', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('193', '32', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('213', '52', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('214', '53', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('215', '35', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('216', '36', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('217', '37', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('218', '38', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('219', '39', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('220', '42', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('221', '43', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('222', '44', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('223', '45', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('224', '46', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('225', '47', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('226', '48', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('227', '49', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('228', '51', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('230', '84', 'a:2:{i:0;s:14:\"SBU AB Non SAP\";i:1;s:20:\"SBU Infrastruktur IT\";}');
INSERT INTO `integrasi` VALUES ('231', '85', 'a:1:{i:0;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('232', '72', 'a:1:{i:0;s:7:\"All SBU\";}');
INSERT INTO `integrasi` VALUES ('233', '73', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('234', '74', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('235', '75', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('236', '76', 'a:1:{i:0;s:7:\"All SBU\";}');
INSERT INTO `integrasi` VALUES ('237', '77', 'a:1:{i:0;s:7:\"All SBU\";}');
INSERT INTO `integrasi` VALUES ('242', '83', 'a:3:{i:0;s:22:\"Dinas Internal Auditor\";i:1;s:14:\"Dinas Logistik\";i:2;s:19:\"Corporate Secretary\";}');
INSERT INTO `integrasi` VALUES ('244', '68', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('245', '69', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('246', '70', 'a:1:{i:0;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('247', '54', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('248', '55', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('250', '57', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('259', '179', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('260', '67', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('261', '66', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('262', '65', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('263', '64', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('264', '63', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('265', '62', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('266', '61', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('267', '60', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('268', '59', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('269', '58', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('277', '92', 'a:1:{i:0;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('278', '87', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('279', '86', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('280', '88', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('281', '89', 'a:1:{i:0;s:14:\"Dinas Logistik\";}');
INSERT INTO `integrasi` VALUES ('282', '90', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('283', '102', 'a:1:{i:0;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('284', '94', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('285', '95', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('286', '96', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('287', '97', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('288', '98', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('289', '99', 'a:1:{i:0;s:19:\"Corporate Secretary\";}');
INSERT INTO `integrasi` VALUES ('290', '100', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('291', '93', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('295', '109', 'a:1:{i:0;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('296', '103', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('297', '104', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('298', '105', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('299', '107', 'a:3:{i:0;s:15:\"Divisi Keuangan\";i:1;s:14:\"Dinas Logistik\";i:2;s:19:\"Corporate Secretary\";}');
INSERT INTO `integrasi` VALUES ('300', '108', 'a:3:{i:0;s:7:\"All SBU\";i:1;s:15:\"Divisi Keuangan\";i:2;s:31:\"Divisi Corporate Transformation\";}');
INSERT INTO `integrasi` VALUES ('304', '178', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('305', '78', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('306', '158', 'a:2:{i:0;s:15:\"Divisi Keuangan\";i:1;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('307', '22', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('310', '173', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('311', '175', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('312', '164', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('313', '171', 'a:2:{i:0;s:15:\"Divisi Keuangan\";i:1;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('314', '172', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('317', '177', 'a:1:{i:0;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('318', '166', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('319', '167', 'a:2:{i:0;s:20:\"Divisi Human Capital\";i:1;s:31:\"Divisi Corporate Transformation\";}');
INSERT INTO `integrasi` VALUES ('320', '168', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('321', '169', 'a:2:{i:0;s:15:\"Divisi Keuangan\";i:1;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('322', '170', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('323', '123', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('324', '124', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('325', '131', 'a:2:{i:0;s:15:\"Divisi Keuangan\";i:1;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('328', '136', 'a:1:{i:0;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('329', '126', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('330', '127', 'a:2:{i:0;s:20:\"Divisi Human Capital\";i:1;s:31:\"Divisi Corporate Transformation\";}');
INSERT INTO `integrasi` VALUES ('331', '128', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('332', '129', 'a:2:{i:0;s:15:\"Divisi Keuangan\";i:1;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('333', '130', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('334', '144', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('335', '143', 'a:2:{i:0;s:15:\"Divisi Keuangan\";i:1;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('336', '142', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('337', '141', 'a:2:{i:0;s:20:\"Divisi Human Capital\";i:1;s:31:\"Divisi Corporate Transformation\";}');
INSERT INTO `integrasi` VALUES ('338', '140', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('339', '150', 'a:1:{i:0;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('342', '145', 'a:2:{i:0;s:15:\"Divisi Keuangan\";i:1;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('343', '138', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('344', '137', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('345', '157', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('346', '156', 'a:2:{i:0;s:15:\"Divisi Keuangan\";i:1;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('347', '155', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('348', '154', 'a:2:{i:0;s:20:\"Divisi Human Capital\";i:1;s:31:\"Divisi Corporate Transformation\";}');
INSERT INTO `integrasi` VALUES ('349', '153', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('350', '163', 'a:1:{i:0;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('353', '160', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('354', '159', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('355', '151', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('356', '114', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('357', '113', 'a:2:{i:0;s:20:\"Divisi Human Capital\";i:1;s:31:\"Divisi Corporate Transformation\";}');
INSERT INTO `integrasi` VALUES ('358', '116', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('359', '115', 'a:2:{i:0;s:15:\"Divisi Keuangan\";i:1;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('360', '119', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('361', '118', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('362', '117', 'a:2:{i:0;s:15:\"Divisi Keuangan\";i:1;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('363', '122', 'a:1:{i:0;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('365', '112', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('367', '110', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('368', '3', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('369', '25', 'a:3:{i:0;s:22:\"Dinas Internal Auditor\";i:1;s:14:\"Dinas Logistik\";i:2;s:19:\"Corporate Secretary\";}');
INSERT INTO `integrasi` VALUES ('370', '71', 'a:3:{i:0;s:22:\"Dinas Internal Auditor\";i:1;s:14:\"Dinas Logistik\";i:2;s:19:\"Corporate Secretary\";}');
INSERT INTO `integrasi` VALUES ('371', '80', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('372', '81', 'a:1:{i:0;s:22:\"Dinas Internal Auditor\";}');
INSERT INTO `integrasi` VALUES ('373', '82', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('374', '56', 'a:1:{i:0;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('375', '125', 'a:1:{i:0;s:14:\"Dinas Logistik\";}');
INSERT INTO `integrasi` VALUES ('376', '135', 'a:2:{i:0;s:15:\"Divisi Keuangan\";i:1;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('377', '139', 'a:1:{i:0;s:14:\"Dinas Logistik\";}');
INSERT INTO `integrasi` VALUES ('378', '149', 'a:2:{i:0;s:15:\"Divisi Keuangan\";i:1;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('379', '165', 'a:1:{i:0;s:14:\"Dinas Logistik\";}');
INSERT INTO `integrasi` VALUES ('380', '176', 'a:2:{i:0;s:15:\"Divisi Keuangan\";i:1;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('381', '152', 'a:1:{i:0;s:14:\"Dinas Logistik\";}');
INSERT INTO `integrasi` VALUES ('382', '162', 'a:2:{i:0;s:15:\"Divisi Keuangan\";i:1;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('383', '111', 'a:1:{i:0;s:14:\"Dinas Logistik\";}');
INSERT INTO `integrasi` VALUES ('384', '121', 'a:2:{i:0;s:15:\"Divisi Keuangan\";i:1;s:20:\"Divisi Human Capital\";}');
INSERT INTO `integrasi` VALUES ('385', '2', 'a:1:{i:0;s:15:\"Divisi Keuangan\";}');
INSERT INTO `integrasi` VALUES ('386', '309', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('387', '404', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('391', '413', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('392', '416', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('393', '417', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('394', '418', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('395', '419', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('396', '397', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('397', '398', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('398', '401', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('399', '402', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('400', '405', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('401', '406', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('402', '408', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('404', '410', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('405', '387', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('406', '388', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('407', '391', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('408', '392', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('409', '364', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('410', '366', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('411', '370', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('412', '372', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('413', '359', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('415', '361', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('416', '345', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('417', '346', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('418', '348', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('419', '351', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('420', '352', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('421', '421', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('422', '422', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('423', '423', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('424', '424', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('425', '425', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('426', '427', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('427', '377', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('428', '381', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('429', '340', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('430', '335', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('431', '336', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('432', '337', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('433', '338', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('436', '180', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('437', '181', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('438', '182', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('441', '183', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('442', '184', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('443', '185', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('444', '186', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('445', '187', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('446', '188', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('447', '189', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('448', '190', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('449', '191', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('450', '192', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('451', '434', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('452', '439', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('453', '440', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('454', '442', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('455', '443', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('456', '449', 'a:2:{i:0;s:7:\"All SBU\";i:1;s:8:\"All Unit\";}');
INSERT INTO `integrasi` VALUES ('458', '409', 'a:0:{}');
INSERT INTO `integrasi` VALUES ('459', '452', 'a:1:{i:0;s:8:\"All Unit\";}');
