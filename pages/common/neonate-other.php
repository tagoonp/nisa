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

  <link rel="stylesheet" href="../../node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">

  <!-- Template CSS -->
  <!-- <link rel="stylesheet" href="../../assets/css/style.css"> -->
  <!-- <link rel="stylesheet" href="../../assets/css/components.css"> -->
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
      <div class="col-12 text-right">
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
                <button type="button" class="btn btn-secondary btn-icon" name="button" onclick="fnc.gotoUrl('./neonate-append?uid=<?php echo $uid;?>&role=<?php echo $role;?>')">Patient's characteristic</button>
                <button type="button" class="btn btn-secondary btn-icon" name="button" onclick="fnc.gotoUrl('./neonate-device?uid=<?php echo $uid;?>&role=<?php echo $role;?>')">Device associate</button>
                <button type="button" class="btn btn-primary btn-icon" name="button" onclick="fnc.gotoUrl('./neonate-other?uid=<?php echo $uid;?>&role=<?php echo $role;?>')">Other infection</button>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12 col-sm-4">
                        <form class="" onsubmit="return false;">
                          <div class="form-group">
                            <label for="">Serial No.: <span class="text-danger">**</span> </label>
                            <input type="text" class="form-control c-input" name="" value="" placeholder="Enter serial no ...">
                          </div>
                          <div class="row">
                            <div class="form-group col-12">
                              <input type="text" class="form-control c-input" name="" value="" placeholder="HN" readonly>
                            </div>

                          </div>
                          <div class="row">
                            <div class="form-group col-4">
                              <input type="text" class="form-control c-input" name="" value="" placeholder="Gender" readonly>
                            </div>
                            <div class="form-group col-4">
                              <input type="text" class="form-control c-input" name="" value="" placeholder="GA" readonly>
                            </div>
                            <div class="form-group col-4">
                              <input type="text" class="form-control c-input" name="" value="" placeholder="BW" readonly>
                            </div>
                          </div>

                          <div class="row">
                            <div class="form-group col-6">
                              <input type="text" class="form-control c-input" name="" value="" placeholder="Admission date" readonly>
                            </div>

                            <div class="form-group col-6">
                              <input type="text" class="form-control c-input" name="" value="" placeholder="Discharge date" readonly>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="">Site of infection: <span class="text-danger">**</span> </label>
                            <select class="form-control c-input" name="">
                              <option value="">-- Choose site --</option>
                            </select>
                          </div>

                          <div class="form-group">
                            <label for="">Date of event: <span class="text-danger">**</span> </label>
                            <input type="text" class="form-control c-input" name="" value="" placeholder="" >
                          </div>

                          <div class="form-group">
                            <input type="text" class="form-control c-input" name="" value="" placeholder="Length from admission to event (days)" readonly>
                          </div>

                          <div class="form-group">
                            <label for="">Pathogen: <span class="text-danger">**</span> </label>
                            <input type="text" class="form-control c-input" name="" value="" placeholder="" >
                          </div>




                          <div class="row">
                            <div class="col-12 text-right pt-3">
                              <button type="button" class="btn btn-primary" name="button">Record <i class="fas fa-chevron-right text-white"></i></button>
                            </div>
                          </div>

                        </form>
                      </div>

                      <div class="col-12 col-sm-8">
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
                                <th class="text-center">

                                </th>
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
                                      <button type="button" class="btn btn-danger btn-sm btn-icon" name="button"><i class="fas fa-trash text-white"></i></button>
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
                  </div>
                </div>

                <!-- ... -->
                <h6 class="text-white">Hospital characteristic</h6>
                <div class="card">
                  <div class="card-body">
                    <form class="" onsubmit="return false;">
                      <div class="form-group">
                        <label for="">Serial No.: <span class="text-danger">**</span> </label>
                        <input type="text" class="form-control c-input" name="" value="" placeholder="Hospital name ...">
                      </div>
                      <div class="form-group">
                        <label for="">HN: <span class="text-danger">**</span> </label>
                        <input type="text" class="form-control c-input" name="" value="" placeholder="Address ...">
                      </div>
                      <div class="form-group">
                        <label for="">Gender: <span class="text-danger">**</span> </label>
                        <select class="form-control c-input" name="">
                          <option value="">-- Choose gender --</option>
                          <option value="M">Male</option>
                          <option value="F">Female</option>
                        </select>
                      </div>
                      <div class="row">
                        <div class="form-group col-6">
                          <label for="">GA: <span class="text-danger">**</span> </label>
                          <input type="text" class="form-control c-input" name="" value="<?php if($hospitalChar){ echo $hospData['hosp_address'];} ?>" placeholder="Enter GA ...">
                        </div>
                        <div class="form-group col-6">
                          <label for="">Birth weight: <span class="text-danger">**</span> </label>
                          <input type="text" class="form-control c-input" name="" value="<?php if($hospitalChar){ echo $hospData['hosp_bedsize'];} ?>" placeholder="Enter birth weight ...">
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="">Admission date: <span class="text-danger">**</span> </label>
                        <input type="text" class="form-control c-input" name="" value="<?php if($hospitalChar){ echo $hospData['hosp_bedsize'];} ?>" placeholder="Enter birth weight ...">
                      </div>

                      <div class="form-group">
                        <label for="">Discharge date: <span class="text-danger">**</span> </label>
                        <input type="text" class="form-control c-input" name="" value="<?php if($hospitalChar){ echo $hospData['hosp_bedsize'];} ?>" placeholder="Enter birth weight ...">
                      </div>

                      <div class="form-group">
                        <label for="">Die in hospital: <span class="text-danger">**</span> </label>
                        <select class="form-control c-input" name="">
                          <option value="N">No</option>
                          <option value="Y">Yes</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="">Length of stay: <span class="text-danger">**</span> </label>
                        <input type="text" class="form-control c-input" name="" value="<?php if($hospitalChar){ echo $hospData['hosp_bedsize'];} ?>" placeholder="Enter birth weight ...">
                      </div>

                      <div class="row">
                        <div class="col-12 text-center pt-3">
                          <button type="button" class="btn btn-primary" name="button">Update</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
                <!-- .carc -->
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
      $('#tableZone1').niceScroll();

      $("#table-1").dataTable({
        "columnDefs": [
          { "sortable": false, "targets": [2,3] }
        ]
      });
    })
  </script>
</body>
</html>
