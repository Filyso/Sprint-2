"use strict";

document.addEventListener("DOMContentLoaded", initialiser);

// Variables : Noeuds éléments (.values ramènera des noeuds textes)

var url;

var minute1;
var minute2;
var seconde1;
var seconde2;

var parole1;
var parole2;
var parole3;
var parole4;
var parole5;


function initialiser(evt) {
    document.getElementById("addTCBtn").addEventListener("click", addTC);
    document.getElementById("addCatBtn").addEventListener("click", addCat);

    url = document.getElementById("linkVideo");
    url.addEventListener("change", verifierURL);

    minute1 = document.getElementById("minStart_1");
    minute1.addEventListener("change", verifierTimecodes);
    minute2 = document.getElementById("minEnd_1");
    minute2.addEventListener("change", verifierTimecodes);
    seconde1 = document.getElementById("secStart_1");
    seconde1.addEventListener("change", verifierTimecodes);
    seconde2 = document.getElementById("secEnd_1");
    seconde2.addEventListener("change", verifierTimecodes);

    parole1 = document.getElementById("prevLyrics_1");
    parole1.addEventListener("change", verifierParoles);
    parole2 = document.getElementById("goodRep_1");
    parole2.addEventListener("change", verifierParoles);
    parole3 = document.getElementById("badRep1_1");
    parole3.addEventListener("change", verifierParoles);
    parole4 = document.getElementById("badRep2_1");
    parole4.addEventListener("change", verifierParoles);
    parole5 = document.getElementById("badRep3_1");
    parole5.addEventListener("change", verifierParoles);
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
        currentInput.id = currentInput.id.slice(0, -1) + nbFieldsetInput.value;
        currentInput.name = currentInput.name.slice(0, -1) + nbFieldsetInput.value;
    }
    var labelsClone = cloneTcFieldset.querySelectorAll("label");
    for (var currentLabel of labelsClone) {
        currentLabel.setAttribute("for", currentLabel.getAttribute("for").slice(0, -1) + nbFieldsetInput.value);
    }

    // Insertion d'un bouton de suppression
    var deleteBtn = document.createElement("input");
    deleteBtn.type = "button";
    deleteBtn.value = "×";
    deleteBtn.classList.add("delButton");
    deleteBtn.addEventListener("click", delParent);
    cloneTcFieldset.children[0].after(deleteBtn);

    // Insertion du nouveau formulaire de timecode dans le DOM
    document.getElementById("addSongForm").insertBefore(cloneTcFieldset, this.parentNode);
}

function addCat(evt) {
    var catSelect = document.querySelector(".catSong");
    var cloneCat = catSelect.cloneNode(true);
    var nbCatInput = document.getElementById("nbCat");

    // Augmentation du nombre de timecode
    nbCatInput.value = parseInt(nbCatInput.value) + 1;

    // Modification des paramètres du clone
    cloneCat.querySelector("select").id = cloneCat.querySelector("select").id.slice(0, -1) + nbCatInput.value;
    console.log(cloneCat.querySelector("select").id);
    cloneCat.querySelector("select").name = cloneCat.querySelector("select").name.slice(0, -1) + nbCatInput.value;
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

//Fonction vérifiant le respect orthographique des URL (on ne vérifie pas l'existence de l'URL)
function verifierURL(evt) {

    url.setCustomValidity("");

    //Les slash de l'URL sont échappées grâce aux anti-slash
    var regex = /^(https:\/\/www.youtube.com\/watch?)\w*?/;

    if (!url.checkValidity()) {
        if (!regex.test(url.value)) {
            url.setCustomValidity("Le format de l'URL n'est pas correct");
            url.style.borderColor = "#ED1B70";
        }
    } else {
        url.style.borderColor = "initial";
    }
}

//Fonction vérifiant la bonne temporalité des timecodes
function verifierTimecodes(evt) {

    // parseInt : important pour comparer des Int et pas des String
    var m1 = parseInt(minute1.value);
    var m2 = parseInt(minute2.value);
    var s1 = parseInt(seconde1.value);
    var s2 = parseInt(seconde2.value);

    seconde1.setCustomValidity("");
    if (m1 != "" && s1 != "" && m2 != "" && s2 != "") {
        if ((m2 < m1) || (m1 == m2 && s2 < s1) || (m1 == m2 && s1 == s2)) {
            seconde1.setCustomValidity("Attention à bien respecter une logique temporelle");
            minute1.style.borderColor = "#ED1B70";
            minute2.style.borderColor = "#ED1B70";
            seconde1.style.borderColor = "#ED1B70";
            seconde2.style.borderColor = "#ED1B70";
        } else {
            minute1.style.borderColor = "initial";
            minute2.style.borderColor = "initial";
            seconde1.style.borderColor = "initial";
            seconde2.style.borderColor = "initial";
        }
    }
}

//Fonction vérifiant que les paroles et réponses sont différentes pour chaque champ
function verifierParoles(evt) {

    var p1 = parole1.value.toLowerCase();
    var p2 = parole2.value.toLowerCase();
    var p3 = parole3.value.toLowerCase();
    var p4 = parole4.value.toLowerCase();
    var p5 = parole5.value.toLowerCase();

    var tabParoles = [p1, p2, p3, p4, p5];

    parole1.setCustomValidity("");

    parole1.style.borderColor = "initial";
    parole2.style.borderColor = "initial";
    parole3.style.borderColor = "initial";
    parole4.style.borderColor = "initial";
    parole5.style.borderColor = "initial";
    
    if (p1 != "" && p2 != "" && p3 != "" && p4 != "" && p5 != "") {
        for (var paroles of tabParoles) {
            let array = [];
            for (var p of tabParoles) {
                if (p !== paroles) {
                    array.push(p);
                }
            }
            if (array.length !== tabParoles.length - 1) {
                parole1.setCustomValidity("Attention à bien mettre des paroles différentes dans chaque champ");
                parole1.style.borderColor = "#ED1B70";
                parole2.style.borderColor = "#ED1B70";
                parole3.style.borderColor = "#ED1B70";
                parole4.style.borderColor = "#ED1B70";
                parole5.style.borderColor = "#ED1B70";
            }
        }
    }
}