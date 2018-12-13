<?php
require_once 'functions/connection.php';

function addResult($conn,$mail,$age,$sexe,$ville,$cp,$freqDouche,$tempsDouche,$debitDouche,$freqBain,$rempBain,$freqDents,$eauDents,$choixVaisselle,$freqVaisselle,$methVaisselle,$couvVaisselle,$freqMal,$tailleMal,$dateMal,$ecoeau,$plante,$quantitePlante,$momentPlante,$eauPlante,$freqPlante,$voiture,$methVoiture,$freqVoiture,$piscine,$freqPiscine,$volumePiscine,$etiquette,$bouteille){
    $sql="INSERT INTO 
    `ressult`
    (
        `mail`,
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
        `choixVaisselle`,
        `freqVaisselle`,
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
    ) 
    VALUES 
    (
        :mail,
        :age,
        :sexe,
        :ville,
        :cp,
        :freqDouche,
        :tempsDouche,
        :debitDouche,
        :freqBain,
        :rempBain,
        :freqDents,
        :eauDents,
        :choixVaisselle,
        :freqVaisselle,
        :methVaisselle,
        :couvVaisselle,
        :freqMal,
        :tailleMal,
        :dateMal,
        :ecoeau,
        :plante,
        :quantitePlante,
        :momentPlante,
        :eauPlante,
        :freqPlante,
        :voiture,
        :methVoiture,
        :freqVoiture,
        :piscine,
        :freqPiscine,
        :volumePiscine,
        :etiquette,
        :bouteille
    )";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':mail', $mail);
    $stmt->bindValue(':age', $age);
    $stmt->bindValue(':sexe', $sexe);
    $stmt->bindValue(':ville', $ville);
    $stmt->bindValue(':cp', $cp);
    $stmt->bindValue(':freqDouche', $freqDouche);
    $stmt->bindValue(':tempsDouche', $tempsDouche);
    $stmt->bindValue(':debitDouche', $debitDouche);
    $stmt->bindValue(':freqBain', $freqBain);
    $stmt->bindValue(':rempBain', $rempBain);
    $stmt->bindValue(':freqDents', $freqDents);
    $stmt->bindValue(':eauDents', $eauDents);
    $stmt->bindValue(':choixVaisselle', $choixVaisselle);
    $stmt->bindValue(':freqVaisselle', $freqVaisselle);
    $stmt->bindValue(':methVaisselle', $methVaisselle);
    $stmt->bindValue(':couvVaisselle', $couvVaisselle);
    $stmt->bindValue(':freqMal', $freqMal);
    $stmt->bindValue(':tailleMal', $tailleMal);
    $stmt->bindValue(':dateMal', $dateMal);
    $stmt->bindValue(':ecoeau', $ecoeau);
    $stmt->bindValue(':plante', $plante);
    $stmt->bindValue(':quantitePlante', $quantitePlante);
    $stmt->bindValue(':momentPlante', $momentPlante);
    $stmt->bindValue(':eauPlante', $eauPlante);
    $stmt->bindValue(':freqPlante', $freqPlante);
    $stmt->bindValue(':voiture', $voiture);
    $stmt->bindValue(':methVoiture', $methVoiture);
    $stmt->bindValue(':freqVoiture', $freqVoiture);
    $stmt->bindValue(':piscine', $piscine);
    $stmt->bindValue(':freqPiscine', $freqPiscine);
    $stmt->bindValue(':volumePiscine', $volumePiscine);
    $stmt->bindValue(':etiquette', $etiquette);
    $stmt->bindValue(':bouteille', $bouteille);
    $stmt->execute();
    errorHandler($stmt);
}