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
$consoDouche = ($consoDouche * 52) ;
$consoBain = ($consoBain * 52) ;
$consoDents = ($consoDents * 365) ;
$consoVaisselle = ($consoVaisselle * 52) ;
$consoMal = ($consoMal * 12) ;
$consoVoiture = ($consoVoiture * 12) ;
$conso = $consoDouche + $consoBain + $consoDents + $consoVaisselle + $consoMal + $consoVoiture + $consoPiscine;

//eco
$ecoDouche = $consoDouche - (5*12*7*52);
$ecoBain = $consoBain;
$ecoDents = $consoDents - 4*365;
$ecoVaisselle = 0;
if($tmp["choixVaisselle"] == "main"){$ecoVaisselle = $consoVaisselle - 3650;}
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
            <h1 class="mb-3 bread">Les conseils person</h1>
          </div>
        </div>
      </div>
    </div>

  <section class="ftco-services category-advice">
      <div class="container">
        <div class="row no-gutters">
          <div class="col-md-4 ftco-animate py-5 nav-link-wrap">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <a class="nav-link px-4 active" id="v-pills-master-tab" data-toggle="pill" href="#v-pills-master" role="tab" aria-controls="v-pills-master" aria-selected="true"><i class="fas fa-shower"></i> Douche</a>

              <a class="nav-link px-4" id="v-pills-bath-tab" data-toggle="pill" href="#v-pills-bath" role="tab" aria-controls="v-pills-bath" aria-selected="false"><i class="fas fa-bath"></i>Bain</a>

              <a class="nav-link px-4" id="v-pills-dish-tab" data-toggle="pill" href="#v-pills-dish" role="tab" aria-controls="v-pills-dish" aria-selected="false"><i class="fas fa-tooth"></i> Dents</a>

              <a class="nav-link px-4" id="v-pills-clothes-tab" data-toggle="pill" href="#v-pills-clothes" role="tab" aria-controls="v-pills-clothes" aria-selected="false"><i class="fas fa-utensils"></i> Vaisselle</a>

              <a class="nav-link px-4" id="v-pills-garden-tab" data-toggle="pill" href="#v-pills-garden" role="tab" aria-controls="v-pills-garden" aria-selected="false"><i class="fab fa-500px"></i> Machine à laver</a>

              <a class="nav-link px-4" id="v-pills-pagelines-tab" data-toggle="pill" href="#v-pills-pagelines" role="tab" aria-controls="v-pills-pagelines" aria-selected="false"><i class="fas fa-check"></i> Economiseur</a>

              <a class="nav-link px-4" id="v-pills-drink-tab" data-toggle="pill" href="#v-pills-drink" role="tab" aria-controls="v-pills-drink" aria-selected="false"><i class="fas fa-leaf"></i> Plantes</a>
             
              <a class="nav-link px-4" id="v-pills-car-tab" data-toggle="pill" href="#v-pills-car" role="tab" aria-controls="v-pills-swimmer" aria-selected="false"><i class="fas fa-car"></i> Voiture</a>

              <a class="nav-link px-4" id="v-pills-swimmer-tab" data-toggle="pill" href="#v-pills-swimmer" role="tab" aria-controls="v-pills-swimmer" aria-selected="false"><i class="fas fa-swimmer"></i> Piscine</a>

              <a class="nav-link px-4" id="v-pills-sticky-note-tab" data-toggle="pill" href="#v-pills-sticky-note" role="tab" aria-controls="v-pills-sticky-note" aria-selected="false"><i class="fas fa-sticky-note"></i> Etiquettes</a>

              <a class="nav-link px-4" id="v-pills-wine-bottle-tab" data-toggle="pill" href="#v-pills-wine-bottle" role="tab" aria-controls="v-pills-wine-bottle" aria-selected="false"><i class="fas fa-wine-bottle"></i> Bouteilles</a>
            </div>
          </div>
          <div class="col-md-8 ftco-animate p-4 p-md-5 d-flex align-items-center">

            <div class="tab-content pl-md-5" id="v-pills-tabContent">

              <div class="tab-pane fade show active py-5" id="v-pills-master" role="tabpanel" aria-labelledby="v-pills-master-tab">
                <i class="icon mb-3 d-block fas fa-shower"></i>
                <h2 class="mb-4">Douche</h2>
                <p>Un bain consomme plus de 100 litres d’eau. Une douche est plus économique, sauf si on traîne un peu sous l'eau mais 10 minutes de douche peuvent consommer plus d’eau qu’un bain.
</p>
<p>On peut penser à :</p>
<ul>
  <li>Recycler l’eau de la douche</li>
  <li>Utiliser des pommeaux de douche munis du label 'energy' ( moins de 12 L par minute), des réducteurs de débits, stop-douche...</li>
</ul>
              </div>

              <div class="tab-pane fade py-5" id="v-pills-bath" role="tabpanel" aria-labelledby="v-pills-bath-tab">
                <i class="icon mb-3 d-block fas fa-bath"></i>
                <h2 class="mb-4">Bain</h2>
                <p>Il est préférable de se rincer avec un verre à dents (10 000 litres d'eau gaspillés par an) ou bien de couper son robinet en se brossant les dents fait également partie des écogestes basiques à mettre en place chez soi.
</p>
               </div>

              <div class="tab-pane fade py-5" id="v-pills-dish" role="tabpanel" aria-labelledby="v-pills-dish-tab">
                <i class="icon mb-3 d-block fas fa-tooth"></i>
                <h2 class="mb-4">Dents</h2>
                <p>Si on fait la vaisselle à la main, il est plus économe de remplir les deux bacs de l’évier (laisser couler l'eau consomme jusqu'à 200 litres par vaisselle).
</p>
<p>Pour une quantité assez importante de vaisselle, l’utilisation d’un lave vaisselle consomme donc en général moins d’eau qu’un lavage à la main. Si la vaisselle ne remplit pas la machine, il est préférable de la laver à la main.
</p>
<p>Si vous optez pour un lave-vaisselle, regardez bien les étiquettes énergétiques qui indiquent la consommation d’eau et achetez des appareils supérieur à la classe A.</p>
                 </div>

              <div class="tab-pane fade py-5" id="v-pills-clothes" role="tabpanel" aria-labelledby="v-pills-clothes-tab">
                <i class="icon mb-3 d-block fas fa-utensils"></i>
                <h2 class="mb-4">Vaisselle</h2>
                <p>Sur les machines qui ne disposent pas la technologie de la reconnaissance du poids du linge, veillez à remplir suffisamment de linge avant de lancer le cycle. Profitez également de la fonction cycle court, ou demi-charge, si votre lave-linge le permet.</p>
                </div>

              <div class="tab-pane fade py-5" id="v-pills-garden" role="tabpanel" aria-labelledby="v-pills-garden-tab">
                <i class="icon mb-3 d-block fab fa-500px"></i>
                <h2 class="mb-4">Machine à laver</h2>
                <ul>
  <li>Remplacer le tuyau d'arrosage par un arrosoir ;
</li>
  <li>Arroser moins souvent mais plus longtemps pour que la terre s'humidifie en profondeur. L'arrosage rotatif par jets alternatifs permet un arrosage « doux » sur une longue période.
</li>
<li>Veiller à ce que le sol soit assez meuble et travaillé. Cela permet un arrosage plus efficace. En effet, l'eau ruisselle sur un sol tassé ;
</li>
<li>Au potager ou dans les plates-bandes, recouvrir le sol entre les plantes de paille, tontes de pelouse, feuilles, etc. favorise la rétention de l'eau ;
</li>
<li>Arroser le soir, pour éviter les gaspillages dus à l'évaporation (il fait plus chaud en journée) et l'évapotranspiration (rejet de vapeur par les plantes).
</li>
</ul>
                </div>

              <div class="tab-pane fade py-5" id="v-pills-pagelines" role="tabpanel" aria-labelledby="v-pills-pagelines-tab">
                <i class="icon mb-3 d-block fas fa-check"></i>
                <h2 class="mb-4">Economiseur</h2>
                <p>Laver la voiture en station et non chez-soi. En plus d’être souillée par les graisses et hydrocarbures, l’eau utilisée est de 3 fois supérieur à celle utilisée dans une station de nettoyage haute pression.</p>
                </div>

                <div class="tab-pane fade py-5" id="v-pills-drink" role="tabpanel" aria-labelledby="v-pills-drink-tab">
                <i class="icon mb-3 d-block fas fa-leaf"></i>
                <h2 class="mb-4">Plantes</h2>
                <p>Selon 
                <a target="_blank" style ="text-decoration: underline;" href="https://www.quechoisir.org/guide-d-achat-quelle-eau-boire-n4855/">UFC-Que Choisir</a>, si vous habitez dans les moyennes et grandes villes, il vaut mieux privilégier l’eau du robinet, plus écologique et moins chère que celle en bouteille[19]. La qualité de l’eau potable de sa commune peut être vérifier grâce à la carte du ministère des Solidarités et de la Santé en cliquant sur ce <a target="_blank" style ="text-decoration: underline;" href="https://solidarites-sante.gouv.fr/sante-et-environnement/eaux/article/qualite-de-l-eau-potable">lien.</a></p>
                <p>
                <a target="_blank" style ="text-decoration: underline;" href="https://www.linfodurable.fr/conso/eau-en-bouteille-eau-du-robinet-laquelle-choisir-2834
">L’UFC-Que Choisir</a> recommande aux personnes souhaitant tout de même en utiliser de remplacer régulièrement la cartouche, de conserver la carafe filtrante et son eau en réfrigérateur et de consommer l’eau filtrée rapidement, idéalement dans les 24 heures après filtration.</p>
              </div>

              <div class="tab-pane fade py-5" id="v-pills-car" role="tabpanel" aria-labelledby="v-pills-drink-tab">
                <i class="icon mb-3 d-block fas fa-car"></i>
                <h2 class="mb-4">Voiture</h2>
                <ul>
                <li>
                Bâcher la piscine pour limiter l’évaporation.</li>
                <li>Changer ¼ du volume d’eau annuellement. Pour plus d'informations, <a target="_blank" style ="text-decoration: underline;" href="https://www.sa-piscine.com/cout-annuel-eau">cliquez ici.</a></li>
                </ul>
                </div>

                
                <div class="tab-pane fade py-5" id="v-pills-swimmer" role="tabpanel" aria-labelledby="v-pills-drink-tab">
                <i class="icon mb-3 d-block fas fa-swimmer"></i>
                <h2 class="mb-4">Piscine</h2>
                <ul>
                <li>
                Bâcher la piscine pour limiter l’évaporation.</li>
                <li>Changer ¼ du volume d’eau annuellement. Pour plus d'informations, <a target="_blank" style ="text-decoration: underline;" href="https://www.sa-piscine.com/cout-annuel-eau">cliquez ici.</a></li>
                </ul>
                </div>
                <div class="tab-pane fade py-5" id="v-pills-sticky-note" role="tabpanel" aria-labelledby="v-pills-drink-tab">
                <i class="icon mb-3 d-block fas fa-sticky-note"></i>
                <h2 class="mb-4">Etiquettes</h2>
                <ul>
                <li>
                Bâcher la piscine pour limiter l’évaporation.</li>
                <li>Changer ¼ du volume d’eau annuellement. Pour plus d'informations, <a target="_blank" style ="text-decoration: underline;" href="https://www.sa-piscine.com/cout-annuel-eau">cliquez ici.</a></li>
                </ul>
                </div>

                <div class="tab-pane fade py-5" id="v-pills-wine-bottle" role="tabpanel" aria-labelledby="v-pills-wine-bottle-tab">
                <i class="icon mb-3 d-block fas fa-wine-bottle"></i>
                <h2 class="mb-4">Bouteilles</h2>
                <ul>
                <li>
                Bâcher la piscine pour limiter l’évaporation.</li>
                <li>Changer ¼ du volume d’eau annuellement. Pour plus d'informations, <a target="_blank" style ="text-decoration: underline;" href="https://www.sa-piscine.com/cout-annuel-eau">cliquez ici.</a></li>
                </ul>
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
            <h2 class="mb-4">Quelques chiffres sur</h2>
            <span class="subheading">La consommation d'eau en France sont ..</span>
          </div>
        </div>
    		<div class="row justify-content-center">
    			<div class="col-md-10">
		    		<div class="row">
		          <div class="col-md-6 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		                <strong class="number" data-number="150">150</strong>
		                <span>Consommations en litres</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-6 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		                <strong class="number" data-number="20">0</strong>
		                <span>Economies possible en litres</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-12 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		                <strong class="number total" data-number="175">0</strong>
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
