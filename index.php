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
	require_once("Kernel/Config/Server.php");

	$_SESSION['File_Root'] = $File_Root;
	$_SESSION['Link_Root'] = $Link_Root;

	$Link = 'http://' .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

	if ($Link != $_SESSION['Link_Root'])
	{
		$Link_Root = $_SESSION['Link_Root'];
		header("Location: $Link_Root/index.php");
	}
	else
	{
		require_once $_SESSION['File_Root']. '/Kernel/Include.php';
		header('Location: Modules/index.php');
	}
}
?>
