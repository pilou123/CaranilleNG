<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	if (empty($_POST['Delete']))
	{
		echo "$Delete_Account_0";
		echo '<form method="POST" action="Delete_Account.php"><br />';
		echo 'Pseudo<br /> <input type="text" name="Pseudo"><br /><br />';
		echo 'Mot de passe<br /> <input type="password" name="Password"><br /><br />';
		echo "<input type=\"submit\" name=\"Delete\" value=\"$Delete_Account_1\">";
		echo '</form>';
	}
	if (isset($_POST['Delete']))
	{
		$Pseudo = htmlspecialchars(addslashes($_POST['Pseudo']));
		$Password = md5(htmlspecialchars(addslashes($_POST['Password'])));

		$Delete_List_Query = $bdd->prepare("SELECT * FROM Caranille_Accounts WHERE Account_Pseudo= ? AND Account_Password= ?");
		$Delete_List_Query->execute(array($Pseudo, $Password));

		$Delete_List = $Delete_List_Query->fetch();
		if ($Delete_List >= 1)
		{
			$Delete_Account = $bdd->prepare("Message_List_Query FROM Caranille_Accounts WHERE Account_Pseudo= :Pseudo AND Account_Password= :Password");
			$Delete_Account->execute(array('Pseudo'=> $Pseudo, 'Password'=> $Password));

			echo "$Delete_Account_2";
		}
		else
		{
			echo "$Delete_Account_3";
		}
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
