var $_GET = {};
if(document.location.toString().indexOf('?') !== -1) {
    var query = document.location
                   .toString()
                   // get the query string
                   .replace(/^.*?\?/, '')
                   // and remove any existing hash string (thanks, @vrijdenker)
                   .replace(/#.*$/, '')
                   .split('&');

    for(var i=0, l=query.length; i<l; i++) {
       var aux = decodeURIComponent(query[i]).split('=');
       $_GET[aux[0]] = aux[1];
    }
}

(function () {
    "use strict";
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
    }

//    function swap(evt) {
//
//    }

    $.post(
        '../php/musique.php', 
        {
            cat: $_GET['categorie'],
            lang: $_GET['lang']
        },
        function (data) {
            console.log(data.chaine);
        }
    );
}());