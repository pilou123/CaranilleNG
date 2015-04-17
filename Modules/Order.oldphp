<?php
	require_once("../HTML/Header.php");
	require_once("../Global.php");
	if (isset($_SESSION['ID']))
	{
		if ($_SESSION['Order_ID'] == 1)
		{
			if(empty($_POST['Accept']))
			{
				echo '<p>Bienvenue sur la page des ordres</p>';
				echo '<p>Vous êtes actuellement neutre. Pour participer au PVP dans le champs de batailles vous devez choisir un odre à servir</p>';
				echo '<p>ATTENTION, ce choix est irréversible, choisissez donc bien</p>';

				echo '<p>Voici les deux ordres disponibles. Choisissez bien</p>';
				$Data_Order_Query = $bdd->query("SELECT * FROM Caranille_Orders WHERE Order_ID != 1");
				echo '<table>';
			
						echo '<tr>';

							echo '<td>';
								echo 'Nom';
							echo '</td>';

							echo '<td>';
								echo 'Description';
							echo '</td>';

							echo '<td>';
								echo 'Action';
							echo '</td>';

						echo '</tr>';
						
				while ($Order_Data = $Data_Order_Query->fetch())
				{
					echo '<tr>';
							
							$Order_ID = stripslashes($Order_Data['Order_ID']);
							
							echo '<td>';
								echo '' .stripslashes($Order_Data['Order_Name']). '';
							echo '</td>';
						
							echo '<td>';
								echo '' .stripslashes(nl2br($Order_Data['Order_Description'])). '';
							echo '</td>';
											
							echo '<td>';
								echo '<form method="POST" action="Order.php">';
								echo "<input type=\"hidden\" name=\"Order_ID\" value=\"$Order_ID\">";
								echo '<input type="submit" name="Accept" value="Rejoindre">';
								echo '</form><br />';
							echo '</td>';
						
						echo '</tr>';
				}
				echo '</table>';
			}	
			if (isset($_POST['Accept']))
			{
				$Order_ID = htmlspecialchars(addslashes($_POST['Order_ID']));
				$Account_Update = $bdd->prepare("UPDATE Caranille_Accounts SET Account_Order= :Order_ID WHERE Account_ID = :ID");
				$Account_Update->execute(array('Order_ID'=> $Order_ID, 'ID'=> $ID));
				echo '<br /><br />Vous venez de rejoindre un ordre';
			}
		}
		else
		{
			echo 'Vous êtes déjà sous un ordre';
		}
		
	}
	else
	{
		echo 'Vous devez être connecté pour accèder à cette zone';
	}	
	require_once("../HTML/Footer.php");
?>
