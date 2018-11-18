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
      <a class="navbar-brand col-sm-3 col-md-4 mr-0 text-center" href="?"><?php echo $nameApp; ?></a>
      <ul class="nav navbar-right px-3">
        <?php
        if(isset($_SESSION['logged']) && $_SESSION['logged']) {
          /*
          <form action="./" method="post">
          <input name="action" value="logout" type="submit" class="a_nav-link a_nav-link-button"></form>
          */
         ?>

         <li class="nav-item nav-icon" id="home">
           <a href="?action=listMessages">
             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
               <path class="svg-icon-home-1" fill="#1e1e1e" d="M12 2.5l-8.4 6A2 2 0 0 0 3 10v9c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2v-9c0-.6-.2-1-.6-1.4zM12 5l6.5 4.6c.3.2.5.5.5.9V18c0 .6-.4 1-1 1H6a1 1 0 0 1-1-1v-7.5c0-.3.2-.6.4-.8z"/>
               <path class="svg-icon-home-2" fill="#1e1e1e" d="M8 12h8c.6 0 1 .4 1 1v6c0 .6-.4 1-1 1H8a1 1 0 0 1-1-1v-6c0-.6.4-1 1-1z"/>
             </svg>
           </a>
        </li>

        <li class="nav-item nav-icon" id="friends">
          <a href="?action=listUsers">
            <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24">
              <path class="svg-icon-friends-1" fill="#1e1e1e" d="M8 6a2.5 2.5 0 0 0-2.5 2.5A2.5 2.5 0 0 0 8 11a2.5 2.5 0 0 0 2.5-2.5A2.5 2.5 0 0 0 8 6zm0 6a5 3 0 0 0-5 3v2c0 .6.4 1 1 1h8c.6 0 1-.4 1-1v-2a5 3 0 0 0-5-3zm0 1.7a3 1.8 0 0 1 3 1.8v.5H5v-.5a3 1.8 0 0 1 3-1.8z" color="#000" overflow="visible" style="isolation:auto;mix-blend-mode:normal"/>
              <path class="svg-icon-friends-2" fill="#1e1e1e" d="M15 6a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zm0 6c-.9 0-1.7.1-2.5.4 1 .9 1.5 1.3 1.5 2.6v2c0 .4 0 .7-.3 1H19c.6 0 1-.4 1-1v-2c0-1.7-2.2-3-5-3z" color="#000" overflow="visible" style="isolation:auto;mix-blend-mode:normal"/>
            </svg>
          </a>
        </li>

        <li class="nav-item nav-icon" id="chat">
          <a>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path class="svg-icon-chats-1" fill="#1e1e1e" d="M5 4a2 2 0 0 0-2 2v7c0 1.1.9 2 2 2h1v2c0 .6.4 1 1 1h1l3-3h4a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H5zm1 2h8c.6 0 1 .4 1 1v5c0 .6-.4 1-1 1h-4l-2 2v-2H6a1 1 0 0 1-1-1V7c0-.6.4-1 1-1z"/>
              <path class="svg-icon-chats-2" fill="#1e1e1e" d="M18 8v5.1c0 1.6-1.3 2.9-2.9 2.9H12l-2.9 2.9.9.1h8a3 3 0 0 0 3-3v-5a3 3 0 0 0-3-3z"/>
            </svg>
            </a>
        </li>

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
              <a class="dropdown-item" href="?action=listMessages">Messages</a>
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
