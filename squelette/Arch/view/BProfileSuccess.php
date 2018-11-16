<?php
  if (!isset($_SESSION['logged']) || !$_SESSION['logged'] || (!$_SESSION['user_var'])) {
    die('Invalid');
  }
  function escape($text) {
    $text = trim($text);
    $text = stripslashes($text);
    $text = htmlspecialchars($text, ENT_QUOTES);
    return $text;
  }
  function genPP($text) {
    if(isset($text) && !is_null($text) && file_exists($text)) return $text;
    else return "images/ico/def48.png";
  }
  function genDate($text) {
    $date = new DateTime($text);
    return date_format($date, 'd/m/Y');
  }
?>
<div class="BProfile">
  <div class="card-deck">
    <div class="card">
      <div class="SProfileCover card-img-top"></div>
      <div class="card-body">
        <div class="d-flex account-small">
          <div class="avatar-container">
            <img class="avatar-image" src="<?php echo genPP($_SESSION['user_var']["avatar"]) //images/ico/def48.png ?>" alt="">
          </div>
          <div class="name-container flex-grow-1">
            <h5 class="card-title"><?php echo escape($_SESSION['user_var']["nom"])." ".escape($_SESSION['user_var']["prenom"]) ?></h5>
            <h6 class="card-subtitle mb-2 text-muted"><?php echo "@".escape($_SESSION['user_var']["identifiant"]) ?></h6>
          </div>
        </div>
        <p class="card-text"><?php echo escape($_SESSION['user_var']["statut"]) ?></p>
      </div>
      <div class="card-footer">
        <small class="text-muted">Born the <?php echo genDate(escape($_SESSION['user_var']["date_de_naissance"])) ?></small>
      </div>
    </div>
  </div>
</div>
