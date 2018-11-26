<?php
  if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
    die('Invalid');
  }
?>
<div class="a_card">
        <div class="embed-card">
          <div class="mini-logo"></div>
          <div class="card post">
            <div class="card-body">
              <div class="d-flex">
                <div class="avatar-container">
                </div>
                <div class="name-container flex-grow-1">
                  <h5 class="card-title"><a>Oh no !</a></h5>
                </div>
                <div class="floating-card" style="width: 18rem;"></div>
              </div>
              <p class="card-text">It looks like the post doesn't exists !</p>
            </div>
            <div class="card-footer">
              <div class="post-actions row">
                <div class="card-link flex-grow-1 post-date">
                  <small class="text-muted float-right"><a href="?action=share&amp;id=139">Why don't you take a tour ? OurFace is waiting for you ...</small></a>
                </div>
              </div>
            </div>
          </div>
        </div>
</div>
