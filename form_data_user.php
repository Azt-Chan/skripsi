<form method=POST action='' >
	<table align='center' >
		<tr>
			<td colspan=2><b><center>Tambah Data Mahasiswa</center></b></td>
		</tr>
		<tr>
			<td>NIM</td>        
			<td>: </td>
			<td> <input name='nim' type='text' style="width:100px;" required="required"> </td>			
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
					<option value='Pagi' >Pagi</option>
					<option value='Sore'>Sore</option>
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
	$nim = $_POST['nim'];
	$nama = $_POST['nama'];
	$jk = $_POST['jenisKelamin'];
	$angkatan = $_POST['angkatan'];
	$kelas = $_POST['kelas'];
    mysql_query("INSERT INTO mahasiswa 				
				VALUES(
					'$nim',
					'$nama',
					'$jk',
					'$angkatan',
					'$kelas'					
				)");
    mysql_query("INSERT INTO user 				
				VALUES(
					'$nim',
					'$nama',
					'$nim',
					'1'										
				)");
}
?>