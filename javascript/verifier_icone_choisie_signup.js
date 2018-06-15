(function () {
    "use strict";
    document.addEventListener("DOMContentLoaded", initialiser);

    var submitbtn;
    var form;
    var iconDefault;
    var hiddenBtn;
    var iconChoisie;
    
    function initialiser(evt) {
        
        form = $(".signUpPage form");
        submitbtn = $("btnSignUp");
        iconDefault = $(".signUpPage figure");
        hiddenBtn = $("#hiddenSignUp");
        iconChoisie = $("#iconChoisie");
        
        iconDefault.css("border","3px solid #231F20");
        iconDefault.click(selectIconDefault);
        iconChoisie.change(selectIconChoisie);
    }
    
    
    function selectIconDefault(evt){
        var thiss = $(this);
        var chemin;
            
            
        iconDefault.css("border","3px solid #231F20");
        thiss.css("border","3px solid #FEC65C");

        chemin = thiss.data("icon");
            
        hiddenBtn.val(chemin);
            
        iconChoisie.val("");
            

        console.log(hiddenBtn.val());
        
        
        
    }
 
function selectIconChoisie(evt){
        var thiss = $(this);
        var chemin;

            
        iconDefault.css("border","3px solid #231F20");
            
        chemin = thiss.val();
        
        chemin = chemin.split("\\").reverse();

            
        hiddenBtn.val(chemin[0]);
             
        console.log(hiddenBtn.val());
    }

}());