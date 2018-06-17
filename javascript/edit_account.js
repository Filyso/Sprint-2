(function () {
    "use strict";
    document.addEventListener("DOMContentLoaded", initialiser);

    var submitbtnPerso;
    var submitbtnPass;
    var submitbtnIcone;
    var messagePerso;
    var messagePass;
    var messageIcone;
    var formPerso;
    var formPass;
    var formIcone;

    
    function initialiser(evt) {
        
        submitbtnPerso = $("#editSubmitPerso");
        submitbtnPass = $("#editSubmitPass");
        submitbtnIcone = $("#editSubmitIcone");
        
        formPerso = $("#editFormPerso");
        formPass = $("#editFormPass");
        formIcone = $("#editFormIcone");
        
        
        formPerso.append("<p id=\"msg1\" ></p>");
        formPass.append("<p id=\"msg2\" ></p>");
        formIcone.append("<p id=\"msg3\" ></p>");
        
        messagePerso = $("#msg1");
        messagePass = $("#msg2");
        messageIcone = $("#msg3");
        
        submitbtnPerso.click(editerPerso);
        submitbtnPass.click(editerPass);
        submitbtnIcone.click(editerIcone);
        
        submitbtnPerso.click(preventDefault);
        submitbtnPass.click(preventDefault);
        submitbtnIcone.click(preventDefault);

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
                passVerif : $("#passEdit").val()
            },
            function(data){
                var lemsg = data;


                messagePass.text(lemsg);
                
                submitbtnPass.text("Editer");
                submitbtnPass.click(editerPass);
               
            },
            'text'
        );
    }
    function editerIcone(evt){
        
        evt.preventDefault();
        
        submitbtnIcone.text("Loading...");
        
        messageIcone.text("");
        
        submitbtnIcone.off("click",editerIcone);
        
        $.post(
           '../php/scripts/script_form_edit_icone.php', 
            {
                cheminIcon : $("#hiddenEdit").val()
            },
            function(data){
                var lemsg = data;


                messageIcone.text(lemsg);
                
                submitbtnIcone.text("Editer");
                submitbtnIcone.click(editerIcone);
               
            },
            'text'
        );
    }
    


}());