<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	if (isset($_SESSION['ID']))
	{
		echo "$Top_0";
		echo '<table>';

				echo '<td>';
				echo "$Top_1";
				echo '</td>';

				echo '<td>';
				echo "$Top_2";
				echo '</td>';
			
			echo '</tr>';
	
		$Account_Query = $bdd->prepare("SELECT * FROM Caranille_Accounts, Caranille_Levels
		WHERE Account_Level = Level_Number
		ORDER BY Account_Level DESC
		LIMIT 0, 99");
		$Account_Query->execute(array($Order_ID));
		while ($Account = $Account_Query->fetch())
		{
			$Account_ID = stripslashes($Account['Account_ID']);
	
			echo '<tr>';

				echo '<td>';
				 echo '' .stripslashes($Account['Account_Level']). ''; 
				echo '</td>';

				echo '<td>';
				 echo '' .stripslashes($Account['Account_Pseudo']). ''; 
				echo '</td>';
				
			echo '</tr>';
		}
		$Account_Query->closeCursor();

		echo '</table>';
	}
	else
	{
		echo "$Top_3";
	}	
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
