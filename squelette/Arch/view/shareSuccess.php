<?php
  if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
    die('Invalid');
  }
?>
<div class="py-md-5 col-centered">
  <div class="embed-card">
    <?php
    $message = $context->message;
    $rt = (isset($message->fourth["Repost"]))?(count($message->fourth["Repost"])):(0);
    $com = (isset($message->fourth["Reply"]))?(count($message->fourth["Reply"])):(0);
    if(isset($message->second[0]) && isset($message->first) && $message->second[0]->image != null) {
      $pid = $message->first->id;
      $id = $message->first->emetteur;
      $img = genImage($message->first->emetteur, $message->second[0]->image);
      $thumb = genThumb($id, $message->second[0]->image);
      $i = getimagesize($img);
      $likes = (isset($message->first) && $message->first->aime != NULL && is_numeric($message->first->aime))?$message->first->aime:0;
      $msg = (isset($message->second[0]))?escape($message->second[0]->texte):'';
      $date = (isset($message->second[0]))?($message->second[0]->date):'times ago';
      $usr = $message->third[0];
      echo getPost($pid, $img, $likes, $com, $rt, $thumb, $id, $usr, $msg, $date, 1);
    } else {
      if(isset($message->second[0]) && isset($message->first)) {
        $pid = $message->first->id;
        $id = $message->first->emetteur;
        $img = null;
        $thumb = null;
        $likes = (isset($message->first) && $message->first->aime != NULL && is_numeric($message->first->aime))?$message->first->aime:0;
        $msg = (isset($message->second[0]))?escape($message->second[0]->texte):'';
        $date = (isset($message->second[0]))?($message->second[0]->date):'times ago';
        $usr = $message->third[0];
        echo getPost($pid, $img, $likes, $com, $rt, $thumb, $id, $usr, $msg, $date, 1);
      }
    }
    ?>
  </div>

</div>
