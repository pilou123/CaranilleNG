<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	if (empty($_POST['Login']))
	{
		echo "$Login_0<br /><br />";
		echo '<form method="POST" action="Login.php"><br />';
		echo "$Login_1<br /> <input type=\"text\" name=\"Pseudo\"><br /><br />";
		echo "$Login_2<br /> <input type=\"password\" name=\"Password\"><br /><br />";
		echo "<input type=\"submit\" name=\"Login\" value=\"$Login_3\">";
		echo '</form>';
	}
	if (isset($_POST['Login']))
	{
		$Account_Pseudo = htmlspecialchars(addslashes($_POST['Pseudo']));
		$Account_Password =  md5(htmlspecialchars(addslashes($_POST['Password'])));
		
		$_SESSION['Account_Data'] = SQL_Account_Connection($Account_Pseudo, $Account_Password);
	
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
	        else
	        {
	            $Reason = $_SESSION['Reason'];
	            echo "<script type=\"text/javascript\"> alert(\"$Login_8 $Reason\"); </script>";
		}
		else
		{
			echo "$Login_9";
		}
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
