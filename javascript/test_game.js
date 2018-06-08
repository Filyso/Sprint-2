var $_GET = {};
if (document.location.toString().indexOf('?') !== -1) {
    var query = document.location
        .toString()
        // get the query string
        .replace(/^.*?\?/, '')
        // and remove any existing hash string (thanks, @vrijdenker)
        .replace(/#.*$/, '')
        .split('&');

    for (var i = 0, l = query.length; i < l; i++) {
        var aux = decodeURIComponent(query[i]).split('=');
        $_GET[aux[0]] = aux[1];
    }
}

//"use strict";

// Variable Song
var currentSong;
var tabTimeCode = [];

// Variable Game
var scoreGeneral = 0;
var scoreGeneralPourcent = 0;


document.addEventListener("DOMContentLoaded", initialiser);

getNewSong();
console.log(currentSong);

// Load the IFrame Player API code asynchronously.
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/player_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
// Replace the 'ytplayer' element with an <iframe> and
// YouTube player after the API code downloads.
var player;

function onYouTubePlayerAPIReady() {
    player = new YT.Player('ytplayer', {
        height: '360',
        width: '640',
        videoId: currentSong.url,
        // PARAMETRES DU LECTEUR
        playerVars: {
            'autoplay': 1,
            /* lance la vidéo automatiquement */
            'controls': 0,
            /* cache l'interférence controles */
            'disabledkb': 1,
            /* empeche l'utilisation des controles */
            'iv_load_policy': 3,
            /* supprime les annotations */
            'rel': 0,
            /* Le lecteur n'affiche pas de vidéo similaire à la fin */
            'showinfo': 0,
            /* n'affiche pas les infos de la vidéo */
            'start': currentSong.timeCodeStart,
            /* seconde début */
            'end': currentSong.timeCodeEnd /* seconde fin */
        },
        events: {
            'onStateChange': swap
        }

    });

}

function initialiser(evt) {
    document.getElementsByClassName("barScore")[0].style.height = 0 + "%";
    document.querySelector(".resultat").style.display = "none";
}

// ******************* //
// *** Gestion Jeu *** //
// ******************* //
function swap(evt) {

    stateChangeTamponMemory.push(evt.data);
    for (var z = 0; z < stateChangeTamponMemory.length; z++) {
        if (stateChangeTamponMemory[z] == 3) {
            verifMemory = true;

        }
    }

    if (evt.data == YT.PlayerState.ENDED && verifMemory) {
        stateChangeTamponMemory = [];
        verifMemory = false;
        document.getElementById("ytplayer").style.display = "none";

        document.getElementsByClassName("contenu")[0].style.display = "block";
        timerStart();
        document.getElementById("numQuestion").textContent = "Question n° " + (numQuest + 1);
        document.getElementById("phraseACompleter").textContent = tabMusique[numQuest].quest;

        reps = document.querySelectorAll(".reponses button");

        melangerReps();

        if (numQuest < 2) {
            reps[2].style.display = "none";
            reps[3].style.display = "none";
        } else if (numQuest < 4) {
            reps[2].style.display = "block";
            reps[2].style.margin = "auto";
            reps[2].style.marginTop = "140px";
            reps[3].style.display = "none";
        } else if (numQuest < 7) {
            reps[2].style.margin = "10px";
            reps[3].style.display = "block";
        }
        for (var rep of reps) {
            rep.addEventListener("click", verfierReps);
        }
    }
}

function verifierReps(evt) {
    // Suppression des eventListener sur les boutons de réponse
    for (var rep of reps) {
        rep.removeEventListener("click", verfierReps);
    }

    // Vérification de la réponse
    if (!timeOut) {
        if (this.value == tabMusique[numQuest].reponse) {
            nbGoodAnswer = nbGoodAnswer + 1;
            this.style.backgroundColor = "#3df22d";
            stopTimer();
            calculScore();
            document.getElementsByClassName("barScore")[0].style.height = Math.round(scoreGeneralPourcent) + "%";
        } else {
            stopTimer();
            this.style.backgroundColor = "red";
        }
    } else {
        document.getElementsByClassName("divTimer")[0].style.borderColor = "red";
    }


    setTimeout(function () {
        if (numQuest < 6) {
            numQuest = numQuest + 1;
            document.getElementsByClassName("contenu")[0].style.display = "none";
            document.getElementById("ytplayer").style.display = "block";

            player.loadVideoById({
                videoId: tabMusique[numQuest].url,
                startSeconds: tabMusique[numQuest].timeCodeStart,
                endSeconds: tabMusique[numQuest].timeCodeEnd,
            });
            player.playVideo();
            reps[0].style.backgroundColor = "#784199";
            reps[1].style.backgroundColor = "#784199";
            reps[2].style.backgroundColor = "#784199";
            reps[3].style.backgroundColor = "#784199";
        } else {
            var childMain = document.querySelectorAll(".mainJeuSolo > *");
            for (var currentElem of childMain) {
                currentElem.style.display = "none";
            }
            document.querySelector(".resultat").style.display = "flex";
            document.getElementById("chiffreScoreResultat").textContent = scoreGeneral;
            document.getElementById("nbBonneReponse").textContent = nbGoodAnswer;
            document.querySelector("main").className = "mainResultat";
        }
    }, 2000);
}

// ************************ //
// *** Gestion Chansons *** //
// ************************ //
function getNewSong() {
    $.post(
        '../php/Musique.php', {
            function: 'getMusique',
            categorie: $_GET['categorie'],
            lang: $_GET['langue']
        },
        majSong,
        'json'
    );
}

function majSong(data) {
    currentSong = data;
    tabTimeCode.push(data.idTimeCode);
    console.log(currentSong);
}

// ********************* //
// *** Gestion Timer *** //
// ********************* //
function timerStart(niv) {
    milli = 1050;
    encours = setInterval(decrement, 10);
    stopTimerBool = false;
    timeOut = false;
    document.getElementsByClassName("divTimer")[0].style.borderColor = "#4cd1cb";
}

function stopTimer() {
    stopTimerBool = true;
}

function decrement(evt) {
    var timer = document.getElementById("timer");
    if (!stopTimerBool) {
        milli = milli - 1;
    } else {
        clearInterval(encours);
    }
    timerSec = Math.round(milli / 100);

    timerMilli = milli - timerSec * 100 + 50;

    if (timerSec > 0) {
        timer.textContent = "" + timerSec;
    } else {
        timer.textContent = "" + timerSec + "." + timerMilli;
    }

    if (timerSec < 1 && timerMilli < 1) {
        clearInterval(encours);
        if (timer.textContent = "0.0") {
            timeOut = true;
            verfierReps();
        }
    }
}

// ********************* //
// *** Gestion Score *** //
// ********************* //
function calculScore() {

    var tempsCourant = timerSec + (timerMilli / 100);

    if (numQuest == 6) {
        var tempsInitial = 10;
        var scoreMax = 40;
    } else {
        var tempsInitial = 10;
        var scoreMax = 20;
    }

    var pourcent = tempsCourant / tempsInitial;
    var scoreReponse = Math.round(pourcent * scoreMax);

    scoreGeneral = scoreGeneral + scoreReponse;

    scoreGeneralPourcent = scoreGeneral * 100 / 160;
}