<?php
# @Author: uapv1701795
# @Date:   2018-11-20T13:30:40+01:00
# @Last modified by:   uapv1701795
# @Last modified time: 2018-11-26T16:08:04+01:00



if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
  die('Please login');
}
  ?>

  <script type="text/javascript">
  $( document ).ready(function () {
    //refresh posts
    chkpst = setInterval(checkAl, 45000);
  }
  //check new posts
  function checkAll() {
    loadChat(cmax());
    loadNew(fmax(), <?php echo $context->id?>);
  }
  //If scrolled to bottom
  $(window).scroll(function() {
    if((fmin()-1)==0) return;
    if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
       loadMoar(fmin(), <?php echo $context->id?>);
    }
  });
  </script>
  <nav class="col col-lg-3 sidebar dashboard dashboard-left">
    <div class="BProfile">
      <div class="card-deck">
        <div class="card">

          <?php if($context->user->id == $context->c_id) genProfile($context->user, true);
          else  genProfile($context->user, false); ?>

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
    <?php genCompose(); ?>
    <div id="posts">

  <?php
  //var_dump($context->messages);
  //echo json_encode($context->messages);
  foreach ($context->messages as $message) {
    $rt = (isset($message->fourth["Repost"]))?(count($message->fourth["Repost"])):(0);
    $com = (isset($message->fourth["Reply"]))?(count($message->fourth["Reply"])):(0);
    if(isset($message->first)) {
      //var_dump($message->first);
      $pid = $message->first->id;
      $id = $message->first->emetteur;
      if(isset($message->second[0]) && $message->second[0]->image != null) {
        $img = genImage($message->first->emetteur, $message->second[0]->image);
        $thumb = genThumb($id, $message->second[0]->image);
      } else {
        $img = null;
        $thumb = null;
      }
      $likes = (isset($message->first) && $message->first->aime != NULL && is_numeric($message->first->aime))?$message->first->aime:0;
      $msg = (isset($message->second[0]))?escape($message->second[0]->texte):'';
      $date = (isset($message->second[0]))?genTimeDiff($message->second[0]->date):'times ago';
      $usr = $message->third[0];
      echo getPost($pid, $img, $likes, $com, $rt, $thumb, $id, $usr, $msg, $date);

    }
    //var_dump($message);
  }
?>
    </div>
</div>

<div class="col-lg-3" id="chats">
<div class="row fixed-chats ">
  <div class="col col-lg-auto servers-container" id="_genchat">
    <h5>Chat loading . . .</h5>
  </div>
</div>
</div>
