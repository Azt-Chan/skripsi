<?php
$sql = mysql_query("SELECT * FROM data_training WHERE id='$_GET[id]'");
$row = mysql_fetch_array($sql);	
$sains=$row['sains'];
$math=$row['math'];
$bindo=$row['bindo'];
$bing=$row['bing'];
$ips=$row['ips'];
$aqidah=$row['aqidah'];
$terbaik=$row['terbaik'];

if (isset($_POST['submit'])) {
	mysql_query("UPDATE data_training SET 
		sains = '$_POST[sains]',
		math = '$_POST[math]',
		bindo = '$_POST[bindo]',
		bing = '$_POST[bing]',
		ips = '$_POST[ips]',
		aqidah = '$_POST[aqidah]',
		terbaik = '$_POST[terbaik]'
		WHERE id      = '$_GET[id]'");
	echo "<center><h3>Berhasil update</h3></center>";
}else{
?>
<form method=POST action='' >
	<table align='center' >
		<tr>
			<td colspan=2><b><center>Edit Data Training</center></b></td>
		</tr>
		<tr>
			<td>Sains</td>        
			<td>: </td>
			<td>	<input name='sains' type='number' step=".01" min="0" max="100" style="width:50px;" required="required" value=<?php echo $sains; ?>> </td>										
		</tr>

		<tr>
			<td>Matematika</td>        
			<td>: </td>
			<td>	<input name='math' type='number' step=".01" min="0" max="100" style="width:50px;" required="required" value=<?php echo $math; ?>> </td>										
		</tr>

		<tr>
			<td>B. Indonesia</td>        
			<td>: </td>
			<td>	<input name='bindo' type='number' step=".01" min="0" max="100" style="width:50px;" required="required" value=<?php echo $bindo; ?>> </td>										
		</tr>

		<tr>
			<td>B. Inggris</td>        
			<td>: </td>
			<td>	<input name='bing' type='number' step=".01" min="0" max="100" style="width:50px;" required="required" value=<?php echo $bing; ?>> </td>					
		</tr>

		<tr>
			<td>IPS</td>        
			<td>: </td>
			<td>	<input name='ips' type='number' step=".01" min="0" max="100" style="width:50px;" required="required" value=<?php echo $ips; ?>> </td>
		</tr>

		<tr>
			<td>Aqidah Akhlaq</td>        
			<td>: </td>
			<td>	<input name='aqidah' type='number' step=".01" min="0" max="100" style="width:50px;" required="required" value=<?php echo $aqidah; ?>> </td>				
		</tr>

		<tr>
			<td><b>Terbaik</b></td>        
			<td><b>: </b></td>
			<td><b>	<input type='radio' name='terbaik' value='Ya' <?php if($terbaik=='Ya'){ echo 'checked'; } ?>>Ya </b></td>
			<td><b>	<input type='radio' name='terbaik' value='Tidak' <?php if($terbaik=='Tidak'){ echo 'checked'; } ?>>Tidak </b></td>
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
}
?>
<a href='index.php?menu=data' accesskey='5' title='Kembali'><< kembali</a>