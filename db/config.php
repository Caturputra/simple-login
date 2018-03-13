<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

$var_host = 'localhost';
$var_user = 'root';
$var_pass = 'caturputra';
$var_dbname = 'hohoho';

$var_con = mysqli_connect($var_host, $var_user, $var_pass, $var_dbname);

if (!$var_con) {
	die('Error: ' . mysqli_error($var_con));
}
