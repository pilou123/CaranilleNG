<?php
if (isset($_SESSION['ID']))
{	
	?>
						<div id="MH">
							<div class="groupe_lien_MH">
								<a class="menu_MH" href="<?php echo $_SESSION['Link_Root'] ."/Modules/index.php"; ?>"><?php echo $Left_0; ?></a>
							</div>
							<div class="groupe_lien_MH">
								<a class="menu_MH" href="#">MMORPG</a>
								<div class="groupe_sublien_MH">
									<div class="sublien_MH">
										<a href="<?php echo $_SESSION['Link_Root'] ."/Modules/Story.php"; ?>"><?php echo $Left_1; ?></a>
									</div>
									<div class="sublien_MH">
										<a href="<?php echo $_SESSION['Link_Root'] ."/Modules/Map.php"; ?>"><?php echo $Left_2; ?></a>
									</div>
									<div class="MH_deroulant_bottom"></div>
								</div>
							</div>
							<div class="groupe_lien_MH">
								<a class="menu_MH" href="#"><?php echo $Left_3; ?></a>
								<div class="groupe_sublien_MH">
									<div class="sublien_MH">
										<a href="<?php echo $_SESSION['Link_Root'] ."/Modules/Character.php"; ?>"><?php echo $Left_4; ?></a>
									</div>
									<div class="sublien_MH">
										<a href="<?php echo $_SESSION['Link_Root'] ."/Modules/Inventory.php"; ?>"><?php echo $Left_5; ?></a>
									</div>
									<div class="MH_deroulant_bottom"></div>
								</div>
							</div>
							<div class="groupe_lien_MH">
								<a class="menu_MH" href="#"><?php echo $Left_6; ?></a>
								<div class="groupe_sublien_MH">
									<div class="sublien_MH">
										<a href="<?php echo $_SESSION['Link_Root'] ."/Modules/Top.php"; ?>"><?php echo $Left_7; ?></a>
									</div>
									<div class="sublien_MH">
										<a href="<?php echo $_SESSION['Link_Root'] ."/Modules/Private_Message.php"; ?>"><?php echo "$Left_8 ($Total_Private_Message Message(s))"; ?></a>
									</div>
									<div class="sublien_MH">
										<a href="<?php echo $_SESSION['Link_Root'] ."/Modules/Chat.php"; ?>"><?php echo $Left_9; ?></a>
									</div>
									<div class="MH_deroulant_bottom"></div>
								</div>
							</div>
							<div class="groupe_lien_MH">
								<a class="menu_MH" href="<?php echo $_SESSION['Link_Root'] ."/Modules/Logout.php"; ?>"><?php echo $Left_10; ?></a>
							</div>
	<?php

	if ($_SESSION['Access'] == "Modo" || $_SESSION['Access'] == "Admin")
	{
		?>
				<div class="groupe_lien_MH">
					<a class="menu_MH" href="<?php echo $_SESSION['Link_Root'] ."/Modo/index.php"; ?>"><?php echo $Left_11; ?></a>
				</div>
		<?php
	}
	if ($_SESSION['Access'] == "Admin")
	{
		?>
				<div class="groupe_lien_MH">
					<a class="menu_MH" href="<?php echo $_SESSION['Link_Root'] ."/Admin/index.php"; ?>"><?php echo $Left_12; ?></a>
				</div>
		<?php
	}
}	
//Si l'utilisateur n'est pas connecté
else
{
	?>
	<div id="MH">
		<div class="groupe_lien_MH">
			<a class="menu_MH" href="<?php echo $_SESSION['Link_Root'] ."/Modules/Main.php"; ?>"><?php echo $Left_0; ?></a>
		</div>
		<div class="groupe_lien_MH">
			<a class="menu_MH" href="<?php echo $_SESSION['Link_Root'] ."/Modules/Presentation.php"; ?>"><?php echo $Left_14; ?></a>
		</div>
		<div class="groupe_lien_MH">
			<a class="menu_MH" href="<?php echo $_SESSION['Link_Root'] ."/Modules/Register.php"; ?>"><?php echo $Left_16; ?></a>
		</div>
		<div class="groupe_lien_MH">
			<a class="menu_MH" href="<?php echo $_SESSION['Link_Root'] ."/Modules/Login.php"; ?>"><?php echo $Left_17; ?></a>
		</div>
		<div class="groupe_lien_MH">
			<a class="menu_MH" href="<?php echo $_SESSION['Link_Root'] ."/Modules/Delete_Account.php"; ?>"><?php echo $Left_19; ?></a>
		</div>
	</div>
	<?php
}
?>
						</div>

