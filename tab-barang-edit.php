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
$nama_barang = $_POST["nama_barang"];
$jenis_barang = $_POST["jenis_barang"];
$sql = "UPDATE barang SET nama_barang = '".$nama_barang."', jenis_barang = '".$jenis_barang."' WHERE idbarang = ".$id;
if ($MySQLi_CON->query($sql) == TRUE) {
	date_default_timezone_set('Asia/Jakarta');
	$waktu = date("d/m/Y h:i:s");
	$kegiatan = "Mengubah nama barang ".$row->nama_barang." menjadi ".$nama_barang." dan mengubah jenis barang ".$row->jenis_barang." menjadi ".$jenis_barang;
	$sqlhistory = "INSERT INTO history (waktu, jenis_barang, nama_barang, kegiatan) 
	VALUES ('".$waktu."','".$row->nama_barang."','".$row->jenis_barang."','".$kegiatan."')";	
    if ($MySQLi_CON->query($sqlhistory) == TRUE) {
	header("Location: tab-barang.php");
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
		<title>STOK | NAMA BARANG | EDIT</title>
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
			<h1 class="content">Tabel Barang</h1>
			<p>Mengubah nama dan jenis barang</p>
			<form method="post">
				<p>ID: <?php echo $id; ?></p>
				<input type="text" name="nama_barang" value="<?php echo $row->nama_barang; ?>" placeholder="Nama Barang" required/><strong>*Nama Barang</strong>
				<input type="text" name="jenis_barang" value="<?php echo $row->jenis_barang; ?>" placeholder="Jenis Barang" required/><strong>*Jenis Barang</strong><br>
				<input type="submit" name="ubah" value="Ubah"/> 
			</form>
		</section>
	</body>
</html>