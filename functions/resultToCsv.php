<?php
require_once 'connection.php';
require_once 'getResult.php';


function resultToCsv($conn){
    $res = getResult($conn);
    $file = fopen('data.csv', 'w');
    var_dump($res);
    fputcsv($file, array('id','age','sexe','ville','cp','freqDouche','tempsDouche','debitDouche','freqBain','rempBain','freqDents','eauDents','freqVaisselle','choixVaisselle','methVaisselle','couvVaisselle','freqMal','dateMal','ecoEau','plante','momentPlante','eauPlante','freqPlante','voiture','methVoiture','freqVoiture','piscine','freqPiscine','volumePiscine','etiquette','bouteille'));
    foreach ($res as $row) {
        fputcsv($file, $row);
    }
    fclose($file);
}
resultToCsv($conn);