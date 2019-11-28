/*
Navicat MySQL Data Transfer

Source Server         : kinerja
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_kinerja

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-15 11:44:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for kpi
-- ----------------------------
DROP TABLE IF EXISTS `kpi`;
CREATE TABLE `kpi` (
  `no_urut` int(10) NOT NULL AUTO_INCREMENT,
  `id_kpi` int(10) NOT NULL,
  `kpi` text,
  `definisi` text NOT NULL,
  `tahun` int(4) DEFAULT NULL,
  `status_kpi` int(1) NOT NULL,
  PRIMARY KEY (`no_urut`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of kpi
-- ----------------------------
INSERT INTO `kpi` VALUES ('1', '1', 'Tingkat Margin Proyek', 'Laba Bersih / total Pendapatan', '2017', '1');
INSERT INTO `kpi` VALUES ('2', '2', 'Jumlah Perolehan Pendapatan', 'Jumlah Pendapatan yang diperoleh', '2017', '1');
INSERT INTO `kpi` VALUES ('3', '3', 'Penyelesaian Audit Eksternal', 'Persentase Penyelesaian Audit', '2017', '1');
INSERT INTO `kpi` VALUES ('4', '4', 'Jumlah Perolehan Kontrak', 'Nilai kontrak yg diperoleh', '2017', '1');
INSERT INTO `kpi` VALUES ('5', '5', 'Jumlah Customer Repeat Order', 'Jumlah Customer yg melakukan order ulang', '2017', '1');
INSERT INTO `kpi` VALUES ('6', '6', 'Jumlah Pelanggan baru', 'Jumlah pelanggan yg baru pertamakali melakukan kontrak', '2017', '1');
INSERT INTO `kpi` VALUES ('7', '7', 'Tingkat Kepuasan Pelanggan', 'Persentase program perbaikan kepuasan pelanggan', '2017', '1');
INSERT INTO `kpi` VALUES ('8', '8', 'Tingkat Penyelesaian Proyek', 'Persentase penyelesaian proyek', '2017', '1');
INSERT INTO `kpi` VALUES ('9', '9', 'Jumlah Waktu Penyelesaian Berita Acara Proyek', 'Jumlah waktu dalam penyelesaian berita acara proyek', '2017', '1');
INSERT INTO `kpi` VALUES ('10', '10', 'Jumlah Waktu Penyelesaian Penagihan', 'Jumlah waktu dalam penyelesaian penagihan', '2017', '1');
INSERT INTO `kpi` VALUES ('11', '11', 'Tingkat Penyelesaian Sales (Peluang sd Kontrak)', 'Persentase penyelesaian sales', '2017', '1');
INSERT INTO `kpi` VALUES ('12', '12', 'Tingkat Penyelesaian Dokumen Pendukung', 'Persentase penyelesaian dokumen', '2017', '1');
INSERT INTO `kpi` VALUES ('13', '13', 'Pengadaan Barang & Jasa', 'Persentase aktivitas pengadaan', '2017', '1');
INSERT INTO `kpi` VALUES ('14', '14', 'Tingkat Implementasi Sistem Manajemen Perusahaan', 'Persentase penyelesaian aktivitas implementasi sistem manajemen', '2017', '1');
INSERT INTO `kpi` VALUES ('15', '15', 'Tingkat Penyelesaian OFI KPKU', 'Score penyelesaian KPKU', '2017', '1');
INSERT INTO `kpi` VALUES ('16', '16', 'Tingkat penyelenggaraan event inovasi', 'Persentase penyelenggaraan event inovasi', '2017', '1');
INSERT INTO `kpi` VALUES ('17', '17', 'Tingkat Penyelesaian Optimalisasi Aktivitas Unit', 'Persentase penyelesaian aktivitas setiap unit', '2017', '1');
INSERT INTO `kpi` VALUES ('18', '18', 'Tingkat Ketersediaan Kas', 'Persentase Ketersediaan Kas', '2017', '1');
INSERT INTO `kpi` VALUES ('19', '19', 'Tingkat Penyelesaian Laporan Keuangan', 'Persentase penyelesaian laporan keuangan', '2017', '1');
INSERT INTO `kpi` VALUES ('20', '20', 'Tingkat penyelesaian audit', 'Persentase penyelesaian audit', '2017', '1');
INSERT INTO `kpi` VALUES ('21', '21', 'Implementasi SIM KIT', 'Persentase implementasi SIM', '2017', '1');
INSERT INTO `kpi` VALUES ('22', '22', 'Produktivitas TK', 'Pendapatan / jumlah tenaga kerja', '2017', '1');
INSERT INTO `kpi` VALUES ('23', '23', 'Jam Pembelajaran', 'jam pembelajaran / jumlah tenaga kerja', '2017', '1');
INSERT INTO `kpi` VALUES ('24', '1', 'Tingkat Margin Proyek', 'Laba Bersih / total Pendapatan', '2018', '1');
INSERT INTO `kpi` VALUES ('25', '2', 'Perolehan Pendapatan', 'Jumlah Pendapatan yang diperoleh', '2018', '1');
INSERT INTO `kpi` VALUES ('26', '3', 'Perolehan Kontrak', 'Nilai kontrak yg diperoleh', '2018', '1');
INSERT INTO `kpi` VALUES ('27', '4', 'Customer Repeat Order', 'Jumlah Customer yg melakukan order ulang ', '2018', '1');
INSERT INTO `kpi` VALUES ('28', '5', 'Pelanggan Baru', 'Jumlah Pelanggan yang baru pertamakali melakukan kontrak', '2018', '1');
INSERT INTO `kpi` VALUES ('29', '6', 'Tingkat Kepuasan Pelanggan', 'Prosentase kenaikan kepuasan pelanggan', '2018', '1');
INSERT INTO `kpi` VALUES ('30', '7', 'Tingkat Penyelesaian Proyek', 'Persentase penyelesaian Proyek', '2018', '1');
INSERT INTO `kpi` VALUES ('31', '8', 'Tingkat Penyelesaian Sales', 'Persentase penyelesaian Sales', '2018', '1');
INSERT INTO `kpi` VALUES ('32', '9', 'Optimalisasi Aktivitas Proses', 'Penyelesaian aktivitas Proses', '2018', '1');
INSERT INTO `kpi` VALUES ('33', '10', 'Optimalisasi Aktivitas Hasil', 'Penyelesaian aktivitas Hasil', '2018', '1');
INSERT INTO `kpi` VALUES ('34', '11', 'Implementasi SM KIT', 'Persentase implementasi SM', '2018', '1');
INSERT INTO `kpi` VALUES ('35', '12', 'Produktivitas Tenaga Kerja', 'Pendapatan / jumlah tenaga kerja', '2018', '1');
INSERT INTO `kpi` VALUES ('36', '13', 'Jam Pembelajaran', 'jam pembelajaran / jumlah tenaga kerja', '2018', '1');
INSERT INTO `kpi` VALUES ('37', '14', 'Efektivitas Penyaluran PKBL', 'Efektivitas Penyaluran PKBL', '2018', '1');
INSERT INTO `kpi` VALUES ('38', '15', 'Penyelesaian Program Kerja Utama Lainnya', 'Penyelesaian Program Kerja Utama Lainnya', '2018', '1');
INSERT INTO `kpi` VALUES ('39', '16', 'Penyelesaian Kegiatan Operasional', 'Penyelesaian Kegiatan Operasional', '2018', '1');
INSERT INTO `kpi` VALUES ('40', '17', 'Index GCG', 'Index GCG', '2018', '1');
INSERT INTO `kpi` VALUES ('41', '18', 'Peningkatan Kompetensi Pegawai', 'Peningkatan Kompetensi Pegawai', '2018', '1');
INSERT INTO `kpi` VALUES ('42', '19', 'Implementasi SIM KIT (HC,Keu)', 'Implementasi SIM KIT (HC,Keu)', '2018', '1');
INSERT INTO `kpi` VALUES ('43', '20', 'Rasio Kas (Cash Ratio)', 'Rasio Kas (Cash Ratio)', '2018', '1');
INSERT INTO `kpi` VALUES ('44', '21', 'Waktu Penyelesaian Audit Publik', 'Waktu Penyelesaian Audit Publik', '2018', '1');
INSERT INTO `kpi` VALUES ('45', '22', 'Enable On-Time Product Delivery', 'Enable On-Time Product Delivery', '2018', '1');
INSERT INTO `kpi` VALUES ('46', '23', 'Tingkat Service Level', 'Tingkat Service Level', '2018', '1');
INSERT INTO `kpi` VALUES ('47', '24', 'Net Profit Margin', 'Net Profit Margin', '2018', '1');
INSERT INTO `kpi` VALUES ('48', '25', 'Laba Kotor Proyek', 'Laba Kotor Proyek', '2018', '1');
INSERT INTO `kpi` VALUES ('49', '26', 'Pertumbuhan Pendapatan Usaha', '(Pendapatan Usaha Tahun Berjalan / Pendapatan Usaha Tahun Sebelumnya) x 100%', '2018', '1');
INSERT INTO `kpi` VALUES ('50', '27', 'Pertumbuhan Aset', '(Total Aset Tahun Berjalan / Total Aset Sebelumnya) x 100%', '2018', '1');
INSERT INTO `kpi` VALUES ('51', '28', 'EBITDA Margin', '(Laba sblm Bunga, Pajak, Depresiasi & Amortisasi / Total Pendapatan Usaha) x 100%', '2018', '1');
INSERT INTO `kpi` VALUES ('52', '29', 'Operating Cash Flow to Sales', '(Operating cash flow / Sales ) x 100%', '2018', '1');
INSERT INTO `kpi` VALUES ('53', '30', 'Cash Flow to Debt Ratio', '(Cash flow akhir tahun / Total Debt) x 100%', '2018', '0');
INSERT INTO `kpi` VALUES ('54', '31', 'Return on Equity (ROE)', '( Laba setelah pajak / Modal Sendiri ) x 100%', '2018', '0');
INSERT INTO `kpi` VALUES ('55', '32', 'Return on Assets (ROA)', '(Laba setelah pajak / Capital Employed)x 100%', '2018', '0');
INSERT INTO `kpi` VALUES ('56', '33', 'Rasio Lancar (Current Ratio)', '(Current Assets / Current Liabilities)   x 100%', '2018', '0');
INSERT INTO `kpi` VALUES ('57', '34', 'Collection Periods', '(Total Piutang Usaha / Total Pendapatan Usaha) x 365 hari', '2018', '0');
INSERT INTO `kpi` VALUES ('58', '35', 'BOPO', 'biaya operasi / pendapatan', '2018', '0');
INSERT INTO `kpi` VALUES ('59', '36', 'Pendapatan Pihak Ketiga', 'Jumlah pendapatan diluar KS Grup', '2018', '0');
INSERT INTO `kpi` VALUES ('60', '37', 'Customer Loyalty', '(Jumlah pelanggan yang sama dengan thn sblmnya  / Jumlah pelanggan thn sblmnya)  x 100 %', '2018', '0');
INSERT INTO `kpi` VALUES ('61', '38', 'Investasi (Capex)', '(Realisasi Program Investasi tahun berjalan / Rencana Program Investasi tahun berjalan) x 100%', '2018', '0');
INSERT INTO `kpi` VALUES ('62', '39', 'Increasing Order Book', 'Pertumbuhan jumlah kontrak yang berhasil didapatkan Perseroan dibandingkan periode sebelumnya', '2018', '0');
INSERT INTO `kpi` VALUES ('63', '40', 'Produktivitas Usaha', '(Laba Kotor / Biaya Usaha (tidak termasuk beban bunga) )  x 100 %', '2018', '0');
INSERT INTO `kpi` VALUES ('64', '1', 'Kontrak', 'Nilai kontrak yg diperoleh', '2019', '1');
INSERT INTO `kpi` VALUES ('65', '2', 'Pendapatan', 'Jumlah Pendapatan yang diperoleh', '2019', '1');
INSERT INTO `kpi` VALUES ('66', '3', 'Pertumbuhan Pendapatan', '(Pendapatan Usaha Tahun Berjalan/Pendapatan Usaha Tahun Sebelumnya) x 100%', '2019', '1');
INSERT INTO `kpi` VALUES ('67', '4', 'Pertumbuhan Aset', '(Total Aset Tahun Berjalan / Total Aset Sebelumnya) x 100%', '2019', '1');
INSERT INTO `kpi` VALUES ('68', '5', 'EBITDA Margin', '(Laba sblm Bunga, Pajak, Depresiasi & Amortisasi / Total Pendapatan Usaha) x 100%', '2019', '1');
INSERT INTO `kpi` VALUES ('69', '6', 'Net Profit Margin', '(Laba setelah pajak / Total Penjualan ) x 100%', '2019', '1');
INSERT INTO `kpi` VALUES ('70', '7', 'Operating Cash Flow to Sales', '(Operating cash flow / Sales ) x 100%', '2019', '1');
INSERT INTO `kpi` VALUES ('71', '8', 'Cash Flow to Debt Ratio', '(Cash flow akhir tahun / Total Debt) x 100%', '2019', '1');
INSERT INTO `kpi` VALUES ('72', '9', 'Return on Equity (ROE)', '( Laba setelah pajak / Modal Sendiri ) x 100%', '2019', '1');
INSERT INTO `kpi` VALUES ('73', '10', 'Return on Assets (ROA)', '(Laba setelah pajak / Capital Employed)x 100%', '2019', '1');
INSERT INTO `kpi` VALUES ('74', '11', 'Rasio Kas (Cash Ratio)', '((Kas + Setara Kas) / Current Liabilities ))x 100%', '2019', '1');
INSERT INTO `kpi` VALUES ('75', '12', 'Rasio Lancar (Current Ratio)', '(Current Assets / Current Liabilities)   x 100%', '2019', '1');
INSERT INTO `kpi` VALUES ('76', '13', 'Collection Periods', '(Total Piutang Usaha / Total Pendapatan Usaha) x 365 hari', '2019', '1');
INSERT INTO `kpi` VALUES ('77', '14', 'BOPO', 'biaya operasi / pendapatan', '2019', '1');
INSERT INTO `kpi` VALUES ('78', '15', 'Waktu Penyelesaian Audit Publik', 'Persentase penyelesaian Audit', '2019', '1');
INSERT INTO `kpi` VALUES ('79', '16', 'Customer Loyalty', '(Jumlah pelanggan yang sama dengan thn sblmnya  / Jumlah pelanggan thn sblmnya)  x 100 %', '2019', '1');
INSERT INTO `kpi` VALUES ('80', '17', 'Tingkat Service Level', 'Persentase Service Level (SLA)', '2019', '1');
INSERT INTO `kpi` VALUES ('81', '18', 'Pelanggan Baru', 'Jumlah pelanggan yg baru pertamakali melakukan kontrak', '2019', '1');
INSERT INTO `kpi` VALUES ('82', '19', 'Customer Repeat Order', 'Jumlah pelanggan yg melakukan order ulang', '2019', '1');
INSERT INTO `kpi` VALUES ('83', '20', 'Investasi (Capex)', '(Realisasi Program Investasi tahun berjalan / Rencana Program Investasi tahun berjalan) x 100%', '2019', '1');
INSERT INTO `kpi` VALUES ('84', '21', 'Tingkat Penyelesaian Proyek', 'Persentase penyelesaian proyek', '2019', '1');
INSERT INTO `kpi` VALUES ('85', '22', 'Implementasi ERP Internal', 'Persentase implementasi', '2019', '1');
INSERT INTO `kpi` VALUES ('86', '23', 'Produktivitas Usaha', '(Laba Kotor / Biaya Usaha (tidak termasuk beban bunga) )  x 100 %', '2019', '1');
INSERT INTO `kpi` VALUES ('87', '24', 'Peningkatan Kompetensi Pegawai', '(Realisasi jumlah pegawai yg memperoleh sertifikasi / Rencana jumlah pegawai yg memperoleh  sertifikasi)x100 %', '2019', '1');
INSERT INTO `kpi` VALUES ('88', '25', 'Produktivitas Tenaga Kerja', 'Pendapatan / jumlah tenaga kerja total', '2019', '1');
INSERT INTO `kpi` VALUES ('89', '26', 'Jam Pembelajaran', 'jam pembelajaran / jumlah tenaga kerja', '2019', '1');
INSERT INTO `kpi` VALUES ('90', '27', 'Efektivitas Penyaluran PKBL', '(Jumlah dana yang disalurkan / Jumlah dana yang tersedia )x 100%', '2019', '1');
INSERT INTO `kpi` VALUES ('91', '28', 'Audit Sistem Manajemen (SM) Mutu KIT', 'Persentase penyelesaian', '2019', '1');
INSERT INTO `kpi` VALUES ('92', '29', 'Index GCG', 'Hasil Penilaian Implemntasi GCG > Hasil Penilaian tahun sebelumnya', '2019', '1');
INSERT INTO `kpi` VALUES ('93', '30', 'Penyelesaian Program Kerja Utama Lainnya', 'Penyelesaian Program Kerja Utama Lainnya', '2019', '0');
INSERT INTO `kpi` VALUES ('94', '31', 'Penyelesaian Kegiatan Operasional', 'Penyelesaian Kegiatan Operasional', '2019', '0');
INSERT INTO `kpi` VALUES ('95', '32', 'Enable On-Time Product Delivery', 'Enable On-Time Product Delivery', '2019', '0');
INSERT INTO `kpi` VALUES ('96', '33', 'Laba Kotor Proyek', 'Laba Kotor Proyek', '2019', '0');
INSERT INTO `kpi` VALUES ('97', '34', 'Implementasi Sistem Manajemen (SM) KIT', 'Implementasi Sistem Manajemen (SM) KIT', '2019', '0');
INSERT INTO `kpi` VALUES ('98', '35', 'Pelaksanaan GCG', 'Pelaksanaan GCG', '2019', '0');
