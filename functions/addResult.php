<?php
session_start();
require_once './connection.php';
require_once './getResult.php';
function addResult($conn,$mail,$age,$sexe,$ville,$cp,$freqDouche,$tempsDouche,$debitDouche,$freqBain,$rempBain,$freqDents,$eauDents,$freqVaisselle,$choixVaisselle,$methVaisselle,$couvVaisselle,$freqMal,$dateMal,$ecoeau,$plante,$momentPlante,$eauPlante,$freqPlante,$voiture,$methVoiture,$freqVoiture,$piscine,$freqPiscine,$volumePiscine,$etiquette,$bouteille){
    $sql="INSERT INTO 
    `result`
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
        `freqVaisselle`,
        `choixVaisselle`,
        `methVaisselle`,
        `couvVaisselle`,
        `freqMal`,
        `dateMal`,
        `ecoeau`,
        `plante`,
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
        :freqVaisselle,
        :choixVaisselle,
        :methVaisselle,
        :couvVaisselle,
        :freqMal,
        :dateMal,
        :ecoeau,
        :plante,
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
    $stmt->bindValue(':dateMal', $dateMal);
    $stmt->bindValue(':ecoeau', $ecoeau);
    $stmt->bindValue(':plante', $plante);
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

$sql="SELECT 
        `mail`
    FROM 
        `result`
    WHERE
        `mail` = :mail
    ;";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':mail', $_POST['email']);
    $stmt->execute();
    errorHandler($stmt);
    $mail=null;
    while(false !== $row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $mail[]=$row;
    }

if(isset($mail[0])){
    header('location:/already_form.php');
}else{

addResult(
    $conn,
    $_POST['email'],
    $_POST['age'],
    $_POST['sexe'],
    $_POST['ville'],
    $_POST['cp'],
    $_POST['q1a'],
    $_POST['q1b'],
    $_POST['q1c'],
    $_POST['q2a'],
    $_POST['q2b'],
    $_POST['q3a'],
    $_POST['q3b'],
    $_POST['q4a'],
    $_POST['q4b'],
    $_POST['q4c'],
    $_POST['q4d'],
    $_POST['q5a'],
    $_POST['q5b'],
    $_POST['q6b'],
    $_POST['q7a'],
    $_POST['q7b'],
    $_POST['q7c'],
    $_POST['q7d'],
    $_POST['q8a'],
    $_POST['q8b'],
    $_POST['q8c'],
    $_POST['q9a'],
    $_POST['q9b'],
    $_POST['q9c'],
    $_POST['q10'],
    $_POST['q11']
);
$_SESSION["mail"] = $_POST["email"];
header('location:/valid_form.php');
}