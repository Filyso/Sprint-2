"use strict"

document.addEventListener("DOMContentLoaded", initialiser);

function initialiser(evt) {
    var lesSuppInput = document.querySelectorAll('input[value="Supprimer"]');

    for (var currentSuppInput of lesSuppInput) {
        currentSuppInput.addEventListener("click", alertSupp);
    }
}

function alertSupp(evt) {
    var nameSong = this.parentElement.parentElement.parentElement.querySelector("td").textContent;
    var nameArtist = this.parentElement.parentElement.parentElement.querySelector("td:nth-child(2)").innerHTML;
    if (confirm("Etes vous sur de vouloir supprimer la chanson: " + nameSong + " de " + nameArtist)) {
        this.parentElement.submit();
    }
}