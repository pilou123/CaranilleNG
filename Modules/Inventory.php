<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	if (isset($_SESSION['ID']))
	{
		if (empty($_POST['Armor']) && empty($_POST['Boots']) && empty($_POST['Gloves']) && empty($_POST['Helmet']) && empty($_POST['Weapon']) && empty($_POST['Invocation']) && empty($_POST['Magic']) && empty($_POST['Item']) && empty($_POST['Parchment']) && empty($_POST['Item_Equip']) && empty($_POST['Sale']))
		{
			echo "$Inventory_0";
			echo '<form method="POST" action="Inventory.php">';
			echo "<input type=\"submit\" name=\"Weapon\" value=\"$Inventory_1\">";
			echo '</form>';
			echo '<form method="POST" action="Inventory.php">';
			echo "<input type=\"submit\" name=\"Armor\" value=\"$Inventory_2\">";
			echo '</form>';
			echo '<form method="POST" action="Inventory.php">';
			echo "<input type=\"submit\" name=\"Boots\" value=\"$Inventory_3\">";
			echo '</form>';
			echo '<form method="POST" action="Inventory.php">';
			echo "<input type=\"submit\" name=\"Helmet\" value=\"$Inventory_4\">";
			echo '</form>';
			echo '<form method="POST" action="Inventory.php">';
			echo "<input type=\"submit\" name=\"Invocation\" value=\"$Inventory_5\">";
			echo '</form>';
			echo '<form method="POST" action="Inventory.php">';
			echo "<input type=\"submit\" name=\"Gloves\" value=\"$Inventory_6\">";
			echo '</form>';
			echo '<form method="POST" action="Inventory.php">';
			echo "<input type=\"submit\" name=\"Magic\" value=\"$Inventory_7\">";
			echo '</form>';
			echo '<form method="POST" action="Inventory.php">';
			echo "<input type=\"submit\" name=\"Item\" value=\"$Inventory_8\">";
			echo '</form>';
			echo '<form method="POST" action="Inventory.php">';
			echo "<input type=\"submit\" name=\"Parchment\" value=\"$Inventory_9\">";
			echo '</form>';
		}
		if (isset($_POST['Weapon']))
		{
			echo "$Inventory_10";
			echo '<table>';
		
				echo '<tr>';

					echo '<td>';
					echo "$Inventory_11";
					echo '</td>';

					echo '<td>';
					echo "$Inventory_12";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_13";
					echo '</td>';

					echo '<td>';
					echo "$Inventory_14";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_15";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_16";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_17";
					echo '</td>';

				echo '</tr>';
	
			$Item_Query = $bdd->prepare("SELECT * FROM Caranille_Inventory, Caranille_Items
			WHERE Inventory_Item_ID = Item_ID
			AND Item_Type = 'Weapon'
			AND Inventory_Account_ID = ?
			ORDER BY Item_Name");
			$Item_Query->execute(array($ID));

			while ($Item = $Item_Query->fetch())
			{
				echo "<tr>";
					echo '<td>';
						echo '' .$Item['Item_Name']. '';
					echo '</td>';
				
					echo '<td>';
						echo '' .$Item['Item_Description']. '';
					echo '</td>';
				
					echo '<td>';
						echo '' .$Item['Item_Level_Required']. '';
					echo '</td>';
				
					echo '<td>';
						echo '' .$Item['Inventory_Item_Quantity']. '';
					echo '</td>';
				
					echo '<td>';
						echo '+' .stripslashes($Item['Item_HP_Effect']). " HP<br />";
						echo '+' .stripslashes($Item['Item_MP_Effect']). " MP<br />";
						echo '+' .stripslashes($Item['Item_Strength_Effect']). " $Inventory_19<br />";
						echo '+' .stripslashes($Item['Item_Magic_Effect']). " $Inventory_20<br />";
						echo '+' .stripslashes($Item['Item_Agility_Effect']). " $Inventory_21<br />";
						echo '+' .stripslashes($Item['Item_Defense_Effect']). " $Inventory_22";
					echo '</td>';
				
					echo '<td>';
						echo '' .$Item['Item_Sale_Price']. '';
					echo '</td>';
				
					$Inventory_ID = stripslashes($Item['Inventory_ID']);
					$Item_ID = stripslashes($Item['Item_ID']);
					$Item_Name = stripslashes($Item['Item_Name']);
					$Item_Level_Required = stripslashes($Item['Item_Level_Required']);
					$Item_Quantity = stripslashes($Item['Inventory_Item_Quantity']);
					$Item_Sale_Price = stripslashes($Item['Item_Sale_Price']);
				
					echo '<td>';
						echo '<form method="POST" action="Inventory.php">';
						echo "<input type=\"hidden\" name=\"Inventory_ID\" value=\"$Inventory_ID\">";
						echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Item_ID\">";
						echo "<input type=\"submit\" name=\"Item_Equip\" value=\"$Inventory_25\">";
						echo '</form>';
						echo '<form method="POST" action="Inventory.php">';
						echo "<input type=\"hidden\" name=\"Inventory_ID\" value=\"$Inventory_ID\">";
						echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Item_ID\">";
						echo "<input type=\"submit\" name=\"Sale\" value=\"$Inventory_26\"><br /><br />";
						echo '</form>';
					echo '</td>';
				echo '</tr>';
			}

			$Item_Query->closeCursor();
	
			echo '</table>';
			echo '<form method="POST" action="Inventory.php"><br />';
			echo "<input type=\"submit\" name=\"Cancel\" value=\"$Inventory_24\">";
			echo '</form>';
		}
		if (isset($_POST['Armor']))
		{
			echo "$Inventory_27<br /><br />";
			echo '<table>';
		
				echo '<tr>';

					echo '<td>';
					echo "$Inventory_11";
					echo '</td>';

					echo '<td>';
					echo "$Inventory_12";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_13";
					echo '</td>';

					echo '<td>';
					echo "$Inventory_14";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_15";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_16";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_17";
					echo '</td>';

				echo '</tr>';
		
			$Item_Query = $bdd->prepare("SELECT * FROM Caranille_Inventory, Caranille_Items
			WHERE Inventory_Item_ID = Item_ID
			AND Item_Type = 'Armor'
			AND Inventory_Account_ID = ?
			ORDER BY Item_Name");
			$Item_Query->execute(array($ID));

			while ($Item = $Item_Query->fetch())
			{
				echo "<tr>";
					echo '<td>';
						echo '' .$Item['Item_Name']. '';
					echo '</td>';
				
					echo '<td>';
						echo '' .$Item['Item_Description']. '';
					echo '</td>';
				
					echo '<td>';
						echo '' .$Item['Item_Level_Required']. '';
					echo '</td>';
				
					echo '<td>';
						echo '' .$Item['Inventory_Item_Quantity']. '';
					echo '</td>';
				
					echo '<td>';
						echo '+' .stripslashes($Item['Item_HP_Effect']). " HP<br />";
						echo '+' .stripslashes($Item['Item_MP_Effect']). " MP<br />";
						echo '+' .stripslashes($Item['Item_Strength_Effect']). " $Inventory_19<br />";
						echo '+' .stripslashes($Item['Item_Magic_Effect']). " $Inventory_20<br />";
						echo '+' .stripslashes($Item['Item_Agility_Effect']). " $Inventory_21<br />";
						echo '+' .stripslashes($Item['Item_Defense_Effect']). " $Inventory_22";
					echo '</td>';
				
					echo '<td>';
						echo '' .$Item['Item_Sale_Price']. '';
					echo '</td>';
				
					$Inventory_ID = stripslashes($Item['Inventory_ID']);
					$Item_ID = stripslashes($Item['Item_ID']);
					$Item_Name = stripslashes($Item['Item_Name']);
					$Item_Level_Required = stripslashes($Item['Item_Level_Required']);
					$Item_Quantity = stripslashes($Item['Inventory_Item_Quantity']);
					$Item_Sale_Price = stripslashes($Item['Item_Sale_Price']);
				
					echo '<td>';
						echo '<form method="POST" action="Inventory.php">';
						echo "<input type=\"hidden\" name=\"Inventory_ID\" value=\"$Inventory_ID\">";
						echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Item_ID\">";
						echo "<input type=\"submit\" name=\"Item_Equip\" value=\"$Inventory_25\">";
						echo '</form>';
						echo '<form method="POST" action="Inventory.php">';
						echo "<input type=\"hidden\" name=\"Inventory_ID\" value=\"$Inventory_ID\">";
						echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Item_ID\">";
						echo "<input type=\"submit\" name=\"Sale\" value=\"$Inventory_26\"><br /><br />";
						echo '</form>';
					echo '</td>';
				echo '</tr>';
			}

			$Item_Query->closeCursor();
	
			echo '</table>';
			echo '<form method="POST" action="Inventory.php"><br />';
			echo "<input type=\"submit\" name=\"Cancel\" value=\"$Inventory_24\">";
			echo '</form>';
		}
		if (isset($_POST['Boots']))
		{
			echo "$Inventory_28<br /><br />";
			echo '<table>';
		
				echo '<tr>';

					echo '<td>';
					echo "$Inventory_11";
					echo '</td>';

					echo '<td>';
					echo "$Inventory_12";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_13";
					echo '</td>';

					echo '<td>';
					echo "$Inventory_14";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_15";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_16";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_17";
					echo '</td>';

				echo '</tr>';
		
			$Item_Query = $bdd->prepare("SELECT * FROM Caranille_Inventory, Caranille_Items
			WHERE Inventory_Item_ID = Item_ID
			AND Item_Type = 'Boots'
			AND Inventory_Account_ID = ?
			ORDER BY Item_Name");
			$Item_Query->execute(array($ID));

			while ($Item = $Item_Query->fetch())
			{
				echo "<tr>";
					echo '<td>';
						echo '' .$Item['Item_Name']. '';
					echo '</td>';
				
					echo '<td>';
						echo '' .$Item['Item_Description']. '';
					echo '</td>';
				
					echo '<td>';
						echo '' .$Item['Item_Level_Required']. '';
					echo '</td>';
				
					echo '<td>';
						echo '' .$Item['Inventory_Item_Quantity']. '';
					echo '</td>';
				
					echo '<td>';
						echo '+' .stripslashes($Item['Item_HP_Effect']). " HP<br />";
						echo '+' .stripslashes($Item['Item_MP_Effect']). " MP<br />";
						echo '+' .stripslashes($Item['Item_Strength_Effect']). " $Inventory_19<br />";
						echo '+' .stripslashes($Item['Item_Magic_Effect']). " $Inventory_20<br />";
						echo '+' .stripslashes($Item['Item_Agility_Effect']). " $Inventory_21<br />";
						echo '+' .stripslashes($Item['Item_Defense_Effect']). " $Inventory_22";
					echo '</td>';
				
					echo '<td>';
						echo '' .$Item['Item_Sale_Price']. '';
					echo '</td>';
				
					$Inventory_ID = stripslashes($Item['Inventory_ID']);
					$Item_ID = stripslashes($Item['Item_ID']);
					$Item_Name = stripslashes($Item['Item_Name']);
					$Item_Level_Required = stripslashes($Item['Item_Level_Required']);
					$Item_Quantity = stripslashes($Item['Inventory_Item_Quantity']);
					$Item_Sale_Price = stripslashes($Item['Item_Sale_Price']);
				
					echo '<td>';
						echo '<form method="POST" action="Inventory.php">';
						echo "<input type=\"hidden\" name=\"Inventory_ID\" value=\"$Inventory_ID\">";
						echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Item_ID\">";
						echo "<input type=\"submit\" name=\"Item_Equip\" value=\"$Inventory_25\">";
						echo '</form>';
						echo '<form method="POST" action="Inventory.php">';
						echo "<input type=\"hidden\" name=\"Inventory_ID\" value=\"$Inventory_ID\">";
						echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Item_ID\">";
						echo "<input type=\"submit\" name=\"Sale\" value=\"$Inventory_26\"><br /><br />";
						echo '</form>';
					echo '</td>';
				echo '</tr>';
			}

			$Item_Query->closeCursor();
	
			echo '</table>';
			echo '<form method="POST" action="Inventory.php"><br />';
			echo "<input type=\"submit\" name=\"Cancel\" value=\"$Inventory_24\">";
			echo '</form>';
		}
		if (isset($_POST['Helmet']))
		{
			echo "$Inventory_29<br /><br />";
			echo '<table>';
		
				echo '<tr>';

					echo '<td>';
					echo "$Inventory_11";
					echo '</td>';

					echo '<td>';
					echo "$Inventory_12";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_13";
					echo '</td>';

					echo '<td>';
					echo "$Inventory_14";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_15";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_16";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_17";
					echo '</td>';

				echo '</tr>';
		
			$Item_Query = $bdd->prepare("SELECT * FROM Caranille_Inventory, Caranille_Items
			WHERE Inventory_Item_ID = Item_ID
			AND Item_Type = 'Helmet'
			AND Inventory_Account_ID = ?
			ORDER BY Item_Name");
			$Item_Query->execute(array($ID));

			while ($Item = $Item_Query->fetch())
			{
				echo "<tr>";
					echo '<td>';
						echo '' .$Item['Item_Name']. '';
					echo '</td>';
				
					echo '<td>';
						echo '' .$Item['Item_Description']. '';
					echo '</td>';
				
					echo '<td>';
						echo '' .$Item['Item_Level_Required']. '';
					echo '</td>';
				
					echo '<td>';
						echo '' .$Item['Inventory_Item_Quantity']. '';
					echo '</td>';
				
					echo '<td>';
						echo '+' .stripslashes($Item['Item_HP_Effect']). " HP<br />";
						echo '+' .stripslashes($Item['Item_MP_Effect']). " MP<br />";
						echo '+' .stripslashes($Item['Item_Strength_Effect']). " $Inventory_19<br />";
						echo '+' .stripslashes($Item['Item_Magic_Effect']). " $Inventory_20<br />";
						echo '+' .stripslashes($Item['Item_Agility_Effect']). " $Inventory_21<br />";
						echo '+' .stripslashes($Item['Item_Defense_Effect']). " $Inventory_22";
					echo '</td>';
				
					echo '<td>';
						echo '' .$Item['Item_Sale_Price']. '';
					echo '</td>';
				
					$Inventory_ID = stripslashes($Item['Inventory_ID']);
					$Item_ID = stripslashes($Item['Item_ID']);
					$Item_Name = stripslashes($Item['Item_Name']);
					$Item_Level_Required = stripslashes($Item['Item_Level_Required']);
					$Item_Quantity = stripslashes($Item['Inventory_Item_Quantity']);
					$Item_Sale_Price = stripslashes($Item['Item_Sale_Price']);
				
					echo '<td>';
						echo '<form method="POST" action="Inventory.php">';
						echo "<input type=\"hidden\" name=\"Inventory_ID\" value=\"$Inventory_ID\">";
						echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Item_ID\">";
						echo "<input type=\"submit\" name=\"Item_Equip\" value=\"$Inventory_25\">";
						echo '</form>';
						echo '<form method="POST" action="Inventory.php">';
						echo "<input type=\"hidden\" name=\"Inventory_ID\" value=\"$Inventory_ID\">";
						echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Item_ID\">";
						echo "<input type=\"submit\" name=\"Sale\" value=\"$Inventory_26\"><br /><br />";
						echo '</form>';
					echo '</td>';
				echo '</tr>';
			}

			$Item_Query->closeCursor();
	
			echo '</table>';
			echo '<form method="POST" action="Inventory.php"><br />';
			echo '<input type="submit" name="Cancel" value="retour">';
			echo '</form>';
		}
		if (isset($_POST['Gloves']))
		{
			echo "$Inventory_30<br /><br />";
			echo '<table>';
		
				echo '<tr>';

					echo '<td>';
					echo "$Inventory_11";
					echo '</td>';

					echo '<td>';
					echo "$Inventory_12";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_13";
					echo '</td>';

					echo '<td>';
					echo "$Inventory_14";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_15";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_16";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_17";
					echo '</td>';

				echo '</tr>';
		
			$Item_Query = $bdd->prepare("SELECT * FROM Caranille_Inventory, Caranille_Items
			WHERE Inventory_Item_ID = Item_ID
			AND Item_Type = 'Gloves'
			AND Inventory_Account_ID = ?
			ORDER BY Item_Name");
			$Item_Query->execute(array($ID));

			while ($Item = $Item_Query->fetch())
			{
				echo "<tr>";
					echo '<td>';
						echo '' .$Item['Item_Name']. '';
					echo '</td>';
				
					echo '<td>';
						echo '' .$Item['Item_Description']. '';
					echo '</td>';
				
					echo '<td>';
						echo '' .$Item['Item_Level_Required']. '';
					echo '</td>';
				
					echo '<td>';
						echo '' .$Item['Inventory_Item_Quantity']. '';
					echo '</td>';
				
					echo '<td>';
						echo '+' .stripslashes($Item['Item_HP_Effect']). " HP<br />";
						echo '+' .stripslashes($Item['Item_MP_Effect']). " MP<br />";
						echo '+' .stripslashes($Item['Item_Strength_Effect']). " $Inventory_19<br />";
						echo '+' .stripslashes($Item['Item_Magic_Effect']). " $Inventory_20<br />";
						echo '+' .stripslashes($Item['Item_Agility_Effect']). " $Inventory_21<br />";
						echo '+' .stripslashes($Item['Item_Defense_Effect']). " $Inventory_22";
					echo '</td>';
				
					echo '<td>';
						echo '' .$Item['Item_Sale_Price']. '';
					echo '</td>';
				
					$Inventory_ID = stripslashes($Item['Inventory_ID']);
					$Item_ID = stripslashes($Item['Item_ID']);
					$Item_Name = stripslashes($Item['Item_Name']);
					$Item_Level_Required = stripslashes($Item['Item_Level_Required']);
					$Item_Quantity = stripslashes($Item['Inventory_Item_Quantity']);
					$Item_Sale_Price = stripslashes($Item['Item_Sale_Price']);
				
					echo '<td>';
						echo '<form method="POST" action="Inventory.php">';
						echo "<input type=\"hidden\" name=\"Inventory_ID\" value=\"$Inventory_ID\">";
						echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Item_ID\">";
						echo "<input type=\"submit\" name=\"Item_Equip\" value=\"$Inventory_25\">";
						echo '</form>';
						echo '<form method="POST" action="Inventory.php">';
						echo "<input type=\"hidden\" name=\"Inventory_ID\" value=\"$Inventory_ID\">";
						echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Item_ID\">";
						echo "<input type=\"submit\" name=\"Sale\" value=\"$Inventory_26\"><br /><br />";
						echo '</form>';
					echo '</td>';
				echo '</tr>';
			}

			$Item_Query->closeCursor();
	
			echo '</table>';
			echo '<form method="POST" action="Inventory.php"><br />';
			echo "<input type=\"submit\" name=\"Cancel\" value=\"$Inventory_24\">";
			echo '</form>';
		}
		if (isset($_POST['Magic']))
		{
			echo "$Inventory_31<br /><br />";
			echo '<table>';
			
			echo '<tr>';

					echo '<td>';
					echo "$Inventory_11";
					echo '</td>';

					echo '<td>';
					echo "$Inventory_12";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_18";
					echo '</td>';

					echo '<td>';
					echo "$Inventory_15";
					echo '</td>';

				echo '</tr>';
			
			$Magic_Query = $bdd->prepare("SELECT * FROM Caranille_Inventory_Magics, Caranille_Magics
			WHERE Inventory_Magic_Magic_ID = Magic_ID
			AND Inventory_Magic_Account_ID = ?
			ORDER BY Magic_Name");
			$Magic_Query->execute(array($ID));

			while ($Magic = $Magic_Query->fetch())
			{
				echo '<tr>';
			
					echo '<td>';
						echo '' .$Magic['Magic_Name']. '';
					echo '</td>';
				
					echo '<td>';
						echo '' .$Magic['Magic_Description']. '';
					echo '</td>';
				
					echo '<td>';
						echo '' .$Magic['Magic_Type']. '';
					echo '</td>';
				
					echo '<td>';
						echo '' .$Magic['Magic_Effect']. '';
					echo '</td>';
				
				echo '</tr>';
			}

			$Magic_Query->closeCursor();

			echo '</table>';
			echo '<form method="POST" action="Inventory.php"><br />';
			echo "<input type=\"submit\" name=\"Cancel\" value=\"$Inventory_24\">";
			echo '</form>';
		}
		if (isset($_POST['Invocation']))
		{
			echo "$Inventory_32<br /><br />";
			echo '<table>';
		
				echo '<tr>';

					echo '<td>';
						echo "$Inventory_11";
					echo '</td>';

					echo '<td>';
						echo "$Inventory_12";
					echo '</td>';

					echo '<td>';
						echo "$Inventory_15";
					echo '</td>';

				echo '</tr>';
			
			$Invocation_Query = $bdd->prepare("SELECT * FROM Caranille_Inventory_Invocations, Caranille_Invocations
			WHERE Inventory_Invocation_Invocation_ID = Invocation_ID
			AND Inventory_Invocation_Account_ID = ?
			ORDER BY Invocation_Name");
			$Invocation_Query->execute(array($ID));

			while ($Invocation = $Invocation_Query->fetch())
			{
				echo '<tr>';
					echo '<td>';
						echo '' .$Invocation['Invocation_Name']. '';
					echo '</td>';
				
					echo '<td>';
						echo '' .$Invocation['Invocation_Description']. '';
					echo '</td>';
				
					echo '<td>';
						echo '' .$Invocation['Invocation_Damage']. '';
					echo '</td>';
				echo '</tr>';
			}

			$Invocation_Query->closeCursor();

			echo '</table>';
			echo '<form method="POST" action="Inventory.php"><br />';
			echo "<input type=\"submit\" name=\"Cancel\" value=\"$Inventory_24\">";
			echo '</form>';

		}
		if (isset($_POST['Item']))
		{
			echo "$Inventory_33<br /><br />";
			echo '<table>';
		
				echo '<tr>';

					echo '<td>';
					echo "$Inventory_11";
					echo '</td>';

					echo '<td>';
					echo "$Inventory_12";
					echo '</td>';

					echo '<td>';
					echo "$Inventory_14";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_15";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_16";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_17";
					echo '</td>';

				echo '</tr>';
			
			$Item_Query = $bdd->prepare("SELECT * FROM Caranille_Inventory, Caranille_Items
			WHERE Inventory_Item_ID = Item_ID
			AND Item_Type = 'Health'
			AND Inventory_Account_ID = ?
			ORDER BY Item_Name");
			$Item_Query->execute(array($ID));

			while ($Item = $Item_Query->fetch())
			{
				echo '<tr>';
			
					echo '<td>';
						echo '' .stripslashes($Item['Item_Name']). '';
					echo '</td>';
				
					echo '<td>';
						echo '' .stripslashes($Item['Item_Description']). '';
					echo '</td>';
				
					echo '<td>';
						echo '' .stripslashes($Item['Inventory_Item_Quantity']). '';
					echo '</td>';
				
					echo '<td>';
						echo '+' .stripslashes($Item['Item_HP_Effect']). " HP<br />";
						echo '+' .stripslashes($Item['Item_MP_Effect']). " MP<br />";
						echo '+' .stripslashes($Item['Item_Strength_Effect']). " $Inventory_19<br />";
						echo '+' .stripslashes($Item['Item_Magic_Effect']). " $Inventory_20<br />";
						echo '+' .stripslashes($Item['Item_Agility_Effect']). " $Inventory_21<br />";
						echo '+' .stripslashes($Item['Item_Defense_Effect']). " $Inventory_22";
					echo '</td>';
				
					echo '<td>';
						echo '' .stripslashes($Item['Item_Sale_Price']). '';
					echo '</td>';
				
					$Inventory_ID = stripslashes($Item['Inventory_ID']);
					$Item_ID = stripslashes($Item['Item_ID']);
					$Item_Name = stripslashes($Item['Item_Name']);
					$Item_Quantity = stripslashes($Item['Inventory_Item_Quantity']);
					$Item_Sale_Price = stripslashes($Item['Item_Sale_Price']);
				
					echo '<td>';
						echo '<form method="POST" action="Inventory.php">';
						echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Item_ID\">";
						echo "<input type=\"hidden\" name=\"Item_Name\" value=\"$Item_Name\">";
						echo '</form>';
						echo '<form method="POST" action="Inventory.php">';
						echo "<input type=\"hidden\" name=\"Inventory_ID\" value=\"$Inventory_ID\">";
						echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Item_ID\">";
						echo "<input type=\"submit\" name=\"Sale\" value=\"$Inventory_26\"><br /><br />";
						echo '</form>';
					echo '</td>';
				
				echo '</tr>';
			}

			$Item_Query->closeCursor();

			$Item_Query = $bdd->prepare("SELECT * FROM Caranille_Inventory, Caranille_Items
			WHERE Inventory_Item_ID = Item_ID
			AND Item_Type = 'Magic'
			AND Inventory_Account_ID = ?
			ORDER BY Item_Name");
			$Item_Query->execute(array($ID));

			while ($Item = $Item_Query->fetch())
			{
				echo '<tr>';
					echo '<td>';
						echo '' .stripslashes($Item['Item_Name']). '';
					echo '</td>';
				
					echo '<td>';
						echo '' .stripslashes($Item['Item_Description']). '';
					echo '</td>';
				
					echo '<td>';
						echo '' .stripslashes($Item['Inventory_Item_Quantity']). '';
					echo '</td>';
				
					echo '<td>';
						echo '+' .stripslashes($Item['Item_HP_Effect']). " HP<br />";
						echo '+' .stripslashes($Item['Item_MP_Effect']). " MP<br />";
						echo '+' .stripslashes($Item['Item_Strength_Effect']). " $Inventory_19<br />";
						echo '+' .stripslashes($Item['Item_Magic_Effect']). " $Inventory_20<br />";
						echo '+' .stripslashes($Item['Item_Agility_Effect']). " $Inventory_21<br />";
						echo '+' .stripslashes($Item['Item_Defense_Effect']). " $Inventory_22";
					echo '</td>';
				
					echo '<td>';
						echo '' .stripslashes($Item['Item_Sale_Price']). '';
					echo '</td>';
				
					$Inventory_ID = stripslashes($Item['Inventory_ID']);
					$Item_ID = stripslashes($Item['Item_ID']);
					$Item_Name = stripslashes($Item['Item_Name']);
					$Item_Quantity = stripslashes($Item['Inventory_Item_Quantity']);
					$Item_Sale_Price = stripslashes($Item['Item_Sale_Price']);
				
					echo '<td>';
						echo '<form method="POST" action="Inventory.php">';
						echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Item_ID\">";
						echo "<input type=\"hidden\" name=\"Item_Name\" value=\"$Item_Name\">";
						echo '</form>';
						echo '<form method="POST" action="Inventory.php">';
						echo "<input type=\"hidden\" name=\"Inventory_ID\" value=\"$Inventory_ID\">";
						echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Item_ID\">";
						echo "<input type=\"submit\" name=\"Sale\" value=\"$Inventory_26\"><br /><br />";
						echo '</form>';
					echo '</td>';
				
				echo '</tr>';
			}

			$Item_Query->closeCursor();

			echo '</table>';
			echo '<form method="POST" action="Inventory.php"><br />';
			echo "<input type=\"submit\" name=\"Cancel\" value=\"$Inventory_24\">";
			echo '</form>';

		}
		if (isset($_POST['Parchment']))
		{
			echo "$Inventory_34<br /><br />";
			echo '<table>';
		
				echo '<tr>';

					echo '<td>';
					echo "$Inventory_11";
					echo '</td>';

					echo '<td>';
					echo "$Inventory_12";
					echo '</td>';

					echo '<td>';
					echo "$Inventory_14";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_15";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_16";
					echo '</td>';
				
					echo '<td>';
					echo "$Inventory_17";
					echo '</td>';

				echo '</tr>';
		
			$Item_Query = $bdd->prepare("SELECT * FROM Caranille_Inventory, Caranille_Items
			WHERE Inventory_Item_ID = Item_ID
			AND Item_Type = 'Parchment'
			AND Inventory_Account_ID = ?
			ORDER BY Item_Name");
			$Item_Query->execute(array($ID));

			while ($Item = $Item_Query->fetch())
			{
				echo "<tr>";
					echo '<td>';
						echo '' .$Item['Item_Name']. '';
					echo '</td>';
				
					echo '<td>';
						echo '' .$Item['Item_Description']. '';
					echo '</td>';
				
					echo '<td>';
						echo '' .$Item['Inventory_Item_Quantity']. '';
					echo '</td>';
				
					echo '<td>';
						echo '+' .stripslashes($Item['Item_HP_Effect']). " HP<br />";
						echo '+' .stripslashes($Item['Item_MP_Effect']). " MP<br />";
						echo '+' .stripslashes($Item['Item_Strength_Effect']). " $Inventory_19<br />";
						echo '+' .stripslashes($Item['Item_Magic_Effect']). " $Inventory_20<br />";
						echo '+' .stripslashes($Item['Item_Agility_Effect']). " $Inventory_21<br />";
						echo '+' .stripslashes($Item['Item_Defense_Effect']). " $Inventory_22";
						echo '+' .stripslashes($Item['Item_Sagesse_Effect']). " $Inventory_22";
					echo '</td>';
				
					echo '<td>';
						echo '' .$Item['Item_Sale_Price']. '';
					echo '</td>';
				
					$Inventory_ID = stripslashes($Item['Inventory_ID']);
					$Item_ID = stripslashes($Item['Item_ID']);
					$Item_Name = stripslashes($Item['Item_Name']);
					$Item_Quantity = stripslashes($Item['Inventory_Item_Quantity']);
					$Item_Sale_Price = stripslashes($Item['Item_Sale_Price']);
				
					echo '<td>';
						echo '<form method="POST" action="Inventory.php">';
						echo "<input type=\"hidden\" name=\"Inventory_ID\" value=\"$Inventory_ID\">";
						echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Item_ID\">";
						echo "<input type=\"submit\" name=\"Use\" value=\"$Inventory_35\">";
						echo '</form>';
						echo '<form method="POST" action="Inventory.php">';
						echo "<input type=\"hidden\" name=\"Inventory_ID\" value=\"$Inventory_ID\">";
						echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Item_ID\">";
						echo "<input type=\"submit\" name=\"Sale\" value=\"$Inventory_26\"><br /><br />";
						echo '</form>';
					echo '</td>';
				echo '</tr>';
			}
			$Item_Query->closeCursor();
	
			echo '</table>';
			echo '<form method="POST" action="Inventory.php"><br />';
			echo "<input type=\"submit\" name=\"Cancel\" value=\"$Inventory_24\">";
			echo '</form>';
		}
		if (isset($_POST['Item_Equip']))
		{	
			$Item_ID = htmlspecialchars(addslashes($_POST['Item_ID']));
			$Inventory_ID = htmlspecialchars(addslashes($_POST['Inventory_ID']));
		
			$Item_Query_List = $bdd->prepare("SELECT * FROM Caranille_Inventory, Caranille_Items
			WHERE Item_ID = ?
			AND Inventory_ID = ?
			AND Inventory_Account_ID = ?");
			$Item_Query_List->execute(array($Item_ID, $Inventory_ID, $ID));
			while ($Item_Query = $Item_Query_List->fetch())
			{
				$_SESSION['Item_ID'] = $Item_Query['Item_ID'];
				$_SESSION['Item_Level_Required'] = $Item_Query['Item_Level_Required'];
				$_SESSION['Item_Quantity'] = $Item_Query['Inventory_Item_Quantity'];
				$_SESSION['Item_Sale_Price'] = $Item_Query['Item_Sale_Price'];
			}
			$Item_ID = $_SESSION['Item_ID'];
			$Item_Level_Required = $_SESSION['Item_Level_Required'];
			$Item_Quantity = $_SESSION['Item_Quantity'];
			$Item_Sale_Price = $_SESSION['Item_Sale_Price'];
		
			if ($_SESSION['Level'] >= $Item_Level_Required)
			{
				if ($_SESSION['Armor_Inventory_ID'] == 0 || $_SESSION['Boots_Inventory_ID'] == 0 || $_SESSION['Gloves_Inventory_ID'] == 0 || $_SESSION['Helmet_Inventory_ID'] == 0 || $_SESSION['Weapon_Inventory_ID'] == 0)
				{
					$Update_Account = $bdd->prepare("UPDATE Caranille_Inventory SET Inventory_Item_Equipped= 'Yes' 
					WHERE Inventory_ID = :Inventory_ID
					AND Inventory_Item_ID= :Item_ID");
					$Update_Account->execute(array('Inventory_ID'=> $Inventory_ID, 'Item_ID'=> $Item_ID));
				}
				else
				{
					$Update_Account = $bdd->prepare("UPDATE Caranille_Inventory SET Inventory_Item_Equipped= 'No' 
					WHERE Inventory_ID = :Inventory_ID
					AND Inventory_Item_ID = :Item_ID");
					$Update_Account->execute(array('Inventory_ID'=> $Inventory_ID, 'Item_ID'=> $Item_ID));

					$Update_Account = $bdd->prepare("UPDATE Caranille_Inventory SET Inventory_Item_Equipped= 'Yes' 
					WHERE Inventory_ID = :Inventory_ID
					AND Inventory_Item_ID= :Item_ID");
					$Update_Account->execute(array('Inventory_ID'=> $Inventory_ID, 'Item_ID'=> $Item_ID));
				}
				echo "$Inventory_36";
			}
			else
			{
				echo "$Inventory_37";
			}
		}
		if (isset($_POST['Sale']))
		{	
			$Item_ID = htmlspecialchars(addslashes($_POST['Item_ID']));
			$Inventory_ID = htmlspecialchars(addslashes($_POST['Inventory_ID']));
			$Item_Query_List = $bdd->prepare("SELECT * FROM Caranille_Inventory, Caranille_Items
			WHERE Item_ID = ?
			AND Inventory_ID = ?
			AND Inventory_Account_ID = ?");
			$Item_Query_List->execute(array($Item_ID, $Inventory_ID, $ID));
			while ($Item_Query = $Item_Query_List->fetch())
			{
				$_SESSION['Item_ID'] = $Item_Query['Item_ID'];
				$_SESSION['Item_Level_Required'] = $Item_Query['Item_Level_Required'];
				$_SESSION['Item_Quantity'] = $Item_Query['Inventory_Item_Quantity'];
				$_SESSION['Item_Sale_Price'] = $Item_Query['Item_Sale_Price'];
			}
			$Item_ID = $_SESSION['Item_ID'];
			$Item_Level_Required = $_SESSION['Item_Level_Required'];
			$Item_Quantity = $_SESSION['Item_Quantity'];
			$Item_Sale_Price = $_SESSION['Item_Sale_Price'];

			if ($Item_Quantity >=2)
			{
				$Update_Account =  $bdd->prepare("UPDATE Caranille_Accounts SET Account_Golds = Account_Golds + :Item_Sale_Price
				WHERE Account_ID = :ID");
				$Update_Account ->execute(array('Item_Sale_Price'=> $Item_Sale_Price, 'ID'=> $ID));

				$Update_Account = $bdd->prepare("UPDATE Caranille_Inventory
				SET Inventory_Item_Quantity = Inventory_Item_Quantity -1
				WHERE Inventory_ID = :Inventory_ID");

				$Update_Account->execute(array('Inventory_ID'=> $Inventory_ID));
				echo "$Inventory_38";
			}
			else
			{
				if ($Inventory_ID == $_SESSION['Armor_Inventory_ID'] || $Inventory_ID == $_SESSION['Boots_Inventory_ID'] ||$Inventory_ID == $_SESSION['Gloves_Inventory_ID'] || $Inventory_ID == $_SESSION['Helmet_Inventory_ID'] || $Inventory_ID == $_SESSION['Weapon_Inventory_ID'])
				{
					echo "$Inventory_39<br />";
				}
				else
				{
					$Update_Account =  $bdd->prepare("UPDATE Caranille_Accounts SET Account_Golds = Account_Golds + :Item_Sale_Price
					WHERE Account_ID = :ID");
					$Update_Account ->execute(array('Item_Sale_Price'=> $Item_Sale_Price, 'ID'=> $ID));

					$Update_Account = $bdd->prepare("DELETE FROM Caranille_Inventory
					WHERE Inventory_ID = :Inventory_ID");
					$Update_Account->execute(array('Inventory_ID'=> $Inventory_ID));
					echo "$Inventory_40 $Item_Sale_Price PO";
				}
			}
			echo '<form method="POST" action="Inventory.php">';
			echo "<input type=\"submit\" name=\"Cancel\" value=\"$Inventory_24\">";
			echo '</form>';
		}
		/*
		Module of Parchement
		*/
		if (isset($_POST['Use']))
		{
			$Item_ID = htmlspecialchars(addslashes($_POST['Item_ID']));
			$Inventory_ID = htmlspecialchars(addslashes($_POST['Inventory_ID']));
		    
			$Item_Query_List = $bdd->prepare("SELECT * FROM Caranille_Inventory, Caranille_Items
			WHERE Item_ID = ?
			AND Inventory_ID = ?
			AND Inventory_Account_ID = ?");
			$Item_Query_List->execute(array($Item_ID, $Inventory_ID, $ID));
			while ($Item_Query = $Item_Query_List->fetch())
			{
				$_SESSION['Inventory_Item_Quantity'] = $Item_Query['Inventory_Item_Quantity'];
			}
		    
			$Item_List_Query = $bdd->prepare("SELECT * FROM Caranille_Items WHERE Item_ID = :Item_ID");
			$Item_List_Query->execute(array('Item_ID' => $Item_ID));
			while ($Item_List = $Item_List_Query->fetch())
			{
				$_SESSION['Item_HP_Effect'] = $Item_List['Item_HP_Effect'];
				$_SESSION['Item_MP_Effect'] = $Item_List['Item_MP_Effect'];
				$_SESSION['Item_Strength_Effect'] = $Item_List['Item_Strength_Effect'];
				$_SESSION['Item_Magic_Effect'] = $Item_List['Item_Magic_Effect'];
				$_SESSION['Item_Agility_Effect'] = $Item_List['Item_Agility_Effect'];
				$_SESSION['Item_Defense_Effect'] = $Item_List['Item_Defense_Effect'];
				$_SESSION['Item_Sagesse_Effect'] = $Item_List['Item_Sagesse_Effect'];
			}
				$Item_HP_Effect = $_SESSION['Item_HP_Effect'];
				$Item_MP_Effect = $_SESSION['Item_MP_Effect'];
				$Item_Strength_Effect = $_SESSION['Item_Strength_Effect'];
				$Item_Magic_Effect = $_SESSION['Item_Magic_Effect'];
				$Item_Agility_Effect = $_SESSION['Item_Agility_Effect'];
				$Item_Defense_Effect = $_SESSION['Item_Agility_Effect'];
				$Item_Sagesse_Effect = $_SESSION['Item_Sagesse_Effect'];
				$Item_Quantity = $_SESSION['Inventory_Item_Quantity'];
		
			if ($Item_Quantity >= 2)
			{
		       		$Update_Account = $bdd->prepare("UPDATE Caranille_Inventory
				SET Inventory_Item_Quantity = Inventory_Item_Quantity -1
				WHERE Inventory_ID = :Inventory_ID");
				$Update_Account->execute(array('Inventory_ID'=> $Inventory_ID));
			
		    		$Update_Stats = $bdd->prepare("UPDATE Caranille_Accounts SET 
				Account_HP_Bonus = Account_HP_Bonus + :Item_HP_Effect, 
				Account_MP_Bonus = Account_MP_Bonus + :Item_MP_Effect, 
				Account_Strength_Bonus = Account_Strength_Bonus + :Item_Strength_Effect, 
				Account_Magic_Bonus = Account_Magic_Bonus + :Item_Magic_Effect, 
				Account_Agility_Bonus = Account_Agility_Bonus + :Item_Agility_Effect, 
				Account_Defense_Bonus = Account_Defense_Bonus + :Item_Defense_Effect, 
				Account_Sagesse_Bonus = Account_Sagesse_Bonus + :Item_Sagesse_Effect
				WHERE Account_ID = :ID");

				$Update_Stats->execute(array(
				'Item_HP_Effect' => $Item_HP_Effect, 
				'Item_MP_Effect' => $Item_MP_Effect, 
				'Item_Strength_Effect' => $Item_Strength_Effect, 
				'Item_Magic_Effect' => $Item_Magic_Effect, 
				'Item_Agility_Effect' => $Item_Agility_Effect, 
				'Item_Defense_Effect' => $Item_Defense_Effect, 
				'Item_Sagesse_Effect' => $Item_Sagesse_Effect, 
				'ID' => $ID));
				echo "$Inventory_41";
			
			}
			else
			{
				$Update_Account = $bdd->prepare("DELETE FROM Caranille_Inventory
				WHERE Inventory_ID = :Inventory_ID");
				$Update_Account->execute(array('Inventory_ID'=> $Inventory_ID));
			
		    		$Update_Stats = $bdd->prepare("UPDATE Caranille_Accounts SET 
				Account_HP_Bonus = Account_HP_Bonus + :Item_HP_Effect, 
				Account_MP_Bonus = Account_MP_Bonus + :Item_MP_Effect, 
				Account_Strength_Bonus = Account_Strength_Bonus + :Item_Strength_Effect, 
				Account_Magic_Bonus = Account_Magic_Bonus + :Item_Magic_Effect, 
				Account_Agility_Bonus = Account_Agility_Bonus + :Item_Agility_Effect, 
				Account_Defense_Bonus = Account_Defense_Bonus + :Item_Defense_Effect, 
				Account_Sagesse_Bonus = Account_Sagesse_Bonus + :Item_Sagesse_Effect 
				WHERE Account_ID = :ID");

				$Update_Stats->execute(array(
				'Item_HP_Effect' => $Item_HP_Effect, 
				'Item_MP_Effect' => $Item_MP_Effect, 
				'Item_Strength_Effect' => $Item_Strength_Effect, 
				'Item_Magic_Effect' => $Item_Magic_Effect, 
				'Item_Agility_Effect' => $Item_Agility_Effect, 
				'Item_Defense_Effect' => $Item_Defense_Effect, 
				'Item_Sagesse_Effect' => $Item_Sagesse_Effect, 
				'ID' => $ID));
				echo "$Inventory_41";
			}
		}
	}
	else
	{
		echo "$Inventory_42";
	}	
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
