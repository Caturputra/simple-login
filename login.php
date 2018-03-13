<?php require_once 'template/header.php'; ?>

<div class="header">
	<header><h2>LOGIN</h2></header>
</div>

<div class="notification">
	<p>
		<?php $var_notif = isset($_GET['e']) ? $_GET['e'] : "" ?>
		<?php switch($var_notif) : case '404' : ?>
			Data tidak temukan.
		<?php break; ?>
		<?php case '403' : ?>
			Akses ditolak.
		<?php break; ?>
		<?php endswitch; ?>
	</p>
</div>
		
<div class="wrapper">
	<section id="login">
		<form method="post" action="login-check.php">
			<div class="form-group">
				<label for="frm_username">Nama pengguna </label>
				<input type="text" name="frm_username" id="frm_username" placeholder="Nama pengguna..." autofocus>
			</div>
			<div class="form-group">
				<label for="frm_password">Kata sandi </label>
				<input type="password" name="frm_password" id="frm_password" placeholder="Kata sandi...">
			</div>
			<div class="form-group">
				<input type="submit" name="btn_submit" value="-- Masuk --">
			</div>
		</form>
	</section>
	
	<section>
		<p> Belum punya akun? <a href="register.php"> Daftar! </a></p>
	</section>
</div>
		
<?php require_once 'template/footer.php'; ?>
