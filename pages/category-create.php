<?php
	require_once __DIR__ . '/../db/config.php';

	// if (!isset($_SESSION['userid'])) {
	// 	header('location: ../login.php?e=403');
	// 	die();
	// }
?>

<?php require_once __DIR__ . '/../template/header.php' ?>

<div class="header">
	<header><h2>TAMBAH KATEGORI:</h2></header>
</div>

<div class="notification">
	<p>
		<?php $var_notif = isset($_GET['e']) ? $_GET['e'] : "" ?>
		<?php switch($var_notif) : case '404' : ?>
			Nama kategori tidak boleh kosong.
		<?php break; ?>

		<?php case 'length' : ?>
			Panjang kategori minimal 6 karakter.
		<?php break; ?>

		<?php case 'same' : ?>
			Kategori sudah ada dalam bank data.
		<?php break; ?>

		<?php case '201' : ?>
			Data berhasil ditambah.
		<?php break; ?>

		<?php endswitch; ?>
	</p>
</div>

<div class="wrapper">
	<section id="login">
		<form method="post" action="category-list.php?act=create">
			<div class="form-group">
				<label for="frm_username">Nama Kategori </label>
				<input type="text" name="frm_categoryname" id="frm_categoryname" placeholder="Nama Kategori..." autofocus>
			</div>

			<div class="form-group">
				<input type="submit" name="btn_create" value="-- Simpan --">
			</div>
		</form>
	</section>
</div>

<?php require_once __DIR__ . '/../template/footer.php' ?>
