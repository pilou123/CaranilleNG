<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	$ID = htmlspecialchars(addslashes($_SESSION['ID']));
	if (isset($_SESSION['ID']))
	{
		//Si le joueur est dans une ville, on regarde si il est actuellement en combat
		if ($_SESSION['Battle'] == 1)
		{
			//Si attaquer et fuir n'ont pas été choisir on affiche le menu de combat
			if (empty($_POST['Attack']) && empty($_POST['Magics']) && empty($_POST['End_Magics']) && empty($_POST['Invocations']) && empty($_POST['End_Invocations']) && empty($_POST['Items']) && empty($_POST['End_Items']) && (empty($_POST['Escape'])))
			{
				//Si la HP du monstre est supérieur à 0 et que la HP du personnage est supérieur à zero le combat commence ou continue
				if ($_SESSION['Monster_HP'] > 0 && $_SESSION['HP'] > 0)
				{
					$Monster_Image = $_SESSION['Monster_Image'];
					echo "<img src=\"$Monster_Image\"><br />";
					echo "$Battle_0 " .htmlspecialchars(addslashes($_SESSION['Monster_Name'])). " $Battle_1 " .htmlspecialchars(addslashes($_SESSION['Pseudo'])). "<br /><br />";
					echo "$Battle_2 " .htmlspecialchars(addslashes($_SESSION['Monster_Name'])). " " .htmlspecialchars(addslashes($_SESSION['Monster_HP'])). " HP<br />";
					echo "$Battle_3 " .htmlspecialchars(addslashes($_SESSION['HP'])). " $Battle_4<br /><br />";
					echo '<form method="POST" action="Battle.php">';
					echo "<input type=\"submit\" name=\"Attack\" value=\"$Battle_5\"><br />";
					echo '</form>';
					echo '<form method="POST" action="Battle.php">';
					echo "<input type=\"submit\" name=\"Magics\" value=\"$Battle_6\"><br />";
					echo '</form>';
					echo '<form method="POST" action="Battle.php">';
					echo "<input type=\"submit\" name=\"Invocations\" value=\"$Battle_7\"><br />";
					echo '</form>';
					echo '<form method="POST" action="Battle.php">';
					echo "<input type=\"submit\" name=\"Items\" value=\"$Battle_8\"><br />";
					echo '</form>';
					echo '<form method="POST" action="Battle.php">';
					echo "<input type=\"submit\" name=\"Escape\" value=\"$Battle_9\"><br />";
					echo '</form>';
				}
			}
			//Si l'utilisateur à choisit attaquer
			if (isset($_POST['Attack']))
			{
				$MIN_Strength = htmlspecialchars(addslashes($_SESSION['Strength_Total'])) / 1.1;
				$MAX_Strength = htmlspecialchars(addslashes($_SESSION['Strength_Total'])) * 1.1;
				$MIN_Defense = htmlspecialchars(addslashes($_SESSION['Defense_Total'])) / 1.1;
				$MAX_Defense = htmlspecialchars(addslashes($_SESSION['Defense_Total'])) * 1.1;

				$Monster_MIN_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) / 1.1;
				$Monster_MAX_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) * 1.1;
				$Monster_MIN_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) / 1.1;
				$Monster_MAX_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) * 1.1;

				$Positive_Damage_Player = mt_rand($MIN_Strength, $MAX_Strength);
				$Negative_Damage_Player = mt_rand($Monster_MIN_Defense, $Monster_MAX_Defense);
				$Total_Damage_Player = htmlspecialchars(addslashes($Positive_Damage_Player)) - htmlspecialchars(addslashes($Negative_Damage_Player));

				$Monster_Positive_Damage = mt_rand($Monster_MIN_Strength, $Monster_MAX_Strength);
				$Monster_Negative_Damage = mt_rand($MIN_Defense, $MAX_Defense);
				$Total_Damage_Monster = htmlspecialchars(addslashes($Monster_Positive_Damage)) - htmlspecialchars(addslashes($Monster_Negative_Damage));
				//Si les dégats du joueurs ou du monstre sont égal ou inférieur à zero
				if ($Total_Damage_Monster <=0)	
				{
					$Total_Damage_Monster = 0;
				}
				if ($Total_Damage_Player <=0)
				{
					$Total_Damage_Player = 0;
				}
				$_SESSION['Monster_HP'] = htmlspecialchars(addslashes($_SESSION['Monster_HP'])) - htmlspecialchars(addslashes($Total_Damage_Player));
				$Remaining_HP = htmlspecialchars(addslashes($_SESSION['HP'])) - htmlspecialchars(addslashes($Total_Damage_Monster));
				$Monster_Image = htmlspecialchars(addslashes($_SESSION['Monster_Image']));
				echo "<img src=\"$Monster_Image\"><br />";
				echo "$Battle_10 $Total_Damage_Player<br /><br />";
				echo "$Battle_11 $Total_Damage_Monster<br /><br />";

				$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_HP_Remaining= :Remaining_HP WHERE Account_ID= :ID");
				$Update_Account->execute(array('Remaining_HP'=> $Remaining_HP, 'ID'=> $ID));

				echo '<form method="POST" action="Battle.php">';
				echo "<input type=\"submit\" name=\"Continue\" value=\"$Battle_12\">";
				echo '</form>';
				
			}
			if (isset($_POST['Magics']))
			{
				echo '<form method="POST" action="Battle.php">';
				echo "$Battle_13<br /><br />";
				echo '<select name="Magic" ID="Magic">';
	
				$List_Query_Magics = $bdd->prepare("SELECT * FROM Caranille_Inventory_Magics, Caranille_Magics 
				WHERE Inventory_Magic_Magic_ID = Magic_ID
				AND Inventory_Magic_Account_ID = ?
				ORDER BY Magic_Name ASC");
				$List_Query_Magics->execute(array($ID));

				while ($List_Magics = $List_Query_Magics->fetch())
				{
					$Magic_MP_Cost = stripslashes($List_Magics['Magic_MP_Cost']);
					$Magic_Description = stripslashes($List_Magics['Magic_Description']);
					$Magic = stripslashes($List_Magics['Magic_Name']);
					echo "<option value=\"$Magic\">$Magic ($Magic_Description, $Magic_MP_Cost MP)</option>";
					echo "<br />$Battle_14: $Magic_Description<br /><br />";
				}
				$List_Query_Magics->closeCursor();

				
				echo '</select><br /><br />';
				echo "<input type=\"hidden\" name=\"Magic_MP_Cost\" value=\"$Magic_MP_Cost\">";
				echo "<input type=\"submit\" name=\"End_Magics\" value=\"$Battle_15\">";
				echo '</form>';
				echo '<form method="POST" action="Battle.php">';
				echo "<input type=\"submit\" name=\"Cancel\" value=\"$Battle_16\"><br />";
				echo '</form>';
			}
			if (isset($_POST['End_Magics']))
			{
				$Magic_Choice = htmlspecialchars(addslashes($_POST['Magic']));
				$Magic_MP_Cost = htmlspecialchars(addslashes($_POST['Magic_MP_Cost']));
				
				if ($_SESSION['MP'] >= $Magic_MP_Cost)
				{
					$Magics_List_Query = $bdd->prepare("SELECT * FROM Caranille_Inventory_Magics, Caranille_Magics 
					WHERE Inventory_Magic_Magic_ID = Magic_ID
					AND Inventory_Magic_Account_ID = ?
					AND Magic_Name = ?");
					$Magics_List_Query->execute(array($ID, $Magic_Choice));
					
					while ($Magic_List = $Magics_List_Query->fetch())
					{
						$Magic_MP_Cost = stripslashes($Magic_List['Magic_MP_Cost']);
						$Magic_Effect = stripslashes($Magic_List['Magic_Effect']);
						$Magic_Name = stripslashes($Magic_List['Magic_Name']);
						$Magic_Type = stripslashes($Magic_List['Magic_Type']);
					}

					$Magics_List_Query->closeCursor();

					if ($Magic_Type == "Attack")
					{
						$MIN_Magic = htmlspecialchars(addslashes($_SESSION['Magic_Total'])) / 1.1;
						$MAX_Magic = htmlspecialchars(addslashes($_SESSION['Magic_Total'])) * 1.1;
						$MIN_Defense = htmlspecialchars(addslashes($_SESSION['Defense_Total'])) / 1.1;
						$MAX_Defense = htmlspecialchars(addslashes($_SESSION['Defense_Total'])) * 1.1;

						$Monster_MIN_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) / 1.1;
						$Monster_MAX_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) * 1.1;
						$Monster_MIN_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) / 1.1;
						$Monster_MAX_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) * 1.1;

						$Positive_Magic_Damage_Player = mt_rand($MIN_Magic, $MAX_Magic) + $Magic_Effect;
						$Negative_Magic_Damage_Player = mt_rand($Monster_MIN_Defense, $Monster_MAX_Defense);
						$Player_Total_Magic_Damage = htmlspecialchars(addslashes($Positive_Magic_Damage_Player)) - htmlspecialchars(addslashes($Negative_Magic_Damage_Player));
						
						$Monster_Positive_Damage = mt_rand($Monster_MIN_Strength, $Monster_MAX_Strength);
						$Monster_Negative_Damage = mt_rand($MIN_Defense, $MAX_Defense);
						$Total_Damage_Monster = htmlspecialchars(addslashes($Monster_Positive_Damage)) - htmlspecialchars(addslashes($Monster_Negative_Damage));
						//Si les dégats du joueurs ou du monstre sont égal ou inférieur à zero
						if ($Total_Damage_Monster <=0)	
						{
							$Total_Damage_Monster = 0;
						}
						if ($Player_Total_Magic_Damage <=0)
						{
							$Player_Total_Magic_Damage = 0;
						}
						$_SESSION['Monster_HP'] = htmlspecialchars(addslashes($_SESSION['Monster_HP'])) - htmlspecialchars(addslashes($Player_Total_Magic_Damage));
						$Remaining_HP = htmlspecialchars(addslashes($_SESSION['HP'])) - htmlspecialchars(addslashes($Total_Damage_Monster));
						$Remaining_MP = htmlspecialchars(addslashes($_SESSION['MP'])) - htmlspecialchars(addslashes($Magic_MP_Cost));
						$Monster_Image = htmlspecialchars(addslashes($_SESSION['Monster_Image']));
						echo "<img src=\"$Monster_Image\"><br />";
						echo "$Battle_17 $Player_Total_Magic_Damage<br /><br />";
						echo "$Battle_11 $Total_Damage_Monster HP<br /><br />";

						$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_HP_Remaining= :Remaining_HP , Account_MP_Remaining= :Remaining_MP WHERE Account_ID= :ID");
						$Update_Account->execute(array('Remaining_HP'=> $Remaining_HP, 'Remaining_MP'=> $Remaining_MP, 'ID'=> $ID));
						
						echo '<form method="POST" action="Battle.php">';
						echo "<input type=\"submit\" name=\"Continue\" value=\"$Battle_12\">";
						echo '</form>';
						
					}
					elseif ($Magic_Type == "Health")
					{
						$MIN_Magic = htmlspecialchars(addslashes($_SESSION['Magic'])) / 1.1;
						$MAX_Magic = htmlspecialchars(addslashes($_SESSION['Magic'])) * 1.1;
						$MIN_Defense = htmlspecialchars(addslashes($_SESSION['Defense'])) / 1.1;
						$MAX_Defense = htmlspecialchars(addslashes($_SESSION['Defense'])) * 1.1;

						$Monster_MIN_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) / 1.1;
						$Monster_MAX_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) * 1.1;
						$Monster_MIN_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) / 1.1;
						$Monster_MAX_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) * 1.1;

						$Player_Health = mt_rand($MIN_Magic, $MAX_Magic) + $Magic_Effect;

						$Monster_Positive_Damage = mt_rand($Monster_MIN_Strength, $Monster_MAX_Strength);
						$Monster_Negative_Damage = mt_rand($MIN_Defense, $MAX_Defense);
						$Total_Damage_Monster = htmlspecialchars(addslashes($Monster_Positive_Damage)) - htmlspecialchars(addslashes($Monster_Negative_Damage));
						//Si les dégats du monstre sont en dessous de 0, on applique 0 de dégat pour éviter de soigner le personnage
						if ($Total_Damage_Monster <=0)	
						{
							$Total_Damage_Monster = 0;
						}
						$Life_Difference = htmlspecialchars(addslashes($_SESSION['HP_Total'])) - htmlspecialchars(addslashes($_SESSION['HP']));
						if ($Player_Health >= $Life_Difference)
						{
							$_SESSION['HP'] = htmlspecialchars(addslashes($_SESSION['HP'])) + htmlspecialchars(addslashes($Life_Difference));
							$Player_Health = htmlspecialchars(addslashes($Player_Health));
						}
						else
						{
							$_SESSION['HP'] = htmlspecialchars(addslashes($_SESSION['HP'])) + htmlspecialchars(addslashes($Player_Health));
						}
						$Remaining_HP = htmlspecialchars(addslashes($_SESSION['HP'])) - htmlspecialchars(addslashes($Total_Damage_Monster));
						$Remaining_MP = htmlspecialchars(addslashes($_SESSION['MP'])) - htmlspecialchars(addslashes($Magic_MP_Cost));
						$Monster_Image = htmlspecialchars(addslashes($_SESSION['Monster_Image']));
						echo "<img src=\"$Monster_Image\"><br />";
						
						echo "$Battle_17 $Player_Health HP <br /><br />";
						echo "$Battle_11 $Total_Damage_Monster HP <br /><br />";

						$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_HP_Remaining= :Remaining_HP , Account_MP_Remaining= :Remaining_MP WHERE Account_ID= :ID");
						$Update_Account->execute(array('Remaining_HP'=> $Remaining_HP, 'Remaining_MP'=> $Remaining_MP, 'ID'=> $ID));
						
						echo '<form method="POST" action="Battle.php">';
						echo "<input type=\"submit\" name=\"Continue\" value=\"$Battle_12\">";
						echo '</form>';
					}
				}
				else
				{
					echo "$Battle_18";
					echo '<form method="POST" action="Battle.php">';
					echo "<input type=\"submit\" name=\"Continue\" value=\"$Battle_12\">";
					echo '</form>';
				}
			}
			if (isset($_POST['Invocations']))
			{
					$List_Query_Invocations = $bdd->prepare("SELECT * FROM Caranille_Inventory_Invocations, Caranille_Invocations 
					WHERE Inventory_Invocation_Invocation_ID = Invocation_ID
					AND Inventory_Invocation_Account_ID = ?
					ORDER BY Invocation_Name ASC");
					$List_Query_Invocations->execute(array($ID));

					$Quantity_Invocations = $List_Query_Invocations->rowCount();
					if ($Quantity_Invocations >=1)
					{
						echo '<form method="POST" action="Battle.php">';
						echo "$Battle_19<br /><br />";
						echo '<select name="Invocation" id="Invocation">';

						while ($Invocations_List = $List_Query_Invocations->fetch())
						{
							$Invocation = stripslashes($Invocations_List['Invocation_Name']);
							echo "<option value=\"$Invocation\">$Invocation</option>";
						}
						echo '</select>';
						echo "<br /><br />$Battle_20<br /><br />";
						echo '<input type="text" name="MP_Choice"><br /><br />';
						echo "<input type=\"submit\" name=\"End_Invocations\" value=\"$Battle_21\">";
						echo '</form>';
						
					}
					else
					{
						echo "$Battle_22";
					}
					$List_Query_Invocations->closeCursor();
					
					echo '<form method="POST" action="Battle.php">';
					echo "<input type=\"submit\" name=\"Cancel\" value=\"$Battle_16\"><br />";
					echo '</form>';
			}
			if (isset($_POST['End_Invocations']))
			{
				$Invocation_Choice = htmlspecialchars(addslashes($_POST['Invocation']));
				$MP_Choice = htmlspecialchars(addslashes($_POST['MP_Choice']));
				if ($_SESSION['MP'] >= $MP_Choice)
				{
					$Invocations_List_Query = $bdd->prepare("SELECT * FROM Caranille_Inventory_Invocations, Caranille_Invocations 
					WHERE Inventory_Invocation_Invocation_ID = Invocation_ID
					AND Inventory_Invocation_Account_ID = ?
					AND Invocation_Name = ?");
					$Invocations_List_Query->execute(array($ID, $Invocation_Choice));

					while ($Invocations_List = $Invocations_List_Query->fetch())
					{
						$Invocation_Damage = $Invocations_List['Invocation_Damage'];
					}
					$Invocations_List_Query->closeCursor();
					$MIN_Defense = htmlspecialchars(addslashes($_SESSION['Defense_Total'])) / 1.1;
					$MAX_Defense = htmlspecialchars(addslashes($_SESSION['Defense_Total'])) * 1.1;

					$Monster_MIN_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) / 1.1;
					$Monster_MAX_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) * 1.1;
					$Monster_MIN_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) / 1.1;
					$Monster_MAX_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) * 1.1;

					$Monster_Positive_Damage = mt_rand($Monster_MIN_Strength, $Monster_MAX_Strength);
					$Monster_Negative_Damage = mt_rand($MIN_Defense, $MAX_Defense);
					$Total_Damage_Monster = htmlspecialchars(addslashes($Monster_Positive_Damage)) - htmlspecialchars(addslashes($Monster_Negative_Damage));

					$Invocation_Total_Damage = htmlspecialchars(addslashes($Invocation_Damage)) * htmlspecialchars(addslashes($MP_Choice));
					//Si les dégats du monstre sont en dessous de 0, on applique 0 de dégat pour éviter de soigner le personnage
					if ($Total_Damage_Monster <=0)
					{
						$Total_Damage_Monster = 0;
					}
					$_SESSION['Monster_HP'] = htmlspecialchars(addslashes($_SESSION['Monster_HP'])) - htmlspecialchars(addslashes($Invocation_Total_Damage));
					$Remaining_HP = htmlspecialchars(addslashes($_SESSION['HP'])) - htmlspecialchars(addslashes($Total_Damage_Monster));
					$Remaining_MP = htmlspecialchars(addslashes($_SESSION['MP'])) - htmlspecialchars(addslashes($MP_Choice));
					$Monster_Image = htmlspecialchars(addslashes($_SESSION['Monster_Image']));
					echo "<img src=\"$Monster_Image\"><br />";
					echo "$Battle_23 $Invocation_Total_Damage HP<br /><br />";
					echo "$Battle_11 $Total_Damage_Monster HP <br /><br />";

					$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_HP_Remaining= :Remaining_HP , Account_MP_Remaining= :Remaining_MP WHERE Account_ID= :ID");
					$Update_Account->execute(array('Remaining_HP'=> $Remaining_HP, 'Remaining_MP'=> $Remaining_MP, 'ID'=> $ID));

					echo '<form method="POST" action="Battle.php">';
					echo "<input type=\"submit\" name=\"Continue\" value=\"$Battle_12\">";
					echo '</form>';
					
				}
				else
				{
					echo 'Vous n\'avez pas assez de MP';
					echo '<form method="POST" action="Battle.php">';
					echo "<input type=\"submit\" name=\"Continue\" value=\"$Battle_12\">";
					echo '</form>';
				}
			}
			if (isset($_POST['Items']))
			{
				$Items_Quantity_Query = $bdd->prepare("SELECT * FROM Caranille_Inventory, Caranille_Items
				WHERE Inventory_Item_ID = Item_ID
				AND Inventory_Account_ID = ?
				AND Item_Type = 'Health' OR 'Magic'
				ORDER BY Item_Name ASC");
				$Items_Quantity_Query->execute(array($ID));

				$Item_Quantity = $Items_Quantity_Query->rowCount();
				if ($Item_Quantity >=1)
				{
					echo '<form method="POST" action="Battle.php">';
					echo "$Battle_24<br /><br />";
					echo '<select name="Item" id="Item">';
					echo "<optgroup label=\"$Battle_25\">";
					
					$HP_Item_List = $bdd->prepare("SELECT * FROM Caranille_Inventory, Caranille_Items
					WHERE Inventory_Item_ID = Item_ID
					AND Item_Type = 'Health'
					AND Inventory_Account_ID = ?
					ORDER BY Item_Name ASC");
					$HP_Item_List->execute(array($ID));

					while ($Item_List = $HP_Item_List->fetch())
					{
						$Inventory_ID = stripslashes($Item_List['Inventory_ID']);
						$Item = stripslashes($Item_List['Item_Name']);
						$Item_Quantity = stripslashes($Item_List['Item_Quantity']);
						$Item_HP_Effect = stripslashes($Item_List['Item_HP_Effect']);
						echo "<option value=\"$Item\">$Item (+$Item_HP_Effect HP)</option>";
					}

					$Items_Quantity_Query->closeCursor();
					
					echo '</optgroup>';
					echo "<optgroup label=\"$Battle_26\">";
					
					$MP_Item_List_Query = $bdd->prepare("SELECT * FROM Caranille_Inventory, Caranille_Items
					WHERE Inventory_Item_ID = Item_ID
					AND Item_Type = 'Magic'
					AND Inventory_Account_ID = ?
					ORDER BY Item_Name ASC");
					$MP_Item_List_Query->execute(array($ID));

					while ($Item_List = $MP_Item_List_Query->fetch())
					{
						$Inventory_ID = stripslashes($Item_List['Inventory_ID']);
						$Item = stripslashes($Item_List['Item_Name']);
						$Item_MP_Effect = stripslashes($Item_List['Item_MP_Effect']);
						echo "<option value=\"$Item\">$Item (+$Item_MP_Effect MP)</option>";
					}

					$MP_Item_List_Query->closeCursor();

					echo '</optgroup>';
					echo '</select>';
					
					echo "<br /><br /><input type=\"hidden\" name=\"Item_Quantity\" value=\"$Item_Quantity\">"; 
					echo "<br /><br /><input type=\"submit\" name=\"End_Items\" value=\"$Battle_27\">";
					echo '</form>';
				}
				else
				{
					echo "$Battle_28";
				}
				
				echo '<form method="POST" action="Battle.php">';
				echo "<input type=\"submit\" name=\"Cancel\" value=\"$Battle_16\"><br />";
				echo '</form>';
			}
			if (isset($_POST['End_Items']))
			{
				$Item_Choice = htmlspecialchars(addslashes($_POST['Item']));
				$Item_List_Query = $bdd->prepare("SELECT *  FROM Caranille_Inventory, Caranille_Items
				WHERE Inventory_Item_ID = Item_ID
				AND Inventory_Account_ID = ?
				AND Item_Name = ?");
				$Item_List_Query->execute(array($ID, $Item_Choice));

				while ($Item_List = $Item_List_Query->fetch())
				{
					$Item_ID = stripslashes($Item_List['Item_ID']);
					$Item_Name = stripslashes($Item_List['Item_Name']);
					$Item_Type = stripslashes($Item_List['Item_Type']);
					$Item_HP_Effect = stripslashes($Item_List['Item_HP_Effect']);
					$Item_MP_Effect = stripslashes($Item_List['Item_MP_Effect']);
					$Inventory_ID = stripslashes($Item_List['Inventory_ID']);
					$Item_Quantity = stripslashes($Item_List['Inventory_Item_Quantity']);
				}
				if ($Item_Type == "Health")
				{
					$MIN_Magic = htmlspecialchars(addslashes($_SESSION['Magic_Total'])) / 1.1;
					$MAX_Magic = htmlspecialchars(addslashes($_SESSION['Magic_Total'])) * 1.1;
					$MIN_Defense = htmlspecialchars(addslashes($_SESSION['Defense_Total'])) / 1.1;
					$MAX_Defense = htmlspecialchars(addslashes($_SESSION['Defense_Total'])) * 1.1;

					$Monster_MIN_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) / 1.1;
					$Monster_MAX_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) * 1.1;
					$Monster_MIN_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) / 1.1;
					$Monster_MAX_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) * 1.1;
					
					$Monster_Positive_Damage = mt_rand($Monster_MIN_Strength, $Monster_MAX_Strength);
					$Monster_Negative_Damage = mt_rand($MIN_Defense, $MAX_Defense);
					$Total_Damage_Monster = htmlspecialchars(addslashes($Monster_Positive_Damage)) - htmlspecialchars(addslashes($Monster_Negative_Damage));
					//Si les dégats du monstre sont en dessous de 0, on applique 0 de dégat pour éviter de soigner le personnage
					if ($Total_Damage_Monster <=0)
					{
						$Total_Damage_Monster = 0;
					}
					$Life_Difference = htmlspecialchars(addslashes($_SESSION['HP_Total'])) - htmlspecialchars(addslashes($_SESSION['HP']));
					if ($Item_HP_Effect >= $Life_Difference)
					{
						$Remaining_HP = htmlspecialchars(addslashes($_SESSION['HP'])) + htmlspecialchars(addslashes($Life_Difference));
						$Item_HP_Effect = htmlspecialchars(addslashes($Life_Difference));
					}
					else
					{
						$Remaining_HP = htmlspecialchars(addslashes($_SESSION['HP'])) + htmlspecialchars(addslashes($Item_HP_Effect));
					}
					$_SESSION['HP'] = htmlspecialchars(addslashes($_SESSION['HP'])) - htmlspecialchars(addslashes($Total_Damage_Monster));
					$Monster_Image = htmlspecialchars(addslashes($_SESSION['Monster_Image']));
					echo "<img src=\"$Monster_Image\"><br />";
					echo "$Battle_29 $Item_HP_Effect <br /><br />";
					echo "$Battle_11 $Total_Damage_Monster HP <br /><br />";

					$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_HP_Remaining= :Remaining_HP WHERE Account_ID= :ID");
					$Update_Account->execute(array('Remaining_HP'=> $Remaining_HP, 'ID'=> $ID));

					if ($Item_Quantity >=2)
					{
						$Add_Item = $bdd->prepare("UPDATE Caranille_Inventory
						SET Inventory_Item_Quantity = Inventory_Item_Quantity -1
						WHERE Inventory_ID = '$Inventory_ID'");
						$Add_Item->execute(array('Inventory_ID'=> $Inventory_ID));
					}
					else
					{
						$Add_Item = $bdd->prepare("DELETE FROM Caranille_Inventory
						WHERE Inventory_ID = :Inventory_ID");
						$Add_Item->execute(array('Inventory_ID'=> $Inventory_ID));
					}
					echo '<form method="POST" action="Battle.php">';
					echo "<input type=\"submit\" name=\"Continue\" value=\"$Battle_12\">";
					echo '</form>';								
				}
				if ($Item_Type == "Magic")
				{
					$MIN_Magic = htmlspecialchars(addslashes($_SESSION['Magic_Total'])) / 1.1;
					$MAX_Magic = htmlspecialchars(addslashes($_SESSION['Magic_Total'])) * 1.1;
					$MIN_Defense = htmlspecialchars(addslashes($_SESSION['Defense_Total'])) / 1.1;
					$MAX_Defense = htmlspecialchars(addslashes($_SESSION['Defense_Total'])) * 1.1;

					$Monster_MIN_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) / 1.1;
					$Monster_MAX_Strength = htmlspecialchars(addslashes($_SESSION['Monster_Strength'])) * 1.1;
					$Monster_MIN_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) / 1.1;
					$Monster_MAX_Defense = htmlspecialchars(addslashes($_SESSION['Monster_Defense'])) * 1.1;
					
					$Monster_Positive_Damage = mt_rand($Monster_MIN_Strength, $Monster_MAX_Strength);
					$Monster_Negative_Damage = mt_rand($MIN_Defense, $MAX_Defense);
					$Total_Damage_Monster = htmlspecialchars(addslashes($Monster_Positive_Damage)) - htmlspecialchars(addslashes($Monster_Negative_Damage));
					if ($Total_Damage_Monster <=0)
					{
						$Total_Damage_Monster = 0;
					}
					$Magic_Difference = htmlspecialchars(addslashes($_SESSION['MP_Total'])) - htmlspecialchars(addslashes($_SESSION['MP']));
					if ($Item_MP_Effect >= $Magic_Difference)
					{
						$Remaining_MP = htmlspecialchars(addslashes($_SESSION['MP'])) + htmlspecialchars(addslashes($Magic_Difference));
						$Item_MP_Effect = htmlspecialchars(addslashes($Magic_Difference));
					}
					else
					{
						$Remaining_MP = htmlspecialchars(addslashes($_SESSION['MP'])) + htmlspecialchars(addslashes($Item_MP_Effect));
					}
					$Remaining_HP = htmlspecialchars(addslashes($_SESSION['HP'] - $Total_Damage_Monster));
					$Monster_Image = htmlspecialchars(addslashes($_SESSION['Monster_Image']));
					echo "<img src=\"$Monster_Image\"><br />";
					echo "$Battle_29 $Item_MP_Effect <br /><br />";
					echo "$Battle_11 $Total_Damage_Monster HP <br /><br />";

					$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_HP_Remaining= :Remaining_HP , Account_MP_Remaining= :Remaining_MP WHERE Account_ID= :ID");
					$Update_Account->execute(array('Remaining_HP'=> $Remaining_HP, 'Remaining_MP'=> $Remaining_MP, 'ID'=> $ID));

					if ($Item_Quantity >=2)
					{
						$Add_Item = $bdd->prepare("UPDATE Caranille_Inventory
						SET Item_Quantity = Item_Quantity -1
						WHERE Inventory_ID = '$Inventory_ID'");
						$Add_Item->execute(array('Inventory_ID'=> $Inventory_ID));
					}
					else
					{
						$Add_Item = $bdd->prepare("DELETE FROM Caranille_Inventory
						WHERE Inventory_ID = :Inventory_ID");
						$Add_Item->execute(array('Inventory_ID'=> $Inventory_ID));
					}
					echo '<form method="POST" action="Battle.php">';
					echo "<input type=\"submit\" name=\"Continue\" value=\"$Battle_12\">";
					echo '</form>';
				}
			}
			//Si l'utilisateur à choisit la fuite
			if (isset($_POST['Escape']))
			{
				echo "$Battle_30<br />";
				echo '<form method="POST" action="Main.php">';
				echo "<input type=\"submit\" name=\"End_Battle\" value=\"$Battle_12\">";
				echo '</form>';
			}
			//Si l'utilisateur continue le combat on vérifie si il y a un gagnant ou un perdant
			if (isset($_POST['Continue']))
			{	
				//Si la HP du monstre est inférieur ou égale à zero le joueur à gagné le combat
				if ($_SESSION['Monster_HP'] <= 0)
				{	
					$Gold_Gained = htmlspecialchars(addslashes($_SESSION['Monster_Golds']));
					$_SESSION['Battle'] = 0;
					echo "$Battle_31<br /><br />";
					echo "$Battle_32 $Gold_Gained <br /><br />";
					$Experience_Gained = htmlspecialchars(addslashes($_SESSION['Monster_Experience']));
					$Experience_Bonus = $_SESSION['Sagesse_Bonus'] * $Experience_Gained /100;
					$Experience_Total = $Experience_Gained + round($Experience_Bonus);
					echo "$Battle_33 $Experience_Total <br />";
					if ($_SESSION['Monster_Item_One'] >= 1)
					{
						$Monster_Item_One_Rate = mt_rand(0, 100);
						if ($Monster_Item_One_Rate <= $_SESSION['Monster_Item_One_Rate'])
						{
							$Monster_Item_One = htmlspecialchars(addslashes($_SESSION['Monster_Item_One']));
							$Item_One = $bdd->prepare("SELECT * From Caranille_Items
							WHERE Item_ID= ?");
							$Item_One->execute(array($Monster_Item_One));
							while ($Item_Name = $Item_One->fetch())
							{
								$Item_Name_One = stripslashes($Item_Name['Item_Name']);
								echo "$Battle_34 $Item_Name_One<br />";

								$One_Item_Verification = $bdd->prepare("SELECT * FROM Caranille_Inventory
								WHERE Inventory_Item_ID= ?
								AND Inventory_Account_ID= ?");
								$One_Item_Verification->execute(array($Monster_Item_One, $ID));

								$Item_Quantity = $One_Item_Verification->rowCount();
								if ($Item_Quantity>=1)
								{
									$Update_Account = $bdd->prepare("UPDATE Caranille_Inventory SET Inventory_Item_Quantity = Inventory_Item_Quantity + 1
									WHERE Inventory_Account_ID = :ID
									AND Inventory_Item_ID= :Monster_Item_One");
									$Update_Account->execute(array('ID'=> $ID, 'Monster_Item_One'=> $Monster_Item_One));
								}
								else
								{
									$Update_Account = $bdd->prepare("INSERT INTO Caranille_Inventory VALUES('', :ID, :Monster_Item_One, '1', 'No')");
									$Update_Account->execute(array('ID'=> $ID, 'Monster_Item_One'=> $Monster_Item_One));
								}
							}
							$Item_One->closeCursor();
						}
					}
					if ($_SESSION['Monster_Item_Two'] >= 1)
					{
						$Monster_Item_Two_Rate = mt_rand(0, 100);
						if ($Monster_Item_Two_Rate <= $_SESSION['Monster_Item_One_Rate'])
						{
							$Monster_Item_Two = htmlspecialchars(addslashes($_SESSION['Monster_Item_Two']));
							$Item_Two = $bdd->prepare("SELECT * From Caranille_Items
							WHERE Item_ID= ?");
							$Item_Two->execute(array($Monster_Item_Two));
							while ($Item_Name = $Item_Two->fetch())
							{
								$Item_Name_Two = stripslashes($Item_Name['Item_Name']);
								echo "$Battle_34 $Item_Name_Two<br />";

								$Two_Item_Verification = $bdd->prepare("SELECT * FROM Caranille_Inventory
								WHERE Inventory_Item_ID= ?
								AND Inventory_Account_ID= ?");
								$Two_Item_Verification->execute(array($Monster_Item_Two, $ID));

								$Item_Quantity = $Two_Item_Verification->rowCount();
								if ($Item_Quantity>=1)
								{
									$Update_Account = $bdd->prepare("UPDATE Caranille_Inventory SET Inventory_Item_Quantity = Inventory_Item_Quantity + 1
									WHERE Inventory_Account_ID = :ID
									AND Inventory_Item_ID= :Monster_Item_Two");
									$Update_Account->execute(array('ID'=> $ID, 'Monster_Item_Two'=> $Monster_Item_Two));
								}
								else
								{
									$Update_Account = $bdd->prepare("INSERT INTO Caranille_Inventory VALUES('', :ID, :Monster_Item_Two, '1', 'No')");
									$Update_Account->execute(array('ID'=> $ID, 'Monster_Item_Two'=> $Monster_Item_Two));
								}
							}
							$Item_Two->closeCursor();
						}
					}
					if ($_SESSION['Monster_Item_Three'] >= 1)
					{
						$Monster_Item_Three_Rate = mt_rand(0, 100);
						if ($Monster_Item_Three_Rate <= $_SESSION['Monster_Item_Three_Rate'])
						{
							$Monster_Item_Three = htmlspecialchars(addslashes($_SESSION['Monster_Item_Three']));
							$Item_Three = $bdd->prepare("SELECT * From Caranille_Items
							WHERE Item_ID= ?");
							$Item_Three->execute(array($Monster_Item_Three));
							while ($Item_Name = $Item_Three->fetch())
							{
								$Item_Name_Three = stripslashes($Item_Name['Item_Name']);
								echo "$Battle_34 $Item_Name_Three<br />";

								$Three_Item_Verification = $bdd->prepare("SELECT * FROM Caranille_Inventory
								WHERE Inventory_Item_ID= ?
								AND Inventory_Account_ID= ?");
								$Three_Item_Verification->execute(array($Monster_Item_Three, $ID));

								$Item_Quantity = $Three_Item_Verification->rowCount();
								if ($Item_Quantity>=1)
								{
									$Update_Account = $bdd->prepare("UPDATE Caranille_Inventory SET Inventory_Item_Quantity = Inventory_Item_Quantity + 1
									WHERE Inventory_Account_ID = :ID
									AND Inventory_Item_ID= :Monster_Item_Three");
									$Update_Account->execute(array('ID'=> $ID, 'Monster_Item_Three'=> $Monster_Item_Three));
								}
								else
								{
									$Update_Account = $bdd->prepare("INSERT INTO Caranille_Inventory VALUES('', :ID, :Monster_Item_Three, '1', 'No')");
									$Update_Account->execute(array('ID'=> $ID, 'Monster_Item_Three'=> $Monster_Item_Three));
								}
							}
							$Item_Three->closeCursor();
						}
					}
					if ($_SESSION['Monster_Item_Four'] >= 1)
					{
						$Monster_Item_Four_Rate = mt_rand(0, 100);
						if ($Monster_Item_Four_Rate <= $_SESSION['Monster_Item_Four_Rate'])
						{
							$Monster_Item_Four = htmlspecialchars(addslashes($_SESSION['Monster_Item_Four']));
							$Item_Four = $bdd->prepare("SELECT * From Caranille_Items
							WHERE Item_ID= ?");
							$Item_Four->execute(array($Monster_Item_Four));
							while ($Item_Name = $Item_Four->fetch())
							{
								$Item_Name_Four = stripslashes($Item_Name['Item_Name']);
								echo "$Battle_34 $Item_Name_Four<br />";

								$Four_Item_Verification = $bdd->prepare("SELECT * FROM Caranille_Inventory
								WHERE Inventory_Item_ID= ?
								AND Inventory_Account_ID= ?");
								$Four_Item_Verification->execute(array($Monster_Item_Four, $ID));

								$Item_Quantity = $Four_Item_Verification->rowCount();
								if ($Item_Quantity>=1)
								{
									$Update_Account = $bdd->prepare("UPDATE Caranille_Inventory SET Inventory_Item_Quantity = Inventory_Item_Quantity + 1
									WHERE Inventory_Account_ID = :ID
									AND Inventory_Item_ID= :Monster_Item_Four");
									$Update_Account->execute(array('ID'=> $ID, 'Monster_Item_Four'=> $Monster_Item_Four));
								}
								else
								{
									$Update_Account = $bdd->prepare("INSERT INTO Caranille_Inventory VALUES('', :ID, :Monster_Item_Four, '1', 'No')");
									$Update_Account->execute(array('ID'=> $ID, 'Monster_Item_Four'=> $Monster_Item_Four));
								}
							}
							$Item_Four->closeCursor();
						}
					}
					if ($_SESSION['Monster_Item_Five'] >= 1)
					{
						$Monster_Item_Five_Rate = mt_rand(0, 100);
						if ($Monster_Item_Five_Rate <= $_SESSION['Monster_Item_Five_Rate'])
						{
							$Monster_Item_Five = htmlspecialchars(addslashes($_SESSION['Monster_Item_Five']));
							$Item_Five = $bdd->prepare("SELECT * From Caranille_Items
							WHERE Item_ID= ?");
							$Item_Five->execute(array($Monster_Item_Five));
							while ($Item_Name = $Item_Five->fetch())
							{
								$Item_Name_Five = stripslashes($Item_Name['Item_Name']);
								echo "$Battle_34 $Item_Name_Five<br />";

								$Five_Item_Verification = $bdd->prepare("SELECT * FROM Caranille_Inventory
								WHERE Inventory_Item_ID= ?
								AND Inventory_Account_ID= ?");
								$Five_Item_Verification->execute(array($Monster_Item_Five, $ID));

								$Item_Quantity = $Five_Item_Verification->rowCount();
								if ($Item_Quantity>=1)
								{
									$Update_Account = $bdd->prepare("UPDATE Caranille_Inventory SET Inventory_Item_Quantity = Inventory_Item_Quantity + 1
									WHERE Inventory_Account_ID = :ID
									AND Inventory_Item_ID= :Monster_Item_Five");
									$Update_Account->execute(array('ID'=> $ID, 'Monster_Item_Five'=> $Monster_Item_Five));
								}
								else
								{
									$Update_Account = $bdd->prepare("INSERT INTO Caranille_Inventory VALUES('', :ID, :Monster_Item_Five, '1', 'No')");
									$Update_Account->execute(array('ID'=> $ID, 'Monster_Item_Five'=> $Monster_Item_Five));
								}
							}
							$Item_Five->closeCursor();
						}
					}
					if ($_SESSION['Chapter_Battle'] == 1)
					{	
						echo '<form method="POST" action="Main.php">';
						echo "$Battle_35<br />";								
						echo $_SESSION['Chapter_Ending'];
						$_SESSION['Chapter'] = htmlspecialchars(addslashes($_SESSION['Chapter'])) + 1;
						$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Experience= Account_Experience + :Experience_Total, Account_Golds= Account_Golds + :Gold_Gained, Account_Chapter= Account_Chapter + 1 WHERE Account_ID= :ID");
						$Update_Account->execute(array('Experience_Total'=> $Experience_Total, 'Gold_Gained'=> $Gold_Gained, 'ID'=> $ID));
					}
					if ($_SESSION['Dungeon_Battle'] == 1)
					{
						echo '<form method="POST" action="Map.php">';
						$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Experience= Account_Experience + :Experience_Total, Account_Golds= Account_Golds + :Gold_Gained WHERE Account_ID= :ID");
						$Update_Account->execute(array('Experience_Total'=> $Experience_Total, 'Gold_Gained'=> $Gold_Gained, 'ID'=> $ID));
					}
					if ($_SESSION['Mission_Battle'] == 1)
					{
						echo '<form method="POST" action="Map.php">';
						$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Experience= Account_Experience + :Experience_Total, Account_Golds= Account_Golds + :Gold_Gained, Account_Mission = Account_Mission + 1 WHERE Account_ID= :ID");
						$Update_Account->execute(array('Experience_Total'=> $Experience_Total, 'Gold_Gained'=> $Gold_Gained, 'ID'=> $ID));
					}
					
					echo "<input type=\"submit\" name=\"End_Battle\" value=\"$Battle_12\">";
					echo '</form>';
					
				}
				//Si la HP du personnage et inférieur ou égale à 0 le joueur à perdu le combat et sera soigné
				if ($_SESSION['HP'] <= 0)
				{
					$_SESSION['Battle'] = 0;
					$HP_Total = htmlspecialchars(addslashes($_SESSION['HP_Total']));
					if ($_SESSION['Chapter_Battle'] == 1)
					{
						echo htmlspecialchars(addslashes($_SESSION['Chapter_Defeate']));

						$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_HP_Remaining= :HP_Total WHERE Account_ID= :ID");
						$Update_Account->execute(array('HP_Total'=> $HP_Total, 'ID'=> $ID));
					}
					if ($_SESSION['Dungeon_Battle'] == 1)
					{
						echo "$Battle_36" .htmlspecialchars(addslashes($_SESSION['Town_Price_INN'])). "$Battle_37";
						$Current_Money = htmlspecialchars(addslashes($_SESSION['Gold'])) - htmlspecialchars(addslashes($_SESSION['Town_Price_INN']));

						$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_HP_Remaining= :HP_Total, Account_Golds= :Current_Money WHERE Account_ID= :ID");
						$Update_Account->execute(array('HP_Total'=> $HP_Total, 'Current_Money'=> $Current_Money, 'ID'=> $ID));
					}
					if ($_SESSION['Mission_Battle'] == 1)
					{
						echo $_SESSION['Mission_Defeate'];
						$Current_Money = htmlspecialchars(addslashes($_SESSION['Gold'])) - htmlspecialchars(addslashes($_SESSION['Town_Price_INN']));

						$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_HP_Remaining= :HP_Total, Account_Golds= :Current_Money WHERE Account_ID= :ID");
						$Update_Account->execute(array('HP_Total'=> $HP_Total, 'Current_Money'=> $Current_Money, 'ID'=> $ID));
					}
					
					echo '<br /><br /><form method="POST" action="Main.php">';
					echo "<input type=\"submit\" name=\"End\" value=\"$Battle_12\">";
					echo '</form>';
				}
			}
		}
	}
	//Si il n'existe pas de données dans la session pseudo, demander de se connecter
	else
	{
		echo "$Battle_38";
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
