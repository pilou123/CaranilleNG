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
			echo "$ATowns_0<br />";
			echo '<form method="POST" action="Towns.php">';
			echo "<input type=\"submit\" name=\"Add\" value=\"$ATowns_1\">";
			echo "<input type=\"submit\" name=\"Edit\" value=\"$ATowns_2\">";
			echo '</form>';
		}
		if (isset($_POST['Edit']))
		{
			echo "$ATowns_3<br /><br />";
			$Towns_List_Query = $bdd->query("SELECT * FROM Caranille_Towns");
			while ($Towns_List = $Towns_List_Query->fetch())
			{
				echo $Towns_List['Town_Name'];
				$Town_ID = stripslashes($Towns_List['Town_ID']);
				echo '<form method="POST" action="Towns.php">';
				echo "<input type=\"hidden\" name=\"Town_ID\" value=\"$Town_ID\">";
				echo "<input type=\"submit\" name=\"Second_Edit\" value=\"$ATowns_4\">";
				echo "<input type=\"submit\" name=\"Delete\" value=\"$ATowns_5\">";
				echo '</form>';
			}
			$Towns_List_Query->closeCursor();
		}
		if (isset($_POST['Second_Edit']))
		{
			$Town_ID = htmlspecialchars(addslashes($_POST['Town_ID']));

			$Towns_List_Query = $bdd->prepare("SELECT * FROM Caranille_Towns WHERE Town_ID= ?");
			$Towns_List_Query->execute(array($Town_ID));

			while ($Towns_List = $Towns_List_Query->fetch())
			{
				$_SESSION['Town_ID'] = stripslashes($Towns_List['Town_ID']);
				$Town_Image = stripslashes($Towns_List['Town_Image']);
				$Town_Name = stripslashes($Towns_List['Town_Name']);
				$Town_Description = stripslashes($Towns_List['Town_Description']);
				$Town_Price_INN = stripslashes($Towns_List['Town_Price_INN']);
				$Town_Chapter = stripslashes($Towns_List['Town_Chapter']);
			}
			$Towns_List_Query->closeCursor();

			echo '</form><br /><br />';
			echo '<form method="POST" action="Towns.php">';
			echo "$ATowns_6<br /> <input type=\"text\" name=\"Town_Image\" value=\"$Town_Image\"><br /><br />";
			echo "$ATowns_7<br /> <input type=\"text\" name=\"Town_Name\" value=\"$Town_Name\"><br /><br />";
			echo "$ATowns_8<br /><textarea name=\"Town_Description\" ID=\"message\" rows=\"10\" cols=\"50\">$Town_Description</textarea><br /><br />";
			echo "$ATowns_9<br /> <input type=\"text\" name=\"Town_Price_INN\" value=\"$Town_Price_INN\"><br /><br />";
			echo "$ATowns_10<br /> <input type=\"text\" name=\"Town_Chapter\" value=\"$Town_Chapter\"><br /><br />";
			echo "<input type=\"submit\" name=\"End_Edit\" value=\"$ATowns_11\">";
			echo '</form>';
		}
		if (isset($_POST['End_Edit']))
		{
			if (isset($_POST['Town_Image']) && ($_POST['Town_Name']) && ($_POST['Town_Description']) && ($_POST['Town_Chapter']))
			{
				$Town_ID = htmlspecialchars(addslashes($_SESSION['Town_ID']));
				$Town_Image = htmlspecialchars(addslashes($_POST['Town_Image']));
				$Town_Name = htmlspecialchars(addslashes($_POST['Town_Name']));
				$Town_Description = htmlspecialchars(addslashes($_POST['Town_Description']));
				$Town_Price_INN = htmlspecialchars(addslashes($_POST['Town_Price_INN']));
				$Town_Chapter = htmlspecialchars(addslashes($_POST['Town_Chapter']));

				$Edit = $bdd->prepare("UPDATE Caranille_Towns SET Town_Image= :Town_Image, Town_Name= :Town_Name, Town_Description= :Town_Description, Town_Price_INN= :Town_Price_INN, Town_Chapter= :Town_Chapter WHERE Town_ID= :Town_ID");
				$Edit->execute(array('Town_Image'=> $Town_Image, 'Town_Name'=> $Town_Name, 'Town_Description'=> $Town_Description, 'Town_Price_INN'=> $Town_Price_INN, 'Town_Chapter'=> $Town_Chapter, 'Town_ID'=> $Town_ID));
				
				echo $ATowns_12;
			}
			else
			{
				echo $ATowns_13;
			}
		}
		if (isset($_POST['Delete']))
		{
			$Town_ID = htmlspecialchars(addslashes($_POST['Town_ID']));

			$Delete = $bdd->prepare("DELETE FROM Caranille_Towns WHERE Town_ID= ?");
			$Delete->execute(array($Town_ID));

			echo $ATowns_14;
		}
		if (isset($_POST['Add']))
		{
			echo '</form><br /><br />';
			echo '<form method="POST" action="Towns.php">';
			echo "$ATowns_6<br /> <input type=\"text\" name=\"Town_Image\"><br /><br />";	
			echo "$ATowns_7<br /> <input type=\"text\" name=\"Town_Name\"><br /><br />";
			echo "$ATowns_8<br /><textarea name=\"Town_Description\" ID=\"message\" rows=\"10\" cols=\"50\"></textarea><br /><br />";
			echo "$ATowns_9<br /> <input type=\"text\" name=\"Town_Price_INN\"><br /><br />";
			echo "$ATowns_10<br /> <input type=\"text\" name=\"Town_Chapter\"><br /><br />";
			echo "<input type=\"submit\" name=\"End_Add\" value=\"$ATowns_11\">";
			echo '</form>';
		}
		if (isset($_POST['End_Add']))
		{
			if (isset($_POST['Town_Image']) && ($_POST['Town_Name']) && ($_POST['Town_Description']) && ($_POST['Town_Chapter']))
			{
				$Town_Image = htmlspecialchars(addslashes($_POST['Town_Image']));	
				$Town_Name = htmlspecialchars(addslashes($_POST['Town_Name']));
				$Town_Description = htmlspecialchars(addslashes($_POST['Town_Description']));
				$Town_Price_INN = htmlspecialchars(addslashes($_POST['Town_Price_INN']));
				$Town_Chapter = htmlspecialchars(addslashes($_POST['Town_Chapter']));
				$Add = $bdd->prepare("INSERT INTO Caranille_Towns VALUES ('', :Town_Image, :Town_Name, :Town_Description, :Town_Price_INN, :Town_Chapter)");
				$Add->execute(array('Town_Image'=> $Town_Image, 'Town_Name'=> $Town_Name, 'Town_Description'=> $Town_Description, 'Town_Price_INN'=> $Town_Price_INN, 'Town_Chapter'=> $Town_Chapter));
			
				echo $ATowns_15;
			}
			else
			{
				echo $ATowns_13;
			}
		}
	}
	else
	{
		echo '<center>';
		echo $ATowns_16;
		echo '</center>';
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
