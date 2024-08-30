<?php
	session_start();
	$liste = "abcdefghij123456789yxzABCDEFGHIJKLMNOPQRSTUVWXYZklmnopqrstuvw";
	$code = '';
	while(strlen($code) != 6) 
	{
	   $code .= $liste[rand(0,61)];
	}
	$_SESSION['sdcapt']=$code; 
	$img = imageCreate(70, 20) or die ("Problème de création GD");
	$background_color = imagecolorallocate ($img, 238, 238, 238);
	$ecriture_color = imagecolorallocate ($img, 0, 0, 0);
	$code_police=25;
	header('Cache-Control: no-store, no-cache, must-revalidate'); 
	header('Cache-Control: post-check=0, pre-check=0', false); 
	header("Content-type: image/jpeg");
	imageString($img, $code_police,(70-imageFontWidth($code_police) * strlen("".$code.""))/2,0, $code,$ecriture_color);
	imagejpeg($img,'',30);
	imageDestroy($img);
?>