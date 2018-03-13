<?php 
	session_start();
	
	if (!isset($_SESSION['userid'])) {
		header('location: ../login.php?e=403');
	die();
}
?>
INI HOME ADMIN

<a href="../logout.php">Logout</a>

<?php require_once __DIR__ . '/../template/sidebar.php'; ?>
