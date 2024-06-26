<?php
	$awal = microtime(true); 
	include 'koneksi.php';
	mysql_query("TRUNCATE pohon_keputusan");	
	pembentukan_tree("","");
	echo "<br><h1><center>---PROSES SELESAI---</center></h1>";
	echo "<center><a href='index.php?menu=tree' accesskey='5' title='pohon keputusan'>Lihat pohon keputusan yang terbentuk</a></center>";
	
	$akhir = microtime(true);
	$lama = $akhir - $awal;
	//echo "<br>Lama eksekusi script adalah: ".$lama." detik";
		
	
	//fungsi utama
	function proses_DT($parent , $kasus_cabang1 , $kasus_cabang2){	
		echo "cabang 1<br>";
		pembentukan_tree($parent , $kasus_cabang1);		
		echo "cabang 2<br>";
		pembentukan_tree($parent , $kasus_cabang2);		
	}		
	
	function pangkas($PARENT, $KASUS, $LEAF){
		//PEMANGKASAN CABANG
		$sql_pangkas = mysql_query("SELECT * FROM pohon_keputusan WHERE parent=\"$PARENT\" AND keputusan=\"$LEAF\"");
		$row_pangkas = mysql_fetch_array($sql_pangkas);
		$jml_pangkas = mysql_num_rows($sql_pangkas);
		//jika keputusan dan parent belum ada maka insert
		if($jml_pangkas==0){			
			mysql_query("INSERT INTO pohon_keputusan (parent,akar,keputusan)VALUES (\"$PARENT\" , \"$KASUS\" , \"$LEAF\")");
		}
		//jika keputusan dan parent sudah ada maka delete
		else{			
			mysql_query("DELETE FROM pohon_keputusan WHERE id='$row_pangkas[0]'");
			
			$exPangkas = explode(" AND ",$PARENT);
			$jmlEXpangkas = count($exPangkas);
			$temp=array();
			for($a=0;$a<($jmlEXpangkas-1);$a++){
				$temp[$a]=$exPangkas[$a];
			}
			$imPangkas = implode(" AND ",$temp);
			$akarPangkas = $exPangkas[$jmlEXpangkas-1];
			
			$que_pangkas = mysql_query("SELECT * FROM pohon_keputusan WHERE parent=\"$imPangkas\" AND keputusan=\"$LEAF\"");
			$baris_pangkas = mysql_fetch_array($que_pangkas);
			$jumlah_pangkas = mysql_num_rows($que_pangkas);
			
			if($jumlah_pangkas==0){		
				mysql_query("INSERT INTO pohon_keputusan (parent,akar,keputusan)VALUES (\"$imPangkas\" , \"$akarPangkas\" , \"$LEAF\")");
				//mysql_query("UPDATE pohon_keputusan SET parent=\"$imPangkas\" , akar=\"$akarPangkas\" , keputusan=\"$LEAF\" WHERE id=\"$row_pangkas[0]\"");
			}else{
				pangkas($imPangkas,$akarPangkas,$LEAF);
			}								
		}
		echo "Keputusan = ".$LEAF."<br>================================<br>";		
	}
	
	//fungsi proses dalam suatu kasus data
	function pembentukan_tree($N_parent , $kasus){
		//mengisi kondisi
		if($N_parent!=''){
			$kondisi = $N_parent." AND ".$kasus;
		}else{
			$kondisi = $kasus;
		}		
		echo $kondisi."<br>";
		//cek data heterogen / homogen???
		$cek = cek_heterohomogen('terbaik',$kondisi);
		if($cek=='homogen'){
			echo "<br>LEAF ";
			$sql_keputusan = mysql_query("SELECT DISTINCT(terbaik) FROM data_training WHERE $kondisi");
			$row_keputusan = mysql_fetch_array($sql_keputusan);	
			$keputusan = $row_keputusan['0'];
			//insert atau lakukan pemangkasan cabang
			pangkas($N_parent , $kasus , $keputusan);
			
		}//jika data masih heterogen
		else if($cek=='heterogen'){
			//cek jumlah data
			$jumlah = jumlah_data($kondisi);
			if($jumlah<8){
				echo "<br>LEAF ";
				$Ntinggi = $kondisi." AND terbaik='Ya'";
				$Nrendah = $kondisi." AND terbaik='Tidak'";
				$jumlahTinggi = jumlah_data("$Ntinggi");
				$jumlahRendah = jumlah_data("$Nrendah");				
				if($jumlahTinggi <= $jumlahRendah){
					$keputusan = 'Tidak';
				}else{
					$keputusan = 'Ya';
				}				
				//insert atau lakukan pemangkasan cabang
				pangkas($N_parent , $kasus , $keputusan);		
			}
			//lakukan perhitungan
			else{			
				//jika kondisi tidak kosong kondisi_ipk=tambah and
				$kondisi_ipk='';
				if($kondisi!=''){
					$kondisi_ipk=$kondisi." AND ";
				}
				$jml_tinggi = jumlah_data("$kondisi_ipk terbaik='Ya'");
				$jml_rendah = jumlah_data("$kondisi_ipk terbaik='Tidak'");
				$jml_total = $jml_tinggi + $jml_rendah;
				echo "Jumlah data = ".$jml_total."<br>";
				echo "Jumlah tinggi = ".$jml_tinggi."<br>";
				echo "Jumlah rendah = ".$jml_rendah."<br>";
				
				//hitung entropy semua
				$entropy_all = hitung_entropy($jml_tinggi , $jml_rendah);
				echo "Entropy = ".$entropy_all."<br>";
								
				//cek berapa nilai setiap atribut
				$nilai_sains = array();
				$nilai_sains = cek_nilaiAtribut('sains_keterangan',$kondisi);								
				$jml_sains = count($nilai_sains);								
				$nilai_math = array();
				$nilai_math = cek_nilaiAtribut('math_keterangan',$kondisi);								
				$jml_math = count($nilai_math);
				$nilai_bindo = array();
				$nilai_bindo = cek_nilaiAtribut('bindo_keterangan',$kondisi);								
				$jml_bindo = count($nilai_bindo);
				$nilai_bing = array();
				$nilai_bing = cek_nilaiAtribut('bing_keterangan',$kondisi);								
				$jml_bing = count($nilai_bing);
				$nilai_ips = array();
				$nilai_ips = cek_nilaiAtribut('ips_keterangan',$kondisi);								
				$jml_ips = count($nilai_ips);				
				$nilai_aqidah = array();
				$nilai_aqidah = cek_nilaiAtribut('aqidah_keterangan',$kondisi);								
				$jml_aqidah = count($nilai_aqidah);				

				//hitung gain atribut
				mysql_query("TRUNCATE gain");
				//sains
				if($jml_sains!=1){
					$NA1Sains="sains_keterangan='$nilai_sains[0]'";
					$NA2Sains="";
					$NA3Sains="";
					$NA4Sains="";
					$NA5Sains="";
					if($jml_sains==2){
						$NA2Sains="sains_keterangan='$nilai_sains[1]'";
					}else if($jml_sains==3){
						$NA2Sains="sains_keterangan='$nilai_sains[1]'";
						$NA3Sains="sains_keterangan='$nilai_sains[2]'";
					}else if($jml_sains==4){
						$NA2Sains="sains_keterangan='$nilai_sains[1]'";
						$NA3Sains="sains_keterangan='$nilai_sains[2]'";
						$NA4Sains="sains_keterangan='$nilai_sains[3]'";
					}
					hitung_gain($kondisi , "sains_keterangan" , $entropy_all , $NA1Sains , $NA2Sains , $NA3Sains , $NA4Sains , $NA5Sains);
				}
				//math
				if($jml_math!=1){
					$NA1Math="math_keterangan='$nilai_math[0]'";
					$NA2Math="";
					$NA3Math="";
					$NA4Math="";
					$NA5Math="";
					if($jml_math==2){
						$NA2Math="math_keterangan='$nilai_math[1]'";
					}else if($jml_math==3){
						$NA2Math="math_keterangan='$nilai_math[1]'";
						$NA3Math="math_keterangan='$nilai_math[2]'";
					}else if($jml_math==4){
						$NA2Math="math_keterangan='$nilai_math[1]'";
						$NA3Math="math_keterangan='$nilai_math[2]'";
						$NA4Math="math_keterangan='$nilai_math[3]'";
					}
					hitung_gain($kondisi , "math_keterangan" , $entropy_all , $NA1Math , $NA2Math , $NA3Math , $NA4Math , $NA5Math);
				}
				//b indonesia
				if($jml_bindo!=1){
					$NA1Bindo="bindo_keterangan='$nilai_bindo[0]'";
					$NA2Bindo="";
					$NA3Bindo="";
					$NA4Bindo="";
					$NA5Bindo="";
					if($jml_bindo==2){
						$NA2Bindo="bindo_keterangan='$nilai_bindo[1]'";
					}else if($jml_bindo==3){
						$NA2Bindo="bindo_keterangan='$nilai_bindo[1]'";
						$NA3Bindo="bindo_keterangan='$nilai_bindo[2]'";
					}else if($jml_bindo==4){
						$NA2Bindo="bindo_keterangan='$nilai_bindo[1]'";
						$NA3Bindo="bindo_keterangan='$nilai_bindo[2]'";
						$NA4Bindo="bindo_keterangan='$nilai_bindo[3]'";
					}
					hitung_gain($kondisi , "bindo_keterangan" , $entropy_all , $NA1Bindo , $NA2Bindo , $NA3Bindo , $NA4Bindo , $NA5Bindo);
				}				
				//b inggris
				if($jml_bing!=1){
					$NA1Bing="bing_keterangan='$nilai_bing[0]'";
					$NA2Bing="";
					$NA3Bing="";
					$NA4Bing="";
					$NA5Bing="";
					if($jml_bing==2){
						$NA2Bing="bing_keterangan='$nilai_bing[1]'";
					}else if($jml_bing==3){
						$NA2Bing="bing_keterangan='$nilai_bing[1]'";
						$NA3Bing="bing_keterangan='$nilai_bing[2]'";
					}else if($jml_bing==4){
						$NA2Bing="bing_keterangan='$nilai_bing[1]'";
						$NA3Bing="bing_keterangan='$nilai_bing[2]'";
						$NA4Bing="bing_keterangan='$nilai_bing[3]'";
					}
					hitung_gain($kondisi , "bing_keterangan" , $entropy_all , $NA1Bing , $NA2Bing , $NA3Bing , $NA4Bing , $NA5Bing);
				}
				//ips
				if($jml_ips!=1){
					$NA1Ips="ips_keterangan='$nilai_ips[0]'";
					$NA2Ips="";
					$NA3Ips="";
					$NA4Ips="";
					$NA5Ips="";
					if($jml_ips==2){
						$NA2Ips="ips_keterangan='$nilai_ips[1]'";
					}else if($jml_ips==3){
						$NA2Ips="ips_keterangan='$nilai_ips[1]'";
						$NA3Ips="ips_keterangan='$nilai_ips[2]'";
					}else if($jml_ips==4){
						$NA2Ips="ips_keterangan='$nilai_ips[1]'";
						$NA3Ips="ips_keterangan='$nilai_ips[2]'";
						$NA4Ips="ips_keterangan='$nilai_ips[3]'";
					}
					hitung_gain($kondisi , "ips_keterangan" , $entropy_all , $NA1Ips , $NA2Ips , $NA3Ips , $NA4Ips , $NA5Ips);
				}																																				
				//aqidah
				if($jml_aqidah!=1){
					$NA1Aqidah="aqidah_keterangan='$nilai_aqidah[0]'";
					$NA2Aqidah="";
					$NA3Aqidah="";
					$NA4Aqidah="";
					$NA5Aqidah="";
					if($jml_aqidah==2){
						$NA2Aqidah="aqidah_keterangan='$nilai_aqidah[1]'";
					}else if($jml_aqidah==3){
						$NA2Aqidah="aqidah_keterangan='$nilai_aqidah[1]'";
						$NA3Aqidah="aqidah_keterangan='$nilai_aqidah[2]'";
					}else if($jml_aqidah==4){
						$NA2Aqidah="aqidah_keterangan='$nilai_aqidah[1]'";
						$NA3Aqidah="aqidah_keterangan='$nilai_aqidah[2]'";
						$NA4Aqidah="aqidah_keterangan='$nilai_aqidah[3]'";
					}
					hitung_gain($kondisi , "aqidah_keterangan" , $entropy_all , $NA1Aqidah , $NA2Aqidah , $NA3Aqidah , $NA4Aqidah , $NA5Aqidah);
				}																																				
			
				//ambil nilai gain tertinggi
					$sql_max = mysql_query("SELECT MAX(gain) FROM gain");
					$row_max = mysql_fetch_array($sql_max);	
					$max_gain = $row_max['0'];
					$sql = mysql_query("SELECT * FROM gain WHERE gain=$max_gain");
					$row = mysql_fetch_array($sql);	
					$atribut = $row['1'];
					echo "Atribut terpilih = ".$atribut.", dengan nilai gain = ".$max_gain."<br>";					
					echo "<br>================================<br>";
				//percabangan jika nilai atribut lebih dari 2 hitung rasio terlebih dahulu
				//SAINS TERPILIH
				if($atribut=="sains_keterangan"){
					//jika nilai atribut 5
					if($jml_sains==5){
						//hitung rasio
						$cabang = array();
						$cabang = hitung_rasio($kondisi , 'sains_keterangan',$max_gain,$nilai_bindo[0],$nilai_bindo[1],$nilai_bindo[2],$nilai_bindo[3],$nilai_bindo[4]);
						$exp_cabang = explode(" , ",$cabang[1]);						
						proses_DT($kondisi,"($atribut='$cabang[0]')","($atribut='$exp_cabang[0]' OR $atribut='$exp_cabang[1]' OR $atribut='$exp_cabang[2]' OR $atribut='$exp_cabang[3]')");						
					}					
					//jika nilai atribut 4
					else if($jml_sains==4){
						//hitung rasio
						$cabang = array();
						$cabang = hitung_rasio($kondisi , 'sains_keterangan',$max_gain,$nilai_bindo[0],$nilai_bindo[1],$nilai_bindo[2],$nilai_bindo[3],'');
						$exp_cabang = explode(" , ",$cabang[1]);
						proses_DT($kondisi,"($atribut='$cabang[0]')","($atribut='$exp_cabang[0]' OR $atribut='$exp_cabang[1]' OR $atribut='$exp_cabang[2]')");
					}					
					//jika nilai atribut 3
					else if($jml_sains==3){
						//hitung rasio
						$cabang = array();
						$cabang = hitung_rasio($kondisi , 'sains_keterangan',$max_gain,$nilai_bindo[0],$nilai_bindo[1],$nilai_bindo[2],'','');
						$exp_cabang = explode(" , ",$cabang[1]);
						proses_DT($kondisi,"($atribut='$cabang[0]')","($atribut='$exp_cabang[0]' OR $atribut='$exp_cabang[1]')");
					}
					//jika nilai atribut 2
					else if($jml_sains==2){
						proses_DT($kondisi,"($atribut='$nilai_bindo[0]')" , "($atribut='$nilai_bindo[1]')");
					}
				}				
				//MATH TERPILIH
				else if($atribut=="math_keterangan"){					
					//jika nilai atribut 5
					if($jml_math==5){
						//hitung rasio
						$cabang = array();
						$cabang = hitung_rasio($kondisi , 'math_keterangan',$max_gain,$nilai_math[0],$nilai_math[1],$nilai_math[2],$nilai_math[3],$nilai_math[4]);
						$exp_cabang = explode(" , ",$cabang[1]);						
						proses_DT($kondisi,"($atribut='$cabang[0]')","($atribut='$exp_cabang[0]' OR $atribut='$exp_cabang[1]' OR $atribut='$exp_cabang[2]' OR $atribut='$exp_cabang[3]')");						
					}					
					//jika nilai atribut 4
					else if($jml_math==4){
						//hitung rasio
						$cabang = array();
						$cabang = hitung_rasio($kondisi , 'math_keterangan',$max_gain,$nilai_math[0],$nilai_math[1],$nilai_math[2],$nilai_math[3],'');
						$exp_cabang = explode(" , ",$cabang[1]);
						proses_DT($kondisi,"($atribut='$cabang[0]')","($atribut='$exp_cabang[0]' OR $atribut='$exp_cabang[1]' OR $atribut='$exp_cabang[2]')");
					}					
					//jika nilai atribut 3
					else if($jml_math==3){
						//hitung rasio
						$cabang = array();
						$cabang = hitung_rasio($kondisi , 'math_keterangan',$max_gain,$nilai_math[0],$nilai_math[1],$nilai_math[2],'','');
						$exp_cabang = explode(" , ",$cabang[1]);
						proses_DT($kondisi,"($atribut='$cabang[0]')","($atribut='$exp_cabang[0]' OR $atribut='$exp_cabang[1]')");
					}
					//jika nilai atribut 2
					else if($jml_math==2){
						proses_DT($kondisi,"($atribut='$nilai_math[0]')" , "($atribut='$nilai_math[1]')");
					}										
				}
				//BINDO TERPILIH
				else if($atribut=="bindo_keterangan"){
					//jika nilai atribut 5
					if($jml_bindo==5){
						//hitung rasio
						$cabang = array();
						$cabang = hitung_rasio($kondisi , 'bindo_keterangan',$max_gain,$nilai_bindo[0],$nilai_bindo[1],$nilai_bindo[2],$nilai_bindo[3],$nilai_bindo[4]);
						$exp_cabang = explode(" , ",$cabang[1]);						
						proses_DT($kondisi,"($atribut='$cabang[0]')","($atribut='$exp_cabang[0]' OR $atribut='$exp_cabang[1]' OR $atribut='$exp_cabang[2]' OR $atribut='$exp_cabang[3]')");						
					}					
					//jika nilai atribut 4
					else if($jml_bindo==4){
						//hitung rasio
						$cabang = array();
						$cabang = hitung_rasio($kondisi , 'bindo_keterangan',$max_gain,$nilai_bindo[0],$nilai_bindo[1],$nilai_bindo[2],$nilai_bindo[3],'');
						$exp_cabang = explode(" , ",$cabang[1]);
						proses_DT($kondisi,"($atribut='$cabang[0]')","($atribut='$exp_cabang[0]' OR $atribut='$exp_cabang[1]' OR $atribut='$exp_cabang[2]')");
					}					
					//jika nilai atribut 3
					else if($jml_bindo==3){
						//hitung rasio
						$cabang = array();
						$cabang = hitung_rasio($kondisi , 'bindo_keterangan',$max_gain,$nilai_bindo[0],$nilai_bindo[1],$nilai_bindo[2],'','');
						$exp_cabang = explode(" , ",$cabang[1]);
						proses_DT($kondisi,"($atribut='$cabang[0]')","($atribut='$exp_cabang[0]' OR $atribut='$exp_cabang[1]')");
					}
					//jika nilai atribut 2
					else if($jml_bindo==2){
						proses_DT($kondisi,"($atribut='$nilai_bindo[0]')" , "($atribut='$nilai_bindo[1]')");
					}
				}
				//BING TERPILIH
				else if($atribut=="bing_keterangan"){
					//jika nilai atribut 5
					if($jml_bing==5){
						//hitung rasio
						$cabang = array();
						$cabang = hitung_rasio($kondisi , 'bing_keterangan',$max_gain,$nilai_bing[0],$nilai_bing[1],$nilai_bing[2],$nilai_bing[3],$nilai_bing[4]);
						$exp_cabang = explode(" , ",$cabang[1]);						
						proses_DT($kondisi,"($atribut='$cabang[0]')","($atribut='$exp_cabang[0]' OR $atribut='$exp_cabang[1]' OR $atribut='$exp_cabang[2]' OR $atribut='$exp_cabang[3]')");						
					}					
					//jika nilai atribut 4
					else if($jml_bing==4){
						//hitung rasio
						$cabang = array();
						$cabang = hitung_rasio($kondisi , 'bing_keterangan',$max_gain,$nilai_bing[0],$nilai_bing[1],$nilai_bing[2],$nilai_bing[3],'');
						$exp_cabang = explode(" , ",$cabang[1]);
						proses_DT($kondisi,"($atribut='$cabang[0]')","($atribut='$exp_cabang[0]' OR $atribut='$exp_cabang[1]' OR $atribut='$exp_cabang[2]')");
					}					
					//jika nilai atribut 3
					else if($jml_bing==3){
						//hitung rasio
						$cabang = array();
						$cabang = hitung_rasio($kondisi , 'bing_keterangan',$max_gain,$nilai_bing[0],$nilai_bing[1],$nilai_bing[2],'','');
						$exp_cabang = explode(" , ",$cabang[1]);
						proses_DT($kondisi,"($atribut='$cabang[0]')","($atribut='$exp_cabang[0]' OR $atribut='$exp_cabang[1]')");
					}
					//jika nilai atribut 2
					else if($jml_bing==2){
						proses_DT($kondisi,"($atribut='$nilai_bing[0]')" , "($atribut='$nilai_bing[1]')");
					}
				}
				//IPS TERPILIH
				else if($atribut=="ips_keterangan"){
					//jika nilai atribut 5
					if($jml_ips==5){
						//hitung rasio
						$cabang = array();
						$cabang = hitung_rasio($kondisi , 'ips_keterangan',$max_gain,$nilai_ips[0],$nilai_ips[1],$nilai_ips[2],$nilai_ips[3],$nilai_ips[4]);
						$exp_cabang = explode(" , ",$cabang[1]);						
						proses_DT($kondisi,"($atribut='$cabang[0]')","($atribut='$exp_cabang[0]' OR $atribut='$exp_cabang[1]' OR $atribut='$exp_cabang[2]' OR $atribut='$exp_cabang[3]')");						
					}					
					//jika nilai atribut 4
					else if($jml_ips==4){
						//hitung rasio
						$cabang = array();
						$cabang = hitung_rasio($kondisi , 'ips_keterangan',$max_gain,$nilai_ips[0],$nilai_ips[1],$nilai_ips[2],$nilai_ips[3],'');
						$exp_cabang = explode(" , ",$cabang[1]);
						proses_DT($kondisi,"($atribut='$cabang[0]')","($atribut='$exp_cabang[0]' OR $atribut='$exp_cabang[1]' OR $atribut='$exp_cabang[2]')");
					}					
					//jika nilai atribut 3
					else if($jml_ips==3){
						//hitung rasio
						$cabang = array();
						$cabang = hitung_rasio($kondisi , 'ips_keterangan',$max_gain,$nilai_ips[0],$nilai_ips[1],$nilai_ips[2],'','');
						$exp_cabang = explode(" , ",$cabang[1]);
						proses_DT($kondisi,"($atribut='$cabang[0]')","($atribut='$exp_cabang[0]' OR $atribut='$exp_cabang[1]')");
					}
					//jika nilai atribut 2
					else if($jml_ips==2){
						proses_DT($kondisi,"($atribut='$nilai_ips[0]')" , "($atribut='$nilai_ips[1]')");
					}
				}
				//AQIDAH TERPILIH
				else if($atribut=="aqidah_keterangan"){
					//jika nilai atribut 5
					if($jml_aqidah==5){
						//hitung rasio
						$cabang = array();
						$cabang = hitung_rasio($kondisi , 'aqidah_keterangan',$max_gain,$nilai_aqidah[0],$nilai_aqidah[1],$nilai_aqidah[2],$nilai_aqidah[3],$nilai_aqidah[4]);
						$exp_cabang = explode(" , ",$cabang[1]);						
						proses_DT($kondisi,"($atribut='$cabang[0]')","($atribut='$exp_cabang[0]' OR $atribut='$exp_cabang[1]' OR $atribut='$exp_cabang[2]' OR $atribut='$exp_cabang[3]')");						
					}					
					//jika nilai atribut 4
					else if($jml_aqidah==4){
						//hitung rasio
						$cabang = array();
						$cabang = hitung_rasio($kondisi , 'aqidah_keterangan',$max_gain,$nilai_aqidah[0],$nilai_aqidah[1],$nilai_aqidah[2],$nilai_aqidah[3],'');
						$exp_cabang = explode(" , ",$cabang[1]);
						proses_DT($kondisi,"($atribut='$cabang[0]')","($atribut='$exp_cabang[0]' OR $atribut='$exp_cabang[1]' OR $atribut='$exp_cabang[2]')");
					}					
					//jika nilai atribut 3
					else if($jml_aqidah==3){
						//hitung rasio
						$cabang = array();
						$cabang = hitung_rasio($kondisi , 'aqidah_keterangan',$max_gain,$nilai_aqidah[0],$nilai_aqidah[1],$nilai_aqidah[2],'','');
						$exp_cabang = explode(" , ",$cabang[1]);
						proses_DT($kondisi,"($atribut='$cabang[0]')","($atribut='$exp_cabang[0]' OR $atribut='$exp_cabang[1]')");
					}
					//jika nilai atribut 2
					else if($jml_aqidah==2){
						proses_DT($kondisi,"($atribut='$nilai_aqidah[0]')" , "($atribut='$nilai_aqidah[1]')");
					}
				}
					
			}
		}						
	}
?>