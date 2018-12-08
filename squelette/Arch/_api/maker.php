<?php

class maker
{

  public static function chat($params) {
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
      if(isset($_pst) && isset($_emtr)) {
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
        getChat($pid, $img, $thumb, $id, $usr, $msg);
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
