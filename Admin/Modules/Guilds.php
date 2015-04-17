<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	//Si le Access est administration, afficher le menu de l'administration
	if ($_SESSION['Access'] == "Admin")
	{
		if (empty($_POST['Edit']) && empty($_POST['Second_Edit']) && (empty($_POST['Delete'])))
		{
			echo 'Que souhaitez-vous faire ?<br />';
			echo '<form method="POST" action="Guilds.php">';
			echo '<input type="submit" name="Edit" value="Modifier une guilde">';
			echo '</form>';
		}
		if (isset($_POST['Edit']))
		{
			echo 'Voici la liste des Guilds du mmorpg<br /><br />';
			$Guilds_List_Query = $bdd->query("SELECT * FROM Caranille_Guilds");
			while ($Guilds = $Guilds_List_Query->fetch())
			{
				echo $Guilds['Guild_Name'];
				$Guild_ID = htmlspecialchars(addslashes($Guilds['Guild_ID']));
				echo '<form method="POST" action="Guilds.php">';
				echo "<input type=\"hidden\" name=\"Guild_ID\" value=\"$Guild_ID\">";
				echo '<input type="submit" name="Second_Edit" value="Modifier">';
				echo '<input type="submit" name="Delete" value="supprimer">';
				echo '</form';
			}
		}
		if (isset($_POST['Second_Edit']))
		{
			$Guild_ID = $_POST['Guild_ID'];
			$Guilds_List_Query = $bdd->prepare("SELECT * FROM Caranille_Guilds WHERE Guild_ID= ?");
			$Guilds_List_Query->execute(array($Guild_ID));

			while ($Guilds = $Guilds_List_Query->fetch())
			{
				$_SESSION['Guild_ID'] = stripslashes($Guilds['Guild_ID']);
				$Guild_Image = stripslashes($Guilds['Guild_Image']);
				$Guild_Name = stripslashes($Guilds['Guild_Name']);
				$Guild_Description = stripslashes($Guilds['Guild_Description']);
				$bonus_force = stripslashes($Guilds['bonus_force_guilde']);
				$bonus_magie = stripslashes($Guilds['bonus_magie_guilde']);
				$bonus_Defense = stripslashes($Guilds['bonus_Defense_guilde']);
				$bonus_HP = stripslashes($Guilds['bonus_HP_guilde']);
				$bonus_MP = stripslashes($Guilds['bonus_MP_guilde']);
			}

			$Guilds_List_Query->closeCursor();

			echo '</form><br /><br />';
			echo "<form method=\"POST\" action=\"Guilds.php\">";
			echo "Image (Adresse) :<br /> <input type=\"text\" name=\"Guild_Image\" value=\"$Guild_Image\"><br /><br />";
			echo "Nom de la guilde :<br /> <input type=\"text\" name=\"Guild_Name\" value=\"$Guild_Name\"><br /><br />";
			echo "Description de la guilde : <br /><textarea name=\"Guild_Description\" ID=\"message\" rows=\"10\" cols=\"50\">$Guild_Description</textarea><br /><br />";
			echo '<input type="submit" name="End_Edit" value="Terminer">';
			echo '</form>';
		}
		if (isset($_POST['End_Edit']))
		{
			if (isset($_POST['Guild_Image']) && ($_POST['Guild_Name']) && ($_POST['Guild_Description']))
			{
				$Guild_ID = $_SESSION['Guild_ID'];
				$Guild_Image = htmlspecialchars(addslashes($_POST['Guild_Image']));
				$Guild_Name = htmlspecialchars(addslashes($_POST['Guild_Name']));
				$Guild_Description = htmlspecialchars(addslashes($_POST['Guild_Description']));

				$Update = $bdd->prepare("UPDATE Caranille_Guilds SET Guild_Image= :Guild_Image, Guild_Name= :Guild_Name, Guild_Description= :Guild_Description WHERE Guild_ID= :Guild_ID");
				$Update->execute(array('Guild_Image'=> $Guild_Image, 'Guild_Name'=> $Guild_Name, 'Guild_Description'=> $Guild_Description, 'Guild_ID'=> $Guild_ID));
				
				echo "guilde mises à jour";
			}
			else
			{
				echo "Tous les champs n'ont pas été remplis";
			}
		}
		if (isset($_POST['Delete']))
		{
			$Guild_ID = stripslashes($_POST['Guild_ID']);

			$Delete = $bdd->prepare("DELETE FROM Caranille_Guilds WHERE Guild_ID= :Guild_ID");
			$Delete->execute(array('Guild_ID'=> $Guild_ID));

			echo 'La guilde a bien été supprimé';
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
