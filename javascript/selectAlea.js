


document.addEventListener("DOMContentLoaded",initialiser);
var categorie;
var selectOptionButton;
var valueNbAlea;

function initialiser(evt){
    var btnAlea = document.getElementById("btnAlea");
    selectOptionButton = document.querySelectorAll("#categorie option");
    btnAlea.addEventListener("click",selectCheckItem);
}


function selectCheckItem(evt){
    indiceAlea = Math.floor(Math.random()*selectOptionButton.length);
    optionAlea = selectOptionButton[indiceAlea];
    optionAlea.selected="selected";
    
}
