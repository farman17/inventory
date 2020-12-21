<?php

/* Dibuat Oleh D_ziem */

  $DB_host = "";
  $DB_user = "admin";
  $DB_pass = "";
  $DB_name = "stok_barang";
  
  $MySQLi_CON = new MySQLi($DB_host,$DB_user,$DB_pass,$DB_name);
    
     if($MySQLi_CON->connect_errno)
     {
         die("ERROR : -> ".$MySQLi_CON->connect_error);
     }

?>
