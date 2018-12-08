<?php
function genBlanc($im) {
	$im = imagecreatetruecolor (150, 30);
	$bgc = imagecolorallocate ($im, 255, 255, 255);
	$tc = imagecolorallocate ($im, 0, 0, 0);

	imagefilledrectangle ($im, 0, 0, 150, 30, $bgc);
	imagestring ($im, 1, 5, 5, 'Error loading ' . $imgname, $tc);
	return $im;
}

function LoadGif($img)
{
	$im = @imagecreatefromgif($img);
	if(!$im) return genBlanc($im);
	$sx = imagesx($im);
	$sy = imagesy($im);
	$dg = ($sx/$sy)*256;
	$i = imagecreatetruecolor($dg, 256);
	imagecopyresized($i, $im, 0, 0, 0, 0, $dg, 256, $sx, $sy);
	return $im;
}

function LoadPng($img) {
	$im = @imagecreatefrompng($img);
	if(!$im) return genBlanc($im);
	$sx = imagesx($im);
	$sy = imagesy($im);
	$dg = ($sx/$sy)*256;
	$i = imagecreatetruecolor($dg, 256);
	imagecopyresized($i, $im, 0, 0, 0, 0, $dg, 256, $sx, $sy);
	return $i;
}


function LoadJpg($img) {
	$im = @imagecreatefromjpeg($img);
	if(!$im) return genBlanc($im);
	$sx = imagesx($im);
	$sy = imagesy($im);
	$dg = ($sx/$sy)*256;
	$i = imagecreatetruecolor($dg, 256);
	imagecopyresized($i, $im, 0, 0, 0, 0, $dg, 256, $sx, $sy);
	return $i;
}

$id = '2';
$name = '5ec6d5605d0c';
$ext = 'gif';
//header('Content-Type: image/gif');
$imgMimes = ['image/gif', 'image/png', 'image/jpeg', 'image/bmp'];

if(1) {

	$files = scandir('../media/');
	foreach($files as $file) {
		$p = explode('.', $file);
		$s = explode('_thumb', $file);
		if(array_key_exists('1', $s)) $p[0] = null;
		if($p[0]!=null) {
			echo '../media/'.$p[0].'.'.$p[1].'<br>';
			if($p[1]=='gif') {
				$img = LoadGif('../media/'.$p[0].'.'.$p[1]);
			       	imagegif($img, '../media/'.$p[0].'_thumb.jpg');
			}
			if($p[1]=='jpg') {
				$img = LoadJpg('../media/'.$p[0].'.'.$p[1]);
				imagejpeg($img, '../media/'.$p[0].'_thumb.jpg');
			}
			if(is_array($p) && !array_key_exists(1, $p)) {
				$mime = mime_content_type('../media/'.$p[0]);
				foreach ($imgMimes as $k => $ext) {
					if ($ext == $mime) {
						if($ext == 'image/jpeg') {
							$img = LoadJpg('../media/'.$p[0]);
							imagejpeg($img, '../media/'.$p[0].'_thumb.jpg');
						}
						if($ext == 'image/gif') {
							$img = LoadGif('../media/'.$p[0]);
							imagejpeg($img, '../media/'.$p[0].'_thumb.jpg');
						}
						if($ext == 'image/png') {
							$img = LoadPng('../media/'.$p[0]);
							imagejpeg($img, '../media/'.$p[0].'_thumb.jpg');
						}
					}
				}
			}
		}
		//$img = LoadGif('../media/'.$id.'_'.$name.'.'.$ext);

		//imagegif($img, $id.'_'.$name.'_thumb.jpg');
		//imagedestroy($img);
	}
}
