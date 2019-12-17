var hosp_profile = {
  saveHospchar(){
    $('.form-control').removeClass('is-invalid')
    $check = 0
    if($('#txtHname').val() == ''){
      $check++
      $('#txtHname').addClass('is-invalid')
    }

    if($('#txtCountry').val() == ''){
      $check++
      $('#txtCountry').addClass('is-invalid')
    }

    if($('#txtBedsize').val() == ''){
      $check++
      $('#txtBedsize').addClass('is-invalid')
    }

    if($('#txtBedsize').val() == ''){
      $check++
      $('#txtBedsize').addClass('is-invalid')
    }

    if($('#txtType').val() == ''){
      $check++
      $('#txtType').addClass('is-invalid')
    }

    if($('#txtSchool').val() == ''){
      $check++
      $('#txtSchool').addClass('is-invalid')
    }

    if($('#txtPvent').val() == ''){
      $check++
      $('#txtPvent').addClass('is-invalid')
    }

    if($('#txtPdian').val() == ''){
      $check++
      $('#txtPdian').addClass('is-invalid')
    }

    if($check != 0){
      return ;
    }

    var param = {
      uid: current_user,
      name: $('#txtHname').val(),
      address: $('#txtAddress').val(),
      country: $('#txtCountry').val(),
      bedsize: $('#txtBedsize').val(),
      type: $('#txtType').val(),
      school: $('#txtSchool').val(),
      pvent: $('#txtPvent').val(),
      pdian: $('#txtPdian').val()
    }

    var kx4 = $.post(conf.api + 'hospital-profile?stage=get_ward', param, function(){}, 'json')

  },
  delWard(id){
    var param = {
      uid: current_user,
      wid: id
    }

    swal({
      title: "Are you sure?",
      text: "You will not be able to recover this imaginary record!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "Cancel",
      closeOnConfirm: true
    },
    function(){
      preload.show()
      var jxr = $.post(conf.api + 'hospital-profile?stage=delete_ward', param, function(){})
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
  get_ward(id){
    var param = {
      uid: current_user,
      code: id
    }
    var kx4 = $.post(conf.api + 'hospital-profile?stage=get_ward', param, function(){}, 'json')
               .always(function(snap){
                 if(fnc.snap(snap)){
                   snap.forEach(i=>{
                     $('#txtName').val(i.ward_name)
                     $('#txtPhone').val(i.tel)
                     $('#txtType').val(i.ward_type)
                   })
                 }else{
                   $('#txtName').val('')
                   $('#txtPhone').val('')
                   $('#txtType').val('')
                 }
               })
  },
  recordWard(){
    $('.form-control').removeClass('is-invalid')
    $check = 0
    if($('#txtCode').val() == ''){
      $check++
      $('#txtCode').addClass('is-invalid')
    }

    if($('#txtName').val() == ''){
      $check++
      $('#txtName').addClass('is-invalid')
    }

    if($('#txtType').val() == ''){
      $check++
      $('#txtType').addClass('is-invalid')
    }

    if($check != 0){
      return ;
    }

    var param = {
      uid: current_user,
      code: $('#txtCode').val(),
      name: $('#txtName').val(),
      phone: $('#txtPhone').val(),
      wtype: $('#txtType').val()
    }

    preload.show()

    var kx4 = $.post(conf.api + 'hospital-profile?stage=set_ward', param, function(){})
               .always(function(resp){
                 console.log(resp);
                 if(resp == 'Y'){
                    preload.hide()
                    swal({
                      title: "Success",
                      text: "Click OK to reload ward info.",
                      type: "success",
                      showCancelButton: false,
                      confirmButtonColor: "#DD6B55",
                      confirmButtonText: "OK",
                      closeOnConfirm: false },
                    function(){
                      window.location.reload()
                    });
                 }else{
                   preload.hide()
                   swal("Error", "Can not record", "error")
                 }
               })
  },
  setSurgeon(to, id){
    var param = {
      uid: current_user,
      sid: id,
      to: to
    }
    var jxr = $.post(conf.api + 'hospital-profile?stage=set_surgeon_still', param, function(){})
  },
  delSurgeon(id){
    var param = {
      uid: current_user,
      sid: id
    }

    swal({
      title: "Are you sure?",
      text: "You will not be able to recover this imaginary record!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "Cancel",
      closeOnConfirm: true
    },
    function(){
      preload.show()
      var jxr = $.post(conf.api + 'hospital-profile?stage=delete_surgeon', param, function(){})
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
  recodeSurgeon(){
    $('.form-control').removeClass('is-invalid')
    $check = 0
    if($('#txtSurid').val() == ''){
      $check++
      $('#txtSurid').addClass('is-invalid')
    }

    if($('#txtSurgeonname').val() == ''){
      $check++
      $('#txtSurgeonname').addClass('is-invalid')
    }

    if($('#txtStill').val() == ''){
      $check++
      $('#txtStill').addClass('is-invalid')
    }

    if($check != 0){
      return ;
    }

    var param = {
      uid: current_user,
      code: $('#txtSurid').val(),
      name: $('#txtSurgeonname').val() ,
      still: $('#txtStill').val()
    }

    preload.show()

    var kx4 = $.post(conf.api + 'hospital-profile?stage=set_surgeon', param, function(){})
               .always(function(resp){
                 console.log(resp);
                 if(resp == 'Y'){
                    preload.hide()
                    swal({
                      title: "Success",
                      text: "Click OK to reload surgeon info.",
                      type: "success",
                      showCancelButton: false,
                      confirmButtonColor: "#DD6B55",
                      confirmButtonText: "OK",
                      closeOnConfirm: false },
                    function(){
                      window.location.reload()
                    });
                 }else{
                   preload.hide()
                   swal("Error", "Can not record", "error")
                 }
               })
  },
  get_surgeon(id){
    var param = {
      uid: current_user,
      sid: id
    }
    var kx4 = $.post(conf.api + 'hospital-profile?stage=get_surgeon', param, function(){}, 'json')
               .always(function(snap){
                 console.log(snap);
                 if(fnc.snap(snap)){

                   snap.forEach(i=>{
                     $('#txtSurgeonname').val(i.sur_name)
                     $('#txtStill').val(i.sur_stillfunction)
                   })
                 }else{
                   $('#txtSurgeonname').val('')
                   $('#txtStill').val('')
                 }
               })
  },
  delete_nicu(id){
    swal({
      title: "Are you sure?",
      text: "You will not be able to recover this imaginary record!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "Cancel",
      closeOnConfirm: true
    },
    function(){
      preload.show()
      var param = {
        uid: current_user,
        nicu_id: id
      }
      var jxr = $.post(conf.api + 'hospital-profile?stage=delete_nicu', param, function(){})
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
  nicu(stage){
    if(stage == 'update'){
      $('.form-control').removeClass('is-invalid')
      if($('#txtLevel').val() == ''){
        $('#txtLevel').addClass('is-invalid')
        return ;
      }

      var param = {
        uid: current_user,
        nicu: $('#txtLevel').val()
      }

      preload.show()

      var jxr = $.post(conf.api + 'hospital-profile?stage=nicu', param, function(){})
                 .always(function(resp){
                   if(resp == 'Y'){
                     setTimeout(()=>{
                       window.location.reload()
                     }, 500)
                   }else{
                     preload.hide()
                     swal("Error", "Can not record", "error")
                   }
                 })
    }
  }
}
