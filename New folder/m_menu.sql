/*
Navicat MySQL Data Transfer

Source Server         : kinerja
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_kinerja

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-15 11:44:51
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for m_menu
-- ----------------------------
DROP TABLE IF EXISTS `m_menu`;
CREATE TABLE `m_menu` (
  `id_menu` int(25) NOT NULL AUTO_INCREMENT,
  `parentId` int(25) DEFAULT NULL,
  `menu` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL,
  `dir` varchar(50) NOT NULL,
  `file` varchar(50) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `status` int(1) NOT NULL,
  `view` int(1) NOT NULL,
  `order` int(3) NOT NULL,
  PRIMARY KEY (`id_menu`),
  KEY `index_menu` (`id_menu`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of m_menu
-- ----------------------------
INSERT INTO `m_menu` VALUES ('1', '0', 'Organisasi', 'organisasi', 'mod_org', 'struktur_org', 'sitemap', '1', '1', '2');
INSERT INTO `m_menu` VALUES ('2', '0', 'SRKO & KPI', '#', '#', '#', 'table', '1', '1', '3');
INSERT INTO `m_menu` VALUES ('3', '2', 'SRKO', 'data_srko', 'mod_srko', 'data_srko', '', '1', '1', '1');
INSERT INTO `m_menu` VALUES ('4', '2', 'Form SRKO', 'form_srko', 'mod_srko', 'form_srko', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('5', '2', 'Import SRKO', 'import_srko', 'mod_srko', 'form_import', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('6', '2', 'SRKO to GCA', 'import_to_gca', 'mod_srko', 'import_to_gca', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('7', '2', 'Target SRKO', 'target_srko', 'mod_target_srko', 'target_srko', '', '1', '1', '2');
INSERT INTO `m_menu` VALUES ('8', '2', 'Katalog KPI', 'katalog_kpi', 'mod_kpi', 'data_kpi', '', '1', '1', '3');
INSERT INTO `m_menu` VALUES ('9', '2', 'Form KPI', 'form_kpi', 'mod_kpi', 'form_kpi', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('10', '0', 'SRKK & MSKK', '#', '#', '#', 'th', '0', '0', '4');
INSERT INTO `m_menu` VALUES ('11', '0', 'GCA', '#', '#', '#', 'folder', '1', '1', '5');
INSERT INTO `m_menu` VALUES ('12', '11', 'Data GCA', 'data_gca', 'mod_gca', 'data_gca', '', '1', '1', '1');
INSERT INTO `m_menu` VALUES ('13', '11', 'Form GCA', 'form_gca', 'mod_gca', 'form_gca', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('14', '11', 'Import GCA', 'import_gca', 'mod_gca', 'form_import', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('15', '11', 'Cek GCA', 'cek_gca', 'mod_gca', 'cek_gca', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('16', '11', 'GCA Load', 'gca_load', 'mod_gca', 'gca_load', '', '1', '1', '2');
INSERT INTO `m_menu` VALUES ('17', '11', 'Detail GCA', 'gca_load_detail', 'mod_gca', 'detail', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('18', '11', 'Update GCA', 'update_gca_load', 'mod_gca', 'update_detail', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('19', '0', 'Job Order', 'job_order', 'mod_job_order', 'data_jo', 'book', '0', '1', '6');
INSERT INTO `m_menu` VALUES ('20', '19', 'Form Job Order', 'form_jo', 'mod_job_order', 'form_jo', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('21', '0', 'Pencapaian Kerja (KKWK)', 'pencapaian_kerja', 'mod_kkwk', 'data_kkwk', 'book', '0', '0', '7');
INSERT INTO `m_menu` VALUES ('22', '21', 'Form KKWK', 'form_kkwk', 'mod_kkwk', 'form_kkwk', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('23', '0', 'Penilaian Kinerja', '#', '#', '#', 'pencil-square-o', '1', '1', '8');
INSERT INTO `m_menu` VALUES ('24', '23', 'Form Penilaian', 'form_penilaian', 'mod_penilaian', 'form_penilaian', '', '0', '0', '0');
INSERT INTO `m_menu` VALUES ('25', '0', 'Laporan', '#', '#', '#', 'file', '0', '0', '9');
INSERT INTO `m_menu` VALUES ('26', '25', 'Kinerja Bulanan', 'kinerja_bulanan', 'mod_laporan', 'data_kinerja_bulanan', '', '1', '1', '1');
INSERT INTO `m_menu` VALUES ('27', '25', 'Summary KKWK', 'summary_kkwk', 'mod_laporan', 'data_summary_kkwk', '', '1', '1', '2');
INSERT INTO `m_menu` VALUES ('28', '0', 'Administration', '#', '#', '#', 'user', '1', '1', '11');
INSERT INTO `m_menu` VALUES ('29', '28', 'Manage User', 'manage_user', 'mod_user', 'view_user', '', '1', '1', '1');
INSERT INTO `m_menu` VALUES ('30', '28', 'Data Karyawan', 'data_karyawan', 'mod_user', 'data_karyawan', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('31', '28', 'Form User', 'form_user', 'mod_user', 'form_user', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('32', '28', 'Manage Menu', 'manage_menu', 'mod_menu', 'view_menu', '', '1', '1', '2');
INSERT INTO `m_menu` VALUES ('33', '28', 'Form Menu', 'form_menu', 'mod_menu', 'form_menu', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('34', '28', 'Form Submenu', 'form_submenu', 'mod_menu', 'form_submenu', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('35', '28', 'Manage Level', 'manage_level', 'mod_level', 'view_level', '', '1', '1', '3');
INSERT INTO `m_menu` VALUES ('36', '28', 'Privileges', 'privileges', 'mod_user', 'privileges', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('37', '28', 'Form Level', 'form_level', 'mod_level', 'form_level', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('38', '28', 'Upload File', 'upload_file', 'mod_upload', 'data_upload', '', '1', '1', '4');
INSERT INTO `m_menu` VALUES ('39', '28', 'Form Upload', 'form_upload', 'mod_upload', 'form_upload', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('40', '0', 'Dashboard', 'dashboard', 'mod_dashboard', 'dashboard', 'dashboard', '1', '0', '1');
INSERT INTO `m_menu` VALUES ('41', '28', 'Privileges_lv', 'privileges_lv', 'mod_level', 'privileges', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('42', '2', 'Kontrak Manajemen', 'kontrak_manajemen', 'mod_km', 'kontrak_manajemen', '', '0', '1', '0');
INSERT INTO `m_menu` VALUES ('43', '2', 'From Target SRKO', 'form_target', 'mod_target_srko', 'form_target', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('44', '2', 'Data Target SRKO', 'data_target_srko', 'mod_target_srko', 'data_target', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('45', '2', 'Data SRKO Full', 'data_srko_full', 'mod_srko', 'data_srko_full', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('46', '10', 'Data SRKK', 'data_srkk', 'mod_srkk', 'data_srkk', '', '1', '1', '1');
INSERT INTO `m_menu` VALUES ('47', '10', 'SRKK', 'srkk', 'mod_srkk', 'srkk', '', '1', '1', '2');
INSERT INTO `m_menu` VALUES ('48', '10', 'From SRKK', 'form_srkk', 'mod_srkk', 'form_srkk', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('49', '10', 'MSKK', 'mskk', 'mod_mskk', 'data_mskk', '', '1', '1', '3');
INSERT INTO `m_menu` VALUES ('50', '10', 'Detail SRKK', 'detail_srkk', 'mod_srkk', 'detail_srkk', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('51', '11', 'Cari GCA', 'cari_gca', 'mod_cari_gca', 'gca_search', '', '1', '1', '3');
INSERT INTO `m_menu` VALUES ('54', '21', 'Form KKWK Update', 'form_kkwk_update', 'mod_kkwk', 'form_kkwk_update', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('55', '25', 'Summary KKWK /CC', 'summary_kkwk_cc', 'mod_laporan', 'data_summary_kkwk_cc', '', '1', '1', '3');
INSERT INTO `m_menu` VALUES ('56', '2', 'Progress SRKO', 'data_progress_srko', 'mod_target_srko', 'progress_srko', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('57', '2', 'From Progress SRKO', 'form_progress', 'mod_target_srko', 'form_progress', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('58', '2', 'Hitung Progress', 'hitung_progress', 'mod_target_srko', 'hitung_progress', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('59', '28', 'Form Karyawan', 'form_karyawan', 'mod_user', 'form_karyawan', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('60', '2', 'Form Ket-Progress', 'ket_progress', 'mod_target_srko', 'form_ket_progress', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('61', '2', 'Target KPI', 'target_kpi', 'mod_kpi', 'target_kpi', '', '1', '1', '4');
INSERT INTO `m_menu` VALUES ('62', '2', 'Form Target KPI', 'form_target_kpi', 'mod_kpi', 'form_target_kpi', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('63', '2', 'From KPKU', 'form_kpku_kpi', 'mod_kpi', 'form_kpi_kpku', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('64', '2', 'Chart KPI', 'chart_kpi', 'mod_kpi', 'chart_kpi', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('65', '10', 'Detail MSKK', 'detail_mskk', 'mod_mskk', 'detail_mskk', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('66', '25', 'Summary MSKK', 'summary_mskk', 'mod_laporan', 'data_summary_mskk', '', '1', '1', '5');
INSERT INTO `m_menu` VALUES ('68', '0', 'Timeline', 'timeline', 'mod_timeline', 'timeline', 'clock-o', '1', '1', '10');
INSERT INTO `m_menu` VALUES ('69', '28', 'Manage Time', 'time', 'mod_time', 'data_time', 'calendar', '1', '1', '5');
INSERT INTO `m_menu` VALUES ('71', '28', 'Backup Database', 'backup', 'mod_backup', 'mod_backup', '', '1', '1', '6');
INSERT INTO `m_menu` VALUES ('72', '25', 'Summary SRKK', 'summary_srkk', 'mod_laporan', 'data_summary_srkk', '', '1', '1', '4');
INSERT INTO `m_menu` VALUES ('73', '2', 'Grafik Pencapaian', 'grafik_realisasi', 'mod_target_srko', 'grafik_realisasi', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('75', '23', 'Penilaian Karyawan', 'penilaian_kerja', 'mod_penilaian', 'data_penilaian', '', '0', '0', '0');
INSERT INTO `m_menu` VALUES ('76', '23', 'Pengisian Sasaran Kerja Karyawan(SKK)', 'data_penilaian_karyawan', 'mod_penilaian', 'data_penilaian_karyawan', '', '1', '1', '0');
INSERT INTO `m_menu` VALUES ('77', '23', 'Form Penilaian Kerja Keryawan', 'form_penilaian_karyawan', 'mod_penilaian', 'form_penilaian_karyawan', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('78', '23', 'Penilaian Karyawan', 'penilaian_skk', 'mod_penilaian', 'penilaian_skk', '', '1', '1', '0');
INSERT INTO `m_menu` VALUES ('79', '23', 'Form Penilaian SKK', 'form_penilaian_skk', 'mod_penilaian', 'form_penilaian_skk', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('80', '23', 'Resume Penilaian Karyawan', 'report_skk', 'mod_penilaian', 'report_skk', '', '1', '1', '0');
INSERT INTO `m_menu` VALUES ('81', '23', 'Resume Penilaian Kepala Unit', 'report_kepala_unit', 'mod_penilaian', 'report_kepala_unit', '', '1', '1', '0');
INSERT INTO `m_menu` VALUES ('82', '23', 'form_penilaian_karyawan_penilai', 'form_penilaian_karyawan_2', 'mod_penilaian', 'form_penilaian_karyawan_2', '', '0', '0', '0');
INSERT INTO `m_menu` VALUES ('83', '23', 'Resume Penilaian SRKO', 'report_sku', 'mod_penilaian', 'report_sku', '', '1', '1', '0');
INSERT INTO `m_menu` VALUES ('85', '28', 'Manage Satuan', 'satuan', 'mod_satuan', 'satuan', '', '1', '1', '0');
INSERT INTO `m_menu` VALUES ('86', '28', 'Form Satuan', 'form_satuan', 'mod_satuan', 'form_satuan', '', '1', '0', '0');
INSERT INTO `m_menu` VALUES ('87', '23', 'Report Karyawan', 'report_penilaian_karyawan', 'mod_penilaian', 'report_penilaian_karyawan', '', '1', '1', '0');
