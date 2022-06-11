<?php
    session_start();
    if(!isset($_SESSION['login'])){
        header("LOCATION:403.php");
    }
    
    require "../connexion.php";

    if(isset($_GET['delete']))
    {
        $id=htmlspecialchars($_GET['delete']);
        $work = $bdd->prepare("SELECT * FROM oeuvres WHERE id=?");
        $work->execute([$id]);
        if(!$donWork = $work->fetch())
        {
            $work->closeCursor();
            header("LOCATION:404.php");
        }
        $work->closeCursor();

        unlink("../images/".$donWork['images']);

        $deleteWork = $bdd->prepare("DELETE FROM oeuvres WHERE id=?");
        $deleteWork->execute([$id]);
        $deleteWork->closeCursor();

        header("LOCATION:works.php?deleteSuccess=".$id);

    }

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
    <div class="container-fluid">
        <h1>Les oeuvres</h1>
        <a href="workAdd.php" class="btn btn-primary">Ajouter</a>
        <?php
            if(isset($_GET['addWork']))
            {
                echo "<div class='alert alert-success'>Vous avez bien ajouté une oeuvre à la base de données</div>";
            }

            if(isset($_GET['workUpdate']))
            {
                echo "<div class='alert alert-warning'>Vous avez bien modifié l'oeuvre n°".$_GET['workUpdate']."</div>";
            }

            if(isset($_GET['deleteSuccess']))
            {
                echo "<div class='alert alert-danger'>Vous avez bien supprimé l'oeuvre n°".$_GET['deleteSuccess']."</div>";
            }
        ?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Titre</th>
                    <th>Logiciel utilisé</th>
                    <th>Catégorie</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                      $myWorks = $bdd->query("SELECT * FROM oeuvres");
                       while($donWork = $myWorks->fetch())
                       {
                            echo "<tr>";    
                                echo "<td>".$donWork['id']."</td>";
                                echo "<td>".$donWork['titre']."</td>";
                                echo "<td>".$donWork['logiciel']."</td>";
                                echo "<td>".$donWork['categorie']."</td>";
                                echo "<td>";
                                    echo "<a href='workUpdate.php?id=".$donWork['id']."' class='btn btn-warning mx-2'>Modifier</a>";
                                    echo "<a href='works.php?delete=".$donWork['id']."' class='btn btn-danger mx-2'>Supprimer</a>";
                                echo "</td>";
                            echo "</tr>";
                       }
                       $myWorks->closeCursor();

                ?>
            </tbody>
        </table>
    </div>    
</body>
</html>