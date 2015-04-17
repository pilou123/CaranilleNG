<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	//Si le Access est administration, afficher le menu de l'administration
	if ($_SESSION['Access'] == "Admin")
	{
		if (empty($_POST['Edit'])&& empty($_POST['Second_Edit']) && (empty($_POST['Add'])))
		{
			echo 'Que souhaitez-vous faire ?<br />';
			echo '<form method="POST" action="Magics.php">';
			echo '<input type="submit" name="Add" value="Ajouter une magie">';
			echo '<input type="submit" name="Edit" value="Modifier une magie">';
			echo '</form>';
		}
		if (isset($_POST['Edit']))
		{
			$Magics_List_Query = $bdd->query("SELECT * FROM Caranille_Magics");
			while ($Magics = $Magics_List_Query->fetch())
			{
				echo 'Nom: ' .$Magics['Magic_Name']. '<br />';
				$Magic_ID = stripslashes($Magics['Magic_ID']);
				echo '<form method="POST" action="Magics.php">';
				echo "<input type=\"hidden\" name=\"Magic_ID\" value=\"$Magic_ID\">";
				echo '<input type="submit" name="Second_Edit" value="modifier">';
				echo '<input type="submit" name="Delete" value="supprimer">';
				echo '</form>';
			}
		}
		if (isset($_POST['Second_Edit']))
		{
			$Magic_ID = $_POST['Magic_ID'];

			$Magics_List_Query = $bdd->prepare("SELECT * FROM Caranille_Magics WHERE Magic_ID= ?");
			$Magics_List_Query->execute(array($Magic_ID));

			while ($Magics = $Magics_List_Query->fetch())
			{
				$_SESSION['Magic_ID'] = stripslashes($Magics['Magic_ID']);
				$Magic_Image = stripslashes($Magics['Magic_Image']);
				$Magic_Name = stripslashes($Magics['Magic_Name']);
				$Magic_Description = stripslashes($Magics['Magic_Description']);
				$Magic_Type = stripslashes($Magics['Magic_Type']);
				$Magic_Effect = stripslashes($Magics['Magic_Effect']);
				$Magic_MP_Cost = stripslashes($Magics['Magic_MP_Cost']);
				$Magic_Town = stripslashes($Magics['Magic_Town']);
				$Magic_Price = stripslashes($Magics['Magic_Price']);	
			}

			$Magics_List_Query->closeCursor();

			echo '<form method="POST" action="Magics.php">';
			echo "Image (Adresse)<br /> <input type=\"text\" name=\"Magic_Image\" value=\"$Magic_Image\"><br /><br />";
			echo "Nom<br /> <input type=\"text\" name=\"Magic_Name\" value=\"$Magic_Name\"><br /><br />";
			echo "description<br /><textarea name=\"Magic_Description\" ID=\"message\" rows=\"10\" cols=\"50\">$Magic_Description</textarea><br /><br />";
			echo 'Type de la magie <br />';
			echo "<select name=\"Magic_Type\" ID=\"Magic_Type\">";
			if ($Magic_Type == "Attack")
			{
				echo "<option selected=\"selected\" value=\"$Magic_Type\">$Magic_Type</option>";
				echo '<option value="Health">Soin</option>';
			}
			if ($Magic_Type == "Health")
			{
				echo "<option selected=\"selected\" value=\"$Magic_Type\">$Magic_Type</option>";
				echo '<option value="Attack">Attaque</option>';
			}
			echo '</select><br /><br />';
			echo "effet de la magie<br /> <input type=\"text\" name=\"Magic_Effect\" value=\"$Magic_Effect\"><br /><br />";
			echo "Cout de la magie<br /> <input type=\"text\" name=\"Magic_MP_Cost\" value=\"$Magic_MP_Cost\"><br /><br />";
			echo "Pièce d'or<br /> <input type=\"text\" name=\"Magic_Price\" value=\"$Magic_Price\"><br /><br />";
			echo 'Ville de la magie <br />';
			echo '<select name="Magic_Town" ID="Magic_Town">';
			$Towns_List_Query = $bdd->query("SELECT * FROM Caranille_Towns");
			while ($Towns_List = $Towns_List_Query->fetch())
			{
				$Magic_Town = stripslashes($Towns_List['Town_Name']);
				echo "<option value=\"$Magic_Town\">$Magic_Town</option>";
			}

			$Towns_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo '<input type="submit" name="End_Edit" value="Modifier"><br /><br />';
			echo '</form>';
		}
		if (isset($_POST['End_Edit']))
		{
			if (isset($_POST['Magic_Image']) && ($_POST['Magic_Name']) && ($_POST['Magic_Description']) && ($_POST['Magic_Type']) && ($_POST['Magic_Town']))
			{
				$Magic_ID = htmlspecialchars(addslashes($_SESSION['Magic_ID']));
				$Magic_Image = htmlspecialchars(addslashes($_POST['Magic_Image']));
				$Magic_Name = htmlspecialchars(addslashes($_POST['Magic_Name']));
				$Magic_Description = htmlspecialchars(addslashes($_POST['Magic_Description']));
				$Magic_Type = htmlspecialchars(addslashes($_POST['Magic_Type']));
				$Magic_Effect = htmlspecialchars(addslashes($_POST['Magic_Effect']));
				$Magic_MP_Cost = htmlspecialchars(addslashes($_POST['Magic_MP_Cost']));
				$Magic_Town = htmlspecialchars(addslashes($_POST['Magic_Town']));
				$recherche_Town_ID = $bdd->prepare("SELECT Town_ID 
				FROM Caranille_Towns
				WHERE Town_Name = ?");
				$recherche_Town_ID->execute(array($Magic_Town));

				while ($Town_ID = $recherche_Town_ID->fetch())
				{
					$Town_ID_choisit = stripslashes($Town_ID['Town_ID']);
				}

				$recherche_Town_ID->closeCursor();

				$Magic_Price = htmlspecialchars(addslashes($_POST['Magic_Price']));

				$Edit = $bdd->prepare("UPDATE Caranille_Magics SET Magic_Image= :Magic_Image, Magic_Name= :Magic_Name, Magic_Description= :Magic_Description, Magic_Type= :Magic_Type, Magic_Effect= :Magic_Effect, Magic_MP_Cost= :Magic_MP_Cost, Magic_Town= :Town_ID_choisit, Magic_Price= :Magic_Price WHERE Magic_ID= :Magic_ID");
				$Edit->execute(array('Magic_Image'=> $Magic_Image, 'Magic_Name'=> $Magic_Name, 'Magic_Description'=> $Magic_Description, 'Magic_Type'=> $Magic_Type, 'Magic_Effect'=> $Magic_Effect, 'Magic_MP_Cost'=> $Magic_MP_Cost, 'Town_ID_choisit'=> $Town_ID_choisit, 'Magic_Price'=> $Magic_Price, 'Magic_ID'=> $Magic_ID));
				
				echo 'Magie mis à jour';
			}
			else
			{
				echo 'Tous les champs n\'ont pas été remplis';
			}
		}
		if (isset($_POST['Delete']))
		{
			$Magic_ID = htmlspecialchars(addslashes($_POST['Magic_ID']));

			$Delete = $bdd->prepare("DELETE FROM Caranille_Magics WHERE Magic_ID= :Magic_ID");
			$Delete->execute(array('Magic_ID'=> $Magic_ID));

			echo 'La magie a bien été supprimé';
		}
		if (isset($_POST['Add']))
		{
			echo 'Ajout d\'une magie<br />';
			echo '<form method="POST" action="Magics.php">';
			echo 'Image (Adresse)<br /> <input type="text" name="Magic_Image"><br /><br />';
			echo 'Nom<br /> <input type="text" name="Magic_Name"><br /><br />';
			echo 'description<br /><textarea name="Magic_Description" ID="message" rows="10" cols="50"></textarea><br /><br />';
			echo 'Type de la magie<br />';
			echo '<select name="Magic_Type" ID="Magic_Type">';
				echo '<option value="Attack">Attaque</option>';
				echo '<option value="Health">Soin</option>';
			echo '</select><br /><br />';
			echo 'Effet de la magie<br /> <input type="text" name="Magic_Effect"><br /><br />';
			echo 'Cout de la magie<br /> <input type="text" name="Magic_MP_Cost"><br /><br />';				
			echo 'Pièce d\'or<br /> <input type="text" name="Magic_Price"><br /><br />';
			echo 'Ville où se trouve la magie<br />';
			echo '<select name="Magic_Town" ID="Magic_Town">';
			$Towns_List_Query = $bdd->query("SELECT * FROM Caranille_Towns");
			while ($Towns_List = $Towns_List_Query->fetch())
			{
				$Magic_Town = stripslashes($Towns_List['Town_Name']);
				echo "<option value=\"$Magic_Town\">$Magic_Town</option>";
			}

			$Towns_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo '<input type="submit" name="End_Add" value="Ajouter"><br /><br />';
			echo '</form>';
		}
		if (isset($_POST['End_Add']))
		{
			if (isset($_POST['Magic_Image']) && ($_POST['Magic_Name']) && ($_POST['Magic_Description']) && ($_POST['Magic_Type']) && ($_POST['Magic_Town']))
			{
				$Magic_Image = htmlspecialchars(addslashes($_POST['Magic_Image']));
				$Magic_Name = htmlspecialchars(addslashes($_POST['Magic_Name']));
				$Magic_Description = htmlspecialchars(addslashes($_POST['Magic_Description']));
				$Magic_Type = htmlspecialchars(addslashes($_POST['Magic_Type']));
				$Magic_Effect = htmlspecialchars(addslashes($_POST['Magic_Effect']));
				$Magic_MP_Cost = htmlspecialchars(addslashes($_POST['Magic_MP_Cost']));
				$Magic_Town = htmlspecialchars(addslashes($_POST['Magic_Town']));

				$recherche_Town_ID = $bdd->prepare("SELECT Town_ID 
				FROM Caranille_Towns
				WHERE Town_Name = ?");
				$recherche_Town_ID->execute(array($Magic_Town));

				while ($Town_ID = $recherche_Town_ID->fetch())
				{
					$Town_ID_choisit = stripslashes($Town_ID['Town_ID']);
				}

				$recherche_Town_ID->closeCursor();

				$Magic_Price = htmlspecialchars(addslashes($_POST['Magic_Price']));

				$Add = $bdd->prepare("INSERT INTO Caranille_Magics VALUES('', :Magic_Image, :Magic_Name, :Magic_Description, :Magic_Type, :Magic_Effect, :Magic_MP_Cost, :Town_ID_choisit, :Magic_Price)");
				$Add->execute(array('Magic_Image'=> $Magic_Image, 'Magic_Name'=> $Magic_Name, 'Magic_Description'=> $Magic_Description, 'Magic_Type'=> $Magic_Type, 'Magic_Effect'=> $Magic_Effect, 'Magic_MP_Cost'=> $Magic_MP_Cost, 'Town_ID_choisit'=> $Town_ID_choisit, 'Magic_Price'=> $Magic_Price));
				
				echo 'Magie ajouté';
			}
			else
			{
				echo 'Tous les champs n\'ont pas été remplis';
			}
		}
	}
	else
	{
		echo "<center>";
		echo "Vous ne possèdez pas le Access nécessaire pour accèder à cette partie du site";
		echo "</center>";
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
