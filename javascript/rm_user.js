(function () {
    "use strict";
    document.addEventListener("DOMContentLoaded", initialiser);

    var obj = {};
    
    function initialiser(evt) {

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
        var nomMbr = this.parentElement.previousElementSibling.innerHTML;
    }
    
    function changerStatut(evt) {
        var newStatut = this.value;
        var nomMbr = this.parentElement.previousElementSibling.previousElementSibling.innerHTML;
        obj = Object.assign({nomMbr:[newStatut]});
        console.log(obj);
    }

}());