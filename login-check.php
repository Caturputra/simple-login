<?php
require_once __DIR__ . '/db/config.php';

if (isset($_POST['btn_submit'])) {
	//membuat variabel untuk menampung data yang dikirim dengan POST
	$var_username = mysqli_escape_string($var_con, filter_var($_POST['frm_username'], FILTER_SANITIZE_STRING));
	$var_password = mysqli_escape_string($var_con, filter_var($_POST['frm_password'], FILTER_SANITIZE_STRING));
	
	//validasi apakah kosong atau tidak?
	if (empty(trim($var_username)) || empty(trim($var_password))) {
		header('location: login.php?e=404');
		die();
	}
	
	//sintaks sql mengambil data op_id, op_username, op_password, level_id, level_name
	//dengan relasi ke tabel level
	$var_sql_cred = "
		SELECT o.op_id, o.op_username, o.op_password, o.level_id, l.level_name
		FROM operator o
		JOIN level l ON l.level_id = o.level_id
		WHERE o.op_username = '{$var_username}'
		LIMIT 1
	";
	
	//eksekusi sintaks sql
	$var_query_cred = mysqli_query($var_con, $var_sql_cred);
	
	//cek data ditemukan atau tidak?
	//apabila tidak ada maka redirect ke halaman login
	if (mysqli_num_rows($var_query_cred) == '0') {
		header('location: login.php?e=404');
		die();
	}
	
	//ambil data dari hasil ekseskusi query
	$var_data_cred = mysqli_fetch_array($var_query_cred);
	
	//fungsi php yang digunakan untuk verifikasi kata sandi
	$var_verify = password_verify($var_password, $var_data_cred['op_password']);
	
	//cek apabila kata sandi tidak sesuai maka redirect ke halaman login
	if (!$var_verify) {
		header('location: login.php?e=404');
		die();
	}
	
	//set session apabila lolos validasi
	$_SESSION['userid'] = $var_data_cred['op_id'];
	$_SESSION['username'] = $var_data_cred['op_username'];
	$_SESSION['levelid'] = $var_data_cred['level_id'];
	$_SESSION['levelname'] = $var_data_cred['level_name'];
	
	//percabangan switch untuk menentukan halaman utama sesuai dengan data di database
	switch($var_data_cred['level_id']) {
		case $var_data_cred['level_id']:
		header('location: pages/home-' . trim(strtolower($var_data_cred['level_name'])) . '.php');
		break;
	}
}

mysqli_free_result($var_query_cred);

mysqli_close($var_con);
