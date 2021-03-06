<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login to NISA</title>

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
          <div class="col-12 col-sm-6 offset-sm-3 ">
            <div class="login-brand">
              <!-- <img src="../assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle"> -->
              <h1 class="text-white">NISA</h1>
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>NISA Login</h4></div>

              <div class="card-body pt-1">
                <form method="POST" action="#" class="needs-validation" novalidate="">
                  <div class="form-group">
                    <input id="email" type="email" class="form-control c-input" name="email" tabindex="1" required autofocus placeholder="E-mail address ...">
                    <div class="invalid-feedback">
                      Please fill in your email
                    </div>
                  </div>

                  <div class="form-group">
                    <input id="password" type="password" class="form-control c-input" name="password" tabindex="2" required placeholder="Password ...">
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="mt-3 text-white text-center">
              Don't have an account? <a href="auth-register" class="text-warning">Create account</a>
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

  <script src="../assets/custom/js/config.js"></script>
  <script src="../assets/custom/js/function.js"></script>
  <script src="../assets/custom/js/authen.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      $('body').niceScroll();
    })
  </script>
</body>
</html>
