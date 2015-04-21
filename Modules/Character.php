<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	if (isset($_SESSION['ID']))
	{
		if (empty($_POST['Change_Password']) && empty($_POST['Finish']))
		{
			echo "$Character_0<br /><br />";
			echo "$Character_1<br /><br />";
			echo "<div class=\"important\">$Character_2</div> : " .htmlspecialchars(addslashes($_SESSION['Pseudo'])). '<br />';
			echo "<div class=\"important\">$Character_3</div> : " .htmlspecialchars(addslashes($_SESSION['Email'])). '<br />';
			echo "<div class=\"important\">$Character_4</div> : " .htmlspecialchars(addslashes($_SESSION['Level'])). '<br />';
			echo "<div class=\"important\">$Character_5</div> : " .htmlspecialchars(addslashes($_SESSION['Strength_Total'])). '<br />';
			echo "<div class=\"important\">$Character_6</div> : " .htmlspecialchars(addslashes($_SESSION['Magic_Total'])). '<br />';
			echo "<div class=\"important\">$Character_7</div> : " .htmlspecialchars(addslashes($_SESSION['Agility_Total'])). '<br />';
			echo "<div class=\"important\">$Character_8</div> : " .htmlspecialchars(addslashes($_SESSION['Defense_Total'])). '<br />';
			echo "<div class=\"important\">$Character_9</div> : " .htmlspecialchars(addslashes($_SESSION['HP'])). '/' .htmlspecialchars(addslashes($_SESSION['HP_Total'])). '<br />';
			echo "<div class=\"important\">$Character_10</div> : " .htmlspecialchars(addslashes($_SESSION['MP'])). '/' .htmlspecialchars(addslashes($_SESSION['MP_Total'])). '<br />';
			echo "<div class=\"important\">$Character_11</div> : " .htmlspecialchars(addslashes($_SESSION['Weapon'])). '<br />';
			echo "<div class=\"important\">$Character_12</div> : " .htmlspecialchars(addslashes($_SESSION['Boots'])). '<br />';
			echo "<div class=\"important\">$Character_13</div> : " .htmlspecialchars(addslashes($_SESSION['Helmet'])). '<br />';
			echo "<div class=\"important\">$Character_14</div> : " .htmlspecialchars(addslashes($_SESSION['Gloves'])). '<br />';
			echo "<div class=\"important\">$Character_15</div> : " .htmlspecialchars(addslashes($_SESSION['Armor'])). '<br />';
			echo "<div class=\"important\">$Character_16</div> : " .htmlspecialchars(addslashes($_SESSION['Gold'])). '<br />';
			echo "<div class=\"important\">$Character_17</div> : " .htmlspecialchars(addslashes($_SESSION['Experience'])). '<br />';
			echo "<div class=\"important\">$Character_18</div> : $Next_Level<br />";
			echo "<div class=\"important\">$Character_19</div> : " .htmlspecialchars(addslashes($_SESSION['Chapter'])). '<br />';
			echo "<div class=\"important\">$Character_20</div> : " .htmlspecialchars(addslashes($_SESSION['Mission'])). '<br />';
			echo "<div class=\"important\">$Character_21</div> : " .htmlspecialchars(addslashes($_SESSION['Access'])). '<br /><br />';
			echo '<form method="POST" action="Character.php"><br />';
			echo "<input type=\"submit\" name=\"Change_Password\" value=\"$Character_22\">";
			echo '</form>';
		}
		if (isset($_POST['Change_Password']))
		{
			echo "$Character_23<br /><br />";
			echo '<form method="POST" action="Character.php"><br />';
			echo "$Character_24<input type=\"password\" name=\"New_Password\"><br />";
			echo "$Character_25<input type=\"password\" name=\"New_Password_Confirmation\"><br />";
			echo "<input type=\"submit\" name=\"Finish\" value=\"$Character_26\">";
			echo '</form>';
		}
		if (isset($_POST['Finish']))
		{
			$New_Password = md5(htmlspecialchars(addslashes($_POST['New_Password'])));
			$New_Password_Confirmation = md5(htmlspecialchars(addslashes($_POST['New_Password_Confirmation'])));
			if ($New_Password == $New_Password_Confirmation)
			{
				echo "$Character_27";
				$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Password= :New_Password WHERE Account_ID= :ID");
				$Update_Account->execute(array('New_Password'=> $New_Password, 'ID'=> $ID));
				echo '<form method="POST" action="Character.php"><br />';
				echo "<input type=\"submit\" name=\"Cancel\" value=\"$Character_28\">";
				echo '</form>';
			}
			else
			{
				echo "$Character_29";
				echo '<form method="POST" action="Character.php"><br />';
				echo "<input type=\"submit\" name=\"Cancel\" value=\"$Character_28\">";
				echo '</form>';
			}
		}
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
