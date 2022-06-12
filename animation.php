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
    <title>Thomas Delacourt - Mes animations</title>
    <script src="app.js"></script>
</head>
<body>
    <div class="slide oeuvres" id="animation">
    <div id="fondanim">
              <img src="images/figmasiteimages/merplanete.jpg" alt="espace">
          </div>
        <div class="wrapper">
            <h1>Mes animations</h1>
            <a href="index.php#portfolio">
            <div id="backanim">
               <span></span> </span><span></span><span></span><span></span> Retour
            </a>
            </div>
            <div class="filtres">
                <a href='animation.php?filtre=cl' class="filtre"><img src="images/clippng.png" alt="clip"></a>
                <a href='animation.php?filtre=ae' class="filtre"><img src="images/afterpng.png" alt="aftereffect"></a>
                <a href='animation.php?filtre=pp' class="filtre"><img src="images/propng.png" alt="Premierpro"></a> 
            </div>
            <div class="galerie">
            <?php
                if(isset($_GET['filtre']))
                {
                    $filtre = htmlspecialchars($_GET['filtre']);
                    if($filtre=="cl")
                    {
                        $works = $bdd->query("SELECT * FROM oeuvres WHERE categorie='Animation' AND logiciel='clip' ORDER BY id DESC");
                    }elseif($filtre=="ae")
                    {
                        $works = $bdd->query("SELECT * FROM oeuvres WHERE categorie='Animation' AND logiciel='aftereffect' ORDER BY id DESC");
                    }else{
                        $works = $bdd->query("SELECT * FROM oeuvres WHERE categorie='Animation' AND logiciel='premierepro' ORDER BY id DESC");
                    }
                }else{
                    $works = $bdd->query("SELECT * FROM oeuvres WHERE categorie='Animation' ORDER BY id DESC");
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