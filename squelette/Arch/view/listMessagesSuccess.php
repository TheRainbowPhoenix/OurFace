<?php
# @Author: uapv1701795
# @Date:   2018-11-19T00:53:49+01:00
# @Last modified by:   uapv1701795
# @Last modified time: 2018-11-20T14:54:29+01:00



  if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
    die('Invalid');
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
              <img class="post-img card-img-top lazy" alt="img" data-src="<?php echo genImage($message->first->emetteur, $message->second[0]->image) ?>" <?php
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
        <div class="d-flex account-small" data-user-id="<?php echo $message->first->emetteur ?>">
          <div class="avatar-container">
	    <img class="avatar-image" src="<?php
if(isset($message->third[0])) {
	echo genPP($message->third[0]->avatar, $message->first->emetteur);
} else {
	echo 'Missingno';
} ?>" alt="">
          </div>
          <div class="name-container flex-grow-1">
            <h5 class="card-title"><?php
            echo '<a href="?action=profile&id='.escape($message->first->emetteur).'">'.escape($message->third[0]->prenom).' '.escape($message->third[0]->nom).'</a>';
            //echo escape($message->third[0]->prenom).' '.escape($message->third[0]->nom)?></h5>
            <h6 class="card-subtitle mb-2 text-muted">@<?php echo escape($message->third[0]->identifiant)?></h6>
          </div>
          <div class="floating-card" style="width: 18rem;"></div>
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
    if($message->first->aime==NULL) $message->first->aime = 0;
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
