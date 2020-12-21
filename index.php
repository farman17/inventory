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

$tablebarang = "SELECT * FROM barang";
$tablebarangquery = $MySQLi_CON->query($tablebarang);
$tablebarangrow = $tablebarangquery->num_rows;

$tablehistory = "SELECT * FROM history";
$tablehistoryquery = $MySQLi_CON->query($tablehistory);
$tablehistoryrow = $tablehistoryquery->num_rows;
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>STOK</title>
	</head>
	
	<body>
		<header>
			<div class="left">
				STOK BARANG by FARMAN
			</div>
			<div class="right">
				Hi , <?php echo htmlentities($username) ?> |
				<a href="logout.php">Logout</a>
			</div>
		</header>
		<aside>
			<ul class="side">
				<li class="side active">Home</li>
				<a href="tab-barang.php"><li class="side">Nama Barang</li></a>
				<a href="tab-stok-barang.php"><li class="side">Stok Barang</li></a>
				<a href="tab-history.php"><li class="side">History</li></a>
			</ul>
		</aside>
		<section class="content">
			<h1 class="content">STOK BARANG</h1>
			<p>Stok barang</p>
			<div class="container">
				<a href="tab-barang.php"><div class="button">Tabel Barang</div></a>
			</div>
			<div class="container">
				<div class="data">
					Jumlah Data Tabel Barang <br>
					<p style="text-align: center;font-size: 24px;color: white;margin: 0;"><?php echo $tablebarangrow; ?></p>
				</div>
			</div>
			<div class="empty"></div>
			<div class="container">
				<a href="tab-history.php"><div class="button">Tabel History</div></a>
			</div>
			<div class="container">
				<div class="data">
					Jumlah Data History <br>
					<p style="text-align: center;font-size: 24px;color: white;margin: 0;"><?php echo $tablehistoryrow; ?></p>
				</div>
			</div>
		</section>
	<?php $MySQLi_CON->close(); ?>
	</body>
</html>
