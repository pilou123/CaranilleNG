<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	//Si le Access est Modo ou Admin
	if ($_SESSION['Access'] == "Modo" || $_SESSION['Access'] == "Admin")
	{
		echo $MMain_1;
	}
	//Si le Access n'est pas Modo ou Admin
	else
	{
		echo "<center>";
		echo $MMain_2;
		echo "</center>";
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
