<form method=POST action='' >
	<table align='center' >
		<tr>
			<td colspan=2><b><center>Tambah Data Siswa</center></b></td>
		</tr>
		<tr>
			<td>NIS</td>        
			<td>: </td>
			<td> <input name='nis' type='text' style="width:100px;" required="required"> </td>			
		</tr>
		<tr>
			<td>Nama</td>        
			<td>: </td>
			<td colspan=2> <input name='nama' type='text' style="width:250px;" required="required"> </td>			
		</tr>
		<tr>
			<td>Jenis Kelamin</td>        
			<td>: </td>
			<td><select name="jenisKelamin" style="width:100px;" required="required">
					<option value=''>-</option>
					<option value='L'>Laki-laki</option>
					<option value='P'>Perempuan</option>
				</select>
			</td>			
		</tr>
		<tr>
			<td>Angkatan</td>        
			<td>: </td>
			<td> <input name='angkatan' type='text' style="width:50px;" required="required"> </td>
		</tr>		

		<tr>
			<td>Kelas</td>        
			<td>: </td>
			<td><select name="kelas" style="width:100px;" required="required">
					<option value=''>-</option>
					<option value='A' >A</option>
					<option value='B'>B</option>
					<option value='C'>C</option>
					<option value='D'>D</option>
				</select>
			</td>
		</tr>		
		<tr>
			<td colspan=2>
				<input type=submit name=submit value=Submit>
				<input type='reset' value='Batal'>
			</td>
		</tr>
	</table>
</form>
<?php
if (isset($_POST['submit'])) {
	$nis = $_POST['nis'];
	$nama = $_POST['nama'];
	$jk = $_POST['jenisKelamin'];
	$angkatan = $_POST['angkatan'];
	$kelas = $_POST['kelas'];

	
    mysql_query("INSERT INTO mahasiswa 				
				VALUES(
					'$nis',
					'$nama',
					'$jk',
					'$angkatan',
					'$kelas'					
				)");
    mysql_query("INSERT INTO user 				
				VALUES(
					'$nis',
					'$nama',
					'$nis',
					'1'										
				)");

	// if(!$result) {
	// 	die("Database query failed: " . mysql_error());
	// } 

}
?>