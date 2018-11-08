//Script for disable the possibility to choose a date lower than today (in create box)

var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1;
var yyyy = today.getFullYear();

if(dd<10){
    dd='0'+dd
} 
if(mm<10){
    mm='0'+mm
} 

today = yyyy + '-' + mm + '-' + dd;
document.getElementById("inputdate").setAttribute("min", today);