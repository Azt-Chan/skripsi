<form method=POST action='' >
	<table align='center' >
		<tr>
			<td colspan=2><b><center>Tambah Data Uji</center></b></td>
		</tr>
		<tr>
			<td>Instansi</td>        
			<td>: </td>
			<td>	<input type='radio' name='instansi' value='SMA' required="required">SMA </td>
			<td>	<input type='radio' name='instansi' value='SMK'>SMK </td>
			<td>	<input type='radio' name='instansi' value='MA'>MA 	</td>						
		</tr>

		<tr>
			<td>Status</td>        
			<td>: </td>
			<td>	<input type='radio' name='status' value='Negeri' required="required">Negeri </td>
			<td>	<input type='radio' name='status' value='Swasta'>Swasta </td>
		</tr>

		<tr>
			<td>Jurusan</td>        
			<td>: </td>
			<td>	<input type='radio' name='jurusan' value='IPA' required="required">IPA </td>
			<td>	<input type='radio' name='jurusan' value='IPS'>IPS </td>
			<td>	<input type='radio' name='jurusan' value='Bahasa'>Bahasa </td>
			<td>	<input type='radio' name='jurusan' value='Teknik'>Teknik </td>
			<td>	<input type='radio' name='jurusan' value='Administrasi'>Administrasi </td>
		</tr>

		<tr>
			<td>Nilai Rata UN</td>        
			<td>: </td>
			<td>	<input name='rataUN' type='text' style="width:50px;" required="required"> </td>
		</tr>		

		<tr>
			<td>Kerja</td>        
			<td>: </td>
			<td>	<input type='radio' name='kerja' value='Sudah' required="required">Sudah </td>
			<td>	<input type='radio' name='kerja' value='Belum'>Belum </td>
		</tr>
		<tr>
			<td>Motivasi</td>        
			<td>: </td>
			<td>	<input type='radio' name='motivasi' value='Sendiri' required="required">Sendiri </td>
			<td>	<input type='radio' name='motivasi' value='Orang Tua'>Orang tua </td>
			<td>	<input type='radio' name='motivasi' value='Orang Lain'>Orang lain </td>
		</tr>
		<tr>
			<td><b>Prestasi</b></td>        
			<td><b>: </b></td>
			<td><b>	<input type='radio' name='prestasi' value='Tinggi' required="required">Tinggi </b></td>
			<td><b>	<input type='radio' name='prestasi' value='Rendah'>Rendah </b></td>
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
    mysql_query("INSERT INTO data_uji 
				(instansi,status,jurusan,rata_un,kerja,motivasi,ipk_asli)
				VALUES(
					'$_POST[instansi]',
					'$_POST[status]',
					'$_POST[jurusan]',
					'$_POST[rataUN]',
					'$_POST[kerja]',
					'$_POST[motivasi]',
					'$_POST[prestasi]'
				)");
    
}
?>