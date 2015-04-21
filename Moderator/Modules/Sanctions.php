<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';

	//Si le Access est Modo ou Admin
	if ($_SESSION['Access'] == "Modo" || $_SESSION['Access'] == "Admin")
	{
		if (empty($_POST['Add']))
        {
			echo '</form><br /><br />';
			echo '<form method="POST" action="Sanctions.php">';
			echo "<label for=\"Receiver\">$MSanction_0</label><br />";
			echo '<select name="Receiver" ID="Receiver">';
			$Players_List_Query = $bdd->query("SELECT * FROM Caranille_Accounts ORDER BY Account_Pseudo ASC");
			while ($Players_List = $Players_List_Query->fetch())
			{
				$Receiver = stripslashes($Players_List['Account_Pseudo']);
				echo "<option value=\"$Receiver\">$Receiver</option>";
			}

			$Players_List_Query->closecursor();

			echo '</select><br /><br />';
			echo 'Raison du banissement <br /> <input type="text" name="Reason"><br /><br />';	
			echo "<input type=\"submit\" name=\"Add\" value=\"$MSanction_1\">";
			echo '</form>';
		}
		if (isset($_POST['Add']))
		{
			if (isset($_POST['Reason']) && ($_POST['Receiver']))
			{
			    $Status = "Banned";
				$Reason = htmlspecialchars(addslashes($_POST['Reason']));	
				$Account_Pseudo = htmlspecialchars(addslashes($_POST['Receiver']));

				$recherche_Sanction_Receiver = $bdd->prepare("SELECT Account_ID 
				FROM Caranille_Accounts
				WHERE Account_Pseudo = ?");
				$recherche_Sanction_Receiver->execute(array($Account_Pseudo));

				while ($Account_ID = $recherche_Sanction_Receiver->fetch())
				{
					$Sanction_Receiver = stripslashes($Account_ID['Account_ID']);
				}
				$recherche_Sanction_Receiver->closeCursor();

				$Add_Banned = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Status= :Status, Account_Reason= :Reason WHERE Account_ID= :ID");
				$Add_Banned->execute(array('Status'=> $Status, 'Reason'=> $Reason, 'ID'=> $ID));
				echo $MSanction_2;
			}
			else
			{
				echo "$MSanction_3";
			}
		}
	}
	else
	{
		echo "<center>";
		echo "$MSanction_4";
		echo "</center>";
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
