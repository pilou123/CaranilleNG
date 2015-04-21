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
			if (empty($_POST['combattre_mission']) && empty($_POST['Accept']))
			{
				$Town = htmlspecialchars(addslashes($_SESSION['Town_ID']));
				$Player_Mission_Level = htmlspecialchars(addslashes($_SESSION['Mission']));
				$Mission_Level_Query = $bdd->prepare("SELECT * FROM Caranille_Missions, Caranille_Missions_Successful
				WHERE Mission_ID = Mission_Successful_Mission_ID
				AND Mission_Successful_Account_ID= ?
				AND Mission_Town= ?
				LIMIT 0,1");
				$Mission_Level_Query->execute(array($ID, $Town));

				$Mission_Number = $Mission_Level_Query->rowCount();
				if ($Mission_Number >= 1)
				{
					while ($Mission_Level = $Mission_Level_Query->fetch())
					{
						$Town = htmlspecialchars(addslashes($_SESSION['Town_ID']));
						$Mission_Number = htmlspecialchars(addslashes($Mission_Level['Mission_Number']));
						$Mission_Number = htmlspecialchars(addslashes($Mission_Number)) +1;

						$Mission_Query = $bdd->prepare("SELECT * FROM Caranille_Missions
						WHERE Mission_Number= ?
						AND Mission_Town= ?");
						$Mission_Query->execute(array('Mission_Number'=> $Mission_Number, 'Mission_Town'=> $Town));
						while ($Mission = $Mission_Query->fetch())
						{
							echo 'N° ' .stripslashes($Mission['Mission_Number']). '<br />';
							echo '' .stripslashes($Mission['Mission_Name']). '<br />';
							echo '' .stripslashes(nl2br($Mission['Mission_Introduction'])). '<br />';
							$Mission_ID = stripslashes($Mission['Mission_ID']);
							$_SESSION['Mission_ID'] = $Mission['Mission_ID'];
							$_SESSION['Mission_Introduction'] = stripslashes(nl2br($Mission['Mission_Introduction']));
							$_SESSION['Mission_Defeate'] = stripslashes(nl2br($Mission['Mission_Defeate']));
							$_SESSION['Mission_Victory'] = stripslashes(nl2br($Mission['Mission_Victory']));
							echo '<form method="POST" action="Mission.php">';
							echo "<input type=\"hidden\" name=\"Mission_ID\" value=\"$Mission_ID\">";
							echo "<input type=\"submit\" name=\"Accept\" value=\"$Mission_0\">";
							echo '</form><br /><br />';
						}
			
						$Mission_Query->closeCursor();

						if (empty($Mission_ID))
						{
							echo "$Mission_1";
						}
					}
				}
				
				if ($Mission_Number == 0)
				{
					$Town = htmlspecialchars(addslashes($_SESSION['Town_ID']));
					$Mission_Query = $bdd->prepare("SELECT * FROM Caranille_Missions
					WHERE Mission_Number= 1
					AND Mission_Town= ?");
					$Mission_Query->execute(array($Town));

					while ($Mission = $Mission_Query->fetch())
					{
						echo 'N° ' .stripslashes($Mission['Mission_Number']). '<br />';
						echo '' .stripslashes($Mission['Mission_Name']). '<br />';
						echo '' .stripslashes(nl2br($Mission['Mission_Introduction'])). '<br />';
						$Mission_ID = stripslashes($Mission['Mission_ID']);
						$_SESSION['Mission_ID'] = $Mission['Mission_ID'];
						$_SESSION['Mission_Introduction'] = stripslashes(nl2br($Mission['Mission_Introduction']));
						$_SESSION['Mission_Defeate'] = stripslashes(nl2br($Mission['Mission_Defeate']));
						$_SESSION['Mission_Victory'] = stripslashes(nl2br($Mission['Mission_Victory']));
						echo '<form method="POST" action="Mission.php">';
						echo "<input type=\"hidden\" name=\"Mission_ID\" value=\"$Mission_ID\">";
						echo "<input type=\"submit\" name=\"Accept\" value=\"$Mission_0\">";
						echo '</form><br /><br />';
					}
					$Mission_Query->closeCursor();

					if (empty($Mission_ID))
					{
						echo "$Mission_1";
					}
				}
			}
			if (isset($_POST['Accept']))
			{
				$Mission_ID = htmlspecialchars(addslashes($_POST['Mission_ID']));
				$Town = htmlspecialchars(addslashes($_SESSION['Town_ID']));
				$_SESSION['$Mission_ID'] = htmlspecialchars(addslashes($_POST['Mission_ID']));
				$Mission_Monster_Query = $bdd->prepare("SELECT * FROM Caranille_Missions, Caranille_Monsters
				WHERE Mission_ID = ?
				AND Mission_Town = ?
				AND Mission_Monster = Monster_ID");
				$Mission_Monster_Query->execute(array($Mission_ID, $Town));

				while ($Mission_Monster = $Mission_Monster_Query->fetch())
				{
					$Monster_Image = stripslashes($Mission_Monster['Monster_Image']);
					echo "<img src=\"$Monster_Image\"><br />";
					echo '' .stripslashes($Mission_Monster['Monster_Name']). '<br />';
					echo '' .stripslashes(nl2br($Mission_Monster['Monster_Description'])). '<br />';
					$_SESSION['Monster_ID'] = stripslashes($Mission_Monster['Monster_ID']);
					$_SESSION['Monster_Image'] = stripslashes($Mission_Monster['Monster_Image']);	
					$_SESSION['Monster_Name'] = stripslashes($Mission_Monster['Monster_Name']);
					$_SESSION['Monster_Description'] = stripslashes(nl2br($Mission_Monster['Monster_Description']));
					$_SESSION['Monster_Level'] = stripslashes($Mission_Monster['Monster_Level']);
					$_SESSION['Monster_Strength'] = stripslashes($Mission_Monster['Monster_Strength']);
					$_SESSION['Monster_Defense'] = stripslashes($Mission_Monster['Monster_Defense']);
					$_SESSION['Monster_HP'] = stripslashes($Mission_Monster['Monster_HP']);
					$_SESSION['Monster_Experience'] = stripslashes($Mission_Monster['Monster_Experience']);
					$_SESSION['Monster_Golds'] = stripslashes($Mission_Monster['Monster_Golds']);
					$_SESSION['Monster_Item_One'] = stripslashes($Mission_Monster['Monster_Item_One']);
					$_SESSION['Monster_Item_One_Rate'] = stripslashes($Mission_Monster['Monster_Item_One_Rate']);
					$_SESSION['Monster_Item_Two'] = stripslashes($Mission_Monster['Monster_Item_Two']);
					$_SESSION['Monster_Item_Two_Rate'] = stripslashes($Mission_Monster['Monster_Item_Three_Rate']);
					$_SESSION['Monster_Item_Three'] = stripslashes($Mission_Monster['Monster_Item_Three']);
					$_SESSION['Monster_Item_Three_Rate'] = stripslashes($Mission_Monster['Monster_Item_Three_Rate']);
					$_SESSION['Monster_Item_Four'] = stripslashes($Mission_Monster['Monster_Item_Four']);
					$_SESSION['Monster_Item_Four_Rate'] = stripslashes($Mission_Monster['Monster_Item_Four_Rate']);
					$_SESSION['Monster_Item_Five'] = stripslashes($Mission_Monster['Monster_Item_Five']);
					$_SESSION['Monster_Item_Five_Rate'] = stripslashes($Mission_Monster['Monster_Item_Five_Rate']);
					$_SESSION['Battle'] = 1;

					$_SESSION['Arena_Battle'] = 0;
					$_SESSION['Chapter_Battle'] = 0;
					$_SESSION['Dungeon_Battle'] = 0;
					$_SESSION['Mission_Battle'] = 1;
				}
				echo '<form method="POST" action="Battle.php">';
				echo "<input type=\"submit\" name=\"lancer_mission\" value=\"$Mission_2\">";
				echo '</form>';
			}
		}
		if ($_SESSION['Town'] == 0)
		{
			echo "$Mission_3";
		}
	}
	else
	{
		echo "$Mission_4";
	}	
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
