(function () {

    "use strict";

    $(document).ready(initialiser);

    //variables globales
    var animationTo = document.getElementById("animation-to");
    var animationFrom = document.getElementById("animation-from");

    function initialiser(evt) {

        var timing = 'cubic-bezier(0.7, 0, 0.3, 1)';

        Moveit.put(first, {
            start: '0%',
            end: '14%'
        });

        Moveit.put(second, {
            start: '0%',
            end: '11.5%'
        });

        Moveit.put(middle, {
            start: '0%',
            end: '100%'
        });

        var open = false;

        //Clic sur l'icône burger du menu & animation du burger (fonction anonyme)
        $('.container').click(function () {

            $('nav').toggleClass("menuHidden");
            $('nav').toggleClass("menuShown");

            if (!open) {
                Moveit.animate(first, {
                    start: '78%',
                    end: '93%',
                    duration: 1,
                    timing: timing,
                });
                Moveit.animate(middle, {
                    start: '50%',
                    end: '50%',
                    duration: 1,
                    timing: timing,
                });
                Moveit.animate(second, {
                    start: '81.5%',
                    end: '94%',
                    duration: 1,
                    timing: timing,
                });
                
            } else {
                Moveit.animate(first, {
                    start: '0%',
                    end: '14%',
                    duration: 1,
                    timing: timing,
                });
                Moveit.animate(middle, {
                    start: '0%',
                    end: '100%',
                    duration: 1,
                    timing: timing,
                });
                Moveit.animate(second, {
                    start: '0%',
                    end: '11.5%',
                    duration: 1,
                    timing: timing,
                });
            }
            open = !open;

        });

        //Clic sur le bouton plein écran
        var fullScreenButton = document.getElementById("fullScreenButton");
        fullScreenButton.addEventListener('click', goFullScreen, false);

    } //Fin de la fonction initialiser

    //Fonction plein écran
    function goFullScreen(evt) {

        //Animation du bouton
        if (this.classList.contains("animated")) {
            this.classList.remove("animated");
            animationFrom.beginElement();
        } else {
            this.classList.add("animated");
            animationTo.beginElement();
        }

        //Activation/Désactivation du mode plein écran avec le clic

        evt.preventDefault();
        var doc = window.document;
        var docEl = doc.documentElement;

        var requestFullScreen = docEl.requestFullscreen || docEl.mozRequestFullScreen || docEl.webkitRequestFullScreen || docEl.msRequestFullscreen;
        var cancelFullScreen = doc.exitFullscreen || doc.mozCancelFullScreen || doc.webkitExitFullscreen || doc.msExitFullscreen;

        if (!doc.fullscreenElement && !doc.mozFullScreenElement && !doc.webkitFullscreenElement && !doc.msFullscreenElement) {
            requestFullScreen.call(docEl);
            window.addEventListener("webkitFullscreenEnabled", escapeFullScreen);

        } else {
            cancelFullScreen.call(doc);

        }

    }

    function escapeFullScreen(evt) {
        var fullScreenButton = document.getElementById("fullScreenButton");
       // if (evt.keyCode == 27) {
            //window.alert("igiy");
            fullScreenButton.classList.remove("animated");
            animationFrom.beginElement();
            document.removeEventListener("keydown", escapeFullScreen);
       // }
    }
}());