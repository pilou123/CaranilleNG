<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';

	echo "$Logout_0<br /><br />";
	?>
	
	<a href="<?php echo $_SESSION['Link_Root'] ."/Modules/Main.php"; ?>"><?php echo $Logout_1; ?></a><br />

	<?php
	session_destroy();
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>