"use strict";
document.addEventListener("DOMContentLoaded", initialiser);

function initialiser(evt) {
    document.getElementById("addTCBtn").addEventListener("click", addTC);
    document.getElementById("addCatBtn").addEventListener("click", addCat);
}

function addTC(evt) {
    var tcFieldset = document.querySelector(".timeCode");
    var cloneTcFieldset = tcFieldset.cloneNode(true);
    var nbFieldsetInput = document.getElementById("nbTimecode");
    
    // Augmentation du nombre de timecode
    nbFieldsetInput.value = parseInt(nbFieldsetInput.value) + 1;
    
    // Modification des paramètres du clone
    var inputsClone = cloneTcFieldset.querySelectorAll("input");
    for (var currentInput of inputsClone) {
        currentInput.id = currentInput.id.slice(0,-1) + nbFieldsetInput.value;
        currentInput.name = currentInput.name.slice(0,-1) + nbFieldsetInput.value;
    }
    var labelsClone = cloneTcFieldset.querySelectorAll("label");
    for (var currentLabel of labelsClone) {
        currentLabel.setAttribute("for", currentLabel.getAttribute("for").slice(0,-1) + nbFieldsetInput.value);
    }
    
    // Insertion du nouveau formulaire de timecode dans le DOM
    document.getElementById("addSongForm").insertBefore(cloneTcFieldset,this.parentNode);
}

function addCat(evt) {
    var catSelect = document.querySelector(".catSong");
    var cloneCat = catSelect.cloneNode(true);
    var nbCatInput = document.getElementById("nbCat");
    
    // Augmentation du nombre de timecode
    nbCatInput.value = parseInt(nbCatInput.value) + 1;
    
    // Modification des paramètres du clone
    cloneCat.id = cloneCat.id.slice(0,-1) + nbCatInput.value;
    cloneCat.name = cloneCat.name.slice(0,-1) + nbCatInput.value;
    
    // Insertion du nouveau formulaire de timecode dans le DOM
    nbCatInput.before(cloneCat);
}