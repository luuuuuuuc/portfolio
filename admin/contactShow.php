<?php
    session_start();
    if(!isset($_SESSION['login'])){
        header("LOCATION:403.php");
    }
    
    require "../connexion.php";

    if(isset($_GET['id']))
    {
        $id=htmlspecialchars($_GET['id']);
    }else{
        header("LOCATION:contact.php");
    }

    require "../connexion.php";
    $req = $bdd->prepare("SELECT id,nom,email,message,DATE_FORMAT(date,'%d / %m / %Y %H h %i min') AS myDate FROM contact WHERE id=?");
    $req->execute([$id]);
    if(!$don = $req->fetch())
    {
        $req->closeCursor();
        header("LOCATION:contact.php");
    }
    $req->closeCursor();


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <?php 
        include("partials/header.php");
    ?>
    <div class="container">
        <h2>Les messages de <?= $don['nom'] ?></h2>
        <h6>le <?= $don['myDate'] ?></h6>
        <h5>De <a href="mailto:<?= $don['email'] ?>"><?= $don['email'] ?></a></h5>
        <div class="row">
            <div class="col-12">
                <?= nl2br($don['message']) ?>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <a href="contact.php" class="btn btn-secondary my-3">Retour</a>
            <a href="contact.php?delete=<?= $don['id'] ?>" class="btn btn-danger my-3">Supprimer</a>
        </div>
    </div>    
</body>
</html>