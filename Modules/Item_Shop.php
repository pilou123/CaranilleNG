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
				echo "$Item_Shop_0<br />";
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
					
						echo '<td>';
							echo "$Item_Shop_6";
						echo '</td>';

					echo '</tr>';
				
				$Item_Query = $bdd->prepare("SELECT * FROM Caranille_Items
				WHERE Item_Type = 'Health'
				AND Item_Town = ?");
				$Item_Query->execute(array($Town));
				while ($Item = $Item_Query->fetch())
				{
					echo '<tr>';
				
						$Item_Image = stripslashes($Item['Item_Image']);
						$Item_ID = stripslashes($Item['Item_ID']);
					
						echo '<td>';
							echo "<img src=\'$Item_Image\'><br />";
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Item['Item_Name']). '';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes(nl2br($Item['Item_Description'])). '';
						echo '</td>';
					
						echo '<td>';
							echo '+' .stripslashes($Item['Item_HP_Effect']). ' HP';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Item['Item_Purchase_Price']). '';
						echo '</td>';
					
						echo '<td>';
							echo '<form method="POST" action="Item_Shop.php">';
							echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Item_ID\">";
							echo "<input type=\"submit\" name=\"Buy\" value=\"$Item_Shop_7\">";
							echo '</form><br />';
						echo '</td>';
					
					echo '</tr>';
				}

				$Item_Query->closeCursor();

				if (empty($Item_ID))
				{
					echo "$Item_Shop_8<br /><br />";
				}
				$Item_Query = $bdd->prepare("SELECT * FROM Caranille_Items
				WHERE Item_Type = 'Magic'
				AND Item_Town = ?");
				$Item_Query->execute(array($Town));
				while ($Item = $Item_Query->fetch())
				{
					echo '<tr>';
				
						$Item_Image = stripslashes($Item['Item_Image']);
						$Item_ID = stripslashes($Item['Item_ID']);
					
						echo '<td>';
							echo "<img src=\'$Item_Image\'><br />";
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Item['Item_Name']). '';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes(nl2br($Item['Item_Description'])). '';
						echo '</td>';
					
						echo '<td>';
							echo '+' .stripslashes($Item['Item_MP_Effect']). ' MP';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Item['Item_Purchase_Price']). '';
						echo '</td>';
					
						echo '<td>';
							echo '<form method="POST" action="Item_Shop.php">';
							echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Item_ID\">";
							echo "<input type=\"submit\" name=\"Buy\" value=\"$Item_Shop_7\">";
							echo '</form><br />';
						echo '</td>';
					
					echo '</tr>';
				}
				$Item_Query->closeCursor();
				echo '</table><br /><br />';
				if (empty($Item_ID))
				{
					echo "$Item_Shop_9<br /><br />";
				}
				echo "$Item_Shop_10<br />";
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
					
						echo '<td>';
							echo "$Item_Shop_6";
						echo '</td>';

					echo '</tr>';
				
				$Item_Query = $bdd->prepare("SELECT * FROM Caranille_Items
				WHERE Item_Type = 'Parchment'
				AND Item_Town = ?");
				$Item_Query->execute(array($Town));
				while ($Item = $Item_Query->fetch())
				{
					echo '<tr>';
				
						$Item_Image = stripslashes($Item['Item_Image']);
						$Item_ID = stripslashes($Item['Item_ID']);
					
						echo '<td>';
							echo "<img src=\'$Item_Image\'><br />";
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Item['Item_Name']). '';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes(nl2br($Item['Item_Description'])). '';
						echo '</td>';
					
						echo '<td>';
							echo '+' .stripslashes($Item['Item_HP_Effect']). ' HP<br />';
							echo '+' .stripslashes($Item['Item_MP_Effect']). ' MP<br />';
							echo '+' .stripslashes($Item['Item_Strength_Effect']). ' Force<br />';
							echo '+' .stripslashes($Item['Item_Magic_Effect']). ' Magie<br />';
							echo '+' .stripslashes($Item['Item_Agility_Effect']). ' Agilité<br />';
							echo '+' .stripslashes($Item['Item_Defense_Effect']). ' Defense';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Item['Item_Purchase_Price']). '';
						echo '</td>';
					
						echo '<td>';
							echo '<form method="POST" action="Item_Shop.php">';
							echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Item_ID\">";
							echo "<input type=\"submit\" name=\"Buy\" value=\"$Item_Shop_7\">";
							echo '</form><br />';
						echo '</td>';
					
					echo '</tr>';
				}
				$Item_Query->closeCursor();
		    echo '</table>';
				if (empty($Item_ID))
				{
					echo "$Item_Shop_11<br /><br />";
				}
			}
			if (isset($_POST['Buy']))
			{
				$Item_ID = $_POST['Item_ID'];
				$Town = htmlspecialchars(addslashes($_SESSION['Town_ID']));
				$Item_Query = $bdd->prepare("SELECT * FROM Caranille_Items
				WHERE Item_ID= ?
				AND Item_Town= ?");
				$Item_Query->execute(array($Item_ID, $Town));
				while ($Item = $Item_Query->fetch())
				{
					$_SESSION['Item_ID'] = stripslashes($Item['Item_ID']);
					$_SESSION['Item_Image'] = stripslashes($Item['Item_Image']);
					$_SESSION['Item_Name'] = stripslashes($Item['Item_Name']);
					$_SESSION['Item_Description'] = stripslashes(nl2br($Item['Item_Description']));
					$_SESSION['Item_Price'] = stripslashes($Item['Item_Purchase_Price']);
					$_SESSION['Item_Type'] = stripslashes($Item['Item_Type']);
					$_SESSION['Item_Town'] = stripslashes($Item['Item_Town']);
					$_SESSION['Item'] = 0;
					if ($_SESSION['Gold'] >= $_SESSION['Item_Price'])
					{
						$Item_ID = htmlspecialchars(addslashes($_SESSION['Item_ID']));
						$Gold = htmlspecialchars(addslashes($_SESSION['Gold'])) - htmlspecialchars(addslashes($_SESSION['Item_Price']));
						$Item = htmlspecialchars(addslashes($_SESSION['Item_Name']));
					
						$Item_Quantity_Query = $bdd->prepare("SELECT * FROM Caranille_Inventory
						WHERE Inventory_Item_ID= ?
						AND Inventory_Account_ID= ?");
						$Item_Quantity_Query->execute(array($Item_ID, $ID));
					
						$Item_Quantity = $Item_Quantity_Query->rowCount();
						if ($Item_Quantity>=1)
						{
							$Add_Item = $bdd->prepare("UPDATE Caranille_Inventory SET Inventory_Item_Quantity = Inventory_Item_Quantity + 1
								WHERE Inventory_Item_ID= :Item_ID
								AND Inventory_Account_ID = :ID");
							$Add_Item->execute(array('Item_ID'=> $Item_ID, 'ID'=> $ID));
						
							$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Golds= :Gold WHERE Account_ID= :ID");
							$Update_Account->execute(array('Gold'=> $Gold, 'ID'=> $ID));
						}
						else
						{
							$Add_Item = $bdd->prepare("INSERT INTO Caranille_Inventory VALUES('', :ID, :Item_ID, '1', 'No')");
							$Add_Item->execute(array('ID'=> $ID, 'Item_ID'=> $Item_ID));
						
							$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Golds= :Gold WHERE Account_ID= :ID");
							$Update_Account->execute(array('Gold'=> $Gold, 'ID'=> $ID));
						}
						echo "$Item_Shop_12 $Item<br /><br />";
						echo '<form method="POST" action="Item_Shop.php">';
						echo "<input type=\"submit\" name=\"Cancel\" value=\"$Item_Shop_13\">";
						echo '</form>';
					}
					else
					{
						echo "$Item_Shop_14";
						echo '<form method="POST" action="Item_Shop.php">';
						echo "<input type=\"submit\" name=\"Cancel\" value=\"$Item_Shop_13\">";
						echo '</form>';
					}
				}
				$Item_Query->closeCursor();
			}
		}
		if ($_SESSION['Town'] == 0)
		{
			echo "$Item_Shop_15";
		}
	}
	else
	{
		echo "$Item_Shop_16";
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
