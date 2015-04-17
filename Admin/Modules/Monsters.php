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
			echo '<form method="POST" action="Monsters.php">';
			echo '<input type="submit" name="Add" value="Ajouter un monstre">';
			echo '<input type="submit" name="Edit" value="Modifier un monstre">';
			echo '</form>';
		}
		if (isset($_POST['Edit']))
		{
			$Monsters_List_Query = $bdd->query("SELECT * FROM Caranille_Monsters");
			while ($Monsters = $Monsters_List_Query->fetch())
			{
				echo 'Nom: ' .$Monsters['Monster_Name']. '<br />';
				$Monster_ID = stripslashes($Monsters['Monster_ID']);
				echo '<form method="POST" action="Monsters.php">';
				echo "<input type=\"hidden\" name=\"Monster_ID\" value=\"$Monster_ID\">";
				echo '<input type="submit" name="Second_Edit" value="modifier">';
				echo '<input type="submit" name="Delete" value="supprimer">';
				echo '</form>';
			}
			$Monsters_List_Query->closeCursor();

		}
		if (isset($_POST['Second_Edit']))
		{
			$Monster_ID = htmlspecialchars(addslashes($_POST['Monster_ID']));

			$Monsters_List_Query = $bdd->prepare("SELECT * FROM Caranille_Monsters WHERE Monster_ID= ?");
			$Monsters_List_Query->execute(array($Monster_ID));

			while ($Monsters_List = $Monsters_List_Query->fetch())
			{
				$_SESSION['Monster_ID'] = stripslashes($Monsters_List['Monster_ID']);
				$Monster_Image = stripslashes($Monsters_List['Monster_Image']);
				$Monster_Name = stripslashes($Monsters_List['Monster_Name']);
				$Monster_Description = stripslashes($Monsters_List['Monster_Description']);
				$Monster_Level = stripslashes($Monsters_List['Monster_Level']);
				$Monster_Strength = stripslashes($Monsters_List['Monster_Strength']);
				$Monster_Defense = stripslashes($Monsters_List['Monster_Defense']);
				$Monster_HP = stripslashes($Monsters_List['Monster_HP']);
				$Monster_MP = stripslashes($Monsters_List['Monster_MP']);
				$Monster_Experience = stripslashes($Monsters_List['Monster_Experience']);
				$Monster_Golds = stripslashes($Monsters_List['Monster_Golds']);
				$Monster_Level = stripslashes($Monsters_List['Monster_Level']);
				$Monster_Item_One =stripslashes($Monsters_List['Monster_Item_One']);
				$Monster_Item_One_Rate = stripslashes($Monsters_List['Monster_Item_One_Rate']);
				$Monster_Item_Two = stripslashes($Monsters_List['Monster_Item_Two']);
				$Monster_Item_Two_Rate = stripslashes($Monsters_List['Monster_Item_Two_Rate']);
				$Monster_Item_Three = stripslashes($Monsters_List['Monster_Item_Three']);
				$Monster_Item_Three_Rate = stripslashes($Monsters_List['Monster_Item_Three_Rate']);
				$Monster_Item_Four = stripslashes($Monsters_List['Monster_Item_Four']);
				$Monster_Item_Four_Rate = stripslashes($Monsters_List['Monster_Item_Four_Rate']);
				$Monster_Item_Five = stripslashes($Monsters_List['Monster_Item_Five']);
				$Monster_Item_Five_Rate = stripslashes($Monsters_List['Monster_Item_Five_Rate']);
				$Monster_Access = stripslashes($Monsters_List['Monster_Access']);	
			}

			$Monsters_List_Query->closeCursor();

			echo '</form><br /><br />';
			echo '<form method="POST" action="Monsters.php">';
			echo "Image (Adresse)<br /> <input type=\"text\" name=\"Monster_Image\" value=\"$Monster_Image\"><br /><br />";
			echo "Nom<br /> <input type=\"text\" name=\"Monster_Name\" value=\"$Monster_Name\"><br /><br />";
			echo "description<br /><textarea name=\"Monster_Description\" ID=\"message\" rows=\"10\" cols=\"50\">$Monster_Description</textarea><br /><br />";
			echo "Niveau<br /> <input type=\"text\" name=\"Monster_Level\" value=\"$Monster_Level\"><br /><br />";				
			echo "Force<br /> <input type=\"text\" name=\"Monster_Strength\" value=\"$Monster_Strength\"><br /><br />";
			echo "Defense<br /> <input type=\"text\" name=\"Monster_Defense\" value=\"$Monster_Defense\"><br /><br />";
			echo "HP<br /> <input type=\"text\" name=\"Monster_HP\" value=\"$Monster_HP\"><br /><br />";
			echo "MP<br /> <input type=\"text\" name=\"Monster_MP\" value=\"$Monster_MP\"><br /><br />";
			echo "Experience<br /> <input type=\"text\" name=\"Monster_Experience\" value=\"$Monster_Experience\"><br /><br />";
			echo "Pièce d'or<br /> <input type=\"text\" name=\"Monster_Golds\" value=\"$Monster_Golds\"><br /><br />";
			echo 'Ville du monstre <br />';
			echo '<select name="Monster_Town" ID="Monster_Town">';
			$Towns_List_Query = $bdd->query("SELECT * FROM Caranille_Towns");
			while ($Towns_List = $Towns_List_Query->fetch())
			{
				$Monster_Town = stripslashes($Towns_List['Town_Name']);
				echo "<option value=\"$Monster_Town\">$Monster_Town</option>";
			}
			$Towns_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo '<div class=important">Choisissez les objets que le monstre est suceptible de faire gagner en cas de victoire du joueur</div><br /><br />';
			echo 'Objet N°1<br />';
			echo '<select name="Monster_Item_One" ID="Monster_Item_One">';

			$Item_One_Query = $bdd->prepare("SELECT * FROM Caranille_Items WHERE 
			Item_ID= ?");
			$Item_One_Query->execute(array($Monster_Item_One));

			while ($Item_One = $Item_One_Query->fetch())
			{
				$nom_Monster_Item_One = stripslashes($Item_One['Item_Name']);
			}
			echo "<option value=\"$nom_Monster_Item_One\">$nom_Monster_Item_One</option>";
			echo '<option value="Aucun objet">Aucun objet</option>';
			$Items_List_Query = $bdd->query("SELECT * FROM Caranille_Items");
			while ($Items_List = $Items_List_Query->fetch())
			{
				$Monster_Item_One = stripslashes($Items_List['Item_Name']);
				echo "<option value=\"$Monster_Item_One\">$Monster_Item_One</option>";
			}
			$Items_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo "Taux d'obtention de l'objet<br /><input type=\"text\" name=\"Monster_Item_One_Rate\" value=\"$Monster_Item_One_Rate\">%<br /><br />";

			echo 'Objet N°2<br />';
			echo '<select name="Monster_Item_Two" ID="Monster_Item_Two">';

			$Item_Two_Query = $bdd->prepare("SELECT * FROM Caranille_Items WHERE 
			Item_ID= ?");
			$Item_Two_Query->execute(array($Monster_Item_Two));

			while ($Item_Two = $Item_Two_Query->fetch())
			{
				$nom_Monster_Item_Two = stripslashes($Item_Two['Item_Name']);
			}
			echo "<option value=\"$nom_Monster_Item_Two\">$nom_Monster_Item_Two</option>";
			echo '<option value="Aucun objet">Aucun objet</option>';
			$Items_List_Query = $bdd->query("SELECT * FROM Caranille_Items");
			while ($Items_List = $Items_List_Query->fetch())
			{
				$Monster_Item_Two = stripslashes($Items_List['Item_Name']);
				echo "<option value=\"$Monster_Item_Two\">$Monster_Item_Two</option>";
			}
			$Items_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo "Taux d'obtention de l'objet<br /><input type=\"text\" name=\"Monster_Item_Two_Rate\" value=\"$Monster_Item_Two_Rate\">%<br /><br />";

			echo 'Objet N°3<br />';
			echo '<select name="Monster_Item_Three" ID="Monster_Item_Three">';

			$Item_Three_Query = $bdd->prepare("SELECT * FROM Caranille_Items WHERE 
			Item_ID= ?");
			$Item_Three_Query->execute(array($Monster_Item_Three));

			while ($Item_Three = $Item_Three_Query->fetch())
			{
				$nom_Monster_Item_Three = stripslashes($Item_Three['Item_Name']);
			}
			echo "<option value=\"$nom_Monster_Item_Three\">$nom_Monster_Item_Three</option>";
			echo '<option value="Aucun objet">Aucun objet</option>';
			$Items_List_Query = $bdd->query("SELECT * FROM Caranille_Items");
			while ($Items_List = $Items_List_Query->fetch())
			{
				$Monster_Item_Three = stripslashes($Items_List['Item_Name']);
				echo "<option value=\"$Monster_Item_Three\">$Monster_Item_Three</option>";
			}
			$Items_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo "Taux d'obtention de l'objet<br /><input type=\"text\" name=\"Monster_Item_Three_Rate\" value=\"$Monster_Item_Three_Rate\">%<br /><br />";

			echo 'Objet N°4<br />';
			echo '<select name="Monster_Item_Four" ID="Monster_Item_Four">';

			$Item_Four_Query = $bdd->prepare("SELECT * FROM Caranille_Items WHERE 
			Item_ID= ?");
			$Item_Four_Query->execute(array($Monster_Item_Four));

			while ($Item_Four = $Item_Four_Query->fetch())
			{
				$nom_Monster_Item_Four = stripslashes($Item_Four['Item_Name']);
			}
			echo "<option value=\"$nom_Monster_Item_Four\">$nom_Monster_Item_Four</option>";
			echo '<option value="Aucun objet">Aucun objet</option>';
			$Items_List_Query = $bdd->query("SELECT * FROM Caranille_Items");
			while ($Items_List = $Items_List_Query->fetch())
			{
				$Monster_Item_Four = stripslashes($Items_List['Item_Name']);
				echo "<option value=\"$Monster_Item_Four\">$Monster_Item_Four</option>";
			}
			$Items_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo "Taux d'obtention de l'objet<br /><input type=\"text\" name=\"Monster_Item_Four_Rate\" value=\"$Monster_Item_Four_Rate\">%<br /><br />";

			echo 'Objet N°5<br />';
			echo '<select name="Monster_Item_Five" ID="Monster_Item_Five">';

			$Item_Five_Query = $bdd->prepare("SELECT * FROM Caranille_Items WHERE 
			Item_ID= ?");
			$Item_Five_Query->execute(array($Monster_Item_Five));

			while ($Item_Five = $Item_Five_Query->fetch())
			{
				$nom_Monster_Item_Five = stripslashes($Item_Five['Item_Name']);
			}
			echo "<option value=\"$nom_Monster_Item_Five\">$nom_Monster_Item_Five</option>";
			echo '<option value="Aucun objet">Aucun objet</option>';
			$Items_List_Query = $bdd->query("SELECT * FROM Caranille_Items");
			while ($Items_List = $Items_List_Query->fetch())
			{
				$Monster_Item_Five = stripslashes($Items_List['Item_Name']);
				echo "<option value=\"$Monster_Item_Five\">$Monster_Item_Five</option>";
			}
			$Items_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo "Taux d'obtention de l'objet<br /><input type=\"text\" name=\"Monster_Item_Five_Rate\" value=\"$Monster_Item_Five_Rate\">%<br /><br />";

			echo '<div class="important">Quel est le type du monstre ?</div><br />';
			echo '<select name="Monster_Access" ID="Monster_Access">';
			if ($Monster_Access == "Chapter")
			{
				echo "<option selected=\"selected\" value=\"$Monster_Access\">$Monster_Access</option>";
				echo '<option value="Battle">combat</option>';
				echo '<option value="Mission">mission</option>';
			}
			if ($Monster_Access == "Battle")
			{
				echo "<option selected=\"selected\" value=\"$Monster_Access\">$Monster_Access</option>";
				echo '<option value="Chapter">Monstre de chapitre</option>';
				echo '<option value="Mission">Monstre de mission</option>';
			}
			if ($Monster_Access == "Mission")
			{
				echo "<option selected=\"selected\" value=\"$Monster_Access\">$Monster_Access</option>";
				echo '<option value="Chapter">Monstre de chapitre</option>';
				echo '<option value="Battle">Monstre de combat</option>';
			}
			echo '</select><br /><br />';
			echo '<input type="submit" name="End_Edit" value="Terminer">';
			echo '</form>';
		}
		if (isset($_POST['End_Edit']))
		{
			if (isset($_POST['Monster_Image']) && ($_POST['Monster_Name']) && ($_POST['Monster_Description']) && ($_POST['Monster_Level']))
			{
				$Monster_ID = $_SESSION['Monster_ID'];
				$Monster_Image = htmlspecialchars(addslashes($_POST['Monster_Image']));
				$Monster_Name = htmlspecialchars(addslashes($_POST['Monster_Name']));
				$Monster_Description = htmlspecialchars(addslashes($_POST['Monster_Description']));
				$Monster_Level = htmlspecialchars(addslashes($_POST['Monster_Level']));
				$Monster_Strength = htmlspecialchars(addslashes($_POST['Monster_Strength']));
				$Monster_Defense = htmlspecialchars(addslashes($_POST['Monster_Defense']));
				$Monster_HP = htmlspecialchars(addslashes($_POST['Monster_HP']));
				$Monster_MP = htmlspecialchars(addslashes($_POST['Monster_MP']));
				$Monster_Experience = htmlspecialchars(addslashes($_POST['Monster_Experience']));
				$Monster_Golds = htmlspecialchars(addslashes($_POST['Monster_Golds']));
				$Monster_Town = htmlspecialchars(addslashes($_POST['Monster_Town']));

				$Towns_List_Query = $bdd->prepare("SELECT Town_ID 
				FROM Caranille_Towns
				WHERE Town_Name = ?");
				$Towns_List_Query->execute(array($Monster_Town));

				while ($Towns_List = $Towns_List_Query->fetch())
				{
					$Town_ID = $Towns_List['Town_ID'];
				}
				$Towns_List_Query->closeCursor();

				$Monster_Item_One = htmlspecialchars(addslashes($_POST['Monster_Item_One']));
				if ($Monster_Item_One == "Aucun objet" || $Monster_Item_One == "")
				{
					$Item_ID_One = 0;
					$Monster_Item_One_Rate = 0;
				}
				else
				{
					$Item_ID_One_List_Query = $bdd->prepare("SELECT Item_ID 
					FROM Caranille_Items
					WHERE Item_Name = ?");
					$Item_ID_One_List_Query->execute(array($Monster_Item_One));

					while ($Item_ID = $Item_ID_One_List_Query->fetch())
					{
						$Item_ID_One = $Item_ID['Item_ID'];
					}

					$Item_ID_One_List_Query->closeCursor();

					$Monster_Item_One_Rate = htmlspecialchars(addslashes($_POST['Monster_Item_One_Rate']));
				}

				$Monster_Item_Two = htmlspecialchars(addslashes($_POST['Monster_Item_Two']));
				if ($Monster_Item_Two == "Aucun objet" || $Monster_Item_Two == "")
				{
					$Item_ID_Two = 0;
					$Monster_Item_Two_Rate = 0;
				}
				else
				{
					$Item_ID_Two_List_Query = $bdd->prepare("SELECT Item_ID 
					FROM Caranille_Items
					WHERE Item_Name = ?");
					$Item_ID_Two_List_Query->execute(array($Monster_Item_Two));

					while ($Item_ID = $Item_ID_Two_List_Query->fetch())
					{
						$Item_ID_Two = $Item_ID['Item_ID'];
					}

					$Item_ID_Two_List_Query->closeCursor();

					$Monster_Item_Two_Rate = htmlspecialchars(addslashes($_POST['Monster_Item_Two_Rate']));
				}

				$Monster_Item_Three = htmlspecialchars(addslashes($_POST['Monster_Item_Three']));
				if ($Monster_Item_Three == "Aucun objet" || $Monster_Item_Three == "")
				{
					$Item_ID_Three = 0;
					$Monster_Item_Three_Rate = 0;
				}
				else
				{
					$Item_ID_Three_List_Query = $bdd->prepare("SELECT Item_ID 
					FROM Caranille_Items
					WHERE Item_Name = ?");
					$Item_ID_Three_List_Query->execute(array($Monster_Item_Three));

					while ($Item_ID = $Item_ID_Three_List_Query->fetch())
					{
						$Item_ID_Three = $Item_ID['Item_ID'];
					}

					$Item_ID_Three_List_Query->closeCursor();

					$Monster_Item_Three_Rate = htmlspecialchars(addslashes($_POST['Monster_Item_Three_Rate']));
				}

				$Monster_Item_Four = htmlspecialchars(addslashes($_POST['Monster_Item_Four']));
				if ($Monster_Item_Four== "Aucun objet" || $Monster_Item_Four == "")
				{
					$Item_ID_Four = 0;
					$Monster_Item_Four_Rate = 0;
				}
				else
				{
					$Item_ID_Four_List_Query = $bdd->prepare("SELECT Item_ID 
					FROM Caranille_Items
					WHERE Item_Name = ?");
					$Item_ID_Four_List_Query->execute(array($Monster_Item_Four));

					while ($Item_ID = $Item_ID_Four_List_Query->fetch())
					{
						$Item_ID_Four = $Item_ID['Item_ID'];
					}

					$Item_ID_Four_List_Query->closeCursor();

					$Monster_Item_Four_Rate = htmlspecialchars(addslashes($_POST['Monster_Item_Four_Rate']));
				}

				$Monster_Item_Five = htmlspecialchars(addslashes($_POST['Monster_Item_Five']));
				if ($Monster_Item_Five == "Aucun objet" || $Monster_Item_Five == "")
				{
					$Item_ID_Five = 0;
					$Monster_Item_Five_Rate = 0;
				}
				else
				{
					$Item_ID_Five_List_Query = $bdd->prepare("SELECT Item_ID 
					FROM Caranille_Items
					WHERE Item_Name = ?");
					$Item_ID_Five_List_Query->execute(array($Monster_Item_Five));

					while ($Item_ID = $Item_ID_Five_List_Query->fetch())
					{
						$Item_ID_Five = $Item_ID['Item_ID'];
					}

					$Item_ID_Five_List_Query->closeCursor();

					$Monster_Item_Five_Rate = htmlspecialchars(addslashes($_POST['Monster_Item_Five_Rate']));
				}

				$Monster_Access = $_POST['Monster_Access'];
				$Monster_Town = htmlspecialchars(addslashes($_POST['Monster_Town']));
				
				$Edit = $bdd->prepare("UPDATE Caranille_Monsters SET 
				Monster_Image= :Monster_Image, 
				Monster_Name= :Monster_Name, 
				Monster_Description= :Monster_Description, 
				Monster_Level = :Monster_Level, 
				Monster_Strength= :Monster_Strength, 
				Monster_Defense= :Monster_Defense, 
				Monster_HP= :Monster_HP, 
				Monster_MP= :Monster_MP, 
				Monster_Experience= :Monster_Experience, 
				Monster_Golds= :Monster_Golds, 
				Monster_Town= :Town_ID_choisit, 
				Monster_Item_One= :Item_ID_One_monstre, 
				Monster_Item_One_Rate= :Monster_Item_One_Rate, 
				Monster_Item_Two= :Item_ID_Two_monstre, 
				Monster_Item_Two_Rate= :Monster_Item_Two_Rate, 
				Monster_Item_Three= :Item_ID_Three_monstre, 
				Monster_Item_Three_Rate= :Monster_Item_Three_Rate,
				Monster_Item_Four= :Item_ID_Four_monstre,  
				Monster_Item_Four_Rate= :Monster_Item_Four_Rate, 
				Monster_Item_Five= :Item_ID_Five_monstre, 
				Monster_Item_Five_Rate= :Monster_Item_Five_Rate, 
				Monster_Access= :Monster_Access 
				WHERE Monster_ID= :Monster_ID");

				$Edit->execute(array(
				'Monster_Image'=> $Monster_Image, 
				'Monster_Name'=> $Monster_Name, 
				'Monster_Description'=> $Monster_Description, 
				'Monster_Level'=> $Monster_Level, 
				'Monster_Strength'=> $Monster_Strength, 
				'Monster_Defense'=> $Monster_Defense, 
				'Monster_HP'=> $Monster_HP, 
				'Monster_MP'=> $Monster_MP, 
				'Monster_Experience'=> $Monster_Experience, 
				'Monster_Golds'=> $Monster_Golds, 
				'Town_ID_choisit'=> $Town_ID, 
				'Item_ID_One_monstre'=> $Item_ID_One, 
				'Monster_Item_One_Rate'=> $Monster_Item_One_Rate, 
				'Item_ID_Two_monstre'=> $Item_ID_Two, 
				'Monster_Item_Two_Rate'=> $Monster_Item_Two_Rate, 
				'Item_ID_Three_monstre'=> $Item_ID_Three, 
				'Monster_Item_Three_Rate'=> $Monster_Item_Three_Rate, 
				'Item_ID_Four_monstre'=> $Item_ID_Four, 
				'Monster_Item_Four_Rate'=> $Monster_Item_Four_Rate, 
				'Item_ID_Five_monstre'=> $Item_ID_Five, 
				'Monster_Item_Five_Rate'=> $Monster_Item_Five_Rate, 
				'Monster_Access'=> $Monster_Access, 
				'Monster_ID'=> $Monster_ID));
				echo 'Monstre mis à jour';
			}
			else
			{
				echo 'Tous les champs n\'ont pas été remplis';
			}
		}
		if (isset($_POST['Delete']))
		{
			$Monster_ID = htmlspecialchars(addslashes($_POST['Monster_ID']));

			$Delete = $bdd->prepare("DELETE FROM Caranille_Monsters WHERE Monster_ID= :Monster_ID");
			$Delete->execute(array('Monster_ID'=> $Monster_ID));

			echo 'Le monstre a bien été supprimé';
		}
		if (isset($_POST['Add']))
		{
			echo 'Ajout d\'un monstre<br />';
			echo '<form method="POST" action="Monsters.php">';
			echo 'Image (Adresse)<br /> <input type="text" name="Monster_Image"><br /><br />';
			echo 'Nom<br /> <input type="text" name="Monster_Name"><br /><br />';
			echo 'description<br /><textarea name="Monster_Description" ID="message" rows="10" cols="50"></textarea><br /><br />';
			echo 'Niveau<br /> <input type="text" name="Monster_Level"><br /><br />';			
			echo 'Force<br /> <input type="text" name="Monster_Strength"><br /><br />';
			echo 'Défense<br /> <input type="text" name="Monster_Defense"><br /><br />';
			echo 'HP<br /> <input type="text" name="Monster_HP"><br /><br />';
			echo 'MP<br /> <input type="text" name="Monster_MP"><br /><br />';
			echo 'Experience<br /> <input type="text" name="Monster_Experience"><br /><br />';
			echo 'Pièce d\'or<br /> <input type="text" name="Monster_Golds"><br /><br />';
			echo '<select name="Monster_Town" ID="Monster_Town">';
			$Towns_List_Query = $bdd->query("SELECT * FROM Caranille_Towns");
			while ($Towns_List = $Towns_List_Query->fetch())
			{
				$Monster_Town = stripslashes($Towns_List['Town_Name']);
				echo "<option value=\"$Monster_Town\">$Monster_Town</option>";
			}
			$Towns_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo '<div class="important">Choisissez les objets que le monstre est suceptible de faire gagner en cas de victoire du joueur</div><br /><br />';
			echo 'Objet N°1<br />';
			echo '<select name="Monster_Item_One" ID="Monster_Item_One">';
			echo '<option value="Aucun objet">Aucun objet</option>';
			$Items_List_Query = $bdd->query("SELECT * FROM Caranille_Items");
			while ($Items_List = $Items_List_Query->fetch())
			{
				$Monster_Item_One = stripslashes($Items_List['Item_Name']);
				echo "<option value=\"$Monster_Item_One\">$Monster_Item_One</option>";
			}
			$Items_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo 'Taux d\'obtention de l\'objet<br /><input type="text" name="Monster_Item_One_Rate">%<br /><br />';
			echo 'Objet N°2<br />';
			echo '<select name="Monster_Item_Two" ID="Monster_Item_Two">';
			echo '<option value="Aucun objet">Aucun objet</option>';
			$Items_List_Query = $bdd->query("SELECT * FROM Caranille_Items");
			while ($Items_List = $Items_List_Query->fetch())
			{
				$Monster_Item_Two = stripslashes($Items_List['Item_Name']);
				echo "<option value=\"$Monster_Item_Two\">$Monster_Item_Two</option>";
			}
			$Items_List_Query->closeCursor();
			echo '</select><br /><br />';
			echo 'Taux d\'obtention de l\'objet<br /><input type="text" name="Monster_Item_Two_Rate">%<br /><br />';

			echo 'Objet N°3<br />';
			echo '<select name="Monster_Item_Three" ID="Monster_Item_Three">';
			echo '<option value="Aucun objet">Aucun objet</option>';
			$Items_List_Query = $bdd->query("SELECT * FROM Caranille_Items");
			while ($Items_List = $Items_List_Query->fetch())
			{
				$Monster_Item_Three = stripslashes($Items_List['Item_Name']);
				echo "<option value=\"$Monster_Item_Three\">$Monster_Item_Three</option>";
			}
			$Items_List_Query->closeCursor();
			echo '</select><br /><br />';
			echo 'Taux d\'obtention de l\'objet<br /><input type="text" name="Monster_Item_Three_Rate">%<br /><br />';

			echo 'Objet N°4<br />';
			echo '<select name="Monster_Item_Four" ID="Monster_Item_Four">';
			echo '<option value="Aucun objet">Aucun objet</option>';
			$Items_List_Query = $bdd->query("SELECT * FROM Caranille_Items");
			while ($Items_List = $Items_List_Query->fetch())
			{
				$Monster_Item_Four = stripslashes($Items_List['Item_Name']);
				echo "<option value=\"$Monster_Item_Four\">$Monster_Item_Four</option>";
			}
			$Items_List_Query->closeCursor();
			echo '</select><br /><br />';
			echo 'Taux d\'obtention de l\'objet<br /><input type="text" name="Monster_Item_Four_Rate">%<br /><br />';

			echo 'Objet N°5<br />';
			echo '<select name="Monster_Item_Five" ID="Monster_Item_Five">';
			echo '<option value="Aucun objet">Aucun objet</option>';
			$Items_List_Query = $bdd->query("SELECT * FROM Caranille_Items");
			while ($Items_List = $Items_List_Query->fetch())
			{
				$Monster_Item_Five = stripslashes($Items_List['Item_Name']);
				echo "<option value=\"$Monster_Item_Five\">$Monster_Item_Five</option>";
			}
			$Items_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo 'Taux d\'obtention de l\'objet<br /><input type="text" name="Monster_Item_Five_Rate">%<br /><br />';
			echo '<div class="important">Quel est le type du monstre ?</div><br />';
			echo '<select name="Monster_Access" ID="Monster_Access">';
				echo '<option value="Chapter">Histoire</option>';
				echo '<option value="Battle">Donjon</option>';
				echo '<option value="Mission">Mission</option>';
			echo '</select><br /><br />';
			echo '<input type="submit" name="End_Add" value="Ajouter">';
			echo '</form>';
		}
		if (isset($_POST['End_Add']))
		{
			if (isset($_POST['Monster_Image']) && ($_POST['Monster_Name']) && ($_POST['Monster_Description']) && ($_POST['Monster_Level']))
			{
				$Monster_Image = htmlspecialchars(addslashes($_POST['Monster_Image']));
				$Monster_Name = htmlspecialchars(addslashes($_POST['Monster_Name']));
				$Monster_Description = htmlspecialchars(addslashes($_POST['Monster_Description']));
				$Monster_Level = htmlspecialchars(addslashes($_POST['Monster_Level']));
				$Monster_Strength = htmlspecialchars(addslashes($_POST['Monster_Strength']));
				$Monster_Defense = htmlspecialchars(addslashes($_POST['Monster_Defense']));
				$Monster_HP = htmlspecialchars(addslashes($_POST['Monster_HP']));
				$Monster_MP = htmlspecialchars(addslashes($_POST['Monster_MP']));
				$Monster_Experience = htmlspecialchars(addslashes($_POST['Monster_Experience']));
				$Monster_Golds = htmlspecialchars(addslashes($_POST['Monster_Golds']));
				$Monster_Town = htmlspecialchars(addslashes($_POST['Monster_Town']));
				$Towns_List_Query = $bdd->prepare("SELECT Town_ID 
				FROM Caranille_Towns
				WHERE Town_Name = ?");
				$Towns_List_Query->execute(array($Monster_Town));

				while ($Towns_List = $Towns_List_Query->fetch())
				{
					$Town_ID = $Towns_List['Town_ID'];
				}
				$Monster_Item_One = htmlspecialchars(addslashes($_POST['Monster_Item_One']));
				if ($Monster_Item_One == "Aucun objet")
				{
					$Item_ID_One = 0;
					$Monster_Item_One_Rate = 0;
				}
				else
				{
					$Item_ID_One_List_Query = $bdd->prepare("SELECT Item_ID 
					FROM Caranille_Items
					WHERE Item_Name = ?");
					$Item_ID_One_List_Query->execute(array($Monster_Item_One));

					while ($Item_ID = $Item_ID_One_List_Query->fetch())
					{
						$Item_ID_One = stripslashes($Item_ID['Item_ID']);
					}

					$Item_ID_One_List_Query->closeCursor();

					$Monster_Item_One_Rate = htmlspecialchars(addslashes($_POST['Monster_Item_One_Rate']));
				}
				$Monster_Item_Two = htmlspecialchars(addslashes($_POST['Monster_Item_Two']));
				if ($Monster_Item_Two == "Aucun objet")
				{
					$Item_ID_Two = 0;
					$Monster_Item_Two_Rate = 0;
				}
				else
				{
					$Item_ID_Two_List_Query = $bdd->prepare("SELECT Item_ID 
					FROM Caranille_Items
					WHERE Item_Name = ?");
					$Item_ID_Two_List_Query->execute(array($Monster_Item_Two));

					while ($Item_ID = $Item_ID_Two_List_Query->fetch())
					{
						$Item_ID_Two = stripslashes($Item_ID['Item_ID']);
					}

					$Item_ID_Two_List_Query->closeCursor();

					$Monster_Item_Two_Rate = htmlspecialchars(addslashes($_POST['Monster_Item_Two_Rate']));
				}
				$Monster_Item_Three = htmlspecialchars(addslashes($_POST['Monster_Item_Three']));
				if ($Monster_Item_Three == "Aucun objet")
				{
					$Item_ID_Three = 0;
					$Monster_Item_Three_Rate = 0;
				}
				else
				{
					$Item_ID_Three_List_Query = $bdd->prepare("SELECT Item_ID 
					FROM Caranille_Items
					WHERE Item_Name = ?");
					$Item_ID_Three_List_Query->execute(array($Monster_Item_Three));

					while ($Item_ID = $Item_ID_Three_List_Query->fetch())
					{
						$Item_ID_Three = stripslashes($Item_ID['Item_ID']);
					}

					$Item_ID_Three_List_Query->closeCursor();

					$Monster_Item_Three_Rate = htmlspecialchars(addslashes($_POST['Monster_Item_Three_Rate']));
				}

				$Monster_Item_Four = htmlspecialchars(addslashes($_POST['Monster_Item_Four']));
				if ($Monster_Item_Four== "Aucun objet")
				{
					$Item_ID_Four = 0;
					$Monster_Item_Four_Rate = 0;
				}
				else
				{
					$Item_ID_Four_List_Query = $bdd->prepare("SELECT Item_ID 
					FROM Caranille_Items
					WHERE Item_Name = ?");
					$Item_ID_Four_List_Query->execute(array($Monster_Item_Four));

					while ($Item_ID = $Item_ID_Four_List_Query->fetch())
					{
						$Item_ID_Four = $Item_ID['Item_ID'];
					}

					$Item_ID_Four_List_Query->closeCursor();

					$Monster_Item_Four_Rate = htmlspecialchars(addslashes($_POST['Monster_Item_Four_Rate']));
				}

				$Monster_Item_Five = htmlspecialchars(addslashes($_POST['Monster_Item_Five']));
				if ($Monster_Item_Five == "Aucun objet")
				{
					$Item_ID_Five = 0;
					$Monster_Item_Five_Rate = 0;
				}
				else
				{
					$Item_ID_Five_List_Query = $bdd->prepare("SELECT Item_ID 
					FROM Caranille_Items
					WHERE Item_Name = ?");
					$Item_ID_Five_List_Query->execute(array($Monster_Item_Five));

					while ($Item_ID = $Item_ID_Five_List_Query->fetch())
					{
						$Item_ID_Five = $Item_ID['Item_ID'];
					}

					$Item_ID_Five_List_Query->closeCursor();

					$Monster_Item_Five_Rate = htmlspecialchars(addslashes($_POST['Monster_Item_Five_Rate']));
				}
				$Monster_Access = htmlspecialchars(addslashes($_POST['Monster_Access']));
				$Monster_Town = htmlspecialchars(addslashes($_POST['Monster_Town']));

				$Add = $bdd->prepare("INSERT INTO Caranille_Monsters VALUES(
				'', 
				:Monster_Image, 
				:Monster_Name, 
				:Monster_Description, 
				:Monster_Level, 
				:Monster_Strength, 
				:Monster_Defense, 
				:Monster_HP, 
				:Monster_MP, 
				:Monster_Experience, 
				:Monster_Golds, 
				:Town_ID_choisit, 
				:Item_ID_One, 
				:Monster_Item_One_Rate, 
				:Item_ID_Two, 
				:Monster_Item_Two_Rate, 
				:Item_ID_Three, 
				:Monster_Item_Three_Rate,
				:Item_ID_Four, 
				:Monster_Item_Four_Rate, 
				:Item_ID_Five, 
				:Monster_Item_Five_Rate,  
				:Monster_Access)");

				$Add->execute(array(
				'Monster_Image'=> $Monster_Image, 
				'Monster_Name'=> $Monster_Name, 
				'Monster_Description'=> $Monster_Description, 
				'Monster_Level'=> $Monster_Level, 
				'Monster_Strength'=> $Monster_Strength, 
				'Monster_Defense'=> $Monster_Defense, 
				'Monster_HP'=> $Monster_HP, 
				'Monster_MP'=> $Monster_MP, 
				'Monster_Experience'=> $Monster_Experience, 
				'Monster_Golds'=> $Monster_Golds, 
				'Town_ID_choisit'=> $Town_ID, 
				'Item_ID_One'=> $Item_ID_One, 
				'Monster_Item_One_Rate'=> $Monster_Item_One_Rate, 
				'Item_ID_Two'=> $Item_ID_Two, 
				'Monster_Item_Two_Rate'=> $Monster_Item_Two_Rate, 
				'Item_ID_Three'=> $Item_ID_Three, 
				'Monster_Item_Three_Rate'=> $Monster_Item_Three_Rate, 
				'Item_ID_Four'=> $Item_ID_Four, 
				'Monster_Item_Four_Rate'=> $Monster_Item_Four_Rate, 
				'Item_ID_Five'=> $Item_ID_Five, 
				'Monster_Item_Five_Rate'=> $Monster_Item_Five_Rate, 
				'Monster_Access'=> $Monster_Access));
				echo 'Monstre ajouté';
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
