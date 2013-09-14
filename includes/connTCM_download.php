<?php
//----------------------- change the values bellow according to the settings you have. ONLY CHANGE THE VALUES THAT ARE BETWEEN QUOTES!
$hostname_connTBM = "localhost";		//----------------------- the host for your database
$database_connTBM = "tcm_db";			//----------------------- the name of your database
$username_connTBM = "username";			//----------------------- the database user
$password_connTBM = "password";			//----------------------- the password of the user
$connTBM = mysql_pconnect($hostname_connTBM, $username_connTBM, $password_connTBM) or trigger_error(mysql_error(),E_USER_ERROR); 
?>