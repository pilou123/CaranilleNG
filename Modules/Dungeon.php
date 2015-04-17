<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	if (isset($_SESSION['ID']))
	{
		if ($_SESSION['Town'] == 1)
		{
			if (empty($_POST['Battle']))
			{	
				echo "$Dungeon_0";
				$ville_actuel = htmlspecialchars(addslashes($_SESSION['Town_ID']));

				$recherche_monstre = $bdd->prepare("SELECT * FROM Caranille_Monsters
				WHERE Monster_Town = ?
				AND Monster_Access = 'Battle'");
				$recherche_monstre->execute(array($ville_actuel));

				while ($monstre = $recherche_monstre->fetch())
				{
					$Monster_Image = stripslashes($monstre['Monster_Image']);
					$Monster_ID = stripslashes($monstre['Monster_ID']);
					echo "<img src=\"$Monster_Image\"><br />";
					echo "" .stripslashes($monstre['Monster_Name']). "<br />";
					echo "" .stripslashes(nl2br($monstre['Monster_Description'])). "<br />";
					echo "HP: " .stripslashes($monstre['Monster_HP']). "<br />";
					echo "MP: " .stripslashes($monstre['Monster_MP']). "<br />";
					echo '<form method="POST" action="Dungeon.php">';
					echo "<input type=\"hidden\" name=\"Monster_ID\" value=\"$Monster_ID\">";
					echo "<input type=\"submit\" name=\"Battle\" value=\"$Dungeon_1\">";
					echo '</form><br />';
				}

				$recherche_monstre->closeCursor();

				if (empty($Monster_ID))
				{
					echo "$Dungeon_2";
				}
			}
			if (isset($_POST['Battle']))
			{
				$ville_actuel = htmlspecialchars(addslashes($_SESSION['Town_ID']));
				$Monster_ID = htmlspecialchars(addslashes($_POST['Monster_ID']));

				$recherche_monstre = $bdd->prepare("SELECT * FROM Caranille_Monsters 
				WHERE Monster_ID= ?");
				$recherche_monstre->execute(array($Monster_ID));

				while ($monstre = $recherche_monstre->fetch())
				{
					$Monster_Image = stripslashes($monstre['Monster_Image']);
					echo "<img src=\"$Monster_Image\"><br />";
					echo "" .$monstre['Monster_Name']. "<br />";
					echo "" .stripslashes(nl2br($monstre['Monster_Description'])). "<br />";
					echo "HP: ???<br />";
					echo "MP: ???<br />";
					$_SESSION['Monster_ID'] = stripslashes($monstre['Monster_ID']);
					$_SESSION['Monster_Image'] = stripslashes($monstre['Monster_Image']);
					$_SESSION['Monster_Name'] = stripslashes($monstre['Monster_Name']);
					$_SESSION['Monster_Description'] = stripslashes(nl2br($monstre['Monster_Description']));
					$_SESSION['Monster_Level'] = stripslashes($monstre['Monster_Level']);
					$_SESSION['Monster_Strength'] = stripslashes($monstre['Monster_Strength']);
					$_SESSION['Monster_Defense'] = stripslashes($monstre['Monster_Defense']);
					$_SESSION['Monster_HP'] = stripslashes($monstre['Monster_HP']);
					$_SESSION['Monster_Experience'] = stripslashes($monstre['Monster_Experience']);
					$_SESSION['Monster_Golds'] = stripslashes($monstre['Monster_Golds']);
					$_SESSION['Monster_Item_One'] = stripslashes($monstre['Monster_Item_One']);
					$_SESSION['Monster_Item_One_Rate'] = stripslashes($monstre['Monster_Item_One_Rate']);
					$_SESSION['Monster_Item_Two'] = stripslashes($monstre['Monster_Item_Two']);
					$_SESSION['Monster_Item_Two_Rate'] = stripslashes($monstre['Monster_Item_Two_Rate']);
					$_SESSION['Monster_Item_Three'] = stripslashes($monstre['Monster_Item_Three']);
					$_SESSION['Monster_Item_Three_Rate'] = stripslashes($monstre['Monster_Item_Three_Rate']);
					$_SESSION['Monster_Item_Four'] = stripslashes($monstre['Monster_Item_Four']);
					$_SESSION['Monster_Item_Four_Rate'] = stripslashes($monstre['Monster_Item_Four_Rate']);
					$_SESSION['Monster_Item_Five'] = stripslashes($monstre['Monster_Item_Five']);
					$_SESSION['Monster_Item_Five_Rate'] = stripslashes($monstre['Monster_Item_Five_Rate']);
					$_SESSION['Battle'] = 1;

					$_SESSION['Arena_Battle'] = 0;
					$_SESSION['Chapter_Battle'] = 0;
					$_SESSION['Dungeon_Battle'] = 1;
					$_SESSION['Mission_Battle'] = 0;
				
					echo '<form method="POST" action="Battle.php">';
					echo "<input type=\"submit\" name=\"lancer_donjon\" value=\"$Dungeon_3\">";
					echo '</form>';
				}

				$recherche_monstre->closeCursor();

			}
		}
		if ($_SESSION['Town'] == 0)
		{
			echo "$Dungeon_4";
		}
	}
	else
	{
		echo "$Dungeon_5";
	}	
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
