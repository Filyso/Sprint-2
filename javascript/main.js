

document.addEventListener("DOMContentLoaded",initialiser);

var timerMilli;
var timerSec;

function initialiser(evt){

    
    window.setInterval(increment,10);
    
}


function increment(evt){
    timerSec = 0;
    timerMilli = 0;
    
    timerMilli = timerMilli + 1;
    
    if(timerMilli >= 100){
        timerMilli = 0;
        timerSec = timerSec + 1;
    }
    
    
}