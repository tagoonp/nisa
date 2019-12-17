var authen_init = {
  init(){
    if((current_user == null) || (current_role == null)){
      window.localStorage.removeItem(conf.prefix + 'uid')
      window.localStorage.removeItem(conf.prefix + 'role')
      window.location = '../index'
    }

    setFontsize()
    authen_init.getUserProfile()
  },
  getUserProfile(){
    var param = {
      uid: current_user
    }
    var jxr = $.post(conf.api + 'authentication?stage=get_profile', param, function(){}, 'json')
               .always(function(snap){
                 if(fnc.snap(snap)){
                   snap.forEach(i=>{
                     $('.userFullname').html(i.fname + ' ' + i.lname)
                   })
                   preload.hide()
                 }else{
                   window.localStorage.removeItem(conf.prefix + 'uid')
                   window.localStorage.removeItem(conf.prefix + 'role')
                   window.location = '../index'
                 }
               })
  }
}

authen_init.init()
