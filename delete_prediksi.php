<?php
	include "koneksi.php";
	$nis=$_GET['id'];	
	mysql_query("DELETE FROM hasil_prediksi WHERE nis = '$nis'");	
	header("location:index.php?menu=form_prediksi&id=$nis");
?>