/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

var engMonth = {};
engMonth['Jan'] = '01';
engMonth['Feb'] = '02';
engMonth['Mar'] = '03';
engMonth['Apr'] = '04';
engMonth['May'] = '05';
engMonth['Jun'] = '06';
engMonth['Jul'] = '07';
engMonth['Aug'] = '08';
engMonth['Sep'] = '09';
engMonth['Oct'] = '10';
engMonth['Nov'] = '11';
engMonth['Dec'] = '12';

var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
 "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

function dateFormat(d){
  var t = new Date(d);
  return t.getDate()+'-'+monthNames[t.getMonth()]+'-'+t.getFullYear();
}

function serializeDate(date) {
  var returnVal = date
  if(date != null){
    var b1 = date.split('-')
    returnVal = b1[2] + '-' + engMonth[b1[1]] + '-' + b1[0]
  }
  return returnVal
}

function calDateDiff(start, end){

  var diff =  Math.floor(
    (
        Date.parse(
            end.replace(/-/g,'\/')
    ) - Date.parse(
            start.replace(/-/g,'\/')
    )
    ) / 86400000);

  return diff
}

function getToday(){
  var d = new Date(),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;

    return [year, month, day].join('-');
}
