<?php
# @Author: uapv1701795
# @Date:   2018-11-26T01:49:54+01:00
# @Last modified by:   uapv1701795
# @Last modified time: 2018-11-26T16:17:06+01:00


function replaceAll($text) {
  $text = str_replace('<','&lt;', $text);
  $text = str_replace('>','&gt;', $text);
  //$text = str_replace('&amp;#039;', '&#039;', $text);
  $text = str_replace('&amp;hearts;','&hearts;', $text);
  //$text = str_replace('&amp;eacute;','&eacute;', $text);
  //$text = str_replace('&amp;euml;','&euml;', $text);
  //$text = str_replace('&amp;', '&', $text);
  //echo $text;
  return $text;
}


function escape($text) {
  $text = trim($text);
  $text = stripslashes($text);
 // echo $text;
  $text = htmlentities($text, ENT_QUOTES);
  $text = htmlspecialchars($text, ENT_HTML5);
  $text = html_entity_decode($text,ENT_QUOTES | ENT_HTML5);
  $text = replaceAll($text);
  return $text;
}

function markup($text) {
  $text = html_entity_decode($text);
  $text = replaceAll($text);
  // [^``` ]+|(```[^`]*```) <- select not in code block

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

  $url_re = '/((http|https|ftp):\/\/\d*[^\s\/$.?#].[^\s&">]+\w*)/i';
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
    $imgMimes = ['image/gif', 'image/png', 'image/jpeg', 'image/bmp'];
    if(file_exists('media/'.$text)) {
      $mime = mime_content_type('media/'.$text);
      foreach ($imgMimes as $k => $ext) {
        if ($ext == $mime) return 'media/'.$text;
      }
    }
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
      $imgMimes = ['image/gif', 'image/png', 'image/jpeg', 'image/bmp'];
      if(file_exists('media/'.$text)) {
        $mime = mime_content_type('media/'.$text);
        foreach ($imgMimes as $k => $ext) {
          if ($ext == $mime) {
            return 'media/'.$text;
          }
        }
      }
    }
    if (filter_var($text, FILTER_VALIDATE_URL) !== false) return $text;
    if (file_exists('/nfs/nas02a_etudiants/inf/uapv1701704/public_html/'.$text)) return '../../~uapv1701704/'.$text;
  }
  return "images/ico/def.svg";
}

function genThumb($id, $text) {
  if(isset($text) && !is_null($text)) {
    $filen = explode('.',$text)[0];
    if (file_exists('media/'.$id.'_'.$filen.'_thumb.jpg')) return 'media/'.$id.'_'.$filen.'_thumb.jpg';
    else {
      if (file_exists('media/'.$id.'_'.$text.'_thumb.jpg')) return 'media/'.$id.'_'.$text.'_thumb.jpg';
      if (file_exists('media/'.$text.'_thumb.jpg')) return 'media/'.$text.'_thumb.jpg';
      if (file_exists('media/'.$text.'_thumb')) return 'media/'.$text.'_thumb';
    }
    if (filter_var($text, FILTER_VALIDATE_URL) !== false) return $text;
  }
  return "images/gif/load.gif";
}

function genProfile($user, $editable=false) { //$pid, $img, $likes, $com, $rt, $thumb, $id, $usr, $msg, $date, $protected=0
  if(isset($user) && !empty($user) && is_numeric($user->id) && $user->id>=0) {
    echo'<div class="SProfileCover card-img-top" style="background-image: url('.genPP($user->avatar, $user->id).')"></div>';
    echo '<div class="card-body">
      <div class="d-flex account-small">
        <div class="avatar-container">';
        if($editable) echo '<a href="#" id="profile-picture" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">';
          echo '<img class="avatar-image" src="'.genPP($user->avatar, $user->id) .'" alt="">';
          if($editable) echo '</a>
          <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
            <div class="dropdown-item image-selector">
              <label class="uploadPP-label">
                <span class="u-hiddenVisually">Upload image</span>
                <input type="file" name="media[]" id="mediaPP" class="file-input inputPP" tabindex="-1" accept="image/gif,image/jpeg,image/jpg,image/png">
              </label>
            </div>
            <button class="dropdown-item" type="button">Add from url</button>
            <div role="separator" class="dropdown-divider"></div>
            <button class="dropdown-item" type="button">Cancel</button>
          </div>';

        echo '</div>
        <div class="name-container flex-grow-1">
          <h5 class="card-title"><a href="?action=profile&id='.escape($user->id).'">'.escape($user->prenom).' '.escape($user->nom).'</a></h5>
          <h6 class="card-subtitle mb-2 text-muted">@'.escape($user->identifiant).'</h6>
        </div>
      </div>';
      if($editable) echo '<a href="#" id="profile-desc">';
      echo '<p class="card-text" id="profile-desc-text">'.escape($user->statut).'</p>';
      if($editable) echo '</a>';
      echo '</div>
    <div class="card-footer">
      <small class="text-muted">Born the '.genDate(escape($user->date_de_naissance)).'</small>
    </div>';
  }
}

function genChatCompose() {
  echo '<div class="card-body suggestions">
    <div class="input-group">
      <div class="input-group-prepend dropup">
        <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu" x-placement="bottom-start">
          <div class="dropdown-item image-selector">
            <label class="uploadChat-label">
              <span class="u-hiddenVisually">Add media</span>
              <input type="file" name="media[]" id="mediaChat" class="file-input inputChat" tabindex="-1" accept="image/gif,image/jpeg,image/jpg,image/png">
            </label>
          </div>
          <a id="linkChatAdd" class="dropdown-item" href="#">Embed link</a>
          <div role="separator" class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Cancel</a>
        </div>
      </div>
      <input type="text" id="chat_in" class="form-control" aria-label="Enter your message">
      <div class="input-group-append">
        <button type="button" id="chatm" class="btn btn-outline-secondary">Send</button>
      </div>
    </div>
  </div>';
}

//254
// <input type="text" class="form-control" aria-label="Text input with segmented dropdown button">
function genCompose() {
  echo '<div class="compose affix-top">
        <div class="input-group">
        <textarea class="form-control" rows="5" maxlength="254" id="comment" aria-label="Clic to compose your message . . ."></textarea>
          <div class="input-group-append">
            <button type="button" id="postBtn" class="btn btn-outline-secondary">Send</button>
            <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu">
              <a id="mediaAdd" class="dropdown-item" href="#">Add media</a>
              <a class="dropdown-item" href="#">Another action</a>
              <a class="dropdown-item" href="#">Something else here</a>
              <div role="separator" class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Separated link</a>
            </div>
          </div>
        </div>
      </div>

      <div class="fixed-bottom">
        <button type="button" class="float-right action-button" data-toggle="modal" data-target="#composeModal">
          <span class="icon icon-large icon-edit">
          </span>
        </button>
      </div>

      <div class="modal fade" id="composeModal" tabindex="-1" role="dialog" aria-labelledby="composeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="composeModalLabel">Compose</h5>
              <!--button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button-->
            </div>
            <div class="modal-body">
              <div class="container compose-m-body">
                <div class="row">
                  <div class="col">
                    <textarea class="form-control" rows="5" maxlength="254" id="commentm" aria-label="Clic to compose your message . . ."></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" id="sendm" class="btn btn-primary">Send</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="uploadModalLabel">Compose</h5>
              <!--button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button-->
            </div>
            <div class="modal-body">
              <div class="container compose-m-body">
                <div class="row">
                  <div class="col">
                    <textarea class="form-control" rows="5" maxlength="254" id="uploadM" aria-label="Clic to compose your message . . ."></textarea>
                    <div class="container upload-handler" >
                        <input type="file" name="img" id="img" class="hiden">
                        <div class="upload-area"  id="uploadfile">
                            <h5 id="dragText">Drop your medias here</h5>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" id="usendm" class="btn btn-primary">Send</button>
            </div>
          </div>
        </div>
      </div>

      ';
}

  function genFoot($likes, $com=0, $rt=0, $id=0, $date, $protected=0)
  {
    echo '<div class="post-actions row">
      <div class="post-action action-like">
        <span class="icon icon-like">
        </span>
  <span class="count">'.$likes.'</span>
      </div>
      <div class="post-action action-reply">
        <span class="icon icon-com">
        </span>
        <span class="count">'.$com.'</span>
      </div>
      <div class="post-action action-rt">
        <span class="icon icon-rt">
        </span>
        <span class="count">'.$rt.'</span>
      </div>';
      if($protected==0) echo ' <div class="post-action">
      <a class="share-link" href="?action=share&id='.$id.'">
        <span class="icon icon-share">
        </span>
        <span class="share-text count">share</span></a>
      </div>';
      echo '<div class="card-link flex-grow-1 post-date">
        <small class="text-muted float-right"> ';
        if ($date!=0) {
          echo genTimeDiff($date);
        } else echo 'times ago';
        echo '</small>
      </div>
    </div>';
  }

  function getChat($pid, $img, $thumb, $id, $usr, $msg) {
    //var_dump($usr);
  echo '<li class="list-group-item card-body">
         <div class="d-flex chat" data-user-id="'.$id.'" data-id="'.$pid.'">
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
               <h5 class="card-title"><a href="?action=profile&amp;id='.escape($usr->id).'">'.escape($usr->prenom).' '.escape($usr->nom).'</a></h5>
               <p class="card-subtitle mb-2">'.markup($msg).'</p>';
  if(isset($img) && ($img!='')) {
              echo '<div class="post-image">
                  <div class="post-image-align">
                     <div class="post-image-contain">
                        <a href="'.$img.'" data-type="image" data-toggle="lightbox" data-max-width="600" data-likes="-1" data-com="-1"><img class="post-img card-img-top img-fluid lazy" alt="img" src="'.$img.'">
                        </a>
                     </div>
                  </div>
               </div>';
             }
  echo '     </div>
            <div class="floating-card" style="width: 18rem;"></div>
         </div>
      </li>';
  }

  function getPost($pid, $img, $likes, $com, $rt, $thumb, $id, $usr, $msg, $date, $protected=0)
  {
    echo '<div class="card post" data-id="'.$pid.'">';
    if($protected==1) echo '<div class="mini-logo"></div>';
    if($img!=null) {
    echo'<div class="post-image">
          <div class="post-image-align">
            <div class="post-image-contain">
              <a href="'.$img.'" data-type="image" data-toggle="lightbox" data-max-width="600" data-likes="'.$likes.'" data-com="'.$com.'">';
                if($protected==1) echo '<img class="overlay" src="images/ico/bg.svg"/>';
                echo '<img class="post-img card-img-top img-fluid lazy" alt="img" src="'.$thumb.'" data-src="'.$img.'">
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
      echo genFoot($likes, $com, $rt,$pid, $date, $protected);
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
        <h5 class="card-title"><a href="?action=profile&id='.escape($user->id).'">'.escape($user->prenom).' '.escape($user->nom).'</a></h5>
        <h6 class="card-subtitle mb-2 text-muted">@'.escape($user->identifiant).'</h6>
      </div>
      <div class="floating-card" style="width: 18rem;"></div>
    </div></li>';
    }
    ////<a href="?action=profile&id='.escape($usr->id).'">'.escape($usr->prenom).' '.escape($usr->nom).'</a>
    //var_dump($sug);
  }

  function genTimeDiff($time) {
    $now = date("Y-m-d H:i:s");
    $diff = strtotime(date("Y-m-d H:i:s"))-strtotime($time);
    if($diff<=0) return 'futures ago';
    if($diff<60) return $diff.' seconds ago';
    else {
      $diffMins = round($diff / 60);
      if($diffMins<60) return $diffMins.' minutes ago';
      else {
        $diffHours = round($diff / 3600);
        if($diffHours<24) return $diffHours.' hours ago';
        else {
          $diffDays = round($diff / 86400);
          if($diffDays<30) return $diffDays.' days ago';
          else {
            $diffMonth = round($diff / 2628000);
            if($diffMonth<12) return $diffMonth.' months ago';
            else {
              $diffYears = round($diff / 31536000);
              return $diffYears.' years ago';
            }
          }
        }
      }
    }
  }

 ?>
