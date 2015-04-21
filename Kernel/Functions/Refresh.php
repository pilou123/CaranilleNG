<?php
if (isset($_SESSION['ID']))
{
	/*
	Variables Globales
	*/
	$ID = $_SESSION['ID'];
	$Date = date('Y-m-d H:i:s');
	$IP = $_SERVER["REMOTE_ADDR"];
	$Pseudo = $_SESSION['Pseudo'];

	$_SESSION['HP_Total'] = $_SESSION['HP_MAX'] + $_SESSION['HP_Bonus'] + $_SESSION['Armor_HP_Effect'] + $_SESSION['Boots_HP_Effect'] + $_SESSION['Gloves_HP_Effect'] + $_SESSION['Helmet_HP_Effect'] + $_SESSION['Weapon_HP_Effect'];
	$_SESSION['MP_Total'] = $_SESSION['MP_MAX'] + $_SESSION['MP_Bonus'] + $_SESSION['Armor_MP_Effect'] + $_SESSION['Boots_MP_Effect'] + $_SESSION['Gloves_MP_Effect'] + $_SESSION['Helmet_MP_Effect'] + $_SESSION['Weapon_MP_Effect'];;
	
	$_SESSION['Strength_Base'] = $_SESSION['Strength'] + $_SESSION['Strength_Bonus'];
	$_SESSION['Strength_Total'] = $_SESSION['Strength_Base'] + $_SESSION['Armor_Strength_Effect'] + $_SESSION['Boots_Strength_Effect'] + $_SESSION['Gloves_Strength_Effect'] + $_SESSION['Helmet_Strength_Effect'] + $_SESSION['Weapon_Strength_Effect'];;
	
	$_SESSION['Magic_Base'] = $_SESSION['Magic'] + $_SESSION['Magic_Bonus'];
	$_SESSION['Magic_Total'] = $_SESSION['Magic_Base'] + $_SESSION['Armor_Magic_Effect'] + $_SESSION['Boots_Magic_Effect'] + $_SESSION['Gloves_Magic_Effect'] + $_SESSION['Helmet_Magic_Effect'] + $_SESSION['Weapon_Magic_Effect'];;
	
	$_SESSION['Agility_Base'] = $_SESSION['Agility'] + $_SESSION['Agility_Bonus'];
	$_SESSION['Agility_Total'] = $_SESSION['Agility_Base'] + $_SESSION['Armor_Agility_Effect'] + $_SESSION['Boots_Agility_Effect'] + $_SESSION['Gloves_Agility_Effect'] + $_SESSION['Helmet_Agility_Effect'] + $_SESSION['Weapon_Agility_Effect'];;
	
	$_SESSION['Defense_Base'] = $_SESSION['Defense'] + $_SESSION['Defense_Bonus'];
	$_SESSION['Defense_Total'] = $_SESSION['Defense_Base'] + $_SESSION['Armor_Defense_Effect'] + $_SESSION['Boots_Defense_Effect'] + $_SESSION['Gloves_Defense_Effect'] + $_SESSION['Helmet_Defense_Effect'] + $_SESSION['Weapon_Defense_Effect'];;

	/*
	Vérification des sanctions pour l'utilisateur
	*/
	$Warning_List_Query = $bdd->prepare("SELECT * FROM Caranille_Accounts, Caranille_Sanctions 
	WHERE Sanction_Receiver = ?");
	$Warning_List_Query->execute(array($ID));
	while ($Warning_List = $Warning_List_Query->fetch())
	{
		$ID_avertissement = $Warning_List['Sanction_ID'];
		$type_avertissement = $Warning_List['Sanction_Type'];
		$emetteur_avertissement = $Warning_List['Sanction_Transmitter'];
		$message_avertissement = $Warning_List['Sanction_Message'];
		echo "<script type=\"text/javascript\"> alert(\"Vous avez recu un(e) $type_avertissement de la part de $emetteur_avertissement\\n\\n$message_avertissement\"); </script>";

		$Delete_Warning = $bdd->prepare("DELETE FROM Caranille_Sanctions WHERE Sanction_ID=:ID_avertissement");
		$Delete_Warning->execute(array('ID_avertissement' => $ID_avertissement));
	}

	$Warning_List_Query->closeCursor();	

	/*
	Mise à jour du compte en temps réel
	*/
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
    	
    	$Data_Item_Query->closeCursor();
    
    	/*
    	Vérification pour savoir si le joueur monte de niveau
    	*/
    	$Level = $_SESSION['Level'] + 1;
    	$Level_Found = $bdd->prepare("SELECT * FROM Caranille_Levels WHERE Level_Number= ?");
    	$Level_Found->execute(array($Level));
    	while ($Level_Data = $Level_Found->fetch())
    	{
    		$_SESSION['Level_Experience_Required'] = $Level_Data['Level_Experience_Required'];
    	}
    
    	$Experience = $_SESSION['Experience'];
    	$Level_Experience_Required = $_SESSION['Level_Experience_Required'];
    
    	if ($Experience < 0)
    	{
    		$_SESSION['Experience'] == 0;
    		$Next_Level = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Experience = :Account_Experience WHERE Account_ID= :ID");
    		$Next_Level->execute(array('Account_Experience'=> $Account_Experience, 'ID'=> $ID));
    	}
    
    	while ($Experience >= $Level_Experience_Required)
    	{
    		$_SESSION['Level'] = $_SESSION['Level'] + 1;
    		$_SESSION['Experience'] = $_SESSION['Experience'] - $_SESSION['Level_Experience_Required'];
    		$Account_Level = $_SESSION['Level'];
    		$Account_Experience = $_SESSION['Experience'];
    		echo "<script type=\"text/javascript\"> alert(\"Votre personnage vient de gagner un niveau\\nIl est maintenant au niveau : $Account_Level\"); </script>";
    		$Next_Level_Query = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Level = :Account_Level, Account_Experience = :Account_Experience WHERE Account_ID= :ID");
    		$Next_Level_Query->execute(array('Account_Level'=> $Account_Level, 'Account_Experience'=> $Account_Experience, 'ID'=> $ID));
    
    		$Level = $_SESSION['Level'] +1;
    		$Experience = $_SESSION['Experience'];
    		$Level_Found = $bdd->prepare("SELECT * FROM Caranille_Levels WHERE Level_Number= ?");
    		$Level_Found->execute(array($level));
    		while($Level_Data = $Level_Found->fetch())
    		{
    			$_SESSION['Level_Experience_Required'] = $Level_Data['Level_Experience_Required'];
    		}
    		$Level_Experience_Required = $_SESSION['Level_Experience_Required'];
    	}
    	$Next_Level = $Level_Experience_Required - $_SESSION['Experience'];
    	
    	/*
    	Vérification du nombre de message privé de l'utilisateur
    	*/
    	$Private_Message_List_Query = $bdd->prepare("SELECT * FROM Caranille_Private_Messages, Caranille_Accounts 
    	WHERE Private_Message_Receiver = ?
    	AND Account_ID = ?");
    	$Private_Message_List_Query->execute(array($Pseudo, $ID));
    
    	$Total_Private_Message = $Private_Message_List_Query->rowCount();
    	$_SESSION['Private_Message_Number'] = $Total_Private_Message;
    	$Private_Message_List_Query->closeCursor();
	}
    else
    {
 		$Reason = $_SESSION['Reason'];
	    echo "<script type=\"text/javascript\"> alert(\"IMPOSSIBLE DE SE CONNECTER\\nVotre compte est banni pour la raison suivante :\\n : $Reason\"); </script>";
        session_destroy();
    }
}
?>
