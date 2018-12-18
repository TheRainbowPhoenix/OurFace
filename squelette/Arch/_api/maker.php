<?php

class maker
{

  public static function modal($params) {
    echo '<div class="modal fade" id="embedLinkChat" tabindex="-1" role="dialog" aria-labelledby="linkChatAdd" aria-hidden="true" styles="    z-index: 999;
      position: absolute;
      margin: 8px;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Recipient:</label>
              <input type="text" class="form-control" id="recipient-name">
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Message:</label>
              <textarea class="form-control" id="message-text"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Send message</button>
        </div>
      </div>
    </div>
  </div>';
  }

  public static function chat($params) {
    maker::modal($params);
    $mostac = chatTable::getMostActive();
    $estack = array();
    $chat_name = "Public chat";
    echo '<div class="col col-lg-auto servers-container"><ul class="list-inline server-list">';
    foreach ($mostac as $key => $acc) {
      $id = $acc["emetteur"];
      $_emtr = utilisateurTable::getUserById($id);
      echo '<li class="list-inline-item server-icon"><a href="?action=profile&id='.escape($id).'"><div class="avatar-container">';
      echo '<img class="avatar-image" src="'.genPP($_emtr[0]->avatar, $id).'" alt="">';
      echo ' </a></div></li>';
    }
    echo '</ul></div>';
    echo '<div class="col chat-block"><div class="card d-flex col-centered"><div class="card-header" id="chat-toggle">';
    echo $chat_name;
    echo '</div><div class="chat-container"><ul class="list-group list-group-flush chat-posts">';
    $cstack = array();
    $_chats = chatTable::getChatLimit();
    foreach (array_reverse($_chats) as $chat) {
      $_pst = postTable::getPostById($chat->post);
      $_emtr = utilisateurTable::getUserById($chat->emetteur);
      if($chat->post && isset($_pst) && isset($_emtr)) {
        $pid = $chat->id;
        $id = $chat->emetteur;
        if($_pst[0]->image != null) {
          $img = genImage($chat->emetteur, $_pst[0]->image);
          $thumb = genThumb($id, $_pst[0]->image);
        } else {
          $img = null;
          $thumb = null;
        }
        $msg = (isset($_pst[0]))?escape($_pst[0]->texte):'';
	$usr = $_emtr[0];
	$dat = $_pst[0]->date;
        $reported = $_pst[0]->reported;
        getChat($pid, $img, $thumb, $id, $usr, $msg, $dat, $reported);
        /*$tmp = new Compose($chat, $_pst, $_emtr);
        array_push($cstack, $tmp);*/
      }
    }
    echo '</ul>';
    echo genChatCompose();
  }
}

//var_dump(json_encode($_SESSION));
//var_dump(utilisateurTable::getUsers());
 ?>
