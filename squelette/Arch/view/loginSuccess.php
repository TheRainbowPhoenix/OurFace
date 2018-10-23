<?php
  function genError($text) {
    return '<div class="a_card">
      <div class="a_card-header"><span class="a_card-header-title"></span></div>
      <div class="a_card-body a_error_card">
        <div class="p_error">
          <span>'.$text.'
          </span>
        </div>
      </div>
    </div>';
  }

  function genWelcome($text) {
    return '<div class="a_card">
      <div class="a_card-header"><span class="a_card-header-title"></span></div>
      <div class="a_card-body">
        <div class="a_card-body-block row">
          <div class="a_card-item col">
            <span>You are now logged as '.$text.'
            </span>
          </div>
        </div>
      </div>
    </div>';
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

<div class="a_card">
  <div class="a_card-header">
    <span class="a_card-header-title"></span>
  </div>
  <div class="a_card-body">
    <div class="a_card-body-block row">
      <div class="a_card-item col">
        <span>Login</span>
      </div>
      <div class="a_card-item col">
        <form class="form-signin mt-10" method="POST">
          <div class="input-group">
            <span class="input-info" id="basic-addon1">Username :</span>
            <input type="text" name="username" class="textfield" autofocus="autofocus" required="">
          </div>
          <label for="inputPassword" class="input-info sr-only">Password :</label>
          <input type="password" name="password" id="inputPassword" class="textfield" required="">
          <div class="card-actions">
  					<a class="btn btn-lg btn-primary btn-block" href="/~fredouil/register_fb.php">Register</a>
  					<button class="right btn-main btn btn-lg btn-primary btn-block" type="submit" style="margin-left: auto;">Login</button>
  				</div>
        </form>
      </div>

    </div>
  </div>
</div>

<?php
  }
  ?>
