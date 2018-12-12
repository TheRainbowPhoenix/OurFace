<?php
  if (is_null($context->logged) || !$context->logged) {
    die('Invalid');
  }
?>

<script type="text/javascript">
  $( document ).ready(function () {
    //refresh posts
    pollChat(cmax());
    //chkpst = setInterval(checkAll, 30000);
  });
  //check new posts
  function checkAll() {
    //loadChat(cmax());
  }
</script>

<nav class="col col-lg-3 sidebar dashboard dashboard-left mob-hidden">
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
              <h5 class="card-title"><?php
              echo '<a href="?action=profile&id='.escape($context->user->id).'">'.escape($context->user->prenom).' '.escape($context->user->nom).'</a>'; ?></h5>
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

<div class="col" id="_genchat">
    <h5 class="load-msg">Chat loading . . .</h5>
</div>
