<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	//Si le Access est administration, afficher le menu de l'administration
	if ($_SESSION['Access'] == "Admin")
	{
		if (empty($_POST['Edit']) && empty($_POST['Second_Edit']) && empty($_POST['Add']) && empty($_POST['End_Add']))
		{
			echo 'Que souhaitez-vous faire ?<br />';
			echo '<form method="POST" action="News.php">';
			echo '<input type="submit" name="Add" value="Ajouter une News">';
			echo '<input type="submit" name="Edit" value="Modifier une News">';
			echo '</form>';
		}
		if (isset($_POST['Edit']))
		{
			echo 'Voici la liste des news du MMORPG<br /><br />';
			$News_List_Query = $bdd->query("SELECT * FROM Caranille_News");
			while ($News_List = $News_List_Query->fetch())
			{
				echo $News_List['News_Title'];
				$News_ID = stripslashes($News_List['News_ID']);
				echo '<form method="POST" action="News.php">';
				echo "<input type=\"hidden\" name=\"News_ID\" value=\"$News_ID\">";
				echo '<input type="submit" name="Second_Edit" value="Modifier la News">';
				echo '<input type="submit" name="Delete" value="supprimer">';
				echo '</form>';
			}

			$News_List_Query->closeCursor();

		}
		if (isset($_POST['Second_Edit']))
		{
			$News_ID = $_POST['News_ID'];

			$News_List_Query = $bdd->prepare("SELECT * FROM Caranille_News WHERE News_ID= ?");
			$News_List_Query->execute(array($News_ID));

			while ($News_List = $News_List_Query->fetch())
			{
				$_SESSION['News_ID'] = stripslashes($News_List['News_ID']);
				$News_Title = stripslashes($News_List['News_Title']);
				$News_Message = stripslashes($News_List['News_Message']);
			}

			$News_List_Query->closeCursor();

			echo '</form><br /><br />';
			echo '<form method="POST" action="News.php">';
			echo "Titre de la News_List<br /> <input type=\"text\" name=\"News_Title\" value=\"$News_Title\"><br /><br />";
			echo "Message de la News_List<br /><textarea name=\"News_Message\" ID=\"message\" rows=\"10\" cols=\"50\">$News_Message</textarea><br /><br />";
			echo '<input type="submit" name="End_Edit" value="Terminer">';
			echo '</form>';
		}
		if (isset($_POST['End_Edit']))
		{
			if (isset($_POST['News_Title']) && ($_POST['News_Message']))
			{
				$News_ID = htmlspecialchars(addslashes($_SESSION['News_ID']));
				$News_Title = htmlspecialchars(addslashes($_POST['News_Title']));
				$News_Message = htmlspecialchars(addslashes($_POST['News_Message']));

				$Update = $bdd->prepare("UPDATE Caranille_News SET News_Title='$News_Title', News_Message='$News_Message' WHERE News_ID='$News_ID'");
				$Update->execute(array('News_Title'=> $News_Title, 'News_Message'=> $News_Message, 'News_ID'=> $News_ID));
				
				echo 'News mise à jour';
			}
			else
			{
				echo 'Tous les champs n\'ont pas été remplis';
			}
		}
		if (isset($_POST['Delete']))
		{
			$News_ID = htmlspecialchars(addslashes($_POST['News_ID']));

			$Delete = $bdd->prepare("DELETE FROM Caranille_News WHERE News_ID= :News_ID");
			$Delete->execute(array('News_ID'=> $News_ID));

			echo 'La News à bien été supprimée';
		}
		if (isset($_POST['Add']))
		{
			echo '</form><br /><br />';
			echo '<form method="POST" action="News.php">';
			echo 'Titre de la News<br /> <input type="text" name="News_Title"><br /><br />';
			echo 'Message de la News<br /><textarea name="News_Message" ID="message" rows="10" cols="50"></textarea><br /><br />';
			echo '<input type="submit" name="End_Add" value="Terminer">';
			echo '</form>';
		}
		if (isset($_POST['End_Add']))
		{
			if (isset($_POST['News_Title']) && ($_POST['News_Message']))
			{
				$News_Title = htmlspecialchars(addslashes($_POST['News_Title']));
				$News_Message = htmlspecialchars(addslashes($_POST['News_Message']));
				$Pseudo = $_SESSION['Pseudo'];
				$Date = date('Y-m-d H:i:s');

				$Add = $bdd->prepare("INSERT INTO Caranille_News VALUES('', :News_Title, :News_Message, :News_Account_Pseudo, :News_Date)");
				$Add->execute(array('News_Title'=> $News_Title, 'News_Message'=> $News_Message, 'News_Account_Pseudo' => $Pseudo, 'News_Date' => $Date));

				echo 'News ajoutée';
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
