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
    <script src="test.js"></script>
    <title>Document</title>
    <script src="app.js"></script>
</head>

<body>
    <div id="mobile">
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#pres">Présentation</a></li>
                <li><a href="#portfolio">Portfolio</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </div>
    <header>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#pres">Présentation</a></li>
                <li><a href="#portfolio">Portfolio</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>
    <div id="burger">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    <div class="slide" id="home">
     
        <div class="block1">
            <h1 id="del">Delacourt</h1>
            <p>
                <h1 id="tho"> Thomas</h1>
            </p>


            <h1 id="etu">étudiant en</h1>
            <p>
                <h1 id="inf"> infographie</h1>
            </p>

        </div>
        
    </div>
    <div class="slide" id="pres">
      
        <h1 id="presentation">Présentation</h1>
        <h1 id="info">Jutse pour info...</h1>

        <div id="myskills">
            <div class="gauche">
                <div class="block" id="texte">
                    <p> Le <strong>dessin</strong> a toujours été une passion mais n’ayant pas étais spécialement orienté vers,
                        quand je suis sortie des secondaires il a bien fallu travailler et j’ai donc commencé ma vie dans le
                        monde du travaille… J’ai détesté ça. Je n’ai jamais vraiment été un manuel mais pas non plus un
                        intellectuel, je ne trouvais pas ma place. Et puis, bien des années plus tard, après avoir cherché et
                        cherché, j’ai enfin trouvé comment lier l’utile à l’ agréable, j' ai repris des études dans
                        <strong>l’infographie</strong>… Et me voilà … </p>
        
                </div>
            </div>
            <div class="droite">
                <h1 id="comp">Compétences</h1>
        
                <div class="wrapper" id="logiciel">
                    <?php
                        $skills = $bdd->query("SELECT * FROM competence");
                        while($donSkills = $skills->fetch())
                        {
                            echo '<img src="images/'.$donSkills['image'].'" alt="Skills Thomas"></a>';
                        }
                        $skills->closeCursor();

                    ?>
                </div>
            </div>




        </div>

    </div>
    <div class="slide" id="portfolio">

        <div class="wrapper" id="gal">

            <h1>Portfolio</h1>
            <nav>
                <ul>
                    <li><a href="illustration.php">Illustration vectoriel</a></li>
                    <li><a href="webdesign.php">Web design</a></li>
                    <li><a href="animation.php">Animation</a></li>
                </ul>
            </nav>

            <div class="galerie">
            <?php
                $works = $bdd->query("SELECT * FROM oeuvres ORDER BY id DESC LIMIT 0,9");
                while($donWorks = $works->fetch())
                {
                    echo '<a href="images/'.$donWorks['images'].'" data-glightbox="'.$donWorks['titre'].'" class="images">';
                        echo '<img src="images/'.$donWorks['images'].'" alt="image '.$donWorks['titre'].'">';
                    echo '</a>';
                    
                }
                $works->closeCursor();

                ?>





            </div>
        </div>
    </div>
    <div class="slide" id="contact">
        <div class="wrapper">
        <h1>Contact</h1>

            <div id="form">
                <?php
                    if(isset($_GET['message']))
                    {
                        echo '<div id="flash">Votre message à bien été envoyé</div>';
                    }

                    if(isset($_GET['error']))
                    {
                        echo '<div id="flash-error">Une erreur est survenue</div>';
                    }
                ?>
                <form action="traitement.php" method="POST">
                    <p><label for="nom">Nom: </label><input type="text" id="nom" name="nom" placeholder="Viair"></p>
                    <p><label for="mail">E-Mail: </label><input type="email" id="mail" name="email"
                            placeholder="l#Rivi#ir@Waterproof.com"></p>
                    <p><label for="mess">Message:</label></p>
                    <p><textarea name="message" id="mess"></textarea></p>
                    <p><input type="submit" value="Envoyer" class="env"></p>
                </form>
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