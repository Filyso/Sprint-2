(function () {
    "use strict";
    document.addEventListener("DOMContentLoaded", initialiser);

    var tabChanges;
    
    function initialiser(evt) {
        
        tabChanges = new Array();

        var mbr = document.querySelectorAll("mbr");

        for (var currentMbr of mbr) {
            var statuts = currentMbr.document.querySelectorAll("statutMbr");
            var roles = currentMbr.document.querySelectorAll("roleMbr");
            var statutCurrentMbr = statuts.options[statuts.selectedIndex].value;
            var roleCurrentMbr = roles.options[roles.selectedIndex].value;
            statutCurrentMbr.addEventListener("change", changerStatut);
            roleCurrentMbr.addEventListener("change", changerRole);
        }
    }

    function changerStatut(evt) {
        var newStatut = this.value;
        var mbr = newStatut.parentElement.parentElement.parentElement;
        tabChanges.push(newStatut);
    }

    function changerRole(evt) {
        var newRole = this.value;
        var mbr = newStatut.parentElement.parentElement.parentElement;
        tabChanges.push(newRole);
    }

}());