<?php 
    session_start();
    if(!isset($_SESSION['login'])){
        header("LOCATION:403.php");
    }

    if(isset($_GET['deco']))
    {
        session_destroy();
        header("LOCATION:index.php");
    }

    require "../connexion.php"
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <?php
        include("partials/header.php");
    ?>
    <div class="container-fluid">
        <h1>Dashboard</h1>
        <div class="row d-flex justify-content-between">
            <div class="col-3 bg-primary text-white text-center">
                <h2>Oeuvre(s)</h2>
                <?php
                    $works = $bdd->query("SELECT * FROM oeuvres");
                    $nbWorks = $works->rowCount();
                    echo "<h3>".$nbWorks."</h3>";
                ?>
                
            </div>
            <div class="col-3 bg-warning text-white text-center">
                <h2>Compétence(s)</h2>
                <?php
                    $skills = $bdd->query("SELECT * FROM competence");
                    $nbSkills = $skills->rowCount();
                    echo "<h3>".$nbSkills."</h3>";
                ?>
            </div>
            <div class="col-3 bg-success text-white text-center">
                <h2>Message(s)</h2>
                <?php
                    $contact = $bdd->query("SELECT * FROM contact");
                    $messages = $contact->rowCount();
                    echo "<h3>".$messages."</h3>";
                ?>
            </div>
        </div>


    </div>
</body>
</html>