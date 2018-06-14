(function () {

    "use strict";
    document.addEventListener("DOMContentLoaded", initialiser);

    var pseudo;
    var mdp1;
    var mdp2;
    var nom;
    var prenom;
    var mail;

    function initialiser(evt) {

        pseudo = document.getElementById("pseudoSignUp");
        mdp1 = document.getElementById("passSignUp");
        mdp2 = document.getElementById("passverif");
        nom = document.getElementById("lastname");
        prenom = document.getElementById("name");
        mail = document.getElementById("emailSignUp");

        pseudo.addEventListener("change", verifierPseudo);
        mdp1.addEventListener("change", verifierMdp1);
        mdp2.addEventListener("change", verifierMdp2);
        nom.addEventListener("change", verifierNom);
        prenom.addEventListener("change", verifierPrenom);
        mail.addEventListener("change", verifierMail);

    }

    function verifierPseudo(evt) {
        this.setCustomValidity("");
        if (!this.checkValidity()) {
            this.setCustomValidity("Le pseudo doit contenir entre 4 et 16 caractères (caractères spéciaux interdits)");
            this.style.borderColor = "red";
        } else {
            this.style.borderColor = "initial";
        }
    }

    function verifierMdp1(evt) {
        this.setCustomValidity("");
        if (!this.checkValidity()) {
            this.setCustomValidity("Le mot de passe (entre 8 et 42 caractères) doit contenir au moins une majuscule, une minuscule, et un chiffre");
            this.style.borderColor = "red";
        } else {
            this.style.borderColor = "initial";
        }
    }

    function verifierMdp2(evt) {
        this.setCustomValidity("");
        if (mdp1.checkValidity() && this.checkValidity()) {
            if (mdp1.value != this.value) {
                this.setCustomValidity("Les 2 mots de passe ne sont pas identiques");
                this.style.borderColor = "red";
            }
        }
    }

    function verifierNom(evt) {
        this.setCustomValidity("");
        if (!this.checkValidity()) {
            this.setCustomValidity("Le nom doit faire 25 caractères maximum");
            this.style.borderColor = "red";
        } else {
            this.style.borderColor = "initial";
        }
    }

    function verifierPrenom(evt) {
        this.setCustomValidity("");
        if (!this.checkValidity()) {
            this.setCustomValidity("Le prénom doit faire 25 caractères maximum");
            this.style.borderColor = "red";
        } else {
            this.style.borderColor = "initial";
        }
    }

    function verifierMail(evt) {
        this.setCustomValidity("");
        if (!this.checkValidity()) {
            this.setCustomValidity("Veuillez respecter un format mail valide");
            this.style.borderColor = "red";
        } else {
            this.style.borderColor = "initial";
        }
    }


}());