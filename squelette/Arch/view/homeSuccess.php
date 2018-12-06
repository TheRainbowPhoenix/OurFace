<?php
# @Author: uapv1701795
# @Date:   2018-11-21T02:20:11+01:00
# @Last modified by:   uapv1701795
# @Last modified time: 2018-11-26T16:00:09+01:00



if (!$context->logged) {
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
            <a href="#" id="profile-desc"><p class="card-text" id="profile-desc-text"><?php echo escape($context->user->statut) ?></p></a>
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
      <div class="col col-lg-auto servers-container">
        <ul class="list-inline server-list">
            <?php
            //var_dump($context->mostac);
            if(!is_null($context->mostac) && is_array($context->mostac)) {
              foreach ($context->mostac as $acc) {
                echo '<li class="list-inline-item server-icon">
                       <a href="?action=profile&id='.escape($acc['id']).'">
                         <div class="avatar-container">';
                echo '<img class="avatar-image" src="'.genPP($acc['avatar'], $acc['id']).'" alt="">';
                echo ' </a></div>
                     </li>';
              }
            }
            ?>
          </ul>
              </div>
              <div class="col">
                  <div class="card d-flex col-centered">
                    <div class="card-header">Chat 1</div>
                    <ul class="list-group list-group-flush chat-posts">

                      <?php // foreach

                      foreach ($context->chats as $chat) {
                        //var_dump($chat);
                        if(isset($chat->first) && isset($chat->second) && isset($chat->third) && is_array($chat->second) && array_key_exists(0, $chat->second) && array_key_exists(0, $chat->third)) {
                          $pid = $chat->first->id;
                          $id = $chat->first->emetteur;
                          if($chat->second[0]->image != null) {
                            $img = genImage($chat->first->emetteur, $chat->second[0]->image);
                            $thumb = genThumb($id, $chat->second[0]->image);
                          } else {
                            $img = null;
                            $thumb = null;
                          }
                          $msg = (isset($chat->second[0]))?escape($chat->second[0]->texte):'';
                          $usr = $chat->third[0];
                          //var_dump($usr);
                          getChat($pid, $img, $thumb, $id, $usr, $msg);
                        }
                        //var_dump($message);
                      }


                      ?>
                    </ul>
                    <div class="card-body suggestions">
                      <div class="input-group">
                    <input type="text" id="chat_in" class="form-control" aria-label="Text input with segmented dropdown button">
                    <div class="input-group-append">
                      <button type="button" id="chatm" class="btn btn-outline-secondary">Send</button>


                    </div>
                  </div>
                    </div>
                  </div>
              </div>
          </div>
</div>
