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

$id = $_GET['id'];
$userquery = $MySQLi_CON->query("SELECT * FROM barang WHERE idbarang = ".$id);
$row = $userquery->fetch_object();
if(isset($_POST["ubah"])){
$jumlah = $_POST["jumlah"];
$hasil_stok = ($row->stok_barang + $jumlah);
$sql = "UPDATE barang SET stok_barang = '".$hasil_stok."' WHERE idbarang = ".$id;
if ($MySQLi_CON->query($sql) == TRUE) {
	date_default_timezone_set('Asia/Jakarta');
	$waktu = date("d/m/Y h:i:s");
	$kegiatan = "Menambah stok barang ".$row->nama_barang." berjulmah ".$row->stok_barang." sebanyak ".$jumlah." sehingga stok barang ".$row->nama_barang." menjadi ".$hasil_stok;
	$sqlhistory = "INSERT INTO history (waktu, jenis_barang, nama_barang, kegiatan) 
	VALUES ('".$waktu."','".$row->nama_barang."','".$row->jenis_barang."','".$kegiatan."')";	
    if ($MySQLi_CON->query($sqlhistory) == TRUE) {
	header("Location: tab-stok-barang.php");
	} else {
    echo "Error dalam mengubah data: " . $MySQLi_CON->error;
	}
} else {
    echo "Error dalam mengubah data: " . $MySQLi_CON->error;
}

$MySQLi_CON->close();
}
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>STOK | STOK BARANG | TAMBAH</title>
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
			<h1 class="content">Tambah Stok Barang</h1>
			<p>Menambah stok barang</p>
			<form method="post">
				<p>ID : <?php echo $id; ?></p>
				<p>Nama Barang : <?php echo $row->nama_barang;?></p>
				<input type="number" name="jumlah" value="0" min="0" placeholder="Jumlah" required/><strong>*Jumlah</strong>
				</br>
				<input type="submit" name="ubah" value="Ubah"/> 
			</form>
		</section>
	</body>
</html>