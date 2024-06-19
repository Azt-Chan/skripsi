<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
    session_start();
    if (!isset($_SESSION['usr'])){
        header("location:login.php");
    }
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Data Mining Prediksi Decision Tree C4.5</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="images/logo.png" rel="shortcut icon" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link href="font-google.css" rel="stylesheet" type="text/css"  media="all"/>
	<link href="css/default.css" rel="stylesheet" type="text/css" media="all" />
	<!--[if IE 6]>
	<link href="default_ie6.css" rel="stylesheet" type="text/css" />
	<![endif]-->
</head>
<body>
	<div id="header">
		<div id="logo">
			<img src="images/logo.png"/>
		</div>
		<div id="logo-name">
			<h1><a href="index.php">SISTEM PREDIKSI SISWA TERBAIK</a></h1>
		</div>				
	</div>	
	<div id="menu">
		<ul>
			<?php
				$level=$_SESSION['lvl'];
				//jika user kaprodi
				if($level=='0'){
					echo "<li class='first'><a href='index.php?menu=home' accesskey='1' title='Beranda'>Beranda</a></li>
							<li><a href='?menu=data' accesskey='1' title='Data Training'>Data Training</a></li>
							<li><a href='?menu=mining' accesskey='2' title='Proses Pembentukan Tree'>Mining</a></li>
							<li><a href='?menu=tree' accesskey='3' title='Rule Pohon Keputusan'>Pohon Keputusan</a></li>
							<li><a href='?menu=hasil' accesskey='4' title='Hasil Prediksi'>Hasil Prediksi</a></li>
							<li><a href='?menu=user' accesskey='5' title='Data User'>Data User</a></li>";
				}
				//jika user mahasiswa
				else{
					echo "<li class='first'><a href='?menu=home' accesskey='1' title='Beranda'>Beranda</a></li>
							<li><a href='?menu=prediksi' accesskey='prediksi' title='Prediksi Prestasi'>Prediksi</a></li>							
							<li><a href='?menu=tree' accesskey='tree' title='Rule Pohon Keputusan'>Pohon Keputusan</a></li>";
				}
			?>								
		</ul>
	</div>
	<div id="wrapper" class="container">
		<h4 align="right">							
			<?php echo "User ID : ".$_SESSION['usr']." | Nama : ".$_SESSION['nama']." | "; ?>
			<a href='?menu=ubah_password' accesskey='5' title='Change password' >Ubah Password</a> | 
			<a href='logout.php' accesskey='5' title='Log Out' onClick="return confirm('Anda yakin akan keluar?')">Log Out</a>
		</h4>
		<div id="page">			
			<div id="content">
				<div id="box1">							
					<p>																		
						<?php
						//jika menu sudah diset
						if (isset($_GET['menu'])) {
							$kode=$_GET['menu'];
							//menu home
							if($kode=='home'){
								echo "<center><strong>
									
									<h2>SISTEM PREDIKSI SISWA TERBAIK MENGGUNAKAN METODE DECISION TREE C4.5</h2><br/>
									<img src='images/siswa.png' width='350' height='auto'/><br>									
									Aplikasi ini akan menghasilkan perkiraan prediksi siswa terbaik dari data training yang di gunakan adalah data nilai Sains,Matematika,Bahasa Indonesia,Bahasa Inggris,Ips dan Aqidah Akhlak.
									<br>
									Hasil analisa dikelompokkan menjasi kelas tinggi (predikasi berprestasi tinggi) dan kelas rendah (predikasi berprestasi rendah).
									</strong></center>";
							}
							//menu olah data
							else if ($kode=='data'){
								include 'data_training.php';
							}
							//menu mining (proses pembentukan pohon keputusan)
							else if($kode=='mining'){
								include 'mining.php';
							}
							//menu pohon keputusan atau rule
							else if($kode=='tree'){
								include 'tree.php';
							}
							//menu pohon tree2
							else if($kode=='pohon_tree'){
								include 'pohon_tree.php';
							}
							//menu uji pohon keputusan atau rule
							else if($kode=='uji_rule'){
								include 'uji_rule.php';
							}
							//menu hasil prediksi
							else if($kode=='hasil'){	
								include 'hasil_prediksi.php';
							}
							//menu data user
							else if($kode=='user'){		
								include 'data_user.php';
							}
							//menu prediksi
							else if($kode=='prediksi'){
								include 'prediksi.php';
							}
							//menu ubah password
							else if($kode=='ubah_password'){
								include 'ubah_password.php';
							}
						}
						//jika menu belum diset
						else{
							echo "<strong><center>BERANDA</center></strong><br><br>";
							echo "<center><strong>
									
									<h2>SISTEM PREDIKSI SISWA TERBAIK MENGGUNAKAN METODE DECISION TREE C4.5</h2><br/>
									<img src='images/siswa.png' width='350' height='auto'/><br>									
									Aplikasi ini akan menghasilkan perkiraan prediksi siswa terbaik dari data training yang di gunakan adalah data nilai Sains,Matematika,Bahasa Indonesia,Bahasa Inggris,Ips dan Aqidah Akhlak.
									<br>
									Hasil analisa dikelompokkan menjadi kelas tinggi (predikasi berprestasi tinggi) dan kelas rendah (predikasi berprestasi rendah).
									</strong></center>";
						}
						?>						
					</p>
				</div>
			</div>
		</div>
	
		<div id="footer">
			<!-- <p>Decision Tree C4.5 &copy;2020 <a href="http://www.mycoding.net">My Coding</a></p> -->
		</div>
	</div>
</body>
</html>
