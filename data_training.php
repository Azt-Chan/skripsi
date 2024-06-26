<?php
	include "koneksi.php";
	include "fungsi.php";

	if(isset($_GET['act'])){
		$action=$_GET['act'];
		$id=$_GET['id'];
		//update data training
		if($action=='update'){
			include "update_data_training.php";
		}
		//delete data training
		else if($action=='delete'){
			mysql_query("DELETE FROM data_training WHERE id = '$id'");
			header('location:index.php?menu=data');
		}
		//delete semua data
		else if($action=='delete_all'){
			mysql_query("TRUNCATE data_training");
			header('location:index.php?menu=data');
		}		
	}else{
		include "form_data_training.php";
		$query=mysql_query("select * from data_training order by(id)");
		$jumlah=mysql_num_rows($query);	
	?>
		<br><br><br>
		<p>
			<form method="post" enctype="multipart/form-data" action="upload.php?data=training">
				Opsi: <a href="index.php?menu=data&act=delete_all" onClick="return confirm('Anda yakin akan hapus semua data?')">Hapus Semua Data</a> | 
				<!-- Import data excel: <input name="userfile" type="file"> -->
				<!-- <input name="upload" type="submit" value="import"> -->
			</form>
		</p>	
	<?php		
		if($jumlah==0){
			echo "<center><h3>Data training masih kosong...</h3></center>";
		}else{
			echo "Jumlah data training: ".$jumlah;				
	?>			
			<table bgcolor='#7c96ba' border='1' cellspacing='0' cellspading='0' align='center' width=900>
				<tr align='center'>
					<th>No</th>
					<th>Sains</th>
					<th>Matematika</th>
					<th>B. Indonesia</th>
					<th>B. Inggris</th>
					<th>IPS</th>
					<th>Aqidah Akhlaq</th>
					<th>Terbaik</th>
					<th>Action</th>	
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
					<tr bgcolor=<?php echo $warna; ?> align='center'>
						<td><?php echo $no;?></td>			
						<td><?php echo $row['sains'];?> (<?php echo $row['sains_keterangan'];?>)</td>
						<td><?php echo $row['math'];?> (<?php echo $row['math_keterangan'];?>)</td>
						<td><?php echo $row['bindo'];?>(<?php echo $row['bindo_keterangan'];?>)</td>
						<td><?php echo $row['bing'];?> (<?php echo $row['bing_keterangan'];?>)</td>
						<td><?php echo $row['ips'];?> (<?php echo $row['ips_keterangan'];?>)</td>
						<td><?php echo $row['aqidah'];?> (<?php echo $row['aqidah_keterangan'];?>)</td>
						<td><?php echo $row['terbaik'];?></td>
						<td>
							<a href="index.php?menu=data&act=update&id=<?php echo $row['id']; ?>">Update | </a>	
							<a href="data_training.php?act=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Apakah anda yakin akan menghapus data?')">Delete</a>	
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