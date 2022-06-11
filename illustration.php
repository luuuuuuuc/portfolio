<?php 
    require "connexion.php";

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dist/css/glightbox.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Thomas Delacourt - Mes illustration</title>
    <script src="app.js"></script>
</head>
<body>
    <div class="slide oeuvres" id="illustration">
    <div id="fondillu">
              <img src="images/figmasiteimages/mergalax.jpg" alt="espace">
          </div>
        <div class="wrapper">
            <h1>Mes illustrations</h1>
            <a href="index.php#portfolio">
                <div class="backillu">
               <span></span> </span><span></span><span></span><span></span> Retour
            </a>
            </div>
            <div class="filtres">
                <a href='illustration.php?filtre=ps' class="filtre"><img src="images/photoshop-logo.png" alt="Photoshop"></a>
                <a href='illustration.php?filtre=ai' class="filtre"><img src="images/illustrator.png" alt="Illustrator"></a>
                <a href='illustration.php?filtre=id' class="filtre"><img src="images/Adobe Id.png" alt="Indesign"></a> 
            </div>
          
            <div class="galerie">
            <?php
                if(isset($_GET['filtre']))
                {
                    $filtre = htmlspecialchars($_GET['filtre']);
                    if($filtre=="ps")
                    {
                        $works = $bdd->query("SELECT * FROM oeuvres WHERE categorie='Illustration' AND logiciel='Photoshop' ORDER BY id DESC");
                    }elseif($filtre=="ai")
                    {
                        $works = $bdd->query("SELECT * FROM oeuvres WHERE categorie='Illustration' AND logiciel='Illustrator' ORDER BY id DESC");
                    }else{
                        $works = $bdd->query("SELECT * FROM oeuvres WHERE categorie='Illustration' AND logiciel='InDesign' ORDER BY id DESC");
                    }
                }else{
                    $works = $bdd->query("SELECT * FROM oeuvres WHERE categorie='Illustration' ORDER BY id DESC");
                }
                

                if($works->rowCount() == 0)
                {
                   echo "<div>Aucun résultat</div>";
                }else{
                    while($donWorks = $works->fetch())
                    {
                        echo '<a href="images/'.$donWorks['images'].'" data-glightbox="title:'.$donWorks['titre'].'; description:'.$donWorks['description'].'" class="images">';
                            echo '<img src="images/'.$donWorks['images'].'" alt="image '.$donWorks['titre'].'">';
                        echo '</a>';
                    }
                    
                }
                $works->closeCursor();
            ?>   
            </div>
        </div>
    </div>
    <footer></footer>

    <script src="dist/js/glightbox.min.js"></script>
    <script>
        var lightbox = GLightbox();
        var lightboxDescription = GLightbox({
            selector: '.images',
        });
    </script>
</body>
</html>