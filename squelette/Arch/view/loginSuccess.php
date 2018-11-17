<?php
  function genError($text) {
    return '<div class="alter-container"><div class="alert alert-danger col-centered" role="alert">
  <strong>Oh snap!</strong> '.$text.'</div></div>';
  }

  function genWelcome($text) {
    return '<div class="col-sm-4 col-centered"><div class="card">
  <div class="card-header">
    Connexion
  </div>
  <div class="card-body">
    <h5 class="card-title">Welcome back '.$text.'</h5>
    <p class="card-text">You have successfuly been logged into Arch.</p>
    <a href="?" class="btn btn-primary">Go to your deck</a>
  </div>
    </div></div>';
  }

  if ($_SESSION['logged']) {
    echo genWelcome($_SESSION['surname']);
    # echo $context->uname.' '.$context->pwd;
  } else {
      if (!$context->empty) {
        echo genError("Bad credentials");
        # code...
      }
?>

<div class="d-flex col-centered top-15p">
  <div class="card post">
    <div class="card-body">
      <h5 class="card-title"><span>Login</span></h5>

      <p class="card-text">
        <form class="form-signin mt-10" method="POST">

          <label for="inputEmail" class="sr-only">Username :</label>
          <input type="text" name="username" id="basic-addon1" class="form-control" placeholder="Username" required="" autofocus="">

          <label for="inputPassword" class="sr-only">Password :</label>
          <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required="">
          <div class="mb-3">
          </div>
          <a class="btn btn-lg btn-secondary btn-block" href="/~fredouil/register_fb.php">Register</a>
          <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>

        </form>
      </p>

    </div>
  </div>
</div>

<?php
  }
  ?>
