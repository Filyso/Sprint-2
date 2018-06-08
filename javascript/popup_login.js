(function () {
    "use strict";
    document.addEventListener("DOMContentLoaded", initialiser);

    var popup;

    function initialiser(evt) {
        popup = document.querySelector(".popup");
        popup.style.visibility = "hidden";
        
        var btn = document.querySelectorAll(".login");
        for(var currentBtn of btn){
            currentBtn.addEventListener("click", show);
        }
        
    }

    function show(evt) {
        popup.style.visibility = "visible";
        popup.classList.toggle("is-open");
        
        var span = document.getElementsByClassName("close");
        span[0].addEventListener("click", hide);
    }

    function hide(evt) {
        popup.classList.toggle("is-open");
        popup.addEventListener("transitionend", cacher);
    }

    function cacher(evt) {
        popup.removeEventListener("transitionend",cacher);
        popup.style.visibility = "hidden";
    }
}());