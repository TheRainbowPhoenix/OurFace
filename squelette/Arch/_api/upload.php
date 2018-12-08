<?php
session_start();
if(array_key_exists('logged', $_SESSION) && array_key_exists('user_var', $_SESSION)
&& $_SESSION['logged']==true && array_key_exists('id', $_SESSION['user_var'])) {
  $id = $_SESSION['user_var']['id'];

  $allowed_ext = array('jpeg', 'jpg', 'png', 'gif', 'bmp');
  if(isset($_FILES['img'])) {
    $filename = $_FILES['img']['name'];

    $filesize = $_FILES['img']['size'];
    $folder = "media/";
    $location = $folder.$filename;

    $imageFileType = strtolower(pathinfo($location ,PATHINFO_EXTENSION));
    $fesc = strtolower(preg_replace('/[^a-zA-Z0-9-_\.]/','',$filename));
    $name = sha1('_'.$fesc.date("Y-m-d H:i:s.u").rand(10,100000));
    //echo $name;
    //$to = $folder.$name.'.'.$imageFileType;
    $to = $folder.$name;

    if(in_array($imageFileType, $allowed_ext)) {

      $return_arr = array();

      if(move_uploaded_file($_FILES['img']['tmp_name'],$to)){
        $src = "default.png";

        // checking file is image or not
        if(is_array(getimagesize($to))){
          $src = $to;
        }
        $mimet = mime_content_type($src);
        list($width, $height, $type, $attr) = getimagesize($src);
        $image = array("image_type" => (isset($mimet))?$mimet:'application/octet-stream', "w" => $width, "h" => $height, "type" => $type);
        $return_arr = array("media_id" => $name, "name" => $filename,"size" => $filesize, "src"=> $src, "image" => $image);
      }
    } else {
      $return_arr = array();
    }


  } else {
    $return_arr = "error";
  }
  echo json_encode($return_arr);
} else {
  die('Bad Authentication data.');
}
/*
$allowed_ext = array('jpeg', 'jpg', 'png', 'gif', 'bmp');
$max_fileSize = 500000;
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["img"]["name"]);
$valid = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["img"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $valid = 1;
    } else {
        echo '{"errors":[{"code":400,"message":"Invalid file type"}]}';
        $valid = 0;
    }
}
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $valid = 0;
}
if ($_FILES["img"]["size"] > $max_fileSize) {
    echo '{"errors":[{"code":400,"message":"Invalid filesize"}]}';
    $valid = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo '{"errors":[{"code":400,"message":"Filetype not allowed"}]}';
    $valid = 0;
}
// Check if $valid is set to 0 by an error
if ($valid == 0) {
    echo '{"errors":[{"code":400,"message":"Upload failed"}]}';
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
      echo '{"media_id": "'.basename( $_FILES["img"]["name"]).'"}';
    } else {
        echo '{"errors":[{"code":400,"message":"Media processing error"}]}';
    }
}*/
/*

$filename = $_FILES['file']['name'];

$filesize = $_FILES['file']['size'];

$location = "upload/".$filename;

$return_arr = array();

if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
    $src = "default.png";

    // checking file is image or not
    if(is_array(getimagesize($location))){
        $src = $location;
    }
    $return_arr = array("name" => $filename,"size" => $filesize, "src"=> $src);
}

echo json_encode($return_arr);
 */
?>
