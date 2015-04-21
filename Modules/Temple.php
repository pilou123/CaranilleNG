<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	if (isset($_SESSION['ID']))
	{
		if ($_SESSION['Town'] == 1)
		{
			if (empty($_POST['Buy']))
			{	
				$Town = htmlspecialchars(addslashes($_SESSION['Town_ID']));
				echo "$Temple_0 <br />";
				echo '<table>';
		
					echo '<tr>';

						echo '<td>';
							echo "$Temple_1";
						echo '</td>';

						echo '<td>';
							echo "$Temple_2";
						echo '</td>';

						echo '<td>';
							echo "$Temple_3";
						echo '</td>';

						echo '<td>';
							echo "$Temple_4";
						echo '</td>';
					
						echo '<td>';
							echo "$Temple_5";
						echo '</td>';

					echo '</tr>';
				
				$Invocation_Query = $bdd->prepare("SELECT * FROM Caranille_Invocations
				WHERE Invocation_Town = ?");
				$Invocation_Query->execute(array($Town));
				while ($Invocation = $Invocation_Query->fetch())
				{
					echo '<tr>';
				
						$Invocation_Image = stripslashes($Invocation['Invocation_Image']);
						$Invocation_ID = stripslashes($Invocation['Invocation_ID']);
					
						echo '<td>';
							echo "<img src=\'$Invocation_Image\'><br />";
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Invocation['Invocation_Name']). '';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes(nl2br($Invocation['Invocation_Description'])). '';
						echo '</td>';
					
						echo '<td>';
							echo '' .stripslashes($Invocation['Invocation_Price']). '';
						echo '</td>';
					
						echo '<td>';
							echo '<form method="POST" action="Temple.php">';
							echo "<input type=\"hidden\" name=\"Item_ID\" value=\"$Invocation_ID\">";
							echo "<input type=\"submit\" name=\"Buy\" value=\"$Temple_6\">";
							echo '</form><br />';
						echo '</td>';
					
					echo '</tr>';
				}
				$Invocation_Query->closeCursor();

				echo '</table>';
				if (empty($Invocation_ID))
				{
					echo "$Temple_7";
				}
			}
			if (isset($_POST['Buy']))
			{
				$Item_ID = $_POST['Item_ID'];
				$Town = htmlspecialchars(addslashes($_SESSION['Town_ID']));
				$Item_Query = $bdd->prepare("SELECT * FROM Caranille_Invocations
				WHERE Invocation_ID= ?
				AND Invocation_Town = ?");
				$Item_Query->execute(array($Item_ID, $Town));

				while ($Item = $Item_Query->fetch())
				{
					$_SESSION['Item_ID'] = stripslashes($Item['Invocation_ID']);
					$_SESSION['Item_Price'] = stripslashes($Item['Invocation_Price']);

					if ($_SESSION['Gold'] >= $_SESSION['Item_Price'])
					{
						$Item_ID = htmlspecialchars(addslashes($_SESSION['Item_ID']));

						$Item_Quantity_Query = $bdd->prepare("SELECT * FROM Caranille_Inventory_Invocations
						WHERE Inventory_Invocation_Invocation_ID= ?
						AND Inventory_Invocation_Account_ID= ?");
						$Item_Quantity_Query->execute(array($Item_ID, $ID));

						$Item_Quantity = $Item_Quantity_Query->rowCount();
						if ($Item_Quantity>=1)
						{
							echo "$Temple_8";
							echo '<form method="POST" action="Temple.php">';
							echo "<input type=\"submit\" name=\"Cancel\" value=\"$Temple_9\">";
							echo '</form>';
						}
						else
						{
							$Item_ID = htmlspecialchars(addslashes($_SESSION['Item_ID']));
							$Gold = htmlspecialchars(addslashes($_SESSION['Gold'])) - htmlspecialchars(addslashes($_SESSION['Item_Price']));
							$Item = htmlspecialchars(addslashes($_SESSION['Item_Name']));
						
							$Add_Invocation = $bdd->prepare("INSERT INTO Caranille_Inventory_Invocations VALUES(:ID, :Item_ID)");
							$Add_Invocation->execute(array('ID'=> $ID, 'Item_ID'=> $Item_ID));
						
							$Update_Account = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Gold = :Gold WHERE Account_ID = :ID)");
							$Update_Account->execute(array('Gold'=> $Gold, 'ID'=> $ID));
						
							echo "$Temple_10 $Invocation<br /><br />";
							echo '<form method="POST" action="Temple.php">';
							echo "<input type=\"submit\" name=\"Cancel\" value=\"$Temple_9\">";
							echo '</form>';
						}
					}
					else
					{
						echo "$Temple_11";
					}
				}
			}
		}
		if ($_SESSION['Town'] == 0)
		{
			echo "$Temple_12";
		}
	}
	else
	{
		echo "$Temple_13";
	}	
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
