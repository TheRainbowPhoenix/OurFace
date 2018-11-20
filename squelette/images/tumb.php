<?php
function LoadGif($imgname)
{
    /* Tente d'ouvrir l'image */
    $im = @imagecreatefromgif($imgname);

    /* Traitement si l'ouverture a échoué */
    if(!$im)
    {
        /* Création d'une image vide */
        $im = imagecreatetruecolor (150, 30);
        $bgc = imagecolorallocate ($im, 255, 255, 255);
        $tc = imagecolorallocate ($im, 0, 0, 0);

        imagefilledrectangle ($im, 0, 0, 150, 30, $bgc);

        /* Affiche un message d'erreur dans l'image */
        imagestring ($im, 1, 5, 5, 'Error loading ' . $imgname, $tc);
    }

    return $im;
}

$id = '2';
$name = '5ec6d5605d0c';
$ext = 'gif';
//header('Content-Type: image/gif');

if(0) {

  $files = scandir('../media/');
  foreach($files as $file) {
    $p = explode('.', $file);
    if($p[0]!=null) {
      echo '../media/'.$p[0].'.'.$p[1].'<br>';
      $img = LoadGif('../media/'.$p[0].'.'.$p[1]);
      imagegif($img, '../media/'.$p[0].'_thumb.jpg');
    }
  }
}

$img = LoadGif('../media/'.$id.'_'.$name.'.'.$ext);

imagegif($img, $id.'_'.$name.'_thumb.jpg');
//imagedestroy($img);
?>
