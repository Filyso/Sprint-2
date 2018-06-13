(function () {

        "use strict";

        document.addEventListener("DOMContentLoaded", initialiser);

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

        //Fonction vérifiant le respect orthographique des URL (on ne vérifie pas l'existence de l'URL)
        function verifierURL(evt) {
            console.log("test");
            url.setCustomValidity("");

            //Les slash de l'URL sont échappées grâce aux anti-slash
            var regex = /^(https:\/\/www.youtube.com\/watch?)\w*?/;

            if (!url.checkValidity()) {
                if (!regex.test(url.value)) {
                    url.setCustomValidity("Le format de l'URL n'est pas correct");
                    url.style.backgroundColor = "red";
                }
            }
        }

        //Fonction vérifiant la bonne temporalité des timecodes
        function verifierTimecodes(evt) {

            var m1 = minute1.value;
            var m2 = minute2.value;
            var s1 = seconde1.value;
            var s2 = seconde2.value;

            m2.setCustomValidity("");

            if (m2.checkValidity()) {
                if ((m2 < m1) || (m1 = m2 && s2 < s1)) {
                    m2.setCustomValidity("Attention à bien respecter une logique temporelle");
                    m1.style.backgroundColor="red";
                    m2.style.backgroundColor="red";
                    s1.style.backgroundColor="red";
                    s2.style.backgroundColor="red";
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

            //Fonction pour comparer les paroles à l'aide de 2 tableaux
            if (p1.checkValidity()) {
                for (var paroles of tabParoles) {
                    let array = [];
                    for (var p of paroles) {
                        if (p !== paroles) {
                            array.push(p);
                        }
                    }
                    if (array.length !== valeurs.length - 1) {
                        p1.setCustomValidity("Attention à bien mettre des paroles différentes dans chaque champ");
                        p1.style.backgroundColor="red";
                        p2.style.backgroundColor="red";
                        p3.style.backgroundColor="red";
                        p4.style.backgroundColor="red";
                        p5.style.backgroundColor="red";
                    }
                }
            }
        }

}());

//Ancienne version
/*//Fonction principale
function verifForm(f) {

    var urlOk = verifierURL(f.url);
    var timecodesOk = verifierTimecodes(f.timecode);
    var parolesOk = verifierParoles(f.paroles);

    if (urlOk && timecodesOk && parolesOk) {
        return true;
    } else {
        alert("Attention à bien remplir correctement tous les champs");
        return false;
    }

}

//Fonction vérifiant le respect orthographique des URL (on ne vérifie pas l'existence de l'URL)
function verifierURL(champ) {
    //Les slash de l'URL sont échappées grâce aux anti-slash
    var regex = /^(https:\/\/www.youtube.com\/watch?)\w*?/;
    if (!regex.test(champ.value)) {
        surligne(champ, true);
        return false;
    } else {
        surligne(champ, false);
        return true;
    }
}

//Fonction vérifiant la bonne temporalité des timecodes
function verifierTimecodes(champ) {
    var m1 = champ.value;
    var m2 = document.getElementById("minEnd_1").value;
    var s1 = document.getElementById("secStart_1").value;
    var s2 = document.getElementById("secEnd_1").value;

    if ((m2 < m1) || (m1 = m2 && s2 < s1)) {
        surligne(m1, true);
        surligne(m2, true);
        surligne(s1, true);
        surligne(s2, true);
        return false;
    } else if ((m2 = m1) || (m2 > m1)) {
        surligne(champ, false);
        return true;
    }
}

//Fonction vérifiant que les paroles et réponses sont différentes pour chaque champ
function verifierParoles(champ) {

    var p1 = champ.value.toLowerCase();
    var p2 = document.getElementById("goodRep_1").value.toLowerCase();
    var p3 = document.getElementById("badRep1_1").value.toLowerCase();
    var p4 = document.getElementById("badRep2_1").value.toLowerCase();
    var p5 = document.getElementById("badRep3_1").value.toLowerCase();

    var tabParoles = [p1, p2, p3, p4, p5];
    
    //Fonction pour comparer les paroles à l'aide de tableaux
    function comparer(tabParoles) {
        for (var paroles of tabParoles) {
            let array = [];
            for (var p of paroles) {
                if (p !== paroles) {
                    array.push(p);
                }
            }
            if (array.length !== valeurs.length - 1) {
                surligne(p1, true);
                surligne(p2, true);
                surligne(p3, true);
                surligne(p4, true);
                surligne(p5, true);
            }
        }
        return true;
    }

}

//Fonction pointant les erreurs (surlignant en couleur)
function surligne(champ, erreur) {
    if (erreur) {
        champ.style.backgroundColor = "#fba";
    } else {
        champ.style.backgroundColor = "";
    }
}*/