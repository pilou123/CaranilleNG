<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	//Si le Access est administration, afficher le menu de l'administration
	if ($_SESSION['Access'] == "Admin")
	{
		if (empty($_POST['Edit']) && empty($_POST['Second_Edit']) && empty($_POST['End_Edit']) && (empty($_POST['Add'])))
		{
			echo 'Que souhaitez-vous faire ?<br />';
			echo '<form method="POST" action="Invocations.php">';
			echo '<input type="submit" name="Add" value="Ajouter une invocation">';
			echo '<input type="submit" name="Edit" value="Modifier une invocation">';
			echo '</form>';
		}
		if (isset($_POST['Edit']))
		{
			$Invocations_List_Query = $bdd->query("SELECT * FROM Caranille_Invocations");
			while ($Invocations_List = $Invocations_List_Query->fetch())
			{
				echo 'Nom: ' .stripslashes($Invocations_List['Invocation_Name']). '<br />';
				$Invocation_ID = stripslashes($Invocations_List['Invocation_ID']);
				echo '<form method="POST" action="Invocations.php">';
				echo "<input type=\"hidden\" name=\"Invocation_ID\" value=\"$Invocation_ID\">";
				echo '<input type="submit" name="Second_Edit" value="modifier">';
				echo '<input type="submit" name="supprimer_Invocations_List" value="supprimer">';
				echo '</form>';
			}
			$Invocations_List_Query->closeCursor();

		}
		if (isset($_POST['Second_Edit']))
		{
			$Invocation_ID = htmlspecialchars(addslashes($_POST['Invocation_ID']));

			$Invocations_List_Query = $bdd->prepare("SELECT * FROM Caranille_Invocations WHERE Invocation_ID= ?");
			$Invocations_List_Query->execute(array($Invocation_ID));

			while ($Invocations_List = $Invocations_List_Query->fetch())
			{
				$_SESSION['Invocation_ID'] = stripslashes($Invocations_List['Invocation_ID']);
				$Invocation_Image = stripslashes($Invocations_List['Invocation_Image']);
				$Invocation_Name = stripslashes($Invocations_List['Invocation_Name']);
				$Invocation_Description = stripslashes($Invocations_List['Invocation_Description']);
				$Invocation_Damage = stripslashes($Invocations_List['Invocation_Damage']);
				$Invocation_Town = stripslashes($Invocations_List['Invocation_Town']);
				$Invocation_Price = stripslashes($Invocations_List['Invocation_Price']);	
			}

			$Invocations_List_Query->closeCursor();

			echo '<form method="POST" action="Invocations.php">';
			echo "Image (Adresse)<br /> <input type=\"text\" name=\"Invocation_Image\" value=\"$Invocation_Image\"><br /><br />";
			echo "Nom<br /> <input type=\"text\" name=\"Invocation_Name\" value=\"$Invocation_Name\"><br /><br />";
			echo "description<br /><textarea name=\"Invocation_Description\" ID=\"message\" rows=\"10\" cols=\"50\">$Invocation_Description</textarea><br /><br />";
			echo "Dégat de base<br /> <input type=\"text\" name=\"Invocation_Damage\" value=\"$Invocation_Damage\"><br /><br />";					
			echo "Prix d'achat<br /> <input type=\"text\" name=\"Invocation_Price\" value=\"$Invocation_Price\"><br /><br />";
			echo '<select name="Invocation_Town" ID="Invocation_Town">';

			$Town_List_Query = $bdd->query("SELECT * FROM Caranille_Towns");

			while ($Town_List = $Town_List_Query->fetch())
			{
				$Invocation_Town = stripslashes($Town_List['Town_Name']);
				echo "<option value=\"$Invocation_Town\">$Invocation_Town</option>";
			}

			$Town_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo '<input type="submit" name="End_Edit" value="Modifier"><br /><br />';
			echo '</form>';
		}
		if (isset($_POST['End_Edit']))
		{
			if (isset($_POST['Invocation_Image']) && ($_POST['Invocation_Name']) && ($_POST['Invocation_Description']) && ($_POST['Invocation_Town']))
			{
				$Invocation_ID = htmlspecialchars(addslashes($_SESSION['Invocation_ID']));
				$Invocation_Image = htmlspecialchars(addslashes($_POST['Invocation_Image']));
				$Invocation_Name = htmlspecialchars(addslashes($_POST['Invocation_Name']));
				$Invocation_Description = htmlspecialchars(addslashes($_POST['Invocation_Description']));
				$Invocation_Damage = htmlspecialchars(addslashes($_POST['Invocation_Damage']));
				$Invocation_Town = htmlspecialchars(addslashes($_POST['Invocation_Town']));
				$Invocation_Price = htmlspecialchars(addslashes($_POST['Invocation_Price']));

				$Town_ID_List_Query = $bdd->prepare("SELECT Town_ID 
				FROM Caranille_Towns
				WHERE Town_Name = ?");
				$Town_ID_List_Query->execute(array($Invocation_Town));

				while ($Town_ID_List = $Town_ID_List_Query->fetch())
				{
					$Town_ID = stripslashes($Town_ID_List['Town_ID']);
				}

				$Town_ID_List_Query->closeCursor();

				$Edit = $bdd->prepare("UPDATE Caranille_Invocations SET Invocation_Image= :Invocation_Image, Invocation_Name= :Invocation_Name, Invocation_Description= :Invocation_Description, Invocation_Damage= :Invocation_Damage, Invocation_Town= :Town_ID, Invocation_Price= :Invocation_Price WHERE Invocation_ID= :Invocation_ID");
				$Edit->execute(array('Invocation_Image'=> $Invocation_Image, 'Invocation_Name'=> $Invocation_Name, 'Invocation_Description'=> $Invocation_Description, 'Invocation_Damage'=> $Invocation_Damage, 'Town_ID'=> $Town_ID, 'Invocation_Price'=> $Invocation_Price, 'Invocation_ID'=> $Invocation_ID));
				
				echo "Invocations mis à jour";
			}
			else
			{
				echo "Tous les champs n'ont pas été remplis";
			}
		}
		if (isset($_POST['supprimer_Invocations_List']))
		{
			$Invocation_ID = htmlspecialchars(addslashes($_POST['Invocation_ID']));

			$supprimer_Invocations_List = $bdd->prepare("DELETE FROM Caranille_Invocations WHERE Invocation_ID= :Invocation_ID");
			$supprimer_Invocations_List->execute(array('Invocation_ID'=> $Invocation_ID));

			echo "L'invocation a bien été supprimé";
		}
		if (isset($_POST['Add']))
		{
			echo "Ajout d'un Invocations_List<br />";
			echo "<form method=\"POST\" action=\"Invocations.php\">";
			echo "Image (Adresse)<br /> <input type=\"text\" name=\"Invocation_Image\"><br /><br />";
			echo "Nom<br /> <input type=\"text\" name=\"Invocation_Name\"><br /><br />";
			echo "description<br /><textarea name=\"Invocation_Description\" ID=\"message\" rows=\"10\" cols=\"50\"></textarea><br /><br />";
			echo "Dégat de base<br /> <input type=\"text\" name=\"Invocation_Damage\"><br /><br />";					
			echo "Prix d'achat<br /> <input type=\"text\" name=\"Invocation_Price\"><br /><br />";
			echo "<select name=\"Invocation_Town\" ID=\"Invocation_Town\">";

			$Town_List_Query = $bdd->query("SELECT * FROM Caranille_Towns");
			while ($Town_List = $Town_List_Query->fetch())
			{
				$Invocation_Town = stripslashes($Town_List['Town_Name']);
				echo "<option value=\"$Invocation_Town\">$Invocation_Town</option>";
			}

			$Town_List_Query->closeCursor();

			echo "</select><br /><br />";
			echo "<input type=\"submit\" name=\"ajouter_fin_Invocations_List\" value=\"Ajouter\"><br /><br />";
			echo "</form>";
		}
		if (isset($_POST['ajouter_fin_Invocations_List']))
		{
			if (isset($_POST['Invocation_Image']) && ($_POST['Invocation_Name']) && ($_POST['Invocation_Description']) && ($_POST['Invocation_Town']))
			{
				$Invocation_Image = htmlspecialchars(addslashes($_POST['Invocation_Image']));
				$Invocation_Name = htmlspecialchars(addslashes($_POST['Invocation_Name']));
				$Invocation_Description = htmlspecialchars(addslashes($_POST['Invocation_Description']));
				$Invocation_Damage = htmlspecialchars(addslashes($_POST['Invocation_Damage']));
				$Invocation_Town = htmlspecialchars(addslashes($_POST['Invocation_Town']));
				$Invocation_Price = htmlspecialchars(addslashes($_POST['Invocation_Price']));

				$Town_ID_List_Query = $bdd->prepare("SELECT Town_ID 
				FROM Caranille_Towns
				WHERE Town_Name = ?");
				$Town_ID_List_Query->execute(array($Invocation_Town));

				while ($Town_ID_List = $Town_ID_List_Query->fetch())
				{
					$Town_ID = stripslashes($Town_ID_List['Town_ID']);
				}

				$Town_ID_List_Query->closeCursor();

				$Add = $bdd->prepare("INSERT INTO Caranille_Invocations VALUES('', :Invocation_Image, :Invocation_Name, :Invocation_Description, :Invocation_Damage, :Town_ID, :Invocation_Price)");
				$Add->execute(array('Invocation_Image'=> $Invocation_Image, 'Invocation_Name'=> $Invocation_Name, 'Invocation_Description'=> $Invocation_Description, 'Invocation_Damage'=> $Invocation_Damage, 'Town_ID'=> $Town_ID, 'Invocation_Price'=> $Invocation_Price));
				
				echo 'Invocations ajouté';
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
		echo 'Vous ne possèdez pas les accès nécessaire pour accèder à cette partie du site';
		echo '</center>';
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
