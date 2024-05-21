<?php
	include "koneksi.php";
	$nim=$_GET['id'];	
	mysql_query("DELETE FROM hasil_prediksi WHERE nim = '$nim'");	
	header("location:index.php?menu=prediksi");
?>