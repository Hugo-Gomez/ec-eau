<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include "header.php" ?>
  </head>
  <body>

  <?php include "topbar.php" ?>
    
    <div class="hero-wrap" style="background-image: url('images/contact.jpg'); background-attachment:fixed;background-position-y: 0px;">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center" data-scrollax-parent="true">
          <div class="col-md-8 ftco-animate text-center">
            <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Page d'accueil</a></span></p>
            <h1 class="mb-3 bread">Contactez-nous</h1>
            <h3>Nous sommes là pour vous aider</h3>
          </div>
        </div>
      </div>
    </div>

   <section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">
        <div class="row d-flex mb-5 contact-info">
          <div class="col-md-12 mb-4">
            <h2 class="h4">Informations de contact</h2>
          </div>
          <div class="w-100"></div>
          <div class="col-md-3">
            <p><span>Adresse:</span> HETIC - 27 bis Rue du Progrès, 93100 Montreuil, France</p>
          </div>
          <div class="col-md-3">
            <p><span>Tél:</span> <a href="tel://1234567920">+33 6 34 56 09 34
</a></p>
          </div>
          <div class="col-md-3">
            <p><span>Email:</span> <a href="mailto:info@yoursite.com">info@ec-eau.com</a></p>
          </div>
          <div class="col-md-3">
            <p><span>Site Web:</span> <a href="https://www.hetic.net/">HETIC</a></p>
          </div>
        </div>
        <div class="row block-9">
          <div class="col-md-12 pr-md-5">
            <form action="#">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Votre nom">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Votre email">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Sujet">
              </div>
              <div class="form-group">
                <textarea name="" id="" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
              </div>
              <div class="form-group">
                <input type="submit" value="Envoyer votre message" class="btn btn-primary py-3 px-5">
              </div>
            </form>

          </div>
        </div>
      </div>
    </section>

    <?php include "footer.php" ?>


  <?php include "js-import.php" ?>

  </body>
</html>
