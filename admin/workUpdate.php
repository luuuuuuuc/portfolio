<?php 
    session_start();
    if(!isset($_SESSION['login'])){
        header("LOCATION:403.php");
    }
     // j'ai besoin de id pour fonctionner
     if(!isset($_GET['id']))
     {
         header("LOCATION:mark.php");
     }else{
         $id = htmlspecialchars($_GET['id']);
     }
 
 
     require "../connexion.php";
     $req = $bdd->prepare("SELECT * FROM oeuvres WHERE id=?");
     $req->execute([$id]);
     if(!$don = $req->fetch())
     {
         $req->closeCursor();
         header("LOCATION:mark.php");
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
        <h1>Modifier </h1>
        <form action="treatmentWorkUpdate.php?id=<?= $don['id'] ?>" method="POST" enctype="multipart/form-data">
          <div class="form-group my-3">
              <label for="marque">Titre: </label>
              <input type="text" id="titre" name="titre" value="<?= $don['titre'] ?>" class="form-control">
          </div>
          <div class="form-group my-3">
              <label for="description">Description</label>
              <textarea name="description" id="description" class="form-control" rows="10"><?= $don['description'] ?></textarea>
          </div>
          <div class="form-group my-3">
              <label for="logiciel">Logiciel utilisé</label>
              <input type="text" id="logiciel" name="logiciel" class="form-control" value="<?= $don['logiciel'] ?>">
          </div>
          <div class="form-group my-3">
              <label for="categorie">Catégorie</label>
              <input type="text" id="categorie" name="categorie" class="form-control" value="<?= $don['categorie'] ?>">
          </div>
          <div class="form-group my-3">
              <div class="col-3">
                  <img src="../images/<?= $don['images'] ?>" alt="image de l'oeuvre <?= $don['titre'] ?>" class="img-fluid">
              </div>
              <label for="logo">images: </label>
              <input type="file" name="image" id="image" class="form-control">
          </div>
          <div class="form-group my-3">
              <input type="submit" value="Modifier" class="btn btn-warning">
          </div>
          <?php
                if(isset($_GET['error']))
                {
                    echo "<div class='alert alert-danger my-3'>Une erreur s'est produite (code erreur: ".$_GET['error'].")</div>";
                }
                if(isset($_GET['imgerror']))
                {
                    switch($_GET['imgerror'])
                    {
                        case 2: 
                            echo "<div class='alert alert-danger'>L'extension de votre fichier n'est pas acceptée</div>";
                            break;
                        case 3:
                            echo "<div class='alert alert-danger'>La taille de votre fichier dépasse la limite autorisée</div>";
                            break;  
                        case 4:
                            echo "<div class='alert alert-danger'>Une erreur est survenue, veuillez recommencer</div>";
                            break;  
                        default: 
                            echo "<div class='alert alert-danger'>Une erreur est survenue</div>";      
                    }
                }

          ?>
        </form>
    </div>
</body>
</html>