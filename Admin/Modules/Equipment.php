<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	//Si le Access est administration, afficher le menu de l'administration
	if ($_SESSION['Access'] == "Admin")
	{
		if (empty($_POST['Edit']) && empty($_POST['Second_Edit']) && (empty($_POST['Add'])))
		{
			echo "$AEquipment_0<br />";
			echo '<form method="POST" action="Equipment.php">';
			echo "<input type=\"submit\" name=\"Add\" value=\"$AEquipment_1\">";
			echo "<input type=\"submit\" name=\"Edit\" value=\"$AEquipment_2\">";
			echo '</form>';
		}
		if (isset($_POST['Edit']))
		{
			$Equipment_List_Query = $bdd->query("SELECT * FROM Caranille_Items WHERE Item_Type = 'Armor' || Item_Type = 'Boots' || Item_Type = 'Gloves' || Item_Type = 'Helmet' || Item_Type = 'Weapon'");
			while ($Equipment_List = $Equipment_List_Query->fetch())
			{
				echo "$AEquipment_3 " .stripslashes($Equipment_List['Item_Name']). '<br />';
				$Item_ID = stripslashes($Equipment_List['Item_ID']);
				echo '<form method="POST" action="Equipment.php">';
				echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Item_ID\">";
				echo "<input type=\"submit\" name=\"Second_Edit\" value=\"$AEquipment_4\">";
				echo "<input type=\"submit\" name=\"Delete\" value=\"$AEquipment_5\">";
				echo '</form>';
			}
			$Equipment_List_Query->closeCursor();

		}
		if (isset($_POST['Second_Edit']))
		{
			$Item_ID = htmlspecialchars(addslashes($_POST['Item_ID']));

			$Equipment_List_Query = $bdd->prepare("SELECT * FROM Caranille_Items WHERE Item_ID= ?");
			$Equipment_List_Query->execute(array($Item_ID));

			while ($Equipment_List = $Equipment_List_Query->fetch())
			{
				$_SESSION['Item_ID'] = stripslashes($Equipment_List['Item_ID']);
				$Item_Image = stripslashes($Equipment_List['Item_Image']);
				$Item_Type = stripslashes($Equipment_List['Item_Type']);
				$Item_Level_Required = stripslashes($Equipment_List['Item_Level_Required']);
				$Item_Name = stripslashes($Equipment_List['Item_Name']);
				$Item_Description = stripslashes($Equipment_List['Item_Description']);
				$Item_HP_Effect = stripslashes($Equipment_List['Item_HP_Effect']);
				$Item_MP_Effect = stripslashes($Equipment_List['Item_MP_Effect']);
				$Item_Strength_Effect = stripslashes($Equipment_List['Item_Strength_Effect']);
				$Item_Magic_Effect = stripslashes($Equipment_List['Item_Magic_Effect']);
				$Item_Agility_Effect = stripslashes($Equipment_List['Item_Agility_Effect']);
				$Item_Defense_Effect = stripslashes($Equipment_List['Item_Defense_Effect']);
				$Item_Sagesse_Effect = stripslashes($Equipment_List['Item_Sagesse_Effect']);
				$Item_Purchase_Price = stripslashes($Equipment_List['Item_Purchase_Price']);
				$Item_Sale_Price = stripslashes($Equipment_List['Item_Sale_Price']);
				$Item_Town = stripslashes($Equipment_List['Item_Town']);
			}

			$Equipment_List_Query->closeCursor();

			echo '<br /><br />';
			echo '<form method="POST" action="Equipment.php">';
			echo "$AEquipment_6<br /> <input type=\"text\" name=\"Item_Image\" value=\"$Item_Image\"><br /><br />";
			echo "<div class=\"important\">$AEquipment_7<br /></div>";
			echo '<select name="Item_Type" ID="Item_Type">';
				echo "<option value=\"Weapon\">$AEquipment_8</option>";
				echo "<option value=\"Armor\">$AEquipment_9</option>";
				echo "<option value=\"Helmet\">$AEquipment_10</option>";
				echo "<option value=\"Boots\">$AEquipment_11</option>";
				echo "<option value=\"Gloves\">$AEquipment_12</option>";
				echo "<option value=\"Parchment\">$AEquipment_13</option>";
			echo '</select><br /><br />';
			echo "$AEquipment_14<br /> <input type=\"text\" name=\"Item_Level_Required\" value=\"$Item_Level_Required\"><br /><br />";
			echo "$AEquipment_3<br /> <input type=\"text\" name=\"Item_Name\" value=\"$Item_Name\"><br /><br />";
			echo "$AEquipment_15<br /><textarea name=\"Item_Description\" ID=\"message\" rows=\"10\" cols=\"50\">$Item_Description</textarea><br /><br />";
			echo "$AEquipment_16<br /> <input type=\"text\" name=\"Item_HP_Effect\" value=\"$Item_HP_Effect\"><br /><br />";
			echo "$AEquipment_17<br /> <input type=\"text\" name=\"Item_MP_Effect\" value=\"$Item_MP_Effect\"><br /><br />";
			echo "$AEquipment_18<br /> <input type=\"text\" name=\"Item_Strength_Effect\" value=\"$Item_Strength_Effect\"><br /><br />";
			echo "$AEquipment_19<br /> <input type=\"text\" name=\"Item_Magic_Effect\" value=\"$Item_Magic_Effect\"><br /><br />";
			echo "$AEquipment_20<br /> <input type=\"text\" name=\"Item_Agility_Effect\" value=\"$Item_Agility_Effect\"><br /><br />";
			echo "$AEquipment_21<br /> <input type=\"text\" name=\"Item_Defense_Effect\" value=\"$Item_Defense_Effect\"><br /><br />";
			echo "$AEquipment_22<br /> <input type=\"text\" name=\"Item_Sagesse_Effect\" value=\"$Item_Sagesse_Effect\"><br /><br />";
			echo "$AEquipment_23<br /> <input type=\"text\" name=\"Item_Purchase_Price\" value=\"$Item_Purchase_Price\"><br /><br />";
			echo "$AEquipment_24<br /> <input type=\"text\" name=\"Item_Sale_Price\" value=\"$Item_Sale_Price\"><br /><br />";
			echo "<div class=\"important\">$AEquipment_25<br /></div>";
			echo '<select name="Item_Town" ID="Item_Town">';
			echo "<option value=\"No_Town\">$AEquipment_26</option>";
			$Town_List_Query = $bdd->query("SELECT * FROM Caranille_Towns");
			while ($Town_List = $Town_List_Query->fetch())
			{
				$Item_Town = stripslashes($Town_List['Town_Name']);
				echo "<option value=\"$Item_Town\">$Item_Town</option>";
			}
			$Town_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo "<input type=\"submit\" name=\"End_Edit\" value=\"$AEquipment_27\">";
			echo '</form>';
		}
		if (isset($_POST['End_Edit']))
		{	
			if (isset($_POST['Item_Image']) && ($_POST['Item_Name']) && ($_POST['Item_Description']) && ($_POST['Item_Town']))
			{
				$Item_ID = htmlspecialchars(addslashes($_SESSION['Item_ID']));
				$Item_Image = htmlspecialchars(addslashes($_POST['Item_Image']));
				$Item_Type = htmlspecialchars(addslashes($_POST['Item_Type']));
				$Item_Level_Required = htmlspecialchars(addslashes($_POST['Item_Level_Required']));
				$Item_Name = htmlspecialchars(addslashes($_POST['Item_Name']));
				$Item_Description = htmlspecialchars(addslashes($_POST['Item_Description']));
				$Item_HP_Effect = htmlspecialchars(addslashes($_POST['Item_HP_Effect']));
				$Item_MP_Effect = htmlspecialchars(addslashes($_POST['Item_MP_Effect']));
				$Item_Strength_Effect = htmlspecialchars(addslashes($_POST['Item_Strength_Effect']));
				$Item_Magic_Effect = htmlspecialchars(addslashes($_POST['Item_Magic_Effect']));
				$Item_Agility_Effect = htmlspecialchars(addslashes($_POST['Item_Agility_Effect']));
				$Item_Defense_Effect = htmlspecialchars(addslashes($_POST['Item_Defense_Effect']));
				$Item_Sagesse_Effect = htmlspecialchars(addslashes($_POST['Item_Sagesse_Effect']));
				$Item_Purchase_Price = htmlspecialchars(addslashes($_POST['Item_Purchase_Price']));
				$Item_Sale_Price = htmlspecialchars(addslashes($_POST['Item_Sale_Price']));
				$Item_Town = htmlspecialchars(addslashes($_POST['Item_Town']));
				if ($Item_Town == "No_Town")
				{
					$Town_ID = 0;
				}
				else
				{
					$Town_ID_List_Query = $bdd->prepare("SELECT Town_ID 
					FROM Caranille_Towns
					WHERE Town_Name = ?");
					$Town_ID_List_Query->execute(array($Item_Town));

					while ($Town_ID_List = $Town_ID_List_Query->fetch())
					{
						$Town_ID = stripslashes($Town_ID_List['Town_ID']);
					}
					$Town_ID_List_Query->closeCursor();
				}
				$Edit = $bdd->prepare("UPDATE Caranille_Items SET 
				Item_Image= :Item_Image, 
				Item_Type= :Item_Type, 
				Item_Level_Required= :Item_Level_Required, 
				Item_Name= :Item_Name, 
				Item_Description= :Item_Description, 
				Item_HP_Effect= :Item_HP_Effect, 
				Item_MP_Effect= :Item_MP_Effect, 
				Item_Strength_Effect= :Item_Strength_Effect, 
				Item_Magic_Effect= :Item_Magic_Effect,
				Item_Agility_Effect= :Item_Agility_Effect, 
				Item_Defense_Effect= :Item_Defense_Effect,
				Item_Sagesse_Effect= :Item_Sagesse_Effect,  
				Item_Town= :Town_ID, 
				Item_Purchase_Price= :Item_Purchase_Price, 
				Item_Sale_Price= :Item_Sale_Price 
				WHERE Item_ID= :Item_ID");

				$Edit->execute(array(
				'Item_Image'=> $Item_Image, 
				'Item_Type'=> $Item_Type, 
				'Item_Level_Required'=> $Item_Level_Required, 
				'Item_Name'=> $Item_Name, 
				'Item_Description'=> $Item_Description, 
				'Item_HP_Effect'=> $Item_HP_Effect, 
				'Item_MP_Effect'=> $Item_MP_Effect, 
				'Item_Strength_Effect'=> $Item_Strength_Effect, 
				'Item_Magic_Effect'=> $Item_Magic_Effect, 
				'Item_Agility_Effect'=> $Item_Agility_Effect, 
				'Item_Defense_Effect'=> $Item_Defense_Effect, 
				'Item_Sagesse_Effect'=> $Item_Sagesse_Effect,
				'Town_ID'=> $Town_ID, 
				'Item_Purchase_Price'=> $Item_Purchase_Price, 
				'Item_Sale_Price'=> $Item_Sale_Price, 
				'Item_ID'=> $Item_ID));
				echo $AEquipment_28;
			}
			else
			{
				echo $AEquipment_29;
			}
		}
		if (isset($_POST['Delete']))
		{
			$Item_ID = htmlspecialchars(addslashes($_POST['Item_ID']));
			$Delete = $bdd->prepare("DELETE FROM Caranille_Items WHERE Item_ID= ?");
			$Delete->execute(array($Item_ID));

			echo $AEquipment_30;
		}
		if (isset($_POST['Add']))
		{
			echo '</form><br /><br />';
			echo '<form method="POST" action="Equipment.php">';
			echo "$AEquipment_6<br /> <input type=\"text\" name=\"Item_Image\"><br /><br />";
			echo "<div class=\"important\">$AEquipment_7<br /></div>";
			echo '<select name="Item_Type" ID="Item_Type">';
				echo "<option value=\"Weapon\">$AEquipment_8</option>";
				echo "<option value=\"Armor\">$AEquipment_9</option>";
				echo "<option value=\"Helmet\">$AEquipment_10</option>";
				echo "<option value=\"Boots\">$AEquipment_11</option>";
				echo "<option value=\"Gloves\">$AEquipment_12</option>";
				echo "<option value=\"Parchment\">$AEquipment_13</option>";
			echo '</select><br /><br />';
			echo "$AEquipment_14<br /> <input type=\"text\" name=\"Item_Level_Required\"><br /><br />";
			echo "$AEquipment_3<br /> <input type=\"text\" name=\"Item_Name\"><br /><br />";
			echo "$AEquipment_15<br /><textarea name=\"Item_Description\" ID=\"message\" rows=\"10\" cols=\"50\"></textarea><br /><br />";
			echo "$AEquipment_16<br /> <input type=\"text\" name=\"Item_HP_Effect\"><br /><br />";
			echo "$AEquipment_17<br /> <input type=\"text\" name=\"Item_MP_Effect\"><br /><br />";
			echo "$AEquipment_18<br /> <input type=\"text\" name=\"Item_Strength_Effect\"><br /><br />";
			echo "$AEquipment_19<br /> <input type=\"text\" name=\"Item_Magic_Effect\"><br /><br />";
			echo "$AEquipment_20<br /> <input type=\"text\" name=\"Item_Agility_Effect\"><br /><br />";
			echo "$AEquipment_21<br /> <input type=\"text\" name=\"Item_Defense_Effect\"><br /><br />";
			echo "$AEquipment_22<br /> <input type=\"text\" name=\"Item_Sagesse_Effect\"><br /><br />";
			echo "$AEquipment_23<br /> <input type=\"text\" name=\"Item_Purchase_Price\"><br /><br />";
			echo "$AEquipment_24<br /> <input type=\"text\" name=\"Item_Sale_Price\"><br /><br />";
			echo "<div class=\"important\">$AEquipment_25<br /></div>";
			echo '<select name="Item_Town" ID="Item_Town">';
			echo "<option value=\"No_Town\">$AEquipment_26</option>";
			$Town_List_Query = $bdd->query("SELECT * FROM Caranille_Towns");
			while ($Town_List = $Town_List_Query->fetch())
			{
				$Item_Town = stripslashes($Town_List['Town_Name']);
				echo "<option value=\"$Item_Town\">$Item_Town</option>";
			}
			$Town_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo "<input type=\"submit\" name=\"End_Add\" value=\"$AEquipment_27\">";
			echo '</form>';
		}
		if (isset($_POST['End_Add']))
		{
			if (isset($_POST['Item_Image']) && ($_POST['Item_Name']) && ($_POST['Item_Description']) && ($_POST['Item_Type']) && ($_POST['Item_Town']))
			{
				$Item_Image = htmlspecialchars(addslashes($_POST['Item_Image']));
				$Item_Type = htmlspecialchars(addslashes($_POST['Item_Type']));
				$Item_Level_Required = htmlspecialchars(addslashes($_POST['Item_Level_Required']));
				$Item_Name = htmlspecialchars(addslashes($_POST['Item_Name']));
				$Item_Description = htmlspecialchars(addslashes($_POST['Item_Description']));
				$Item_HP_Effect = htmlspecialchars(addslashes($_POST['Item_HP_Effect']));
				$Item_MP_Effect = htmlspecialchars(addslashes($_POST['Item_MP_Effect']));
				$Item_Strength_Effect = htmlspecialchars(addslashes($_POST['Item_Strength_Effect']));
				$Item_Magic_Effect = htmlspecialchars(addslashes($_POST['Item_Magic_Effect']));
				$Item_Agility_Effect = htmlspecialchars(addslashes($_POST['Item_Agility_Effect']));
				$Item_Defense_Effect = htmlspecialchars(addslashes($_POST['Item_Defense_Effect']));
				$Item_Sagesse_Effect = htmlspecialchars(addslashes($_POST['Item_Sagesse_Effect']));
				$Item_Purchase_Price = htmlspecialchars(addslashes($_POST['Item_Purchase_Price']));
				$Item_Sale_Price = htmlspecialchars(addslashes($_POST['Item_Sale_Price']));
				$Item_Town = htmlspecialchars(addslashes($_POST['Item_Town']));
				if ($Item_Town == "No_Town" || $Item_Town=="")
				{
					$Town_ID = 0;
				}
				else
				{
					$Town_ID_List_Query = $bdd->prepare("SELECT Town_ID 
					FROM Caranille_Towns
					WHERE Town_Name = ?");
					$Town_ID_List_Query->execute(array($Item_Town));

					while ($Town_ID_List = $Town_ID_List_Query->fetch())
					{
						$Town_ID = stripslashes($Town_ID_List['Town_ID']);
					}
					$Town_ID_List_Query->closecursor();
				}
				$Add = $bdd->prepare("INSERT INTO Caranille_Items VALUES(
				'', 
				:Item_Image, 
				:Item_Type, 
				:Item_Level_Required, 
				:Item_Name, 
				:Item_Description, 
				:Item_HP_Effect, 
				:Item_MP_Effect, 
				:Item_Strength_Effect, 
				:Item_Magic_Effect, 
				:Item_Agility_Effect, 
				:Item_Defense_Effect, 
				:Item_Sagesse_Effect,
				:Town_ID, 
				:Item_Purchase_Price, 
				:Item_Sale_Price)");

				$Add->execute(array(
				'Item_Image'=> $Item_Image, 
				'Item_Type'=> $Item_Type, 
				'Item_Level_Required'=> $Item_Level_Required, 
				'Item_Name'=> $Item_Name, 
				'Item_Description'=> $Item_Description, 
				'Item_HP_Effect'=> $Item_HP_Effect, 
				'Item_MP_Effect'=> $Item_MP_Effect, 
				'Item_Strength_Effect'=> $Item_Strength_Effect, 
				'Item_Magic_Effect'=> $Item_Magic_Effect, 
				'Item_Agility_Effect'=> $Item_Agility_Effect, 
				'Item_Defense_Effect'=> $Item_Defense_Effect, 
				'Item_Sagesse_Effect'=> $Item_Sagesse_Effect, 
				'Town_ID'=> $Town_ID, 
				'Item_Purchase_Price'=> $Item_Purchase_Price, 
				'Item_Sale_Price'=> $Item_Sale_Price));
	
				echo $AEquipment_30;
			}
			else
			{
				echo $AEquipment_31;
			}
		}
	}
	else
	{
		echo '<center>';
		echo 'Vous ne possèdez pas le Access nécessaire pour accèder à cette partie du site';
		echo '</center>';
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
