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
    <title>Thomas Delacourt - Mes Web Design</title>
    <script src="app.js"></script>
</head>
<body>
    <div class="slide oeuvres" id="webdesign">
    <div id="fondweb">
              <img src="images/figmasiteimages/meraurore.jpg" alt="espace">
          </div>
        <div class="wrapper">
            <h1>Mes Web Design</h1>
            <a href="index.php#portfolio">
                <div id="backweb">
               <span></span> </span><span></span><span></span><span></span> Retour
            </a>
            </div>
            <div class="filtres">
                <a href='webdesign.php?filtre=ht' class="filtre"><img src="images/htmlcsspng.png" alt="htmlcss"></a>
                <a href='webdesign.php?filtre=fi' class="filtre"><img src="images/figmapng.png" alt="Figma"></a>
               
            </div>
          
            <div class="galerie">
            <?php
                if(isset($_GET['filtre']))
                {
                    $filtre = htmlspecialchars($_GET['filtre']);
                    if($filtre=="ht")
                    {
                        $works = $bdd->query("SELECT * FROM oeuvres WHERE categorie='webdesign' AND logiciel='Html' ORDER BY id DESC");
                    }else{
                        $works = $bdd->query("SELECT * FROM oeuvres WHERE categorie='webdesign' AND logiciel='Figma' ORDER BY id DESC");
                    }
                }else{
                    $works = $bdd->query("SELECT * FROM oeuvres WHERE categorie='webdesign' ORDER BY id DESC");
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