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

function SQL_Account_Data($Account_Pseudo, $Account_Password)
{
	global $bdd;
	global $Login_4;
	global $Login_5;
	global $Login_6;
	global $Login_7;
	global $Login_8;
	global $Login_9;

	$Login_Query = $bdd->prepare("SELECT * FROM Caranille_Accounts WHERE Account_Pseudo= ? AND Account_Password= ?");
	$Login_Query->execute(array($Account_Pseudo, $Account_Password));
	$Login = $Login_Query->rowCount();
	if ($Login >= 1)
	{
		$Data_Account_Query = $bdd->prepare("SELECT * FROM Caranille_Accounts, Caranille_Levels
		WHERE Account_Pseudo= ?
		AND Account_Level = Level_Number");
		$Data_Account_Query->execute(array($Account_Pseudo));
		while ($Account_Data = $Data_Account_Query->fetch())
		{
			$Account['Account_data']['ID'] = stripslashes($Account_Data['Account_ID']);
			$Account['Account_data']['Pseudo'] = stripslashes($Account_Data['Account_Pseudo']);
			$Account['Account_data']['Email'] = stripslashes($Account_Data['Account_Email']);
			$Account['Account_data']['Level'] = stripslashes($Account_Data['Account_Level']);
			$Account['Account_data']['Strength'] = stripslashes($Account_Data['Level_Strength']);
			$Account['Account_data']['Magic'] = stripslashes($Account_Data['Level_Magic']);
			$Account['Account_data']['Agility'] = stripslashes($Account_Data['Level_Agility']);
			$Account['Account_data']['Defense'] = stripslashes($Account_Data['Level_Defense']);
			$Account['Account_data']['HP'] = stripslashes($Account_Data['Account_HP_Remaining']);
			$Account['Account_data']['HP_MAX'] = stripslashes($Account_Data['Level_HP']);
			$Account['Account_data']['HP_Bonus'] = stripslashes($Account_Data['Account_HP_Bonus']);
			$Account['Account_data']['MP'] = stripslashes($Account_Data['Account_MP_Remaining']);
			$Account['Account_data']['MP_MAX'] = stripslashes($Account_Data['Level_MP']);
			$Account['Account_data']['MP_Bonus'] = stripslashes($Account_Data['Account_MP_Bonus']);
			$Account['Account_data']['Strength_Bonus'] = stripslashes($Account_Data['Account_Strength_Bonus']);
			$Account['Account_data']['Magic_Bonus'] = stripslashes($Account_Data['Account_Magic_Bonus']);
			$Account['Account_data']['Agility_Bonus'] = stripslashes($Account_Data['Account_Agility_Bonus']);
			$Account['Account_data']['Defense_Bonus'] = stripslashes($Account_Data['Account_Defense_Bonus']);
			$Account['Account_data']['Sagesse_Bonus'] = stripslashes($Account_Data['Account_Sagesse_Bonus']);
			$Account['Account_data']['Experience'] = stripslashes($Account_Data['Account_Experience']);
			$Account['Account_data']['Gold'] = stripslashes($Account_Data['Account_Golds']);
			$Account['Account_data']['Chapter'] = stripslashes($Account_Data['Account_Chapter']);
			$Account['Account_data']['Mission'] = stripslashes($Account_Data['Account_Mission']);	
			$Account['Account_data']['Access'] = stripslashes($Account_Data['Account_Access']);
			$Account['Account_data']['Last_Connection'] = stripslashes($Account_Data['Account_Last_Connection']);
			$Account['Account_data']['Last_IP'] = stripslashes($Account_Data['Account_Last_IP']);
			$Account['Account_data']['Status'] = stripslashes($Account_Data['Account_Status']);
			$Account['Account_data']['Reason'] = stripslashes($Account_Data['Account_Reason']);
		}
		$Data_Account_Query->closeCursor();
		if ($Account['Account_data']['Status'] == "Authorized")
		{
		    	$Data_Item_Query = $bdd->prepare("SELECT * FROM Caranille_Accounts, Caranille_Inventory, Caranille_Items 
		    	WHERE Inventory_Account_ID = Account_ID
		    	AND Inventory_Item_ID = Item_ID 
		    	AND Inventory_Item_Equipped='Yes'
		    	AND Account_Pseudo= ?"); 
		    	$Data_Item_Query->execute(array($Account_Pseudo));
		    	$Item_Quantity = $Data_Item_Query->rowCount();
		    	while ($Account_Data = $Data_Item_Query->fetch())
		    	{
		    		if ($Account_Data['Item_Type'] == "Armor")
		    		{
		    			$Account['Account_data']['Armor_Inventory_ID'] = stripslashes($Account_Data['Inventory_ID']);
		    			$Account['Account_data']['Armor_ID'] = stripslashes($Account_Data['Inventory_Item_ID']);
		    			$Account['Account_data']['Armor'] = stripslashes($Account_Data['Item_Name']);
		    			$Account['Account_data']['Armor_HP_Effect'] = stripslashes($Account_Data['Item_HP_Effect']);
		    			$Account['Account_data']['Armor_MP_Effect'] = stripslashes($Account_Data['Item_MP_Effect']);
		    			$Account['Account_data']['Armor_Strength_Effect'] = stripslashes($Account_Data['Item_Strength_Effect']);
		    			$Account['Account_data']['Armor_Magic_Effect'] = stripslashes($Account_Data['Item_Magic_Effect']);
		    			$Account['Account_data']['Armor_Agility_Effect'] = stripslashes($Account_Data['Item_Agility_Effect']);
		    			$Account['Account_data']['Armor_Defense_Effect'] = stripslashes($Account_Data['Item_Defense_Effect']);
		    		}
		    		if ($Account_Data['Item_Type'] == "Boots")
		    		{
		    			$Account['Account_data']['Boots_Inventory_ID'] = stripslashes($Account_Data['Inventory_ID']);
		    			$Account['Account_data']['Boots_ID'] = stripslashes($Account_Data['Inventory_Item_ID']);
		    			$Account['Account_data']['Boots'] = stripslashes($Account_Data['Item_Name']);
		    			$Account['Account_data']['Boots_HP_Effect'] = stripslashes($Account_Data['Item_HP_Effect']);
		    			$Account['Account_data']['Boots_MP_Effect'] = stripslashes($Account_Data['Item_MP_Effect']);
		    			$Account['Account_data']['Boots_Strength_Effect'] = stripslashes($Account_Data['Item_Strength_Effect']);
		    			$Account['Account_data']['Boots_Magic_Effect'] = stripslashes($Account_Data['Item_Magic_Effect']);
		    			$Account['Account_data']['Boots_Agility_Effect'] = stripslashes($Account_Data['Item_Agility_Effect']);
		    			$Account['Account_data']['Boots_Defense_Effect'] = stripslashes($Account_Data['Item_Defense_Effect']);
		    		}
		    		if ($Account_Data['Item_Type'] == "Gloves")
		    		{
		    			$Account['Account_data']['Gloves_Inventory_ID'] = stripslashes($Account_Data['Inventory_ID']);
		    			$Account['Account_data']['Gloves_ID'] = stripslashes($Account_Data['Inventory_Item_ID']);
		    			$Account['Account_data']['Gloves'] = stripslashes($Account_Data['Item_Name']);
		    			$Account['Account_data']['Gloves_HP_Effect'] = stripslashes($Account_Data['Item_HP_Effect']);
		    			$Account['Account_data']['Gloves_MP_Effect'] = stripslashes($Account_Data['Item_MP_Effect']);
		    			$Account['Account_data']['Gloves_Strength_Effect'] = stripslashes($Account_Data['Item_Strength_Effect']);
		    			$Account['Account_data']['Gloves_Magic_Effect'] = stripslashes($Account_Data['Item_Magic_Effect']);
		    			$Account['Account_data']['Gloves_Agility_Effect'] = stripslashes($Account_Data['Item_Agility_Effect']);
		    			$Account['Account_data']['Gloves_Defense_Effect'] = stripslashes($Account_Data['Item_Defense_Effect']);
		    		}
		    		if ($Account_Data['Item_Type'] == "Helmet")
		    		{
		    			$Account['Account_data']['Helmet_Inventory_ID'] = stripslashes($Account_Data['Inventory_ID']);
		    			$Account['Account_data']['Helmet_ID'] = stripslashes($Account_Data['Inventory_Item_ID']);
		    			$Account['Account_data']['Helmet'] = stripslashes($Account_Data['Item_Name']);
		    			$Account['Account_data']['Helmet_HP_Effect'] = stripslashes($Account_Data['Item_HP_Effect']);
		    			$Account['Account_data']['Helmet_MP_Effect'] = stripslashes($Account_Data['Item_MP_Effect']);
		    			$Account['Account_data']['Helmet_Strength_Effect'] = stripslashes($Account_Data['Item_Strength_Effect']);
		    			$Account['Account_data']['Helmet_Magic_Effect'] = stripslashes($Account_Data['Item_Magic_Effect']);
		    			$Account['Account_data']['Helmet_Agility_Effect'] = stripslashes($Account_Data['Item_Agility_Effect']);
		    			$Account['Account_data']['Helmet_Defense_Effect'] = stripslashes($Account_Data['Item_Defense_Effect']);
		    		}
		    		if ($Account_Data['Item_Type'] == "Weapon")
		    		{
		    			$Account['Account_data']['Weapon_Inventory_ID'] = stripslashes($Account_Data['Inventory_ID']);
		    			$Account['Account_data']['Weapon_ID'] = stripslashes($Account_Data['Inventory_Item_ID']);
		    			$Account['Account_data']['Weapon'] = stripslashes($Account_Data['Item_Name']);
		    			$Account['Account_data']['Weapon_HP_Effect'] = stripslashes($Account_Data['Item_HP_Effect']);
		    			$Account['Account_data']['Weapon_MP_Effect'] = stripslashes($Account_Data['Item_MP_Effect']);
		    			$Account['Account_data']['Weapon_Strength_Effect'] = stripslashes($Account_Data['Item_Strength_Effect']);
		    			$Account['Account_data']['Weapon_Magic_Effect'] = stripslashes($Account_Data['Item_Magic_Effect']);
		    			$Account['Account_data']['Weapon_Agility_Effect'] = stripslashes($Account_Data['Item_Agility_Effect']);
		    			$Account['Account_data']['Weapon_Defense_Effect'] = stripslashes($Account_Data['Item_Defense_Effect']);
		    		}
		    	}
		
		    	$Data_Item_Query->closeCursor();
		
		    	if (empty($Account['Account_data']['Armor_Inventory_ID']))
		    	{
		    		$Account['Account_data']['Armor_Inventory_ID'] = 0;
		    		$Account['Account_data']['Armor_ID'] = 0;
		    		$Account['Account_data']['Armor'] = "Aucune";
		    		$Account['Account_data']['Armor_HP_Effect'] = 0;
		    		$Account['Account_data']['Armor_MP_Effect'] = 0;
		    		$Account['Account_data']['Armor_Strength_Effect'] = 0;
		    		$Account['Account_data']['Armor_Magic_Effect'] = 0;
		    		$Account['Account_data']['Armor_Agility_Effect'] = 0;
		    		$Account['Account_data']['Armor_Defense_Effect'] = 0;
		    	}
		    	if (empty($Account['Account_data']['Boots_Inventory_ID']))
		    	{
		    		$Account['Account_data']['Boots_Inventory_ID'] = 0;
		    		$Account['Account_data']['Boots_ID'] = 0;
		    		$Account['Account_data']['Boots'] = "Aucune";
		    		$Account['Account_data']['Boots_HP_Effect'] = 0;
		    		$Account['Account_data']['Boots_MP_Effect'] = 0;
		    		$Account['Account_data']['Boots_Strength_Effect'] = 0;
		    		$Account['Account_data']['Boots_Magic_Effect'] = 0;
		    		$Account['Account_data']['Boots_Agility_Effect'] = 0;
		    		$Account['Account_data']['Boots_Defense_Effect'] = 0;
		    	}
		    	if (empty($Account['Account_data']['Gloves_Inventory_ID']))
		    	{
		    		$Account['Account_data']['Gloves_Inventory_ID'] = 0;
		    		$Account['Account_data']['Gloves_ID'] = 0;
		    		$Account['Account_data']['Gloves'] = "Aucun";
		    		$Account['Account_data']['Gloves_HP_Effect'] = 0;
		    		$Account['Account_data']['Gloves_MP_Effect'] = 0;
		    		$Account['Account_data']['Gloves_Strength_Effect'] = 0;
		    		$Account['Account_data']['Gloves_Magic_Effect'] = 0;
		    		$Account['Account_data']['Gloves_Agility_Effect'] = 0;
		    		$Account['Account_data']['Gloves_Defense_Effect'] = 0;
		    	}
		    	if (empty($Account['Account_data']['Helmet_Inventory_ID']))
		    	{
		    		$Account['Account_data']['Helmet_Inventory_ID'] = 0;
		    		$Account['Account_data']['Helmet_ID'] = 0;
		    		$Account['Account_data']['Helmet'] = "Aucun";
		    		$Account['Account_data']['Helmet_HP_Effect'] = 0;
		    		$Account['Account_data']['Helmet_MP_Effect'] = 0;
		    		$Account['Account_data']['Helmet_Strength_Effect'] = 0;
		    		$Account['Account_data']['Helmet_Magic_Effect'] = 0;
		    		$Account['Account_data']['Helmet_Agility_Effect'] = 0;
		    		$Account['Account_data']['Helmet_Defense_Effect'] = 0;
		    	}
		    	if (empty($Account['Account_data']['Weapon_Inventory_ID']))
		    	{
		    		$Account['Account_data']['Weapon_Inventory_ID'] = 0;
		    		$Account['Account_data']['Weapon_ID'] = 0;
		    		$Account['Account_data']['Weapon'] = "Aucune";
		    		$Account['Account_data']['Weapon_HP_Effect'] = 0;
		    		$Account['Account_data']['Weapon_MP_Effect'] = 0;
		    		$Account['Account_data']['Weapon_Strength_Effect'] = 0;
		    		$Account['Account_data']['Weapon_Magic_Effect'] = 0;
		    		$Account['Account_data']['Weapon_Agility_Effect'] = 0;
		    		$Account['Account_data']['Weapon_Defense_Effect'] = 0;
		    	}

		    	$Game_Data_Query = $bdd->query("SELECT * FROM Caranille_Configuration");
		    	while ($Game_Data = $Game_Data_Query->fetch())
		    	{
		    		$Account['Account_data']['Configuration_Access'] = stripslashes($Game_Data['Configuration_Access']);
		    	}
		
		    	$Game_Data_Query->closeCursor();
		
		    	$Account['Account_data']['Battle'] = 0;
		    	$Account['Account_data']['Mission'] = 0;
		    	$Account['Account_data']['Town'] = 0;
		    	
		    	if ($Account['Account_data']['Configuration_Access'] == "Yes")
		    	{
		    		$ID = $Account['Account_data']['ID'];
		    		$Date = date('Y-m-d H:i:s');
		    		$IP = $_SERVER["REMOTE_ADDR"];
		    		$Last_Connection = $Account['Account_data']['Last_Connection'];
		    		$Last_IP = $Account['Account_data']['Last_IP'];
		    		if ($Last_IP != $_SERVER["REMOTE_ADDR"])
		    		{
		    			echo "<script type=\"text/javascript\"> alert(\"$Login_4 $Last_Connection\\n- Adresse IP: $Last_IP\"); </script>";
		    		}
		    		$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Last_Connection = :Date, Account_Last_IP = :IP WHERE Account_ID = :ID");
		    		$Update_Account->execute(array('Date' => $Date, 'IP' => $IP, 'ID' => $ID));
		    		echo "$Login_5<br /><br />";
		    		echo "<a href=\"Main.php\">$Login_6</a>";
				return $Account['Account_data'];
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
					return $Account['Account_data'];
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
		    $Reason = $Account['Account_data']['Reason'];
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
