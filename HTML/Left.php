<?php
if (isset($_SESSION['ID']))
{	
	?>
	<div class="important">MMORPG</div><br />
	<a href="<?php echo $_SESSION['Link_Root'] ."/Modules/index.php"; ?>"><?php echo $Left_0; ?></a><br />
	<a href="<?php echo $_SESSION['Link_Root'] ."/Modules/Story.php"; ?>"><?php echo $Left_1; ?></a><br />
	<a href="<?php echo $_SESSION['Link_Root'] ."/Modules/Map.php"; ?>"><?php echo $Left_2; ?></a><br /><br />
	<div class="important"><?php echo $Left_3; ?></div><br />
	<a href="<?php echo $_SESSION['Link_Root'] ."/Modules/Character.php"; ?>"><?php echo $Left_4; ?></a><br />
	<a href="<?php echo $_SESSION['Link_Root'] ."/Modules/Inventory.php"; ?>"><?php echo $Left_5; ?></a><br /><br />
	<div class="important"><?php echo $Left_6; ?></div><br />
	<a href="<?php echo $_SESSION['Link_Root'] ."/Modules/Top.php"; ?>"><?php echo $Left_7; ?></a><br />
	<a href="<?php echo $_SESSION['Link_Root'] ."/Modules/Private_Message.php"; ?>"><?php echo "$Left_8 ($Total_Private_Message Message(s))</a><br />"; ?>
	<a href="<?php echo $_SESSION['Link_Root'] ."/Modules/Chat.php"; ?>"><?php echo $Left_9; ?></a><br /><br />
	<a href="<?php echo $_SESSION['Link_Root'] ."/Modules/Logout.php"; ?>"><?php echo $Left_10; ?></a><br /><br />
	<?php

	if ($_SESSION['Access'] == "Modo" || $_SESSION['Access'] == "Admin")
	{
		?>
		<a href="<?php echo $_SESSION['Link_Root'] ."Moderator/index.php"; ?>"><div class="important"><?php echo $Left_11; ?></div></a><br />
		<?php
	}
	if ($_SESSION['Access'] == "Admin")
	{
		?>
		<a href="<?php echo $_SESSION['Link_Root'] ."Admin/index.php"; ?>"><div class="important"><?php echo $Left_12; ?></div></a><br />
		<?php
	}
}	
//Si l'utilisateur n'est pas connecté
else
{
	?>
	<div class="important">MMORPG</div><br />
	<a href="<?php echo $_SESSION['Link_Root'] ."/Modules/Main.php"; ?>"><?php echo $Left_13; ?></a><br />
	<a href="<?php echo $_SESSION['Link_Root'] ."/Modules/Presentation.php"; ?>"><?php echo $Left_14; ?></a><br /><br />
	<div class="important"><?php echo $Left_15; ?></div><br />
	<a href="<?php echo $_SESSION['Link_Root'] ."/Modules/Register.php"; ?>"><?php echo $Left_16; ?></a><br />
	<a href="<?php echo $_SESSION['Link_Root'] ."/Modules/Login.php"; ?>"><?php echo $Left_17; ?></a><br /><br />
	<div class="important"><?php echo $Left_18; ?></div><br />
	<a href="<?php echo $_SESSION['Link_Root'] ."/Modules/Delete_Account.php"; ?>"><?php echo $Left_19; ?></a><br /><br />
	<?php
}
?>
