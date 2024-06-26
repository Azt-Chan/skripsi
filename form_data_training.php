<form method=POST action='' >
	<table align='center' >
		<tr>
			<td>
				0 - 50 : Kurang
			</td>
		</tr>
		<tr>
			<td>
				51-59 : Cukup 
			</td>
		</tr>
		<tr>
			<td>
				60-75 : Baik
			</td>
		</tr>
		<tr>
			<td>
				76-85 : Cukup baik 
			</td>
		</tr>
		<tr>
			<td>
				86-100 : sangat baik
			</td>
		</tr>

		<tr>
			<td>
				<br/>
			</td>
		</tr>

		<tr>
			<td colspan=2><b><center>Tambah Data Training</center></b></td>
		</tr>



		

		<tr>
			<td>Sains</td>        
			<td>: </td>
			<td>	<input name='sains' type='number' step=".01" min="60" max="100" style="width:50px;" required="required"> </td>										
		</tr>

		<tr>
			<td>Matematika</td>        
			<td>: </td>
			<td>	<input name='math' type='number' step=".01" min="60" max="100" style="width:50px;" required="required"> </td>										
		</tr>

		<tr>
			<td>B. Indonesia</td>        
			<td>: </td>
			<td>	<input name='bindo' type='number' step=".01" min="60" max="100" style="width:50px;" required="required"> </td>										
		</tr>

		<tr>
			<td>B. Inggris</td>        
			<td>: </td>
			<td>	<input name='bing' type='number' step=".01" min="60" max="100" style="width:50px;" required="required"> </td>					
		</tr>

		<tr>
			<td>IPS</td>        
			<td>: </td>
			<td>	<input name='ips' type='number' step=".01" min="60" max="100" style="width:50px;" required="required"> </td>
		</tr>

		<tr>
			<td>Aqidah Akhlaq</td>        
			<td>: </td>
			<td>	<input name='aqidah' type='number' step=".01" min="60" max="100" style="width:50px;" required="required"> </td>				
		</tr>

		<tr>
			<td><b>Terbaik</b></td>        
			<td><b>: </b></td>
			<td><b>	<input type='radio' name='terbaik' value='Ya' required="required">Ya </b></td>
			<td><b>	<input type='radio' name='terbaik' value='Tidak'>Tidak </b></td>
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
	$sains_keterangan = getKeterangan($_POST['sains']);
	$math_keterangan = getKeterangan($_POST['math']);
	$bindo_keterangan = getKeterangan($_POST['bindo']);
	$bing_keterangan = getKeterangan($_POST['bing']);
	$ips_keterangan = getKeterangan($_POST['ips']);
	$aqidah_keterangan = getKeterangan($_POST['aqidah']);

	$result = mysql_query("INSERT INTO data_training 
				(sains,math,bindo,bing,ips,aqidah,terbaik,
				sains_keterangan,math_keterangan,bindo_keterangan,bing_keterangan,ips_keterangan,aqidah_keterangan)
				VALUES(
					'$_POST[sains]',
					'$_POST[math]',
					'$_POST[bindo]',
					'$_POST[bing]',
					'$_POST[ips]',
					'$_POST[aqidah]',
					'$_POST[terbaik]',
					'$sains_keterangan',
					'$math_keterangan',
					'$bindo_keterangan',
					'$bing_keterangan',
					'$ips_keterangan',
					'$aqidah_keterangan'
				)");


	if(!$result) {
		die("Database query failed: " . mysql_error());
	} 
    
}
?>