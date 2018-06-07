(function () {
    "use strict";

    document.addEventListener("DOMContentLoaded", initialiser);

    var timecode1 = document.getElementById("minStart_1");
    var timecode2 = document.getElementById("minEnd_2");

    function initialiser(evt) {
        timecode1.addEventListener("change", verifier);
        timecode2.addEventListener("change", verfier);
    }

    function verifier(evt) {

        this.setCustomValidity("");
        if (timecode1.value >= timecode2.value) {
            this.setCustomValidity("Le temps du début doit être inférieur au temps de fin.");
        }
    }

}());
