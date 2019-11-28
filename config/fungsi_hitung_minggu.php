<?php
		function jmlMinggu($tgl_awal, $tgl_akhir){
			$detik = 24 * 3600;
			$tgl_awal = strtotime($tgl_awal);
			$tgl_akhir = strtotime($tgl_akhir);

			$minggu = 0;
			for ($i=$tgl_awal; $i < $tgl_akhir; $i += $detik){
				if (date("w", $i) == "0"){
					$minggu++;
				}
			}
			return $minggu;
		}
?>