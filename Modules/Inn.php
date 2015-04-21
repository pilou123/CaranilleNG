<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	if (isset($_SESSION['ID']))
	{
		if ($_SESSION['Town'] == 1)
		{
			if (empty($_POST['Rest']))
			{
				echo "$Inn_0 " .$_SESSION['Town_Price_INN']. " $Inn_1";
				echo '<form method="POST" action="Inn.php">';
				echo "<input type=\"submit\" name=\"Rest\" value=\"$Inn_2\">";
				echo '</form>';
			}
			if (isset($_POST['Rest']))
			{
				if ($_SESSION['Gold'] >= $_SESSION['Town_Price_INN'])
				{
					echo $Inn_3;
					$Gold = htmlspecialchars(addslashes($_SESSION['Gold'])) - htmlspecialchars(addslashes($_SESSION['Town_Price_INN']));
					$HP_Total = htmlspecialchars(addslashes($_SESSION['HP_Total']));
					$MP_Total = htmlspecialchars(addslashes($_SESSION['MP_Total']));
					$Account_Update = $bdd->prepare("UPDATE Caranille_Accounts SET Account_HP_Remaining=:HP_Total, Account_MP_Remaining=:MP_Total, Account_Golds=:Gold WHERE Account_ID=:ID");
					$Account_Update->execute(array('HP_Total'=> $HP_Total, 'MP_Total'=> $MP_Total, 'Gold'=> $Gold, 'ID'=> $ID));
				
					echo '<form method="POST" action="Map.php">';
					echo "<input type=\"submit\" name=\"Inn\" value=\"$Inn_4\">";
					echo '</form>';
				}
				else
				{
					echo $Inn_5;
				}
			}
		}
		if ($_SESSION['Town'] == 0)
		{
			echo $Inn_6;
		}
	}
	else
	{
		echo $Inn_7;
	}	
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
