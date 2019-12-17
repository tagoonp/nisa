var authen = {
  login(){
    $jxr = $.post(conf.api + 'authentication?stage=login', {username: $('#email').val(), password: $('#password').val()}, function(){}, 'json')
            .always(function(snap){
              if(fnc.snap(snap)){
                snap.forEach(i=>{
                  window.localStorage.setItem(conf.prefix + 'uid', i.uid)
                  window.localStorage.setItem(conf.prefix + 'role', i.role)
                  window.location = './' + i.role + '/index?uid=' + i.uid + '&role=' + i.role
                })
                // event.preventDefault();
                // event.stopPropagation();
              }else{
                alert('Invalid user nis_useraccount')
              }
            })

    // event.preventDefault();
    // event.stopPropagation();
  }
}
