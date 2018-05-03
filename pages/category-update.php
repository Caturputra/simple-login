<?php
	require_once __DIR__ . '/../db/config.php';

	// if (!isset($_SESSION['userid'])) {
	// 	header('location: ../login.php?e=403');
	// 	die();
	// }

	$var_opid = isset($_GET['id']) ? $_GET['id'] : "";
?>

<?php require_once __DIR__ . '/../template/header.php' ?>

<?php
	$var_sql_update = "
		SELECT c.category_id, c.category_name
		FROM category c
		WHERE c.category_id = '{$var_opid}'
		LIMIT 1
	";

	$var_query_update = mysqli_query($var_con, $var_sql_update);
	$var_data_update = mysqli_fetch_array($var_query_update);
?>

<div class="header">
	<header><h2>EDIT KATEGORI: <?php echo $var_data_update['category_name'] ?> </h2></header>
</div>

<div class="wrapper">
	<section id="login">
		<form method="post" action="category-list.php?act=update&amp;id=<?php echo $var_data_update['category_id'] ?>">
			<div class="form-group">
				<label for="frm_name">ID </label>
				<input type="text" name="frm_cid" id="frm_cid" placeholder="Kategori" readonly value="<?php echo $var_data_update['category_id'] ?>">
			</div>

			<div class="form-group">
				<label for="frm_username">Nama Kategori </label>
				<input type="text" name="frm_categoryname" id="frm_categoryname" placeholder="Nama Kategori..." value="<?php echo $var_data_update['category_name'] ?>">
			</div>

			<div class="form-group">
				<input type="submit" name="btn_update" value="-- Edit --">
			</div>
		</form>
	</section>
</div>

<?php require_once __DIR__ . '/../template/footer.php' ?>
