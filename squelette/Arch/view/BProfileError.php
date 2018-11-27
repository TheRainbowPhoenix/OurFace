<?php
# @Author: uapv1701795
# @Date:   2018-11-27T13:32:55+01:00
# @Last modified by:   uapv1701795
# @Last modified time: 2018-11-27T13:33:01+01:00




  if (!$context->logged) {
    die('Invalid Session. please <a href="?action=login"> login</a>');
  }
?>
<div class="BProfile">
  <div class="card-deck">
    <div class="card">
      <div class="card-body">
        <div class="d-flex account-small">
          <div class="avatar-container">
            <img class="avatar-image" src="images/ico/def48.png" alt="">
          </div>
          <div class="name-container flex-grow-1">
            <h5 class="card-title">Invlaid</h5>
            <h6 class="card-subtitle mb-2 text-muted">@missing</h6>
          </div>
        </div>
        <p class="card-text">This is an invalid user</p>
      </div>
      <div class="card-footer">
        <small class="text-muted">Last updated -1 mins ago</small>
      </div>
    </div>
  </div>
</div>
