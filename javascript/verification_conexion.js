(function () {
    "use strict";
    document.addEventListener("DOMContentLoaded", initialiser);

    var submitbtn;
    var form;
    
    function initialiser(evt) {
        
        
        
        submitbtn = $("#connexionBtn");
        form = $(".popup form");
        
        
        submitbtn.click(verifier);
        

    }
    
    function verifier(evt){
        
        console.log($("#pseudo").val());
        console.log($("#passwd").val());
        
        $.post(
           '../php/script_login.php', 
            {
                pseudo : $("#pseudo").val(),
                passwd : $("#passwd").val()
            },
            function(data){
                
                
                if(data == "Echec"){
                    
                    form.setCustomValidity("");
                    
                    $(".popup form h2").html("<p>L'identifiant ou(et) le mot de passe est invalide.</p>")
                    
                }
            
            },
            'text'
        );
        
        
    }


}());