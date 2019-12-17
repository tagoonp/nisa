<?php
include "../../conf.inc.php";
include "../../connect.inc.php";
include "../../function.inc.php";

$return = array();

if(
    (!isset($_GET['uid'])) ||
    (!isset($_GET['role']))
){
    header('Location: ../../');
    mysqli_close($conn);
    die();
}

$uid = mysqli_real_escape_string($conn, $_GET['uid']);
$role = mysqli_real_escape_string($conn, $_GET['role']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>NISA for Common user</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../node_modules/@fortawesome/fontawesome-free/css/all.css">

  <!-- Template CSS -->
  <!-- <link rel="stylesheet" href="../../assets/css/style.css"> -->
  <!-- <link rel="stylesheet" href="../../assets/css/components.css"> -->
  <link rel="stylesheet" href="../../assets/custom/css/style.css">

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
          <div class="col-12 col-sm-10 offset-sm-1 ">
            <div class="login-brand">
              <!-- <img src="../../assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle"> -->
              <h1 class="text-white">NISA</h1>
            </div>

            <div class="row">
              <div class="col-6 col-sm-3 mb-4">
                <img src="../../img/mainmenu.png" alt="" class="img-fluid thumbnail-icon" onclick="fnc.gotoUrl('./index?uid=<?php echo $uid;?>&role=<?php echo $role;?>')">
              </div>
              <div class="col-6 col-sm-3 mb-4">
                <img src="../../img/appenddata.png" alt="" class="img-fluid thumbnail-icon" onclick="fnc.gotoUrl('./neonate-append?uid=<?php echo $uid;?>&role=<?php echo $role;?>')">
              </div>
              <div class="col-6 col-sm-3 mb-4">
                <img src="../../img/analysis.png" alt="" class="img-fluid thumbnail-icon">
              </div>
              <div class="col-6 col-sm-3 mb-4">
                <img src="../../img/backup.png" alt="" class="img-fluid thumbnail-icon">
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="../../node_modules/jquery/dist/jquery.min.js" ></script>
  <script src="../../node_modules/popper.js/dist/umd/popper.min.js"></script>
  <script src="../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" ></script>
  <script src="../../node_modules/jquery.nicescroll/dist/jquery.nicescroll.min.js"></script>
  <script src="../../node_modules/moment/min/moment.min.js"></script>
  <script src="../../assets/js/stisla.js"></script>

  <!-- Template JS File -->
  <script src="../../assets/js/scripts.js"></script>
  <script src="../../assets/js/custom.js"></script>

  <script src="../../assets/custom/js/config.js"></script>
  <script src="../../assets/custom/js/function.js"></script>
  <script src="../../assets/custom/js/authen.js"></script>
  <script src="../../assets/custom/js/authen-init.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      $('body').niceScroll();
    })
  </script>
</body>
</html>
