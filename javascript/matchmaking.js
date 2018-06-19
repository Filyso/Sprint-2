(function () {
    "use strict"

    var timerQueue;

    document.addEventListener("DOMContentLoaded", initialiser);

    function initialiser(evt) {
        timerQueue = setInterval(checkQueue, 1000);
    }

    function checkQueue() {
        $.post(
            '../php/scripts/script_game_multi.php', {
                function: 'checkQueue',
            },
            function (data) {
                if (data.competitorFind) {
                    window.clearInterval(timerQueue);
                    document.location.href = "./multi_game.php";
                    console.log(data.requete);
                } else {
                    console.log("En recherche de Matchmaking");
                    console.log(data.requete);
                }
            },
            'json'
        );
    }

}());