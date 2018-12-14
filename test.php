<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include "header.php" ?>
  </head>
  <body>

    <?php include "topbar.php" ?>

    <section class="test-section">
       <div class="container">
         <div class="row test-row">
           <div class="col-md-8 pr-md-8 test-form">

             <form action="functions/addResult.php" method="post" class="form-group">

             <!-- Informations personnelles -->
               <h2 class="section-title">Informations personnelles</h2>
               <label class="title" for="email">Email : </label>
               <input class="form-control" type="email" name="email" id="email"><br>
               <label class="title" for="age">Age : </label>
               <input class="form-control" type="text" name="age" id="age"><br>
               <label class="title" for="sexe">Sexe : </label>
               <select class="sexe" id="sexe" name="sexe">
                 <option value="homme">Homme</option>
                 <option value="femme">Femme</option>
                 <option value="autre">Autre</option>
               </select><br>
               <label class="title" for="ville">Ville : </label>
               <input class="form-control" type="text" name="ville" id="ville"><br>
               <label class="title" for="cp">Code Postal : </label>
               <input class="form-control" type="text" name="cp" id="cp"><br>

               <br>

           <!-- Question 1 -->
               <h2 class="section-title">Douche</h2>
               <label class="title" for="q1a">Combien de douches prenez-vous par semaine ?</label>
               <input class="form-control" type="number" name="q1a" id="q1a"><br>
               <label class="title" for="q1b">Combien de temps en moyenne passez-vous sous la douche (en minute) ?</label>
               <input class="form-control" type="text" name="q1b" id="q1b"><br>
               <label class="title" for="q1c">Quel est le débit de votre pomme de douche ?</label>
               <div class="sub-label">
                 <input type="radio" id="q1c1"
                  name="q1c" value="faible" checked>
                 <label for="q1c1">Faible (réducteur de débit / label énergie pour le pommeau)</label>
                 <br>
                 <input type="radio" id="q1c2"
                  name="q1c" value="moyen">
                 <label for="q1c2">Moyen (coupe l'eau pendant le savonnage)</label>
                 <br>
                 <input type="radio" id="q1c3"
                  name="q1c" value="fort">
                 <label for="q1c3">Fort</label>
               </div>

           <!-- Question 2 -->
               <h2 class="section-title">Bains</h2>
               <label class="title" for="q2a">Combien de bains prenez-vous par semaine ?</label>
               <input class="form-control" type="number" name="q2a" id="q2a"><br>
               <div id="hideQ2">
                 <label class="title" for="q2b">(si oui) Remplissez-vous votre baignoire entièrement ?</label>
                 <div class="sub-label">
                   <input type="radio" id="q2b1"
                    name="q2b" value="oui" checked>
                   <label for="q2b1">Oui</label>
                   <br>
                   <input type="radio" id="q2b2"
                    name="q2b" value="non">
                   <label for="q2b2">Non</label>
                 </div>
               </div>

           <!-- Question 3 -->
               <h2 class="section-title">Lavage de dents</h2>
               <label class="title" for="q3a">Combien de fois vous brossez-vous les dents par jour ?</label>
               <input class="form-control" type="number" name="q3a" id="q3a"><br>
               <label class="title" for="q3b">Coupez vous l’eau pendant le brossage de vos dents ?</label>
               <div class="sub-label">
                 <input type="radio" id="q3b1"
                  name="q3b" value="oui" checked>
                 <label for="q3b1">Oui</label>
                 <br>
                 <input type="radio" id="q3b2"
                  name="q3b" value="parfois">
                 <label for="q3b2">Parfois</label>
                 <br>
                 <input type="radio" id="q3b3"
                  name="q3b" value="non">
                 <label for="q3b3">Non</label>
               </div>

           <!-- Question 4 -->
               <h2 class="section-title">Vaisselle</h2>
               <label class="title" for="q4a">Combien de vaisselles faites-vous par semaine ?</label>
               <input class="form-control" type="number" name="q4a" id="q4a"><br>

               <label class="title" for="q4b">Lavez-vous votre vaisselle à la main ou avec un lave-vaisselle ?</label>
               <div class="sub-label">
                 <input type="radio" id="q4b1"
                  name="q4b" value="main">
                 <label for="q4b1">Lavage à la main</label>
                 <br>
                 <input type="radio" id="q4b2"
                  name="q4b" value="lave-vaisselle" checked>
                 <label for="q4b2">Lave-vaisselle</label>
               </div>

               <div id="hideQ4c">
                 <label class="title" for="q4c">(si vaisselle à la main) Laissez-vous couler l'eau lors de votre vaisselle ?</label>
                 <div class="sub-label">
                   <input type="radio" id="q4c1"
                    name="q4c" value="oui">
                   <label for="q4c1">Oui</label>
                   <br>
                   <input type="radio" id="q4c2"
                    name="q4c" value="non" checked>
                   <label for="q4c2">Non</label>
                 </div>
               </div>

               <div id="hideQ4d">
                 <label class="title" for="q4d">(si eau coule) Combien de pièces lavez-vous en moyenne par vaisselle ?</label>
                 <input class="form-control" type="number" name="q4d" id="q4d"><br>
               </div>

           <!-- Question 5 -->
               <h2 class="section-title">Lave-linge</h2>
               <label class="title" for="q5a">Combien de fois utilisez-vous votre lave-linge par mois ?</label>
               <input class="form-control" type="number" name="q5a" id="q5a"><br>
               <label class="title" for="q5b">Le lave-linge utilisé est-il récent ou ancien ?</label>
               <div class="sub-label">
                 <input type="radio" id="q5b1"
                  name="q5b" value="recent" checked>
                 <label for="q5b1">Recent (après 2011)</label>
                 <br>
                 <input type="radio" id="q5b2"
                  name="q5b" value="ancien">
                 <label for="q5b2">Ancien</label>
               </div>

           <!-- Question 6 -->
               <h2 class="section-title">Installations</h2>
               <label class="title" for="q6">Avez-vous une ou plusieurs installations pour économiser l'eau?</label><br>
               <input type="checkbox" name="q6" value="mitigeur"> Mitigeur<br>
               <input type="checkbox" name="q6" value="recuperateur"> Récupérateur d'eau de pluie<br>
               <input type="checkbox" name="q6" value="chasse d'eau"> Chasse d'eau économe<br>
               <input type="hidden" name="q6b" value="">
               
           <!-- Question 7 -->
               <h2 class="section-title">Jardin</h2>
               <label class="title" for="q7a">Avez-vous des plantes / un jardin ?</label>
               <div class="sub-label">
                 <input type="radio" id="q7a1"
                  name="q7a" value="oui">
                 <label for="q7a1">Oui</label>
                 <br>
                 <input type="radio" id="q7a2"
                  name="q7a" value="non" checked>
                 <label for="q7a2">Non</label>
               </div>
               <div id="hideQ7">
                 <label class="title" for="q7b">(si oui) Quand arrosez-vous vos plantes ?</label>
                 <div class="sub-label">
                   <input type="radio" id="q7b1"
                    name="q7b" value="matin" checked>
                   <label for="q7b1">Matin</label>
                   <br>
                   <input type="radio" id="q7b2"
                    name="q7b" value="journée">
                   <label for="q7b2">En journée</label>
                   <br>
                   <input type="radio" id="q7b2"
                    name="q7b" value="soir">
                   <label for="q7b2">Soir</label>
                 </div>
                 <label class="title" for="q7c">(si oui) Avec quelle eau arrosez-vous vos plantes ?</label>
                 <div class="sub-label">
                   <input type="radio" id="q7c1"
                    name="q7c" value="robinet" checked>
                   <label for="q7c1">Eau du robinet</label>
                   <br>
                   <input type="radio" id="q7c2"
                    name="q7c" value="pluie">
                   <label for="q7c2">Eau de pluie</label>
                 </div>
                 <label class="title" for="q7d">(si oui) Combien de fois arrosez-vous vos plantes par mois ?</label>
                 <input class="form-control" type="number" name="q7d" id="q7d"><br>
               </div>

           <!-- Question 8 -->
               <h2 class="section-title">Voiture</h2>
               <label class="title" for="q8a">Avez-vous au moins une voiture ?</label>
               <div class="sub-label">
                 <input type="radio" id="q8a1"
                  name="q8a" value="oui">
                 <label for="q8a1">Oui</label>
                 <br>
                 <input type="radio" id="q8a2"
                  name="q8a" value="non" checked>
                 <label for="q8a2">Non</label>
               </div>
               <div id="hideQ8">
                 <label class="title" for="q8b">(si oui) Utilisez-vous le lavage automatique ou le lavage manuel</label>
                 <div class="sub-label">
                   <input type="radio" id="q8b1"
                    name="q8b" value="automatique" checked>
                   <label for="q8b1">Lavage automatique</label>
                   <br>
                   <input type="radio" id="q8b2"
                    name="q8b" value="manuel">
                   <label for="q8b2">Lavage manuel</label>
                 </div>
                 <label class="title" for="q8c">(si oui) Combien de fois lavez-vous votre voiture par mois ?</label>
                 <input class="form-control" type="number" name="q8c" id="q8c"><br>
               </div>

           <!-- Question 9 -->
               <h2 class="section-title">Piscine</h2>
               <label class="title" for="q9a">Avez-vous une piscine ?</label>
               <div class="sub-label">
                 <input type="radio" id="q9a1"
                  name="q9a" value="oui">
                 <label for="q9a1">Oui</label>
                 <br>
                 <input type="radio" id="q9a2"
                  name="q9a" value="non" checked>
                 <label for="q9a2">Non</label>
               </div>
               <div id="hideQ9">
                 <label class="title" for="q9b">(si oui) Quel est le volume de votre piscine (en m3)?</label>
                 <input class="form-control" type="number" name="q9b" id="q9b"><br>
                 <label class="title" for="q9c">(si oui) Videz-vous votre piscine chaque année ?</label>
                 <input class="form-control" type="number" name="q9c" id="q9c"><br>
               </div>

           <!-- Question 10 -->
               <h2 class="section-title">Étiquettes énergétiques</h2>
               <label class="title" for="q10">Faites-vous attention aux étiquettes énergétiques quand vous achetez de l'électroménager?</label>
               <div class="sub-label">
                 <input type="radio" id="q101"
                  name="q10" value="oui" checked>
                 <label for="q101">Oui</label>
                 <br>
                 <input type="radio" id="q102"
                  name="q10" value="non">
                 <label for="q102">Non</label>
               </div>

           <!-- Question 11 -->
               <h2 class="section-title">Eau en bouteille</h2>
               <label class="title" for="q11">Buvez vous de l'eau en bouteille ou de l'eau du robinet (filtrée) ?</label>
               <div class="sub-label">
                 <input type="radio" id="q111"
                  name="q11" value="bouteille" checked>
                 <label for="q111">Eau en bouteille</label>
                 <br>
                 <input type="radio" id="q112"
                  name="q11" value="robinet">
                 <label for="q112">Eau du robinet</label>
               </div>

               <div class="form-group send-button">
                 <input type="submit" value="Envoyer" class="btn btn-primary py-3 px-5">
               </div>

             </form>

           </div>
         </div>
       </div>
     </section>

     <?php include "js-import.php" ?>

     <script type="text/javascript" src="js/script/test.js">

     </script>

    <?php include "footer.php" ?>

  </body>
</html>
