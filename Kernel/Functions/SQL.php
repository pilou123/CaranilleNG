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

function SQL_AccountèData($Account_Pseudo, $Account_Password)
{
	$Login_Query = $bdd->prepare("SELECT * FROM Caranille_Accounts WHERE Account_Pseudo= ? AND Account_Password= ?");
	$Login_Query->execute(array($Pseudo, $Password));
	$Login = $Login_Query->rowCount();
	if ($Login >= 1)
	{
		$Data_Account_Query = $bdd->prepare("SELECT * FROM Caranille_Accounts, Caranille_Levels
		WHERE Account_Pseudo= ?
		AND Account_Level = Level_Number");
		$Data_Account_Query->execute(array($Pseudo));
		while ($Account_Data = $Data_Account_Query->fetch())
		{
			$_SESSION['ID'] = stripslashes($Account_Data['Account_ID']);
			$_SESSION['Pseudo'] = stripslashes($Account_Data['Account_Pseudo']);
			$_SESSION['Email'] = stripslashes($Account_Data['Account_Email']);
			$_SESSION['Level'] = stripslashes($Account_Data['Account_Level']);
			$_SESSION['Strength'] = stripslashes($Account_Data['Level_Strength']);
			$_SESSION['Magic'] = stripslashes($Account_Data['Level_Magic']);
			$_SESSION['Agility'] = stripslashes($Account_Data['Level_Agility']);
			$_SESSION['Defense'] = stripslashes($Account_Data['Level_Defense']);
			$_SESSION['HP'] = stripslashes($Account_Data['Account_HP_Remaining']);
			$_SESSION['HP_MAX'] = stripslashes($Account_Data['Level_HP']);
			$_SESSION['HP_Bonus'] = stripslashes($Account_Data['Account_HP_Bonus']);
			$_SESSION['MP'] = stripslashes($Account_Data['Account_MP_Remaining']);
			$_SESSION['MP_MAX'] = stripslashes($Account_Data['Level_MP']);
			$_SESSION['MP_Bonus'] = stripslashes($Account_Data['Account_MP_Bonus']);
			$_SESSION['Strength_Bonus'] = stripslashes($Account_Data['Account_Strength_Bonus']);
			$_SESSION['Magic_Bonus'] = stripslashes($Account_Data['Account_Magic_Bonus']);
			$_SESSION['Agility_Bonus'] = stripslashes($Account_Data['Account_Agility_Bonus']);
			$_SESSION['Defense_Bonus'] = stripslashes($Account_Data['Account_Defense_Bonus']);
			$_SESSION['Sagesse_Bonus'] = stripslashes($Account_Data['Account_Sagesse_Bonus']);
			$_SESSION['Experience'] = stripslashes($Account_Data['Account_Experience']);
			$_SESSION['Gold'] = stripslashes($Account_Data['Account_Golds']);
			$_SESSION['Chapter'] = stripslashes($Account_Data['Account_Chapter']);
			$_SESSION['Mission'] = stripslashes($Account_Data['Account_Mission']);	
			$_SESSION['Access'] = stripslashes($Account_Data['Account_Access']);
			$_SESSION['Last_Connection'] = stripslashes($Account_Data['Account_Last_Connection']);
			$_SESSION['Last_IP'] = stripslashes($Account_Data['Account_Last_IP']);
			$_SESSION['Status'] = stripslashes($Account_Data['Account_Status']);
			$_SESSION['Reason'] = stripslashes($Account_Data['Account_Reason']);
		}
		$Data_Account_Query->closeCursor();
		if ($_SESSION['Status'] == "Authorized")
		{
		    	$Data_Item_Query = $bdd->prepare("SELECT * FROM Caranille_Accounts, Caranille_Inventory, Caranille_Items 
		    	WHERE Inventory_Account_ID = Account_ID
		    	AND Inventory_Item_ID = Item_ID 
		    	AND Inventory_Item_Equipped='Yes'
		    	AND Account_Pseudo= ?"); 
		    	$Data_Item_Query->execute(array($Pseudo));
		    	$Item_Quantity = $Data_Item_Query->rowCount();
		    	while ($Account_Data = $Data_Item_Query->fetch())
		    	{
		    		if ($Account_Data['Item_Type'] == "Armor")
		    		{
		    			$_SESSION['Armor_Inventory_ID'] = stripslashes($Account_Data['Inventory_ID']);
		    			$_SESSION['Armor_ID'] = stripslashes($Account_Data['Inventory_Item_ID']);
		    			$_SESSION['Armor'] = stripslashes($Account_Data['Item_Name']);
		    			$_SESSION['Armor_HP_Effect'] = stripslashes($Account_Data['Item_HP_Effect']);
		    			$_SESSION['Armor_MP_Effect'] = stripslashes($Account_Data['Item_MP_Effect']);
		    			$_SESSION['Armor_Strength_Effect'] = stripslashes($Account_Data['Item_Strength_Effect']);
		    			$_SESSION['Armor_Magic_Effect'] = stripslashes($Account_Data['Item_Magic_Effect']);
		    			$_SESSION['Armor_Agility_Effect'] = stripslashes($Account_Data['Item_Agility_Effect']);
		    			$_SESSION['Armor_Defense_Effect'] = stripslashes($Account_Data['Item_Defense_Effect']);
		    		}
		    		if ($Account_Data['Item_Type'] == "Boots")
		    		{
		    			$_SESSION['Boots_Inventory_ID'] = stripslashes($Account_Data['Inventory_ID']);
		    			$_SESSION['Boots_ID'] = stripslashes($Account_Data['Inventory_Item_ID']);
		    			$_SESSION['Boots'] = stripslashes($Account_Data['Item_Name']);
		    			$_SESSION['Boots_HP_Effect'] = stripslashes($Account_Data['Item_HP_Effect']);
		    			$_SESSION['Boots_MP_Effect'] = stripslashes($Account_Data['Item_MP_Effect']);
		    			$_SESSION['Boots_Strength_Effect'] = stripslashes($Account_Data['Item_Strength_Effect']);
		    			$_SESSION['Boots_Magic_Effect'] = stripslashes($Account_Data['Item_Magic_Effect']);
		    			$_SESSION['Boots_Agility_Effect'] = stripslashes($Account_Data['Item_Agility_Effect']);
		    			$_SESSION['Boots_Defense_Effect'] = stripslashes($Account_Data['Item_Defense_Effect']);
		    		}
		    		if ($Account_Data['Item_Type'] == "Gloves")
		    		{
		    			$_SESSION['Gloves_Inventory_ID'] = stripslashes($Account_Data['Inventory_ID']);
		    			$_SESSION['Gloves_ID'] = stripslashes($Account_Data['Inventory_Item_ID']);
		    			$_SESSION['Gloves'] = stripslashes($Account_Data['Item_Name']);
		    			$_SESSION['Gloves_HP_Effect'] = stripslashes($Account_Data['Item_HP_Effect']);
		    			$_SESSION['Gloves_MP_Effect'] = stripslashes($Account_Data['Item_MP_Effect']);
		    			$_SESSION['Gloves_Strength_Effect'] = stripslashes($Account_Data['Item_Strength_Effect']);
		    			$_SESSION['Gloves_Magic_Effect'] = stripslashes($Account_Data['Item_Magic_Effect']);
		    			$_SESSION['Gloves_Agility_Effect'] = stripslashes($Account_Data['Item_Agility_Effect']);
		    			$_SESSION['Gloves_Defense_Effect'] = stripslashes($Account_Data['Item_Defense_Effect']);
		    		}
		    		if ($Account_Data['Item_Type'] == "Helmet")
		    		{
		    			$_SESSION['Helmet_Inventory_ID'] = stripslashes($Account_Data['Inventory_ID']);
		    			$_SESSION['Helmet_ID'] = stripslashes($Account_Data['Inventory_Item_ID']);
		    			$_SESSION['Helmet'] = stripslashes($Account_Data['Item_Name']);
		    			$_SESSION['Helmet_HP_Effect'] = stripslashes($Account_Data['Item_HP_Effect']);
		    			$_SESSION['Helmet_MP_Effect'] = stripslashes($Account_Data['Item_MP_Effect']);
		    			$_SESSION['Helmet_Strength_Effect'] = stripslashes($Account_Data['Item_Strength_Effect']);
		    			$_SESSION['Helmet_Magic_Effect'] = stripslashes($Account_Data['Item_Magic_Effect']);
		    			$_SESSION['Helmet_Agility_Effect'] = stripslashes($Account_Data['Item_Agility_Effect']);
		    			$_SESSION['Helmet_Defense_Effect'] = stripslashes($Account_Data['Item_Defense_Effect']);
		    		}
		    		if ($Account_Data['Item_Type'] == "Weapon")
		    		{
		    			$_SESSION['Weapon_Inventory_ID'] = stripslashes($Account_Data['Inventory_ID']);
		    			$_SESSION['Weapon_ID'] = stripslashes($Account_Data['Inventory_Item_ID']);
		    			$_SESSION['Weapon'] = stripslashes($Account_Data['Item_Name']);
		    			$_SESSION['Weapon_HP_Effect'] = stripslashes($Account_Data['Item_HP_Effect']);
		    			$_SESSION['Weapon_MP_Effect'] = stripslashes($Account_Data['Item_MP_Effect']);
		    			$_SESSION['Weapon_Strength_Effect'] = stripslashes($Account_Data['Item_Strength_Effect']);
		    			$_SESSION['Weapon_Magic_Effect'] = stripslashes($Account_Data['Item_Magic_Effect']);
		    			$_SESSION['Weapon_Agility_Effect'] = stripslashes($Account_Data['Item_Agility_Effect']);
		    			$_SESSION['Weapon_Defense_Effect'] = stripslashes($Account_Data['Item_Defense_Effect']);
		    		}
		    	}
		
		    	$Data_Item_Query->closeCursor();
		
		    	if (empty($_SESSION['Armor_Inventory_ID']))
		    	{
		    		$_SESSION['Armor_Inventory_ID'] = 0;
		    		$_SESSION['Armor_ID'] = 0;
		    		$_SESSION['Armor'] = "Aucune";
		    		$_SESSION['Armor_HP_Effect'] = 0;
		    		$_SESSION['Armor_MP_Effect'] = 0;
		    		$_SESSION['Armor_Strength_Effect'] = 0;
		    		$_SESSION['Armor_Magic_Effect'] = 0;
		    		$_SESSION['Armor_Agility_Effect'] = 0;
		    		$_SESSION['Armor_Defense_Effect'] = 0;
		    	}
		    	if (empty($_SESSION['Boots_Inventory_ID']))
		    	{
		    		$_SESSION['Boots_Inventory_ID'] = 0;
		    		$_SESSION['Boots_ID'] = 0;
		    		$_SESSION['Boots'] = "Aucune";
		    		$_SESSION['Boots_HP_Effect'] = 0;
		    		$_SESSION['Boots_MP_Effect'] = 0;
		    		$_SESSION['Boots_Strength_Effect'] = 0;
		    		$_SESSION['Boots_Magic_Effect'] = 0;
		    		$_SESSION['Boots_Agility_Effect'] = 0;
		    		$_SESSION['Boots_Defense_Effect'] = 0;
		    	}
		    	if (empty($_SESSION['Gloves_Inventory_ID']))
		    	{
		    		$_SESSION['Gloves_Inventory_ID'] = 0;
		    		$_SESSION['Gloves_ID'] = 0;
		    		$_SESSION['Gloves'] = "Aucun";
		    		$_SESSION['Gloves_HP_Effect'] = 0;
		    		$_SESSION['Gloves_MP_Effect'] = 0;
		    		$_SESSION['Gloves_Strength_Effect'] = 0;
		    		$_SESSION['Gloves_Magic_Effect'] = 0;
		    		$_SESSION['Gloves_Agility_Effect'] = 0;
		    		$_SESSION['Gloves_Defense_Effect'] = 0;
		    	}
		    	if (empty($_SESSION['Helmet_Inventory_ID']))
		    	{
		    		$_SESSION['Helmet_Inventory_ID'] = 0;
		    		$_SESSION['Helmet_ID'] = 0;
		    		$_SESSION['Helmet'] = "Aucun";
		    		$_SESSION['Helmet_HP_Effect'] = 0;
		    		$_SESSION['Helmet_MP_Effect'] = 0;
		    		$_SESSION['Helmet_Strength_Effect'] = 0;
		    		$_SESSION['Helmet_Magic_Effect'] = 0;
		    		$_SESSION['Helmet_Agility_Effect'] = 0;
		    		$_SESSION['Helmet_Defense_Effect'] = 0;
		    	}
		    	if (empty($_SESSION['Weapon_Inventory_ID']))
		    	{
		    		$_SESSION['Weapon_Inventory_ID'] = 0;
		    		$_SESSION['Weapon_ID'] = 0;
		    		$_SESSION['Weapon'] = "Aucune";
		    		$_SESSION['Weapon_HP_Effect'] = 0;
		    		$_SESSION['Weapon_MP_Effect'] = 0;
		    		$_SESSION['Weapon_Strength_Effect'] = 0;
		    		$_SESSION['Weapon_Magic_Effect'] = 0;
		    		$_SESSION['Weapon_Agility_Effect'] = 0;
		    		$_SESSION['Weapon_Defense_Effect'] = 0;
		    	}
		    	$recuperation_donnees_jeu = $bdd->query("SELECT * FROM Caranille_Configuration");
		    	while ($donnees_jeu = $recuperation_donnees_jeu->fetch())
		    	{
		    		$_SESSION['Configuration_Access'] = stripslashes($donnees_jeu['Configuration_Access']);
		    	}
		
		    	$recuperation_donnees_jeu->closeCursor();
		
		    	$_SESSION['Battle'] = 0;
		    	$_SESSION['Mission'] = 0;
		    	$_SESSION['Town'] = 0;
		    	
		    	if ($_SESSION['Configuration_Access'] == "Yes")
		    	{
		    		$ID = $_SESSION['ID'];
		    		$Date = date('Y-m-d H:i:s');
		    		$IP = $_SERVER["REMOTE_ADDR"];
		    		$Last_Connection = $_SESSION['Last_Connection'];
		    		$Last_IP = $_SESSION['Last_IP'];
		    		if ($Last_IP != $_SERVER["REMOTE_ADDR"])
		    		{
		    			echo "<script type=\"text/javascript\"> alert(\"$Login_4 $Last_Connection\\n- Adresse IP: $Last_IP\"); </script>";
		    		}
		    		$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Last_Connection = :Date, Account_Last_IP = :IP WHERE Account_ID = :ID");
		    		$Update_Account->execute(array('Date' => $Date, 'IP' => $IP, 'ID' => $ID));
		    		echo "$Login_5<br /><br />";
		    		echo "<a href=\"Main.php\">$Login_6</a>";
		    	}
		    	else
		    	{
		    		if ($_SESSION['Access'] == "Admin")
		    		{
		    			$ID = $_SESSION['ID'];
		    			$Date = date('Y-m-d H:i:s');
		    			$IP = $_SERVER["REMOTE_ADDR"];
		    			$Last_Connection = $_SESSION['Last_Connection'];
		    			$Last_IP = $_SESSION['Last_IP'];
		    			if ($Last_IP != $_SERVER["REMOTE_ADDR"])
		    			{
		    				echo "<script type=\"text/javascript\"> alert(\"$Login_4 $Last_Connection\\n- Adresse IP: $Last_IP\"); </script>";
		    			}
		    			$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Last_Connection = :Date, Account_Last_IP = :IP WHERE Account_ID = :ID");
		    			$Update_Account->execute(array('Date' => $Date, 'IP' => $IP, 'ID' => $ID));
		    			echo "$Login_5<br /><br />";
		    			echo "<a href=\"Main.php\">$Login_6</a>";
		    		}
		    		else
		    		{	
		    			echo "$Login_7";
		    			$ID = $_SESSION['ID'];
		    			$Date = date('Y-m-d H:i:s');
		    			$IP = $_SERVER["REMOTE_ADDR"];
		    			$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Last_Connection = :Date, Account_Last_IP = :IP WHERE Account_ID = :ID");
		    			$Update_Account->execute(array('Date' => $Date, 'IP' => $IP, 'ID' => $ID));
		    			session_destroy();
		    		}
		    	}
		}
		else
		{
		    $Reason = $_SESSION['Reason'];
		    echo "<script type=\"text/javascript\"> alert(\"$Login_8 $Reason\"); </script>";
		}
	}
	else
	{
		echo "$Login_9";
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
