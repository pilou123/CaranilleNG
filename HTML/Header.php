<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
	<head>
		<!-- Ce site a été créé avec http://www.creer-son-website.fr/ -->
		<title>CaranilleNG</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" media="screen" type="text/css" title="Design" href="<?php echo $_SESSION['Link_Root'] ."/Design/style.css"; ?>" />
		<!--[if IE 6]><link rel="stylesheet" media="screen" type="text/css" title="Design" href="design/ie6.css" /> <![endif]-->
		<!--[if IE 7]> <style type="text/css">
			.groupe_lien_MH{display : inline;margin-left:0px;}
			.sublien_MH{height : 37px;width : 120px;}
		</style> <![endif]-->
		<script src="<?php echo $_SESSION['Link_Root'] ."/Design/jquery-2.1.4.min.js"; ?>" type="text/javascript"></script>
		<!--[if IE 6]>
			<script type="text/javascript">
				$(function()
				{
					$('.groupe_lien_MH').hover
					(
						function()
						{
							$(this).addClass('groupe_lien_MH_hover');
						},
						function()
						{
							$(this).removeClass('groupe_lien_MH_hover');
						}
					);
				}
				);
			</script>
		<![endif]-->
		<script type="text/javascript">
			animation_complete=function(){jQuery(this).hide();}
			jquery_MH_deroulant=function()
			{ 
				$(".groupe_lien_MH").mouseenter
				(
					function () 
					{
						$groupe_sublien=jQuery(this).find(".groupe_sublien_MH");
						$sublien=jQuery(this).find(".sublien_MH a");
						$bottom=jQuery(this).find(".MH_deroulant_bottom");
						$top=jQuery(this).find(".MH_deroulant_top");
						if ($groupe_sublien.is(":hidden") || $sublien.is(":hidden") )
						{
							$sublien.hide();
							$bottom.hide();
							$top.hide();
							$groupe_sublien.css({'height':'0px','width':$sublien.innerWidth()}).show();
							//IE8 does not support fadind to 100% and on imbricated div
							//therefore each element must be faded individually to 99%
							$sublien.fadeTo(500,0.99);
							$bottom.fadeTo(500,0.99);
							$top.fadeTo(500,0.99);
							$groupe_sublien.animate({height: $sublien.size()*$sublien.innerHeight() + $bottom.innerHeight() + $top.innerHeight()}, 500);
						} 
					}
				);
				$(".groupe_lien_MH").mouseleave
				(
					function ()
					{
						$sublien=jQuery(this).find(".sublien_MH a");
						$groupe_sublien=jQuery(this).find(".groupe_sublien_MH");
						if (!$groupe_sublien.is(":hidden"))
						{
							jQuery(this).find(".groupe_sublien_MH").animate({height:'0px'},{duration : 500, complete : animation_complete});
							$sublien.animate({opacity:'hide'},{duration : 500});
							$bottom.animate({opacity:'hide'},{duration : 500});
							$top.animate({opacity:'hide'},{duration : 500});
						}
					}
				);
			}
		</script>
	</head>

	<body onload="jquery_MH_deroulant();">

		<div id="conteneur">

			<div id="CHG"></div><div id="CHD"></div><div id="BH"></div>
			<div id="BG"><div id="BD">

				<div id="corps">
					<div id="fond_MV">

						<div id="banniere"><div id="logo"></div></div>
							<?php require_once($_SESSION['File_Root'] ."/HTML/Left.php"); ?>
							<?php require($_SESSION['File_Root'] ."/HTML/Right.php"); ?>
							<div id="texte"><div id="overflow">
								<div class="cadre"><div class="titre">Titre du cadre</div><div class="marge_interne">