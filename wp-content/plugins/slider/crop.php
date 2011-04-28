<?php
	$targ_w = 940;
	$targ_h = 200;
	$jpeg_quality = 90;

	$coordx = $_GET['coordx'];
	$coordy = $_GET['coordy'];
	
	$coordx2 = $_GET['coordx2'];
	$coordy2 = $_GET['coordy2'];
	
	$width = $coordx2 - $coordx;
	$height = $coordy2 - $coordy;
	
	$image = "uploads/" . $_GET['image'];
	$img_r = imagecreatefromjpeg($image);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	//imagecopyresampled(fichier de destination, image source, x nvo, y nvo, x choisi, y choisi, largeur voulue, hauteur voulue, largeur sel, hauteur sel);
	imagecopyresampled($dst_r, $img_r, 0, 0, $coordx, $coordy, $targ_w, $targ_h, $width, $height);
	imagejpeg($dst_r, $image, $jpeg_quality);
	
	//echo '<img src="'.$image.'" />';
?>