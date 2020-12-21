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
		<title>STOK | STOK BARANG</title>
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
				<a href="tab-stok-barang.php"><li class="side active">Stok Barang</li></a>
				<a href="tab-history.php"><li class="side">History</li></a>
			</ul>
		</aside>
		<section class="content">
			<h1 class="content">Tabel Stok Barang</h1>
			<p>Menampilkan data stok barang</p>
			<p style="float: left;width: 100%;">Filter dalam menampiklan data</p>
			<form method="POST" style="width: 100%;float: left;">
				<select name="filter" onchange="this.form.submit()">
					<option disabled selected>Filter</option>
					<option value="remove">Hilangkan Filter</option>
					<?php
						$filterbarang = "SELECT * FROM barang";
						$filterresult = $MySQLi_CON->query($filterbarang);
						while ($filterrow = $filterresult->fetch_object()) {
							echo "<option value=\"{$filterrow->jenis_barang}\">";
							echo $filterrow->jenis_barang;
							echo "</option>";
						}
					?>
				</select>
			</form>
			<?php
			if(isset($_POST["filter"])){
				if($_POST["filter"] == "remove"){
					$tablebarang = "SELECT * FROM barang";
				}
				else{
					$tablebarang = "SELECT * FROM barang WHERE jenis_barang IN ('".$_POST["filter"]."')";
				}
			}
			else{
				$tablebarang = "SELECT * FROM barang";
			}
			if ($result = $MySQLi_CON->query($tablebarang))
			{
			if ($result->num_rows > 0)
			{
			echo "<table id='tableData'>";

			echo "<tr><th>ID</th><th>Nama Barang</th><th>Jenis Barang</th><th>Stok Barang</th><th></th><th></th></tr></th></tr>";

			while ($row = $result->fetch_object())
			{
			echo "<tr>";
			echo "<td>" . $row->idbarang . "</td>";
			echo "<td>" . $row->nama_barang . "</td>";
			echo "<td>" . $row->jenis_barang . "</td>";
			echo "<td>" . $row->stok_barang . "</td>";
			echo "<td><a class='table'href='tab-tambah-stok.php?id=" . $row->idbarang . "'>Tambah Stok</a></td>";
			echo "<td><a class='table'href='tab-kurangi-stok.php?id=" . $row->idbarang . "'>Kurangi Stok</a></td>";
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
	<?php $MySQLi_CON->close(); ?>
</html>