(function () {
    "use strict";
    document.addEventListener("DOMContentLoaded", initialiser);

    var submitbtn;
    var form;
    
    function initialiser(evt) {
        
        submitbtn = $("#connexionBtn");
        form = $(".popup form");
        
        form.append("<p></p>");
        
        submitbtn.click(verifier);

    }
    
    function verifier(evt){
        evt.preventDefault();
        

        
        $.post(
           '../php/script_login.php', 
            {
                pseudo : $("#pseudo").val(),
                pass : $("#passwd").val()
            },
            function(data){
                
                
                if(data == "Echec"){
                    
                    $("#pseudo").val("");
                    $("#passwd").val("");
                    $(".popup form p").text("Le couple identifiant/mot de passe est invalide");
                    
                    
                }else if(data == "Connexion"){
                    form.submit();
                }else if(data == "nonVerif"){
                    
                    $("#pseudo").val("");
                    $("#passwd").val("");
                    $(".popup form p").text("L'email de vérification qui vous a été envoyé n'a pas été vérifié  ");
                       
                }
                
            
            },
            'text'
        );
        
        
    }


}());