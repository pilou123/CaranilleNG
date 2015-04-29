<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';

	//Si le Access est Modo ou Admin
	if ($_SESSION['Access'] == "Modo" || $_SESSION['Access'] == "Admin")
	{
		if (empty($_POST['Add']) && (empty($_POST['End_Add'])))
		{
			echo "$MWarning_0";
			echo '<form method="POST" action="Warnings.php">';
			echo "<input type=\"submit\" name=\"Add\" value=\"$MWarning_1\">";
			echo '</form>';
		}
		if (isset($_POST['Add']))
		{
			echo '</form><br /><br />';
			echo '<form method="POST" action="Warnings.php">';
			echo "$MWarning_2<br /> <input type=\"text\" name=\"Avert_Type\"><br /><br />";	
			echo "$MWarning_3<br /> <input type=\"text\" name=\"Avert_Message\"><br /><br />";
			echo "<label for=\"Receiver\">$MWarning_4</label><br />";
			echo '<select name="Receiver" ID="Receiver">';
			$Players_List_Query = $bdd->query("SELECT * FROM Caranille_Accounts ORDER BY Account_Pseudo ASC");
			while ($Players_List = $Players_List_Query->fetch())
			{
				$Receiver_ID = stripslashes($Players_List['Account_ID']);
				$Receiver_Pseudo = stripslashes($Players_List['Account_Pseudo']);
				echo "<option value=\"$Receiver_ID\">$Receiver_Pseudo</option>";
			}

			$Players_List_Query->closecursor();

			echo '</select><br /><br />';
			echo "<input type=\"submit\" name=\"End_Add\" value=\"$MWarning_5\">";
			echo '</form>';
		}
		if (isset($_POST['End_Add']))
		{
			if (isset($_POST['Avert_Type']) && ($_POST['Avert_Message']) && ($_POST['Receiver']))
			{
				$Avert_Type = htmlspecialchars(addslashes($_POST['Avert_Type']));	
				$Avert_Message = htmlspecialchars(addslashes($_POST['Avert_Message']));
				$Avert_Transmitter = htmlspecialchars(addslashes($_SESSION['Pseudo']));
				$Avert_Receiver = htmlspecialchars(addslashes($_POST['Receiver']));

				$Add_Avert = $bdd->prepare("INSERT INTO Caranille_Sanctions VALUES ('', :Avert_Type, :Avert_Message, :Avert_Transmitter, :Avert_Receiver)");
				$Add_Avert->execute(array('Avert_Type'=> $Avert_Type, 'Avert_Message'=> $Avert_Message, 'Avert_Transmitter'=> $Avert_Transmitter, 'Avert_Receiver'=> $Avert_Receiver));
				echo "$MWarning_6";
			}
			else
			{
				echo "$MWarning_7";
			}
		}
	}
	else
	{
		echo "<center>";
		echo "$MWarning_8";
		echo "</center>";
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
