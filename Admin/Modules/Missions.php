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
			echo "$AMissions_0<br />";
			echo '<form method="POST" action="Missions.php">';
			echo "<input type=\"submit\" name=\"Add\" value=\"$AMissions_1\">";
			echo "<input type=\"submit\" name=\"Edit\" value=\"$AMissions_2\">";
			echo '</form>';
		}
		if (isset($_POST['Edit']))
		{
			echo "$AMissions_3<br /><br />";
			$Missions_List_Query = $bdd->query("SELECT * 
			FROM Caranille_Missions, Caranille_Towns
			WHERE Mission_Town = Town_ID
			ORDER BY Town_Name ASC");
			while ($Missions_List = $Missions_List_Query->fetch())
			{
				echo "<br /><div class=\"important\">$AMissions_4</div>" .$Missions_List['Town_Name']. "<br />";
				echo "<div class=\"important\">$AMissions_5</div>" .$Missions_List['Mission_Number']. "<br />";
				echo "<div class=\"important\">$AMissions_6</div>" .$Missions_List['Mission_Name']. "<br />";
				$Mission_ID = stripslashes($Missions_List['Mission_ID']);
				echo '<form method="POST" action="Missions.php">';
				echo "<input type=\"hidden\" name=\"Mission_ID\" value=\"$Mission_ID\">";
				echo "<input type=\"submit\" name=\"Second_Edit\" value=\"$AMissions_7\">";
				echo "<input type=\"submit\" name=\"Delete\" value=\"$AMissions_8\">";
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
			echo "$AMissions_9<br /><br />";
			echo "<br />$AMissions_10<br />";
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
			echo "$AMissions_11<br /> <input type=\"text\" name=\"Mission_Number\" value=\"$Mission_Number\"><br /><br />";
			echo "$AMissions_12<br /><input type=\"text\" name=\"Mission_Name\" value=\"$Mission_Name\"><br /><br />";
			echo "$AMissions_13<br /><textarea name=\"Mission_Introduction\" ID=\"message\" rows=\"10\" cols=\"50\">$Mission_Introduction</textarea><br /><br />";
			echo "$AMissions_14<br /><textarea name=\"Mission_Victory\" ID=\"message\" rows=\"10\" cols=\"50\">$Mission_Victory</textarea><br /><br />";
			echo "$AMissions_15<br /><textarea name=\"Mission_Defeate\" ID=\"message\" rows=\"10\" cols=\"50\">$Mission_Defeate</textarea><br />";
			echo "<br />$AMissions_16<br />";
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
			echo "<input type=\"submit\" name=\"End_Edit\" value=\"$AMissions_17\">";
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
				
				echo $AMissions_18;
			}
			else
			{
				echo $AMissions_19;
			}
		}
		if (isset($_POST['Delete']))
		{
			$Mission_ID = htmlspecialchars(addslashes($_POST['Mission_ID']));
			$bdd->exec("DELETE FROM Caranille_Missions WHERE Mission_ID='$Mission_ID'");
			echo $AMissions_20;
		}
		if (isset($_POST['Add']))
		{
			echo '</form><br /><br />';
			echo '<form method="POST" action="Missions.php">';
			echo "$AMissions_9<br /><br />";
			echo "<br />$AMissions_10<br />";
			echo '<select name="Mission_Town" ID="Mission_Town">';
			$Town_List_Query = $bdd->query("SELECT * FROM Caranille_Towns");
			while ($Town_List = $Town_List_Query->fetch())
			{
				$Mission_Town = $Town_List['Town_Name'];
				echo "<option value=\"$Mission_Town\">$Mission_Town</option>";
			}
			$Town_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo "$AMissions_11<br /> <input type=\"text\" name=\"Mission_Number\"><br /><br />";
			echo "$AMissions_12<br /> <input type=\"text\" name=\"Mission_Name\"><br /><br />";
			echo "$AMissions_13<br /><textarea name=\"Mission_Introduction\" ID=\"message\" rows=\"10\" cols=\"50\"></textarea><br /><br />";
			echo "$AMissions_14<br /><textarea name=\"Mission_Victory\" ID=\"message\" rows=\"10\" cols=\"50\"></textarea><br /><br />";
			echo "$AMissions_15<br /><textarea name=\"Mission_Defeate\" ID=\"message\" rows=\"10\" cols=\"50\"></textarea><br />";
			echo "$AMissions_16<br />";
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
			echo "<input type=\"submit\" name=\"End_Add\" value=\"$AMissions_17\">";
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
				
				echo $AMissions_21;
			}
			else
			{
				echo $AMissions_22;
			}	
		}
	}
	else
	{
		echo '<center>';
		echo $AMissions_23;
		echo '</center>';
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
