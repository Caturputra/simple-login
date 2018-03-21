<?php
require_once __DIR__ . '/db/config.php';

if (isset($_POST['btn_register'])) {
	//membuat variabel untuk menampung data yang dikirim melalui POST
	$var_name = mysqli_escape_string($var_con, filter_var($_POST['frm_name'], FILTER_SANITIZE_STRING));
	$var_username = mysqli_escape_string($var_con, filter_var($_POST['frm_username'], FILTER_SANITIZE_STRING));
	$var_password = mysqli_escape_string($var_con, filter_var($_POST['frm_password'], FILTER_SANITIZE_STRING));
	$var_role = mysqli_escape_string($var_con, filter_var($_POST['frm_role'], FILTER_SANITIZE_STRING));
	
	//validasi apakah kosong atau tidak?
	if ( empty(trim($var_name)) || empty(trim($var_username)) || empty(trim($var_password)) || empty(trim($var_role)) ) {
		header('location: register.php?e=404');
		die();
	}
	
	//fungsi php yang digunakan untuk hashing kata sandi (keamanan)
	$var_password = password_hash($var_password, PASSWORD_BCRYPT);
	
	//sintaks sql untuk input data baru
	$var_sql_operator = "
		INSERT INTO operator(op_username, op_password, op_name, level_id)
		VALUE ('{$var_username}', '{$var_password}', '{$var_name}', '{$var_role}')
	";
	
	//eksekusi sintaks sql
	$var_query_operator = mysqli_query($var_con, $var_sql_operator);
	
	//percabangan apabila hasil eksekusi sintaks true maka tampilkan notif berhasil
	//jika tidak tampilkan notif gagal dan penyebabnya
	if ($var_query_operator) {
		
		mysqli_close($var_con);

		header('location: register.php?e=200');
		die();
	} else {
		echo "Galat! Tidak bisa input: " . mysqli_error($var_con);
	}
}

?>

<?php require_once 'template/header.php' ?>

<div class="header">
	<header><h2>REGISTER</h2></header>
</div>
		
<div class="notification">
	<p>
		<?php $var_notif = isset($_GET['e']) ? $_GET['e'] : "" ?>
		<?php switch($var_notif) : case '404' : ?>
			Data tidak temukan.
		<?php break; ?>
			
		<?php case '200' : ?>
			Data berhasil ditambahkan.
		<?php break; ?>
		<?php endswitch; ?>
	</p>
</div>
		
<div class="wrapper">
	<section id="login">
		<form method="post" action="register.php">
			<div class="form-group">
				<label for="frm_name">Nama </label>
				<input type="text" name="frm_name" id="frm_name" placeholder="Nama lengkap..." autofocus>
			</div>
			<div class="form-group">
				<label for="frm_username">Nama pengguna </label>
				<input type="text" name="frm_username" id="frm_username" placeholder="Nama pengguna...">
			</div>
			<div class="form-group">
				<label for="frm_password">Kata sandi </label>
				<input type="password" name="frm_password" id="frm_password" placeholder="Kata sandi...">
			</div>
			<div class="form-group">
				<select name="frm_role">
					<option value="">--Pilih Level--</option>
					<?php 
						$var_sql_role = "
							SELECT level_id, level_name
							FROM level
						";
						
						$var_query_role = mysqli_query($var_con, $var_sql_role);
					?>
					<?php if (mysqli_num_rows($var_query_role)) : ?>
						<?php while($var_data_role = mysqli_fetch_array($var_query_role)) : ?>
							<option value="<?php echo $var_data_role['level_id'] ?>"><?php echo ucwords($var_data_role['level_name']) ?></option>
						<?php endwhile; ?>
					<?php endif; ?>
				</select>
			</div>
			<div class="form-group">
				<input type="submit" name="btn_register" value="-- Daftar --">
			</div>
		</form>
	</section>
	
	<section>
		<p> Sudah punya akun? <a href="login.php"> Login! </a></p>
	</section>
</div>

<?php require_once 'template/footer.php' ?>
