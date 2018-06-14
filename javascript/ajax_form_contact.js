(function () {
    "use strict";
    document.addEventListener("DOMContentLoaded", initialiser);

    var submitbtn1;
    var submitbtn2;
    var form1;
    var form2;
    
    function initialiser(evt) {
        
        submitbtn1 = $("#formContactSub1");
        submitbtn2 = $("#formContactSub2");
        
        form1 = $("#formContact1");
        form2 = $("#formContact2");
        
        form1.append("<p></p>");
        form2.append("<p></p>");
        
        submitbtn1.click(verifier1);
        submitbtn2.click(verifier2);

        submitbtn1.click(preventDefault);
        submitbtn2.click(preventDefault);
    }
    function preventDefault(evt){
        evt.preventDefault();
    }
    function verifier1(evt){
        evt.preventDefault();
        $("#formContact1 p").text("Loading...");
        submitbtn1.off("click",verifier1);
        
        $.post(
           '../php/scripts/script_form_contact.php', 
            {
                sujet : $("#formContactSujet1").val(),
                message : $("#formContactMsg1").val()
            },
            function(data){
                
                console.log(data);
                if(data == "Echec"){
          
                    $("#formContactSujet1").val("");
                    $("#formContactMsg1").val("");
                    $("#formContact1 p").text("Vous devez être connecté pour utiliser ce formulaire");
                    
                    submitbtn1.click(verifier1);
                }else if(data == "Reussie"){
                    
                    $("#formContactSujet1").val("");
                    $("#formContactMsg1").val("");
                    $("#formContact1 p").text("Votre message a bien été envoyé");
                    
                    submitbtn1.click(verifier1);
                    
                    
                    
                    
                }else if(data == "vide"){
                    
                    $("#formContactSujet1").val("");
                    $("#formContactMsg1").val("");
                    $("#formContact1 p").text("Le formulaire n'est pas complet");
                    
                    submitbtn1.click(verifier1);
                    
                }else{
                    $("#formContactSujet1").val("");
                    $("#formContactMsg1").val("");
                    $("#formContact1 p").text("Un problème est survenue. Il se peut que se service soit momentanément indisponible.");
                    
                    submitbtn1.click(verifier1);
                }
            },
            'text'
        );

    }
    function verifier2(evt){
        evt.preventDefault();
        $("#formContact2 p").text("Loading...");
        submitbtn1.off("click",verifier2);
        
        $.post(
           '../php/scripts/script_form_contact.php', 
            {
                sujet : $("#formContactSujet2").val(),
                message : $("#formContactMsg2").val()
            },
            function(data){
                
                console.log(data);
                if(data == "Echec"){
          
                    $("#formContactSujet2").val("");
                    $("#formContactMsg2").val("");
                    $("#formContact2 p").text("Vous devez être connecté pour utiliser ce formulaire");
                    submitbtn2.click(verifier2);
     
                }else if(data == "Reussie"){
                    
                    $("#formContactSujet2").val("");
                    $("#formContactMsg2").val("");
                    $("#formContact2 p").text("Votre message a bien été envoyé");
                    submitbtn2.click(verifier2);
                    
                    
                    
                    
                    
                }else if(data == "vide"){
                    
                    $("#formContactSujet2").val("");
                    $("#formContactMsg2").val("");
                    $("#formContact2 p").text("Le formulaire n'est pas complet");
                    
                    submitbtn2.click(verifier2);
                    
                }else{
                    $("#formContact2 p").text("Un problème est survenue. Il se peut que se service soit momentanément indisponible.");
                    submitbtn2.click(verifier2);
                }
            },
            'text'
        );

    }


}());