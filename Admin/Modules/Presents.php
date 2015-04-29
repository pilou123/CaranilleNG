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
			echo "<label for=\"Account_ID\">$APresents_3</label><br />";
			echo '<select name="Account_ID" ID="Account_ID">';
			$Player_List_Query = $bdd->query("SELECT * FROM Caranille_Accounts ORDER BY Account_Pseudo ASC");
			while ($Player_List = $Player_List_Query->fetch())
			{
				$Account_ID = stripslashes($Player_List['Account_ID']);
				$Account_Pseudo = stripslashes($Player_List['Account_Pseudo']);
				echo "<option value=\"$Account_ID\">$Account_Pseudo</option>";
			}
			$Player_List_Query->closeCursor();
			echo '</select><br /><br />';
			
			echo "<label for=\"Item_ID\">$APresents_4</label><br />";
			echo '<select name="Item_ID" ID="Item_ID">';
			$Item_List_Query = $bdd->query("SELECT * FROM Caranille_Items ORDER BY Item_Name ASC");
			while ($Item_List = $Item_List_Query->fetch())
			{
				$Item_ID = stripslashes($Item_List['Item_ID']);
				$Item_Name = stripslashes($Item_List['Item_Name']);
				echo "<option value=\"$Item_ID\">$Item_Name</option>";
			}
			$Item_List_Query->closeCursor();
			echo '</select><br /><br />';
			echo "$APresents_5<br /><textarea name=\"Message\" ID=\"message\" rows=\"10\" cols=\"50\"></textarea><br /><br />";
			echo "<input type=\"submit\" name=\"End_Add\" value=\"$APresents_5\">";
			echo '</form>';
		}
		if (isset($_POST['End_Add']))
		{
			$Account_ID = htmlspecialchars(addslashes($_POST['Account_ID']));
			$Item_ID = htmlspecialchars(addslashes($_POST['Item_ID']));
			$Message = htmlspecialchars(addslashes($_POST['Message']));
			
			$Item_Quantity_Query = $bdd->prepare("SELECT * FROM Caranille_Inventory
			WHERE Inventory_Item_ID= ?
			AND Inventory_Account_ID= ?");
			$Item_Quantity_Query->execute(array($Item_ID, $Account_ID));
		
			$Item_Quantity = $Item_Quantity_Query->rowCount();
			if ($Item_Quantity>=1)
			{
				$Add_Item = $bdd->prepare("UPDATE Caranille_Inventory SET Inventory_Item_Quantity = Inventory_Item_Quantity + 1
				WHERE Inventory_Item_ID= :Item_ID
				AND Inventory_Account_ID = :Account_ID");
				$Add_Item->execute(array('Item_ID'=> $Item_ID, 'Account_ID'=> $Account_ID));
			}
			else
			{
				$Add_Item = $bdd->prepare("INSERT INTO Caranille_Inventory VALUES('', :Account_ID, :Item_ID, '1', 'No')");
				$Add_Item->execute(array('Account_ID'=> $Account_ID, 'Item_ID'=> $Item_ID));
			}
			echo $APresents_6;
		}
	}
	else
	{
		echo '<center>';
		echo $APresents_7;
		echo '</center>';
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
