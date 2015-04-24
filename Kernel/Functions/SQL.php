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

//LIST OF THE SQL FUNCTION
function SQL_Account_Connection($Account_Pseudo, $Account_Password)
{
    global $bdd;
    global $Login_6;
    global $Login_7;
    
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
			$Account['Account_Data']['ID'] = stripslashes($Account_Data['Account_ID']);
			$Account['Account_Data']['Pseudo'] = stripslashes($Account_Data['Account_Pseudo']);
			$Account['Account_Data']['Email'] = stripslashes($Account_Data['Account_Email']);
			$Account['Account_Data']['Level'] = stripslashes($Account_Data['Account_Level']);
			$Account['Account_Data']['Strength'] = stripslashes($Account_Data['Level_Strength']);
			$Account['Account_Data']['Magic'] = stripslashes($Account_Data['Level_Magic']);
			$Account['Account_Data']['Agility'] = stripslashes($Account_Data['Level_Agility']);
			$Account['Account_Data']['Defense'] = stripslashes($Account_Data['Level_Defense']);
			$Account['Account_Data']['HP'] = stripslashes($Account_Data['Account_HP_Remaining']);
			$Account['Account_Data']['HP_MAX'] = stripslashes($Account_Data['Level_HP']);
			$Account['Account_Data']['HP_Bonus'] = stripslashes($Account_Data['Account_HP_Bonus']);
			$Account['Account_Data']['MP'] = stripslashes($Account_Data['Account_MP_Remaining']);
			$Account['Account_Data']['MP_MAX'] = stripslashes($Account_Data['Level_MP']);
			$Account['Account_Data']['MP_Bonus'] = stripslashes($Account_Data['Account_MP_Bonus']);
			$Account['Account_Data']['Strength_Bonus'] = stripslashes($Account_Data['Account_Strength_Bonus']);
			$Account['Account_Data']['Magic_Bonus'] = stripslashes($Account_Data['Account_Magic_Bonus']);
			$Account['Account_Data']['Agility_Bonus'] = stripslashes($Account_Data['Account_Agility_Bonus']);
			$Account['Account_Data']['Defense_Bonus'] = stripslashes($Account_Data['Account_Defense_Bonus']);
			$Account['Account_Data']['Sagesse_Bonus'] = stripslashes($Account_Data['Account_Sagesse_Bonus']);
			$Account['Account_Data']['Experience'] = stripslashes($Account_Data['Account_Experience']);
			$Account['Account_Data']['Gold'] = stripslashes($Account_Data['Account_Golds']);
			$Account['Account_Data']['Chapter'] = stripslashes($Account_Data['Account_Chapter']);
			$Account['Account_Data']['Mission'] = stripslashes($Account_Data['Account_Mission']);	
			$Account['Account_Data']['Access'] = stripslashes($Account_Data['Account_Access']);
			$Account['Account_Data']['Last_Connection'] = stripslashes($Account_Data['Account_Last_Connection']);
			$Account['Account_Data']['Last_IP'] = stripslashes($Account_Data['Account_Last_IP']);
			$Account['Account_Data']['Status'] = stripslashes($Account_Data['Account_Status']);
			$Account['Account_Data']['Reason'] = stripslashes($Account_Data['Account_Reason']);
			
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
			return $Account['Account_Data'];
		}
	}
	else
	{
	    echo $Login_6;
	}
}

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

function SQL_Create_Table($Dsn, $User, $Password)
{
	try
	{
		$bdd = new PDO($Dsn, $User, $Password);
		$bdd->exec("CREATE TABLE `Caranille_Accounts` (
					`Account_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Account_Guild_ID` int(11) NOT NULL,
					`Account_Pseudo` VARCHAR(30) NOT NULL,
					`Account_Password` TEXT NOT NULL,
					`Account_Email` VARCHAR(30) NOT NULL,
					`Account_Level` int(11) NOT NULL,
					`Account_HP_Remaining` int(11) NOT NULL,
					`Account_HP_Bonus` int(11) NOT NULL,
					`Account_MP_Remaining` int(11) NOT NULL,
					`Account_MP_Bonus` int(11) NOT NULL,
					`Account_Strength_Bonus` int(11) NOT NULL,
					`Account_Magic_Bonus` int(11) NOT NULL,
					`Account_Agility_Bonus` int(11) NOT NULL,
					`Account_Defense_Bonus` int(11) NOT NULL,
					`Account_Sagesse_Bonus` int(11) NOT NULL,
					`Account_Experience` bigint(255) NOT NULL,
					`Account_Golds` int(11) NOT NULL,
					`Account_Chapter` int(11) NOT NULL,
					`Account_Mission` int(11) NOT NULL,
					`Account_Access` VARCHAR(10) NOT NULL,
					`Account_Last_Connection` DATETIME NOT NULL,
					`Account_Last_IP` TEXT NOT NULL,
					`Account_Status` TEXT NOT NULL,
					`Account_Reason` TEXT NOT NULL
					)");
					
			$bdd->exec("CREATE TABLE `Caranille_Levels` (
					`Level_ID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Level_Number` int(11) NOT NULL,
					`Level_Experience_Required` bigint(255) NOT NULL,
					`Level_HP` bigint(255) NOT NULL,
					`Level_MP` bigint(255) NOT NULL,
					`Level_Strength` bigint(255) NOT NULL,
					`Level_Magic` bigint(255) NOT NULL,
					`Level_Agility` bigint(255) NOT NULL,
					`Level_Defense` bigint(255) NOT NULL
					);");
					
		
		$bdd->exec("CREATE TABLE `Caranille_News` (
					`News_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`News_Title` VARCHAR(30) NOT NULL,
					`News_Message` TEXT NOT NULL,
					`News_Account_Pseudo` VARCHAR(15) NOT NULL,
					`News_Date` DATETIME NOT NULL
					)");
		
		$Date = date('Y-m-d H:i:s');
		$bdd->exec("INSERT INTO Caranille_News VALUES(
				'',
				'Installation of CaranilleNG',
				'Congratulation CaranilleNG has installed',
				'Admin',
				'$Date')");
				
				$HP_Choice = 20;
				$MP_Choice = 2;
				$MP_Choice = 2;
				$Magic_Choice = 2;
				$Agility_Choice = 2;
				$Defense_Choice = 2;
				$Experience_Choice = 2000;
				while ($Level < 200)
				{
					$HP = $HP + $HP_Choice;
					$MP = $MP + $MP_Choice;
					$Strength = $Strength + $MP_Choice;
					$Magic = $Magic + $Magic_Choice;
					$Agility = $Agility + $Agility_Choice;
					$Defense = $Defense + $Defense_Choice;
					$Experience = $Experience + $Experience_Choice;

					$Level = $Level +1;
					$bdd->exec("INSERT INTO Caranille_Levels VALUES(
					'', 
					'$Level', 
					'$Experience', 
					'$HP', 
					'$MP', 
					'$Strength', 
					'$Magic', 
					'$Agility', 
					'$Defense')");
				}

	}
	catch (PDOException $e)
	{
		echo 'An error has occurred: The creation of the tables has failed. Error: ' . $e->getMessage();
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
