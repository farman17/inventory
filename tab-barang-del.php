<?php

include('dbconnect.php');

if (isset($_GET['id']) && is_numeric($_GET['id']))
{

$id = $_GET['id'];

if ($stmt = $MySQLi_CON->prepare("DELETE FROM barang WHERE idbarang = ? LIMIT 1"))
{
$id = $_GET['id'];
$userquery = $MySQLi_CON->query("SELECT * FROM barang WHERE idbarang = ".$id);
$row = $userquery->fetch_object();
date_default_timezone_set('Asia/Jakarta');
$waktu = date("d/m/Y h:i:s");
$kegiatan = "Meghapus nama barang ".$row->nama_barang." dengan jenis barang ".$row->jenis_barang;
$sqlhistory = "INSERT INTO history (waktu, jenis_barang, nama_barang, kegiatan) 
VALUES ('".$waktu."','".$row->nama_barang."','".$row->jenis_barang."','".$kegiatan."')";	
if ($MySQLi_CON->query($sqlhistory) == TRUE) {

}
else 
{
    echo "Error dalam menghapus data: " . $MySQLi_CON->error;
}
$stmt->bind_param("i",$id);
$stmt->execute();
$stmt->close();
}
else
{
echo "ERROR: could not prepare SQL statement.";
}

$MySQLi_CON->close();
header("Location: tab-barang.php");
}
else
{
header("Location: tab-barang.php");
}

?>