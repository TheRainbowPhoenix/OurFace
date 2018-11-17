<?php
  if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
    die('Invalid');
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
