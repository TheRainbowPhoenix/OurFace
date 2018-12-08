<?php

class emojiTable extends basemodel {
  public function getProviders()
  {
    $provider = array('dir' => 'images/emojis','name' => 'Arch' );
    $provider = array('dir' => 'images/default','name' => 'Default' );
    $list = array(0 => $provider);
    return $list;
  }

  public function getEmoji($pid, $html=false)
  {
    if(is_numeric($pid)) {
      $imgExt = ['jpg', 'gif', 'png'];
      foreach ($imgExt as $k => $ext) {
        //echo 'images/'.$pid.'.'.$ext;
        if (file_exists('images/emojis/'.$pid.'.'.$ext)) {
          if($html) {
            return '<img class="emoji inline" src="'.'images/emojis/'.$pid.'.'.$ext.'" alt="'.$pid.'" draggable="false">';
          } else {
            $rtrn = array('id' => $pid, 'src' => 'images/emojis/'.$pid.'.'.$ext);
            return json_encode($rtrn);
          }
        }
      }
    }
    return false;
  }
}
