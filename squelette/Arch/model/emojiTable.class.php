<?php

class emojiTable extends basemodel {
  public function getProviders()
  {
    $list = array();
    $provider = array('dir' => 'images/emojis','name' => 'Arch' );
    array_push($list, $provider);
    $provider = array('dir' => 'images/default','name' => 'Default' );
    array_push($list, $provider);
    $provider = array('dir' => 'images/emojiOne2_1','name' => 'emojiOne 2.1' );
    array_push($list, $provider);
    return $list;
  }

  public function getEmoji($pid, $html=false, $url=false)
  {
    if(isset($pid)) {
      $providers = emojiTable::getProviders();
      foreach ($providers as $key => $provider) {
        $dir = $provider["dir"];
        $imgExt = ['jpg', 'gif', 'png'];
        foreach ($imgExt as $k => $ext) {
          if (file_exists($dir.'/'.$pid.'.'.$ext)) {
            if($html) {
              return '<img class="emoji inline" src="'.$dir.'/'.$pid.'.'.$ext.'" alt="'.$pid.'" draggable="false">';
	    } else if($url) {
	      return $dir.'/'.$pid.'.'.$ext;
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
