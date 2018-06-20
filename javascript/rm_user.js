(function () {
    
    "use strict";
    document.addEventListener("DOMContentLoaded", initialiser);

    var obj = {};
    var json;
    var hiddenInput;

    function initialiser(evt) {
        
        json = JSON.stringify(obj);
        hiddenInput = document.getElementById("arrayData");

        var mbr = document.querySelectorAll(".mbr");

        for (var currentMbr of mbr) {
            var statuts = currentMbr.querySelector(".statutMbr");
            var roles = currentMbr.querySelector(".roleMbr");
            var statutCurrentMbr = statuts.value;
            var roleCurrentMbr = roles.value;
            statuts.addEventListener("change", changerStatut);
            roles.addEventListener("change", changerRole);
            
        }
    }

    function changerRole(evt) {
        var newRole = this.value;
        var actualStatut = this.parentElement.nextElementSibling.firstElementChild.value;
        var pseudoMbr = this.parentElement.previousElementSibling.innerHTML.trim();
        obj[pseudoMbr] = [newRole, actualStatut];
        console.log(obj);
        var json = JSON.stringify(obj);
        hiddenInput.value = json;
    }

    function changerStatut(evt) {
        var newStatut = this.value;
        var actualRole = this.parentElement.previousElementSibling.firstElementChild.value;
        var pseudoMbr = this.parentElement.previousElementSibling.previousElementSibling.innerHTML.trim();
        obj[pseudoMbr] = [actualRole, newStatut];
        var json = JSON.stringify(obj);
        hiddenInput.value = json;
    }

}());