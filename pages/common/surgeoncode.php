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
  <link rel="stylesheet" href="../../node_modules/sweetalert/dist/sweetalert.css">
  <link rel="stylesheet" href="../../node_modules/preload.js/dist/css/preload.css">
  <link rel="stylesheet" href="../../node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">

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
        Hello, <span class="userFullname text-primary"><i class="fas fa-sync fa-spin text-primary"></i></span> <a href="Javascript:authen.logout()" class="text-white ml-3"><i class="fas fa-sign-out-alt text-white"></i> Log out</a>
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
              <h1 class="text-white">Surgeon codes</h1>
            </div>
            <div class="row">
              <div class="col-12 mb-3">
                <button type="button" class="btn btn-primary btn-icon" name="button" onclick="fnc.gotoUrl('./index?uid=<?php echo $uid;?>&role=<?php echo $role;?>')"><i class="fas fa-home text-white"></i></button>
                <button type="button" class="btn btn-secondary btn-icon" name="button" onclick="fnc.gotoUrl('./hospital?uid=<?php echo $uid;?>&role=<?php echo $role;?>')">Hospital profile</button>
                <button type="button" class="btn btn-secondary btn-icon" name="button" onclick="fnc.gotoUrl('./wardcode?uid=<?php echo $uid;?>&role=<?php echo $role;?>')">Ward codes</button>
                <button type="button" class="btn btn-primary btn-icon" name="button" onclick="fnc.gotoUrl('./surgeoncode?uid=<?php echo $uid;?>&role=<?php echo $role;?>')">Surgeon codes</button>
                <button type="button" class="btn btn-secondary btn-icon" name="button" onclick="fnc.gotoUrl('./nicu?uid=<?php echo $uid;?>&role=<?php echo $role;?>')">NICU Level</button>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-4">
                <h6 class="text-white">Surgeon information</h6>
                <div class="card">
                  <div class="card-body">
                    <form class="" onsubmit="return false;">
                      <div class="form-group">
                        <label for="">Surgeon ID: <span class="text-danger">**</span> </label>
                        <input type="text" class="form-control c-input" name="txtSurid" id="txtSurid" placeholder="Enter surgeon ID ..." autofocus>
                      </div>
                      <div class="form-group">
                        <label for="">Surgeon name: <span class="text-danger">**</span> </label>
                        <input type="text" class="form-control c-input" name=txtSurgeonname"" id="txtSurgeonname" placeholder="Enter name of surgeon ...">
                      </div>
                      <div class="form-group">
                        <label for="">Still function: <span class="text-danger">**</span> </label>
                        <select class="form-control c-input" name="txtStill" id="txtStill">
                          <option value="">-- Choose status --</option>
                          <option value="1">Yes</option>
                          <option value="0">No</option>
                        </select>
                      </div>


                      <div class="row">
                        <div class="col-12 text-right pt-3">
                          <button type="reset" class="btn btn-primary-" name="button">Reset</button>
                          <button type="button" class="btn btn-primary" name="button" onclick="hosp_profile.recodeSurgeon()">Record <i class="fas fa-chevron-right text-white"></i></button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
                <!-- .carc -->
              </div>
              <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-8">
                <h6 class="text-white">Surgeon list</h6>
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive" id="tableZone1">
                      <?php
                      $columData = array();
                      $strSQL = "SELECT * FROM nis_surgeon WHERE sur_uid = '$uid' AND sur_delete = '0' ORDER BY sur_id ASC";
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
                            <th>Surgeon ID</th>
                            <th>Surgeon name</th>
                            <th>Still function</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if(sizeof($columData) == 0){
                            ?>
                            <tr>
                              <td colspan="4" class="text-center">
                                No history found.
                              </td>
                            </tr>
                            <?php
                          }else{
                            foreach ($columData as $rowData) {
                              ?>
                              <tr>
                                <td>
                                  <button type="button" class="btn btn-danger- btn-sm btn-icon" name="button" onclick="setLocalData('<?php echo $rowData['sur_id'];?>')"><i class="fas fa-pencil-alt text-dark"></i></button>
                                  <button type="button" class="btn btn-danger- btn-sm btn-icon" name="button" onclick="hosp_profile.delSurgeon('<?php echo $rowData['ID'];?>')"><i class="fas fa-trash text-danger"></i></button>
                                </td>
                                <td><?php echo $rowData['sur_id']; ?></td>
                                <td><?php echo $rowData['sur_name']; ?></td>
                                <td>
                                  <?php
                                  if($rowData['sur_stillfunction'] == 1){
                                    ?>
                                    <div class="form-group mb-0">
                                      <label class="custom-switch mt-2">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked onclick="hosp_profile.setSurgeon('0', '<?php echo $rowData['ID'];?>')">
                                        <span class="custom-switch-indicator"></span>
                                      </label>
                                    </div>
                                    <?php
                                  }else{
                                    ?>
                                    <div class="form-group mb-0">
                                      <label class="custom-switch mt-2">
                                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" onclick="hosp_profile.setSurgeon('1', '<?php echo $rowData['ID'];?>')">
                                        <span class="custom-switch-indicator"></span>
                                      </label>
                                    </div>
                                    <?php
                                  }
                                  ?>
                                </td>
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

  <script src="../../assets/js/stisla.js"></script>

  <!-- Template JS File -->
  <script src="../../assets/js/scripts.js"></script>
  <script src="../../assets/js/custom.js"></script>

  <script src="../../assets/custom/js/config.js"></script>
  <script src="../../assets/custom/js/function.js"></script>
  <script src="../../assets/custom/js/authen.js"></script>
  <script src="../../assets/custom/js/authen-init.js"></script>
  <script src="../../assets/custom/js/hospital-profile.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      $('#tableZone1').niceScroll();

      $("#table-1").dataTable({
        "columnDefs": [
          { "width": "100px", "targets": 0 },
          { "sortable": false, "targets": [2,3] }
        ]
      });
    })

    $(function(){
      $("#txtSurid").keyup(function(){
        $key = $("#txtSurid").val()
        hosp_profile.get_surgeon($key)
      })
    })

    function setLocalData(id){
      $("#txtSurid").val(id)
      hosp_profile.get_surgeon(id)
    }
  </script>
</body>
</html>
