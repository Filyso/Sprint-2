(function () {
    "use strict";
    document.addEventListener("DOMContentLoaded", initialiser);

    var submitbtn;

    function initialiser(evt) {

        submitbtn = $("#connexionBtn");

        submitbtn.click(verifier);


    }
    
    function verifier(evt){
        
        $.post(
           '../php/script_login.php', 
            {
                pseudo : $("#pseudo").val(),
                passwd : $("#passwd").val()
            },
            function(data){
                
                if(data == "Echec"){
                    
                    $(".popup form h2").html("<p>L'identifiant ou(et) le mot de passe est invalide.</p>")
                    
                }
            
            },
            'text'
        );
        
    }


}());