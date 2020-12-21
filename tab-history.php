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
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type="application/javascript" src="jquery-2.1.3.js"></script>
		<script type="application/javascript" src="jquery-ui.js"></script>
		<script type="application/javascript" src="paging.js"></script> 
		<script>
			$(document).ready(function() {
                $('#tableData').paging({
				limit:10
				});
            });
		</script>
		<title>STOK | HISTORY</title>
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
				<a href="tab-barang.php"><li class="side">Nama Barang</li></a>
				<a href="tab-stok-barang.php"><li class="side">Stok Barang</li></a>
				<a href="tab-history.php"><li class="side active">History</li></a>
			</ul>
		</aside>
		<section class="content">
			<h1 class="content">History</h1>
			<p>Menampilkan history operasi yang dilakukan</p>
			<?php 
			$tablehistory = "SELECT * FROM history";
			if ($result = $MySQLi_CON->query($tablehistory))
			{
			if ($result->num_rows > 0)
			{
			echo "<table id='tableData'>";

			echo "<tr><th>ID</th><th>Nama Barang</th><th>Jenis Barang</th><th>Kegiatan</th><th></th>";

			while ($row = $result->fetch_object())
			{
			echo "<tr>";
			echo "<td>" . $row->idhistory . "</td>";
			echo "<td>" . $row->nama_barang . "</td>";
			echo "<td>" . $row->jenis_barang . "</td>";
			echo "<td>" . $row->kegiatan . "</td>";
			echo "<td><a class='table'onclick='return confirmDelete(this);'href='tab-history-del.php?id=" . $row->idhistory . "'>Hapus</a></td>";
			echo "</tr>";
			}

			echo "</table>";
			}
			else
			{
			echo "Tidak ada yang dapat ditampilkan !!!";
			}
			}
			else
			{
			echo "Error: " . $MySQLi_CON->error;
			}
			?>
		</section>
	</body>
	<script>
		function confirmDelete(link) {
			if (confirm("Data ini akan dihapus ?")) {
				doAjax(link.href, "POST"); // doAjax needs to send the "confirm" field
			}
			return false;
		}
	</script>
	<?php $MySQLi_CON->close(); ?>
</html>