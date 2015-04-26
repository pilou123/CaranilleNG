<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	if ($_SESSION['Access'] == "Admin")
	{
		if (empty($_POST['Add']) && empty($_POST['End_Add']))
		{
			echo "$APresents_0<br />";
			echo '<form method="POST" action="Presents.php">';
			echo "<input type=\"submit\" name=\"Add\" value=\"$APresents_1\">";
			echo '</form>';
		}
		if (isset($_POST['Add']))
		{
			echo "$APresents_2<br />";
			echo '<form method="POST" action="Presents.php">';
			echo "<label for=\"Receiver\">$APresents_3</label><br />";
			echo '<select name="Receiver" ID="Receiver">';
			$Player_List_Query = $bdd->query("SELECT * FROM Caranille_Accounts ORDER BY Account_Pseudo ASC");
			while ($Player_List = $Player_List_Query->fetch())
			{
				$Receiver = stripslashes($Player_List['Account_Pseudo']);
				echo "<option value=\"$Receiver\">$Receiver</option>";
			}
			$Player_List_Query->closeCursor();
			echo '</select><br /><br />';

			echo "<label for=\"Item_Name\">$APresents_4</label><br />";
			echo '<select name="Item_Name" ID="Item_Name">';
			$Item_List_Query = $bdd->query("SELECT * FROM Caranille_Items ORDER BY Item_Name ASC");
			while ($Item_List = $Item_List_Query->fetch())
			{
				$Item_ID = stripslashes($Item_List['Item_ID']);
				$Item_Name = stripslashes($Item_List['Item_Name']);
				echo "<option value=\"$Item_Name\">$Item_Name</option>";
			}
			$Item_List_Query->closeCursor();
			echo '</select><br /><br />';
			echo "<input type=\"submit\" name=\"End_Add\" value=\"$APresents_5\">";
			echo '</form>';

		}
		if (isset($_POST['End_Add']))
		{
			echo "Do nothing";
		}
	}
	else
	{
		echo '<center>';
		echo $APresents_29;
		echo '</center>';
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
