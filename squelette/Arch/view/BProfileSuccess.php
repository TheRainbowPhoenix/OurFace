<?php
# @Author: uapv1701795
# @Date:   2018-11-18T00:14:45+01:00
# @Last modified by:   uapv1701795
# @Last modified time: 2018-11-27T13:41:05+01:00

  if (!$context->logged || !$context->current_user) {
    die('Invalid');
  }
?>
<div class="BProfile">
  <div class="card-deck">
    <div class="card">
      <div class="SProfileCover card-img-top" style="<?php
      echo 'background-image: url('.genPP($context->current_user["avatar"], $context->current_user['id']).')';
      ?>"></div>
      <div class="card-body">
        <div class="d-flex account-small">
          <div class="avatar-container">
            <img class="avatar-image" src="<?php echo genPP($context->current_user["avatar"], $context->current_user['id']) //images/ico/def48.png ?>" alt="">
          </div>
          <div class="name-container flex-grow-1">
            <h5 class="card-title"><?php echo escape($context->current_user["nom"])." ".escape($context->current_user["prenom"]) ?></h5>
            <h6 class="card-subtitle mb-2 text-muted"><?php echo "@".escape($context->current_user["identifiant"]) ?></h6>
          </div>
        </div>
        <p class="card-text"><?php echo escape($context->current_user["statut"]) ?></p>
      </div>
      <div class="card-footer">
        <small class="text-muted">Born the <?php echo genDate(escape($context->current_user["date_de_naissance"])) ?></small>
      </div>
    </div>
  </div>
</div>
