<?php
    session_start();
    if(!isset($_SESSION['login'])){
        header("LOCATION:403.php");
    }
    
    require "../connexion.php";

    if(isset($_GET['delete']))
    {
        $id=htmlspecialchars($_GET['delete']);

        $skill = $bdd->prepare("SELECT * FROM competence WHERE id=?");
        $skill->execute([$id]);
        if(!$donSkill = $skill->fetch())
        {
            $skill->closeCursor();
            header("LOCATION:404.php");
        }
        $skill->closeCursor();

        unlink("../images/".$donSkill['image']);
      
        $deleteSkill = $bdd->prepare("DELETE FROM competence WHERE id=?");
        $deleteSkill->execute([$id]);
        $deleteSkill->closeCursor();

        header("LOCATION:skills.php?deleteSuccess=".$id);

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
        <h1>Mes compétences</h1>
        <a href="skillAdd.php" class="btn btn-primary">Ajouter</a>
        <?php
            if(isset($_GET['addSkill']))
            {
                echo "<div class='alert alert-success'>Vous avez bien ajouté une compétence à la base de données</div>";
            }

            if(isset($_GET['skillUpdate']))
            {
                echo "<div class='alert alert-warning'>Vous avez bien modifié la compétence n°".$_GET['skillUpdate']."</div>";
            }

            if(isset($_GET['deleteSuccess']))
            {
                echo "<div class='alert alert-danger'>Vous avez bien supprimé la compétence n°".$_GET['deleteSuccess']."</div>";
            }
        ?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Comptétences</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                      $skills = $bdd->query("SELECT * FROM competence");
                       while($donSkills = $skills->fetch())
                       {
                            echo "<tr>";    
                                echo "<td>".$donSkills['id']."</td>";
                                echo "<td><img src='../images/".$donSkills['image']."' class='mini-img' alt='skill'></td>";
                                echo "<td>";
                                    echo "<a href='skillUpdate.php?id=".$donSkills['id']."' class='btn btn-warning mx-2'>Modifier</a>";
                                    echo "<a href='skills.php?delete=".$donSkills['id']."' class='btn btn-danger mx-2'>Supprimer</a>";
                                echo "</td>";
                            echo "</tr>";
                       }
                       $skills->closeCursor();

                ?>
            </tbody>
        </table>
    </div>    
</body>
</html>