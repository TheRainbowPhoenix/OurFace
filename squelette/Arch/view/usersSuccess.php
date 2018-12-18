<?php
  if($context->logged == false) {
    die("Please go login");
  }
 ?>
<nav class="col col-lg-3 sidebar dashboard dashboard-left mob-hidden">
  <div class="BProfile">
    <div class="card-deck">
      <div class="card">
        <?php genProfile($context->user, true) ?>
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
        <a href="?action=users" class="card-link">View more</a>
      </div>
    </div>
  </div>
</nav>
<div class="col posts-main ">
  <div class="row profiles">
    <?php

    foreach ($context->users as $user) {
      ?>
    <div class="col-lg-4">
      <div class="card-deck">
	<div class="card">
		
          <?php genProfile($user, false, true) ?>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</div>
