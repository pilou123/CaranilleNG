<?php
if (isset($_SESSION['ID']))
{
	if (isset($Next_Level))
	{
        ?>
						<div id="MV">
							<div class="en_tete_MV">Stats</div>
								<a class="lien_MV"><?php echo "<div class=\"important\">$Right_0</div> : " . $_SESSION['Pseudo'] ?></a>
								<a class="lien_MV"><div class="important"><?php echo $Right_2; ?></div> : <?php echo $_SESSION['Strength_Total']; ?> </a>
								<a class="lien_MV"><div class="important"><?php echo $Right_1; ?></div> : <?php echo $_SESSION['Level']; ?></a>
								<a class="lien_MV"><div class="important"><?php echo $Right_3; ?></div> : <?php echo $_SESSION['Magic_Total']; ?></a>
								<a class="lien_MV"><div class="important"><?php echo $Right_4; ?></div> : <?php echo $_SESSION['Agility_Total']; ?></a>
								<a class="lien_MV"><div class="important"><?php echo $Right_5; ?></div> : <?php echo $_SESSION['Defense_Total']; ?></a>
								<a class="lien_MV"><div class="important"><?php echo $Right_6; ?></div> : <?php echo $_SESSION['Sagesse_Bonus']; ?></a>
								<a class="lien_MV"><div class="important"><?php echo $Right_7; ?></div> : <?php echo $_SESSION['HP']. "/" .$_SESSION['HP_Total']; ?></a>
								<a class="lien_MV"><div class="important"><?php echo $Right_8; ?></div> : <?php echo $_SESSION['MP']. "/" .$_SESSION['MP_Total']; ?></a>
								<a class="lien_MV"><div class="important"><?php echo $Right_9; ?></div> : <?php echo $_SESSION['Gold']; ?></a>
								<a class="lien_MV"><div class="important"><?php echo $Right_10; ?></div> : <?php echo $_SESSION['Experience']; ?></a>
								<a class="lien_MV"><div class="important"><?php echo $Right_11; ?></div> : <?php echo $Next_Level; ?></a>
							<div class="marge_MV"></div>
						</div>
		<?php
	}
}else{
?>
						<div id="MV">
							<div class="en_tete_MV">Partenaires</div>
								<a class="lien_MV">Votre site ici ?</a>
								<a class="lien_MV">Votre site ici ?</a>
								<a class="lien_MV">Votre site ici ?</a>
								<a class="lien_MV">Votre site ici ?</a>
								<a class="lien_MV">Votre site ici ?</a>
								<a class="lien_MV">Votre site ici ?</a>
								<a class="lien_MV">Votre site ici ?</a>
								<a class="lien_MV">Votre site ici ?</a>
								<a class="lien_MV">Votre site ici ?</a>
								<a class="lien_MV">Votre site ici ?</a>
							<div class="marge_MV"></div>
						</div>
<?php
}
?>


