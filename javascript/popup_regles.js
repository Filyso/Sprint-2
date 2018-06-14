(function () {
    "use strict";
    document.addEventListener("DOMContentLoaded", initialiser);

    var popup;

    function initialiser(evt) {
        popup = document.querySelector(".popup_regle");

        popup.style.visibility = "hidden";
        popup.style.opacity = 1;

        var span = document.getElementsByClassName("close_regle");
        span[0].addEventListener("click", hide);

        var btn = document.getElementById("tutoButton");
        btn.addEventListener("click", show);
    }

    function show(evt) {
        popup.style.visibility = "visible";
        popup.style.opacity = 1;

        var span = document.getElementsByClassName("close_regle");
        span[0].addEventListener("click", hide);
    }

    function hide(evt) {
        popup.addEventListener("transitionend", cacher);
        popup.style.opacity = 0;
    }

    function cacher(evt) {
        popup.removeEventListener("transitionend", cacher);
        popup.style.visibility = "hidden";
    }
}());
