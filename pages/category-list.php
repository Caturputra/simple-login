<?php
	require_once __DIR__ . '/../db/config.php';

	if (!isset($_SESSION['userid'])) {
		header('location: ../login.php?e=403');
		die();
	}

	$var_action = isset($_GET['act']) ? $_GET['act'] : "";
	$var_cid = isset($_GET['id']) ? $_GET['id'] : "";

	switch($var_action) {
		case 'create' :
		if (isset($_POST['btn_create'])) {
			$var_categoryname = mysqli_escape_string($var_con, filter_var($_POST['frm_categoryname'], FILTER_SANITIZE_STRING));

			if ( empty(trim($var_categoryname)) ) {
				header('location: category-create.php?e=404');
				die();
			}

			if ( strlen($var_categoryname) < '7' ) {
				header('location: category-create.php?e=length');
				die();
			}

			$var_sql_same = "
			SELECT category_name FROM category WHERE category_name = '{$var_categoryname}' LIMIT 1
			";
			$var_query_same = mysqli_query($var_con, $var_sql_same);
			$var_data_same = mysqli_fetch_row($var_query_same);

			if ($var_categoryname == $var_data_same[0]) {
				header('location: category-create.php?e=same');
				die();
			}

			$var_sql_insert = "
			INSERT INTO category(category_name) VALUES('{$var_categoryname}')
			";
			$var_query_insert = mysqli_query($var_con, $var_sql_insert);

			if ($var_query_insert) {
				header('location: category-list.php?e=202');
				die();
			}
		}
		break;

		case 'update' :

		if (isset($_POST['btn_update'])) {
			$var_cid = mysqli_escape_string($var_con, filter_var($_POST['frm_cid'], FILTER_SANITIZE_STRING));
			$var_categoryname = mysqli_escape_string($var_con, filter_var($_POST['frm_categoryname'], FILTER_SANITIZE_STRING));

			if ( empty(trim($var_categoryname)) ) {
				header('location: category-list.php?e=404');
				die();
			}

			$var_sql_operator = "
				UPDATE category SET category_name = '{$var_categoryname}'
				WHERE category_id = '{$var_cid}'
			";
			$var_query_operator = mysqli_query($var_con, $var_sql_operator);

			if ($var_query_operator) {
				header('location: category-list.php?e=201');
				die();
			} else {
				echo "Galat! Tidak bisa edit: " . mysqli_error($var_con);
			}
		}

		break;

		case 'delete' :
			$var_sql_delete = "
				DELETE FROM category WHERE category_id = '{$var_cid}'
			";
			$var_query_delete = mysqli_query($var_con, $var_sql_delete);

			if (mysqli_affected_rows($var_con)) {
				header('location: category-list.php?e=200');
				die();
			}
		break;
	}

?>

<?php require_once __DIR__ . '/../template/header.php' ?>

<div class="header">
	<header><h2>DAFTAR CATEGORY</h2><span><a href="home-<?php echo $_SESSION['levelname'] ?>.php">Kembali</a></span></header>
</div>

<div class="notification">
	<p>
		<?php $var_notif = isset($_GET['e']) ? $_GET['e'] : "" ?>
		<?php switch($var_notif) : case '404' : ?>
			Data tidak temukan.
		<?php break; ?>

		<?php case '200' : ?>
			Data berhasil dihapus.
		<?php break; ?>

		<?php case '201' : ?>
			Data berhasil diedit.
		<?php break; ?>

		<?php case '202' : ?>
			Data berhasil ditambah.
		<?php break; ?>

		<?php endswitch; ?>
	</p>
</div>

<div class="wrapper">
	<section>
		<a href="category-create.php">Tambah Kategori</a>
		<br><br>
		<table border='1'>
			<thead>
				<tr>
					<th>No.</th>
					<th>ID</th>
					<th>Nama Kategori</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$var_sql_list = "
						SELECT c.category_id, c.category_name
						FROM category c
					";
					$var_query_list = mysqli_query($var_con, $var_sql_list);
					$no = 1;
				?>
				<?php if($var_num_rows = mysqli_num_rows($var_query_list) > 0) :?>
					<?php while($var_data_list = mysqli_fetch_array($var_query_list)) : ?>
						<?php
						$var_rowcolor = "";

						if ($var_num_rows % 2) {
							$var_rowcolor = "#d2d2d2";
						} else {
							$var_rowcolor = "#r4r3w2";
						}
						?>
						<tr bgcolor="<?= $var_rowcolor ?>">
							<td><?php echo $no++ ?></td>
							<td><?php echo $var_data_list['category_id'] ?></td>
							<td><?php echo $var_data_list['category_name'] ?></td>
							<td>
								<a href="category-update.php?id=<?php echo $var_data_list['category_id'] ?>"> Edit</a> |
								<a href="category-list.php?act=delete&amp;id=<?php echo $var_data_list['category_id'] ?>"> Hapus</a>
							</td>
						</tr>
					<?php endwhile; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</section>
</div>

<?php require_once __DIR__ . '/../template/footer.php' ?>
