<?php

function grade($nilai)
	{
		if($nilai >=90 AND $nilai<=100){
			$grade= "Sangat Baik";
		}elseif($nilai >=75 AND $nilai <=89){
			$grade= "Baik";
		}elseif($nilai >=61 AND $nilai <=75){
			$grade= "Cukup";
		}elseif($nilai >=51 AND $nilai <=60){
			$grade= "Sedang";
		}elseif($nilai <=50){
			$grade= "Buruk";
		}
		return $grade;
	}
?>