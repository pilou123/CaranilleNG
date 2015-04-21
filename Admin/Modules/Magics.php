<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	//Si le Access est administration, afficher le menu de l'administration
	if ($_SESSION['Access'] == "Admin")
	{
		if (empty($_POST['Edit'])&& empty($_POST['Second_Edit']) && (empty($_POST['Add'])))
		{
			echo "$AMagics_0<br />";
			echo '<form method="POST" action="Magics.php">';
			echo "<input type=\"submit\" name=\"Add\" value=\"$AMagics_1\">";
			echo "<input type=\"submit\" name=\"Edit\" value=\"$AMagics_2\">";
			echo '</form>';
		}
		if (isset($_POST['Edit']))
		{
			$Magics_List_Query = $bdd->query("SELECT * FROM Caranille_Magics");
			while ($Magics = $Magics_List_Query->fetch())
			{
				echo "$AMagics_3 " .$Magics['Magic_Name']. '<br />';
				$Magic_ID = stripslashes($Magics['Magic_ID']);
				echo '<form method="POST" action="Magics.php">';
				echo "<input type=\"hidden\" name=\"Magic_ID\" value=\"$Magic_ID\">";
				echo "<input type=\"submit\" name=\"Second_Edit\" value=\"$AMagics_4\">";
				echo "<input type=\"submit\" name=\"Delete\" value=\"$AMagics_5\">";
				echo '</form>';
			}
		}
		if (isset($_POST['Second_Edit']))
		{
			$Magic_ID = $_POST['Magic_ID'];

			$Magics_List_Query = $bdd->prepare("SELECT * FROM Caranille_Magics WHERE Magic_ID= ?");
			$Magics_List_Query->execute(array($Magic_ID));

			while ($Magics = $Magics_List_Query->fetch())
			{
				$_SESSION['Magic_ID'] = stripslashes($Magics['Magic_ID']);
				$Magic_Image = stripslashes($Magics['Magic_Image']);
				$Magic_Name = stripslashes($Magics['Magic_Name']);
				$Magic_Description = stripslashes($Magics['Magic_Description']);
				$Magic_Type = stripslashes($Magics['Magic_Type']);
				$Magic_Effect = stripslashes($Magics['Magic_Effect']);
				$Magic_MP_Cost = stripslashes($Magics['Magic_MP_Cost']);
				$Magic_Town = stripslashes($Magics['Magic_Town']);
				$Magic_Price = stripslashes($Magics['Magic_Price']);	
			}

			$Magics_List_Query->closeCursor();

			echo '<form method="POST" action="Magics.php">';
			echo "$AMagics_6<br /> <input type=\"text\" name=\"Magic_Image\" value=\"$Magic_Image\"><br /><br />";
			echo "$AMagics_7<br /> <input type=\"text\" name=\"Magic_Name\" value=\"$Magic_Name\"><br /><br />";
			echo "$AMagics_8<br /><textarea name=\"Magic_Description\" ID=\"message\" rows=\"10\" cols=\"50\">$Magic_Description</textarea><br /><br />";
			echo "$AMagics_9<br />";
			echo "<select name=\"Magic_Type\" ID=\"Magic_Type\">";
			if ($Magic_Type == "Attack")
			{
				echo "<option selected=\"selected\" value=\"$Magic_Type\">$Magic_Type</option>";
				echo "<option value=\"Health\">$AMagics_10</option>";
			}
			if ($Magic_Type == "Health")
			{
				echo "<option selected=\"selected\" value=\"$Magic_Type\">$Magic_Type</option>";
				echo "<option value=\"Attack\">$AMagics_11</option>";
			}
			echo '</select><br /><br />';
			echo "$AMagics_12<br /> <input type=\"text\" name=\"Magic_Effect\" value=\"$Magic_Effect\"><br /><br />";
			echo "$AMagics_13<br /> <input type=\"text\" name=\"Magic_MP_Cost\" value=\"$Magic_MP_Cost\"><br /><br />";
			echo "$AMagics_14<br /> <input type=\"text\" name=\"Magic_Price\" value=\"$Magic_Price\"><br /><br />";
			echo "$AMagics_15<br >";
			echo '<select name="Magic_Town" ID="Magic_Town">';
			$Towns_List_Query = $bdd->query("SELECT * FROM Caranille_Towns");
			while ($Towns_List = $Towns_List_Query->fetch())
			{
				$Magic_Town = stripslashes($Towns_List['Town_Name']);
				echo "<option value=\"$Magic_Town\">$Magic_Town</option>";
			}

			$Towns_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo "<input type=\"submit\" name=\"End_Edit\" value=\"$AMagics_4\"><br /><br />";
			echo '</form>';
		}
		if (isset($_POST['End_Edit']))
		{
			if (isset($_POST['Magic_Image']) && ($_POST['Magic_Name']) && ($_POST['Magic_Description']) && ($_POST['Magic_Type']) && ($_POST['Magic_Town']))
			{
				$Magic_ID = htmlspecialchars(addslashes($_SESSION['Magic_ID']));
				$Magic_Image = htmlspecialchars(addslashes($_POST['Magic_Image']));
				$Magic_Name = htmlspecialchars(addslashes($_POST['Magic_Name']));
				$Magic_Description = htmlspecialchars(addslashes($_POST['Magic_Description']));
				$Magic_Type = htmlspecialchars(addslashes($_POST['Magic_Type']));
				$Magic_Effect = htmlspecialchars(addslashes($_POST['Magic_Effect']));
				$Magic_MP_Cost = htmlspecialchars(addslashes($_POST['Magic_MP_Cost']));
				$Magic_Town = htmlspecialchars(addslashes($_POST['Magic_Town']));
				$recherche_Town_ID = $bdd->prepare("SELECT Town_ID 
				FROM Caranille_Towns
				WHERE Town_Name = ?");
				$recherche_Town_ID->execute(array($Magic_Town));

				while ($Town_ID = $recherche_Town_ID->fetch())
				{
					$Town_ID_choisit = stripslashes($Town_ID['Town_ID']);
				}

				$recherche_Town_ID->closeCursor();

				$Magic_Price = htmlspecialchars(addslashes($_POST['Magic_Price']));

				$Edit = $bdd->prepare("UPDATE Caranille_Magics SET Magic_Image= :Magic_Image, Magic_Name= :Magic_Name, Magic_Description= :Magic_Description, Magic_Type= :Magic_Type, Magic_Effect= :Magic_Effect, Magic_MP_Cost= :Magic_MP_Cost, Magic_Town= :Town_ID_choisit, Magic_Price= :Magic_Price WHERE Magic_ID= :Magic_ID");
				$Edit->execute(array('Magic_Image'=> $Magic_Image, 'Magic_Name'=> $Magic_Name, 'Magic_Description'=> $Magic_Description, 'Magic_Type'=> $Magic_Type, 'Magic_Effect'=> $Magic_Effect, 'Magic_MP_Cost'=> $Magic_MP_Cost, 'Town_ID_choisit'=> $Town_ID_choisit, 'Magic_Price'=> $Magic_Price, 'Magic_ID'=> $Magic_ID));
				
				echo $AMagics_16;
			}
			else
			{
				echo $AMagics_17;
			}
		}
		if (isset($_POST['Delete']))
		{
			$Magic_ID = htmlspecialchars(addslashes($_POST['Magic_ID']));

			$Delete = $bdd->prepare("DELETE FROM Caranille_Magics WHERE Magic_ID= :Magic_ID");
			$Delete->execute(array('Magic_ID'=> $Magic_ID));

			echo $AMagics_18;
		}
		if (isset($_POST['Add']))
		{
			echo "$AMagics_19<br />";
			echo '<form method="POST" action="Magics.php">';
			echo "$AMagics_6<br /> <input type=\"text\" name=\"Magic_Image\"><br /><br />";
			echo "$AMagics_7<br /> <input type=\"text\" name=\"Magic_Name\"><br /><br />";
			echo "$AMagics_8<br /><textarea name=\"Magic_Description\" ID=\"message\" rows=\"10\" cols=\"50\"></textarea><br /><br />";
			echo "$AMagics_9<br />";
			echo '<select name="Magic_Type" ID="Magic_Type">';
				echo "option value=\"Health\">$AMagics_10</option>";
				echo "<option value=\"Attack\">$AMagics_11</option>";
			echo '</select><br /><br />';
			echo "AMagics_12<br /> <input type=\"text\" name=\"Magic_Effect\"><br /><br />";
			echo "AMagics_13<br /> <input type=\"text\" name=\"Magic_MP_Cost\"><br /><br />";				
			echo "$AMagics_14<br /> <input type=\"text\" name=\"Magic_Price\"><br /><br />";
			echo "$AMagics_15<br />";
			echo "<select name=\"Magic_Town\" ID=\"Magic_Town\">";
			$Towns_List_Query = $bdd->query("SELECT * FROM Caranille_Towns");
			while ($Towns_List = $Towns_List_Query->fetch())
			{
				$Magic_Town = stripslashes($Towns_List['Town_Name']);
				echo "<option value=\"$Magic_Town\">$Magic_Town</option>";
			}
			$Towns_List_Query->closeCursor();

			echo '</select><br /><br />';
			echo "<input type=\"submit\" name=\"End_Add\" value=\"$AMagics_20\"><br /><br />";
			echo '</form>';
		}
		if (isset($_POST['End_Add']))
		{
			if (isset($_POST['Magic_Image']) && ($_POST['Magic_Name']) && ($_POST['Magic_Description']) && ($_POST['Magic_Type']) && ($_POST['Magic_Town']))
			{
				$Magic_Image = htmlspecialchars(addslashes($_POST['Magic_Image']));
				$Magic_Name = htmlspecialchars(addslashes($_POST['Magic_Name']));
				$Magic_Description = htmlspecialchars(addslashes($_POST['Magic_Description']));
				$Magic_Type = htmlspecialchars(addslashes($_POST['Magic_Type']));
				$Magic_Effect = htmlspecialchars(addslashes($_POST['Magic_Effect']));
				$Magic_MP_Cost = htmlspecialchars(addslashes($_POST['Magic_MP_Cost']));
				$Magic_Town = htmlspecialchars(addslashes($_POST['Magic_Town']));

				$recherche_Town_ID = $bdd->prepare("SELECT Town_ID 
				FROM Caranille_Towns
				WHERE Town_Name = ?");
				$recherche_Town_ID->execute(array($Magic_Town));

				while ($Town_ID = $recherche_Town_ID->fetch())
				{
					$Town_ID_choisit = stripslashes($Town_ID['Town_ID']);
				}

				$recherche_Town_ID->closeCursor();

				$Magic_Price = htmlspecialchars(addslashes($_POST['Magic_Price']));

				$Add = $bdd->prepare("INSERT INTO Caranille_Magics VALUES('', :Magic_Image, :Magic_Name, :Magic_Description, :Magic_Type, :Magic_Effect, :Magic_MP_Cost, :Town_ID_choisit, :Magic_Price)");
				$Add->execute(array('Magic_Image'=> $Magic_Image, 'Magic_Name'=> $Magic_Name, 'Magic_Description'=> $Magic_Description, 'Magic_Type'=> $Magic_Type, 'Magic_Effect'=> $Magic_Effect, 'Magic_MP_Cost'=> $Magic_MP_Cost, 'Town_ID_choisit'=> $Town_ID_choisit, 'Magic_Price'=> $Magic_Price));
				
				echo $AMagics_21;
			}
			else
			{
				echo $AMagics_22;
			}
		}
	}
	else
	{
		echo "<center>";
		echo $AMagics_23;
		echo "</center>";
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
