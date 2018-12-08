<?php



class emojiTable extends basemodel {
  public function getProviders()
  {
    $list = array();
    $provider = array('dir' => 'images/emojis','name' => 'Arch' );
    array_push($list, $provider);
    $provider = array('dir' => 'images/default','name' => 'Default' );
    array_push($list, $provider);
    return $list;
  }

  public function getEmoji($pid, $html=false)
  {
    if(isset($pid)) {
      $providers = emojiTable::getProviders();
      foreach ($providers as $key => $provider) {
        $dir = $provider["dir"];
        $imgExt = ['jpg', 'gif', 'png'];
        foreach ($imgExt as $k => $ext) {
          //echo 'images/'.$pid.'.'.$ext;
          if (file_exists($dir.'/'.$pid.'.'.$ext)) {
            if($html) {
              return '<img class="emoji inline" src="'.$dir.'/'.$pid.'.'.$ext.'" alt="'.$pid.'" draggable="false">';
            } else {
              $rtrn = array('id' => $pid, 'src' => $dir.'/'.$pid.'.'.$ext);
              return json_encode($rtrn);
            }
          }
        }
      }
    }
    return false;
  }
}
