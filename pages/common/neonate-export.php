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


$hospitalChar = false;
$hospData = '';
$strSQL = "SELECT * FROM nis_hospchar WHERE hosp_uid = '$uid' AND hosp_deletestatus = '0' AND hosp_status = '1' ORDER BY hosp_udatetime LIMIT 1";
$resultHospchar = mysqli_query($conn, $strSQL);
if(($resultHospchar) && (mysqli_num_rows($resultHospchar) > 0)){
  $hospitalChar = true;
  $hospData = mysqli_fetch_assoc($resultHospchar);
}else{
  header('Location: neonate?uid='.$uid.'&role='.$role);
  die();
}

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
  <link rel="stylesheet" href="../../node_modules/sweetalert/dist/sweetalert.css">
  <link rel="stylesheet" href="../../node_modules/preload.js/dist/css/preload.css">
  <link rel="stylesheet" href="../../node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../node_modules/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="../../node_modules/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="../../node_modules/selectric/public/selectric.css">
  <style> table, td {border:1px solid black; vertical-align: top;} table {border-collapse:collapse}</style>
  <!-- Template CSS -->
  <link rel="stylesheet" href="../../assets/custom/css/style.css">

  <style media="screen">
    body{
      background: rgb(47, 47, 47) !important;
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
    }
  </style>
</head>

<body>

  <div class="tools-bar">
    <div class="row">
      <div class="col-12 col-sm-6 text-white">
        Hello, <span class="userFullname text-warning"><i class="fas fa-sync fa-spin text-primary"></i></span> <a href="Javascript:authen.logout()" class="text-white ml-3"><i class="fas fa-sign-out-alt text-white"></i> Log out</a>
      </div>
      <div class="col-12 col-sm-6 text-right">
        <button type="button" class="btn btn-sm- btn-primary" name="button" style="font-size: 0.7em;" onclick="changeFontsize(1)"><i class="fas fa-plus text-white"  style="font-size: 0.7em;"></i> Font Size</button>
        <button type="button" class="btn btn-sm- btn-primary" name="button" style="font-size: 0.7em;" onclick="changeFontsize(2)"><i class="fas fa-minus text-white"  style="font-size: 0.7em;"></i> Font Size</button>
      </div>
    </div>
  </div>
  <div id="app">
    <section class="section">
      <div class="container-fluid mt-5 mb-5">
        <div class="row">
          <div class="col-12">
            <div class="login-brand">
              <h1 class="text-white">Neonate backup</h1>
            </div>

            <div class="row">
              <div class="col-12 mb-3">
                <button type="button" class="btn btn-primary btn-icon" name="button" onclick="fnc.gotoUrl('./neonate?uid=<?php echo $uid;?>&role=<?php echo $role;?>')"><i class="fas fa-home text-white"></i> Neo main menu</button>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <h6 class="text-white">Data interval</h6>
                <div class="card">
                  <div class="card-body p-3">
                    <div class="row">
                      <div class="col-12 col-sm-4">
                        <div class="form-group">
                          <label for="" class="col-form-label">From : <span class="text-danger">*</span> </label>
                          <select class="form-control c-input" name="txtStartyear" id="txtStartyear">
                            <option value="">YYYY</option>
                            <?php
                            for ($i = date('Y'); $i > (date('Y') - 10); $i--) {
                              ?>
                              <option value="<?php echo $i;?>"><?php echo $i; ?></option>
                              <?php
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-12 col-sm-4">
                        <div class="form-group">
                          <label for="" class="col-form-label">To :  <span class="text-danger">*</span></label>
                          <select class="form-control c-input" name="txtEndyear" id="txtEndyear">
                            <option value="">YYYY</option>
                            <?php
                            for ($i = date('Y'); $i > (date('Y') - 10); $i--) {
                              ?>
                              <option value="<?php echo $i;?>"><?php echo $i; ?></option>
                              <?php
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-12 col-sm-4">
                        <div class="form-group row">
                          <label for="" class="col-12 col-form-label">Dataset :  <span class="text-danger">*</span></label>
                          <div class="col-12">
                            <select class="form-control c-input" name="txtDataset" id="txtDataset">
                              <option value="">-- Choose data --</option>
                              <option value="1">Patient characteristic</option>
                              <option value="2">Device indwelling</option>
                              <option value="3">Device associated infection</option>
                              <option value="4">Other infection</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row mb-0">
                      <div class="col-12 text-right">
                        <button type="button" class="btn btn-primary" name="button" id="generateExport">Export</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- .card  -->

              </div>
              <!-- .col-12 -->
            </div>
            <!-- .row -->

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
  <script src="../../node_modules/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="../../node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
  <script src="../../node_modules/preload.js/dist/js/preload.js"></script>
  <script src="../../node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="../../node_modules/select2/dist/js/select2.full.min.js"></script>
  <script src="../../node_modules/selectric/public/jquery.selectric.min.js"></script>
  <script src="../../assets/js/stisla.js"></script>

  <!-- Template JS File -->
  <script src="../../assets/js/scripts.js"></script>
  <script src="../../assets/js/custom.js"></script>

  <script src="../../assets/custom/js/config.js"></script>
  <script src="../../assets/custom/js/function.js"></script>
  <script src="../../assets/custom/js/authen.js"></script>
  <script src="../../assets/custom/js/authen-init.js"></script>
  <script src="../../assets/custom/js/neonate.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){

      preload.hide()

    })

    $(function(){
      $('#generateExport').click(function(){
        $check = 0
        $('.form-control').removeClass('is-invalid')
        if($('#txtStartyear').val() == ''){
          $('#txtStartyear').addClass('is-invalid'); $check++;
        }

        if($('#txtEndyear').val() == ''){
          $('#txtEndyear').addClass('is-invalid'); $check++;
        }

        if($('#txtDataset').val() == ''){
          $('#txtDataset').addClass('is-invalid'); $check++;
        }

        if($check != 0){ return ; }

        window.open('../../controller/export_neonate?uid=' + current_user + '&start=' + $('#txtStartyear').val() + '&end=' + $('#txtEndyear').val() + '&dataset=' + $('#txtDataset').val() )
      })

      $('.neoPatienForm').submit(function(){
        neonate.savePatient()
      })

      $('#txtAdm').change(function(){
        calculateLos()
      })
      $('#txtDisc').change(function(){
        calculateLos()
      })
      $('#txtSerial').keyup(function(){
        neonate.searchPatient($('#txtSerial').val())
      })
    })

    function setLocalData(id){
      $("#txtSerial").val(id)
      neonate.searchPatient(id)
    }

    function calculateLos(){
      var start = serializeDate($('#txtAdm').val())
      var end = serializeDate($('#txtDisc').val())
      var _Diff = calDateDiff(start, end)
      $('#txtLos').val(_Diff + 1)
    }
  </script>
</body>
</html>
