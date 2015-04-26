<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	if (empty($_POST['Register']))
	{	
		echo "$Register_0<br /><br />";
		echo "<div class=\"important\">$Register_1</div><br /><br />";
		echo '<form method="POST" action="Register.php">';
		echo "$Register_2<br /> <input type=\"text\" name=\"Account_Pseudo\"><br /><br />";
		echo "$Register_3<br /> <input type=\"password\" name=\"Account_Password\"><br /><br />";
		echo "$Register_4<br /> <input type=\"password\" name=\"Account_Password_Confirm\"><br /><br />";
		echo "$Register_5<br /> <input type=\"text\" name=\"Account_Email\"><br /><br />";
		echo '<iframe src="../LICENCE.txt"></iframe><br /><br />';
		echo "<input type=\"checkbox\" name=\"Licence\">$Register_6<br /><br />";
		echo "<input type=\"submit\" name=\"Register\" value=\"$Register_7\">";
		echo '</form>';
	}	
	if (isset($_POST['Register']))
	{
		if (isset($_POST['Account_Pseudo']) && ($_POST['Account_Password']) && ($_POST['Account_Password_Confirm']) && ($_POST['Account_Email']))
		{
			$Account_Pseudo = htmlspecialchars(addslashes($_POST['Account_Pseudo']));
			$Account_Password = htmlspecialchars(addslashes($_POST['Account_Password']));
			$Account_Password_Confirm = htmlspecialchars(addslashes($_POST['Account_Password_Confirm']));
			$Account_Email = htmlspecialchars(addslashes($_POST['Account_Email']));
			if ($Account_Password == $Account_Password_Confirm)
			{
				if (isset($_POST['Licence']))
				{
					$Account_Password = md5(htmlspecialchars(addslashes($_POST['Account_Password'])));
					$Pseudo_List_Query = $bdd->prepare("SELECT * FROM Caranille_Accounts WHERE Account_Pseudo= ?");
					$Pseudo_List_Query->execute(array($Account_Pseudo));
					
					$Pseudo_List = $Pseudo_List_Query->rowCount();
					if ($Pseudo_List == 0)
					{
					    $Email_List_Query = $bdd->prepare("SELECT * FROM Caranille_Accounts WHERE Account_Pseudo= ?");
					    $Email_List_Query->execute(array($Account_Pseudo));
					    
					    $Email_List = $Email_List_Query->rowCount();
					    if ($Email_List == 0)
					    {
						$Date = date('Y-m-d H:i:s');
						$IP = $_SERVER["REMOTE_ADDR"];
					
						$Add_Account = $bdd->prepare("INSERT INTO Caranille_Accounts VALUES(
						'', 
						'0', 
						:Pseudo, 
						:Password, 
						:Email, 
						'1', 
						'100', 
						'0', 
						'10', 
						'0', 
						'0', 
						'0', 
						'0', 
						'0', 
						'0', 
						'0', 
						'0', 
						'1', 
						'1', 
						'Member', 
						:Date, 
						:IP, 
						'Authorized', 
						'None')");
					
						$Add_Account->execute(array(
						'Pseudo' => $Account_Pseudo, 
						'Password' => $Account_Password, 
						'Email' => $Account_Email, 
						'Date' => $Date, 
						'IP' => $IP));
						
						$Account_Data_Query = $bdd->prepare("SELECT * FROM Caranille_Accounts 
						WHERE Account_Pseudo= ?");
						$Account_Data_Query->execute(array($Account_Pseudo));
			
						while ($Account_Data = $Account_Data_Query->fetch())
						{	
							$ID = $Account_Data['Account_ID'];
							$bdd->exec("INSERT INTO Caranille_Inventory VALUES('', '$ID', '1', '1', 'Yes')");
							$bdd->exec("INSERT INTO Caranille_Inventory VALUES('', '$ID', '2', '1', 'Yes')");
							$bdd->exec("INSERT INTO Caranille_Inventory VALUES('', '$ID', '3', '1', 'Yes')");
							$bdd->exec("INSERT INTO Caranille_Inventory VALUES('', '$ID', '4', '1', 'Yes')");
							$bdd->exec("INSERT INTO Caranille_Inventory VALUES('', '$ID', '5', '1', 'Yes')");
						}
						$Account_Data_Query->closeCursor();
						echo $Register_8;
					}
					else
					{
						echo $Register_9;
					}
				}
				else
				{
					echo "$Register_10";
				}
			}
			else
			{
				echo "$Register_11";
			}
		}
		else
		{
			echo "$Register_12";
		}
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
