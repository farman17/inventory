<?php

/* Dibuat Oleh D_ziem */

session_start();
include_once 'dbconnect.php';

if(isset($_POST['btn-login']))
{
 $user = $MySQLi_CON->real_escape_string(trim($_POST['user']));
 $pass = $MySQLi_CON->real_escape_string(trim($_POST['pass']));
 $check_user = "select * from user WHERE username='$user' AND password='$pass'";  
 $run = $MySQLi_CON->query($check_user); 
 $query = $MySQLi_CON->query("SELECT * FROM user WHERE username='$user'");
 $row = $query->fetch_array();
   if(mysqli_num_rows($run))  
    {  
        $_SESSION['userSession'] = $row['user_id'];
		header("Location: index.php");
    }  
    else  
    {  
     $msg = "username or password does not exists !";
    }   
 $MySQLi_CON->close();
 
}
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>STOK | LOGIN</title>
	</head>
	
	<body>
		<form class="login" method="post">
			<h1 class="login">Log In</h1>
			 <?php
				if(isset($msg)){
				echo "<p>".$msg."</p>";
				}
			?>
			<input type="text" class="login" name="user" placeholder="Username" required/>
			<input type="password" class="login" name="pass" placeholder="Password" required/>
			<input type="submit" class="button button-login" value="Login" name="btn-login" style="float: none;margin: 0 auto;"/>
		</form>
	</body>
</html>