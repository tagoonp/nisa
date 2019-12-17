<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Register to NISA</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../node_modules/@fortawesome/fontawesome-free/css/all.css">

  <!-- Template CSS -->
  <!-- <link rel="stylesheet" href="../assets/css/style.css"> -->
  <!-- <link rel="stylesheet" href="../assets/css/components.css"> -->
  <link rel="stylesheet" href="../assets/custom/css/style.css">

  <style media="screen">
    body{
      background: rgb(47, 47, 47) !important;
      /* background: url('../img/nisa-bg2.png'); */
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
    }
  </style>
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5 mb-5" style=" ">
        <div class="row">
          <div class="col-12 col-sm-6 offset-sm-3">
            <div class="login-brand">
              <!-- <img src="../assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle"> -->
              <h1 class="text-white">NISA</h1>
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>Create account</h4></div>

              <div class="card-body pt-1">
                <form method="POST" action="#" class="needs-validation" novalidate="">
                  <div class="row">
                    <div class="form-group col-12">
                      <input id="email" type="email" class="form-control c-input" name="email" tabindex="1" required autofocus placeholder="E-mail address ...">
                    </div>

                    <div class="form-group col-12">
                      <input id="password" type="password" class="form-control c-input" name="email" tabindex="2" required autofocus placeholder="Create your password ...">
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-12">
                      <input id="fname" type="text" class="form-control c-input" name="fname" tabindex="3" required placeholder="Your first name ...">
                    </div>


                    <div class="form-group col-12">
                      <input id="lname" type="text" class="form-control c-input" name="lname" tabindex="4" required placeholder="Your surname ...">
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Create account
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="mt-3 text-white text-center" style="position: fixed; top: 0px; left: 0px; padding-left: 20px;">
              <a href="index" class="text-warning"><i class="fas fa-chevron-left text-warning"></i> Back to Log in.</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="../node_modules/jquery/dist/jquery.min.js" ></script>
  <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" ></script>
  <script src="../node_modules/jquery.nicescroll/dist/jquery.nicescroll.min.js"></script>
  <script src="../node_modules/moment/min/moment.min.js"></script>
  <script src="../assets/js/stisla.js"></script>

  <!-- Template JS File -->
  <script src="../assets/js/scripts.js"></script>
  <script src="../assets/js/custom.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      $('body').niceScroll();
    })
  </script>
</body>
</html>
