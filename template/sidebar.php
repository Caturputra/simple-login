<?php
require_once __DIR__ . '/../db/config.php';

$var_levelid = isset($_SESSION['levelid']) ? filter_var($_SESSION['levelid'], FILTER_SANITIZE_NUMBER_INT) : "";

$var_sql_menu = "
	SELECT m.menu_name, m.menu_url
	FROM level_menu lm 
	JOIN menu m ON m.menu_id = lm.menu_id
	WHERE lm.level_id = '{$var_levelid}'
";

$var_query_menu = mysqli_query($var_con, $var_sql_menu);
?>

<?php while($var_data_menu = mysqli_fetch_array($var_query_menu)) : ?>
	<br><a href="<?php echo $var_data_menu['menu_url'] ?>"><?php echo ucwords($var_data_menu['menu_name']) ?></a>
<?php endwhile; ?>

