<?php
  if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
    die('Invalid');
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
    }
    return "images/ico/def96.png";
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
  <div class="col-md-5 col-centered posts-main">
    <div>

  <?php
  //var_dump($context->messages);
  //echo json_encode($context->messages);
  foreach ($context->messages as $message) {
    //var_dump($message);
    ?>
    <div class="card post">
      <?php
      if(isset($message->second[0]) && isset($message->first) && $message->second[0]->image != null) {
      $i = getimagesize(genImage($message->first->emetteur, $message->second[0]->image)); ?>
        <div class="post-image">
          <div class="post-image-align">
            <div class="post-image-contain">
              <img class="post-img card-img-top" alt="img" src="<?php echo genImage($message->first->emetteur, $message->second[0]->image) ?>" <?php
              if($i[1]>260) {
                $diff = 12800/$i[1]-50;
                //echo 'style="transform: translateY('.$diff.'%);"';
              }
              ?>>
            </div>
          </div>

        </div>
     <?php } ?>
      <div class="card-body">
        <div class="d-flex account-small">
          <div class="avatar-container">
	    <img class="avatar-image" src="<?php
if(isset($message->third[0])) {
	echo genPP($message->third[0]->avatar, $message->first->emetteur);
} else {
	echo 'Missingno';
} ?>" alt="">
          </div>
          <div class="name-container flex-grow-1">
            <h5 class="card-title"><?php echo escape($message->third[0]->prenom).' '.escape($message->third[0]->nom)?></h5>
            <h6 class="card-subtitle mb-2 text-muted">@<?php echo escape($message->third[0]->identifiant)?></h6>
          </div>
	</div>
	<?php if (isset($message->second[0])) { ?>
        <p class="card-text"><?php echo escape($message->second[0]->texte); ?></p>
      	<?php } ?>
	</div>
      <div class="card-footer">
        <div class="post-actions row">
          <div href="#" class="post-action">
            <span class="icon icon-like">
            </span>
	    <span class="count"><?php
	if (isset($message->first)) {
		echo escape($message->first->aime);
	} else {
		echo '0';
	}
?></span>
          </div>
          <div href="#" class="post-action">
            <span class="icon icon-com">
            </span>
            <span class="count">0</span>
          </div>

          <div class="card-link flex-grow-1 post-date">
            <small class="text-muted float-right">Last updated <?php
      if (isset($message->second[0])) {
              echo genTimeDiff($message->second[0]->date);
      } else {
		echo 'times ago';
	}
      //echo genDate($message->second[0]->date)
             ?></small>
          </div>
        </div>
      </div>
    </div>
 <?php
  }
?>
    </div>
</div>
