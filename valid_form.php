<?php
require_once('functions/connection.php');
session_start();
$_SESSION['mail']="bocquillon.pierre@orange.fr";
$sql="SELECT 
    `id`,
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
FROM 
    `result`
WHERE
    `mail` = :mail
;";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':mail', $_SESSION['mail']);
$stmt->execute();
errorHandler($stmt);
$res=null;
while(false !== $row = $stmt->fetch(PDO::FETCH_ASSOC)){
$res[]=$row;
}
$tmp = $res[0];

//bool
$csDouche1 = FALSE;// label energie
$csDouche2 = FALSE;//coupez l'eau
$csBain1 = FALSE;//pas de bain
$csBain2 = FALSE;//pas remplir a fond
$csDent1 = false;//coupez l'eau
$csVaisselle1 = false;//coupez l'eau
$csVaisselle2 = false;//acheter lave-vaisselle
$csVaisselle3 = false;//rappel lancer a plein le lavevaisselle
$csMAL1 = false;//verifiez l'ettiquette energetique
$csEco1 = false;//mitigeur
$csEco2 = false;//recuperateur
$csEco3 = false;//chasse
$csPlante1 = false;//arroser le soir
$csPlante2 = false;//preferer l'eau de pluie
$csVoiture1 = false;//eviter par forte chaleur
$csVoiture2 = false;//lavage auto
$csPiscine1 = false;// 1/4 remplissage /an
$csEtiquette1 = false;//check ettiquette
$csBouteille1 = false;// eau du robinet

//douche
if($tmp["debitDouche"] == "fort"){
  $csDouche1 = TRUE;
  $csDouche2 = TRUE;
}elseif($tmp["debitDouche"] == "moyen"){
  $csDouche1 = TRUE;
}
//echo "<!--".$csDouche1." ".$csDouche2."-->";

//bain
if($tmp["freqBain"] > 0){
  $csBain1 = true;
  if($tmp["rempBain"] == "oui"){
    $csBain2 = true;
  }
}

//dents
if($tmp["eauDents"] != "oui"){
  $csDent1 = true;
}

//vaisselle
if($tmp["choixVaisselle"] == "main"){
  if($tmp["methVaisselle"] == "oui"){
    $csVaisselle1 = true;
  }
  if($tmp["freqVaisselle"] > 7 || $tmp["couvVaisselle"] > 16){
    $csVaisselle2 = true;
  }
}else{
  $csVaisselle3 = true;
}

//MAL
if($tmp["dateMAL"] == "ancien"){
  $csMAL1 = true;
}

//ecoeau
$eco = $tmp["ecoEau"];
if($eco < 100){
  $csEco1 = true;
}
if($eco % 100 < 10){
  $csEco2 = true;
}
if($eco % 10 < 1){
  $csEco3 = true;
}


//plante
if($tmp["plante"] == "oui"){
  if($tmp["momentPlante"] != "soir"){
    $csPlante1 = true;
  }
  if($tmp["eauPlante"] == "robinet"){
    $csPlante2 = true;
  }
}

//voiture
if($tmp["voiture"] == "oui"){
  $csVoiture1 = true;
  if($tmp["methVoiture"] == "manuel"){
    $csVoiture2 = true;
  }
}

//piscine
if($tmp["piscine"] == "oui"){
  if($tmp["freqPiscine"] == "oui"){
    $csPiscine1 = true;    
  }
}

//etiquette
if($tmp["etiquette"] == "non"){
  $csEtiquette1 = true;
}

//bouteille
if($tmp["bouteille"] == "bouteille"){
  $csBouteille1 = true;
}



?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include "header.php" ?>
  </head>
  <body>

  <?php include "topbar.php" ?>
    

    <section class="ftco-section-parallax test-section">
      <div class="parallax-img d-flex align-items-center">
        <div class="container">
          <div class="row d-flex justify-content-center">
            <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
              <h2>Merci d'avoir répondu au formulaire.</h2>
              <div class="row d-flex justify-content-center mt-5">
                <div class="col-md-8">
                  <a class="test-link" href="index.php"><span>Revenir à l'accueil</span></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <?php include "footer.php" ?>


  <?php include "js-import.php" ?>

  </body>
</html>
