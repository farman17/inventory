<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['userSession']))
{
 header("Location: login.php");
}
else{
$sql = "SELECT * FROM user WHERE user_id=".$_SESSION['userSession'];
$userquery = $MySQLi_CON->query($sql);
$userRow = $userquery->fetch_object();
$username = $userRow->username;
}

if(isset($_POST["tambah"])){
$nama_barang = $_POST["nama_barang"];
$jenis_barang = $_POST["jenis_barang"];
$sql = "INSERT INTO barang (nama_barang, jenis_barang, stok_barang)
VALUES ('".$nama_barang."','".$jenis_barang."',0)";

if ($MySQLi_CON->query($sql) == TRUE) {
date_default_timezone_set('Asia/Jakarta');
$waktu = date("d/m/Y h:i:s");
$kegiatan = "Memabahkan barang baru jenis ".$jenis_barang." dengan nama ".$nama_barang;
$sqlhistory = "INSERT INTO history (waktu, jenis_barang, nama_barang, kegiatan) 
VALUES ('".$waktu."','".$nama_barang."','".$jenis_barang."','".$kegiatan."')";
if ($MySQLi_CON->query($sqlhistory) == TRUE) {
	header("Location: tab-barang.php");
}
else {
echo "Error: " . $sql . "<br>" . $MySQLi_CON->error;
}
} else {
echo "Error: " . $sql . "<br>" . $MySQLi_CON->error;
}

$MySQLi_CON->close();
}
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>STOK | NAMA BARANG | TAMBAH</title>
	</head>
	
	<body>
		<header>
			<div class="left">
				STOK BARANG
			</div>
			<div class="right">
				Hi , <?php echo htmlentities($username) ?> |
				<a href="logout.php">Logout</a>
			</div>
		</header>
		<aside>
			<ul class="side">
				<a href="index.php"><li class="side">Home</li></a>
				<a href="tab-barang.php"><li class="side active">Nama Barang</li></a>
				<a href="tab-stok-barang.php"><li class="side">Stok Barang</li></a>
				<a href="tab-history.php"><li class="side">History</li></a>
			</ul>
		</aside>
		<section class="content">
			<h1 class="content">Tabel barang</h1>
			<p>Menambah data barang</p>
			<form method="post">
				<input type="text" name="nama_barang" placeholder="Nama Barang" required/>
				<input type="text" name="jenis_barang" placeholder="Jenis Barang" required/><br>
				<input type="submit" name="tambah" value="Tambah"/> 
			</form>
		</section>
	</body>
</html>