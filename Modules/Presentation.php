<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	$recherche_presentation = $bdd->query("SELECT * FROM Caranille_Configuration");
	while ($presentation = $recherche_presentation->fetch())
	{
		echo stripslashes(nl2br($presentation['Configuration_Presentation']));
	}
		
	$recherche_presentation->closeCursor();
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
