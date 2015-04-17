<?php
session_start();
$Config = 'Kernel/Config/SQL.php';
$Size = filesize($Config); 
if ($Size == 0) 
{
	header('Location: install.php');
}
else
{
	//IF THE $_SESSION['File_Root'] AS EMPTY WE CREATE THE SESSION WITH THE ABSOLUT PATH
	if (empty($_SESSION['File_Root']) && empty($_SESSION['Link_Root']))
	{
		require_once("Kernel/Config/Server.php");
		$_SESSION['File_Root'] = $File_Root;
		$_SESSION['Link_Root'] = $Link_Root;
		require_once $_SESSION['File_Root']. '/Kernel/Include.php';
		header('Location: Modules/index.php');
	}
	else
	{
		require_once $_SESSION['File_Root']. '/Kernel/Include.php';
		header('Location: Modules/index.php');
	}
}
?>
