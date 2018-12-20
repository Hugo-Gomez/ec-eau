<?php
require_once('connection.php');
$the_sql="SELECT
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
;";
$the_stmt = $conn->prepare($the_sql);
$the_stmt->execute();
errorHandler($the_stmt);
$the_res=null;
while(false !== $the_row = $the_stmt->fetch(PDO::FETCH_ASSOC)){
$the_res[]=$the_row;
}


$the_conso = [];
$the_consoDouche = [];
$the_consoBain = [];
$the_consoDents = [];
$the_consoVaisselle = [];
$the_consoMal = [];
$the_consoVoiture = [];
$the_consoPiscine = [];

$the_eco = [];
$the_ecoDouche = [];
$the_ecoBain = [];
$the_ecoDents = [];
$the_ecoVaisselle = [];
$the_ecoMal = [];
$the_ecoVoiture = [];
$the_ecoPiscine = [];


foreach($the_res as $the_tmp){
    
    // -----conso-----
    //douche
    $the_debitDouche = 0;
    if($the_tmp["debitDouche"] == "faible"){$the_debitDouche = 12 ;}
    elseif($the_tmp["debitDouche"] == "moyen"){$the_debitDouche = 15 ;}
    elseif($the_tmp["debitDouche"] == "fort"){$the_debitDouche = 20 ;}
    $the_consoDouche = $the_tmp["tempsDouche"] * $the_debitDouche * $the_tmp["freqDouche"];//par semaine
    //bain
    $the_rempBain = 0;
    if($the_tmp["rempBain"] == "oui"){$the_rempBain = 200 ;}
    elseif($the_tmp["rempBain"] == "non"){$the_rempBain = 120 ;}
    $the_consoBain = $the_tmp["freqBain"] * $the_rempBain; //par semaine
    //dents
    $the_eauDents = 0;
    if($the_tmp["eauDents"] == "oui"){$the_eauDents = 2 ;}
    elseif($the_tmp["eauDents"] == "parfois"){$the_eauDents = 19 ;}
    elseif($the_tmp["eauDents"] == "non"){$the_eauDents = 36 ;}
    $the_consoDents = $the_tmp["freqDents"] * $the_eauDents;//par jour
    //vaisselle
    $the_consoVaisselle = 0;
    if($the_tmp["choixVaisselle"] == "main"){
    if($the_tmp["methVaisselle"] == "non"){
        $the_consoVaisselle = $the_tmp["freqVaisselle"] * 10;//par semaines
    }else{
        $the_consoVaisselle = $the_tmp["freqVaisselle"] * $the_tmp["couvVaisselle"] * 0.5;//par semaines
    }
    }else{
    $the_consoVaisselle = $the_tmp["freqVaisselle"] * 12;//par semaines
    }
    //MAL
    $the_consoMal = 0;
    if($the_tmp["dateMal"] == "ancien"){
    $the_consoMal = $the_tmp["freqMal"] * 100;//par mois
    }else{
    $the_consoMal = $the_tmp["freqMal"] * 50;//par mois
    }
    //voiture
    $the_consoVoiture = 0;
    if($the_tmp["methVoiture"] == "manuel"){
    $the_consoVoiture = $the_tmp["freqVoiture"] * 200;//par mois
    }else{
    $the_consoVoiture = $the_tmp["freqVoiture"] * 60;//par mois
    }
    //piscine
    $the_consoPiscine = 0;
    if($the_tmp["piscine"] = "oui"){
    if($the_tmp["freqPiscine"] = "oui"){
        $the_consoPiscine = $the_tmp["volumePiscine"] * 1000;//par an
    }else{
        $the_consoPiscine = $the_tmp["volumePiscine"] * 250;//par an
    }
    }
    //conso
    $the_consoDouche = ($the_consoDouche * 52) ;
    $the_consoBain = ($the_consoBain * 52) ;
    $the_consoDents = ($the_consoDents * 365) ;
    $the_consoVaisselle = ($the_consoVaisselle * 52) ;
    $the_consoMal = ($the_consoMal * 12) ;
    $the_consoVoiture = ($the_consoVoiture * 12) ;
    $the_conso = $the_consoDouche + $the_consoBain + $the_consoDents + $the_consoVaisselle + $the_consoMal + $the_consoVoiture + $the_consoPiscine;
    //eco
    $the_ecoDouche = $the_consoDouche - (5*12*$the_tmp["freqDouche"]*52);
    $the_ecoBain = $the_consoBain;
    $the_ecoDents = $the_consoDents - 4*365;
    $the_ecoVaisselle = 0;
    if($the_tmp["choixVaisselle"] == "main"){$the_ecoVaisselle = $the_consoVaisselle - 3650;}
    if($the_ecoVaisselle<0){$the_ecoVaisselle = 0;}
    $the_ecoMal = $the_consoMal - ($the_tmp["freqMal"] * 50)*12;
    $the_ecoVoiture = 0;
    if($the_tmp["voiture"] == "oui"){$the_ecoVoiture = $the_consoVoiture - (60 * 12);}
    $the_ecoPiscine = 0;
    if($the_tmp["piscine"] == "oui"){$the_ecoPiscine = $the_consoPiscine - $the_tmp["volumePiscine"] * 250;}
    $the_eco = $the_ecoDouche + $the_ecoBain + $the_ecoDents + $the_ecoVaisselle + $the_ecoMal + $the_ecoVoiture + $the_ecoPiscine;

    $the_consoGen[] = $the_conso;
    $the_consoDoucheGen[] = $the_consoDouche;
    $the_consoBainGen[] = $the_consoBain;
    $the_consoDentsGen[] = $the_consoDents;
    $the_consoVaisselleGen[] = $the_consoVaisselle;
    $the_consoMalGen[] = $the_consoMal;
    $the_consoVoitureGen[] = $the_consoVoiture;
    $the_consoPiscineGen[] = $the_consoPiscine;

    $the_ecoGen[] = $the_eco;
    $the_ecoDoucheGen[] = $the_ecoDouche;
    $the_ecoBainGen[] = $the_ecoBain;
    $the_ecoDentsGen[] = $the_ecoDents;
    $the_ecoVaisselleGen[] = $the_ecoVaisselle;
    $the_ecoMalGen[] = $the_ecoMal;
    $the_ecoVoitureGen[] = $the_ecoVoiture;
    $the_ecoPiscineGen[] = $the_ecoPiscine;
}
$the_consoGenMean = array_sum($the_consoGen)/count($the_consoGen);
$the_consoDoucheGenMean = array_sum($the_consoDoucheGen)/count($the_consoDoucheGen);
$the_consoBainGenMean = array_sum($the_consoBainGen)/count($the_consoBainGen);
$the_consoDentsGenMean = array_sum($the_consoDentsGen)/count($the_consoDentsGen);
$the_consoVaisselleGenMean = array_sum($the_consoVaisselleGen)/count($the_consoVaisselleGen);
$the_consoMalGenMean = array_sum($the_consoMalGen)/count($the_consoMalGen);
$the_consoVoitureGenMean = array_sum($the_consoVoitureGen)/count($the_consoVoitureGen);
$the_consoPiscineGenMean = array_sum($the_consoPiscineGen)/count($the_consoPiscineGen);

$the_ecoGenMean = array_sum($the_ecoGen)/count($the_ecoGen);
$the_ecoDoucheGenMean = array_sum($the_ecoDoucheGen)/count($the_ecoDoucheGen);
$the_ecoBainGenMean = array_sum($the_ecoBainGen)/count($the_ecoBainGen);
$the_ecoDentsGenMean = array_sum($the_ecoDentsGen)/count($the_ecoDentsGen);
$the_ecoVaisselleGenMean = array_sum($the_ecoVaisselleGen)/count($the_ecoVaisselleGen);
$the_ecoMalGenMean = array_sum($the_ecoMalGen)/count($the_ecoMalGen);
$the_ecoVoitureGenMean = array_sum($the_ecoVoitureGen)/count($the_ecoVoitureGen);
$the_ecoPiscineGenMean = array_sum($the_ecoPiscineGen)/count($the_ecoPiscineGen);

echo PHP_EOL;
echo "consoGenMean : " . round($the_consoGenMean,2) ;
echo PHP_EOL;
echo "consoDoucheGenMean : " . round($the_consoDoucheGenMean,2) ;
echo PHP_EOL;
echo "consoBainGenMean : " . round($the_consoBainGenMean,2) ;
echo PHP_EOL;
echo "consoDentsGenMean : " . round($the_consoDentsGenMean,2) ;
echo PHP_EOL;
echo "consoVaisselleGenMean : " . round($the_consoVaisselleGenMean,2) ;
echo PHP_EOL;
echo "consoMalGenMean : " . round($the_consoMalGenMean,2) ;
echo PHP_EOL;
echo "consoVoitureGenMean : " . round($the_consoVoitureGenMean,2) ;
echo PHP_EOL;
echo "consoPiscineGenMean : " . round($the_consoPiscineGenMean,2) ;
echo PHP_EOL;
echo "ecoGenMean : " . round($the_ecoGenMean,2) ;
echo PHP_EOL;
echo "ecoDoucheGenMean : " . round($the_ecoDoucheGenMean,2) ;
echo PHP_EOL;
echo "ecoBainGenMean : " . round($the_ecoBainGenMean,2) ;
echo PHP_EOL;
echo "ecoDentsGenMean : " . round($the_ecoDentsGenMean,2) ;
echo PHP_EOL;
echo "ecoVaisselleGenMean : " . round($the_ecoVaisselleGenMean,2) ;
echo PHP_EOL;
echo "ecoMalGenMean : " . round($the_ecoMalGenMean,2) ;
echo PHP_EOL;
echo "ecoVoitureGenMean : " . round($the_ecoVoitureGenMean,2) ;
echo PHP_EOL;
echo "ecoPiscineGenMean : " . round($the_ecoPiscineGenMean,2) ;
echo PHP_EOL;
echo PHP_EOL;
echo PHP_EOL;
echo PHP_EOL;
echo "consoGenMean : " . round($the_consoGenMean * 0.003,2) . " €";
echo PHP_EOL;
echo "consoDoucheGenMean : " . round($the_consoDoucheGenMean * 0.003,2) . " €";
echo PHP_EOL;
echo "consoBainGenMean : " . round($the_consoBainGenMean * 0.003,2) . " €";
echo PHP_EOL;
echo "consoDentsGenMean : " . round($the_consoDentsGenMean * 0.003,2) . " €";
echo PHP_EOL;
echo "consoVaisselleGenMean : " . round($the_consoVaisselleGenMean * 0.003,2) . " €";
echo PHP_EOL;
echo "consoMalGenMean : " . round($the_consoMalGenMean * 0.003,2) . " €";
echo PHP_EOL;
echo "consoVoitureGenMean : " . round($the_consoVoitureGenMean * 0.003,2) . " €";
echo PHP_EOL;
echo "consoPiscineGenMean : " . round($the_consoPiscineGenMean * 0.003,2) . " €";
echo PHP_EOL;
echo "ecoGenMean : " . round($the_ecoGenMean * 0.003,2) . " €";
echo PHP_EOL;
echo "ecoDoucheGenMean : " . round($the_ecoDoucheGenMean * 0.003,2) . " €";
echo PHP_EOL;
echo "ecoBainGenMean : " . round($the_ecoBainGenMean * 0.003,2) . " €";
echo PHP_EOL;
echo "ecoDentsGenMean : " . round($the_ecoDentsGenMean * 0.003,2) . " €";
echo PHP_EOL;
echo "ecoVaisselleGenMean : " . round($the_ecoVaisselleGenMean * 0.003,2) . " €";
echo PHP_EOL;
echo "ecoMalGenMean : " . round($the_ecoMalGenMean * 0.003,2) . " €";
echo PHP_EOL;
echo "ecoVoitureGenMean : " . round($the_ecoVoitureGenMean * 0.003,2) . " €";
echo PHP_EOL;
echo "ecoPiscineGenMean : " . round($the_ecoPiscineGenMean * 0.003,2) . " €";
?>