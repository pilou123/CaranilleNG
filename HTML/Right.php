<?php
if (isset($_SESSION['ID']))
{
	if (isset($Next_Level))
	{
        ?>
		<?php echo "<div class=\"important\">$Right_0</div> : " . $_SESSION['Pseudo'] ?> <br />
		<div class="important"><?php echo $Right_1; ?></div> : <?php echo $_SESSION['Level']; ?> <br />
		<div class="important"><?php echo $Right_2; ?></div> : <?php echo $_SESSION['Strength_Total']; ?> <br />
		<div class="important"><?php echo $Right_3; ?></div> : <?php echo $_SESSION['Magic_Total']; ?> <br />
		<div class="important"><?php echo $Right_4; ?></div> : <?php echo $_SESSION['Agility_Total']; ?> <br />
		<div class="important"><?php echo $Right_5; ?></div> : <?php echo $_SESSION['Defense_Total']; ?> <br />
		<div class="important"><?php echo $Right_6; ?></div> : <?php echo $_SESSION['Sagesse_Bonus']; ?> <br />
		<div class="important"><?php echo $Right_7; ?></div> : <?php echo $_SESSION['HP']. "/" .$_SESSION['HP_Total']; ?> <br />
		<div class="important"><?php echo $Right_8; ?></div> : <?php echo $_SESSION['MP']. "/" .$_SESSION['MP_Total']; ?> <br /><br />
		<div class="important"><?php echo $Right_9; ?></div> : <?php echo $_SESSION['Gold']; ?> <br />
		<div class="important"><?php echo $Right_10; ?></div> : <?php echo $_SESSION['Experience']; ?> <br />
		<div class="important"><?php echo $Right_11; ?></div> : <?php echo $Next_Level; ?><br /><br />
		<?php
	}
	?>
	CaranilleNG <?php echo "$version"; ?>
	<?php
}
?>

