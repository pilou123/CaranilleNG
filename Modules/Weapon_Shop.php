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
				echo "$Weapon_Shop_0<br />";
				echo '<table>';
		
					echo '<tr>';

						echo '<td>';
							echo "$Weapon_Shop_1";
						echo '</td>';
					
						echo '<td>';
							echo "$Weapon_Shop_2";
						echo '</td>';

						echo '<td>';
							echo "$Weapon_Shop_3";
						echo '</td>';

						echo '<td>';
							echo "$Weapon_Shop_4";
						echo '</td>';
					
						echo '<td>';
							echo "$Weapon_Shop_5";
						echo '</td>';
					
						echo '<td>';
							echo "$Weapon_Shop_6";
						echo '</td>';
					
						echo '<td>';
							echo "$Weapon_Shop_7";
						echo '</td>';

					echo '</tr>';
				
				$Weapon_Query = $bdd->prepare("SELECT * FROM Caranille_Items
				WHERE Item_Type = 'Weapon'
				AND Item_Town = ?");
				$Weapon_Query->execute(array($Town));
				while ($Weapon = $Weapon_Query->fetch())
				{
					echo '<tr>';
				
						$image_Weapon = stripslashes($Weapon['Item_Image']);
						$Weapon_ID = stripslashes($Weapon['Item_ID']);
					
						echo '<td>';
							echo "<img src=\"$image_Weapon\"><br />";
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Weapon['Item_Level_Required']). '';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Weapon['Item_Name']). '';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes(nl2br($Weapon['Item_Description'])). '';
						echo '</td>';
					
						echo '<td>';
							echo '+' .stripslashes($Weapon['Item_HP_Effect']). " $Weapon_Shop_8<br />";
							echo '+' .stripslashes($Weapon['Item_MP_Effect']). " $Weapon_Shop_9<br />";
							echo '+' .stripslashes($Weapon['Item_Strength_Effect']). " $Weapon_Shop_10<br />";
							echo '+' .stripslashes($Weapon['Item_Magic_Effect']). " $Weapon_Shop_11<br />";
							echo '+' .stripslashes($Weapon['Item_Agility_Effect']). " $Weapon_Shop_12<br />";
							echo '+' .stripslashes($Weapon['Item_Defense_Effect']). " $Weapon_Shop_13";
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Weapon['Item_Purchase_Price']). '';
						echo '</td>';
					
						echo '<td>';
							echo '<form method="POST" action="Weapon_Shop.php">';
							echo "<input type=\"hidden\" name=\"Weapon_ID\" value=\"$Weapon_ID\">";
							echo "<input type=\"submit\" name=\"Buy\" value=\"$Weapon_Shop_14\">";
							echo '</form><br />';
						echo '</td>';
					
					echo '</tr>';
				}

				$Weapon_Query->closeCursor();

				echo '</table>';
				if (empty($Weapon_ID))
				{
					echo "$Weapon_Shop_15";
				}
			}
			if (isset($_POST['Buy']))
			{
				$Weapon_ID = htmlspecialchars(addslashes($_POST['Weapon_ID']));
				$Town = htmlspecialchars(addslashes($_SESSION['Town_ID']));
				$Weapon_Query = $bdd->prepare("SELECT * FROM Caranille_Items
				WHERE Item_ID= ?
				AND Item_Town= ?");
				$Weapon_Query->execute(array($Weapon_ID, $Town));
				while ($Weapon = $Weapon_Query->fetch())
				{
					$_SESSION['Weapon_ID'] = stripslashes($Weapon['Item_ID']);
					$_SESSION['Weapon_Image'] = stripslashes($Weapon['Item_Image']);
					$_SESSION['Weapon_Name'] = stripslashes($Weapon['Item_Name']);
					$_SESSION['Weapon_Description'] = stripslashes(nl2br($Weapon['Item_Description']));
					$_SESSION['Weapon_Price'] = stripslashes($Weapon['Item_Purchase_Price']);
					$_SESSION['Weapon_Type'] = stripslashes($Weapon['Item_Type']);
					$_SESSION['Weapon_Town'] = stripslashes($Weapon['Item_Town']);
					$_SESSION['Item'] = 0;
				
					if ($_SESSION['Gold'] >= $_SESSION['Weapon_Price'])
					{
						$Weapon_ID = htmlspecialchars(addslashes($_SESSION['Weapon_ID']));
						$Gold = htmlspecialchars(addslashes($_SESSION['Gold'])) - htmlspecialchars(addslashes($_SESSION['Weapon_Price']));
						$Weapon = htmlspecialchars(addslashes($_SESSION['Weapon_Name']));
						$Weapon_Effect = htmlspecialchars(addslashes($_SESSION['Weapon_Effect']));
					
						$Item_Quantity_Query = $bdd->prepare("SELECT * FROM Caranille_Inventory
						WHERE Inventory_Item_ID= ?
						AND Inventory_Account_ID= ?");
						$Item_Quantity_Query->execute(array($Weapon_ID, $ID));
					
						$Item_Quantity = $Item_Quantity_Query->rowCount();
						if ($Item_Quantity>=1)
						{
							$Add_Item = $bdd->prepare("UPDATE Caranille_Inventory SET Inventory_Item_Quantity = Inventory_Item_Quantity + 1
								WHERE Inventory_Item_ID= :Weapon_ID
								AND Inventory_Account_ID = :ID");
							$Add_Item->execute(array('Weapon_ID'=> $Weapon_ID, 'ID'=> $ID));
						
							$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Golds= :Gold WHERE Account_ID= :ID");
							$Update_Account->execute(array('Gold'=> $Gold, 'ID'=> $ID));
						}
						else
						{
							$Add_Item = $bdd->prepare("INSERT INTO Caranille_Inventory VALUES('', :ID, :Weapon_ID, '1', 'No')");
							$Add_Item->execute(array('ID'=> $ID, 'Weapon_ID'=> $Weapon_ID));
						
							$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Golds= :Gold WHERE Account_ID= :ID");
							$Update_Account->execute(array('Gold'=> $Gold, 'ID'=> $ID));
						}
						echo "$Weapon_Shop_16 $Weapon<br /><br />";
						echo '<form method="POST" action="Weapon_Shop.php">';
						echo "<input type=\"submit\" name=\"Cancel\" value=\"$Weapon_Shop_17\">";
						echo '</form>';
					}
					else
					{
						echo "$Weapon_Shop_18";
					}
				}
				$Weapon_Query->closeCursor();
			}
		}
		if ($_SESSION['Town'] == 0)
		{
			echo "$Weapon_Shop_19";
		}
	}
	else
	{
		echo "$Weapon_Shop_20";
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
