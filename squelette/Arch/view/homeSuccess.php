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
  $( document ).ready(function () {
    //refresh posts
    chkpst = setInterval(checkAll, 30000);
  });
  //check new posts
  function checkAll() {
    loadNew(fmax(), -1);
    loadChat(cmax());
  }
  //If scrolled to bottom
  $(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
       loadMoar(fmin(), -1);
    }
  });
  </script>
  <nav class="col col-lg-3 sidebar dashboard dashboard-left draggable mob-hidden">
    <div class="ui-resizable-handle ui-resizable-e" style="z-index: 90;"></div>
    <div class="BProfile">
      <div class="card-deck">
        <div class="card">
          <?php genProfile($context->user, true) ?>
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
    <div class="col col-lg-auto servers-container" id="_genchat">
      <h5>Chat loading . . .</h5>

    </div>
  </div>
</div>
