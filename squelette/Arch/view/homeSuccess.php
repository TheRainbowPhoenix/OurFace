<?php
# @Author: uapv1701795
# @Date:   2018-11-21T02:20:11+01:00
# @Last modified by:   uapv1701795
# @Last modified time: 2018-11-21T13:44:02+01:00



if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
  goLogin();
}
?>
  <script type="text/javascript">
  //If scrolled to bottom
  $(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
       loadMoar(fmin(), -1);
    }
  });
  </script>
  <nav class="col col-lg-3 sidebar dashboard dashboard-left draggable">
    <div class="ui-resizable-handle ui-resizable-e" style="z-index: 90;"></div>
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


  <div class="col posts-main draggable">
    <div class="ui-resizable-handle ui-resizable-e" style="z-index: 90;"></div>
    <?php genCompose(); ?>
    <div id="posts">

  <?php
  //var_dump($context->messages);
  //echo json_encode($context->messages);
  foreach ($context->messages as $message) {
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
      echo getPost($pid, $img, $likes, $com, $rt, $thumb, $id, $usr, $msg, $date);
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
        echo getPost($pid, $img, $likes, $com, $rt, $thumb, $id, $usr, $msg, $date);
      }
    }
    //var_dump($message);
  }
?>
    </div>
    <?php genLoadError(-1); ?>
</div>

<div class="col col-lg-3 draggable" id="chats">
  <div class="row fixed-chats ">
    <div class="ui-resizable-handle ui-resizable-e" style="z-index: 90;"></div>
              <div class="col col-lg-auto servers-container" style="
"><ul class="list-inline server-list">
        <li class="list-inline-item server-icon"><div class="avatar-container">
                    <img class="avatar-image" src="images/ico/def48.png" alt="">
                  </div></li>
        <li class="list-inline-item server-icon"><div class="avatar-container">
                    <img class="avatar-image" src="images/ico/def48.png" alt="">
                  </div></li>
        <li class="list-inline-item server-icon"><div class="avatar-container">
                    <img class="avatar-image" src="images/ico/def48.png" alt="">
                  </div></li>
      </ul></div>
              <div class="col">
                  <div class="card d-flex col-centered">
                    <div class="card-header">Chat 1</div>
                    <ul class="list-group list-group-flush">

                      <li class="list-group-item card-body">
                        <div class="d-flex" data-user-id="55">
                          <div class="avatar-container">
                            <img class="avatar-image" src="profile-image/55_400x400.jpg" alt="">
                          </div>
                          <div class="name-container flex-grow-1">
                            <h5 class="card-title">root root</h5>
                            <p class="card-subtitle mb-2">My message 1<br>with lines
      </p>
                          </div>
                          <div class="floating-card" style="width: 18rem;"></div>
                        </div>
                      </li>
                      <li class="list-group-item card-body">
                        <div class="d-flex" data-user-id="55">
                          <div class="avatar-container">
                            <img class="avatar-image" src="profile-image/55_400x400.jpg" alt="">
                          </div>
                          <div class="name-container flex-grow-1">
                            <h5 class="card-title">root root</h5>
                            <p class="card-subtitle mb-2">My message 1<br>with lines<br> and another
      </p>
                          </div>
                          <div class="floating-card" style="width: 18rem;"></div>
                        </div>
                      </li>
                      <li class="list-group-item card-body">
                        <div class="d-flex" data-user-id="55">
                          <div class="avatar-container">
                            <img class="avatar-image" src="profile-image/55_400x400.jpg" alt="">
                          </div>
                          <div class="name-container flex-grow-1">
                            <h5 class="card-title">root root</h5>
                            <p class="card-subtitle mb-2">My message 1<br>with lines</p>
                          </div>
                          <div class="floating-card" style="width: 18rem;"></div>
                        </div>
                      </li>
                    </ul>
                    <div class="card-body suggestions">
                      <div class="input-group">
                    <input type="text" class="form-control" aria-label="Text input with segmented dropdown button">
                    <div class="input-group-append">
                      <button type="button" class="btn btn-outline-secondary">Send</button>


                    </div>
                  </div>
                    </div>
                  </div>
              </div>
          </div>
    chat
</div>
