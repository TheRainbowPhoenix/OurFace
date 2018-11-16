

<?php
if (isset($_SESSION['logged'])  && $_SESSION['logged']===true ) {

?>
<div class="col col-md-12">
  <div class="card post">
    <div class="card-body">
      <p class="card-text"><span>😊 Welcome <?php echo $_SESSION['surname'] ?>, Check the
        <a href="?action=helloWorld">hello world !</a>
      </span></p>
    </div>
  </div>
</div>

<?php }?>

<div class="col col-md-12">
  <div class="card post">
    <div class="card-body">
      <p class="card-text">
        <span>
          Arch init with <?php echo $context->param1 ?> at <?php echo $context->param2 ?>
        </span>
        <span>
          <?php
          if (isset($context->error) && !is_null($context->error)) {
            echo $context->error;
          } else {
            //$ret = $context->db->doQuery("select * from fredouil.utilisateur where identifiant='1' OR 1=1 --");
            var_dump(utilisateurTable::getUserById('2'));
            var_dump(messageTable::getMessagesSentTo('2'));
            //echo json_encode($ret);
          }
           ?>
        </span>
      </p>
    </div>
  </div>
</div>
