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

"use strict";

// Variables Song
var currentSong;
var tabTimeCode = [];
var forceSwap = false;
var forceSwapTimer;

// Variables Timer
var encours;
var milli;
var timerMilli;
var timerSec;

var timerWait;
var wait;

// Variables Game
var niv;
var score = 0;
var numQuest = 0;
var stopTimerBool = false;
var reps;
var stateChangeTamponMemory = [];
var verifMemory = false;
var timeOut = false;

// Variables Score
var scoreGeneral = 0;
var scoreGeneralPourcent = 0;
var scoreReponse;
var nbGoodAnswer = 0;


document.addEventListener("DOMContentLoaded", initialiser);

// Load the IFrame Player API code asynchronously.
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/player_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
// Replace the 'ytplayer' element with an <iframe> and
// YouTube player after the API code downloads.
var player;

function onYouTubePlayerAPIReady() {
    $.post(
        '../php/scripts/script_game_multi.php', {
            function: 'getTimeCode',
            forbiddenTimeCode: JSON.stringify(tabTimeCode)
        },
        function (data) {
            currentSong = data;
            tabTimeCode.push(data.idTimeCode);
            player = new YT.Player('ytplayer', {
                height: '360',
                width: '640',
                videoId: data.url,
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
                    'start': data.timeCodeStart,
                    /* seconde début */
                    'end': data.timeCodeEnd /* seconde fin */
                },
                events: {
                    'onStateChange': swap
                }
            });
            forceSwapTimer = setTimeout(function () {
                forceSwap = true;
                forceSwapFct();
            }, ((3 + currentSong.timeCodeEnd - currentSong.timeCodeStart) * 1000));
            document.getElementById("nomEtArtiste").textContent = data.nameSong + " - " + data.nameArtist;
        },
        'json'
    );
}

function initialiser(evt) {
    window.addEventListener('beforeunload', function (event) {
        $.post(
            '../php/scripts/script_game_multi.php', {
                function: 'delLobby'
            }
        );
    });

    $.post('../php/scripts/script_game_multi.php', {
        function: 'setSessionIdLobby'
    }, function (data) {
        console.log(data.idLobby + "\n" + data.playerNumber)
    }, 'json');

    // Création de la barre de score
    var barScoreMax = document.createElement("div");
    barScoreMax.classList.add("barScoreMax");

    var barScore = document.createElement("div");
    barScore.classList.add("barScore");
    barScore.style.height = 0 + "%";
    barScoreMax.appendChild(barScore);

    document.getElementsByClassName("score")[0].appendChild(barScoreMax);

    // Création de la div contenu
    var contenu = document.createElement("div");
    contenu.classList.add("contenu");
    document.querySelector(".sectionSolo").appendChild(contenu);
    // Création de la div numEtTuto
    var numEtTuto = document.createElement("div");
    numEtTuto.classList.add("numEtTuto");
    contenu.appendChild(numEtTuto);
    // Création du bouton de tuto
    var tutoBtn = document.createElement("input");
    tutoBtn.id = "tutoBtn";
    tutoBtn.type = "button";
    tutoBtn.value = "?";
    numEtTuto.appendChild(tutoBtn);
    // Création du paragraphe de num de question
    var numQuestion = document.createElement("p");
    numQuestion.id = "numQuestion";
    numQuestion.textContent = "#1";
    numQuestion.classList.add("numQuestion");
    numEtTuto.appendChild(numQuestion);
    // Création du paragraphe de nom de chanson et d'artiste
    var nomEtArtiste = document.createElement("p");
    nomEtArtiste.id = "nomEtArtiste";
    nomEtArtiste.classList.add("nomEtArtiste");
    numEtTuto.appendChild(nomEtArtiste);
    // Création de la div ytplayer
    var ytplayer = document.createElement("div");
    ytplayer.id = "ytplayer";
    ytplayer.classList.add("ytplayer");
    contenu.appendChild(ytplayer);
    // Création de la div rep
    var rep = document.createElement("div");
    rep.id = "rep";
    rep.style.display = "none";
    contenu.appendChild(rep);
    // Création du paragraphe de phrase à compléter
    var phraseACompleter = document.createElement("p");
    phraseACompleter.id = "phraseACompleter";
    phraseACompleter.classList.add("phraseACompleter");
    rep.appendChild(phraseACompleter);
    // Création de la div contenant les réponses
    var reponses = document.createElement("div");
    reponses.classList.add("reponses");
    rep.appendChild(reponses);
    // Création div de sous-réponses 1
    var sousReponses1 = document.createElement("div");
    sousReponses1.classList.add("sousReponses");
    reponses.appendChild(sousReponses1);
    // Création bouton de réponse 1
    var reponse1Btn = document.createElement("button");
    reponse1Btn.id = "reponse1Btn";
    reponse1Btn.classList = "reponseBtn";
    sousReponses1.appendChild(reponse1Btn);
    // Création bouton de réponse 2
    var reponse2Btn = document.createElement("button");
    reponse2Btn.id = "reponse2Btn";
    reponse2Btn.classList = "reponseBtn";
    sousReponses1.appendChild(reponse2Btn);
    // Création div timer
    var divTimer = document.createElement("div");
    divTimer.classList.add("divTimer");
    reponses.appendChild(divTimer);
    // Création paragraphe timer
    var timer = document.createElement("p");
    timer.id = "timer";
    timer.classList.add("timer");
    divTimer.appendChild(timer);
    // Création div de sous-réponses 2
    var sousReponses2 = document.createElement("div");
    sousReponses2.classList.add("sousReponses");
    reponses.appendChild(sousReponses2);
    // Création bouton de réponse 3
    var reponse3Btn = document.createElement("button");
    reponse3Btn.id = "reponse3Btn";
    reponse3Btn.classList = "reponseBtn";
    sousReponses2.appendChild(reponse3Btn);
    // Création bouton de réponse 4
    var reponse4Btn = document.createElement("button");
    reponse4Btn.id = "reponse4Btn";
    reponse4Btn.classList = "reponseBtn";
    sousReponses2.appendChild(reponse4Btn);
    // Création form reponse 7
    var form = document.createElement("form");
    reponses.appendChild(form);
    // Création du label 1 reponse 7
    var label = document.createElement("label");
    label.setAttribute("for", "reponse7Input");
    form.appendChild(label);
    // Création de l'input reponse 7
    var reponse7Input = document.createElement("input");
    reponse7Input.id = "reponse7Input";
    reponse7Input.type = "text";
    reponse7Input.name = "reponse7Input";
    form.appendChild(reponse7Input);
    // Création du label 2 reponse 7
    var label2 = document.createElement("label");
    label2.setAttribute("for", "reponse7Input");
    form.appendChild(label2);

    document.getElementById("reponse7Input").parentElement.addEventListener("submit", function (evt) {
        evt.preventDefault();
    });
    document.getElementById("reponse7Input").parentElement.style.display = "none";

    $.post(
        '../php/scripts/script_game_multi.php', {
            function: 'getEnemyImgLink'
        },
        function (data) {
            var enemyScore = document.querySelectorAll(".score")[1];
            var cloneBarScoreMax = barScoreMax.cloneNode();
            var cloneBarScore = barScore.cloneNode();
            cloneBarScoreMax.appendChild(cloneBarScore);
            enemyScore.querySelector("img").src = data.linkIconEnemy;
            enemyScore.appendChild(cloneBarScoreMax);
            enemyScore.style.left = "calc(100% - 13vw)";
            
            var pseudoEnemy = document.createElement("span");

            enemyScore.appendChild(pseudoEnemy);
            pseudoEnemy.textContent = data.pseudoEnemy;
            pseudoEnemy.style.position = "absolute";
            pseudoEnemy.style.top = "calc(10vw + 15px)";
            pseudoEnemy.style.left = "calc(0)";
            
            var pseudoMbr = document.createElement("span");
            
            document.querySelectorAll(".score")[0].appendChild(pseudoMbr);
            pseudoMbr.textContent = data.pseudoMbr;
            pseudoMbr.style.position = "absolute";
            pseudoMbr.style.top = "calc(10vw + 15px)";
            pseudoMbr.style.left = "calc(0)";
            
        },
        'json'
    );

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

    if ((evt.data == YT.PlayerState.ENDED && verifMemory) || forceSwap) {
        forceSwap = false;
        window.clearTimeout(forceSwapTimer);
        stateChangeTamponMemory = [];
        verifMemory = false;
        document.getElementById("ytplayer").style.display = "none";

        document.getElementById("rep").style.display = "block";
        timerStart();
        document.getElementById("phraseACompleter").textContent = currentSong.previousLyrics;

        reps = document.querySelectorAll(".reponses button");

        melangerReps();

        if (numQuest < 2) {
            reps[2].style.display = "none";
            reps[3].style.display = "none";
        } else if (numQuest < 4) {
            reps[2].style.display = "block";
            reps[3].style.display = "none";
            reps[2].style.marginTop = "10px";
        } else if (numQuest < 6) {
            reps[2].style.marginTop = "10px";
            reps[3].style.display = "block";
        } else {
            reps[0].style.display = "none";
            reps[1].style.display = "none";
            reps[2].style.display = "none";
            reps[3].style.display = "none";
            $.post(
                '../php/scripts/script_game_multi.php', {
                    function: 'getQuestion7',
                    idTimeCode: tabTimeCode[numQuest]
                },
                function (data) {
                    document.querySelectorAll("label[for=reponse7Input]")[0].textContent += data.rightStr;
                    document.querySelectorAll("label[for=reponse7Input]")[1].textContent += data.leftStr;
                },
                'json'
            );
            document.getElementById("reponse7Input").autofocus;
            document.getElementById("reponse7Input").parentElement.style.display = "block";
            document.getElementById("reponse7Input").addEventListener("keyup", verifierType);
        }

        // Ajout de l'eventListener sur les boutons
        for (var rep of reps) {
            rep.addEventListener("click", verifierReps);
        }
    }
}

function forceSwapFct(evt) {
    if (forceSwap) {
        forceSwap = false;
        window.clearTimeout(forceSwapTimer);
        stateChangeTamponMemory = [];
        verifMemory = false;
        document.getElementById("ytplayer").style.display = "none";

        document.getElementById("rep").style.display = "block";
        timerStart();
        document.getElementById("phraseACompleter").textContent = currentSong.previousLyrics;

        reps = document.querySelectorAll(".reponses button");

        melangerReps();

        if (numQuest < 2) {
            reps[2].style.display = "none";
            reps[3].style.display = "none";
        } else if (numQuest < 4) {
            reps[2].style.display = "block";
            reps[3].style.display = "none";
            reps[2].style.marginTop = "10px";
        } else if (numQuest < 6) {
            reps[2].style.marginTop = "10px";
            reps[3].style.display = "block";
        } else {
            reps[0].style.display = "none";
            reps[1].style.display = "none";
            reps[2].style.display = "none";
            reps[3].style.display = "none";
            $.post(
                '../php/scripts/script_game_multi.php', {
                    function: 'getQuestion7',
                    idTimeCode: tabTimeCode[numQuest]
                },
                function (data) {
                    document.querySelectorAll("label[for=reponse7Input]")[0].textContent += data.rightStr;
                    document.querySelectorAll("label[for=reponse7Input]")[1].textContent += data.leftStr;
                },
                'json'
            );
            document.getElementById("reponse7Input").autofocus;
            document.getElementById("reponse7Input").parentElement.style.display = "block";
            document.getElementById("reponse7Input").addEventListener("keyup", verifierType);
        }

        // Ajout de l'eventListener sur les boutons
        for (var rep of reps) {
            rep.addEventListener("click", verifierReps);
        }
    }
}

function melangerReps() {
    $.post(
        '../php/scripts/script_musique.php', {
            function: 'getTimeCodeAnswers',
            idTimeCode: tabTimeCode[numQuest]
        },
        function (data) {
            if (numQuest < 2) {
                var bonneRepPositionAlea = Math.floor(Math.random() * 2);
            } else if (numQuest < 4) {
                var bonneRepPositionAlea = Math.floor(Math.random() * 3);
            } else if (numQuest < 7) {
                var bonneRepPositionAlea = Math.floor(Math.random() * 4);
            }

            var tabReps = [-1, -1, -1, -1];

            tabReps[0] = bonneRepPositionAlea;

            for (var m = 1; m < 4; m++) {

                var questAlea = Math.floor(Math.random() * 4);

                while (tabReps[0] == questAlea || tabReps[1] == questAlea || tabReps[2] == questAlea) {
                    questAlea = Math.floor(Math.random() * 4);
                }
                tabReps[m] = questAlea;
            }

            reps[tabReps[0]].value = data.answers.rep1;
            reps[tabReps[1]].value = data.answers.rep2;
            reps[tabReps[2]].value = data.answers.rep3;
            reps[tabReps[3]].value = data.answers.rep4;

            reps[tabReps[0]].textContent = data.answers.rep1;
            reps[tabReps[1]].textContent = data.answers.rep2;
            reps[tabReps[2]].textContent = data.answers.rep3;
            reps[tabReps[3]].textContent = data.answers.rep4;
        },
        'json'
    );

}

function verifierReps(evt) {
    var btnThis = this;

    // Suppression des eventListener sur les boutons de réponse
    for (var rep of reps) {
        rep.removeEventListener("click", verifierReps);
    }

    // Vérification de la réponse
    if (!timeOut) {
        $.post(
            '../php/scripts/script_musique.php', {
                function: 'getTimeCodeAnswer',
                idTimeCode: tabTimeCode[numQuest],
            },
            function (data) {
                if (btnThis.value == data.trueRep) {
                    nbGoodAnswer = nbGoodAnswer + 1;
                    btnThis.style.backgroundColor = "#3df22d";
                    stopTimer();
                    calculScore();
                    afficherScore();
                    document.getElementsByClassName("barScore")[0].style.height = Math.round(scoreGeneralPourcent) + "%";
                } else {
                    afficherScore(0);
                    stopTimer();
                    btnThis.style.backgroundColor = "red";
                }
                setTimeout(waitFct, 2000);
            },
            'json'
        );
    } else {
        afficherScore(0);
        document.getElementsByClassName("divTimer")[0].style.borderColor = "red";
        setTimeout(waitFct, 2000);
    }

}

function verifierType(evt) {
    var repInput = this;
    var thisLabels = this.parentElement.querySelectorAll("label");
    var answer = thisLabels[0].textContent + this.value + thisLabels[1].textContent;
    $.post(
        '../php/scripts/script_musique.php', {
            function: 'checkAnswer',
            idTimeCode: tabTimeCode[numQuest],
            playerAnswer: answer.toLowerCase()
        },
        function (data) {
            if (data.answerIsGood) {
                document.getElementById("reponse7Input").removeEventListener("keyup", verifierType);
                nbGoodAnswer = nbGoodAnswer + 1;
                repInput.style.borderColor = "#3df22d";
                stopTimer();
                calculScore();
                afficherScore();
                document.getElementsByClassName("barScore")[0].style.height = Math.round(scoreGeneralPourcent) + "%";
                setTimeout(waitFct, 2000);

            } else {
                repInput.style.borderColor = "red";
            }
        },
        'json'
    );
}

function waitFct() {
    $.post('../php/scripts/script_game_multi.php', {
            function: 'checkLobbyExist',
        },
        function (data) {
            if (!data.lobbyExist) {
                window.alert("Votre adversaire s'est déconnecté, vous allez être redirigé vers la sélection d'options de jeu.");
                document.location.href = "../php/pre_game_page.php?mod=multi";
            }
        },
        'json'
    );

    $.post('../php/scripts/script_game_multi.php', {
        function: 'playerIsReady',
        playerIsReady: '1'
    });

    wait = true;
    timerWait = setInterval(function () {
        $.post('../php/scripts/script_game_multi.php', {
                function: 'arePlayersReady',
            },
            function (data) {
                wait = !data.playersAreReady;
            },
            'json');
        console.log(wait);
        if (!wait) {
            afterVerif();
            $.post('../php/scripts/script_game_multi.php', {
                function: 'playerIsReady',
                playerIsReady: '0'
            });
            window.clearInterval(timerWait);
        }
    }, 1000);
}

function afterVerif(evt) {
    $.post('../php/scripts/script_game_multi.php', {
            function: 'getEnemyScore',
        },
        function (data) {
            document.getElementsByClassName("barScore")[1].style.height = Math.round(data.enemyScore * 100 / 160) + "%";
        },
        'json'
    );

    if (document.getElementById("currentScore") != null) {
        document.getElementById("currentScore").remove();
    }
    if (numQuest < 6) {
        numQuest = numQuest + 1;
        document.getElementById("rep").style.display = "none";
        document.getElementById("ytplayer").style.display = "block";

        $.post(
            '../php/scripts/script_game_multi.php', {
                function: 'getTimeCode',
                forbiddenTimeCode: JSON.stringify(tabTimeCode)
            },
            function (data) {
                currentSong = data;
                tabTimeCode.push(data.idTimeCode);
                player.loadVideoById({
                    videoId: data.url,
                    startSeconds: data.timeCodeStart,
                    endSeconds: data.timeCodeEnd,
                });

                document.getElementById("nomEtArtiste").textContent = data.nameSong + " - " + data.nameArtist;

                player.playVideo();

                document.getElementById("numQuestion").textContent = "#" + (numQuest + 1);

                reps[0].style.backgroundColor = "transparent";
                reps[1].style.backgroundColor = "transparent";
                reps[2].style.backgroundColor = "transparent";
                reps[3].style.backgroundColor = "transparent";

                forceSwapTimer = setTimeout(function () {
                    forceSwap = true;
                    forceSwapFct();
                }, ((3 + currentSong.timeCodeEnd - currentSong.timeCodeStart) * 1000));

            },
            'json'
        );

    } else {
        // Cacher les éléments contenu dans l'élément main du DOM
        var childMain = document.querySelectorAll(".mainJeuSolo > *");
        for (var currentElem of childMain) {
            currentElem.style.display = "none";
        }

        // Création div résultat
        var resultat = document.createElement("div");
        resultat.classList.add("resultat");
        document.querySelector("main").appendChild(resultat);
        // Création partie gauche
        var partieGauche = document.createElement("div");
        partieGauche.classList.add("partieGauche");
        resultat.appendChild(partieGauche);
        // Création cercle score
        var cercleScore = document.createElement("div");
        cercleScore.classList.add("cercleScore");
        partieGauche.appendChild(cercleScore);
        // Création paragraphe scoreResultat
        var scoreResultat = document.createElement("p");
        scoreResultat.classList.add("scoreResultat");
        scoreResultat.textContent = "Score";
        cercleScore.appendChild(scoreResultat);
        // Création paragraphe chiffreScoreResultat
        var chiffreScoreResultat = document.createElement("p");
        chiffreScoreResultat.id = "chiffreScoreResultat";
        chiffreScoreResultat.classList.add("chiffreScoreResultat");
        chiffreScoreResultat.textContent = scoreGeneral;
        cercleScore.appendChild(chiffreScoreResultat);
        $.post(
            '../php/scripts/script_game_multi.php', {
                function: 'isPlayerWinner',
            },
            function (data) {
                var texteScoreResultat = document.createElement("p");
                texteScoreResultat.classList.add("scoreResultat");
                texteScoreResultat.textContent = data.playerIsWinner;
                cercleScore.appendChild(texteScoreResultat);
            },
            'json'
        );
        // Création partie droite
        var partieDroite = document.createElement("div");
        partieDroite.classList.add("partieDroite");
        resultat.appendChild(partieDroite);
        // Création div bonnesReponses
        var bonnesReponses = document.createElement("div");
        bonnesReponses.classList.add("bonnesReponses");
        partieDroite.appendChild(bonnesReponses);
        // Création paragraphe nbBonneReponse
        var nbBonneReponse = document.createElement("p");
        nbBonneReponse.id = "nbBonneReponse"
        nbBonneReponse.classList.add("nbBonneReponse");
        nbBonneReponse.textContent = nbGoodAnswer;
        bonnesReponses.appendChild(nbBonneReponse);
        // Création paragraphe chiffreScoreResultat
        var txtBonnesReponses = document.createElement("p");
        txtBonnesReponses.classList.add("txtBonnesReponses");
        txtBonnesReponses.textContent = "bonnes réponses";
        bonnesReponses.appendChild(txtBonnesReponses);
        // Création lien Rejouer
        var replayLink = document.createElement("a");
        replayLink.setAttribute("href", "pre_game_page.php?mod=multi");
        partieDroite.appendChild(replayLink);
        // Création bouton rejouer
        var replayBtn = document.createElement("button");
        replayBtn.classList.add("replayBtn");
        replayLink.appendChild(replayBtn);
        // Création Img Rejouer
        var replayImg = document.createElement("img");
        replayImg.setAttribute("src", "../images/fleche.png");
        replayImg.setAttribute("alt", "fleche pour rejouer");
        replayImg.classList.add("replayImg");
        replayBtn.appendChild(replayImg);
        // Création Paragraph Rejouer
        var replayParagraph = document.createElement("p");
        replayParagraph.textContent = "Rejouer";
        replayBtn.appendChild(replayParagraph);

        // Changement de la classe de l'élément DOM main
        document.querySelector("main").className = "mainResultat";
    }
}

// ********************* //
// *** Gestion Timer *** //
// ********************* //
function timerStart(niv) {
    if (numQuest == 6) {
        milli = 1550;
    } else {
        milli = 1050;
    }

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
            if (numQuest < 6) {
                verifierReps();
            } else {
                waitFct();
            }
        }
    }
}

// ********************* //
// *** Gestion Score *** //
// ********************* //
function calculScore() {

    var tempsCourant = timerSec + (timerMilli / 100);

    if (numQuest == 6) {
        var tempsInitial = 30;
        var scoreMax = 40;
    } else {
        var tempsInitial = 10;
        var scoreMax = 20;
    }

    var pourcent = tempsCourant / tempsInitial;
    scoreReponse = Math.round(pourcent * scoreMax);

    scoreGeneral = scoreGeneral + scoreReponse;

    scoreGeneralPourcent = scoreGeneral * 100 / 160;
}

function afficherScore(setScore) {
    var spanScore = document.createElement("span");

    if (setScore != undefined) {
        spanScore.textContent = "+" + setScore;
        scoreReponse = setScore;
    } else {
        spanScore.textContent = "+" + scoreReponse;
    }

    spanScore.id = "currentScore";

    spanScore.style.position = "absolute";
    spanScore.style.top = "50%";
    spanScore.style.left = "50%";

    document.querySelector(".contenu").appendChild(spanScore);

    $.post(
        '../php/scripts/script_game_multi.php', {
            function: 'setScore',
            idTimeCode: tabTimeCode[numQuest],
            score: scoreReponse
        }
    );
}
