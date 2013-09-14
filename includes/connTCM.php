<?php
$hostname_connTBM = "localhost";
$database_connTBM = "diunuge_contacts_manager";
$username_connTBM = "root";
$password_connTBM = "";
$connTBM = mysql_pconnect($hostname_connTBM, $username_connTBM, $password_connTBM) or trigger_error(mysql_error(),E_USER_ERROR); 
?>