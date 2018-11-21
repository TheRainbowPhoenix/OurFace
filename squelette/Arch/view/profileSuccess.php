<?php
# @Author: uapv1701795
# @Date:   2018-11-20T13:30:40+01:00
# @Last modified by:   uapv1701795
# @Last modified time: 2018-11-20T15:47:35+01:00



if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
  die('Invalid');
}

  ?>


  <nav class="col col-lg-3 sidebar dashboard dashboard-left">
    <div class="BProfile">
      <div class="card-deck">
        <div class="card">
          <div class="SProfileCover card-img-top" style="<?php
          echo 'background-image: url('.genPP($context->user->avatar, $context->user->id).')';
          ?>"></div>
          <div class="card-body">
            <div class="d-flex account-small">
              <div class="avatar-container">
                <img class="avatar-image" src="<?php echo genPP($context->user->avatar, $context->user->id) ?>" alt="">
              </div>
              <div class="name-container flex-grow-1">
                <h5 class="card-title"><?php echo escape($context->user->nom)." ".escape($context->user->prenom) ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo "@".escape($context->user->identifiant) ?></h6>
              </div>
            </div>
            <p class="card-text"><?php echo escape($context->user->statut) ?></p>
          </div>
          <div class="card-footer">
            <small class="text-muted">Born the <?php echo genDate(escape($context->user->date_de_naissance)) ?></small>
          </div>
        </div>
      </div>
      <div class="BSug">
        <div class="card d-flex col-centered">
          <div class="card-header">
            Suggestions
          </div>
          <ul class="list-group list-group-flush">

            <?php echo genSuggestions($context->sug);?>

          </ul>
          <div class="card-body suggestions">
            <a href="?action=listUsers" class="card-link">View more</a>
          </div>
        </div>
      </div>
    </div>
  </nav>


  <div class="col posts-main">
    <div>

  <?php
  //var_dump($context->messages);
  //echo json_encode($context->messages);
  foreach ($context->messages as $message) {
    if(isset($message->second[0]) && isset($message->first) && $message->second[0]->image != null) {
      $id = $message->first->emetteur;
      $img = genImage($message->first->emetteur, $message->second[0]->image);
      $thumb = genThumb($id, $message->second[0]->image);
      $i = getimagesize($img);
      $com = 0;
      $likes = (isset($message->first) && $message->first->aime != NULL && is_numeric($message->first->aime))?$message->first->aime:0;
      $msg = (isset($message->second[0]))?escape($message->second[0]->texte):'';
      $date = (isset($message->second[0]))?genTimeDiff($message->second[0]->date):'times ago';
      $usr = $message->third[0];
      echo getPost($img, $likes, $com, $thumb, $id, $usr, $msg, $date);
    }
    //var_dump($message);
  }
?>
    </div>
</div>

<div class="col-lg-3" id="chats">
    chat
</div>
