function calculScore(seconde, milliseconde, numeroQuestion) {

    var tempsCourant = seconde + (milliseconde/100);
    

    if (numeroQuestion == 7) {
        
        var tempsInitial = 10;
        var scoreMax = 40;

        var pourcent = Math.round((tempsCourant / tempsInitial) * 20) / 20;
        var scoreReponse = pourcent * scoreFinalMax;

    } else {

        var tempsInitaial = 20;
        var scoreMax = 20;

        var pourcent = Math.round((tempsCourant / tempsInitial) * 20) / 20;
        var scoreReponse = pourcent * scoreMax;
        
    }

    var scoreGeneral = scoreGeneral + scoreReponse;
    
    return scoreGeneral;

}