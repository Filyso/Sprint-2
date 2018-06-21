(function () {
    "use strict";
    document.addEventListener("DOMContentLoaded", initialiser);

    var submitbtn;
    var form;
    var iconDefault;
    var hiddenBtn;
    var iconChoisie;
    
    var submitbtnEd;
    var formEd;
    var iconDefaultEd;
    var hiddenBtnEd;
    var iconChoisieEd;
    
    function initialiser(evt) {
        
        form = $(".signUpPage form");
        submitbtn = $("#btnSignUp");
        iconDefault = $("#signUpForm figure");
        hiddenBtn = $("#hiddenSignUp");
        iconChoisie = $("#iconChoisie");
        
        formEd = $("#editFormIcone form");
        submitbtnEd = $("#editSubmitIcone");
        iconDefaultEd = $("#editFormIcone figure");
        hiddenBtnEd = $("#hiddenEdit");
        iconChoisieEd = $("#iconChoisieEdit");
        
        
        
        iconDefault.css("border","3px solid #231F20");
        iconDefault.click(selectIconDefaultSU);
        iconChoisie.change(selectIconChoisieSU);
        
        iconDefaultEd.css("border","3px solid #231F20");
        iconDefaultEd.click(selectIconDefaultEd);
        iconChoisieEd.change(selectIconChoisieEd);
    }
    
    
    function selectIconDefaultSU(evt){
        var thiss = $(this);
        var chemin;
            
            
        iconDefault.css("border","3px solid #231F20");
        thiss.css("border","3px solid #FEC65C");

        chemin = thiss.data("icon");
            
        hiddenBtn.val(chemin);
            
        iconChoisie.val("");
            

      
        
        
    }
 
    function selectIconChoisieSU(evt){
        var thiss = $(this);
        var chemin;

        iconDefault.css("border","3px solid #231F20");
            
        chemin = thiss.val();
        
        chemin = chemin.split("\\").reverse();

            
        hiddenBtn.val(chemin[0]);
             
      
    }
    
    function selectIconDefaultEd(evt){
        var thissEd = $(this);
        var cheminEd;
            
            
        iconDefaultEd.css("border","3px solid #231F20");
        thissEd.css("border","3px solid #FEC65C");

        cheminEd = thissEd.data("icon");
            
        hiddenBtnEd.val("../images/icons/default/"+cheminEd);
            
        iconChoisieEd.val("");
            

    
        
        
        
    }
 
function selectIconChoisieEd(evt){
        var thissEd = $(this);
        var cheminEd;

        iconDefaultEd.css("border","3px solid #231F20");
            
        cheminEd = thissEd.val();
        
        cheminEd = cheminEd.split("\\").reverse();

            
        hiddenBtnEd.val(cheminEd[0]);

    }
    

}());