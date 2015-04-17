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
			echo 'Que souhaitez-vous faire ?<br />';
			echo '<form method="POST" action="Parchments.php">';
			echo '<input type="submit" name="Add" value="Ajouter un parchemin">';
			echo '<input type="submit" name="Edit" value="Modifier un parchemin">';
			echo '</form>';
		}
		if (isset($_POST['Edit']))
		{
			$Parchement_List_Query = $bdd->query("SELECT * FROM Caranille_Items WHERE Item_Type = 'Parchment'");
			while ($Parchement_List = $Parchement_List_Query->fetch())
			{
				echo 'Nom: ' .stripslashes($Parchement_List['Item_Name']). '<br />';
				$Item_ID = stripslashes($Parchement_List['Item_ID']);
				echo '<form method="POST" action="Parchments.php">';
				echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Item_ID\">";
				echo '<input type="submit" name="Second_Edit" value="modifier">';
				echo '<input type="submit" name="Delete" value="supprimer">';
				echo '</form>';
			}
			$Parchement_List_Query->closeCursor();

		}
		if (isset($_POST['Second_Edit']))
		{
			$Item_ID = htmlspecialchars(addslashes($_POST['Item_ID']));

			$Parchement_List_Query = $bdd->prepare("SELECT * FROM Caranille_Items WHERE Item_ID= ?");
			$Parchement_List_Query->execute(array($Item_ID));

			while ($Parchement_List = $Parchement_List_Query->fetch())
			{
				$_SESSION['Item_ID'] = stripslashes($Parchement_List['Item_ID']);
				$Item_Image = stripslashes($Parchement_List['Item_Image']);
				$Item_Level_Required = stripslashes($Parchement_List['Item_Level_Required']);
				$Item_Name = stripslashes($Parchement_List['Item_Name']);
				$Item_Description = stripslashes($Parchement_List['Item_Description']);
				$Item_HP_Effect = stripslashes($Parchement_List['Item_HP_Effect']);
				$Item_MP_Effect = stripslashes($Parchement_List['Item_MP_Effect']);
				$Item_Strength_Effect = stripslashes($Parchement_List['Item_Strength_Effect']);
				$Item_Magic_Effect = stripslashes($Parchement_List['Item_Magic_Effect']);
				$Item_Agility_Effect = stripslashes($Parchement_List['Item_Agility_Effect']);
				$Item_Defense_Effect = stripslashes($Parchement_List['Item_Defense_Effect']);
				$Item_Sagesse_Effect = stripslashes($Parchement_List['Item_Sagesse_Effect']);
				$Item_Purchase_Price = stripslashes($Parchement_List['Item_Purchase_Price']);
				$Item_Sale_Price = stripslashes($Parchement_List['Item_Sale_Price']);
				$Item_Town = stripslashes($Parchement_List['Item_Town']);
			}

			$Parchement_List_Query->closeCursor();

			echo '<br /><br />';
			echo '<form method="POST" action="Parchments.php">';
			echo "Image (Adresse)<br /> <input type=\"text\" name=\"Item_Image\" value=\"$Item_Image\"><br /><br />";
			echo "Niveau requis<br /> <input type=\"text\" name=\"Item_Level_Required\" value=\"$Item_Level_Required\"><br /><br />";
			echo "Nom<br /> <input type=\"text\" name=\"Item_Name\" value=\"$Item_Name\"><br /><br />";
			echo "description<br /><textarea name=\"Item_Description\" ID=\"message\" rows=\"10\" cols=\"50\">$Item_Description</textarea><br /><br />";
			echo "HP +<br /> <input type=\"text\" name=\"Item_HP_Effect\" value=\"$Item_HP_Effect\"><br /><br />";
			echo "MP +<br /> <input type=\"text\" name=\"Item_MP_Effect\" value=\"$Item_MP_Effect\"><br /><br />";
			echo "Force +<br /> <input type=\"text\" name=\"Item_Strength_Effect\" value=\"$Item_Strength_Effect\"><br /><br />";
			echo "Magie +<br /> <input type=\"text\" name=\"Item_Magic_Effect\" value=\"$Item_Magic_Effect\"><br /><br />";
			echo "Agilité +<br /> <input type=\"text\" name=\"Item_Agility_Effect\" value=\"$Item_Agility_Effect\"><br /><br />";
			echo "Defense +<br /> <input type=\"text\" name=\"Item_Defense_Effect\" value=\"$Item_Defense_Effect\"><br /><br />";
			echo "Sagesse +<br /> <input type=\"text\" name=\"Item_Sagesse_Effect\" value=\"$Item_Sagesse_Effect\"><br /><br />";
			echo "Prix d'achat de l'objet<br /> <input type=\"text\" name=\"Item_Purchase_Price\" value=\"$Item_Purchase_Price\"><br /><br />";
			echo "Prix de vente de l'objet<br /> <input type=\"text\" name=\"Item_Sale_Price\" value=\"$Item_Sale_Price\"><br /><br />";
			echo '<div class="important">Dans quelle ville se trouve t\'il ?<br /></div>';
			echo '<select name="Item_Town" ID="Item_Town">';
			echo '<option value="Aucune ville">Aucune ville</option>';
			$Town_List_Query = $bdd->query("SELECT * FROM Caranille_Towns");
			while ($Town_List = $Town_List_Query->fetch())
			{
				$Item_Town = stripslashes($Town_List['Town_Name']);
				echo "<option value=\"$Item_Town\">$Item_Town</option>";
			}
			$Town_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo '<input type="submit" name="End_Edit" value="Terminer">';
			echo '</form>';
		}
		if (isset($_POST['End_Edit']))
		{	
			if (isset($_POST['Item_Image']) && ($_POST['Item_Name']) && ($_POST['Item_Description']) && ($_POST['Item_Town']))
			{
				$Item_ID = htmlspecialchars(addslashes($_SESSION['Item_ID']));
				$Item_Image = htmlspecialchars(addslashes($_POST['Item_Image']));
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
				if ($Item_Town == "Aucune ville")
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
				$Edit = $bdd->prepare("UPDATE Caranille_Items SET Item_Image= :Item_Image, Item_Level_Required= :Item_Level_Required, Item_Name= :Item_Name, Item_Description= :Item_Description, Item_HP_Effect= :Item_HP_Effect, Item_MP_Effect= :Item_MP_Effect, Item_Strength_Effect= :Item_Strength_Effect, Item_Magic_Effect= :Item_Magic_Effect, Item_Agility_Effect= :Item_Agility_Effect, Item_Defense_Effect= :Item_Defense_Effect, Item_Sagesse_Effect = :Item_Sagesse_Effect, Item_Town= :Town_ID, Item_Purchase_Price= :Item_Purchase_Price, Item_Sale_Price= :Item_Sale_Price WHERE Item_ID= :Item_ID");
				$Edit->execute(array('Item_Image'=> $Item_Image, 'Item_Level_Required'=> $Item_Level_Required, 'Item_Name'=> $Item_Name, 'Item_Description'=> $Item_Description, 'Item_HP_Effect'=> $Item_HP_Effect, 'Item_MP_Effect'=> $Item_MP_Effect, 'Item_Strength_Effect'=> $Item_Strength_Effect, 'Item_Magic_Effect'=> $Item_Magic_Effect, 'Item_Agility_Effect'=> $Item_Agility_Effect, 'Item_Defense_Effect'=> $Item_Defense_Effect, 'Item_Sagesse_Effect'=> $Item_Sagesse_Effect, 'Town_ID'=> $Town_ID, 'Item_Purchase_Price'=> $Item_Purchase_Price, 'Item_Sale_Price'=> $Item_Sale_Price, 'Item_ID'=> $Item_ID));
				echo 'Parchemin mis à jour';
			}
			else
			{
				echo 'Tous les champs n\'ont pas été remplis';
			}
		}
		if (isset($_POST['Delete']))
		{
			$Item_ID = htmlspecialchars(addslashes($_POST['Item_ID']));
			$Delete = $bdd->prepare("DELETE FROM Caranille_Items WHERE Item_ID= ?");
			$Delete->execute(array($Item_ID));

			echo 'Le parchemin a bien été supprimé';
		}
		if (isset($_POST['Add']))
		{
			echo '</form><br /><br />';
			echo '<form method="POST" action="Parchments.php">';
			echo 'Image (Adresse)<br /> <input type="text" name="Item_Image"><br /><br />';
			echo 'Niveau requis<br /> <input type="text" name="Item_Level_Required"><br /><br />';
			echo 'Nom<br /> <input type="text" name="Item_Name"><br /><br />';
			echo 'description<br /><textarea name="Item_Description" ID="message" rows="10" cols="50"></textarea><br /><br />';
			echo 'HP +<br /> <input type="text" name="Item_HP_Effect"><br /><br />';
			echo 'MP +<br /> <input type="text" name="Item_MP_Effect"><br /><br />';
			echo 'Force +<br /> <input type="text" name="Item_Strength_Effect"><br /><br />';
			echo 'Magie +<br /> <input type="text" name="Item_Magic_Effect"><br /><br />';
			echo 'Agilité +<br /> <input type="text" name="Item_Agility_Effect"><br /><br />';
			echo 'Defense +<br /> <input type="text" name="Item_Defense_Effect"><br /><br />';
			echo 'Sagesse +<br /> <input type="text" name="Item_Sagesse_Effect"><br /><br />';
			echo 'Prix d\'achat de l\'objet<br /> <input type="text" name="Item_Purchase_Price"><br /><br />';
			echo 'Prix de vente de l\'objet<br /> <input type="text" name="Item_Sale_Price"><br /><br />';
			echo '<div class="important">Dans quelle ville se trouve t\'il ?<br /></div>';
			echo '<select name="Item_Town" ID="Item_Town">';
			echo '<option value="Aucune ville">Aucune ville</option>';
			$Town_List_Query = $bdd->query("SELECT * FROM Caranille_Towns");
			while ($Town_List = $Town_List_Query->fetch())
			{
				$Item_Town = stripslashes($Town_List['Town_Name']);
				echo "<option value=\"$Item_Town\">$Item_Town</option>";
			}
			$Town_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo '<input type="submit" name="End_Add" value="Terminer">';
			echo '</form>';
		}
		if (isset($_POST['End_Add']))
		{
			if (isset($_POST['Item_Image']) && ($_POST['Item_Name']) && ($_POST['Item_Description']) && ($_POST['Item_Town']))
			{
				$Item_Image = htmlspecialchars(addslashes($_POST['Item_Image']));
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
				if ($Item_Town == "Aucune ville" || $Item_Town=="")
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
				$Add = $bdd->prepare("INSERT INTO Caranille_Items VALUES('', :Item_Image, 'Parchment', :Item_Level_Required, :Item_Name, :Item_Description, :Item_HP_Effect, :Item_MP_Effect, :Item_Strength_Effect, :Item_Magic_Effect, :Item_Agility_Effect, :Item_Defense_Effect, :Item_Sagesse_Effect, :Town_ID, :Item_Purchase_Price, :Item_Sale_Price)");
				$Add->execute(array('Item_Image'=> $Item_Image, 'Item_Level_Required'=> $Item_Level_Required, 'Item_Name'=> $Item_Name, 'Item_Description'=> $Item_Description, 'Item_HP_Effect'=> $Item_HP_Effect, 'Item_MP_Effect'=> $Item_MP_Effect, 'Item_Strength_Effect'=> $Item_Strength_Effect, 'Item_Magic_Effect'=> $Item_Magic_Effect, 'Item_Agility_Effect'=> $Item_Agility_Effect, 'Item_Defense_Effect'=> $Item_Defense_Effect, 'Item_Sagesse_Effect'=> $Item_Sagesse_Effect, 'Town_ID'=> $Town_ID, 'Item_Purchase_Price'=> $Item_Purchase_Price, 'Item_Sale_Price'=> $Item_Sale_Price));
			}
			else
			{
				echo 'Tous les champs n\'ont pas été remplis';
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
