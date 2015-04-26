<?php
	error_reporting(E_ALL); 
	$timestart = microtime(true);
	session_start();

	require_once $_SESSION['File_Root']. '/Kernel/Include.php';
	require_once $_SESSION['File_Root']. '/HTML/Header.php';
	//Si le Access est Admin
	if ($_SESSION['Access'] == "Admin")
	{
		?>
		
		<div class="important"><?php echo $AIndex_0; ?></div><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Accounts.php"; ?>"><?php echo $AIndex_1; ?></a><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Configuration.php"; ?>"><?php echo $AIndex_2; ?></a><br /><br />
		<div class="important"><?php echo $AIndex_3; ?></div><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Chapters.php"; ?>"><?php echo $AIndex_4; ?></a><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Invocations.php"; ?>"><?php echo $AIndex_5; ?></a><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Equipment.php"; ?>"><?php echo $AIndex_6; ?></a><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Magics.php"; ?>"><?php echo $AIndex_7; ?></a><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Missions.php"; ?>"><?php echo $AIndex_8; ?></a><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Monsters.php"; ?>"><?php echo $AIndex_9; ?></a><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/News.php"; ?>"><?php echo $AIndex_10; ?></a><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Items.php"; ?>"><?php echo $AIndex_11; ?></a><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Parchments.php"; ?>"><?php echo $AIndex_12; ?></a><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Towns.php"; ?>"><?php echo $AIndex_13; ?></a><br /><br />
		<div class="important"><?php echo $AIndex_14; ?></div><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Design.php"; ?>"><?php echo $AIndex_15; ?></a><br /><br />
		<div class="important"><?php echo $AIndex_16; ?></div><br />
		<a href="<?php echo $_SESSION['Link_Root'] ."/Admin/Modules/Presents.php"; ?>"><?php echo $AIndex_17; ?></a><br />
		<?php
	}
	//Si le Access est autre que Admin, afficher le menu classique
	else
	{
		echo $AIndex_18;
	}
	require_once $_SESSION['File_Root'] .'/HTML/Footer.php';
?>
