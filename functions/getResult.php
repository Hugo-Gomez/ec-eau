<?php

require_once 'functions/connection.php';
function getResult($conn){
    $sql="SELECT 
        `id`,
        `age`,
        `sexe`,
        `ville`,
        `cp`,
        `freqDouche`,
        `tempsDouche`,
        `debitDouche`,
        `freqBain`,
        `rempBain`,
        `freqDents`,
        `eauDents`,
        `freqVaisselle`,
        `choixVaisselle`,
        `methVaisselle`,
        `couvVaisselle`,
        `freqMal`,
        `tailleMal`,
        `dateMal`,
        `ecoeau`,
        `plante`,
        `quantitePlante`,
        `momentPlante`,
        `eauPlante`,
        `freqPlante`,
        `voiture`,
        `methVoiture`,
        `freqVoiture`,
        `piscine`,
        `freqPiscine`,
        `volumePiscine`,
        `etiquette`,
        `bouteille`
    FROM 
        `result`
    ;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    errorHandler($stmt);
    $res=null;
    while(false !== $row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $res[]=$row;
    }
}