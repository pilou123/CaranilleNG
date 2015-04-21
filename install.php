<?php
session_start();
require_once("Kernel/Config/Locales.php");
require_once("Kernel/Config/Server.php");
require_once("Kernel/Config/SQL.php");

if (isset($_SESSION['Language']))
{
	$Language = $_SESSION['Language'];
	require_once("Kernel/Locales/" .$Language. "/Words.php");
}
?>
<!DOCTYPE html>
<html>
		<head>
			<title><?php echo $Install_0; ?></title>
			<meta charset="utf-8" />
			<link rel="stylesheet" media="screen" type="text/css" title="design" href="Design/Design.css" />
		</head>

		<body>

			<p>
			<img src="Design/Images/logo.png">
			</p>
			
			<section>
				<?php
				if (empty($_POST['Install']) && empty($_POST['Accept']) && empty($_POST['Create_Configuration']) && empty($_POST['Choose_Curve']) && empty($_POST['Start_Installation']) && empty($_POST['Configure']) && empty($_POST['Finish']))
				{
					?>
					<form method="POST" action="install.php">
					<label for="Language">Choose your language<br /></label><br />
					<select name="Language" id="Language">
					<option value="En">Anglais</option>
					<option value="Fr">Français</option>
					</select><br /><br />
					<input type="submit" name="Install" value="Install">
					</form>
					<?php
				}
				if (isset($_POST['Install']))
				{
					$_SESSION['Language'] = htmlspecialchars(addslashes($_POST['Language']));
					$Language = $_SESSION['Language'];
					require_once("Kernel/Locales/" .$Language. "/Words.php");
					?>
					<div class="important"><?php echo $Install_1; ?></div><p>
					<?php echo $Install_2; ?>
					<a rel="license" href="http://creativecommons.org/licenses/by/4.0/deed.fr"><img alt="Licence Creative Commons" style="border-width:0" src="http://i.creativecommons.org/l/by/4.0/88x31.png" /></a><br />Ce(tte) œuvre est mise à disposition selon les termes de la <a rel="license" href="http://creativecommons.org/licenses/by/4.0/deed.fr">Licence Creative Commons Attribution 4.0 International</a>.
					<br /><br /><iframe src="LICENCE.txt">
					</iframe><br /><br />
					<form method="POST" action="install.php">
					<input type="submit" name="Accept" value="<?php echo $Install_3; ?>"><br /><br />
					<div class="important"><?php echo $Install_4; ?></div>
					</form>
					<?php
				}
				if (isset($_POST['Accept']))
				{
					?>
					<div class="important"><?php echo $Install_5; ?></div>
					<?php echo $Install_6; ?>
					<form method="POST" action="install.php">
					<?php echo $Install_7; ?><br /><input type="text" name="Database_Name"><br /><br />
					<?php echo $Install_8; ?><br /><input type="text" name="Database_Host"><br /><br />
					<?php echo $Install_9; ?><br /><input type="text" name="Database_User"><br /><br />
					<?php echo $Install_10; ?><br /><input type="password" name="Database_Password"><br /><br />
					<input type="submit" name="Create_Configuration" value="<?php echo $Install_11; ?>">
					</form>
					<?php
				}
				if (isset($_POST['Create_Configuration']))
				{
					$Language = $_SESSION['Language'];
					$Database_Name = htmlspecialchars(addslashes($_POST['Database_Name']));
					$Database_Host = htmlspecialchars(addslashes($_POST['Database_Host']));
					$Database_User = htmlspecialchars(addslashes($_POST['Database_User']));
					$Database_Password = htmlspecialchars(addslashes($_POST['Database_Password']));
					
					$Open_Locales = fopen("Kernel/Config/Locales.php", "w");
					fwrite($Open_Locales, "
					<?php
					\$Language = '$Language';
					?>");
					fclose($Open_Locales);
					
					$File = dirname(__FILE__); 
					$Link = 'http://' .$_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']); 
					$Open_Server = fopen("Kernel/Config/Server.php", "w");
					fwrite($Open_Server, "
					<?php
					\$File_Root = '$File'; 
					\$Link_Root = '$Link'; 					
					?>");
					fclose($Open_Server);

					$Open_SQL = fopen("Kernel/Config/SQL.php", "w");
					fwrite($Open_SQL, "
					<?php
					//Version of Caranille RPG
					\$version = \"6.0.0\";
					\$Dsn = 'mysql:dbname=$Database_Name;host=$Database_Host';
					\$User = '$Database_User';
					\$Password = '$Database_Password';
					?>");
					fclose($Open_SQL);
					
					if (file_exists("Kernel/Config/SQL.php"))
					{
						?>
						<form method="POST" action="install.php">
						<?php echo $Install_12; ?>
						<br /><br />
						<input type="submit" name="Choose_Curve" value="<?php echo $Install_13; ?>">
						</form>
						<?php
					}
					else
					{
						echo $Install_14;
					}
                }
				if (isset($_POST['Choose_Curve']))
				{
					?>
					<?php echo $Install_15; ?>
					<form method="POST" action="install.php">
					<?php echo $Install_16; ?> <br /> <input type="text" name="HP_Level"><br /><br />
					<?php echo $Install_17; ?> <br /> <input type="text" name="MP_Level"><br /><br />
					<?php echo $Install_18; ?> <br /> <input type="text" name="Strength_Level"><br /><br />
					<?php echo $Install_19; ?> <br /> <input type="text" name="Magic_Level"><br /><br />
					<?php echo $Install_20; ?> <br /> <input type="text" name="Agility_Level"><br /><br />  
					<?php echo $Install_21; ?> <br /> <input type="text" name="Defense_Level"><br /><br />                                  
					<?php echo $Install_22; ?> <br /> <input type="text" name="Experience_Level"><br /><br />
					<input type="submit" name="Start_Installation" value="<?php echo $Install_23; ?>">
					</form>
					<?php
				}
				if (isset($_POST['Start_Installation']))
				{
					require_once("Kernel/Functions/SQL.php");
					?>
					<div class="important"><?php echo $Install_24; ?></div><br /><br />
					<?php
					
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
				
					$bdd->exec("CREATE TABLE `Caranille_Chapters` (
					`Chapter_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Chapter_Number` int(5) NOT NULL,
					`Chapter_Name` VARCHAR(30) NOT NULL,
					`Chapter_Opening` TEXT NOT NULL,
					`Chapter_Ending` TEXT NOT NULL,
					`Chapter_Defeate` TEXT NOT NULL,
					`Chapter_Monster` int(5) NOT NULL
					)");

					$bdd->exec("CREATE TABLE `Caranille_Chat` (
					`Chat_Message_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Chat_Pseudo_ID` INT(5) NOT NULL,
					`Chat_Message` TEXT NOT NULL
					)");

					$bdd->exec("CREATE TABLE `Caranille_Configuration` (
					`Configuration_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Configuration_RPG_Name` VARCHAR(30) NOT NULL,
					`Configuration_Presentation` TEXT NOT NULL,
					`Configuration_Access` VARCHAR(10) NOT NULL
					)");

					$bdd->exec("CREATE TABLE `Caranille_Inventory` (
					`Inventory_ID` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Inventory_Account_ID` int(5) NOT NULL,
					`Inventory_Item_ID` int(5) NOT NULL,
					`Inventory_Item_Quantity` int(5) NOT NULL,
					`Inventory_Item_Equipped` VARCHAR(10) NOT NULL
					)");
				
					$bdd->exec("CREATE TABLE `Caranille_Inventory_Invocations` (
					`Inventory_Invocation_Account_ID` int(5) NOT NULL,
					`Inventory_Invocation_Invocation_ID` int(5) NOT NULL
					)");
				
					$bdd->exec("CREATE TABLE `Caranille_Inventory_Magics` (
					`Inventory_Magic_Account_ID` int(5) NOT NULL,
					`Inventory_Magic_Magic_ID` int(5) NOT NULL
					)");
					
					$bdd->exec("CREATE TABLE `Caranille_Invocations` (
					`Invocation_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Invocation_Image` TEXT NOT NULL,	
					`Invocation_Name` VARCHAR(30) NOT NULL,
					`Invocation_Description` TEXT NOT NULL,
					`Invocation_Damage` int(11) NOT NULL,
					`Invocation_Town` int(5) NOT NULL,
					`Invocation_Price` int(11) NOT NULL
					)");
					
					$bdd->exec("CREATE TABLE `Caranille_Items` (
					`Item_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Item_Image` TEXT NOT NULL,	
					`Item_Type` VARCHAR(30) NOT NULL,
					`Item_Level_Required` VARCHAR(30) NOT NULL,
					`Item_Name` VARCHAR(30) NOT NULL,
					`Item_Description` TEXT NOT NULL,
					`Item_HP_Effect` int(11) NOT NULL,
					`Item_MP_Effect` int(11) NOT NULL,
					`Item_Strength_Effect` int(11) NOT NULL,
					`Item_Magic_Effect` int(11) NOT NULL,
					`Item_Agility_Effect` int(11) NOT NULL,
					`Item_Defense_Effect` int(11) NOT NULL,
					`Item_Sagesse_Effect` int(11) NOT NULL,
					`Item_Town` int(5) NOT NULL,
					`Item_Purchase_Price` int(11) NOT NULL,
					`Item_Sale_Price` int(11) NOT NULL
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
					
					$bdd->exec("CREATE TABLE `Caranille_Magics` (
					`Magic_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Magic_Image` TEXT NOT NULL,	
					`Magic_Name` VARCHAR(30) NOT NULL,
					`Magic_Description` TEXT NOT NULL,
					`Magic_Type` VARCHAR(30) NOT NULL,
					`Magic_Effect` int(11) NOT NULL,
					`Magic_MP_Cost` int(11) NOT NULL,
					`Magic_Town` int(5) NOT NULL,
					`Magic_Price` int(11) NOT NULL
					)");
					
					$bdd->exec("CREATE TABLE `Caranille_Missions` (
					`Mission_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Mission_Town` int(5) NOT NULL,
					`Mission_Number` int(5) NOT NULL,
					`Mission_Name` VARCHAR(30) NOT NULL,
					`Mission_Introduction` TEXT NOT NULL,
					`Mission_Victory` TEXT NOT NULL,
					`Mission_Defeate` TEXT NOT NULL,
					`Mission_Monster` int(5) NOT NULL
					)");
					
					$bdd->exec("CREATE TABLE `Caranille_Missions_Successful` (
					`Mission_Successful_Mission_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Mission_Successful_Account_ID` int(5) NOT NULL
					)");

					$bdd->exec("CREATE TABLE `Caranille_Monsters` (
					`Monster_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Monster_Image` TEXT NOT NULL,	
					`Monster_Name` VARCHAR(30) NOT NULL,
					`Monster_Description` TEXT NOT NULL,
					`Monster_Level` int(11) NOT NULL,
					`Monster_Strength` int(11) NOT NULL,
					`Monster_Defense` int(11) NOT NULL,
					`Monster_HP` int(11) NOT NULL,
					`Monster_MP` int(11) NOT NULL,
					`Monster_Golds` int(11) NOT NULL,
					`Monster_Experience` bigint(255) NOT NULL,
					`Monster_Town` int(5) NOT NULL,
					`Monster_Item_One` int(11) NOT NULL,
					`Monster_Item_One_Rate` int(11) NOT NULL,
					`Monster_Item_Two` int(11) NOT NULL,
					`Monster_Item_Two_Rate` int(11) NOT NULL,
					`Monster_Item_Three` int(11) NOT NULL,
					`Monster_Item_Three_Rate` int(11) NOT NULL,
					`Monster_Item_Four` int(11) NOT NULL,
					`Monster_Item_Four_Rate` int(11) NOT NULL,
					`Monster_Item_Five` int(11) NOT NULL,
					`Monster_Item_Five_Rate` int(11) NOT NULL,
					`Monster_Access` VARCHAR(30) NOT NULL
					)");
					
					$bdd->exec("CREATE TABLE `Caranille_News` (
					`News_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`News_Title` VARCHAR(30) NOT NULL,
					`News_Message` TEXT NOT NULL,
					`News_Account_Pseudo` VARCHAR(15) NOT NULL,
					`News_Date` DATETIME NOT NULL
					)");
		
					$bdd->exec("CREATE TABLE `Caranille_Private_Messages` (
					`Private_Message_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Private_Message_Transmitter` int(5) NOT NULL,
					`Private_Message_Receiver` VARCHAR(20) NOT NULL,
					`Private_Message_Subject` TEXT NOT NULL,
					`Private_Message_Message` TEXT NOT NULL
					)");
				
					$bdd->exec("CREATE TABLE `Caranille_Sanctions` (
					`Sanction_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Sanction_Type` VARCHAR(15) NOT NULL,
					`Sanction_Message` TEXT NOT NULL,
					`Sanction_Transmitter` VARCHAR(50) NOT NULL,
					`Sanction_Receiver` INT(11) NOT NULL
					)");

					$bdd->exec("CREATE TABLE `Caranille_Towns` (
					`Town_ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					`Town_Image` TEXT NOT NULL,		
					`Town_Name` VARCHAR(30) NOT NULL,
					`Town_Description` TEXT NOT NULL,
					`Town_Price_INN` int(10) NOT NULL,
					`Town_Chapter` int(5) NOT NULL
					)");

					$Level = 1;
					$Experience = 0;
					$HP = 100;
					$MP = 10;
					$Strength= 10;
					$Magic = 10;
					$Agility = 10;
					$Defense = 10;
                                        
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
                                        
					$HP_Choice = $_POST['HP_Level'];
					$MP_Choice = $_POST['MP_Level'];
					$MP_Choice = $_POST['Strength_Level'];
					$Magic_Choice = $_POST['Magic_Level'];
					$Agility_Choice = $_POST['Agility_Level'];
					$Defense_Choice = $_POST['Defense_Level'];
					$Experience_Choice = $_POST['Experience_Level'];
					while ($Level < 1000)
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
						
					?>
					<?php echo $Install_25; ?>
					<form method="POST" action="install.php">
					<input type="submit" name="Configure" value="<?php echo $Install_26; ?>">
					</form>
					<?php
				}
				if (isset($_POST['Configure']))
				{
					?>
					<div class="important"><?php echo $Install_27; ?></div><br /><br />
					<?php echo $Install_28; ?>
					<form method="POST" action="install.php">
					<?php echo $Install_29; ?><br /> <input type="text" name="RPG_Name"><br /><br />
					<?php echo $Install_30; ?><br /><textarea name="Presentation" ID="Presentation" rows="10" cols="50"></textarea><br /><br />
					<?php echo $Install_31; ?><br /> <input type="text" name="Pseudo"><br /><br />
					<?php echo $Install_32; ?><br /> <input type="password" name="Password"><br /><br />
					<?php echo $Install_33; ?><br /> <input type="password" name="Password_Confirm"><br /><br />
					<?php echo $Install_34; ?><br /> <input type="text" name="Email"><br /><br />
					<input type="submit" name="Finish" value="<?php echo $Install_35; ?>">
					</form>
					<?php
				}
				if (isset($_POST['Finish']))
				{
					require_once 'Kernel/Functions/SQL.php';
					echo "<div class=\"important\"><?php echo $Install_36; ?></div><br /><br />";
					$RPG_Name = htmlspecialchars(addslashes($_POST['RPG_Name']));
					$Presentation = htmlspecialchars(addslashes($_POST['Presentation']));
					$Pseudo = htmlspecialchars(addslashes($_POST['Pseudo']));
					$Email = htmlspecialchars(addslashes($_POST['Email']));

					if (isset($_POST['RPG_Name']) && ($_POST['Presentation']) && ($_POST['Pseudo']) && ($_POST['Password']) && ($_POST['Email']))
					{
						$Password = htmlspecialchars(addslashes($_POST['Password']));
						$Password_Confirm = htmlspecialchars(addslashes($_POST['Password_Confirm']));
						if ($Password == $Password_Confirm)
						{
							$bdd->exec("INSERT INTO Caranille_Invocations VALUES(
							'', 
							'http://localhost', 
							'Trident', 
							'Chimère qui provient du fond des océans', 
							'10',
							'1', 
							'200')");

							$Date = date('Y-m-d H:i:s');
							$IP = $_SERVER["REMOTE_ADDR"];
							$Password = md5(htmlspecialchars(addslashes($_POST['Password'])));

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
							'Admin', 
							:Date, 
							:IP, 
							'Authorized' , 
							'None')");

							$Add_Account->execute(array(
							'Pseudo' => $Pseudo, 
							'Password' => $Password, 
							'Email' => $Email, 
							'Date' => $Date, 
							'IP' => $IP));
							
							$RPG = $bdd->prepare("INSERT into Caranille_Configuration VALUES(
							'', 
							:RPG_Name, 
							:Presentation, 
							'Yes')");

							$RPG->execute(array(
							'RPG_Name' => $RPG_Name, 
							'Presentation' => $Presentation));

							$bdd->exec("INSERT into Caranille_Guilds_competences VALUES(
							'1', 
							'1', 
							'1', 
							'1', 
							'1')");
							
							$bdd->exec("INSERT into Caranille_Chapters VALUES(
							'', 
							'1', 
							'Chapitre 1 - Le commencement', 
							'Bienvenue dans Indicia, une ville d\'habitude très agréable, malheureusement un monstre bloque l\'accé à la ville', 
							'Vous avez sauvé la ville', 
							'Vous êtes morts en héro', 
							'3')");

							$bdd->exec("INSERT INTO Caranille_Inventory VALUES(
							'', 
							'1', 
							'1', 
							'1', 
							'No')");

							$bdd->exec("INSERT INTO Caranille_Inventory VALUES(
							'', 
							'1', 
							'2', 
							'1', 
							'No')");

							$bdd->exec("INSERT INTO Caranille_Inventory VALUES(
							'', 
							'1', 
							'3', 
							'1', 
							'No')");

							$bdd->exec("INSERT INTO Caranille_Inventory VALUES(
							'', 
							'1', 
							'4', 
							'1', 
							'No')");

							$bdd->exec("INSERT INTO Caranille_Inventory VALUES(
							'', 
							'1', 
							'5', 
							'1', 
							'No')");

							$bdd->exec("INSERT INTO Caranille_Inventory_Invocations VALUES(
							'1', 
							'1')");

							$bdd->exec("INSERT INTO Caranille_Inventory_Magics VALUES(
							'1', 
							'1')");

							$bdd->exec("INSERT INTO Caranille_News VALUES(
							'', 
							'Installation de Caranille', 
							'Félicitation Caranille est bien installé, vous pouvez éditer cette news ou la supprimer', 
							'$Pseudo', 
							'$Date')");

							$bdd->exec("INSERT INTO Caranille_Magics VALUES(
							'', 
							'http://localhost', 
							'Feu', 
							'Petite boule de feu', 
							'Attack', 
							'5', 
							'10', 
							'1', 
							'50')");

							$bdd->exec("INSERT INTO Caranille_Magics VALUES(
							'', 
							'http://localhost', 
							'Soin', 
							'Un peu de HP en plus', 
							'Health', 
							'10', 
							'5', 
							'1', 
							'50')");

							$bdd->exec("INSERT INTO Caranille_Missions VALUES(
							'', 
							'1', 
							'1', 
							'Mission 01 - Affronter un dragon', 
							'Un dragon menace le village de Indicia, aller l\'affronter pour sauver le village', 
							'Vous avez sauvé le village', 
							'Le dragon vient de détruire le village', 
							'2')");
						
							$bdd->exec("INSERT INTO Caranille_Monsters VALUES(
							'', 
							'http://localhost', 
							'Plop', 
							'Petit monstre vert', 
							'1', 
							'15', 
							'5', 
							'40', 
							'30', 
							'5', 
							'5', 
							'1', 
							'', 
							'', 
							'', 
							'', 
							'', 
							'', 
							'',
							'',
							'',
							'', 
							'Battle')");

							$bdd->exec("INSERT INTO Caranille_Monsters VALUES(
							'', 
							'http://localhost', 
							'Dragon', 
							'Monstre qui crache du feu', 
							'1', 
							'50', 
							'30', 
							'1000', 
							'100', 
							'100', 
							'100', 
							'1', 
							'', 
							'', 
							'', 
							'', 
							'', 
							'', 
							'',
							'',
							'',
							'', 
							'Mission')");

							$bdd->exec("INSERT INTO Caranille_Monsters VALUES(
							'', 
							'http://localhost', 
							'Plop doree', 
							'Petit monstre en or', 
							'1', 
							'75', 
							'10', 
							'300', 
							'30', 
							'5', 
							'5', 
							'1', 
							'', 
							'', 
							'', 
							'', 
							'', 
							'',
							'',
							'',
							'',
							'', 
							'Chapter')");

							$bdd->exec("INSERT INTO Caranille_Items VALUES(
							'', 
							'http://localhost', 
							'Weapon', 
							'1', 
							'Epée de cuivre', 
							'Une petite Epée', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'1', 
							'10', 
							'5')");

							$bdd->exec("INSERT INTO Caranille_Items VALUES(
							'', 
							'http://localhost', 
							'Armor', 
							'1', 
							'Armure de cuivre', 
							'Une petite armure', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'1', 
							'10', 
							'5')");

							$bdd->exec("INSERT INTO Caranille_Items VALUES(
							'', 
							'http://localhost', 
							'Boots', 
							'1', 
							'Bottes de cuivre', 
							'Des petites bottes', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'1', 
							'10', 
							'5')");

							$bdd->exec("INSERT INTO Caranille_Items VALUES(
							'', 
							'http://localhost', 
							'Gloves',
							'1', 
							'Gants de cuivre', 
							'Des petits gants', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'1', 
							'10', 
							'5')");

							$bdd->exec("INSERT INTO Caranille_Items VALUES(
							'', 
							'http://localhost', 
							'Helmet', 
							'1', 
							'Casque de cuivre', 
							'Un petit casque', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'1', 
							'0', 
							'10', 
							'5')");

							$bdd->exec("INSERT INTO Caranille_Items VALUES(
							'', 
							'http://localhost', 
							'Parchment', 
							'1', 
							'Parchemin vide', 
							'Un parchemin vide', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'1', 
							'10', 
							'5')");

							$bdd->exec("INSERT INTO Caranille_Items VALUES(
							'', 
							'http://localhost', 
							'Health', 
							'1', 
							'Potion', 
							'Redonne 50 HP', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'1', 
							'10', 
							'5')");

							$bdd->exec("INSERT INTO Caranille_Items VALUES(
							'', 
							'http://localhost', 
							'Magic', 
							'1', 
							'Ether', 
							'Redonne 5 MP', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'0', 
							'1', 
							'10', 
							'5')");
					
							$bdd->exec("INSERT INTO Caranille_Towns VALUES(
							'', 
							'http://localhost', 
							'Indicia', 
							'Petite ville cotière', 
							'10', 
							'1')");
						
							?>
							<?php echo $Install_37; ?>
							<form method="POST" action="index.php">
							<input type="submit" name="accueil" value="<?php echo $Install_38; ?>">
							</form>
							<?php
						}
						else
						{
							?>
							<?php echo $Install_39; ?>
							<form method="POST" action="index.php">
							<input type="submit" name="Finish" value="<?php echo $Install_40; ?>">
							</form>
							<?php
						}
					}
					else
					{
						?>
						<?php echo $Install_41; ?>
						<form method="POST" action="index.php">
						<input type="submit" name="Finish" value="<?php echo $Install_42; ?>">
						</form>
						<?php
					}
				}
				?>
		</section>
	</body>
</html>
