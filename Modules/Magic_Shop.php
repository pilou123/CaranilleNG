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
			if (empty($_POST['Buy']))
			{	
				$Town = htmlspecialchars(addslashes($_SESSION['Town_ID']));
				echo "$Magic_Shop_0<br />";
				echo '<table>';
		
					echo '<tr>';

						echo '<td>';
							echo "$Item_Shop_1";
						echo '</td>';

						echo '<td>';
							echo "$Item_Shop_2";
						echo '</td>';

						echo '<td>';
							echo "$Item_Shop_3";
						echo '</td>';
					
						echo '<td>';
							echo "$Item_Shop_4";
						echo '</td>';
					
						echo '<td>';
							echo "$Item_Shop_5";
						echo '</td>';

					echo '</tr>';
				
				$Magic_Query = $bdd->prepare("SELECT * FROM Caranille_Magics
				WHERE Magic_Town = ?");
				$Magic_Query->execute(array($Town));
				while ($Magic = $Magic_Query->fetch())
				{
					echo '<tr>';
				
						$Magic_ID = stripslashes($Magic['Magic_ID']);
						$Magic_Image = stripslashes($Magic['Magic_Image']);
						$Magic_Type = stripslashes($Magic['Magic_Type']);
					
						echo '<td>';
							echo "<img src=\"$Magic_Image\"><br />";
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Magic['Magic_Name']). '';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes(nl2br($Magic['Magic_Description'])). '';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Magic['Magic_Price']). '';
						echo '</td>';
					
						echo '<td>';
							echo '<form method="POST" action="Magic_Shop.php">';
							echo "<input type=\"hidden\" name=\"Magic_ID\" value=\"$Magic_ID\">";
							echo "<input type=\"submit\" name=\"Buy\" value=\"$Magic_Shop_6\">";
							echo '</form><br />';
						echo '</td>';
					
					echo '</tr>';
				}

				$Magic_Query->closeCursor();

				echo '</table>';
				if (empty($Magic_ID))
				{
					echo "$Magic_Shop_7";
				}
			}
			if (isset($_POST['Buy']))
			{
				$Magic_ID = htmlspecialchars(addslashes($_POST['Magic_ID']));
				$Town = htmlspecialchars(addslashes($_SESSION['Town_ID']));
				$Magic_Query = $bdd->prepare("SELECT * FROM Caranille_Magics
				WHERE Magic_ID= ?
				AND Magic_Town= ?");
				$Magic_Query->execute(array($Magic_ID, $Town));
				while ($Magic = $Magic_Query->fetch())
				{
					$_SESSION['Magic_ID'] = stripslashes($Magic['Magic_ID']);
					$_SESSION['Magic_Image'] = stripslashes($Magic['Magic_Image']);
					$_SESSION['Magic_Name'] = stripslashes($Magic['Magic_Name']);
					$_SESSION['Magic_Description'] = stripslashes(nl2br($Magic['Magic_Description']));
					$_SESSION['Magic_Effect'] = stripslashes($Magic['Magic_Effect']);
					$_SESSION['Magic_Price'] = stripslashes($Magic['Magic_Price']);
					$_SESSION['Magic_Type'] = stripslashes($Magic['Magic_Type']);
					$_SESSION['Magic_Town'] = stripslashes($Magic['Magic_Town']);
					$_SESSION['objet'] = 0;
					if ($_SESSION['Gold'] >= $_SESSION['Magic_Price'])
					{
						$Magic_ID = htmlspecialchars(addslashes($_SESSION['Magic_ID']));
						$verification_Magic_Quantitys = $bdd->prepare("SELECT * FROM Caranille_Inventory_Magics
						WHERE Inventory_Magic_Magic_ID= ?
						AND Inventory_Magic_Account_ID= ?");
						$verification_Magic_Quantitys->execute(array($Magic_ID, $ID));
						$Magic_Quantity = $verification_Magic_Quantitys->rowCount();
						if ($Magic_Quantity>=1)
						{
							echo "$Magic_Shop_8";
							echo "<form method=\"POST\" action=\"Magic_Shop.php\">";
							echo "<input type=\"submit\" name=\"Cancel\" value=\"$Magic_Shop_9\">";
							echo '</form>';
						}
						else
						{
							$Gold = htmlspecialchars(addslashes($_SESSION['Gold'])) - htmlspecialchars(addslashes($_SESSION['Magic_Price']));
							$Magic = htmlspecialchars(addslashes($_SESSION['Magic_Name']));
							$Magic_Effect = htmlspecialchars(addslashes($_SESSION['Magic_Effect']));
						
							$Add_Magic = $bdd->prepare("INSERT INTO Caranille_Inventory_Magics VALUES(:ID, :Magic_ID)");
							$Add_Magic->execute(array('ID'=> $ID, 'Magic_ID'=> $Magic_ID));
						
							$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Golds= :Gold WHERE Account_ID= :ID");
							$Update_Account->execute(array('Gold'=> $Gold, 'ID'=> $ID));
						
							echo "$Magic_Shop_10 $Magic<br /><br />";
							echo '<form method="POST" action="Magic_Shop.php">';
							echo "<input type=\"submit\" name=\"Cancel\" value=\"$Magic_Shop_9\">";
							echo '</form>';
						}
					}
					else
					{
						echo 'Vous n\'avez pas assez d\'argent';
						echo '<form method="POST" action="Magic_Shop.php">';
							echo "<input type=\"submit\" name=\"Cancel\" value=\"$Magic_Shop_9\">";
						echo '</form>';
					}
				}
				$Magic_Query->closeCursor();
			}
		}
		if ($_SESSION['Town'] == 0)
		{
			echo "$Magic_Shop_11";
		}
	}
	else
	{
		echo "$Magic_Shop_12";
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
