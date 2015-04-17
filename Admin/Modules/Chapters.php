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
			echo '<form method="POST" action="Chapters.php">';
			echo '<input type="submit" name="Add" value="Ajouter un chapitre">';
			echo '<input type="submit" name="Edit" value="Modifier un chapitre">';
			echo '</form>';
		}
		if (isset($_POST['Edit']))
		{
			echo 'Voici la liste des chapitres du MMORPG<br /><br />';
			$Chapter_List_Query = $bdd->query("SELECT * FROM Caranille_Chapters");
			while ($Chapter_List = $Chapter_List_Query->fetch())
			{
				echo 'Titre du Chapter_List: ' .stripslashes($Chapter_List['Chapter_Name']). '<br />';
				$Chapter_ID = stripslashes($Chapter_List['Chapter_ID']);
				echo '<form method="POST" action="Chapters.php">';
				echo "<input type=\"hidden\" name=\"Chapter_ID\" value=\"$Chapter_ID\">";
				echo '<input type="submit" name="Second_Edit" value="Modifier">';
				echo '<input type="submit" name="Delete" value="supprimer">';
				echo '</form>';
			}
			$Chapter_List_Query->closeCursor();
		}
		if (isset($_POST['Second_Edit']))
		{
			$Chapter_ID = htmlspecialchars(addslashes($_POST['Chapter_ID']));

			$Chapter_List_Query = $bdd->prepare("SELECT * FROM Caranille_Chapters WHERE Chapter_ID= ?");
			$Chapter_List_Query->execute(array($Chapter_ID));

			while ($Chapter_List = $Chapter_List_Query->fetch())
			{
				$_SESSION['Chapter_ID'] = stripslashes($Chapter_List['Chapter_ID']);
				$Chapter_Number = stripslashes($Chapter_List['Chapter_Number']);
				$Chapter_Name = stripslashes($Chapter_List['Chapter_Name']);
				$Chapter_Opening = stripslashes($Chapter_List['Chapter_Opening']);
				$Chapter_Ending = stripslashes($Chapter_List['Chapter_Ending']);
				$Chapter_Defeate = stripslashes($Chapter_List['Chapter_Defeate']);
			}

			$Chapter_List_Query->closeCursor();

			echo '</form><br /><br />';
			echo '<form method="POST" action="Chapters.php">';
			echo 'Modification du Chapitre<br /><br />';
			echo "Numéro du chapitre : <br /> <input type=\"text\" name=\"Chapter_Number\" value=\"$Chapter_Number\"><br /><br />";
			echo "Nom du chapitre : <br /><input type=\"text\" name=\"Chapter_Name\" value=\"$Chapter_Name\"><br /><br />";
			echo "Début du chapitre : <br /><textarea name=\"Chapter_Opening\" ID=\"message\" rows=\"10\" cols=\"50\">$Chapter_Opening</textarea><br /><br />";
			echo "Fin du chapitre : <br /><textarea name=\"Chapter_Ending\" ID=\"message\" rows=\"10\" cols=\"50\">$Chapter_Ending</textarea><br /><br />";
			echo "Message en cas de défaite : <br /><textarea name=\"Chapter_Defeate\" ID=\"message\" rows=\"10\" cols=\"50\">$Chapter_Defeate</textarea><br /><br />";
			echo '<br /> Monstre du chapitre : <br />';
			echo '<select name="Chapter_Monster" ID="Chapter_Monster">';

			$Monster_List_Query = $bdd->query("SELECT * FROM Caranille_Monsters
			WHERE Monster_Access = 'Chapter'");
			while ($Monster_List = $Monster_List_Query->fetch())
			{
				$Chapter_Monster = stripslashes($Monster_List['Monster_Name']);
				echo "<option value=\"$Chapter_Monster\">$Chapter_Monster</option>";
			}
			$Monster_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo '<input type="submit" name="End_Edit" value="Terminer">';
			echo '</form>';
		}
		if (isset($_POST['End_Edit']))
		{
			if (isset($_POST['Chapter_Number']) && ($_POST['Chapter_Name']) && ($_POST['Chapter_Opening']) && ($_POST['Chapter_Ending']) && ($_POST['Chapter_Defeate']))
			{
				$Chapter_ID = htmlspecialchars(addslashes($_SESSION['Chapter_ID']));
				$Chapter_Number = htmlspecialchars(addslashes($_POST['Chapter_Number']));
				$Chapter_Name = htmlspecialchars(addslashes($_POST['Chapter_Name']));
				$Chapter_Opening = htmlspecialchars(addslashes($_POST['Chapter_Opening']));
				$Chapter_Ending = htmlspecialchars(addslashes($_POST['Chapter_Ending']));
				$Chapter_Defeate = htmlspecialchars(addslashes($_POST['Chapter_Defeate']));
				$Chapter_Monster = htmlspecialchars(addslashes($_POST['Chapter_Monster']));

				$recherche_Monster_ID = $bdd->prepare("SELECT * FROM Caranille_Monsters
				WHERE Monster_Name = ?");
				$recherche_Monster_ID->execute(array($Chapter_Monster));

				while ($Monster_ID = $recherche_Monster_ID->fetch())
				{
					$Monster_ID_choisit = $Monster_ID['Monster_ID'];
				}
				$recherche_Monster_ID->closeCursor();

				$Update = $bdd->prepare("UPDATE Caranille_Chapters SET Chapter_Number= :Chapter_Number, Chapter_Name= :Chapter_Name, Chapter_Opening= :Chapter_Opening, Chapter_Ending= :Chapter_Ending, Chapter_Defeate= :Chapter_Defeate, Chapter_Monster= :Monster_ID_choisit WHERE Chapter_ID= :Chapter_ID");
				$Update->execute(array('Chapter_Number'=> $Chapter_Number, 'Chapter_Name'=> $Chapter_Name, 'Chapter_Opening'=> $Chapter_Opening, 'Chapter_Ending'=> $Chapter_Ending, 'Chapter_Defeate'=> $Chapter_Defeate, 'Monster_ID_choisit'=> $Monster_ID_choisit, 'Chapter_ID'=> $Chapter_ID));

				echo 'Chapitre mis à jour';
			}
			else
			{
				echo 'Tous les champs n\'ont pas été remplis';
			}
		}
		if (isset($_POST['Delete']))
		{
			$Chapter_ID = htmlspecialchars(addslashes($_POST['Chapter_ID']));

			$Delete = $bdd->prepare("DELETE FROM Caranille_Chapters WHERE Chapter_ID= :Chapter_ID");
			$Delete->execute(array('Chapter_ID'=> $Chapter_ID));

			echo 'Le chapitre a bien été supprimée';
		}
		if (isset($_POST['Add']))
		{
			echo '</form><br /><br />';
			echo '<form method="POST" action="Chapters.php">';
			echo 'Ajout d\'un chapitre<br /><br />';
			echo 'Numéro du chapitre : <br /> <input type="text" name="Chapter_Number"><br /><br />';
			echo 'Nom du chapitre : <br /> <input type="text" name="Chapter_Name"><br /><br />';
			echo 'Début du chapitre : <br /><textarea name="Chapter_Opening" ID="message" rows="10" cols="50"></textarea><br /><br />';
			echo 'Fin du chapitre : <br /><textarea name="Chapter_Ending" ID="message" rows="10" cols="50"></textarea><br /><br />';
			echo 'Message en cas de défaite : <br /><textarea name="Chapter_Defeate" ID="message" rows="10" cols="50"></textarea><br /><br />';
			echo 'Monstre du chapitre : <br />';
			echo '<select name="Chapter_Monster" ID="Chapter_Monster">';

			$Monster_List_Query = $bdd->query("SELECT * FROM Caranille_Monsters
			WHERE Monster_Access = 'Chapter'");

			while ($Monster_List = $Monster_List_Query->fetch())
			{
				$Chapter_Monster = stripslashes($Monster_List['Monster_Name']);
				echo "<option value=\"$Chapter_Monster\">$Chapter_Monster</option>";
			}
			$Monster_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo '<input type="submit" name="End_Add" value="Terminer">';
			echo '</form>';
		}
		if (isset($_POST['End_Add']))
		{
			if (isset($_POST['Chapter_Number']) && ($_POST['Chapter_Name']) && ($_POST['Chapter_Opening']) && ($_POST['Chapter_Ending']) && ($_POST['Chapter_Defeate']))
			{
				$Chapter_Number = htmlspecialchars(addslashes($_POST['Chapter_Number']));
				$Chapter_Name = htmlspecialchars(addslashes($_POST['Chapter_Name']));
				$Chapter_Opening = htmlspecialchars(addslashes($_POST['Chapter_Opening']));
				$Chapter_Ending = htmlspecialchars(addslashes($_POST['Chapter_Ending']));
				$Chapter_Defeate = htmlspecialchars(addslashes($_POST['Chapter_Defeate']));
				$Chapter_Monster = htmlspecialchars(addslashes($_POST['Chapter_Monster']));

				$recherche_Monster_ID = $bdd->prepare("SELECT * FROM Caranille_Monsters
				WHERE Monster_Name = ?");
				$recherche_Monster_ID->execute(array($Chapter_Monster));

				while ($Monster_ID = $recherche_Monster_ID->fetch())
				{
					$Monster_ID_choisit = $Monster_ID['Monster_ID'];
				}

				$recherche_Monster_ID->closeCursor();

				$Add = $bdd->prepare("INSERT INTO Caranille_Chapters VALUES('', :Chapter_Number, :Chapter_Name, :Chapter_Opening, :Chapter_Ending, :Chapter_Defeate, :Monster_ID_choisit)");
				$Add->execute(array('Chapter_Number'=> $Chapter_Number, 'Chapter_Name'=> $Chapter_Name, 'Chapter_Opening'=> $Chapter_Opening, 'Chapter_Ending'=> $Chapter_Ending, 'Chapter_Defeate'=> $Chapter_Defeate, 'Monster_ID_choisit'=> $Monster_ID_choisit)); 
				
				echo 'chapitre ajouté';
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
		echo 'Vous ne possèdez pas les droits nécessaire pour accèder à cette partie du site';
		echo '</center>';
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
