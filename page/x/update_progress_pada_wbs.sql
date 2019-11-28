UPDATE wbs SET `prog-l`=(SELECT progress FROM pencapaian 
WHERE  pencapaian.jo_gca = wbs.id 
AND id_pencapaian=(select max(id_pencapaian) from pencapaian where jo_gca=wbs.id AND `status`='1'))
WHERE wbs.`level` > 4 AND wbs.tahun='2017'

UPDATE wbs SET `prog-b`=(SELECT progress FROM pencapaian 
WHERE  pencapaian.jo_gca = wbs.id 
AND id_pencapaian=(
								select max(id_pencapaian) 
								from pencapaian 
								where jo_gca=wbs.id 
								AND `status`='1' 
								AND DATE_FORMAT(tgl_aktifitas,'%m')=(SELECT MONTH(NOW())) AND DATE_FORMAT(tgl_aktifitas,'%Y')=(SELECT YEAR(NOW()))
								)
)
WHERE wbs.`level` > 4 AND wbs.tahun='2017'