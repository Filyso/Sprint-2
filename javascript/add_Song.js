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
    
    // Insertion d'un bouton de suppression
    var deleteBtn = document.createElement("input");
    deleteBtn.type = "button";
    deleteBtn.value = "×";
    deleteBtn.classList.add("delButton");
    deleteBtn.addEventListener("click", delParent);
    cloneTcFieldset.children[0].after(deleteBtn);
    
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
    cloneCat.querySelector("select").id = cloneCat.querySelector("select").id.slice(0,-1) + nbCatInput.value;
    console.log(cloneCat.querySelector("select").id);
    cloneCat.querySelector("select").name = cloneCat.querySelector("select").name.slice(0,-1) + nbCatInput.value;
    cloneCat.querySelector("label").setAttribute("for", cloneCat.querySelector("select").id);

    // Insertion d'un bouton de suppression
    var deleteBtn = document.createElement("input");
    deleteBtn.type = "button";
    deleteBtn.value = "×";
    deleteBtn.classList.add("delButton");
    deleteBtn.addEventListener("click", delParent);
    cloneCat.append(deleteBtn);
    
    // Insertion du nouveau formulaire de timecode dans le DOM
    nbCatInput.before(cloneCat);
}

function delParent(evt) {
    this.parentElement.remove();
}