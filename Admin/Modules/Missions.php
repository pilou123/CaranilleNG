<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	//Si le Access est administration, afficher le menu de l'administration
	if ($_SESSION['Access'] == "Admin")
	{
		if (empty($_POST['Edit']) && empty($_POST['Second_Edit']) && empty($_POST['End_Edit'])&& (empty($_POST['Add'])))
		{
			echo 'Que souhaitez-vous faire ?<br />';
			echo '<form method="POST" action="Missions.php">';
			echo '<input type="submit" name="Add" value="Ajouter une mission">';
			echo '<input type="submit" name="Edit" value="Modifier une mission">';
			echo '</form>';
		}
		if (isset($_POST['Edit']))
		{
			echo 'Voici la liste des missions du MMORPG<br /><br />';
			$Missions_List_Query = $bdd->query("SELECT * 
			FROM Caranille_Missions, Caranille_Towns
			WHERE Mission_Town = Town_ID
			ORDER BY Town_Name ASC");
			while ($Missions_List = $Missions_List_Query->fetch())
			{
				echo "<br /><div class=\"important\">Ville: </div>" .$Missions_List['Town_Name']. "<br />";
				echo "<div class=\"important\">N°: </div>" .$Missions_List['Mission_Number']. "<br />";
				echo "<div class=\"important\">Titre de la mission : </div>" .$Missions_List['Mission_Name']. "<br />";
				$Mission_ID = stripslashes($Missions_List['Mission_ID']);
				echo '<form method="POST" action="Missions.php">';
				echo "<input type=\"hidden\" name=\"Mission_ID\" value=\"$Mission_ID\">";
				echo '<input type="submit" name="Second_Edit" value="Modifier">';
				echo '<input type="submit" name="Delete" value="Supprimer">';
				echo '</form>';
			}
			$Missions_List_Query->closeCursor();

		}
		if (isset($_POST['Second_Edit']))
		{
			$Mission_ID = htmlspecialchars(addslashes($_POST['Mission_ID']));

			$Missions_List_Query = $bdd->prepare("SELECT * FROM Caranille_Missions WHERE Mission_ID= ?");
			$Missions_List_Query->execute(array($Mission_ID));

			while ($Missions_List = $Missions_List_Query->fetch())
			{
				$_SESSION['Mission_ID'] = stripslashes($Missions_List['Mission_ID']);
				$Mission_Number = stripslashes($Missions_List['Mission_Number']);
				$Mission_Name = stripslashes($Missions_List['Mission_Name']);
				$Mission_Introduction = stripslashes($Missions_List['Mission_Introduction']);
				$Mission_Defeate = stripslashes($Missions_List['Mission_Defeate']);
				$Mission_Victory = stripslashes($Missions_List['Mission_Victory']);
				$Mission_Town = stripslashes($Missions_List['Mission_Town']);
			}
			echo '</form><br /><br />';
			echo '<form method="POST" action="Missions.php">';
			echo 'Paramètre de la mission<br /><br />';
			echo '<br /> Ville où se trouve la Mission :<br />';
			echo '<select name="Mission_Town" ID="Mission_Town">';
			
			$Town_List_Query = $bdd->query("SELECT * 
			FROM Caranille_Missions, Caranille_Towns
			WHERE Mission_Town = Town_ID
			AND Mission_ID = '$Mission_ID'
			ORDER BY Town_Name ASC");
			while ($Town_List = $Town_List_Query->fetch())
			{
				$Town = $Town_List['Town_Name'];
			}
			$Town_List_Query->closeCursor();

			echo "<option value=\"$Town\">$Town</option>";
			$Town_List_Query = $bdd->query("SELECT * FROM Caranille_Towns");
			while ($Town_List = $Town_List_Query->fetch())
			{
				$Town = $Town_List['Town_Name'];
				echo "<option value=\"$Town\">$Town</option>";
			}

			$Town_List_Query->closeCursor();

			echo "</select><br /><br />";
			echo "Numéro de la mission<br /> <input type=\"text\" name=\"Mission_Number\" value=\"$Mission_Number\"><br /><br />";
			echo "Nom de la mission<br /><input type=\"text\" name=\"Mission_Name\" value=\"$Mission_Name\"><br /><br />";
			echo "Introduction de la mission<br /><textarea name=\"Mission_Introduction\" ID=\"message\" rows=\"10\" cols=\"50\">$Mission_Introduction</textarea><br /><br />";
			echo "Message en cas de victoire<br /><textarea name=\"Mission_Victory\" ID=\"message\" rows=\"10\" cols=\"50\">$Mission_Victory</textarea><br /><br />";
			echo "Message en cas de défaite<br /><textarea name=\"Mission_Defeate\" ID=\"message\" rows=\"10\" cols=\"50\">$Mission_Defeate</textarea><br />";
			echo "<br /> Monstre de la mission :<br />";
			echo "<select name=\"Mission_Monster\" ID=\"Mission_Monster\">";
			$Monster_List_Query = $bdd->query("SELECT * FROM Caranille_Monsters
			WHERE Monster_Access = 'Mission'");
			while ($Monster_List = $Monster_List_Query->fetch())
			{
				$Mission_Monster = stripslashes($Monster_List['Monster_Name']);
				echo "<option value=\"$Mission_Monster\">$Mission_Monster</option>";
			}
			$Monster_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo '<input type="submit" name="End_Edit" value="Terminer">';
			echo '</form>';
		}
		if (isset($_POST['End_Edit']))
		{
			if (isset($_POST['Mission_Number']) && ($_POST['Mission_Name']) && ($_POST['Mission_Introduction']) && ($_POST['Mission_Defeate']) && ($_POST['Mission_Victory']) && ($_POST['Mission_Town']))
			{
				$Mission_ID = htmlspecialchars(addslashes($_SESSION['Mission_ID']));
				$Mission_Number = htmlspecialchars(addslashes($_POST['Mission_Number']));
				$Mission_Name = htmlspecialchars(addslashes($_POST['Mission_Name']));
				$Mission_Introduction = htmlspecialchars(addslashes($_POST['Mission_Introduction']));
				$Mission_Defeate = htmlspecialchars(addslashes($_POST['Mission_Defeate']));
				$Mission_Victory = htmlspecialchars(addslashes($_POST['Mission_Victory']));
				$Mission_Town = htmlspecialchars(addslashes($_POST['Mission_Town']));

				$Town_List_Query = $bdd->prepare("SELECT Town_ID 
				FROM Caranille_Towns
				WHERE Town_Name = ?");
				$Town_List_Query->execute(array($Mission_Town));

				while ($Town_List = $Town_List_Query->fetch())
				{
					$Town_ID = stripslashes($Town_List['Town_ID']);
				}
				$Town_List_Query->closeCursor();

				$Mission_Monster = htmlspecialchars(addslashes($_POST['Mission_Monster']));

				$Monster_List_Query = $bdd->prepare("SELECT * FROM Caranille_Monsters
				WHERE Monster_Name = ?");
				$Monster_List_Query->execute(array($Mission_Monster));
				while ($Monster = $Monster_List_Query->fetch())
				{
					$Monster_ID = stripslashes($Monster['Monster_ID']);
				}
				$Monster_List_Query->closeCursor();

				$Edit = $bdd->prepare("UPDATE Caranille_Missions SET Mission_Town= :Town_ID, Mission_Number= :Mission_Number, Mission_Name= :Mission_Name, Mission_Introduction= :Mission_Introduction, Mission_Victory= :Mission_Victory, Mission_Defeate= :Mission_Defeate, Mission_Monster= :Monster_ID WHERE Mission_ID= :Mission_ID");	
				$Edit->execute(array('Town_ID'=> $Town_ID, 'Mission_Number'=> $Mission_Number, 'Mission_Name'=> $Mission_Name, 'Mission_Introduction'=> $Mission_Introduction, 'Mission_Victory'=> $Mission_Victory, 'Mission_Defeate'=> $Mission_Defeate, 'Monster_ID'=> $Monster_ID, 'Mission_ID'=> $Mission_ID));
				
				echo 'Mission mise à jour';
			}
			else
			{
				echo 'Tous les champs n\'ont pas été remplis';
			}
		}
		if (isset($_POST['Delete']))
		{
			$Mission_ID = htmlspecialchars(addslashes($_POST['Mission_ID']));
			$bdd->exec("DELETE FROM Caranille_Missions WHERE Mission_ID='$Mission_ID'");
			echo 'La mission a bien été supprimée';
		}
		if (isset($_POST['Add']))
		{
			echo '</form><br /><br />';
			echo '<form method="POST" action="Missions.php">';
			echo 'Paramètre de la mission<br /><br />';
			echo '<br /> Ville où se trouve la mission :<br />';
			echo '<select name="Mission_Town" ID="Mission_Town">';
			$Town_List_Query = $bdd->query("SELECT * FROM Caranille_Towns");
			while ($Town_List = $Town_List_Query->fetch())
			{
				$Mission_Town = $Town_List['Town_Name'];
				echo "<option value=\"$Mission_Town\">$Mission_Town</option>";
			}
			$Town_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo 'Numéro de la mission<br /> <input type="text" name="Mission_Number"><br /><br />';
			echo 'Nom de la mission<br /> <input type="text" name="Mission_Name"><br /><br />';
			echo 'Introduction de la mission<br /><textarea name="Mission_Introduction" ID="message" rows="10" cols="50"></textarea><br /><br />';
			echo 'Message en cas de victoire<br /><textarea name="Mission_Victory" ID="message" rows="10" cols="50"></textarea><br /><br />';
			echo 'Message en cas de défaite<br /><textarea name="Mission_Defeate" ID="message" rows="10" cols="50"></textarea><br />';
			echo 'Monstre de la mission :<br />';
			echo '<select name="Mission_Monster" ID="Mission_Monster">';
			$Monster_List_Query = $bdd->query("SELECT * FROM Caranille_Monsters
			WHERE Monster_Access = 'Mission'");
			while ($Monster_List = $Monster_List_Query->fetch())
			{
				$Mission_Monster = stripslashes($Monster_List['Monster_Name']);
				echo "<option value=\"$Mission_Monster\">$Mission_Monster</option>";
			}
			$Monster_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo '<input type="submit" name="End_Add" value="Terminer">';
			echo '</form>';
		}
		if (isset($_POST['End_Add']))
		{
			if (isset($_POST['Mission_Number']) && ($_POST['Mission_Name']) && ($_POST['Mission_Introduction']) && ($_POST['Mission_Defeate']) && ($_POST['Mission_Victory']) && ($_POST['Mission_Town']))
			{
				$Mission_Number = htmlspecialchars(addslashes($_POST['Mission_Number']));
				$Mission_Name = htmlspecialchars(addslashes($_POST['Mission_Name']));
				$Mission_Introduction = htmlspecialchars(addslashes($_POST['Mission_Introduction']));
				$Mission_Defeate = htmlspecialchars(addslashes($_POST['Mission_Defeate']));
				$Mission_Victory = htmlspecialchars(addslashes($_POST['Mission_Victory']));
				$Mission_Town = htmlspecialchars(addslashes($_POST['Mission_Town']));

				$Town_List_Query = $bdd->prepare("SELECT Town_ID 
				FROM Caranille_Towns
				WHERE Town_Name = ?");
				$Town_List_Query->execute(array($Mission_Town));
				while ($Town_List = $Town_List_Query->fetch())
				{
					$Town_ID = $Town_List['Town_ID'];
				}
				$Town_List_Query->closeCursor();

				$Mission_Monster = htmlspecialchars(addslashes($_POST['Mission_Monster']));

				$Monster_List_Query = $bdd->prepare("SELECT * FROM Caranille_Monsters
				WHERE Monster_Name = ?");
				$Monster_List_Query->execute(array($Mission_Monster));

				while ($Monster_List = $Monster_List_Query->fetch())
				{
					$Monster_ID = $Monster_List['Monster_ID'];
				}
				$Monster_List_Query->closeCursor();

				$Add = $bdd->prepare("INSERT INTO Caranille_Missions VALUES('', :Town_ID, :Mission_Number, :Mission_Name, :Mission_Introduction, :Mission_Victory, :Mission_Defeate, :Monster_ID)");
				$Add->execute(array('Town_ID'=> $Town_ID, 'Mission_Number'=> $Mission_Number, 'Mission_Name'=> $Mission_Name, 'Mission_Introduction'=> $Mission_Introduction, 'Mission_Victory'=> $Mission_Victory, 'Mission_Defeate'=> $Mission_Defeate, 'Monster_ID'=> $Monster_ID));
				
				echo 'Mission ajoutée';
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
