<?php

function escape($text) {
  $text = trim($text);
  $text = stripslashes($text);
  $text = htmlspecialchars($text, ENT_QUOTES);
  return $text;
}

function markup($text) {
  $text = html_entity_decode($text);

  //<a href="/hashtag/name" class="hastag"><s>#</s><b>TAG</b></a>
  $htag_re = '/\B#(\d*[0-9A-Za-z_]+\w*)\b(?!;)/m';
  preg_match_all($htag_re, $text, $matches, PREG_SET_ORDER, 0);
  $rep = array();
  foreach ($matches as $value=>$key) {
    $rep[$value] = '<a href="?action=hashtag&tag='.$key[1].'" class="hastag"><s>#</s><b>'.$key[1].'</b></a>';
    $matches[$value] = $key[0];
  }
  $text = str_replace($matches, $rep, $text);

  $mention_re = '/\B@(\w+)/m';
  preg_match_all($mention_re, $text, $matches, PREG_SET_ORDER, 0);
  $rep = array();
  foreach ($matches as $value=>$key) {
    $id = utilisateurTable::userHasName(escape($key[1]));
    if($id==false) $rep[$value] = '@'.$key[1];
    else $rep[$value] = '<a href="?action=profile&id='.$id.'" class="atmention"><s>@</s><b>'.$key[1].'</b></a>';
    $matches[$value] = $key[0];
  }
  $text = str_replace($matches, $rep, $text);

  $url_re = '/((http|https|ftp):\/\/\d*[^\s\/$.?#].[^\s]+\w*)/i';
  preg_match_all($url_re, $text, $matches, PREG_SET_ORDER, 0);
  $rep = array();
  foreach ($matches as $value=>$key) {
    if(filter_var($key[0], FILTER_VALIDATE_URL)) {
      $rep[$value] = '<a href="'.$key[0].'">'.$key[0].'</a>';
    } else {
      $rep[$value] = $key[0];
    }
    $matches[$value] = $key[0];
  }
  $text = str_replace($matches, $rep, $text);

  $code_re = '/```([^`]+)```/i';
  preg_match_all($code_re, $text, $matches, PREG_SET_ORDER, 0);
  $rep = array();
  foreach ($matches as $value=>$key) {
    $rep[$value] = '<code class="markup">'.$key[1].'</code>';
    $matches[$value] = $key[0];
  }
  $text = str_replace($matches, $rep, $text);


  return $text;
}

function genPP($text, $id) {
  if(isset($text) && !is_null($text)) {
    if(file_exists('profile-image/'.$text)) return 'profile-image/'.$text;
    if (filter_var($text, FILTER_VALIDATE_URL) !== false) return $text;
  }
  if (is_numeric($id)) {
    $f = 'profile-image/'.$id.'_400x400.jpg';
    if(file_exists($f)) return $f;
  }
  return "images/ico/def.svg";
}

function genDate($text) {
  $date = new DateTime($text);
  return date_format($date, 'd/m/Y');
}

function genImage($id, $text) {
  if(isset($text) && !is_null($text)) {
    if (file_exists('media/'.$id.'_'.$text)) return 'media/'.$id.'_'.$text;
    else {
      $imgExt = ['jpg', 'gif', 'png'];
foreach ($imgExt as $k => $ext) {
        if (file_exists('media/'.$id.'_'.$text.'.'.$ext)) return 'media/'.$id.'_'.$text.'.'.$ext;
      }
    }
    if (filter_var($text, FILTER_VALIDATE_URL) !== false) return $text;
  }
  return "images/ico/def.svg";
}

function genThumb($id, $text) {
  if(isset($text) && !is_null($text)) {
    $filen = explode('.',$text)[0];
    if (file_exists('media/'.$id.'_'.$filen.'_thumb.jpg')) return 'media/'.$id.'_'.$filen.'_thumb.jpg';
    else {
      if (file_exists('media/'.$id.'_'.$text.'_thumb.jpg')) return 'media/'.$id.'_'.$text.'_thumb.jpg';
    }
    if (filter_var($text, FILTER_VALIDATE_URL) !== false) return $text;
  }
  return "images/gif/load.gif";
}

function genCompose() {
  echo '<div class="compose affix-top">
        <div class="input-group">
          <input type="text" class="form-control" aria-label="Text input with segmented dropdown button">
          <div class="input-group-append">
            <button type="button" id="postBtn" class="btn btn-outline-secondary">Action</button>
            <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <a class="dropdown-item" href="#">Something else here</a>
              <div role="separator" class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Separated link</a>
            </div>
          </div>
        </div>
      </div>

      <div class="fixed-bottom">
        <div class="float-right action-button">
          <span class="icon icon-large icon-edit">
          </span>
        </div>
      </div>';
}

  function genFoot($likes, $com=0, $date)
  {
    echo '<div class="post-actions row">
      <div class="post-action">
        <span class="icon icon-like">
        </span>
  <span class="count">'.$likes.'</span>
      </div>
      <div class="post-action">
        <span class="icon icon-com">
        </span>
        <span class="count">'.$com.'</span>
      </div>
      <div class="card-link flex-grow-1 post-date">
        <small class="text-muted float-right">Last updated ';
        if ($date!=0) {
          echo genTimeDiff($date);
        } else echo 'times ago';
        echo '</small>
      </div>
    </div>';
  }

  function getPost($pid, $img, $likes, $com, $thumb, $id, $usr, $msg, $date)
  {
    echo '<div class="card post" data-id="'.$pid.'">';
    if($img!=null) {
    echo'<div class="post-image">
          <div class="post-image-align">
            <div class="post-image-contain">
              <a href="'.$img.'" data-toggle="lightbox" data-max-width="600" data-likes="'.$likes.'" data-com="'.$com.'">
                <img class="post-img card-img-top img-fluid lazy" alt="img" src="'.$thumb.'" data-src="'.$img.'">
              </a>
            </div>
          </div>
        </div>';
      }
      echo '<div class="card-body">
        <div class="d-flex account-small" data-user-id="'.$id.'">
          <div class="avatar-container">
      <img class="avatar-image" src="';
      if (isset($usr)) {
        echo genPP($usr->avatar, $id);
      } else {
        echo 'images/ico/def.svg';
      }
      echo '" alt="">
        </div>
        <div class="name-container flex-grow-1">
          <h5 class="card-title"><a href="?action=profile&id='.escape($usr->id).'">'.escape($usr->prenom).' '.escape($usr->nom).'</a></h5>
          <h6 class="card-subtitle mb-2 text-muted">@'.escape($usr->identifiant).'</h6>
        </div>
        <div class="floating-card" style="width: 18rem;"></div>
      </div>
      <p class="card-text">'.markup($msg).'</p>
    </div>
    <div class="card-footer">';
      echo genFoot($likes, $com, $date);
      echo '</div></div>';
  }

  function genLoadError($id) {
    echo '<div> <div class="card-body">
    <h5 class="card-title">Oh no !</h5>
    <p class="card-text">Automatic messages loading seems to be stuck ... Maybe you could try :</p>
    <a href="javascript:loadMoar(fmin(), '.$id.');" class="card-link">Reload</a>
    <a href="#" class="card-link">contact support</a>
  </div></div>';
  }

  function genSuggestions($sug) {
    foreach ($sug as $id => $user) {
      echo '<li class="list-group-item card-body">
      <div class="d-flex account-small" data-user-id="'.$user->id.'"/><div class="avatar-container">
        <img class="avatar-image" src="'.genPP($user->avatar, $user->id).'" alt="">
      </div>
      <div class="name-container flex-grow-1">
        <h5 class="card-title">'.escape($user->prenom).' '.escape($user->nom).'</h5>
        <h6 class="card-subtitle mb-2 text-muted">@'.escape($user->identifiant).'</h6>
      </div>
      <div class="floating-card" style="width: 18rem;"></div>
    </div></li>';
    }
    //var_dump($sug);
  }

  function genTimeDiff($time) {
    $now = strtotime(date("Y-m-d h:i:sa"));
    $last = strtotime($time);
    $diffMins = round(($now - $last) / 60);
    if($diffMins<60) return $diffMins.' minutes ago';
    else {
      $diffHours = round(($now - $last) / 3600);
      if($diffHours<24) return $diffHours.' hours ago';
      else {
        $diffDays = round(($now - $last) / 86400);
        if($diffDays<30) return $diffDays.' days ago';
        else {
          $diffMonth = round(($now - $last) / 2628000);
          if($diffMonth<12) return $diffMonth.' months ago';
          else {
            $diffYears = round(($now - $last) / 31536000);
            return $diffYears.' years ago';
          }
        }
      }
    }
  }

 ?>
