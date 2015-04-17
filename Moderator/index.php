<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	//Si le Access est Modo ou Admin
		if ($_SESSION['Access'] == "Modo" || $_SESSION['Access'] == "Admin")
	{
		?>
		<div class="important">Modération du jeu</div><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Moderator/Modules/Sanctions.php"; ?>"><?php echo $MIndex_0; ?></a><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Moderator/Modules/Warnings.php"; ?>"><?php echo $MIndex_1; ?></a><br />
		<?php
	}
	//Si le Access est autre que Admin, afficher le menu classique
	else
	{
		echo <?php echo $MIndex_2; ?>;
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
