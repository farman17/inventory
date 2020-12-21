<?php

include('dbconnect.php');

if (isset($_GET['id']) && is_numeric($_GET['id']))
{

$id = $_GET['id'];

if ($stmt = $MySQLi_CON->prepare("DELETE FROM history WHERE idhistory = ? LIMIT 1"))
{
$stmt->bind_param("i",$id);
$stmt->execute();
$stmt->close();
}
else
{
echo "ERROR: could not prepare SQL statement.";
}
$MySQLi_CON->close();

header("Location: tab-history.php");
}
else
{
header("Location: tab-history.php");
}

?>