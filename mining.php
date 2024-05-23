<?php
	include "koneksi.php";
	$query=mysql_query("select * from data_training order by(id)");
	$jumlah=mysql_num_rows($query);	
	

	// 0-25 : Cukup
	// 26-50 : Baik
	// 51-75 : Cukup baik
	// 76-100 : Sangat baik
	function getKeteragan($nilai){
		if($nilai>=0 && $nilai<=25){
			return "Cukup";
		}else if($nilai>=26 && $nilai<=50){
			return "Baik";
		}else if($nilai>=51 && $nilai<=75){
			return "Cukup Baik";
		}else if($nilai>=76 && $nilai<=100){
			return "Sangat Baik";
		}
	}

	if($jumlah==0){
		echo "<center><h3>Data training masih kosong...</h3></center>";
	}else{
		
		if(isset($_POST['submit'])){
			include "proses_mining.php";
		}else{
			?>
			<center>
				Klik "Proses Mining" untuk membentuk pohon keputusan...<br><br><br>
				<form method=POST action=''>		              				
					<input type=submit name=submit value=Proses Mining!>
				</form>
			</center>
			<?php
			echo "Jumlah data : ".$jumlah;
			?>
			<table bgcolor='#7c96ba' border='1' cellspacing='0' cellspading='0' align='center' width=900>
				<tr>
					<th>No</th>
					<th>Sains</th>
					<th>Matematika</th>
					<th>B. Indonesia</th>
					<th>B. Inggris</th>
					<th>IPS</th>
					<th>Aqidah Akhlaq</th>
					<th>Terbaik</th>
				</tr>
			<?php
				$warna1 = '#ffffff';
				$warna2 = '#f5f5f5';
				$warna  = $warna1; 	
				$no=1;
				while($row=mysql_fetch_array($query)){
					if($warna == $warna1){ 
						$warna = $warna2; 
					} else { 
						$warna = $warna1; 
					} 		
				?>
					<tr bgcolor=<?php echo $warna; ?> align=center>
						<td><?php echo getKeteragan($row['id']);?></td>			
						<td><?php echo getKeteragan($row['sains']);?></td>
						<td><?php echo getKeteragan($row['math']);?></td>
						<td><?php echo getKeteragan($row['bindo']);?></td>
						<td><?php echo getKeteragan($row['bing']);?></td>
						<td><?php echo getKeteragan($row['ips']);?></td>
						<td><?php echo getKeteragan($row['aqidah']);?></td>
						<td><?php echo getKeteragan($row['terbaik']);?></td>	
					</tr>
				<?php
					$no++;
				}
				?>
			</table>		
<?php
		}
	}		    	
?>