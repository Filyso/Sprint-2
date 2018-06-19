(function () {
    "use strict";
    document.addEventListener("DOMContentLoaded", initialiser);

    function initialiser(evt) {
        console.log("test");
        window.addEventListener('beforeunload', function (event) {
            console.log('I am the 1st one.');
            $.post(
                '../php/scripts/script_game_multi.php', {
                    function: 'delLobby'
                }
            );
        });
    }

    function beforeUnloadGame(evt) {
        window.alert("test");
    }

}());