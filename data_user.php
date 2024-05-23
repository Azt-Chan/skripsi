<?php
	include "koneksi.php";		
	if(isset($_GET['act'])){
		$action=$_GET['act'];
		$id=$_GET['id'];		
		//delete data user
		if($action=='delete'){
			mysql_query("DELETE FROM user WHERE user_id = '$id'");
			mysql_query("DELETE FROM mahasiswa WHERE nim = '$id'");
			header('location:index.php?menu=user');
		}
		//delete semua data
		else if($action=='delete_all'){
			mysql_query("TRUNCATE mahasiswa");
			mysql_query("DELETE FROM user WHERE type ='1'");
			header('location:index.php?menu=user');
		}		
	}else{
		include "form_data_user.php";
		$query=mysql_query("select * from mahasiswa ORDER BY(nim)");
		$jumlah=mysql_num_rows($query);	
		echo "<br><br>";
	?>
		<br>
		<p>
			<form method="post" enctype="multipart/form-data" action="upload.php?data=user">
				Opsi: <a href="index.php?menu=user&act=delete_all" onClick="return confirm('Anda yakin akan hapus semua data user?')">Hapus Semua Data</a> | 
				Import data excel: <input name="userfile" type="file"> 
				<input name="upload" type="submit" value="import">*format sama dengan tabel tanpa no dan status prediksi
			</form>
		</p>	
	<?php		
		
		if($jumlah==0){
			echo "<center><h3>Data user mahasiswa masih kosong...</h3></center>";
		}else{
			echo "Jumlah data : ".$jumlah;	
		?>			
			<table bgcolor='#7c96ba' border='1' cellspacing='0' cellspading='0' align='center' width=900>
				<tr align='center'>
					<th>No</th>
					<th>NIS</th>
					<th>Nama</th>
					<th>Jenis Kelamin</th>
					<th>Angkatan</th>
					<th>Kelas</th>
					<th>Status Prediksi</th>
					<th>Action</th>
				</tr>
		<?php
				$warna1 = '#ffffff';
				$warna2 = '#f5f5f5';
				$warna  = $warna1; 	
				$no=1; 
				while($row=mysql_fetch_array($query)){
					$nis=$row['nis'];
					$que=mysql_query("SELECT * FROM hasil_prediksi WHERE nim = '$nis'");
					$statusPrediksi="";
					//jika mahasiswa sudah melakukan prediksi
					if (mysql_num_rows($que) == 1) {
						$statusPrediksi="Sudah";
					}else if(mysql_num_rows($que) == 0) {
						$statusPrediksi="Belum";
					}
					if($warna == $warna1){ 
						$warna = $warna2; 
					} else { 
						$warna = $warna1; 
					} 					
			?>
					<tr bgcolor=<?php echo $warna; ?> align='center'>
						<td><?php echo $no;?></td>			
						<td><?php echo $row['nis'];?></td>
						<td><?php echo $row['nama'];?></td>
						<td><?php echo $row['kelas'];?></td>
						<td><?php echo $row['angkatan'];?></td>
						<td><?php echo $row['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ;?></td>
						<td><?php 
								if($statusPrediksi=='Sudah'){
									echo "<strong>".$statusPrediksi."</strong>";
								}else{
									echo $statusPrediksi;
								}
							?></td>
						<td>							
							<a href="index.php?menu=user&act=delete&id=<?php echo $row[0]; ?>" onclick="return confirm('Anda yakin akan hapus data ini?')">Delete</a>
						</td>
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