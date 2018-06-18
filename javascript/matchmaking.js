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
                if (competitorFind) {
                    window.clearInterval(timerQueue);
                } else {
                    console.log("En recherche de Matchmaking");
                }
            },
            'json'
        );
    }

}());