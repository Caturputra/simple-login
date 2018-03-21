<?php 
	require_once __DIR__ . '/../db/config.php'; 
	
	if (!isset($_SESSION['userid'])) {
		header('location: ../login.php?e=403');
		die();
	}
	
	$var_opid = isset($_GET['id']) ? $_GET['id'] : "";
?>

<?php require_once __DIR__ . '/../template/header.php' ?>
	
<?php 
	$var_sql_update = "
		SELECT o.op_id, o.op_username, o.op_password, o.level_id, l.level_name, o.op_name
		FROM operator o
		JOIN level l ON l.level_id = o.level_id
		WHERE o.op_id = '{$var_opid}'
		LIMIT 1
	";
	
	$var_query_update = mysqli_query($var_con, $var_sql_update);
	$var_data_update = mysqli_fetch_array($var_query_update);
?>
	
<div class="header">
	<header><h2>EDIT OPERATOR: <?php echo $var_data_update['op_name'] ?> </h2></header>
</div>
		
<div class="wrapper">
	<section id="login">
		<form method="post" action="operator-list.php?act=update&amp;id=<?php echo $var_data_update['op_id'] ?>">
			<div class="form-group">
				<label for="frm_name">Nama </label>
				<input type="text" name="frm_name" id="frm_name" placeholder="Nama lengkap..." value="<?php echo $var_data_update['op_name'] ?>">
			</div>
			
			<div class="form-group">
				<label for="frm_username">Nama pengguna </label>
				<input type="text" name="frm_username" id="frm_username" placeholder="Nama pengguna..." value="<?php echo $var_data_update['op_username'] ?>">
			</div>
			
			<div class="form-group">
				<select name="frm_role">
					<option value="<?php echo $var_data_update['level_id'] ?>" selected><?php echo ucwords($var_data_update['level_name']) ?></option>
					<?php 
						$var_sql_role = "
							SELECT level_id, level_name
							FROM level
							WHERE level_id != '{$var_data_update['level_id']}'
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
				<input type="submit" name="btn_update" value="-- Edit --">
			</div>
		</form>
	</section>
</div>

<?php require_once __DIR__ . '/../template/footer.php' ?>
