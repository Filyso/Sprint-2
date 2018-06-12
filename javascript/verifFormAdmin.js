function verifForm(f) {
    
    var urlOk= verifierURL(f.url);
    var timecodesOk= verifierTimecodes(f.timecode) ;
    var parolesOk= verifierParoles(f.paroles);

    if ( urlOk && timecodesOk && parolesOk){
        return true;
    } else {
        alert("Attention à bien remplir correctement tous les champs");
        return false;
    }

}

//Fonction vérifiant le respect orthographique des URL (on ne vérifie pas l'existence de l'URL)
function verifierURL(champ) {
    //Les slash de l'URL sont échappées grâce aux anti-slash
    var regex = /^https:\/\/www.youtube.com\/watch?[\w]?/;
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

    if ((m2 < m1) || (m1=m2 && s2<s1)) {
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
    
    if(p1==p2 || p1==p3 || p1==p4 || p1==p5 || p2==p3 || p2==p4 || p2==p5 || p3==p4 || p3==p5 || p4==p5){
        surligne(p1, true);
        surligne(p2, true);
        surligne(p3, true);
        surligne(p4, true);
        surligne(p5, true);
    } else {
        return true;
    }

}

//Fonction pointant les erreurs
function surligne(champ, erreur) {
    if (erreur) {
        champ.style.backgroundColor = "#fba";
    } else {
        champ.style.backgroundColor = "";
    }
}