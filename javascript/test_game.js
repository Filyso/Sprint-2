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

(function () {
    "use strict";

    var currentSong;
    var tabTimeCode = [];


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

        player = new YT.Player('ytplayer', {
            height: '360',
            width: '640',
            //            videoId: tabMusique[numQuest].url,
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
                //                'start': tabMusique[numQuest].timeCodeStart,
                /* seconde début */
                //                'end': tabMusique[numQuest].timeCodeEnd /* seconde fin */
            },
            events: {
                'onStateChange': swap
            }

        });

    }

    function initialiser(evt) {
        console.log($_GET['categorie']);
        console.log($_GET['langue']);

    }

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

    $.post(
        '../php/Musique.php', {
            function: 'getMusique',
            categorie: $_GET['categorie'],
            lang: $_GET['langue']
        },
        majSong,
        'json'
    );

    function majSong(data) {
        currentSong = data;
        tabTimeCode.push(data.idTimeCode);
    }

}());