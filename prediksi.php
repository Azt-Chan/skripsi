<?php
include "koneksi.php";
include "fungsi.php";
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if (!isset($_SESSION['usr'])){
	header("location:login.php");
}	

$s_Query=mysql_query("SELECT * FROM pohon_keputusan");
$jml_tree=mysql_num_rows($s_Query);

if($jml_tree==0){
	echo "<center><h3>Anda tidak bisa melakukan prediksi,<br>
			Karena Pohon Keputusan belum terbentuk...</h3></center>";
}else{
	$nis=$_SESSION['usr'];
	$query=mysql_query("SELECT * FROM hasil_prediksi WHERE nis='$nis'");
	$baris=mysql_fetch_array($query);
	$jmlque=mysql_num_rows($query);
	if($jmlque==1){
		echo "<center><h1>Anda sudah melakukan prediksi..<br></h1>
			<strong>Jawaban Anda sebelumnya:<br>
			Sains = $baris[sains] ($baris[sains_keterangan])<br>
			Math = $baris[math] ($baris[math_keterangan])<br>
			Bahasa Indo = $baris[bindo] ($baris[bindo_keterangan])<br>
			Bahasa Inggris = $baris[bing] ($baris[bing_keterangan])<br> 
			Ips = $baris[ips] ($baris[ips_keterangan])<br>
			Aqidah = $baris[aqidah] ($baris[aqidah_keterangan]) </strong><br> 
			<h1>Prediksi menjadi siswa terbaik adalah ".$baris['hasil']."</h1></center>";	
		
		//menyajikan rule
		$n_sains = $baris['sains_keterangan'];
		$n_math = $baris['math_keterangan'];
		$n_bindo = $baris['bindo_keterangan'];
		$n_bing = $baris['bing_keterangan'];
		$n_ips = $baris['ips_keterangan'];
		$n_aqidah = $baris['aqidah_keterangan'];
		
		$sql=mysql_query("SELECT * FROM pohon_keputusan");	
		$id_rule="";
		$keputusan="";
		while($row=mysql_fetch_array($sql)){
			//menggabungkan parent dan akar dengan kata AND
			if($row[1]!=''){
				$rule=$row[1]." AND ".$row[2];
			}else{
				$rule=$row[2];
			}
			//mengubah parameter
			$rule=str_replace("<="," k ",$rule);
			$rule=str_replace("="," s ",$rule);
			$rule=str_replace(">"," l ",$rule);		
			//mengganti nilai
			$rule=str_replace("sains_keterangan","'$n_sains'",$rule);
			$rule=str_replace("math_keterangan","'$n_math'",$rule);
			$rule=str_replace("bindo_keterangan","'$n_bindo'",$rule);
			$rule=str_replace("bing_keterangan","$n_bing",$rule);
			$rule=str_replace("ips_keterangan","'$n_ips'",$rule);
			$rule=str_replace("aqidah_keterangan","'$n_aqidah'",$rule);		
			//menghilangkan '
			$rule=str_replace("'","",$rule);
			//explode and
			$explodeAND = explode(" AND ",$rule);
			$jmlAND = count($explodeAND);				
			//menghilangkan ()
			$explodeAND=str_replace("(","",$explodeAND);
			$explodeAND=str_replace(")","",$explodeAND);			
			//deklarasi bol
			$bolAND=array();
			$n=0;
			while($n<$jmlAND){
				//explode or
				$explodeOR = explode(" OR ",$explodeAND[$n]);
				$jmlOR = count($explodeOR);	
				//deklarasi bol
				$bol=array();
				$a=0;
				while($a<$jmlOR){				
					//pecah  dengan spasi
					$exrule2 = explode(" ",$explodeOR[$a]);
					$parameter = $exrule2[1];				
					if($parameter=='s'){
						//pecah  dengan s
						$explodeRule = explode(" s ",$explodeOR[$a]);
						//nilai true false						
						if($explodeRule[0]==$explodeRule[1]){
							$bol[$a]="Benar";
						}else if($explodeRule[0]!=$explodeRule[1]){
							$bol[$a]="Salah";
						}
					}else if($parameter=='k'){
						//pecah  dengan k
						$explodeRule = explode(" k ",$explodeOR[$a]);
						//nilai true false
						if($explodeRule[0]<=$explodeRule[1]){
							$bol[$a]="Benar";
						}else{
							$bol[$a]="Salah";
						}
					}else if($parameter=='l'){
						//pecah dengan s
						$explodeRule = explode(" l ",$explodeOR[$a]);
						//nilai true false
						if($explodeRule[0]>$explodeRule[1]){
							$bol[$a]="Benar";
						}else{
							$bol[$a]="Salah";
						}
					}
					//cetak nilai bolean				
					$a++;
				}
				//isi false
				$bolAND[$n]="Salah";
				$b=0;			
				while($b<$jmlOR){
					//jika $bol[$b] benar bolAND benar
					if($bol[$b]=="Benar"){
						$bolAND[$n]="Benar";
					}
					$b++;
				}			
				$n++;
			}
			//isi boolrule
			$boolRule="Benar";
			$a=0;
			while($a<$jmlAND){			
				//jika ada yang salah boolrule diganti salah
				if($bolAND[$a]=="Salah"){
					$boolRule="Salah";
				}						
				$a++;
			}		
			if($boolRule=="Benar"){
				$keputusan=$row[3];
				$id_rule=$row[0];
			}			
		}
		if($keputusan==''){		
			echo "<h4><center>Rule terpilih adalah rule yang terakhir karena tidak memenuhi semua rule</center></h4>";			
		}else{		
			$sql_que=mysql_query("SELECT * FROM pohon_keputusan WHERE id=$id_rule");			
			$row_bar=mysql_fetch_array($sql_que);
			$rule_terpilih = "IF ".$row_bar[1]." AND ".$row_bar[2]." THEN prestasi = ".$row_bar[3];
			echo "<h4><center>Rule yang terpilih adalah rule ke-".$row_bar[0]."<br>".$rule_terpilih."</center></h4>";						
		}
		echo "<center><a href='delete_prediksi.php?id=$nis' accesskey='5' title='ubah jawaban' onClick=\"return confirm('Anda yakin akan mengedit data?')\">Klik disini untuk kembali lakukan prediksi</a></center>";	
	}
	//jika belum melakukan prediksi
	else if($jmlque==0){
		if (!isset($_POST['submit'])) {
		?>
		<center><b>Jawab pertanyaan berikut dengan benar!</b></center>
		<form method=POST action='' >
			<table align='center'>
				<tr>
					<td colspan=2></td>
				</tr>		

				<tr>
					<td colspan=3>1. Berapa nilai sains?</td>        
				</tr>
				<tr>
					<td> &nbsp;&nbsp;<input name='sains' type='text' style="width:50px;" required="required"> </td>
				</tr>	

				<tr>
					<td colspan=3>2. Berapa nilai math?</td>        
				</tr>
				<tr>
					<td> &nbsp;&nbsp;<input name='math' type='text' style="width:50px;" required="required"> </td>
				</tr>
					
				<tr>
					<td colspan=3>3. Berapa nilai bahasa indonesia?</td>        
				</tr>
				<tr>
					<td> &nbsp;&nbsp;<input name='bindo' type='text' style="width:50px;" required="required"> </td>
				</tr>

				<tr>
					<td colspan=3>4. Berapa nilai bahasa inggris?</td>        
				</tr>
				<tr>
					<td> &nbsp;&nbsp;<input name='bing' type='text' style="width:50px;" required="required"> </td>
				</tr>

				<tr>
					<td colspan=3>5. Berapa nilai ips?</td>        
				</tr>
				<tr>
					<td> &nbsp;&nbsp;<input name='ips' type='text' style="width:50px;" required="required"> </td>
				</tr>

				<tr>
					<td colspan=3>5. Berapa nilai aqidah?</td>        
				</tr>
				<tr>
					<td> &nbsp;&nbsp;<input name='aqidah' type='text' style="width:50px;" required="required"> </td>
				</tr>	

				<tr>
					<td colspan=2>
						<input type=submit name=submit value=Submit >
						<input type='reset' value='Batal'>
					</td>
				</tr>
			</table>
		</form>

		<?php
		}else{
			$n_sains = $_POST['sains'];
			$n_math = $_POST['math'];
			$n_bindo = $_POST['bindo'];
			$n_bing = $_POST['bing'];
			$n_ips = $_POST['ips'];
			$n_aqidah = $_POST['aqidah'];

			echo "<h4><center>Hasil Jawaban Anda...<br>";
			echo "Nilai sains: ".$n_sains."<br>";
			echo "Nilai math: ".$n_math."<br>";
			echo "Nilai bahasa indonesia: ".$n_bindo."<br>";
			echo "Nilai Bahasa inggris: ".$n_bing."<br>";
			echo "Nilai ips: ".$n_ips."<br>";
			echo "Nilai aqidah: ".$n_aqidah."<br><br><br><br></center></h4>";	
					
			$sql=mysql_query("SELECT * FROM pohon_keputusan");	
			$id_rule="";
			$keputusan="";
			while($row=mysql_fetch_array($sql)){
				//menggabungkan parent dan akar dengan kata AND
				if($row[1]!=''){
					$rule=$row[1]." AND ".$row[2];
				}else{
					$rule=$row[2];
				}
			
				//mengubah parameter
				$rule=str_replace("<="," k ",$rule);
				$rule=str_replace("="," s ",$rule);
				$rule=str_replace(">"," l ",$rule);		
				//mengganti nilai
				$rule=str_replace("sains_keterangan","'".getKeterangan($n_sains)."'",$rule);
				$rule=str_replace("math_keterangan","'".getKeterangan($n_math)."'",$rule);
				$rule=str_replace("bindo_keterangan","'".getKeterangan($n_bindo)."'",$rule);
				$rule=str_replace("bing_keterangan","".getKeterangan($n_bing)."",$rule);
				$rule=str_replace("ips_keterangan","'".getKeterangan($n_ips)."'",$rule);
				$rule=str_replace("aqidah_keterangan","'".getKeterangan($n_aqidah)."'",$rule);		
				//menghilangkan '
				$rule=str_replace("'","",$rule);
				//explode and
				$explodeAND = explode(" AND ",$rule);
				$jmlAND = count($explodeAND);				
				//menghilangkan ()
				$explodeAND=str_replace("(","",$explodeAND);
				$explodeAND=str_replace(")","",$explodeAND);			
				//deklarasi bol
				$bolAND=array();
				$n=0;
				while($n<$jmlAND){
					//explode or
					$explodeOR = explode(" OR ",$explodeAND[$n]);
					$jmlOR = count($explodeOR);	
					//deklarasi bol
					$bol=array();
					$a=0;
					while($a<$jmlOR){				
						//pecah  dengan spasi
						$exrule2 = explode(" ",$explodeOR[$a]);
						$parameter = $exrule2[1];				
						if($parameter=='s'){
							//pecah  dengan s
							$explodeRule = explode(" s ",$explodeOR[$a]);
							//nilai true false						
							if($explodeRule[0]==$explodeRule[1]){
								$bol[$a]="Benar";
							}else if($explodeRule[0]!=$explodeRule[1]){
								$bol[$a]="Salah";
							}
						}else if($parameter=='k'){
							//pecah  dengan k
							$explodeRule = explode(" k ",$explodeOR[$a]);
							//nilai true false
							if($explodeRule[0]<=$explodeRule[1]){
								$bol[$a]="Benar";
							}else{
								$bol[$a]="Salah";
							}
						}else if($parameter=='l'){
							//pecah dengan s
							$explodeRule = explode(" l ",$explodeOR[$a]);
							//nilai true false
							if($explodeRule[0]>$explodeRule[1]){
								$bol[$a]="Benar";
							}else{
								$bol[$a]="Salah";
							}
						}
						//cetak nilai bolean				
						$a++;
					}
					//isi false
					$bolAND[$n]="Salah";
					$b=0;			
					while($b<$jmlOR){
						//jika $bol[$b] benar bolAND benar
						if($bol[$b]=="Benar"){
							$bolAND[$n]="Benar";
						}
						$b++;
					}			
					$n++;
				}
				//isi boolrule
				$boolRule="Benar";
				$a=0;
				while($a<$jmlAND){			
					//jika ada yang salah boolrule diganti salah
					if($bolAND[$a]=="Salah"){
						$boolRule="Salah";
					}						
					$a++;
				}		
				if($boolRule=="Benar"){
					$keputusan=$row[3];
					$id_rule=$row[0];
				}			
			}				
			
			if($keputusan==''){
				$que=mysql_query("SELECT parent FROM pohon_keputusan");				
				$jml=array();
				$exParent=array();
				$i=0;
				while($bar=mysql_fetch_array($que)){
					$exParent=explode(" AND ",$bar['parent']);								
					$jml[$i] = count($exParent);	
					$i++;
				}
				$maxParent=max($jml);
				$sql_query=mysql_query("SELECT * FROM pohon_keputusan");				
				while($bar_row=mysql_fetch_array($sql_query)){
					$explP=explode(" AND ",$bar_row['parent']);
					$jmlT=count($explP);
					if($jmlT==$maxParent){
						$keputusan=$bar_row['keputusan'];
						$id_rule=$bar_row['id'];
					}
				}			
				echo "<h1><center>Anda diprediksi memiliki  prestasi".$keputusan."</center></h1>";			
				echo "<h4><center>Rule terpilih adalah rule yang terakhir karena tidak memenuhi semua rule</center></h4>";	
				mysql_query("INSERT INTO hasil_prediksi (nis,sains,math,bindo,bing,ips,aqidah,  sains_keterangan,math_keterangan,bindo_keterangan,bing_keterangan,ips_keterangan,aqidah_keterangan,hasil) VALUES 
				('$nis','$n_sains','$n_math','$n_bindo','$n_bing','$n_ips','$n_aqidah','".getKeterangan($n_sains)."','".getKeterangan($n_math)."','".getKeterangan($n_bindo)."','".getKeterangan($n_bing)."','".getKeterangan($n_ips)."','".getKeterangan($n_aqidah)."','$keputusan')");
			}else{
				echo "<h1><center>Anda diprediksi memiliki menjadi siswa terbaik ".$keputusan."</center></h1>";
				$sql_que=mysql_query("SELECT * FROM pohon_keputusan WHERE id=$id_rule");			
				$row_bar=mysql_fetch_array($sql_que);
				$rule_terpilih = "IF ".$row_bar[1]." AND ".$row_bar[2]." THEN prestasi = ".$row_bar[3];
				echo "<h4><center>Rule yang terpilih adalah rule ke-".$row_bar[0]."<br>".$rule_terpilih."</center></h4>";	
				mysql_query("INSERT INTO hasil_prediksi (nis,sains,math,bindo,bing,ips,aqidah,  sains_keterangan,math_keterangan,bindo_keterangan,bing_keterangan,ips_keterangan,aqidah_keterangan,hasil) VALUES 
				('$nis','$n_sains','$n_math','$n_bindo','$n_bing','$n_ips','$n_aqidah','".getKeterangan($n_sains)."','".getKeterangan($n_math)."','".getKeterangan($n_bindo)."','".getKeterangan($n_bing)."','".getKeterangan($n_ips)."','".getKeterangan($n_aqidah)."','$keputusan')");				
			}		
		}
	}
}
?>