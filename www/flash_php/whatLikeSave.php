<?php

require_once('config.php');

$_GET['pid']='flash';
$_GET['sp']='whatLike';
$_GET['add']='1';
chdir(FLASH_DIR);
require_once('index.php');


/*
$saveHash = $_POST['saveHash'];
$title = $_POST['title'];
$content = $_POST['content'];
$categoryId = $_POST['categoryId'];
$boxId = $_POST['boxId'];

$imageWidth = 74;
$normalPath = "";
$miniaturePath = "";

$dir = "assets/whatLike/images/";
$fileExist = count( $_FILES );

if( $fileExist ){
$fileName = $_FILES['Filedata']['name'];
$ext = explode( '.', $fileName );
$ext = $ext[ count( $ext )-1 ];

$normalPath = $dir."normal/".$saveHash.".".$ext;
$miniaturePath = $dir."miniature/".$saveHash.".".$ext;

move_uploaded_file($_FILES['Filedata']['tmp_name'], "../".$normalPath );
move_uploaded_file($_FILES['FiledataMiniature']['tmp_name'], "../".$miniaturePath );
	
   
		//create normal size
		#if( $ext == "jpg" || $ext=="JPG" || $ext == "jpeg" || $ext=="JPEG" ) $source_image = imagecreatefromjpeg("../".$normalPath);
		#else if( $ext == "png" || $ext=="PNG" ) $source_image = imagecreatefrompng("../".$normalPath);
		#else if( $ext == "gif" || $ext=="GIF" ) $source_image = imagecreatefromgif("../".$normalPath);
		#$width = imagesx($source_image);
		#$height = imagesy($source_image);
		#$desired_height = floor($height*($imageWidth/$width));
		#$virtual_image = imagecreatetruecolor($imageWidth,$desired_height);
		
		#if( $ext=='png' || $ext=='PNG' ){
		#	imagesavealpha($virtual_image, true);
		#	$trans_colour = imagecolorallocatealpha($virtual_image, 0, 0, 0, 127);
		#	imagefill($virtual_image, 0, 0, $trans_colour);
		#}
		
		#imagecopyresized($virtual_image, $source_image,0,0,0,0,$imageWidth,$desired_height,$width,$height);
		#if( $ext == "jpg" || $ext=="JPG" || $ext == "jpeg" || $ext=="JPEG"  ) imagejpeg($virtual_image,"../".$miniaturePath);
		#else if( $ext == "png" || $ext=="PNG" ) imagepng($virtual_image,"../".$miniaturePath);
		#else if( $ext == "gif" || $ext=="GIF" ) imagegif($virtual_image,"../".$miniaturePath);
	
}
	$e = "
	<root>
		<normalPath>$normalPath</normalPath>
		<miniaturePath>$miniaturePath</miniaturePath>
		<title><![CDATA[$title]]></title>
		<content><![CDATA[$content]]></content>
	</root>
	";
	echo $e;
*/
