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
$vOui = 0;
$vNon = 0;
$vHeight = 0;
foreach ($res as $row) {
  if($row["choixVaisselle"] == "main"){
    $vHeight ++;
    if($row["methVaisselle"] == "oui"){$vOui ++;}
    if($row["methVaisselle"] == "non"){$vNon ++;}
  }
}
$pctVOui = ($vOui / $vHeight) * 100;
$pctVNon = ($vNon / $vHeight) * 100;
//echo "<!-- vaisselle :".$vMain." ".$vLave."-->";
//echo "<!-- vaisselle pct :".$pctVMain." ".$pctVLave."-->";

//machine a laver
$MalRecent = 0;
$MalAncien = 0;
foreach ($res as $row) {
    if($row["dateMal"] == "recent"){$MalRecent ++;}
    if($row["dateMal"] == "ancien"){$MalAncien ++;}
}
$pctMalRecent = ($MalRecent / $vHeight) * 100;
$pctMalAncien = ($MalAncien / $vHeight) * 100;
//echo "<!-- MAL :".$MAL0_5." ".$MAL5_10." ".$MAL10_15." ".$MAL15_20." ".$MAL20_25." ".$MAL25_plus."-->";

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
    if($row["freqPiscine"] == "oui"){
      $piOui ++;
    }
    if($row["freqPiscine"] == "non"){
      $piNon ++;
    }
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
$pctDouche = [round($pctDFaible),round($pctDMoyen),round($pctDFort)];

$bain = [$bainNon,$bainOui];
$pctBain = [round($pctBainNon),round($pctBainOui)];

$vaisselle = [$vOui,$vNon];
$pctVaisselle = [round($pctVOui),round($pctVNon)];

$MAL = [$MalRecent,$MalAncien];

$plante = [$pRobinet,$pPluie];
$pctPlante = [round($pctPRobinet),round($pctPPluie)];

$piscine = [$piNon,$piOui];
$pctPiscine = [round($pctPiOui),round($pctPiNon)];

$etiquette = [$etOui,$etNon];
$pctEtiquette = [round($pctEtOui),round($pctEtNon)];

$bouteille = [$boOui,$boNon];
$pctBouteille = [round($pctBoOui),round($pctBoNon)];

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
            Nous pouvons voir grâce à ce graphique que la majorité des usagers ayant répondu
            à notre questionnaire on une consommation moyenne d'eau lors de leur douche (coupe
            l'eau pendant le savonage).
          </p>
        </div>
        <div class="col-md-10 plot">
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
              Ici, on voit que seulement 14% des usagers ayant répondu à notre questionnaire prennent
              un bain.
            </p>
          </div>
          <div class="col-md-10 plot">
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
          <h2 class="title">Vaisselle</h2>
          <p class="description">
            On observe sur ce graphique quelque chose d'intéressant, car la différence entre
            les usagers utilisant un lave-vaisselle et ceux qui font la vaiselle à la main n'est
            pas très importante, même si il y a plus de personne qui font la vaiselle à la main.
          </p>
        </div>
        <div class="col-md-10 plot">
          <canvas id="dishChart" width="400" height="150"></canvas>
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
              On remarque une presque équivalence ici sur le sujet de l'arrosage du jardin. En
              effet, comme il est dit sur la page conseil, il est préférable d'utiliser l'eau
              de pluie pour ce genre d'activité.
            </p>
          </div>
          <div class="col-md-10 plot">
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
          <h2 class="title">Lave-linge</h2>
          <p class="description">
            On remarque qu'une grande partie des usagers ayant répondu à notre test font
            0 à 10 machine par mois.
          </p>
        </div>
        <div class="col-md-10 plot">
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
            <h2>Piscine</h2>
            <p class="description">
              On remarque ici une majorité de personne n'ayant pas de piscine.
            </p>
          </div>
          <div class="col-md-10 plot">
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
            On remarque ici que les résultats n'ont pas énormément de différence, même si
            la plupart des usagers ont tendances à ne pas faire attention aux étiquettes
            énergétiques à l'achat d'un produit électroménager.
          </p>
        </div>
        <div class="col-md-10 plot">
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
              On remarque ici que la majorité des usagers ne consomme pas d'eau en bouteille
              et préfère donc consommer directement via le robinet, qui est une pratique
              bien meilleure pour la préservation de l'eau.
            </p>
          </div>
          <div class="col-md-10 plot">
            <canvas class="white-plot" id="bottleChart" width="400" height="150"></canvas>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include "footer.php" ?>

  <?php include "js-import.php" ?>

  <script type="text/javascript">
    // Douche
    var showerCtx = document.getElementById('showerChart').getContext('2d');
    var showerChart = new Chart(showerCtx, {
      type: 'bar',
      data: {
          labels: ["Fort", "Moyen", "Faible"],
          datasets: [{
              backgroundColor: '#2288e4',
              borderColor: '#2288e4',
              data: <?php echo json_encode($douche) ?>,
          }]
      },
      options: {
        title: {
          display: true,
          text: "Débit de la pomme de douche"
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });

    // Bains
    var bathCtx = document.getElementById('bathChart').getContext('2d');
    var bathChart = new Chart(bathCtx, {
      type: 'pie',
      data: {
          labels: ["Non", "Oui"],
          datasets: [{
              backgroundColor: ['#2288e4', "orange"],
              borderColor: ['#2288e4', "orange"],
              data: <?php echo json_encode($pctBain) ?>,
          }]
      },
      options: {
        title: {
          display: true,
          text: "Pourcentage de bains"
        },
        legend: {
            labels: {
                fontColor: "white",
            }
        }
      }
    });

    // Lave-vaiselle
    var dishCtx = document.getElementById('dishChart').getContext('2d');
    var dishChart = new Chart(dishCtx, {
      type: 'bar',
      data: {
          labels: ["Oui", "Non"],
          datasets: [{
              backgroundColor: "orange",
              borderColor: "orange",
              data: <?php echo json_encode($vaisselle) ?>,
          }]
      },
      options: {
        title: {
          display: true,
          text: "nombre de perssone qui laissent couler l'eau durant une vaisselle"
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });

    // Jardin
    var gardenCtx = document.getElementById('gardenChart').getContext('2d');
    var gardenChart = new Chart(gardenCtx, {
      type: 'pie',
      data: {
          labels: ["Robinet", "Pluie"],
          datasets: [{
              backgroundColor: ['#2288e4', "orange"],
              borderColor: ['#2288e4', "orange"],
              data: <?php echo json_encode($pctPlante) ?>,
          }]
      },
      options: {
        title: {
          display: true,
          text: "Provenance de l'eau utilisé pour le jardin"
        },
        legend: {
            labels: {
                fontColor: "white",
            }
        }
      }
    });

    // Machine à laver
    var washingCtx = document.getElementById('washingChart').getContext('2d');
    var washingChart = new Chart(washingCtx, {
      type: 'bar',
      data: {
          labels: ["Recent", "Ancien"],
          datasets: [{
              backgroundColor: '#2288e4',
              borderColor: '#2288e4',
              data: <?php echo json_encode($MAL) ?>,
          }]
      },
      options: {
          title: {
            display: true,
            text: "Nombre de machine lancé par mois"
          },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });

    // Piscine
    var poolCtx = document.getElementById('poolChart').getContext('2d');
    var poolChart = new Chart(poolCtx, {
      type: 'pie',
      data: {
          labels: ["Non", "Oui"],
          datasets: [{
              backgroundColor: ["orange", '#2288e4'],
              borderColor: ["orange", '#2288e4'],
              data: <?php echo json_encode($pctPiscine) ?>,
          }]
      },
      options: {
        title: {
          display: true,
          text: "Possession de piscine"
        },
        legend: {
            labels: {
                fontColor: "white",
            }
        }
      }
    });

    // Etiquette énergétique
    var stickerCtx = document.getElementById('stickerChart').getContext('2d');
    var stickerChart = new Chart(stickerCtx, {
      type: 'bar',
      data: {
          labels: ["Oui", "Non"],
          datasets: [{
              backgroundColor: '#2288e4',
              borderColor: '#2288e4',
              data: <?php echo json_encode($etiquette) ?>,
          }]
      },
      options: {
        title: {
          display: true,
          text: "Attention portée aux étiquettes énergies à l'achat d'un bien électroménager"
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            }
          }]
        }
      }
    });

    // Bouteille
    var bottleCtx = document.getElementById('bottleChart').getContext('2d');
    var bottleChart = new Chart(bottleCtx, {
      type: 'pie',
      data: {
          labels: ["Oui", "Non"],
          datasets: [{
              backgroundColor: ['#2288e4', "orange"],
              borderColor: ['#2288e4', "orange"],
              data: <?php echo json_encode($pctBouteille) ?>,
          }]
      },
      options: {
          title: {
            display: true,
            text: "Consommation de bouteille d'eau"
          },
        legend: {
            labels: {
                fontColor: "white",
            }
        }
      }
    });

    // Multi Chart
    // var multiCtx = document.getElementById('multiChart').getContext('2d');
    // var multiChart = new Chart(multiCtx, {
    //
    //   type: 'bar',
    //
    //
    //   data: {
    //       datasets: [{
    //           label: "My First dataset",
    //           backgroundColor: "orange",
    //           borderColor: "orange",
    //           data: [5, 10, 5, 2, 20, 30, 45],
    //       }, {
    //         label: "My Second dataset",
    //         backgroundColor: "#2288e4",
    //         borderColor: "#2288e4",
    //         data: [10, 20, 15, 2, 22, 13, 14],
    //       }],
    //       // X
    //       labels: ["January", "February", "March", "April", "May", "June", "July"]
    //   }
    // });
  </script>

  </body>
</html>
