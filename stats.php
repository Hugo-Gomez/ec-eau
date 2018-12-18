<?php
require_once 'functions/connection.php';
require_once 'functions/getResult.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include "header.php" ?>
  </head>
  <body>
<?php
$res = getResult($conn);
$height = count($res);

//douche
$dMoyen = 0;
$dFaible = 0;
$dFort = 0;
foreach ($res as $row) {
  if($row["debitDouche"] == "moyen"){$dMoyen ++;}
  if($row["debitDouche"] == "faible"){$dFaible ++;}
  if($row["debitDouche"] == "fort"){$dFort ++;}
}
$pctDMoyen = ($dMoyen / $height) * 100;
$pctDFaible = ($dFaible/ $height) * 100;
$pctDFort = ($dFort / $height) * 100;
//echo "<!-- douche :".$dFaible." ".$dMoyen." ".$dFort."-->";
//echo "<!-- douche pct :".$pctDFaible." ".$pctDMoyen." ".$pctDFort."-->";

//bain
$bainOui = 0;
$bainNon = 0;
foreach ($res as $row) {
  if($row["freqBain"] != 0){$bainOui ++;}
  if($row["freqBain"] == 0){$bainNon ++;}
}
$pctBainOui = ($bainOui / $height) * 100;
$pctBainNon = ($bainNon / $height) * 100;
//echo "<!-- bain :".$bainNon." ".$bainOui."-->";
//echo "<!-- bain pct :".$pctBainNon." ".$pctBainOui."-->";

//vaisselle
$vMain = 0;
$vLave = 0;
foreach ($res as $row) {
  if($row["choixVaisselle"] == "main"){$vMain ++;}
  if($row["choixVaisselle"] == "lave-vaisselle"){$vLave ++;}
}
$pctVMain = ($vMain / $height) * 100;
$pctVLave = ($vLave / $height) * 100;
//echo "<!-- vaisselle :".$vMain." ".$vLave."-->";
//echo "<!-- vaisselle pct :".$pctVMain." ".$pctVLave."-->";

//machine a laver
$MAL0_5 = 0;
$MAL1_10 = 0;
$MAL10_15 = 0;
$MAL15_20 = 0;
$MAL20_25 = 0;
$MAL25_plus = 0;
foreach ($res as $row) {
  if($row["freqMal"] >= 0 && $row["freqMal"] < 5){$MAL0_5 ++;}
  if($row["freqMal"] >= 5 && $row["freqMal"] < 10){$MAL1_10 ++;}
  if($row["freqMal"] >= 10 && $row["freqMal"] < 15){$MAL10_15 ++;}
  if($row["freqMal"] >= 15 && $row["freqMal"] < 20){$MAL15_20 ++;}
  if($row["freqMal"] >= 20 && $row["freqMal"] < 25){$MAL20_25 ++;}
  if($row["freqMal"] >= 25 ){$MAL25_plus ++;}
}
//echo "<!-- MAL :".$MAL0_5." ".$MAL1_10." ".$MAL10_15." ".$MAL15_20." ".$MAL20_25." ".$MAL25_plus."-->";

//plante
$pRobinet = 0;
$pPluie = 0;
$pHeight = 0;
foreach ($res as $row) {
  if($row["plante"] == "oui"){
    $pHeight ++;
    if($row["eauPlante"] == "robinet"){$pRobinet ++;}
    if($row["eauPlante"] == "pluie"){$pPluie ++;}
  }
}
$pctPRobinet = ($pRobinet / $pHeight) * 100;
$pctPPluie = ($pPluie / $pHeight) * 100;
//echo "<!-- Plante :".$pRobinet." ".$pPluie."-->";
//echo "<!-- Plante pct :".$pctPRobinet." ".$pctPPluie."-->";

//piscine
$piOui = 0;  
$piNon = 0;
$piHeight = 0;
foreach ($res as $row) {
  if($row["piscine"] == "oui"){
    $piHeight ++;
    if($row["freqPiscine"] == "oui"){$piOui ++;}
    if($row["freqPiscine"] == "non"){$piNon ++;}
  }
}
$pctPiOui = ($piOui / $piHeight) * 100;
$pctPiNon = ($piNon / $piHeight) * 100;
//echo "<!-- Piscine :".$piOui." ".$piNon."-->";
//echo "<!-- Piscine pct :".$pctPiOui." ".$pctPiNon."-->";

//etiquette
$etOui = 0;  
$etNon = 0;
foreach ($res as $row) {
  if($row["etiquette"] == "oui"){$etOui ++;}
  if($row["etiquette"] == "non"){$etNon ++;}
}
$pctEtOui = ($etOui / $height) * 100;
$pctEtNon = ($etNon / $height) * 100;
//echo "<!-- Ettiquette :".$etOui." ".$etNon."-->";
//echo "<!-- Ettiquette pct :".$pctEtOui." ".$pctEtNon."-->";


//bouteille
$boOui = 0;  
$boNon = 0;
foreach ($res as $row) {
  if($row["bouteille"] == "bouteille"){$boOui ++;}
  if($row["bouteille"] == "robinet"){$boNon ++;}
}
$pctBoOui = ($boOui / $height) * 100;
$pctBoNon = ($boNon / $height) * 100;
//echo "<!-- Bouteille :".$boOui." ".$boNon."-->";
//echo "<!-- Bouteille pct :".$pctBoOui." ".$pctBoNon."-->";





//tab

$douche = [$dFaible,$dMoyen,$dFort];
$pctDouche = [$pctDFaible,$pctDMoyen,$pctDFort];

$bain = [$bainNon,$bainOui];
$pctBain = [$pctBainNon,$pctBainOui];

$vaisselle = [$vMain,$vLave];
$pctVaisselle = [$pctVMain,$pctVLave];

$MAL = [$MAL0_5,$MAL1_10,$MAL10_15,$MAL15_20,$MAL20_25,$MAL25_plus];

$plante = [$pRobinet,$pPluie];
$pctPlante = [$pctPRobinet,$pctPPluie];

$piscine = [$piOui,$piNon];
$pctPiscine = [$pctPiOui,$pctPiNon];

$etiquette = [$etOui,$etNon];
$pctEtiquette = [$pctEtOui,$pctEtNon];

$bouteille = [$boOui,$boNon];
$pctBouteille = [$pctBoOui,$pctBoNon];

?>
  <?php include "topbar.php" ?>

  <div class="hero-wrap" style="background-image: url('images/stats-wp.jpg'); background-attachment:fixed;">
    <div class="overlay"></div>
    <div class="container">
      <div class="row no-gutters slider-text align-items-center justify-content-center" data-scrollax-parent="true">
        <div class="col-md-10 ftco-animate text-center">
          <h1 class="mb-4">La consommation d'eau</h1>
          <p>Les résultats d'ensemble de notre test.</p>
        </div>
      </div>
    </div>
  </div>

  <section class="presentation-section">
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="col-md-10 text-center heading-section heading-section-white ftco-animate">
          <h2 class="title">Nos chiffres se basent sur vous</h2>
          <p class="description">
            Nous aurions put mettre des centaines de graphiques venant de centaines d'études... Mais
            ce qui nous intéresse le plus, c'est vous. Alors voici les résultats de nos test sur la
            globalité des usagers l'ayant réalisé.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Chiffres brut -->
  <section class="ftco-section ftco-counter img" id="section-counter" style="background-image: url(images/bg_4.jpg);">
    <div class="container">
      <div class="row justify-content-center mb-5 pb-3">
        <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
          <h2 class="mb-4">Premier aperçu</h2>
          <span class="subheading">Selon notre test..</span>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="row">
            <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
              <div class="block-18 text-center">
                <div class="text">
                  <strong class="number" data-number="60">0</strong><strong class="white-text">%</strong>
                  <span>des Français ont un lave vaiselle</span>
                </div>
              </div>
            </div>
            <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
              <div class="block-18 text-center">
                <div class="text">
                  <strong class="number" data-number="7">0</strong>
                  <span>douches par semaines en moyenne pour une personne</span>
                </div>
              </div>
            </div>
            <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
              <div class="block-18 text-center">
                <div class="text">
                  <strong class="number" data-number="5">0</strong><strong class="white-text">%</strong>
                  <span>des Français ont une piscine chez eux</span>
                </div>
              </div>
            </div>
            <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
              <div class="block-18 text-center">
                <div class="text">
                  <strong class="number" data-number="2">0</strong>
                  <span>lavage de voiture par mois en moyenne pour une personne véhiculée</span>
                </div>
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
        <div class="col-md-10 text-center heading-section heading-section-white ftco-animate">
          <h2 class="title">Douche</h2>
          <p class="description">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
            exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
            dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
            anim id est laborum.
          </p>
        </div>
        <div class="col-md-10">
          <canvas id="showerChart" width="400" height="150"></canvas>
        </div>
      </div>
    </div>
  </section>

  <section class="ftco-section-parallax test-section">
    <div class="parallax-img d-flex align-items-center">
      <div class="container">
        <div class="row d-flex justify-content-center">
          <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
            <h2>Bains</h2>
            <p class="description">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
              incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
              exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
              dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
              Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
              anim id est laborum.
            </p>
          </div>
          <div class="col-md-10">
            <canvas class="white-plot" id="bathChart" width="400" height="150"></canvas>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="presentation-section">
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="col-md-10 text-center heading-section heading-section-white ftco-animate">
          <h2 class="title">Lavage de dents</h2>
          <p class="description">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
            exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
            dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
            anim id est laborum.
          </p>
        </div>
        <div class="col-md-10">
          <canvas id="teethChart" width="400" height="150"></canvas>
        </div>
      </div>
    </div>
  </section>

  <section class="ftco-section-parallax test-section">
    <div class="parallax-img d-flex align-items-center">
      <div class="container">
        <div class="row d-flex justify-content-center">
          <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
            <h2>Vaiselle</h2>
            <p class="description">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
              incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
              exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
              dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
              Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
              anim id est laborum.
            </p>
          </div>
          <div class="col-md-10">
            <canvas class="white-plot" id="dishChart" width="400" height="150"></canvas>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="presentation-section">
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="col-md-10 text-center heading-section heading-section-white ftco-animate">
          <h2 class="title">Lave-linge</h2>
          <p class="description">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
            exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
            dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
            anim id est laborum.
          </p>
        </div>
        <div class="col-md-10">
          <canvas id="washingChart" width="400" height="150"></canvas>
        </div>
      </div>
    </div>
  </section>

  <section class="ftco-section-parallax test-section">
    <div class="parallax-img d-flex align-items-center">
      <div class="container">
        <div class="row d-flex justify-content-center">
          <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
            <h2>Jardin</h2>
            <p class="description">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
              incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
              exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
              dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
              Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
              anim id est laborum.
            </p>
          </div>
          <div class="col-md-10">
            <canvas class="white-plot" id="gardenChart" width="400" height="150"></canvas>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="presentation-section">
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="col-md-10 text-center heading-section heading-section-white ftco-animate">
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
        <div class="col-md-10">
          <canvas id="carChart" width="400" height="150"></canvas>
        </div>
      </div>
    </div>
  </section>

  <section class="ftco-section-parallax test-section">
    <div class="parallax-img d-flex align-items-center">
      <div class="container">
        <div class="row d-flex justify-content-center">
          <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
            <h2>Piscine</h2>
            <p class="description">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
              incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
              exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
              dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
              Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
              anim id est laborum.
            </p>
          </div>
          <div class="col-md-10">
            <canvas class="white-plot" id="poolChart" width="400" height="150"></canvas>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="presentation-section">
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="col-md-10 text-center heading-section heading-section-white ftco-animate">
          <h2 class="title">Étiquettes énergétiques</h2>
          <p class="description">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
            exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
            dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
            anim id est laborum.
          </p>
        </div>
        <div class="col-md-10">
          <canvas id="stickerChart" width="400" height="150"></canvas>
        </div>
      </div>
    </div>
  </section>

  <section class="ftco-section-parallax test-section">
    <div class="parallax-img d-flex align-items-center">
      <div class="container">
        <div class="row d-flex justify-content-center">
          <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
            <h2>Eau en bouteille</h2>
            <p class="description">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
              incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
              exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
              dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
              Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
              anim id est laborum.
            </p>
          </div>
          <div class="col-md-10">
            <canvas class="white-plot" id="bottleChart" width="400" height="150"></canvas>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include "footer.php" ?>

  <?php include "js-import.php" ?>

  <script type="text/javascript">
    // Line Chart
    var showerCtx = document.getElementById('showerChart').getContext('2d');
    var showerChart = new Chart(showerCtx, {
      // The type of chart we want to create
      type: 'line',

      // The data for our dataset
      data: {
          // X
          labels: ["January", "February", "March", "April", "May", "June", "July"],
          datasets: [{
              label: "My First dataset",
              backgroundColor: '#2288e4',
              borderColor: '#2288e4',
              data: [0, 10, 5, 2, 20, 30, 45],
          }]
      }
    });

    // Bar Chart
    var bathCtx = document.getElementById('bathChart').getContext('2d');
    var bathChart = new Chart(bathCtx, {
      // The type of chart we want to create
      type: 'bar',

      // The data for our dataset
      data: {
          // X
          labels: ["January", "February", "March", "April", "May", "June", "July"],
          datasets: [{
              label: "My First dataset",
              backgroundColor: 'orange',
              borderColor: 'orange',
              data: [5, 10, 5, 2, 20, 30, 45],
          }]
      }
    });

    // Doughnut Chart
    var teethCtx = document.getElementById('teethChart').getContext('2d');
    var teethChart = new Chart(teethCtx, {
      // The type of chart we want to create
      type: 'doughnut',

      // The data for our dataset
      data: {
          // X
          labels: ["January", "February", "March", "April", "May", "June", "July"],
          datasets: [{
              label: "My First dataset",
              backgroundColor: ["#18a084", "#34495d", "#e74c3c", "#40d47e", "#9b59b6", "#2288e4", "orange"],
              borderColor: ["#18a084", "#34495d", "#e74c3c", "#40d47e", "#9b59b6", "#2288e4", "orange"],
              data: [5, 10, 5, 2, 20, 30, 45],
          }]
      }
    });

    // Multi Chart
    var dishCtx = document.getElementById('dishChart').getContext('2d');
    var dishChart = new Chart(dishCtx, {
      // The type of chart we want to create
      type: 'bar',

      // The data for our dataset
      data: {
          datasets: [{
              label: "My First dataset",
              backgroundColor: "orange",
              borderColor: "orange",
              data: [5, 10, 5, 2, 20, 30, 45],
          }, {
            label: "My Second dataset",
            backgroundColor: "#2288e4",
            borderColor: "#2288e4",
            data: [10, 20, 15, 2, 22, 13, 14],
          }],
          // X
          labels: ["January", "February", "March", "April", "May", "June", "July"]
      }
    });

    // Bar Chart
    var washingCtx = document.getElementById('washingChart').getContext('2d');
    var washingChart = new Chart(washingCtx, {
      // The type of chart we want to create
      type: 'bar',

      // The data for our dataset
      data: {
          // X
          labels: ["January", "February", "March", "April", "May", "June", "July"],
          datasets: [{
              label: "My First dataset",
              backgroundColor: 'orange',
              borderColor: 'orange',
              data: [5, 10, 5, 2, 20, 30, 45],
          }]
      }
    });

    // Bar Chart
    var gardenCtx = document.getElementById('gardenChart').getContext('2d');
    var gardenChart = new Chart(gardenCtx, {
      // The type of chart we want to create
      type: 'bar',

      // The data for our dataset
      data: {
          // X
          labels: ["January", "February", "March", "April", "May", "June", "July"],
          datasets: [{
              label: "My First dataset",
              backgroundColor: 'orange',
              borderColor: 'orange',
              data: [5, 10, 5, 2, 20, 30, 45],
          }]
      }
    });

    // Bar Chart
    var carCtx = document.getElementById('carChart').getContext('2d');
    var carChart = new Chart(carCtx, {
      // The type of chart we want to create
      type: 'bar',

      // The data for our dataset
      data: {
          // X
          labels: ["January", "February", "March", "April", "May", "June", "July"],
          datasets: [{
              label: "My First dataset",
              backgroundColor: 'orange',
              borderColor: 'orange',
              data: [5, 10, 5, 2, 20, 30, 45],
          }]
      }
    });

    // Bar Chart
    var poolCtx = document.getElementById('poolChart').getContext('2d');
    var poolChart = new Chart(poolCtx, {
      // The type of chart we want to create
      type: 'bar',

      // The data for our dataset
      data: {
          // X
          labels: ["January", "February", "March", "April", "May", "June", "July"],
          datasets: [{
              label: "My First dataset",
              backgroundColor: 'orange',
              borderColor: 'orange',
              data: [5, 10, 5, 2, 20, 30, 45],
          }]
      }
    });

    // Bar Chart
    var stickerCtx = document.getElementById('stickerChart').getContext('2d');
    var stickerChart = new Chart(stickerCtx, {
      // The type of chart we want to create
      type: 'bar',

      // The data for our dataset
      data: {
          // X
          labels: ["January", "February", "March", "April", "May", "June", "July"],
          datasets: [{
              label: "My First dataset",
              backgroundColor: 'orange',
              borderColor: 'orange',
              data: [5, 10, 5, 2, 20, 30, 45],
          }]
      }
    });

    // Bar Chart
    var bottleCtx = document.getElementById('bottleChart').getContext('2d');
    var bottleChart = new Chart(bottleCtx, {
      // The type of chart we want to create
      type: 'bar',

      // The data for our dataset
      data: {
          // X
          labels: ["January", "February", "March", "April", "May", "June", "July"],
          datasets: [{
              label: "My First dataset",
              backgroundColor: 'orange',
              borderColor: 'orange',
              data: [5, 10, 5, 2, 20, 30, 45],
          }]
      }
    });
  </script>

  </body>
</html>
