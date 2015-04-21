<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	if (isset($_SESSION['ID']))
	{
		if (empty($_POST['Launch']))
		{
			$Chapter_Level = htmlspecialchars(addslashes($_SESSION['Chapter']));
			$Chapter_Level_Query = $bdd->prepare("SELECT * FROM Caranille_Chapters
			WHERE Chapter_Number = ?");
			$Chapter_Level_Query->execute(array($Chapter_Level));
			while ($Chapter_Level = $Chapter_Level_Query->fetch())
			{
				$Chapter_Number = stripslashes($Chapter_Level['Chapter_Number']);
				echo "" .stripslashes($Chapter_Level['Chapter_Name']). "<br />";
				echo "" .stripslashes(nl2br($Chapter_Level['Chapter_Opening'])). "<br />";
				$_SESSION['Chapter_Opening'] = stripslashes(nl2br($Chapter_Level['Chapter_Opening']));
				$_SESSION['Chapter_Ending'] = stripslashes(nl2br($Chapter_Level['Chapter_Ending']));
				$_SESSION['Chapter_Defeate'] = stripslashes(nl2br($Chapter_Level['Chapter_Defeate']));
				echo '<form method="POST" action="Story.php">';
				echo "<input type=\"submit\" name=\"Launch\" value=\"$Story_0\">";
				echo '</form><br /><br />';
			}
			$Chapter_Level_Query->closeCursor();
			if (empty($Chapter_Number))
			{
				echo "$Story_1";
			}
		}
		if (isset($_POST['Launch']))
		{
			$Chapter_Number = htmlspecialchars(addslashes($_SESSION['Chapter']));
			$Chapter_Monster_Query = $bdd->prepare("SELECT * FROM Caranille_Chapters, Caranille_Monsters
			WHERE Chapter_Number = ?
			AND Chapter_Monster = Monster_ID");
			$Chapter_Monster_Query->execute(array($Chapter_Number));
			while ($Chapter_Monster = $Chapter_Monster_Query->fetch())
			{
				$Monster_Image = htmlspecialchars(addslashes($Chapter_Monster['Monster_Image']));
				echo "<img src=\"$Monster_Image\"><br />";
				echo '' .$Chapter_Monster['Monster_Name']. '<br />';
				echo '' .stripslashes(nl2br($Chapter_Monster['Monster_Description'])). '<br />';
				$_SESSION['Monster_ID'] = stripslashes($Chapter_Monster['Monster_ID']);
				$_SESSION['Monster_Image'] = stripslashes($Chapter_Monster['Monster_Image']);	
				$_SESSION['Monster_Name'] = stripslashes($Chapter_Monster['Monster_Name']);
				$_SESSION['Monster_Description'] = stripslashes(nl2br($Chapter_Monster['Monster_Description']));
				$_SESSION['Monster_Level'] = stripslashes($Chapter_Monster['Monster_Level']);
				$_SESSION['Monster_Strength'] = stripslashes($Chapter_Monster['Monster_Strength']);
				$_SESSION['Monster_Defense'] = stripslashes($Chapter_Monster['Monster_Defense']);
				$_SESSION['Monster_HP'] = stripslashes($Chapter_Monster['Monster_HP']);
				$_SESSION['Monster_Experience'] = stripslashes($Chapter_Monster['Monster_Experience']);
				$_SESSION['Monster_Golds'] = stripslashes($Chapter_Monster['Monster_Golds']);
				$_SESSION['Monster_Item_One'] = stripslashes($Chapter_Monster['Monster_Item_One']);
				$_SESSION['Monster_Item_One_Rate'] = stripslashes($Chapter_Monster['Monster_Item_One_Rate']);
				$_SESSION['Monster_Item_Two'] = stripslashes($Chapter_Monster['Monster_Item_Two']);
				$_SESSION['Monster_Item_Two_Rate'] = stripslashes($Chapter_Monster['Monster_Item_Three_Rate']);
				$_SESSION['Monster_Item_Three'] = stripslashes($Chapter_Monster['Monster_Item_Three']);
				$_SESSION['Monster_Item_Three_Rate'] = stripslashes($Chapter_Monster['Monster_Item_Three_Rate']);
				$_SESSION['Monster_Item_Four'] = stripslashes($monstre['Monster_Item_Four']);
				$_SESSION['Monster_Item_Four_Rate'] = stripslashes($monstre['Monster_Item_Four_Rate']);
				$_SESSION['Monster_Item_Five'] = stripslashes($monstre['Monster_Item_Five']);
				$_SESSION['Monster_Item_Five_Rate'] = stripslashes($monstre['Monster_Item_Five_Rate']);
				$_SESSION['Battle'] = 1;

				$_SESSION['Arena_Battle'] = 0;
				$_SESSION['Chapter_Battle'] = 1;
				$_SESSION['Dungeon_Battle'] = 0;
				$_SESSION['Mission_Battle'] = 0;
				echo '<form method="POST" action="Battle.php">';
				echo "<input type=\"submit\" name=\"Continue\" value=\"$Story_2\">";
				echo '</form>';
			}
			$Chapter_Monster_Query->closeCursor();
		}
	}
	else
	{
		echo "$Story_3";
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
