<?php
mysql_select_db($database_connTBM, $connTBM);

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

//---------------------------------------- settings query

foreach($_POST as $post_key => $post_value) {
	if ($post_value == '') { $_POST[$post_key] = '0'; }
	}
//edited diunuge
//$tbm_sorter = $_GET['tbm_sorter'];
//Not needed
if (!isset($_GET['tbm_sorter'])) {
	$tbm_sorter = 0;
}
else {
	$tbm_sorter = $_GET['tbm_sorter'];
}

$row_total = 8;

if (!isset($_GET['row_start'])) {
	$row_start = 0;
	$row_end = $row_total;
}
else {
	$row_start = $_GET['row_start'];
	$row_end = $_GET['row_end'];
}

if (!isset($_GET['pag_nr'])) {
$_GET['pag_nr'] = 1;
}

//if (!$_REQUEST['tcm_lang']) { $_REQUEST['tcm_lang'] = 'en'; }
//no longer needed. only english version
$_REQUEST['tcm_lang'] = 'en';

if (isset($_POST['tbm_contain']) && $_POST['tbm_contain'] == 1) {
	$tbm_like_start = '';
}
else {
	$tbm_like_start = '%';
}

/*
if ($_POST['tbm_contain'] == 1) { $tbm_like_start = '%'; }
else { $tbm_like_start = ''; } */

$tbm_like_end = '%';

$current_page = $_SERVER["PHP_SELF"];

$var_time = date('Y-m-d H:i:s');

$tbm_sort_direction = $_GET['tbm_sort_direction'];

switch($tbm_sort_direction) {
	case !isset($_GET['tbm_action']) && !isset($_POST['tbm_action']) && $_GET['tbm_sort_direction'] == 'ASC': $tbm_sort_direction = 'DESC'; break;
	case !isset($_GET['tbm_action']) && !isset($_POST['tbm_action']) && $_GET['tbm_sort_direction'] == 'DESC': $tbm_sort_direction = 'ASC'; break;
	case isset($_GET['tbm_action']) || isset($_POST['tbm_action']): $tbm_sort_direction = $_GET['tbm_sort_direction']; break;
	default: $tbm_sort_direction = 'DESC';
}
?>