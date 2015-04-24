<?php
//LAUNCH THE CONNECTION
    try 
    {
    	$bdd = new PDO($Dsn, $User, $Password);
    }
    catch (PDOException $e)
    {
    	echo 'An error as occured, Cannot connect to the database. Error: ' . $e->getMessage();
    }
// END OF LAUNCH THE CONNECTION

function SQL_Add_Account($Account_Pseudo, $Account_Password, $Account_Email)
{
	global $bdd;
	global $Register_8;
	global $Register_9;

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
		echo $Register_9;
	}
}

function SQL_News_List()
{
    global $bdd;
    global $Main_0;
    global $Main_1;
        
	$Resultat = $bdd->query("SELECT * FROM Caranille_News ORDER BY News_ID desc");
	while ($News = $Resultat->fetch())
	{
		echo '<table>';
			echo '<tr>';
				echo '<th>';
					echo "$Main_0 " .$News['News_Date']. " $Main_1 " .$News['News_Account_Pseudo']. "";
				echo '</th>';
			echo '</tr>';
							
			echo '<tr>';
				echo '<td>';
					echo '<h4>' .$News['News_Title']. '</h4>';
					echo '' .stripslashes(nl2br($News['News_Message'])). '';
				echo '</td>';
			echo '</tr>';
		echo '</table><br /><br />';
	}
	$Resultat->closeCursor();	
}
?>
