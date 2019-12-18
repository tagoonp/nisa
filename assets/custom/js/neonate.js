var neonate = {
  saveDeviceIndwelling(){
    $check = 0
    $('.form-control').removeClass('is-invalid')
    if($('#txtSerial1').val() == ''){
      $check++
      $('#txtSerial1').addClass('is-invalid')
    }

    if($('#txtDate1').val() == ''){
      $check++
      $('#txtDate1').addClass('is-invalid')
    }

    if($('#txtLos1').val() == ''){
      $check++
      $('#txtLos1').addClass('is-invalid')
    }

    $cath = 0
    $vent = 0

    if($('#txtCath1').is(":checked")){
      $cath = 1;
    }

    if($('#txtVent1').is(":checked")){
      $vent = 1;
    }

    if($check != 0){
      return ;
    }

    var param = {
      uid: current_user,
      serial: $('#txtSerial1').val(),
      ddate: serializeDate($('#txtDate1').val()),
      los: $('#txtLos1').val(),
      cath: $cath,
      vent: $vent
    }

    preload.show()

    var jxr = $.post(conf.api + 'neonate?stage=saveDeviceIndwelling', param, function(){})
               .always(function(resp){
                 if(resp == 'Y'){
                   preload.hide()
                   swal({
                     title: "Success",
                     text: "Click OK to reload data.",
                     type: "success",
                     showCancelButton: false,
                     confirmButtonColor: "#DD6B55",
                     confirmButtonText: "OK",
                     closeOnConfirm: false },
                   function(){
                     window.location.reload()
                   });
                 }else if(resp == 'No data'){
                   preload.hide()
                   swal("Error", "Serial number not found in patient list", "error")
                 }else{
                   preload.hide()
                   swal("Error", "Can not record", "error")
                 }
               })


  },
  delPatient(id){
    var param = {
      uid: current_user,
      neo_id: id
    }
    swal({
      title: "Are you sure?",
      text: "You will not be able to recover this record!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "Cancel",
      closeOnConfirm: true
    },
    function(){
      preload.show()
      var jxr = $.post(conf.api + 'neonate?stage=delete_patient', param, function(){})
                 .always(function(resp){
                   if(resp == 'Y'){
                     setTimeout(()=>{
                       window.location.reload()
                     }, 500)
                   }else{
                     preload.hide()
                     swal("Error", "Can not delete record", "error")
                   }
                 })
    });
  },
  searchPatient(key){
    var param = {
      uid: current_user,
      serial: key
    }

    var jxr = $.post(conf.api + 'neonate?stage=info', param , function(){}, 'json')
               .always(function(snap){
                 if(fnc.snap(snap)){
                    snap.forEach(i=>{
                      $('#txtBw').val(i.neo_bw)
                      $('#txtGender').val(i.neo_sex)
                      $('#txtGa').val(i.neo_ga)
                      $('#txtDie').val(i.neo_die)
                      $('#txtHn').val(i.neo_hn)
                      $('#txtLos').val(i.neo_los)
                      if($('#txtAdm').length){
                          $('#txtAdm').data('daterangepicker').setStartDate(dateFormat(i.neo_admission));
                      }

                      if($('#txtDisc').length){
                          $('#txtDisc').data('daterangepicker').setStartDate(dateFormat(i.neo_discharge));
                      }

                      // $('#txtDisc').data('daterangepicker').setStartDate(dateFormat(i.));
                      $('.txtHn').val(i.neo_hn)
                      $('.txtGender').val(i.neo_sex)
                      $('.txtGa').val(i.neo_ga)
                      $('.txtBw').val(i.neo_bw)
                      $('.txtAdm').val(dateFormat(i.neo_admission))
                      $('.txtDisc').val(dateFormat(i.neo_discharge))

                      if($('#txtLos1').length){
                        calculateLoa1()
                      }
                    })
                 }else{
                   $('#txtBw').val('')
                   $('#txtGender').val('')
                   $('#txtGa').val('')
                   $('#txtDie').val('N')
                   $('#txtHn').val('')
                   $('#txtLos').val('1')
                   if($('#txtDisc').length){
                       $('#txtAdm').data('daterangepicker').setStartDate(dateFormat(getToday()));
                   }
                   if($('#txtDisc').length){
                       $('#txtDisc').data('daterangepicker').setStartDate(dateFormat(getToday()));
                   }


                 }
               })
  },
  savePatient(){
    $('.form-control').removeClass('is-invalid')
    $check = 0
    if($('#txtSerial').val() == ''){
      $('#txtSerial').addClass('is-invalid'); $check++
    }

    if($('#txtBw').val() == ''){
      $('#txtBw').addClass('is-invalid'); $check++
    }

    if($('#txtGender').val() == ''){
      $('#txtGender').addClass('is-invalid'); $check++
    }

    if($('#txtAdm').val() == ''){
      $('#txtAdm').addClass('is-invalid'); $check++
    }

    if($('#txtDisc').val() == ''){
      $('#txtDisc').addClass('is-invalid'); $check++
    }

    if($('#txtLos').val() == ''){
      $('#txtLos').addClass('is-invalid'); $check++
    }

    if($check != 0){
      return ;
    }

    var param = {
      uid: current_user,
      serial: $('#txtSerial').val(),
      hn: $('#txtHn').val(),
      gender: $('#txtGender').val(),
      ga: $('#txtGa').val(),
      bw: $('#txtBw').val(),
      adm: serializeDate($('#txtAdm').val()),
      disc: serializeDate($('#txtDisc').val()),
      die: $('#txtDie').val(),
      los: $('#txtLos').val()
    }

    var jxr = $.post(conf.api + 'neonate?stage=savenew', param , function(){})
               .always(function(resp){
                 if(resp == 'Y'){
                   preload.hide()
                   swal({
                     title: "Success",
                     text: "Click OK to reload data.",
                     type: "success",
                     showCancelButton: false,
                     confirmButtonColor: "#DD6B55",
                     confirmButtonText: "OK",
                     closeOnConfirm: false },
                   function(){
                     window.location.reload()
                   });
                 }else{
                   preload.hide();
                   swal("Error", "Can not record", "error")
                 }
               })
  }
}
