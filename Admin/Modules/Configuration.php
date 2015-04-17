<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	if ($_SESSION['Access'] == "Admin")
	{
		if (empty($_POST['End_Edit']))
		{
			$Configuration_Query = $bdd->query('SELECT * FROM Caranille_Configuration');
			while ($configuration = $Configuration_Query->fetch())
			{
				$_SESSION['Configuration_ID'] = stripslashes($configuration['Configuration_ID']);
				$_SESSION['Configuration_Access'] = stripslashes($configuration['Configuration_Access']);
				$Configuration_Presentation = stripslashes($configuration['Configuration_Presentation']);
				$Configuration_Access = stripslashes($configuration['Configuration_Access']);
				echo '<form method="POST" action="Configuration.php">';
				if ($Configuration_Access == 'No')
				{
					echo '<div class="important"><br />Le RPG est actuellement fermé aux joueurs</div><br />';
				}
				else
				{
					echo '<div class="important"><br />Le RPG est actuellement ouvert aux joueurs</div><br />';
				}
				echo '<input type="radio" name="Configuration_Access" value="Yes" ID="Yes" /> <label for="Yes">Ouvrir le mmorpg aux joueurs</label><br />';
				echo '<input type="radio" name="Configuration_Access" value="No" ID="No" /> <label for="No">Fermer le rpg aux joueurs</label><br /><br />';
				echo "Présentation : <br /><textarea name=\"Configuration_Presentation\" ID=\"message\" rows=\"10\" cols=\"50\">$Configuration_Presentation</textarea><br /><br />";
				echo '<input type="submit" name="End_Edit" value="Terminer">';
				echo '</form>';
			}
			$Configuration_Query->closeCursor();

		}
		else
		{
			$Configuration_ID = htmlspecialchars(addslashes($_SESSION['Configuration_ID']));
			if (isset($_POST['Configuration_Access']))
			{
				$Configuration_Access = htmlspecialchars(addslashes($_POST['Configuration_Access']));
			}
			else
			{
				$Configuration_Access = htmlspecialchars(addslashes($_SESSION['Configuration_Access']));
			}
			$Configuration_Presentation = htmlspecialchars(addslashes($_POST['Configuration_Presentation']));

			$Update = $bdd->prepare("UPDATE Caranille_Configuration SET Configuration_Presentation= :Configuration_Presentation, Configuration_Access= :Configuration_Access WHERE Configuration_ID= :Configuration_ID");
			$Update->execute(array('Configuration_Presentation'=> $Configuration_Presentation, 'Configuration_Access'=> $Configuration_Access, 'Configuration_ID'=> $Configuration_ID));
			echo 'Mise à jour effectuée';
			echo '<form method="POST" action="Configuration.php">';
			echo '<input type="submit" name="accueil_configuration" value="Continuer">';
			echo '</form>';
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
