<?php
$hostname_connTBM = "localhost";
$database_connTBM = "ind_projects";
$username_connTBM = "gabrielantal1";
$password_connTBM = "oxyd4785";
$connTBM = mysql_pconnect($hostname_connTBM, $username_connTBM, $password_connTBM) or trigger_error(mysql_error(),E_USER_ERROR); 
?>