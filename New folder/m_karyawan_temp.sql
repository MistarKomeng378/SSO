/*
Navicat MySQL Data Transfer

Source Server         : kinerja
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_kinerja

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-04-15 11:44:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for m_karyawan_temp
-- ----------------------------
DROP TABLE IF EXISTS `m_karyawan_temp`;
CREATE TABLE `m_karyawan_temp` (
  `regno` varchar(10) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `poscode` varchar(50) DEFAULT NULL,
  `dept` varchar(25) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`regno`),
  KEY `index_karyawan` (`regno`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of m_karyawan_temp
-- ----------------------------
INSERT INTO `m_karyawan_temp` VALUES ('00018', 'Siti Mulyanah Sugiharti', 'D.3.8.29.39.09', 'M4300', 'yana@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00036', 'Suhartati', 'D.2.1.08.14.08', 'KH', 'tati@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00041', 'Diane Rusiaty', 'D.2.2.13.20.31', 'KB', 'diane@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00047', 'Zuraidah, Dra', 'D.3.6.24.31.09', 'M4100', 'zuraidah@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00051', 'Kgs M Adim', 'D.3.6.24.31.07', 'M4100', 'adim@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00054', 'Rudi Setiawan, Ir', 'D.2.5.00.02.21', 'KJ', 'rudi.setiawan@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00061', 'Subandi', 'D.2.0.07.02.04', 'KE', 'bandi@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00065', 'Dwi Anugrahanto', 'D.3.7.26.36.10', 'M4200', 'dwi.anug@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00066', 'Madlias', 'D.2.4.17.11.63', 'KL', 'madlias@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00069', 'Kumhari', 'D.2.3.15.23.08', 'KD', 'kumhari@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00071', 'Hifni Syarifuddin', 'D.2.3.14.11.49', 'KD', 'hifni@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00075', 'Sukardi', 'D.2.3.16.20.47', 'KD', 'sukardi@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00076', 'Yani Waspoadi, Ir', 'D.2.3.00.02.13', 'KD', 'Yani.Waspoadi@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00079', 'Trisnawan Arifantoro. Drs', 'D.3.6.00.02.27', 'M4100', 'trisnawan@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00081', 'Sinar Wigati', 'D.3.0.23.01.11', 'M1300', 'sinar.wigati@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00088', 'Imam Prasodjo', 'D.2.1.09.15.02', 'KH', 'imam@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00090', 'Dian Haerani Mustofa', 'D.2.0.07.03.19', 'KE', 'dian@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00091', 'Sudarmono, Ir.', 'D.2.1.00.02.05', 'KH', 'sudarmono.moedjari@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00099', 'Edi Suwardi', 'D.2.2.12.02.11', 'KB', 'Edi.Soewardi@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00100', 'Budi Badru Zaman', 'D.2.1.09.16.06', 'KH', 'budi@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00106', 'Rini Sopijati', 'D.3.7.27.37.17', 'M4200', 'rini@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00108', 'Tini Rostini', 'D.3.6.24.32.07', 'M4100', 'tini@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00110', 'Rika Trisarsanti', 'D.3.6.24.34.07', 'M4100', 'rika@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00114', 'Elin Kurniasih', 'D.3.8.30.07.03', 'M4300', 'elin@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00116', 'Ine Mulyani, Dra', 'D.3.0.23.01.09', 'M1300', 'ine.mulyani@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00117', 'Iwan Herawan, Ir', 'D.3.8.00.02.29', 'M4300', 'iwanh@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00119', 'Roni Hari Kartiko', 'D.2.1.09.17.08', 'KH', 'roni@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00120', 'Rima Sulpana Popi', 'D.2.1.08.11.17', 'KH', 'rima@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00121', 'Agus Caturi Santoso', 'D.2.0.07.03.19', 'KE', 'caturi@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00125', 'Rochmadi', 'D.2.1.09.17.08', 'KH', 'rochmadi@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00126', 'Khatimatun Hasanah, Ir', 'D.2.1.08.14.07', 'KH', 'nuning@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00129', 'Sugiarni', 'D.3.7.26.36.26', 'M4200', 'arni@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00137', 'Asep Kunkun K.', 'D.2.1.09.17.08', 'KH', 'koen@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00138', 'Barkah Sarwono', 'D.2.1.09.17.08', 'KH', 'barkah@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00148', 'Fatoni', 'D.2.3.15.26.06', 'KD', 'fatoni@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00150', 'Koko Christianto', 'D.3.7.27.37.08', 'M4200', 'koko@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00151', 'Yulianto Wisnu Sadewo', 'D.3.7.00.02.27', 'M4200', 'wisnu.sadewo@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00152', 'Nandang Supriatna', 'D.2.3.14.11.48', 'KD', 'nandang@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00156', 'Alvian', 'D.2.4.18.30.07', 'KL', 'alvi@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00157', 'Ronald I Sumeler, Ir', 'D.3.8.28.38.01', 'M4300', 'ronald@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00160', 'Andik Budi Suciono, Ir', 'D.2.1.08.11.16', 'KH', 'andikbs@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00161', 'Roni Ramdhani', 'D.2.1.09.18.05', 'KH', 'ramdhani@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00162', 'Tri Tego Pramono', 'D.2.1.09.17.07', 'KH', 'tritego@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00163', 'Bakoh Winarno', 'D.3.6.25.35.04', 'M4100', 'bakoh.winarno@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00164', 'Tetty Cahyawati', 'D.3.6.24.33.07', 'M4100', 'tetty@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00165', 'Anita Megayanti', 'D.2.1.09.17.06', 'KH', 'anita@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00166', 'Bismannur Bahdar', 'D.2.2.00.02.10', 'KB', 'bismannur.bahdar@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00167', 'Mochtar Aji Nugroho', 'D.2.5.21.30.06', 'KJ', 'mochtar.aji@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00168', 'Asep Mabrur Aid, ST', 'D.2.1.09.18.06', 'KH', 'asep.mabrur@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00169', 'Ali Marjan', 'D.2.3.15.24.07', 'KD', 'Ali.Marjan@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00172', 'Erwan Susanto', 'D.2.2.12.16.17', 'KB', 'Erwan.Susanto@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00174', 'Nuah Herijonta Tarigan', 'D.2.2.12.16.16', 'KB', 'nuah.tarigan@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00176', 'Christyan Arga Putra', 'D.2.1.09.18.06', 'KH', 'Christian.Putra@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00177', 'Fatahillah Firdaus', 'D.2.5.21.18.52', 'KJ', 'fatah@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00180', 'Farah Rohima Rohmah', 'D.2.3.16.20.47', 'KD', 'farah.rr@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00182', 'Djoko Supriyadi Santo', 'D.2.5.21.18.51', 'KJ', 'djoko.supryadi@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00184', 'Feriano Pujiastanto', 'D.2.5.21.18.51', 'KJ', 'feriano@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00185', 'Agus Sudono', 'D.2.3.15.23.08', 'KD', 'agus.sudono@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('00186', 'Ari Prabowo', 'D.2.5.21.30.07', 'KJ', 'ari.prabowo@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10001', 'Leilla Risha Novianna', 'D.2.2.12.16.14', 'KB', 'leilla.rishanoviana@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10003', 'Mohamad Rizki Anugrah', 'D.2.2.12.16.14', 'KB', 'mrizky.anugrah@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10006', 'Rudi Hendri', 'D.2.3.15.25.03', 'KD', 'Rudi.hendri@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10007', 'Syamsul Maarif', 'D.2.3.15.27.18', 'KD', 'Syamsul@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10008', 'Lucky Santana Yusuf', 'D.2.3.15.23.06', 'KD', 'lucky.Santana@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10009', 'Wahyudin Nor Achmad', 'D.2.5.21.18.50', 'KJ', 'wahyudin.achmad@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10010', 'Heruno Utomo', 'D.2.5.21.18.50', 'KJ', 'heruno.utomo@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10011', 'Noory Eka Muliantri', 'D.2.2.12.16.15', 'KB', 'Noory.muliantri@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10012', 'Fahru Ramdan', 'D.2.5.21.18.50', 'KJ', 'fahru.ramdan@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10013', 'Robi Fahmi', 'D.2.5.21.18.48', 'KJ', 'robi.fahmi@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10014', 'Claudia Febrina', 'D.2.2.12.18.19', 'KB', 'claudia.febrina@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10015', 'Marlita Dewi', 'D.2.2.12.18.19', 'KB', 'marlita.dewi@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10016', 'Yevilina Aulia Rizka', 'D.2.2.12.18.19', 'KB', 'yevilina.auliarizka@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10017', 'Koen Dian Pancawati', 'D.2.2.12.18.19', 'KB', 'Koen.Pancawati@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10018', 'Fadia Hadyani Putri', 'D.2.2.12.18.19', 'KB', 'Fadia.putri@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10019', 'Hafiz Yunaz Aljazirah', 'D.2.2.12.18.19', 'KB', 'Hafiz.aljazirah@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10020', 'Annisa Putri Mashur', 'D.2.2.12.18.19', 'KB', 'annissa.mashur@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10021', 'Fachrie Mohammad', 'D.2.2.12.18.19', 'KB', 'fahrie.mohammad@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10022', 'Galih Nugroho', 'D.2.2.12.18.19', 'KB', 'galih.nugraha@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10023', 'Harry Mulya', 'D.2.2.12.18.19', 'KB', 'harry.mulya@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10024', 'Alfin Bonafia', 'D.2.2.12.18.19', 'KB', 'alfin.bonafia@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10025', 'Rinny Lestari', 'D.2.2.12.18.19', 'KB', 'rinny.lestari@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10026', 'Septian Tri Putra', 'D.2.2.12.18.19', 'KB', 'septian.tp@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10027', 'Munaji', 'D.2.2.12.18.18', 'KB', 'munaji@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10028', 'Erwin Kusdiyanta', 'D.2.2.12.18.18', 'KB', 'erwin.kusdiyanta@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('10029', 'Yoiko Maison', 'D.2.2.12.18.19', 'KB', 'yoiko.maison@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('70005', 'Rendrayanto', 'D.3.8.30.02.03', 'M4300', 'rendrayanto@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('80024', 'Mulyadi', 'D.2.3.15.25.04', 'KD', '', '0');
INSERT INTO `m_karyawan_temp` VALUES ('80025', 'Rahmatullah', 'D.2.3.14.11.43', 'KD', '', '0');
INSERT INTO `m_karyawan_temp` VALUES ('80026', 'Agus Taufik', 'D.2.3.15.25.05', 'KD', '', '0');
INSERT INTO `m_karyawan_temp` VALUES ('80027', 'Afu Fuad', 'D.2.3.14.11.43', 'KD', '', '0');
INSERT INTO `m_karyawan_temp` VALUES ('80045', 'Achmad Rudi', 'D.2.3.15.26.02', 'KD', 'ahmad.rudi@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('80061', 'Mutawali', 'D.2.3.15.27.17', 'KD', '', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90176', 'Muhtadi', 'D.2.1.09.18.04', 'KH', 'muchtadi@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90177', 'Ade Wahyudi', 'D.2.1.09.18.05', 'KH', 'ade.wahyudi@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90209', 'Habib Rachman', 'D.2.1.09.18.05', 'KH', 'Habib.Rahman@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90220', 'Mohamad Taufik Husaeni', 'D.2.1.09.18.04', 'KH', 'm.taufik@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90223', 'Harris Permana', 'D.2.3.15.23.02', 'KD', 'haris.permana@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90251', 'Imas Komalasari', 'OOSS12', 'KH', 'imas.komalasari2015@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90268', 'Desi Sulistiani', 'D.3.8.28.38.17', 'M4300', 'Desi.Sulistiani@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90269', 'Yulie Hadyana', 'OOSS12', 'KH', 'yulie.hadyana90269@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90282', 'Destiono', 'D.2.2.12.17.16', 'KB', 'destiono@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90284', 'Lucky Muslim Nurhakim', 'D.2.2.12.17.16', 'KB', 'Lucky.Muslim@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90301', 'Yulianto', 'D.2.3.15.26.01', 'KD', 'Yulianto@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90305', 'Fajar Setyawan', 'D.2.3.15.26.01', 'KD', 'fajar.setyawan@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90318', 'Ato Ulloh', 'D.2.3.15.25.03', 'KD', 'ato.ulloh@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90328', 'Ganes Aryuda', 'D.2.3.15.26.02', 'KD', 'ganes.aryudha@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90330', 'Tri Joko Wibowo', 'D.3.8.28.38.19', 'M4300', 'trijoko.wibowo@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90340', 'Feri Indriyana', 'D.2.2.12.17.16', 'KB', 'fery.indriyana@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90343', 'Nurully Januar', 'D.2.2.12.17.16', 'KB', 'rully.januar@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90352', 'Atikah Firdausi', 'D.2.2.12.17.18', 'KB', 'atikah.firdausi@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90361', 'Mukhamad Benny', 'D.2.1.09.18.05', 'KH', 'mukhamad.benny@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90379', 'Muhammad Ronny Chandra', 'D.2.1.09.18.04', 'KH', 'ronny.chandra@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90381', 'Beri Perima', 'D.2.1.09.18.04', 'KH', 'beri.perima@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90382', 'Mohamad Febriansyah', 'D.2.3.15.27.18', 'KD', 'mohamad.febriansyah@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90397', 'Ridho Mulyandar', 'D.2.2.12.17.16', 'KB', 'rmulyandar@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90398', 'Ita Nurjanah', 'D.2.3.15.27.17', 'KD', 'ita.nurjanah@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90400', 'Ahmad Alwani', 'D.2.2.13.20.19', 'KB', 'ahmadalwani107@yahoo.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90401', 'Mega Elvianty', 'D.1.0.03.05.07', 'M1000', 'mega.elvianty@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90410', 'Shoheh Azis Fatulloh', 'D.2.3.15.27.19', 'KD', 'shoheh.azis@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90411', 'Zaenul Muttaqin', 'D.2.3.15.24.03', 'KD', ' Zainul.Muttaqin@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90414', 'Hanafi', 'D.2.3.15.25.03', 'KD', 'hanafi@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90415', 'Ikhsanilah', 'D.2.3.15.23.03', 'KD', 'ikhsanillah@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90416', 'Dani Agustian', 'D.2.3.15.23.03', 'KD', 'dani.agustian@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90422', 'Rika Ayu Agustini', 'D.2.3.16.20.39', 'KD', 'rika.Agustina@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90423', 'Chandra Setyo Nugroho', 'D.2.1.09.18.05', 'KH', 'chandra@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90424', 'Sendra Rizki Eka Suherman', 'D.2.3.15.27.17', 'KD', 'sendra.suherman@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90426', 'Iskandar Muda', 'D.2.5.21.18.49', 'KJ', 'iskandar.muda@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90428', 'Gugum Gumilar', 'D.2.1.09.18.04', 'KH', 'gugum.gumilar@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90429', 'Jarkasih', 'D.2.3.15.26.01', 'KD', 'jarkasih@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90430', 'Achmad Arif Rudiyani', 'D.2.3.15.26.01', 'KD', 'arief.rudiyani@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90431', 'Yunanto Andhika Didamba', 'D.2.5.21.23.31', 'KJ', 'yunanto.andhika@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90432', 'Rendy Sutisna', 'D.2.5.21.23.31', 'KJ', 'rendy.sutisna@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90433', 'Tiara Septinia', 'D.2.5.21.18.49', 'KJ', 'tiara.septinia@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90434', 'Yang Arestya Putri', 'D.2.2.13.20.20', 'KB', 'yayang@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90436', 'Ahmad Isa Ansori', 'D.3.7.27.37.11', 'M4200', 'ahmadi.ansori@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90437', 'Novi Hotimah', 'D.3.6.25.35.03', 'M4100', 'novi.khotimah@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90438', 'Bonny Rizaldi', 'D.2.3.15.26.01', 'KD', 'bonny.rizaldi@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90440', 'Firidli Hajar Mahardicha', 'D.2.5.21.23.31', 'KJ', 'f.hajar.mahardicha@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90441', 'Aji Muda Casaka', 'D.2.1.09.17.05', 'KH', 'a.muda.casaka@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90443', 'Fajar Isnandio Cindyka', 'D.2.1.09.18.05', 'KH', 'fajar.isnandio@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90463', 'Pandji Prasetya', 'D.2.3.15.26.01', 'KD', 'Pandji@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90466', 'Widhi Dwi Anggoro', 'D.2.3.15.26.03', 'KD', 'widhi.danggoro@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90467', 'Maulana Kelvin Fahlevy', 'D.2.3.15.27.17', 'KD', 'maulana.kelvin@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90476', 'Ratu Meilinda Purnama Sari', 'D.2.3.16.20.38', 'KD', 'r.m.purnama.sari@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90477', 'Agung Syahputra', 'D.2.3.15.23.03', 'KD', 'Agung.Syahputra@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90478', 'Sirinta Putri Kamila', 'D.2.2.12.17.17', 'KB', 'sirintap.kamilia@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90479', 'Iskandar Zulkarnaen', 'D.2.5.21.23.30', 'KJ', 'iskandar.zulkarnaen@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90481', 'Satya Mintharenza', 'D.2.5.21.18.49', 'KJ', 'satya.mintharenza@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90483', 'Nanang Ibnu Qosim', 'D.2.2.12.18.18', 'KB', 'nanangi.qosim@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90485', 'Rina Oktavialianti', 'D.2.2.12.17.16', 'KB', 'rina.oktavialianti@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90486', 'Ni Made Riska Indrayati', 'D.2.3.16.20.39', 'KD', 'riska.indrayati@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90487', 'Attika Adha Kurnia', 'D.2.3.15.23.01', 'KD', 'attika.kurnia@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90489', 'Novi Mayasari', 'D.1.02.03.01', 'M1000', 'novi.mayasari@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90490', 'Al Afgani', 'D.2.2.12.18.18', 'KB', 'al.afgani@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90491', 'Rohanah', 'D.2.2.13.21.30', 'KB', 'rohanah@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90493', 'Furkon Fajri', 'D.2.2.12.18.18', 'KB', 'furqon.fajri@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90494', 'Abdul Ghoji Hanggoro', 'D.2.1.09.18.03', 'KH', 'abdul.ghoji@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90495', 'Mochamad Alda Gumelar', 'D.2.5.21.30.01', 'KJ', 'alda.gumelar@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90496', 'Mohamad Sopian', 'D.3.8.30.10.03', 'M4300', 'mohamad.sopian@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90497', 'Diki Dewa Putra', 'D.2.3.15.23.04', 'KD', 'diki.dewaputra@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90498', 'Didit Permata Aji', 'D.2.3.15.26.01', 'KD', 'didit.p.aji@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90500', 'Ahmad Muhammad Thabrani', 'D.2.3.15.23.01', 'KD', 'thabrani.abi@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90501', 'Fakhrizal', 'D.2.3.15.23.01', 'KD', 'fakhrizal@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90502', 'Briliyan Panji Handoko', 'D.2.3.15.23.01', 'KD', 'briliyanp.handoko@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90503', 'Iwan Supriyatno', 'D.2.3.15.23.01', 'KD', 'iwan.supriyatno@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90504', 'Doni Darmawan', 'D.2.3.15.23.01', 'KD', 'doni.darmawan@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90505', 'Annisa Resnianty', 'D.2.3.16.20.38', 'KD', 'annisa.resnianty@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90506', 'Sindu Riswanda', 'D.2.2.12.18.16', 'KB', 'sindu.riswanda@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90507', 'Reza Yanovan', 'D.2.3.15.23.01', 'KD', 'reza.yanovan@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90508', 'Muhammad Malik Artanto', 'D.2.3.15.27.17', 'KD', 'malik.artanto@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90509', 'Nana Supriatna', 'D.2.3.15.23.04', 'KD', 'Nana.supriatna@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90511', 'Ahmad Hamdan Hidayat', 'D.2.3.15.26.01', 'KD', 'ahmadh.hidayat@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90512', 'Zaenal Muttaqin', 'D.2.3.15.26.01', 'KD', 'zainal.muttaqin@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90514', 'Bayyu Indra Kusuma', 'D.2.2.12.17.18', 'KB', 'bayui.kusuma@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90515', 'Valdi haris', 'D.2.3.15.27.17', 'KD', 'valdi.haris@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90516', 'Andiarto Dimas', 'D.2.3.15.27.17', 'KD', 'andiarto.dimas@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90517', 'Asry Febrina', 'D.2.3.16.20.37', 'KD', 'asry.febriana@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90518', 'Entol Fakih', 'D.2.5.21.18.48', 'KJ', 'entol.fakih@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90519', 'Nabila Caesaria Putri', 'D.2.2.12.17.16', 'KB', 'nabilac.putri@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90520', 'Tri Utomo', 'D.2.3.15.27.17', 'KD', 'tri.utomo@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90531', 'Chelvina Olivia', 'D.2.2.13.20.19', 'KB', 'chelvina.olivia@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90532', 'Dwina Rizki Anindhita', 'D.2.5.22.20.75', 'KJ', 'dwina.anindhita@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90533', 'Triar Kurniasih', 'D.2.2.13.20.20', 'KB', 'triar@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90534', 'Dida Nurwanda', 'D.2.5.21.23.29', 'KJ', 'dida.nurwanda@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90535', 'Titi Sulfiyati', 'D.2.3.16.20.38', 'KD', 'titi.sulfiyati@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90536', 'Zaenal Mutakin', 'D.2.3.15.26.01', 'KD', 'zaenal.mutakin@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90537', 'Hesta Fernanda Aji Saputra', 'D.2.3.15.25.02', 'KD', 'hesta.fernanda@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('90538', 'Afriyadi Sauqi', 'D.1.0.03.04.02', 'M1000', 'Afriyadi.Sauqi@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97016', 'Saepudin', 'OOSS08', 'KH', 'Saepudinduljaya@yahoo.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97027', 'Mas\'amah', 'OOSS06', 'KH', 'massamah1637@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97034', 'Agus Haryono', 'OOSS09', 'KH', 'gushar.haryono@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97041', 'Salamullah', 'OOSS08', 'KH', 'Salamullah_alam@yahoo.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97044', 'Abdul Gani', 'OOSS08', 'KH', 'abdul_gani25@yahoo.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97046', 'Dwi Fariyatno', 'OOSS09', 'KH', 'Fariyatnodwi@yahoo.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97049', 'Sri Murdianti', 'OOSS07', 'KH', 'srimurdianti6@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97050', 'Arief Furqon Djati Wijaya', 'OOSS08', 'KH', 'Arieffurqondjatiwidjaja@ymail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97051', 'Sri Ida', 'OOSS09', 'KH', 'sriida97051@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97053', 'Muhlis', 'OOSS08', 'KH', 'muhlis.as75@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97055', 'Neneng Nurwulan', 'OOSS09', 'KH', 'nenengnurwulan17@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97058', 'Guntur Windumurti', 'OOSS07', 'KH', 'guntur.bdoel@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97059', 'Nila Farida', 'OOSS09', 'KH', 'nilahilmania@ymail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97060', 'Dewi Sulistyarini', 'OOSS06', 'KH', 'Dewi.sulistyorini@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97061', 'Soffan Haruri', 'OOSS06', 'KH', 'soffanharurikit@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97062', 'Junita', 'OOSS09', 'KH', 'yunita_chaniago@yahoo.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97064', 'Rini Oktaviani', 'OOSS07', 'KH', 'rini.warnasari@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97065', 'Safik', 'OOSS06', 'KH', 'safik080470@yahoo.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97067', 'Safrudin', 'OOSS07', 'KH', 'Safrudinbinohat@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97069', 'Zainal Abidin', 'OOSS10', 'KH', 'zainalabidin364@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97073', 'Muhlas', 'OOSS08', 'KH', 'muhlas.rico@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97075', 'Arisma Cholma CM', 'OOSS10', 'KH', 'rismaye2s@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97076', 'Novi Krisnawati', 'OOSS09', 'KH', 'mpie.mpop@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97077', 'Sri Ningsih Puji Hastuti', 'OOSS09', 'KH', 'snpaujie@ymail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97079', 'Lindasari', 'OOSS09', 'KH', 'lindasari2112@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97080', 'Diny Cheryani', 'OOSS08', 'KH', 'd.cheryani@yahoo.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97081', 'Aris Handayana', 'OOSS06', 'KH', 'arisaryana@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97082', 'Sri Ayunia Kania Dewi', 'OOSS10', 'KH', 'sriayuniakaniadewi@yahoo.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97084', 'Nasrudin', 'OOSS08', 'KH', 'nasrudinyah@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97085', 'Yulia Farida', 'OOSS09', 'KH', 'yl.farida@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97087', 'Gustiani Kurnia', 'OOSS09', 'KH', 'gustianikurnia@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97088', 'Eka Oktora', 'OOSS09', 'KH', 'divisi.gcg&rm@krakatausteel.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97089', 'Fajar Mardiana', 'OOSS09', 'KH', 'diankiano@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97091', 'Lidya Sudriyanti Adibella', 'OOSS09', 'KH', 'ray_rasy51@yahoo.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97093', 'Prima Pramestari', 'OOSS09', 'KH', 'pramestha.77@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97094', 'Wawan Gunawan', 'OOSS08', 'KH', 'wg31031984@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97096', 'Ali Yunan', 'OOSS06', 'KH', 'aliarfayunan@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97097', 'Ratu Irma Rachmawati', 'OOSS09', 'KH', 'ratoeirma@yahoo.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97098', 'Nur Choiriyah', 'OOSS06', 'KH', 'Choi_niez@Yahoo.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97099', 'Meylin Afrianita', 'OOSS11', 'KH', 'Meylinafrianita@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97100', 'Elva Falahiah Nurbanati', 'OOSS12', 'KH', 'eilvha.alfala@yahoo.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97101', 'Pepi Kristinawati', 'OOSS11', 'KH', 'pepi_kristinawati@yahoo.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97102', 'Babay Mubayinah', 'OOSS08', 'KH', 'Babay.inv@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97104', 'Ratih Febriani Putri', 'OOSS09', 'KH', 'ratih.alea14@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97105', 'Eka Rohmayanti', 'OOSS12', 'KH', 'eka.rohmayantie@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97107', 'Fahrudin', 'OOSS12', 'KH', 'dien.fahru@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97108', 'Ayu Rahmawati', 'OOSS06', 'KH', 'ayurahmawati1388@yahoo.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97109', 'Sari Noviana Putri', 'OOSS12', 'KH', 'Sari.novianaputri@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97111', 'Cecep Bahrul Ulum', 'OOSS06', 'KH', 'Cecepbahrul.ulum@Yahoo.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97112', 'Vita Kustianti', 'OOSS11', 'KH', 'vitadirjanuari@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97114', 'Shintia Rahma Putri Lestari', 'OOSS09', 'KH', 'shintea87@yahoo.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97115', 'Finda', 'OOSS09', 'KH', 'findaariyadi@yahoo.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97116', 'Anisa Suciarti', 'OOSS09', 'KH', 'suciartianisa@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97120', 'Diah Septiani', 'OOSS09', 'KH', 'diahsepty@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97122', 'Runtawati', 'OOSS09', 'KH', 'watiejr@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97123', 'Nasrullah', 'OOSS06', 'KH', 'nas087871904528@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97125', 'Lia Herlina', 'OOSS09', 'KH', 'lieaherlina@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97128', 'Leni Dini S', 'OOSS09', 'KH', 'Dini.qie@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97130', 'Rizky Nurlaela', 'OOSS12', 'KH', 'rizkymarsya@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97131', 'Maniatun Nufus', 'OOSS06', 'KH', 'Maniatunnufus18@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97132', 'Amirah Roesli', 'OOSS12', 'KH', 'amirahroesli@yahoo.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97133', 'Mariyati', 'OOSS09', 'KH', 'mariyati_lady01@yahoo.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97134', 'Beatrix Berlina', 'OOSS12', 'KH', 'beatrix.berlina9@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97136', 'Aramiko Kayanie N.A', 'OOSS09', 'KH', 'aramiko11.kayanie@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97137', 'Nuraeni Ismi', 'OOSS12', 'KH', 'izzmyshop@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97138', 'Rini Antika Dewi', 'OOSS09', 'KH', 'riniantika.dewi@yahoo.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97139', 'Tia Martiya', 'OOSS09', 'KH', 'tiamartiya@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97141', 'Ayu Wulandari', 'OOSS09', 'KH', 'ayuw841@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97142', 'Riris Rizkita Sari', 'OOSS09', 'KH', 'rhiez_mats@yahoo.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97143', 'Nurshela', 'OOSS12', 'KH', 'Ishela40@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97144', 'Eka Winda Kurnia', 'OOSS12', 'KH', 'eca.sks19@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97145', 'Nawiri', 'OOSS07', 'KH', 'nawiri.97145@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97146', 'Siti Khodijah', 'OOSS12', 'KH', 'khodijah@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97148', 'Lailatun Nazillah', 'OOSS09', 'KH', 'Lailatun91@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97150', 'Galih Satya Dharmawan', 'OOSS08', 'KH', 'galihsatya75@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97151', 'Reydhita', 'OOSS08', 'KH', 'Reydhitarusiana@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97152', 'Arif Cahya Ramadhan', 'OOSS08', 'KH', 'arifcahyaramadhan28@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97153', 'Izzatunnisa', 'OOSS09', 'KH', 'izzatunnisa045@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97156', 'Sugeng Widiantoro', 'OOSS07', 'KH', 'Sugengwidiantoro@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97158', 'Reni Rahmawati', 'OOSS12', 'KH', 'reni_ivory@yahoo.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97161', 'Esti Pitarawasti', 'OOSS12', 'KH', 'estii.tara@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97162', 'Nazelia Hijina Yakfi', 'OOSS09', 'KH', 'nazelia.yakfi2017@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97163', 'Surya Antika', 'OOSS09', 'KH', 'suryaantika21@yahoo.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97165', 'Yuliana', 'OOSS06', 'KH', 'yuliyuliana901@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97166', 'Mita Masrina', 'OOSS06', 'KH', 'masrina31mita@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97167', 'Endah Rahayu', 'OOSS06', 'KH', '  endah.rhy@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97168', 'Helen Azwar', 'OOSS09', 'KH', 'helenazwar12@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97169', 'Dina Sazidah', 'OOSS03', 'KH', 'Dinasazidah1@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('97170', 'Novita Sari', 'OOSS06', 'KH', 'Sari.novita549@gmail.com', '0');
INSERT INTO `m_karyawan_temp` VALUES ('K0047', 'Hotland Siringoringo', 'S0002', 'M1400', '', '0');
INSERT INTO `m_karyawan_temp` VALUES ('K0050', 'Amirul Mu\'tamar', 'D.1.0.00.02.01', 'M1000', 'amirul.mutamar@krakatau-it.co.id', '0');
INSERT INTO `m_karyawan_temp` VALUES ('K0051', 'Bakhrul Ulum', 'D.1.0.00.02.02', 'M1000', 'BAKHRUL.ULUM@KRAKATAU-IT.CO.ID', '0');
INSERT INTO `m_karyawan_temp` VALUES ('K0052', 'Cahyo Antarikso', 'D0002', 'M1400', '', '0');
