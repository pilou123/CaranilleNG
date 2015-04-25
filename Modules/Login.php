<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();
	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	if (empty($_POST['Login']))
	{
		echo "$Login_0<br /><br />";
		echo '<form method="POST" action="Login.php"><br />';
		echo "$Login_1<br /> <input type=\"text\" name=\"Pseudo\"><br /><br />";
		echo "$Login_2<br /> <input type=\"password\" name=\"Password\"><br /><br />";
		echo "<input type=\"submit\" name=\"Login\" value=\"$Login_3\">";
		echo '</form>';
	}
	if (isset($_POST['Login']))
	{
		$Pseudo = htmlspecialchars(addslashes($_POST['Pseudo']));
		$Password =  md5(htmlspecialchars(addslashes($_POST['Password'])));
		
		$_SESSION['Account_Data'] = SQL_Account_Data($Account_Pseudo, $Account_Password);
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
