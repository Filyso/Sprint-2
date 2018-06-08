/* 
tuto utiliser ce truc : 
 coller ça dans le head :
 <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
 
  et ça avant la fin du body:  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="../javascript/jsAnimParticules.js"></script>
    
puis mettre dans la div qu'on veut l'id "particle"    
*/

var options = {
    "particles": {
        "number": {
            "value": 40, //nb de particule
            "density": {
                "enable": true,
                "value_area": 1000
            }
        },
        "color": {
            "value": "random" //couleur
        },
        "shape": {
            "type": "circle",
            "stroke": {
                "width": 0,
                "color": "#000000"
            },
            "polygon": {
                "nb_sides": 3
            },
            "image":{
                "src" : "../images/note_music - Copie.png",
                "width" : 150,
                "height" : 150
            }
        },
        "opacity": {
            "value": 1,
            "random": true,
            "anim": {
                "enable": false,
                "speed": 1,
                "opacity_min": 0.1,
                "sync": false
            }
        },
        "size": {
            "value": 5,
            "random": true,
            "anim": {
                "enable": true,
                "speed": 1,
                "size_min": 0.1,
                "sync": false
            }
        },
        "line_linked": {
            "enable": false,  // mettre true si on veut des liens entre les points
            "distance": 150,
            "color": "#f4be09", //couleur des lignes
            "opacity": 0.4,
            "width": 1
        },
        "move": {
            "enable": true,
            "speed": 1,       //vitesse des boules
            "direction": "none",
            "random": true,
            "straight": false,
            "out_mode": "out",
            "bounce": false,
            "attract": {
                "enable": false,
                "rotateX": 600,
                "rotateY": 1200
            }
        }
    },
    "interactivity": {
        "detect_on": "canvas",
        "events": {
            "onhover": {
                "enable": true,  //mettre en true si on veut que les boules dégagent au passage de la souris
                "mode": "grab"
            },
            "onclick": {
                "enable": true,
                "mode": "repulse"
            },
            "resize": true
        },
        "modes": {
            "grab": {
                "distance": 150,
                "line_linked": {
                    "opacity": 1
                }
            },
            "bubble": {
                "distance": 400,
                "size": 40,
                "duration": 2,
                "opacity": 8,
                "speed": 3
            },
            "repulse": {
                "distance": 200,
                "duration": 0.2
            },
            "push": {
                "particles_nb": 4
            },
            "remove": {
                "particles_nb": 2
            }
        }
    },
    "retina_detect": false
};
particlesJS("particle", options);