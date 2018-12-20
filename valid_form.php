<?php
require_once('functions/connection.php');
session_start();
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
$csVoiture1 = 0;//lavage auto
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
  if($tmp["methVoiture"] == "manuel"){
    $csVoiture1 = 1;
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
$consoDouche = ($consoDouche * 52) ;
$consoBain = ($consoBain * 52) ;
$consoDents = ($consoDents * 365) ;
$consoVaisselle = ($consoVaisselle * 52) ;
$consoMal = ($consoMal * 12) ;
$consoVoiture = ($consoVoiture * 12) ;
$conso = $consoDouche + $consoBain + $consoDents + $consoVaisselle + $consoMal + $consoVoiture + $consoPiscine;
//eco
$ecoDouche = $consoDouche - (5*12*$tmp["freqDouche"]*52);
$ecoBain = $consoBain;
$ecoDents = $consoDents - 4*365;
$ecoVaisselle = 0;
if($tmp["choixVaisselle"] == "main"){$ecoVaisselle = $consoVaisselle - 3650;}
if($ecoVaisselle<0){$ecoVaisselle = 0;}
$ecoMal = $consoMal - ($tmp["freqMal"] * 50)*12;
$ecoVoiture = 0;
if($tmp["voiture"] == "oui"){$ecoVoiture = $consoVoiture - (60 * 12);}
$ecoPiscine = 0;
if($tmp["piscine"] == "oui"){$ecoPiscine = $consoPiscine - $tmp["volumePiscine"] * 250;}
$eco = $ecoDouche + $ecoBain + $ecoDents + $ecoVaisselle + $ecoMal + $ecoVoiture + $ecoPiscine;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include "header.php" ?>
  </head>
  <body>

  <?php include "topbar.php" ?>
  <div class="hero-wrap" style="background-image: url('images/advice-wallpaper.jpg'); background-attachment:fixed;">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center" data-scrollax-parent="true">
          <div class="col-md-8 ftco-animate text-center">
            <h1 class="mb-3 bread">Les conseils personnels</h1>
          </div>
        </div>
      </div>
    </div>

  <section class="ftco-services category-advice">
      <div class="container">
        <div class="row no-gutters">
          <div class="col-md-4 ftco-animate py-5 nav-link-wrap">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

            <?php
              //$csDouche1 = 0;$csDouche2 = 0;$csDouche3 = 0;
              if ($csDouche1 == 1 || $csDouche2 == 1 || $csDouche3 == 1){
            ?>
              <a class="nav-link px-4 active" id="v-pills-master-tab" data-toggle="pill" href="#v-pills-master" role="tab" aria-controls="v-pills-master" aria-selected="true"><i class="fas fa-shower"></i> Douche</a>
            <?php
              }
              if ($csBain1 == 1 || $csBain2 == 1){
            ?>
              <a class="nav-link px-4" id="v-pills-bath-tab" data-toggle="pill" href="#v-pills-bath" role="tab" aria-controls="v-pills-bath" aria-selected="false"><i class="fas fa-bath"></i>Bain</a>
              <?php
              }
              if ($csDent1 == 1){
            ?>
              <a class="nav-link px-4" id="v-pills-dish-tab" data-toggle="pill" href="#v-pills-dish" role="tab" aria-controls="v-pills-dish" aria-selected="false"><i class="fas fa-tooth"></i> Dents</a>
              <?php
              }
              if ($csVaisselle1 == 1 || $csVaisselle2 == 1 || $csVaisselle3 == 1){
            ?>
              <a class="nav-link px-4" id="v-pills-clothes-tab" data-toggle="pill" href="#v-pills-clothes" role="tab" aria-controls="v-pills-clothes" aria-selected="false"><i class="fas fa-utensils"></i> Vaisselle</a>
              <?php
              }
              if ($csMAL1 == 1){
            ?>
              <a class="nav-link px-4" id="v-pills-garden-tab" data-toggle="pill" href="#v-pills-garden" role="tab" aria-controls="v-pills-garden" aria-selected="false"><i class="fab fa-500px"></i> Machine à laver</a>
              <?php
              }
              if ($csEco1 == 1 || $csEco2 == 1 || $csEco3 == 1){
            ?>
              <a class="nav-link px-4" id="v-pills-pagelines-tab" data-toggle="pill" href="#v-pills-pagelines" role="tab" aria-controls="v-pills-pagelines" aria-selected="false"><i class="fas fa-check"></i> Economiseur</a>
              <?php
              }
              if ($csPlante1 == 1 || $csPlante2 == 1){
            ?>
              <a class="nav-link px-4" id="v-pills-drink-tab" data-toggle="pill" href="#v-pills-drink" role="tab" aria-controls="v-pills-drink" aria-selected="false"><i class="fas fa-leaf"></i> Plantes</a>
              <?php
              }
              if ($csVoiture1 == 1){
            ?>
              <a class="nav-link px-4" id="v-pills-car-tab" data-toggle="pill" href="#v-pills-car" role="tab" aria-controls="v-pills-swimmer" aria-selected="false"><i class="fas fa-car"></i> Voiture</a>
              <?php
              }
              if ($csPiscine1 == 1){
            ?>
              <a class="nav-link px-4" id="v-pills-swimmer-tab" data-toggle="pill" href="#v-pills-swimmer" role="tab" aria-controls="v-pills-swimmer" aria-selected="false"><i class="fas fa-swimmer"></i> Piscine</a>
              <?php
              }
              if ($csEtiquette1 == 1){
            ?>
              <a class="nav-link px-4" id="v-pills-sticky-note-tab" data-toggle="pill" href="#v-pills-sticky-note" role="tab" aria-controls="v-pills-sticky-note" aria-selected="false"><i class="fas fa-sticky-note"></i> Etiquettes</a>
              <?php
              }
              if ($csBouteille1 == 1){
            ?>
              <a class="nav-link px-4" id="v-pills-wine-bottle-tab" data-toggle="pill" href="#v-pills-wine-bottle" role="tab" aria-controls="v-pills-wine-bottle" aria-selected="false"><i class="fas fa-wine-bottle"></i> Bouteilles</a>
              <?php
              }
            ?>
            <a class="nav-link px-4" id="v-pills-file-alt-tab" data-toggle="pill" href="#v-pills-file-alt" role="tab" aria-controls="v-pills-file-alt" aria-selected="false"><i class="fas fa-file-alt"></i> Récap</a>
            </div>
          </div>
          <div class="col-md-8 ftco-animate p-4 p-md-5 d-flex align-items-center">

            <div class="tab-content pl-md-5" id="v-pills-tabContent">
              <div class="tab-pane fade show active py-5" id="v-pills-master" role="tabpanel" aria-labelledby="v-pills-master-tab">
                <i class="icon mb-3 d-block fas fa-shower"></i>
                <h2 class="mb-4">Douche</h2>
                <?php
                if ($csDouche1 == 1){
                ?>
                <p>- Pensez à installer des pommeaux de douche munis du label ‘energy’, des réducteurs de débits et des stops-douches.</p>
                <?php
                }
                if ($csDouche2 == 1){
                ?>
                <p>- Il est préférable de couper l’eau lors du savonnage pour éviter une consommation excessive sous la douche.</p>
                <?php
                }
                if ($csDouche3 == 1){
                ?>
                <p>- Une douche optimale ne dépasse pas les 5 minutes. La consommation d’eau sera alors drastiquement réduite.</p>
                <?php
                }
                ?>
              </div>

              <div class="tab-pane fade py-5" id="v-pills-bath" role="tabpanel" aria-labelledby="v-pills-bath-tab">
                <i class="icon mb-3 d-block fas fa-bath"></i>
                <h2 class="mb-4">Bain</h2>
                <?php
                if ($csBain1 == 1){
                ?>
                <p>- Prendre un bain consomme plus du double d’eau qu’une douche. Préférez donc la douche au bain.</p>
                <?php
                }
                if ($csBain2 == 1){
                ?>
                <p>- Si vous prenez un bain, il n’est pas nécessaire de remplir complètement la baignoire. La moitié est suffisante.</p>
                <?php
                }
                ?>
               </div>

              <div class="tab-pane fade py-5" id="v-pills-dish" role="tabpanel" aria-labelledby="v-pills-dish-tab">
                <i class="icon mb-3 d-block fas fa-tooth"></i>
                <h2 class="mb-4">Dents</h2>
                <?php
                if ($csDent1 == 1){
                ?>
                <p>- Lors du brossage des dents, il est primordial de couper l’eau. La consommation peut passer de 2 litres d’eau à 36 litres pour un brossage de 3 minutes en laissant couler l’eau.</p>
                <?php
                }
                ?>
                 </div>

              <div class="tab-pane fade py-5" id="v-pills-clothes" role="tabpanel" aria-labelledby="v-pills-clothes-tab">
                <i class="icon mb-3 d-block fas fa-utensils"></i>
                <h2 class="mb-4">Vaisselle</h2>
                <?php
                if ($csVaisselle1 == 1){
                ?>
                <p>- En cas de lavage à la main, privilégiez l’utilisation d’un bac pour le rinçage afin de ne pas laisser couler l’eau.</p>
                <?php
                }
                if ($csVaisselle2 == 1){
                ?>
                <p>- Pour une quantité assez importante de vaisselle, l’utilisation d’un lave vaisselle consomme moins d’eau qu’un lavage à la main. Vous ferez donc des économies d’eau.</p>
                <?php
                }
                if ($csVaisselle3 == 1){
                ?>
                <p>- Préférez mettre en marche un lave-vaisselle lorsqu’il est plein. Si la vaisselle ne remplit pas la machine et qu’il y a peu de pièce, il est préférable de la laver à la main.</p>
                <?php
                }
                ?>
                </div>

              <div class="tab-pane fade py-5" id="v-pills-garden" role="tabpanel" aria-labelledby="v-pills-garden-tab">
                <i class="icon mb-3 d-block fab fa-500px"></i>
                <h2 class="mb-4">Machine à laver</h2>
                <?php
                if ($csMAL1 == 1){
                ?>
                <p>- Il est important de vérifier l’étiquette énergétique de votre lave-linge. Si la note indiquée est inférieure à A, considérez un </p>
                <?php
                }
                ?>
                </div>

              <div class="tab-pane fade py-5" id="v-pills-pagelines" role="tabpanel" aria-labelledby="v-pills-pagelines-tab">
                <i class="icon mb-3 d-block fas fa-check"></i>
                <h2 class="mb-4">Economiseur</h2>
                <?php
                if ($csEco1 == 1){
                ?>
                <p>- Les mitigeurs sont une solution simple et économique pour réduire efficacement la consommation d’eau de vos robinets sans modifier leur pression à la sortie.</p>
                <?php
                }
                if ($csEco2 == 1){
                ?>
                <p>- Si vous avez la place, installer un récupérateur d’eau de pluie limitera votre consommation d’eau notamment pour les tâches ne nécessitant pas d’eau potable.</p>
                <?php
                }
                if ($csEco3 == 1){
                ?>
                <p>- Les toilettes sont une des plus grandes sources de consommation d’eau au quotidien. Il est difficile de diminuer son utilisation, cependant les chasses d’eau économes sont un moyen efficace de diminuer cette consommation. La consommation d’eau peut être divisée par 2 voir 3.</p>
                <?php
                }
                ?>
                </div>

                <div class="tab-pane fade py-5" id="v-pills-drink" role="tabpanel" aria-labelledby="v-pills-drink-tab">
                <i class="icon mb-3 d-block fas fa-leaf"></i>
                <h2 class="mb-4">Plantes</h2>
                <?php
                if ($csPlante1 == 1){
                ?>
                <p>- Arroser le soir permet d’éviter les gaspillages dus à l'évaporation car il fait plus chaud en journée et c’est à ce moment là qu’a lieu l'évapotranspiration (rejet de vapeur par les plantes).</p>
                <?php
                }
                if ($csPlante2 == 1){
                ?>
                <p>- L’utilisation d’eau de pluie permet de ne plus consommer d’eau potable pour arroser ses plantes. Le plus simple pour stocker l’eau de plus est l’installation d’un récupérateur d’eau de pluie.</p>
                <?php
                }
                ?>
              </div>

              <div class="tab-pane fade py-5" id="v-pills-car" role="tabpanel" aria-labelledby="v-pills-drink-tab">
                <i class="icon mb-3 d-block fas fa-car"></i>
                <h2 class="mb-4">Voiture</h2>
                <?php
                if ($csVoiture1 == 1){
                ?>
                <p>- Un lavage au tuyau d’arrosage chez soi consomme beaucoup plus d’eau qu’un lavage automatique en station. Préférez alors cette option qui permet de consommer 10 fois moins d’eau.</p>
                <?php
                }
                ?>
                </div>


                <div class="tab-pane fade py-5" id="v-pills-swimmer" role="tabpanel" aria-labelledby="v-pills-drink-tab">
                <i class="icon mb-3 d-block fas fa-swimmer"></i>
                <h2 class="mb-4">Piscine</h2>
                <?php
                if ($csPiscine1 == 1){
                ?>
                <p>- Si vous avez une piscine, votre consommation d’eau annuelle est drastiquement augmenté. Cependant, pour limiter cela, pensez à bâcher la piscine pour limiter l’évaporation et changer seulement un quart du volume d’eau annuellement.</p>
                <?php
                }
                ?>
                </div>

                <div class="tab-pane fade py-5" id="v-pills-sticky-note" role="tabpanel" aria-labelledby="v-pills-drink-tab">
                <i class="icon mb-3 d-block fas fa-sticky-note"></i>
                <h2 class="mb-4">Etiquettes</h2>
                <?php
                if ($csEtiquette1 == 1){
                ?>
                <p>- Vérifier l’étiquetage énergétique sur vos appareils est un réflexe économique et écologique à avoir. Il vous informe sur la consommation énergétique (notamment la consommation d’eau) de vos appareils électriques afin de faciliter le choix entre différents modèles.</p>
                <?php
                }
                ?>
                </div>

                <div class="tab-pane fade py-5" id="v-pills-wine-bottle" role="tabpanel" aria-labelledby="v-pills-wine-bottle-tab">
                <i class="icon mb-3 d-block fas fa-wine-bottle"></i>
                <h2 class="mb-4">Bouteilles</h2>
                <?php
                if ($csBouteille1 == 1){
                ?>
                <p>- Boire de l’eau en bouteille est économiquement plus cher que boire de l’eau du robinet. L’eau en bouteille a aussi un impact écologique plus fort à cause de l’embouteillage plastique et de la logistique. Il existe en plus des solutions abordables pour filtrer l’eau du robinet afin de supprimer certaines particules comme le calcaire ou le plomb</p>
                <?php
                }
                ?>

                </div>
                <div class="tab-pane fade py-5" id="v-pills-file-alt" role="tabpanel" aria-labelledby="v-pills-file-alt-tab">
                <i class="icon mb-3 d-block fas fa-file-alt"></i>
                <h2 class="mb-4">Récap</h2>
                <p>
                <table>
                  <th>
                  </th>
                  <th>
                    consommation (en L/an)
                  </th>
                  <th>
                    consommation (en €/an)
                  </th>
                  <th>
                    économie possible (en L/an)
                  </th>
                  <th>
                    économie possible (en €/an)
                  </th>
                  <tr>
                    <td>
                    <!--consoDouche , consoBain , consoDents , consoVaisselle , consoMal , consoVoiture , consoPiscine-->
                    <b>Douche</b>
                    </td>
                    <td>
                    <?=$consoDouche?>
                    </td>
                    <td>
                    <?=$consoDouche * 0.003?>
                    </td>
                    <td>
                    <?=$ecoDouche?>
                    </td>
                    <td>
                    <?=$ecoDouche * 0.003?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                    <!--consoDouche , consoBain , consoDents , consoVaisselle , consoMal , consoVoiture , consoPiscine-->
                    <b>Bain</b>
                    </td>
                    <td>
                    <?=$consoBain?>
                    </td>
                    <td>
                    <?=$consoBain * 0.003?>
                    </td>
                    <td>
                    <?=$ecoBain?>
                    </td>
                    <td>
                    <?=$ecoBain * 0.003?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                    <!--consoDouche , consoBain , consoDents , consoVaisselle , consoMal , consoVoiture , consoPiscine-->
                    <b>Dents</b>
                    </td>
                    <td>
                    <?=$consoDents?>
                    </td>
                    <td>
                    <?=$consoDents * 0.003?>
                    </td>
                    <td>
                    <?=$ecoDents?>
                    </td>
                    <td>
                    <?=$ecoDents * 0.003?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                    <!--consoDouche , consoBain , consoDents , consoVaisselle , consoMal , consoVoiture , consoPiscine-->
                    <b>Vaisselle</b>
                    </td>
                    <td>
                    <?=$consoVaisselle?>
                    </td>
                    <td>
                    <?=$consoVaisselle * 0.003?>
                    </td>
                    <td>
                    <?=$ecoVaisselle?>
                    </td>
                    <td>
                    <?=$ecoVaisselle * 0.003?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                    <!--consoDouche , consoBain , consoDents , consoVaisselle , consoMal , consoVoiture , consoPiscine-->
                    <b>Machine à laver</b>
                    </td>
                    <td>
                    <?=$consoMal?>
                    </td>
                    <td>
                    <?=$consoMal * 0.003?>
                    </td>
                    <td>
                    <?=$ecoMal?>
                    </td>
                    <td>
                    <?=$ecoMal * 0.003?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                    <!--consoDouche , consoBain , consoDents , consoVaisselle , consoMal , consoVoiture , consoPiscine-->
                    <b>Voiture</b>
                    </td>
                    <td>
                    <?=$consoVoiture?>
                    </td>
                    <td>
                    <?=$consoVoiture * 0.003?>
                    </td>
                    <td>
                    <?=$ecoVoiture?>
                    </td>
                    <td>
                    <?=$ecoVoiture * 0.003?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                    <!--consoDouche , consoBain , consoDents , consoVaisselle , consoMal , consoVoiture , consoPiscine-->
                    <b>Piscine</b>
                    </td>
                    <td>
                    <?=$consoPiscine?>
                    </td>
                    <td>
                    <?=$consoPiscine * 0.003?>
                    </td>
                    <td>
                    <?=$ecoPiscine?>
                    </td>
                    <td>
                    <?=$ecoPiscine * 0.003?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                    <!--consoDouche , consoBain , consoDents , consoVaisselle , consoMal , consoVoiture , consoPiscine-->
                    <b>Total</b>
                    </td>
                    <td>
                    <?=$conso?>
                    </td>
                    <td>
                    <?=$conso * 0.003?>
                    </td>
                    <td>
                    <?=$eco?>
                    </td>
                    <td>
                    <?=$eco * 0.003?>
                    </td>
                  </tr>
                </table>
                </p>
                </div>

            </div>
          </div>
        </div>
      </div>
    </section>


    <section class="ftco-section ftco-counter img" id="section-counter" style="background-image: url(images/bg_4.jpg);">
    	<div class="container">
    		<div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
            <h2 class="mb-4">Votre consommation d'eau par an</h2>
            <span class="subheading"></span>
          </div>
        </div>
    		<div class="row justify-content-center">
    			<div class="col-md-10">
		    		<div class="row">
		          <div class="col-md-12 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		                <strong class="number total" data-number="<?=$conso*0.003?>"><?=$conso*0.003?></strong>
		                <span>Consommations en euros </span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-6 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		                <strong class="number" data-number="<?=$conso;?>"><?=$conso;?></strong>
		                <span>Consommations en litres</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-6 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		                <strong class="number" data-number="<?=$eco?>"><?=$eco?></strong>
		                <span>Economies possible en litres</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-12 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		                <strong class="number total" data-number="<?=$eco*0.003?>"><?=$eco*0.003?></strong>
		                <span>Economies possible en euros </span>
		              </div>
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
