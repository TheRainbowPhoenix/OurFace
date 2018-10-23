<?php
  if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
    die('Invalid');
  }
?>
<div class="a_card">
  <div class="a_card-header"><span class="a_card-header-title"></span></div>
  <div class="a_card-body">
    <div class="a_card-body-block row">
      <div class="a_card-item col">
        <span>Ceci est un super <?php echo $context->mavariable ?> ! dingue non ?
        </span>
      </div>
    </div>
  </div>
</div>
