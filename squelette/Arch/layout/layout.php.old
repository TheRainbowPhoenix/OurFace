<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
     <!--meta http-equiv="Content-Type" content="text/html; charset=utf-8" /-->
     <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>
     Arch
    </title>

    <meta name="author" content="Pho3">
    <meta name="description" content="Arch">
    <meta name="keywords" content="arch,php">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Raleway:200,300,400,500,700" type="text/css">
    <link rel="stylesheet" href="css/styles.css" type="text/css">
    <link rel="icon" type="image/png" sizes="192x192"  href="images/favicon/arch-192.png">
    <link rel="icon" type="image/png" sizes="24x24" href="images/favicon/arch.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/arch-16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/arch-32.png">
    <meta name="msapplication-TileColor" content="#bd9cd7">
  <meta name="msapplication-TileImage" content="images/favicon/arch-144.png">
  <meta name="theme-color" content="#bd9cd7">
  </head>

  <body>
    <header class="a_header">
      <a class="a_nav-button" href="?">
        <svg class="a_icon-24" viewBox="0 0 24 24">
          <path fill-opacity=".5" fill-rule="evenodd" d="M16 0L4 12l12 12 1-1L6 12 17 1l-1-1z" color="#000" overflow="visible"></path>
        </svg>
      </a>
      <div class="a_header-row">
        <span class="a_title">
          <?php echo $nameApp; ?>
        </span>
        <?php
        if(isset($_SESSION['logged']) && $_SESSION['logged']) {
          /*
          <form action="./" method="post">
          <input name="action" value="logout" type="submit" class="a_nav-link a_nav-link-button"></form>
          */
          echo '<nav class="a_nav">
          <a class="a_nav-link a_nav-link-button" href="?action=logout">logout</a>
              </nav>';
        } else {
          echo '<nav class="a_nav">
          <a class="a_nav-link a_nav-link-button" href="?action=login">login</a>
              </nav>';
        }
         ?>
      </div>
    </header>

    <div class="a_container">
      <?php if(isset($context->trace) && !is_null($context->trace)) {
        echo $context->trace;
      }
      ?>
      <?php include($template_view); ?>
    </div>

  </body>

</html>
