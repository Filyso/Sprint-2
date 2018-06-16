(function () {
    "use strict";
    document.addEventListener("DOMContentLoaded", initialiser);

    var submitbtn;
    var message;
    var form;

    
    function initialiser(evt) {
        
        submitbtn = $("#editSubmit");
        form = $("#editForm");
        form.append("<p id=\"msg\" ></p>");
        message = $("#msg");
        submitbtn.click(verifier);
        submitbtn.click(preventDefault);

    }
    function preventDefault(evt){
        evt.preventDefault();
    }
    function verifier(evt){
        
        evt.preventDefault();
        
        submitbtn.text("Loading...");
        
        message.text("");
        
        submitbtn.off("click",verifier);
        
        $.post(
           '../php/scripts/script_form_edit.php', 
            {
                pseudo : $("#pseudoEdit").val(),
                nom : $("#lastnameEdit").val(),
                prenom : $("#nameEdit").val(),
                oldpass : $("#oldPass").val(),
                pass :  $("#passEdit").val(),
                passVerif : $("#passEdit").val(),
                cheminIcon : $("#hiddenEdit").val()
            },
            function(data){
                var lemsg = data;


                
                
                message.text(lemsg);
                
                submitbtn.text("Editer");
                submitbtn.click(verifier);
               
            },
            'text'
        );
        

    }
    


}());