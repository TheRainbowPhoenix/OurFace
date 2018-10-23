

<?php
if (isset($_SESSION['logged'])  && $_SESSION['logged']===true ) {

?>
<div class="a_card">
  <div class="a_card-header"><span class="a_card-header-title"></span></div>
  <div class="a_card-body">
    <div class="a_card-body-block row">
      <div class="a_card-item col">
        <span>😊 Welcome <?php echo $_SESSION['surname'] ?>, Check the
          <a href="?action=helloWorld">hello world !</a>
        </span>
      </div>
    </div>
  </div>
</div>

<?php }?>
<div class="a_card">
  <div class="a_card-header"><span class="a_card-header-title"></span></div>
  <div class="a_card-body">
    <div class="a_card-body-block row">
      <div class="a_card-item col">
        <span>
          Arch init with <?php echo $context->param1 ?> at <?php echo $context->param2 ?>
        </span>
        <span>
          <?php
          if (isset($context->error) && !is_null($context->error)) {
            echo $context->error;
          } else {
            $ret = $context->db->doQuery("select * from fredouil.utilisateur where identifiant='1' OR 1=1 --");
            var_dump(utilisateurTable::getUserById('2'));
            var_dump(messageTable::getMessagesSentTo('2'));
            //echo json_encode($ret);
          }
           ?>
        </span>
      </div>
    </div>
  </div>
</div>
