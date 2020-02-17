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

    #chart {
      max-width: 100%;
      height: 300px;
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
                            <select class="form-control c-input" name="txtStartmonth" id="txtStartmonth">
                              <option value="">MM</option>
                              <option value="01">1</option>
                              <option value="02">2</option>
                              <option value="03">3</option>
                              <option value="04">4</option>
                              <option value="05">5</option>
                              <option value="06">6</option>
                              <option value="07">7</option>
                              <option value="08">8</option>
                              <option value="09">9</option>
                              <option value="10">10</option>
                              <option value="11">11</option>
                              <option value="12">12</option>
                            </select>
                          </div>
                          <div class="col-8">
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
                      </div>
                      <div class="col-12 col-sm-4">
                        <div class="form-group row">
                          <label for="" class="col-12 col-form-label">To :  <span class="text-danger">*</span></label>
                          <div class="col-4">
                            <select class="form-control c-input" name="txtEndmonth" id="txtEndmonth">
                              <option value="">MM</option>
                              <option value="01">1</option>
                              <option value="02">2</option>
                              <option value="03">3</option>
                              <option value="04">4</option>
                              <option value="05">5</option>
                              <option value="06">6</option>
                              <option value="07">7</option>
                              <option value="08">8</option>
                              <option value="09">9</option>
                              <option value="10">10</option>
                              <option value="11">11</option>
                              <option value="12">12</option>
                            </select>
                          </div>
                          <div class="col-8">
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
                      </div>
                      <div class="col-12 col-sm-4">
                        <div class="form-group row">
                          <label for="" class="col-12 col-form-label">Period for report :  <span class="text-danger">*</span></label>
                          <div class="col-12">
                            <select class="form-control c-input" name="txtPeriod" id="txtPeriod">
                              <option value="">-- Choose period --</option>
                              <option value="Monthly">Monthly</option>
                              <option value="Bimonth">Bimonth</option>
                              <option value="Quarter">Quarter</option>
                              <option value="Trimester">Trimester</option>
                              <option value="SemiAnnual">SemiAnnual</option>
                              <option value="Annual">Annual</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row mb-0">
                      <label for="" class="col-12 col-sm-2 col-form-label">Site of infection : <span class="text-danger">*</span></label>
                      <div class="col-12 col-sm-3">
                        <div class="">
                          <label class="custom-switch mt-2 pl-0">
                            <input type="checkbox" name="txtCath1" id="txtSite1" class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description text-dark">CLABSI</span>
                          </label>
                        </div>
                      </div>
                      <div class="col-12 col-sm-3">
                        <div class="">
                          <label class="custom-switch mt-2 pl-0">
                            <input type="checkbox" name="txtCath1" id="txtSite2" class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description text-dark">PedVAE</span>
                          </label>
                        </div>
                      </div>
                      <div class="col-12 col-sm-4 text-right">
                        <button type="button" class="btn btn-primary" name="button" onclick="neonate.generateReport()">Genarate report</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- .card  -->

                <div class="dn" id="table-zone">
                  <div class="row pb-2">
                    <div class="col-5">
                        <h6 class="text-white">Table report</h6>
                    </div>
                    <div class="col-7 text-right">
                      <button type="button" class="btn btn-primary btn-sm dn" style="margin-top: -10px;">CLABSI</button>
                      <button type="button" class="btn btn-primary btn-sm dn" style="margin-top: -10px;">PedVAE</button>
                    </div>
                  </div>
                  <div class="card dn" id="tablereportCLASBI">
                    <div class="card-header bg-primary-">
                      <h4 class="text-white-">Table : standardized ratio of CLABSI in NICU</h4>
                      <div class="card-header-action dropdown">
                        <a href="#" id="btnChartCLABSI" class="btn btn-danger"><i class="fas fa-chart-line text-white"></i> Chart</a>
                        <a href="#" id="btnDownloadCLABSI" class="btn btn-danger"><i class="fas fa-download text-white"></i> Export</a>
                      </div>
                    </div>
                    <div class="card-body p-0">
                      <div class="" id="tmpDivCLASBI">

                      </div>
                    </div>
                  </div>

                  <div class="card dn" id="tablereportPedVAE">
                    <div class="card-header bg-primary-">
                      <h4 class="text-white-">Table : standardized ratio of PedVAE in NICU</h4>
                      <div class="card-header-action dropdown">
                        <a href="#" id="btnChartPedVAE" class="btn btn-danger"><i class="fas fa-chart-line text-white"></i> Chart</a>
                        <a href="#" id="btnDownloadPedVAE" class="btn btn-danger"><i class="fas fa-download text-white"></i> Export</a>
                      </div>
                    </div>
                    <div class="card-body p-0">
                      <div class="" id="tmpDivPedVAE">

                      </div>
                    </div>
                  </div>


                </div>
                <!-- # table-zone -->

                <div class="dn" id="chart-zone">
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
  <!-- <script src="../../node_modules/apexcharts.js/dist/apexcharts.js"></script>
  <script src="../../node_modules/jsPDF-1.3.2/dist/jspdf.min.js"></script> -->
  <script src="../../node_modules/fusioncharts/js/fusioncharts.js"></script>
  <script src="../../node_modules/fusioncharts/js/themes/fusioncharts.theme.fusion.js"></script>

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
      // $("#tableQuarter").tableExport();

      preload.hide()

      // var options = {
      //               chart: {
      //                 type: 'line'
      //               },
      //               series: [{
      //                 name: 'SIR o',
      //                 data: [30,40,45,50,49,60,70,91,125]
      //               }],
      //               xaxis: {
      //                 categories: ['1st', '2nd', '3rd', '4th']
      //               }
      //             }



    })

    $(function(){

      $('#btnDownloadCLABSI').click(function(){
        var table =  $('#tmpDivCLASBI').html();
        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");
        var is_edge = navigator.userAgent.toLowerCase().indexOf('edge') > -1;
        if(is_edge === true) {
           sa = true;
          var blob = new Blob( [ table ], { type: "text/html"} );
          window.navigator.msSaveOrOpenBlob( blob, "output.xls" );
        } else
        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
        {
            txtArea1.document.open("txt/html", "replace");
            txtArea1.document.write(table);
            txtArea1.document.close();
            txtArea1.focus();
            sa = txtArea1.document.execCommand("SaveAs", true, "DataExport_CLABSI_<?php echo $sysdateu; ?>.xls");
        } else {               //other browser not tested on IE 11
            // sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(table));
            var link = document.createElement('a');
            var data_type = 'data:application/vnd.ms-excel';
            var table_html = encodeURIComponent(table);
            link.href = data_type + ', ' + table_html;
            link.download = 'DataExport_CLABSI_<?php echo $sysdateu; ?>.xls';
            link.click();
            // e.preventDefault();
        }
        return (sa);

      })

      $('#btnDownloadPedVAE').click(function(){
        var table =  $('#tmpDivPedVAE').html();
        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");
        var is_edge = navigator.userAgent.toLowerCase().indexOf('edge') > -1;
        if(is_edge === true) {
           sa = true;
          var blob = new Blob( [ table ], { type: "text/html"} );
          window.navigator.msSaveOrOpenBlob( blob, "output.xls" );
          console.log('ssss');
        } else
        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
        {
          console.log('aaaa');
            txtArea1.document.open("txt/html", "replace");
            txtArea1.document.write(table);
            txtArea1.document.close();
            txtArea1.focus();
            sa = txtArea1.document.execCommand("SaveAs", true, "DataExport_PedVAE_<?php echo $sysdateu; ?>.xls");
        } else {               //other browser not tested on IE 11
            // sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(table) +'; filename=DataExport_PedVAE_xls;');
            var link = document.createElement('a');
            var data_type = 'data:application/vnd.ms-excel';
            var table_html = encodeURIComponent(table);
            link.href = data_type + ', ' + table_html;
            link.download = 'DataExport_PedVAE_<?php echo $sysdateu; ?>.xls';
            link.click();
            // e.preventDefault();
        }
        return (sa);
      })

      $('#btnChartCLABSI').click(function(){
        $('#chartCLABSIModal').modal()
        console.log('CL -> ' + $('#gran_total_CLABSI').text());
        console.log('SIR Q1 -> ' + $('#sir_1').text());
        console.log('SIR Q2 -> ' + $('#sir_2').text());
        console.log('SIR Q3 -> ' + $('#sir_3').text());
        console.log('SIR Q4 -> ' + $('#sir_4').text());
        var cl = parseFloat($('#gran_total_CLABSI').text());
        var q1 = parseFloat($('#sir_1').text());
        var q2 = parseFloat($('#sir_2').text());
        var q3 = parseFloat($('#sir_3').text());
        var q4 = parseFloat($('#sir_4').text());
        // Create a JSON object to store the chart configurations
        const chartData = [{
            "label": "Venezuela",
            "value": "290"
        }, {
            "label": "Saudi",
            "value": "260"
        }, {
            "label": "Canada",
            "value": "180"
        }, {
            "label": "Iran",
            "value": "140"
        }, {
            "label": "Russia",
            "value": "115"
        }, {
            "label": "UAE",
            "value": "100"
        }, {
            "label": "US",
            "value": "30"
        }, {
            "label": "China",
            "value": "30"
        }];

        //STEP 3 - Chart Configurations
        const chartConfig = {
          type: 'column2d',
          renderAt: 'chart',
          width: '100%',
          height: '400',
          dataFormat: 'json',
          dataSource: {
              // Chart Configuration
              "chart": {
                  "caption": "Countries With Most Oil Reserves [2017-18]",
                  "subCaption": "In MMbbl = One Million barrels",
                  "xAxisName": "Country",
                  "yAxisName": "Reserves (MMbbl)",
                  "numberSuffix": "K",
                  "theme": "fusion",
                  exportEnabled: "1",
                  },
              // Chart Data
              "data": chartData
          },

        };

        FusionCharts.ready(function(){
          var fusioncharts = new FusionCharts(chartConfig);
          fusioncharts.render();
        });

        //         var options = {
        //   chart: {
        //     height: 350,
        //     type: "line",
        //     stacked: false,
        //     toolbar: {
        //         show: true,
        //         tools: {
        //           download: true,
        //           selection: true,
        //           zoom: true,
        //           zoomin: true,
        //           zoomout: true,
        //           pan: true,
        //           reset: true | '<img src="/static/icons/reset.png" width="20">',
        //           customIcons: []
        //         },
        //         autoSelected: 'zoom'
        //       },
        //   },
        //   dataLabels: {
        //     enabled: false
        //   },
        //   colors: ["#FF1654", "#247BA0"],
        //   series: [
        //     {
        //       name: "Series A",
        //       data: [1.4, 2, 2.5, 1.5, 2.5, 2.8, 3.8, 4.6]
        //     },
        //     {
        //       name: "Series B",
        //       data: [20, 29, 37, 36, 44, 45, 50, 58]
        //     }
        //   ],
        //   stroke: {
        //     width: [4, 4]
        //   },
        //   plotOptions: {
        //     bar: {
        //       columnWidth: "20%"
        //     }
        //   },
        //   xaxis: {
        //     categories: [2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016]
        //   },
        //   yaxis: [
        //     {
        //       axisTicks: {
        //         show: true
        //       },
        //       axisBorder: {
        //         show: true,
        //         color: "#FF1654"
        //       },
        //       labels: {
        //         style: {
        //           color: "#FF1654"
        //         }
        //       },
        //       title: {
        //         text: "Series A"
        //       }
        //     },
        //     {
        //       opposite: true,
        //       axisTicks: {
        //         show: true
        //       },
        //       axisBorder: {
        //         show: true,
        //         color: "#247BA0"
        //       },
        //       labels: {
        //         style: {
        //           color: "#247BA0"
        //         }
        //       },
        //       title: {
        //         text: "Series B"
        //       }
        //     }
        //   ],
        //   tooltip: {
        //     shared: false,
        //     intersect: true,
        //     x: {
        //       show: false
        //     }
        //   },
        //   legend: {
        //     horizontalAlign: "left",
        //     offsetX: 40
        //   }
        // };
        //
        // var chart = new ApexCharts(document.querySelector("#chart"), options);
        //
        // chart.render();

      })

      $('#link').click(function(){
        var svg = $("#chart").html();
        var b64 = Base64.encode(svg);
        console.log(b64);
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

  <!-- Modal -->
  <div class="modal fade" id="chartCLABSIModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div id="chart"></div>
          <a href="#" id="link">asd</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
