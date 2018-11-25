<?php
  if (isset($_SESSION['logged']) && $_SESSION['logged']) {
    die('Ok');
  }
?>

<style>
  .container-fluid {
    width: 100%;
  }
</style>

<section class="first col-md-6">
    <div class="row h-100">
      <div id="logo-big" class="my-auto col-centered"></div>
    </div>
</section>

<section class="second col-md-6">
  <div class="container h-100">
        <div class="row h-100">
          <div class="col-8 col-centered" style="margin-top: 25%;">
            <div class="py-5 py-md-0 moving">
              <h1 class="mb-3">OurFace</h1>
              <p class="mb-5">Because y'all like good-working websites.</p>
              <div class="row">
                <a class="btn btn-primary btn-landing" href="?action=login" role="button">Login</a>
                <div class="col"></div>
                <a class="btn btn-secondary btn-landing" href="../~fredouil/register_fb.php" role="button">Register</a>
              </div>
            </div>
          </div>
        </div>
      </div>
</section>
