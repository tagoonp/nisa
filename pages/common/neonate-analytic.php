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
              <h1 class="text-white">Neonate analysis of Device-associated infection</h1>
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
                        <div class="form-group row">
                          <label for="" class="col-12 col-form-label">From : <span class="text-danger">*</span> </label>
                          <div class="col-4">
                            <select class="form-control c-input" name="">
                              <option value="">MM</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                              <option value="6">6</option>
                              <option value="7">7</option>
                              <option value="8">8</option>
                              <option value="9">9</option>
                              <option value="10">10</option>
                              <option value="11">11</option>
                              <option value="12">12</option>
                            </select>
                          </div>
                          <div class="col-8">
                            <select class="form-control c-input" name="">
                              <option value="">YYYY</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-sm-4">
                        <div class="form-group row">
                          <label for="" class="col-12 col-form-label">To :  <span class="text-danger">*</span></label>
                          <div class="col-4">
                            <select class="form-control c-input" name="">
                              <option value="">MM</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                              <option value="6">6</option>
                              <option value="7">7</option>
                              <option value="8">8</option>
                              <option value="9">9</option>
                              <option value="10">10</option>
                              <option value="11">11</option>
                              <option value="12">12</option>
                            </select>
                          </div>
                          <div class="col-8">
                            <select class="form-control c-input" name="">
                              <option value="">YYYY</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-sm-4">
                        <div class="form-group row">
                          <label for="" class="col-12 col-form-label">Period for report :  <span class="text-danger">*</span></label>
                          <div class="col-12">
                            <select class="form-control c-input" name="">
                              <option value="">-- Choose period --</option>
                              <option value="">Monthly</option>
                              <option value="">Bimonth</option>
                              <option value="">Quarter</option>
                              <option value="">Trimester</option>
                              <option value="">SemiAnnual</option>
                              <option value="">Annual</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row mb-0">
                      <label for="" class="col-12 col-sm-2 col-form-label">Site of infection : </label>
                      <div class="col-12 col-sm-3">
                        <div class="">
                          <label class="custom-switch mt-2 pl-0">
                            <input type="checkbox" name="txtCath1" id="txtCath1" class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description text-dark">CLABSI</span>
                          </label>
                        </div>
                      </div>
                      <div class="col-12 col-sm-3">
                        <div class="">
                          <label class="custom-switch mt-2 pl-0">
                            <input type="checkbox" name="txtCath1" id="txtCath1" class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description text-dark">PedVAE</span>
                          </label>
                        </div>
                      </div>
                      <div class="col-12 col-sm-4 text-right">
                        <button type="button" class="btn btn-primary" name="button">Table report</button>
                        <button type="button" class="btn btn-primary" name="button">Chart report</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- .card  -->

                <div class="" id="table-zone">
                  <h6 class="text-white">Table report</h6>
                  <div class="card">
                    <div class="card-header">
                      <h4>Table : standardized ratio of CLABSI in NICU</h4>
                    </div>
                    <div class="card-body p-0">
                      <table class="table table-bordered table-sm mb-0">
                        <thead>
                          <tr>
                            <th>Year</th>
                            <th>Quarter</th>
                            <th>Birthweight</th>
                            <th>CLABSI</th>
                            <th>Catheter-days</th>
                            <th>Rate</th>
                            <th>SIR</th>
                            <th>LWL</th>
                            <th>CL</th>
                            <th>UWL</th>
                            <th>UCL</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- <tr>
                            <td colspan="11" class="text-center">Please filter and generate report</td>
                          </tr> -->
                          <tr>
                            <td rowspan="25">2012</td>
                            <td rowspan="6">1st</td>
                            <td> < 751 gms. </td>
                            <td>v</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>
                          <tr>
                            <td>751-1000 gms</td>
                            <td>v</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>
                          <tr>
                            <td>1001-1500 gms</td>
                            <td>v</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>
                          <tr>
                            <td>1501-2500 gms</td>
                            <td>v</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>
                          <tr>
                            <td> >2500 gms </td>
                            <td>v</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>
                          <tr>
                            <td>Total</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>

                          <tr>
                            <td rowspan="6">2nd</td>
                            <td> < 751 gms. </td>
                            <td>v</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>
                          <tr>
                            <td>751-1000 gms</td>
                            <td>v</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>
                          <tr>
                            <td>1001-1500 gms</td>
                            <td>v</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>
                          <tr>
                            <td>1501-2500 gms</td>
                            <td>v</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>
                          <tr>
                            <td> >2500 gms </td>
                            <td>v</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>
                          <tr>
                            <td>Total</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>

                          <tr>
                            <td rowspan="6">3rd</td>
                            <td> < 751 gms. </td>
                            <td>v</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>
                          <tr>
                            <td>751-1000 gms</td>
                            <td>v</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>
                          <tr>
                            <td>1001-1500 gms</td>
                            <td>v</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>
                          <tr>
                            <td>1501-2500 gms</td>
                            <td>v</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>
                          <tr>
                            <td> >2500 gms </td>
                            <td>v</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>
                          <tr>
                            <td>Total</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>

                          <tr>
                            <td rowspan="6">4th</td>
                            <td> < 751 gms. </td>
                            <td>v</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>
                          <tr>
                            <td>751-1000 gms</td>
                            <td>v</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>
                          <tr>
                            <td>1001-1500 gms</td>
                            <td>v</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>
                          <tr>
                            <td>1501-2500 gms</td>
                            <td>v</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>
                          <tr>
                            <td> >2500 gms </td>
                            <td>v</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>
                          <tr>
                            <td>Total</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>

                          <tr>
                            <td colspan="2">GRAND TOTAL</td>
                            <td>d</td>
                            <td>f</td>
                            <td>h</td>
                            <td>j</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                            <td>k</td>
                          </tr>

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <!-- # table-zone -->

                <div class="" id="chart-zone">
                  <h6 class="text-white">Chart report</h6>
                  <div class="card">
                    <div class="card-body">
                      <div class="text-center" style="padding: 50px 0px;">
                        <i class="fas fa-chart-line text-muted" style="font-size: 100px !important;" id="chartPreload"></i><br>Please generate report
                      </div>
                    </div>
                  </div>
                </div>
                <!-- # chart-zone -->

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

      // if(jQuery().daterangepicker){
      //   if($('.datepicker').length){
      //     $('.datepicker').daterangepicker({
      //       locale: {format: 'DD-MMM-YYYY'},
      //       singleDatePicker: true
      //     })
      //   }
      // }

      // $('#tableZone1').niceScroll();
      //
      // $("#table-1").dataTable({
      //   "columnDefs": [
      //     { "width": "100px", "targets": 0 },
      //     { "sortable": false, "targets": [2,3] }
      //   ]
      // });

      // calculateLos()
    })

    $(function(){
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
