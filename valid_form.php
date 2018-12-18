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
    `ecoEau`,
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

// -----conseils-----

//bool
$csDouche1 = 0;// label energie
$csDouche2 = 0;//coupez l'eau
$csDouche3 = 0;//douche plus courte
$csBain1 = 0;//pas de bain
$csBain2 = 0;//pas remplir a fond
$csDent1 = 0;//coupez l'eau
$csVaisselle1 = 0;//coupez l'eau
$csVaisselle2 = 0;//acheter lave-vaisselle
$csVaisselle3 = 0;//rappel lancer a plein le lavevaisselle
$csMAL1 = 0;//verifiez l'ettiquette energetique
$csEco1 = 0;//mitigeur
$csEco2 = 0;//recuperateur
$csEco3 = 0;//chasse
$csPlante1 = 0;//arroser le soir
$csPlante2 = 0;//preferer l'eau de pluie
$csVoiture1 = 0;//eviter par forte chaleur
$csVoiture2 = 0;//lavage auto
$csPiscine1 = 0;// 1/4 remplissage /an
$csEtiquette1 = 0;//check ettiquette
$csBouteille1 = 0;// eau du robinet

//douche
if($tmp["debitDouche"] == "fort"){
  $csDouche1 = 1;
  $csDouche2 = 1;
}elseif($tmp["debitDouche"] == "moyen"){
  $csDouche1 = 1;
}
if($tmp["tempsDouche"] > 15){
  $csDouche3 = 1;
}
//echo "<!--".$csDouche1." ".$csDouche2."-->";

//bain
if($tmp["freqBain"] > 0){
  $csBain1 = 1;
  if($tmp["rempBain"] == "oui"){
    $csBain2 = 1;
  }
}

//dents
if($tmp["eauDents"] != "oui"){
  $csDent1 = 1;
}

//vaisselle
if($tmp["choixVaisselle"] == "main"){
  if($tmp["methVaisselle"] == "oui"){
    $csVaisselle1 = 1;
  }
  if($tmp["freqVaisselle"] > 7 || $tmp["couvVaisselle"] > 16){
    $csVaisselle2 = 1;
  }
}else{
  $csVaisselle3 = 1;
}

//MAL
if($tmp["dateMal"] == "ancien"){
  $csMAL1 = 1;
}

//ecoeau
$ecoEau = $tmp["ecoEau"];
if($ecoEau < 100){
  $csEco1 = 1;
}
if($ecoEau % 100 < 10){
  $csEco2 = 1;
}
if($ecoEau % 10 < 1){
  $csEco3 = 1;
}


//plante
if($tmp["plante"] == "oui"){
  if($tmp["momentPlante"] != "soir"){
    $csPlante1 = 1;
  }
  if($tmp["eauPlante"] == "robinet"){
    $csPlante2 = 1;
  }
}

//voiture
if($tmp["voiture"] == "oui"){
  $csVoiture1 = 1;
  if($tmp["methVoiture"] == "manuel"){
    $csVoiture2 = 1;
  }
}

//piscine
if($tmp["piscine"] == "oui"){
  if($tmp["freqPiscine"] == "oui"){
    $csPiscine1 = 1;    
  }
}

//etiquette
if($tmp["etiquette"] == "non"){
  $csEtiquette1 = 1;
}

//bouteille
if($tmp["bouteille"] == "bouteille"){
  $csBouteille1 = 1;
}




// -----conso-----

//douche
$debitDouche = 0;
if($tmp["debitDouche"] == "faible"){$debitDouche = 12 ;}
elseif($tmp["debitDouche"] == "moyen"){$debitDouche = 15 ;}  
elseif($tmp["debitDouche"] == "fort"){$debitDouche = 20 ;}
$consoDouche = $tmp["tempsDouche"] * $debitDouche * $tmp["freqDouche"];//par semaine


//bain
$rempBain = 0;
if($tmp["rempBain"] == "oui"){$rempBain = 200 ;}
elseif($tmp["rempBain"] == "non"){$rempBain = 120 ;}  
$consoBain = $tmp["freqBain"] * $rempBain; //par semaine

//dents
$eauDents = 0;
if($tmp["eauDents"] == "oui"){$eauDents = 2 ;}
elseif($tmp["eauDents"] == "parfois"){$eauDents = 19 ;}  
elseif($tmp["eauDents"] == "non"){$eauDents = 36 ;}
$consoDents = $tmp["freqDents"] * $eauDents;//par jour

//vaisselle
$consoVaisselle = 0;
if($tmp["choixVaisselle"] == "main"){
  if($tmp["methVaisselle"] == "non"){
    $consoVaisselle = $tmp["freqVaisselle"] * 10;//par semaines
  }else{
    $consoVaisselle = $tmp["freqVaisselle"] * $tmp["couvVaisselle"] * 0.5;//par semaines
  }
}else{
  $consoVaisselle = $tmp["freqVaisselle"] * 12;//par semaines
}

//MAL
$consoMal = 0;
if($tmp["dateMal"] == "ancien"){
  $consoMal = $tmp["freqMal"] * 100;//par mois
}else{
  $consoMal = $tmp["freqMal"] * 50;//par mois
}

//voiture
$consoVoiture = 0;
if($tmp["methVoiture"] == "manuel"){
  $consoVoiture = $tmp["freqVoiture"] * 200;//par mois
}else{
  $consoVoiture = $tmp["freqVoiture"] * 60;//par mois
}

//piscine
$consoPiscine = 0;
if($tmp["piscine"] = "oui"){
  if($tmp["freqPiscine"] = "oui"){
    $consoPiscine = $tmp["volumePiscine"] * 1000;//par an
  }else{
    $consoPiscine = $tmp["volumePiscine"] * 250;//par an
  }
}

//conso
$conso = ($consoDouche * 52) + ($consoBain * 52) + ($consoDents * 365) + ($consoVaisselle * 52) + ($consoMal * 12) + ($consoVoiture * 12) + $consoPiscine;

//eco
$eco 




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

    <section class="presentation-section">
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="col-md-10 text-center heading-section heading-section-white ftco-animate fadeInUp ftco-animated">
          <h2 class="title">Voiture</h2>
          <p class="description">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
            exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
            dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
            anim id est laborum.
          </p>
        </div>
      </div>
    </div>
  </section>

    <?php include "footer.php" ?>


  <?php include "js-import.php" ?>

  </body>
</html>
