(function () {
    "use strict";
    document.addEventListener("DOMContentLoaded", initialiser);

    var submitbtnPerso;
    var submitbtnPass;

    var messagePerso;
    var messagePass;

    var formPerso;
    var formPass;


    
    function initialiser(evt) {
        
        submitbtnPerso = $("#editSubmitPerso");
        submitbtnPass = $("#editSubmitPass");

        
        formPerso = $("#editFormPerso");
        formPass = $("#editFormPass");

        
        
        formPerso.append("<p id=\"msg1\" ></p>");
        formPass.append("<p id=\"msg2\" ></p>");

        
        messagePerso = $("#msg1");
        messagePass = $("#msg2");

        
        submitbtnPerso.click(editerPerso);
        submitbtnPass.click(editerPass);

        
        submitbtnPerso.click(preventDefault);
        submitbtnPass.click(preventDefault);


    }
    function preventDefault(evt){
        evt.preventDefault();
    }
    
    
    function editerPerso(evt){
        
        evt.preventDefault();
        
        submitbtnPerso.text("Loading...");
        
        messagePerso.text("");
        
        submitbtnPerso.off("click",editerPerso);
        
        $.post(
           '../php/scripts/script_form_edit_perso.php', 
            {
                pseudo : $("#pseudoEdit").val(),
                nom : $("#lastnameEdit").val(),
                prenom : $("#nameEdit").val()
            },
            function(data){
                var lemsg = data;


                messagePerso.text(lemsg);
                
                submitbtnPerso.text("Editer");
                submitbtnPerso.click(editerPerso);
               
            },
            'text'
        );
    }
    function editerPass(evt){
        
        evt.preventDefault();
        
        submitbtnPass.text("Loading...");
        
        messagePass.text("");
        
        submitbtnPass.off("click",editerPass);
        
        $.post(
           '../php/scripts/script_form_edit_pass.php', 
            {
                oldpass : $("#oldPass").val(),
                pass :  $("#passEdit").val(),
                passVerif : $("#passverifEdit").val()
            },
            function(data){
                var lemsg = data;
                console.log(data);

                messagePass.text(lemsg);
                
                submitbtnPass.text("Editer");
                submitbtnPass.click(editerPass);
                $("#oldPass").val("");
                $("#passEdit").val("");
                $("#passverifEdit").val("");
            },
            'text'
        );
    }
    
}());