<?php
function escape($text) {
  $text = trim($text);
  $text = stripslashes($text);
  $text = htmlspecialchars($text, ENT_QUOTES);
  return $text;
}
function genPP($text, $id) {
  if(isset($text) && !is_null($text) && file_exists('profile-image/'.$text)) return 'profile-image/'.$text;
  $f = 'profile-image/'.$id.'_400x400.jpg';
  if(file_exists($f)) return $f;
  else return "images/ico/def48.png";
}
function genDate($text) {
  $date = new DateTime($text);
  return date_format($date, 'd/m/Y');
}
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>OurFace</title>
  <meta name="author" content="name">
  <meta name="description" content="description here">
  <meta name="keywords" content="keywords,here">

  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Raleway:200,300,400,500,700" type="text/css">
  <link href="bad/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/icons.css" rel="stylesheet">
  <link href="bad/css/bad.css" rel="stylesheet">
  </head>
  <body>

    <!--[if IE]>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="bad/js/stickyfill.js"></script>
    <script>$(function() {
      Stickyfill.add($('.sticky'));
      Stickyfill.add($('.affix-top'));
    });</script>
    <![endif]-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script>
    if (navigator.userAgent.indexOf("Chrome") == -1){ // Fuck you IE I hate you
      document.write("\<script src='bad/js/stickyfill.js' type='text/javascript'>\<\/script>");
      $(function() {
        Stickyfill.add($('.sticky'));
        Stickyfill.add($('.affix-top'));
      });
    }
    </script>
    <!-- nav -->
    <nav class="navbar navbar-light fixed-top bg-light flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-1 mr-0 text-center" href="?"><?php echo $nameApp; ?></a>
      <ul class="nav navbar-right px-3">
        <?php
        if(isset($_SESSION['logged']) && $_SESSION['logged']) {
          /*
          <form action="./" method="post">
          <input name="action" value="logout" type="submit" class="a_nav-link a_nav-link-button"></form>
          */
         ?>

        <li class="nav-item" id="pp">
          <div class="nav-avatar d-flex">

            <div class="dropdown">
              <a class="dropdown-toggle avatar-dropdown" href="#" role="button" id="profileLinks" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="name-container flex-grow-1">
                  <h5 class="card-title"><?php echo $_SESSION['user_var']['prenom']; ?></h5>
                </div>
                <div class="avatar-container">
                  <img class="avatar-image" src="<?php echo genPP($_SESSION['user_var']['avatar'], $_SESSION['user_var']['id'])?>" alt="">
                </div>
              </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileLinks">
              <a class="dropdown-item" href="?action=BProfile">Profile</a>
              <a class="dropdown-item" href="?action=logout">Logout</a>
            </div>
          </div>
        </div>
       </li>


         <?php
        /*  echo '<li class="nav-item" id="logout">
                  <a class="nav-link" href="?action=logout">Logout</a>
                </li>';*/
        } else {
          echo '  <li class="nav-item" id="register">
                    <a class="nav-link" href="#">Register</a>
                  </li>
                  <li class="nav-item" id="login">
                    <a class="nav-link" href="?action=login">Login</a>
                  </li>';
        }
         ?>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">

        <?php if(isset($context->trace) && !is_null($context->trace)) {
          echo $context->trace;
        }
        ?>
        <?php include($template_view); ?>

      </div>
    </div>


  </body>
</html>
