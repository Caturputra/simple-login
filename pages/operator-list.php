<?php 
	require_once __DIR__ . '/../db/config.php';
	
	if (!isset($_SESSION['userid'])) {
		header('location: ../login.php?e=403');
		die();
	}
	
	$var_action = isset($_GET['act']) ? $_GET['act'] : "";
	$var_opid = isset($_GET['id']) ? $_GET['id'] : "";
	
	switch($var_action) {
		case 'update' :
		
		if (isset($_POST['btn_update'])) {
			$var_name = mysqli_escape_string($var_con, filter_var($_POST['frm_name'], FILTER_SANITIZE_STRING));
			$var_username = mysqli_escape_string($var_con, filter_var($_POST['frm_username'], FILTER_SANITIZE_STRING));
			$var_role = mysqli_escape_string($var_con, filter_var($_POST['frm_role'], FILTER_SANITIZE_STRING));
	
			if ( empty(trim($var_name)) || empty(trim($var_username)) || empty(trim($var_role)) ) {
				header('location: operator-list.php?e=404');
				die();
			}
	
			$var_sql_operator = "
				UPDATE operator SET op_username = '{$var_username}', level_id = '{$var_role}', op_username = '{$var_username}'
				WHERE op_id = '{$var_opid}'
			";
			$var_query_operator = mysqli_query($var_con, $var_sql_operator);
	
			if ($var_query_operator) {
				header('location: operator-list.php?e=201');
				die();
			} else {
				echo "Galat! Tidak bisa input: " . mysqli_error($var_con);
			}
		}

		break;
		
		case 'delete' :
			$var_sql_delete = "
				DELETE FROM operator WHERE op_id = '{$var_opid}'
			";
			$var_query_delete = mysqli_query($var_con, $var_sql_delete);
			
			if (mysqli_affected_rows($var_con)) {
				header('location: operator-list.php?e=200');
				die();
			}
		break;
	}

?>

<?php require_once __DIR__ . '/../template/header.php' ?>

<div class="header">
	<header><h2>DAFTAR OPERATOR</h2><span><a href="home-<?php echo $_SESSION['levelname'] ?>.php">Kembali</a></span></header>
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
				
		<?php endswitch; ?>
	</p>
</div>
		
<div class="wrapper">
	<section>
		<table border='1'>
			<thead>
				<tr>
					<th>No.</th>
					<th>Nama</th>
					<th>Nama Pengguna</th>
					<th>Level</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
					$var_sql_list = "
						SELECT o.op_id, o.op_name, o.op_username, l.level_name
						FROM operator o
						JOIN level l ON l.level_id = o.level_id
					";
					$var_query_list = mysqli_query($var_con, $var_sql_list);
					$no = 1;
				?>
				<?php if(mysqli_num_rows($var_query_list) > 0) :?>
					<?php while($var_data_list = mysqli_fetch_array($var_query_list)) : ?>
						<tr>
							<td><?php echo $no++ ?></td>
							<td><?php echo $var_data_list['op_name'] ?></td>
							<td><?php echo $var_data_list['op_username'] ?></td>
							<td><?php echo $var_data_list['level_name'] ?></td>
							<td>
								<a href="operator-update.php?id=<?php echo $var_data_list['op_id'] ?>"> Edit</a> | 
								<a href="operator-list.php?act=delete&amp;id=<?php echo $var_data_list['op_id'] ?>"> Hapus</a>
							</td>
						</tr>
					<?php endwhile; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</section>
</div>

<?php require_once __DIR__ . '/../template/footer.php' ?>
