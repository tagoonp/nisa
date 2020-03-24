// var conf = {
//     domain: 'http://localhost/nisa/',
//     api: 'http://localhost/nisa/controller/',
//     prefix: 'nsllc_',
//     mail_user: 'rmismedpsu@gmail.com',
//     mail_key: 'cm1pc21lZHBzdUBnbWFpbC5jb20yMDE5LTEwLTIyIDIxOjU4OjU3MTI0LjEyMi40Mi4yNDU=',
// }


var conf = {
    domain: 'https://fxplor.com/nisa/',
    api: 'https://fxplor.com/nisa/controller/',
    prefix: 'nsllc_',
    mail_user: 'rmismedpsu@gmail.com',
    mail_key: 'cm1pc21lZHBzdUBnbWFpbC5jb20yMDE5LTEwLTIyIDIxOjU4OjU3MTI0LjEyMi40Mi4yNDU=',
}

// =======
// var conf = {
//     domain: 'https://fxplor.com/nisa/',
//     api: 'https://fxplor.com/nisa/controller/',
//     prefix: 'nsllc_',
//     mail_user: 'rmismedpsu@gmail.com',
//     mail_key: 'cm1pc21lZHBzdUBnbWFpbC5jb20yMDE5LTEwLTIyIDIxOjU4OjU3MTI0LjEyMi40Mi4yNDU=',
// }
// >>>>>>> a18bf235f48ea2018eb41d40da5ce77e78d5ff3f

var current_user = window.localStorage.getItem(conf.prefix + 'uid')
var current_role = window.localStorage.getItem(conf.prefix + 'role')

// var conf = {
//     domain: 'http://rmis2.medicine.psu.ac.th/rmis5/',
//     api: 'http://rmis2.medicine.psu.ac.th/rmis5/controller/',
//     prefix: 'rmis5_'
// }
