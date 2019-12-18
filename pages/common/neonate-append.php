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
        Hello, <span class="userFullname text-primary"><i class="fas fa-sync fa-spin text-primary"></i></span>
      </div>
      <div class="col-12 col-sm-6 text-right">
        <button type="button" class="btn btn-sm- btn-primary" name="button" style="font-size: 0.7em;" onclick="changeFontsize(1)"><i class="fas fa-plus text-white"  style="font-size: 0.7em;"></i> Font Size</button>
        <button type="button" class="btn btn-sm- btn-primary" name="button" style="font-size: 0.7em;" onclick="changeFontsize(2)"><i class="fas fa-minus text-white"  style="font-size: 0.7em;"></i> Font Size</button>
      </div>
    </div>
  </div>
  <div id="app">
    <section class="section">
      <div class="container-fluid mt-5 mb-5" style=" ">
        <div class="row">
          <div class="col-12">
            <div class="login-brand">
              <!-- <img src="../../assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle"> -->
              <h1 class="text-white">Neonate :: Append data</h1>
            </div>

            <div class="row">
              <div class="col-12 mb-3">
                <button type="button" class="btn btn-primary btn-icon" name="button" onclick="fnc.gotoUrl('./neonate?uid=<?php echo $uid;?>&role=<?php echo $role;?>')"><i class="fas fa-home text-white"></i></button>
                <button type="button" class="btn btn-primary btn-icon" name="button" onclick="fnc.gotoUrl('./neonate-append?uid=<?php echo $uid;?>&role=<?php echo $role;?>')">Patient's characteristic</button>
                <button type="button" class="btn btn-secondary btn-icon" name="button" onclick="fnc.gotoUrl('./neonate-device?uid=<?php echo $uid;?>&role=<?php echo $role;?>')">Device associate</button>
                <button type="button" class="btn btn-secondary btn-icon" name="button" onclick="fnc.gotoUrl('./neonate-other?uid=<?php echo $uid;?>&role=<?php echo $role;?>')">Other infection</button>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-4">
                <h6 class="text-white">Hospital characteristic</h6>
                <div class="card">
                  <div class="card-body">
                    <form class="neoPatienForm" onsubmit="return false;">
                      <div class="form-group">
                        <label for="">Serial No.: <span class="text-danger">**</span> </label>
                        <input type="text" class="form-control c-input" name="txtSerial" id="txtSerial"  placeholder="Enter serial no. ..." autofocus tabindex="1">
                      </div>
                      <div class="row">
                        <div class="form-group col-6">
                          <label for="">HN:  </label>
                          <input type="text" class="form-control c-input" name="txtHn" id="txtHn" placeholder="Enter HN ..." tabindex="2">
                        </div>
                        <div class="form-group col-6">
                          <label for="">Gender: <span class="text-danger">**</span> </label>
                          <select class="form-control c-input" name="txtGender" id="txtGender" tabindex="3">
                            <option value="">-- Choose gender --</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-6">
                          <label for="">GA (weeks):  </label>
                          <input type="number" min="1" max="50" class="form-control c-input" name="txtGa" id="txtGa" placeholder="Enter GA ..." tabindex="4">
                        </div>
                        <div class="form-group col-6">
                          <label for="">BW (grams): <span class="text-danger">**</span> </label>
                          <input type="number" min="100" class="form-control c-input" name="txtBw" id="txtBw" placeholder="Enter birth weight ..." tabindex="5">
                          <small id="passwordHelpInline" class="text-muted">
                            Must be greater than 100
                          </small>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="">Admission date: <span class="text-danger">**</span> </label>
                        <input type="text" class="form-control c-input datepicker" name="txtAdm" id="txtAdm"  tabindex="6">
                      </div>

                      <div class="form-group">
                        <label for="">Discharge date: <span class="text-danger">**</span> </label>
                        <input type="text" class="form-control c-input datepicker" name="txtDisc" id="txtDisc"  tabindex="7">
                      </div>

                      <div class="row">
                        <div class="form-group col-6">
                          <label for="">Die in hospital: <span class="text-danger">**</span> </label>
                          <select class="form-control c-input" name="txtDie" id="txtDie"  tabindex="8">
                            <option value="N" selected>No</option>
                            <option value="Y">Yes</option>
                          </select>
                        </div>

                        <div class="form-group col-6">
                          <label for="">Length of stay: <span class="text-danger">**</span> </label>
                          <input type="number" min="0" max="30" class="form-control c-input" name="txtLos" id="txtLos" placeholder="Enter length of stay in days ..."  tabindex="9">
                          <small id="passwordHelpInline" class="text-muted">
                            Must be 1 - 30 days.
                          </small>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-12 text-right pt-3">
                          <button type="submit" class="btn btn-primary" name="button" >Record <i class="fas fa-chevron-right text-white"></i></button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
                <!-- .carc -->
              </div>
              <div class="col-12 col-sm-8">
                <h6 class="text-white">Patient's record</h6>
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive" id="tableZone1">
                      <?php
                      $columData = array();
                      $strSQL = "SELECT * FROM nis_neonate_patient WHERE neo_uid = '$uid' ORDER BY neo_serial DESC";
                      $resultHosphistory = mysqli_query($conn, $strSQL);
                      if(($resultHosphistory) && (mysqli_num_rows($resultHosphistory) > 0)){
                        while ($row = mysqli_fetch_array($resultHosphistory)) {
                          $buf = array();
                          foreach ($row as $key => $value) {
                              if(!is_int($key)){
                                $buf[$key] = $value;
                              }
                          }
                          $columData[] = $buf;
                        }
                      }

                      ?>
                      <table class="table table-striped table-sm" id="table-1">
                        <thead>
                          <tr>
                            <th class="text-center"></th>
                            <th>Serial</th>
                            <th>HN</th>
                            <th>Sex</th>
                            <th>GA</th>
                            <th>BW</th>
                            <th>Admission</th>
                            <th>Discharge</th>
                            <th>Die</th>
                            <th>Los</th>
                            <th>BW_Cat</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if(sizeof($columData) == 0){
                            ?>
                            <tr>
                              <td colspan="12" class="text-center">
                                No patient found.
                              </td>
                            </tr>
                            <?php
                          }else{
                            foreach ($columData as $rowData) {
                              ?>
                              <tr>
                                <td>
                                  <button type="button" class="btn btn-sm btn-icon" name="button" onclick="setLocalData('<?php echo $rowData['neo_serial'];?>')"><i class="fas fa-pencil-alt text-dark"></i></button>
                                  <button type="button" class="btn btn-sm btn-icon" name="button" onclick="neonate.delPatient('<?php echo $rowData['neo_id'];?>')"><i class="fas fa-trash text-danger"></i></button>
                                </td>
                                <td><?php echo $rowData['neo_serial']; ?></td>
                                <td><?php echo $rowData['neo_hn']; ?></td>
                                <td><?php echo $rowData['neo_sex']; ?></td>
                                <td><?php echo $rowData['neo_ga']; ?></td>
                                <td><?php echo $rowData['neo_bw']; ?></td>
                                <td><?php echo $rowData['neo_admission']; ?></td>
                                <td><?php echo $rowData['neo_discharge']; ?></td>
                                <td><?php echo $rowData['neo_die']; ?></td>
                                <td><?php echo $rowData['neo_los']; ?></td>
                                <td><?php echo $rowData['neo_bw_cat']; ?></td>
                              </tr>
                              <?php
                            }
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <!-- .card -->
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

      if(jQuery().daterangepicker){
        if($('.datepicker').length){
          $('.datepicker').daterangepicker({
            locale: {format: 'DD-MMM-YYYY'},
            singleDatePicker: true
          })
        }
      }

      $('#tableZone1').niceScroll();

      $("#table-1").dataTable({
        "columnDefs": [
          { "width": "100px", "targets": 0 },
          { "sortable": false, "targets": [2,3] }
        ]
      });

      calculateLos()
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
