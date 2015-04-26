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
