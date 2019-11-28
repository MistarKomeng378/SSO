/*
Navicat MySQL Data Transfer

Source Server         : kinerja
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_kinerja

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-15 11:44:06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for kpku_kpi
-- ----------------------------
DROP TABLE IF EXISTS `kpku_kpi`;
CREATE TABLE `kpku_kpi` (
  `id_kpi` char(10) NOT NULL,
  `id_srko` char(10) NOT NULL,
  `tahun` int(4) NOT NULL,
  `id_perspektif` char(10) NOT NULL,
  `kpi` text NOT NULL,
  `bobot` char(15) NOT NULL,
  `satuan` varchar(30) NOT NULL,
  `target_tahun` char(15) NOT NULL,
  `rumus` int(1) NOT NULL,
  `perhitungan` int(1) NOT NULL,
  `v_rkap` int(1) NOT NULL,
  `v_real` int(1) NOT NULL,
  `v_rkap_kom` int(1) NOT NULL,
  `v_real_kom` int(1) NOT NULL,
  `v_prosen_real` int(1) NOT NULL,
  `v_prosen_kom` int(1) NOT NULL,
  `t_rkap` int(1) NOT NULL,
  `t_real` int(1) NOT NULL,
  `t_rkap_kom` int(1) NOT NULL,
  `t_real_kom` int(1) NOT NULL,
  `t_prosen_real` int(1) NOT NULL,
  `t_prosen_kom` int(1) NOT NULL,
  `scale` varchar(50) NOT NULL,
  PRIMARY KEY (`id_kpi`),
  KEY `kpi` (`id_perspektif`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of kpku_kpi
-- ----------------------------
INSERT INTO `kpku_kpi` VALUES ('1', '4', '2017', '', 'Kontrak', '', 'Rp. M', '226.064', '1', '2', '0', '0', '1', '1', '0', '0', '0', '0', '1', '1', '0', '1', '0:275:25');
INSERT INTO `kpku_kpi` VALUES ('2', '2', '2017', '', 'Pendapatan', '', 'Rp. M', '160.860', '1', '2', '0', '0', '1', '1', '0', '0', '0', '0', '1', '1', '0', '1', '0:190:20');
INSERT INTO `kpku_kpi` VALUES ('3', '18', '2017', '', 'Cash Ratio', '', '%', '26.0', '1', '1', '1', '1', '0', '0', '0', '0', '1', '1', '0', '0', '1', '0', '::');
INSERT INTO `kpku_kpi` VALUES ('4', '', '2017', '', 'Jumlah Karyawan', '', 'Karyawan', '256', '2', '1', '1', '1', '0', '0', '0', '0', '1', '1', '0', '0', '1', '0', '::');
INSERT INTO `kpku_kpi` VALUES ('I-1', '8', '2017', '7.1', 'Tingkat Penyelesaian Proyek', '5', '%', '95', '1', '2', '1', '1', '1', '1', '0', '0', '1', '1', '1', '1', '1', '1', '::');
INSERT INTO `kpku_kpi` VALUES ('I-2', '22', '2017', '7.1', 'Penyelesaian Aplikasi Internal SIM KIT (HC, Keu)', '5', '%', '95', '1', '2', '0', '0', '1', '1', '0', '0', '0', '0', '1', '1', '0', '1', '::');
INSERT INTO `kpku_kpi` VALUES ('II-1', '5', '2017', '7.2', 'Pelanggan Repeat Order', '5', 'Cust', '25', '1', '2', '0', '0', '1', '1', '0', '0', '0', '0', '1', '1', '0', '1', '0:30:1');
INSERT INTO `kpku_kpi` VALUES ('II-2', '', '2017', '7.2', 'Tingkat Kepuasan Pelanggan', '5', '%', '99', '1', '3', '1', '1', '0', '0', '0', '0', '1', '1', '0', '0', '0', '0', '95:100:1');
INSERT INTO `kpku_kpi` VALUES ('II-3', '6', '2017', '7.2', 'Pelanggan Baru', '10', 'Cust', '8', '1', '2', '0', '0', '1', '1', '0', '0', '0', '0', '1', '1', '0', '1', '::');
INSERT INTO `kpku_kpi` VALUES ('III-1', '23', '2017', '7.3', 'Produktivitas Karyawan', '5', 'Jt Rp/Org/Th', '628', '1', '2', '0', '0', '1', '1', '0', '0', '0', '0', '1', '1', '0', '1', '::');
INSERT INTO `kpku_kpi` VALUES ('III-2', '24', '2017', '7.3', 'Jam Pembelajaran Karyawan', '5', 'Jam/Org/Th', '70', '1', '2', '0', '0', '1', '1', '0', '0', '0', '0', '1', '1', '0', '1', '::');
INSERT INTO `kpku_kpi` VALUES ('IV-1', '14', '2017', '7.4', 'Evaluasi Implementasi SM KIT', '5', '%', '100', '1', '2', '0', '0', '1', '1', '0', '0', '0', '0', '1', '1', '0', '1', '::');
INSERT INTO `kpku_kpi` VALUES ('IV-2', '3', '2017', '7.4', 'Penyelesaian Laporan Audit', '5', '%', '100', '1', '2', '0', '0', '1', '1', '0', '0', '0', '0', '1', '1', '0', '1', '::');
INSERT INTO `kpku_kpi` VALUES ('V-1', '', '2017', '7.5', 'Profit Margin', '10', '%', '4.7', '1', '2', '1', '1', '0', '0', '0', '0', '1', '1', '0', '0', '1', '0', '::');
INSERT INTO `kpku_kpi` VALUES ('V-2', '', '2017', '7.5', 'Margin EBITDA', '5', '%', '10.3', '1', '3', '1', '1', '0', '0', '0', '0', '1', '1', '0', '0', '1', '0', '::');
INSERT INTO `kpku_kpi` VALUES ('V-3', '', '2017', '7.5', 'ROE', '5', '%', '21.7', '1', '2', '0', '0', '1', '1', '0', '0', '0', '0', '1', '1', '0', '1', '-12:25:0');
INSERT INTO `kpku_kpi` VALUES ('V-4', '', '2017', '7.5', 'Current Ratio', '5', '%', '187.7', '1', '1', '1', '1', '0', '0', '0', '0', '1', '1', '0', '0', '1', '0', '130:190:10');
INSERT INTO `kpku_kpi` VALUES ('V-5', '', '2017', '7.5', 'Collection Period', '5', 'Hari', '110', '2', '3', '1', '1', '0', '0', '0', '0', '1', '1', '0', '0', '1', '0', '::');
INSERT INTO `kpku_kpi` VALUES ('V-6', '', '2017', '7.5', 'Pendapatan Pihak Ketiga', '5', 'Rp. M', '88.3', '1', '2', '0', '0', '1', '1', '0', '0', '0', '0', '1', '1', '0', '1', '::');
INSERT INTO `kpku_kpi` VALUES ('V-7', '', '2017', '7.5', 'Pertumbuhan Pendapatan', '5', '%', '124', '1', '1', '1', '1', '0', '0', '0', '0', '1', '1', '0', '0', '1', '0', '80:150:5');
INSERT INTO `kpku_kpi` VALUES ('V-8', '', '2017', '7.5', 'BOPO', '10', '%', '92.9', '2', '3', '1', '1', '0', '0', '0', '0', '1', '1', '0', '0', '1', '0', '70:130:10');
