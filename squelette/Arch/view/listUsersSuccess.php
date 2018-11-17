<?php
  if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
    die('Invalid');
  }

  function escape($text) {
    $text = trim($text);
    $text = stripslashes($text);
    $text = htmlspecialchars($text, ENT_QUOTES);
    return $text;
  }
  function genPP($text, $id) {
    if(isset($text) && !is_null($text) && file_exists('profile-image/'.$text)) return 'profile-image/'.$text;
    $f = 'profile-image/'.$id.'_400x400.jpg';
    if(file_exists($f)) return $f;
    else return "images/ico/def48.png";
  }
  function genDate($text) {
    $date = new DateTime($text);
    return date_format($date, 'd/m/Y');
  }

  ?>
  <div class="card d-flex col-centered" style="min-width: 300px;">
    <div class="card-header">
      Users
    </div>
    <ul class="list-group list-group-flush">

  <?php

  foreach ($context->users as $user) {
    echo '<li class="list-group-item card-body">';
    //echo json_encode($user);
    echo '
<div class="d-flex account-small">
  <div class="avatar-container">
    <img class="avatar-image" src="'.genPP($user->avatar, $user->id).'" alt="">
  </div>
  <div class="name-container flex-grow-1">
    <h5 class="card-title">'.escape($user->prenom).' '.escape($user->nom).'</h5>
    <h6 class="card-subtitle mb-2 text-muted">@'.escape($user->identifiant).'</h6>
  </div>
</div>
    ';
    echo '</li>';
  }

?>
  </ul>
</div>
