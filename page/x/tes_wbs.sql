INSERT INTO `kit_simpro8`.`wbs` (`id`, `parentId`, `id_srko`, `aktivitas`, `mulai`, `akhir`, `cc`, `pic`, `deliverable`, `bobot`, `kode_kpi`, `jam`, `durasi`, `tgl_isi`, `gca_by`, `tahun`, `hasil_akhir`, `lock`, `cc_id`, `realisasi`, `level`, `jenisGCA`, `jenisAktf`, `icon`, `prog-w`, `prog-b`, `prog-l`) VALUES ('2', '0', '', 'GCA 2017', NULL, NULL, '', '', NULL, '0', '0', '0', '382154', '0000-00-00 00:00:00', '', '2017', '', '1', '', '115816', '1', '1', '0', 'assets/img/folder.png', NULL, NULL, NULL);

TRUNCATE wbs;
TRUNCATE waktu_kerja2;

INSERT INTO `wbs` (`id`, `parentId`, `id_srko`, `aktivitas`, `mulai`, `akhir`, `cc`, `pic`, `deliverable`, `bobot`, `kode_kpi`, `jam`, `durasi`, `tgl_isi`, `gca_by`, `tahun`, `hasil_akhir`, `lock`, `cc_id`, `realisasi`, `level`, `jenisGCA`, `jenisAktf`, `icon`, `prog-w`, `prog-b`, `prog-l`) 
VALUES ('3', '0', '', 'GCA 2018', NULL, NULL, '', '', NULL, '0', '0', '0', '', NOW(), '', '2018', '', '1', '', '', '1', '1', '0', 'assets/img/folder.png', NULL, NULL, NULL);
