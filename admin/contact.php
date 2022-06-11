<?php
    session_start();
    if(!isset($_SESSION['login'])){
        header("LOCATION:403.php");
    }
    
    require "../connexion.php";

    if(isset($_GET['delete']))
    {
        // vérifier si le message existe 
        $id = htmlspecialchars($_GET['delete']);
        $reqDel = $bdd->prepare("SELECT * FROM contact WHERE id=?");
        $reqDel->execute([$id]);
        if(!$donDel = $reqDel->fetch()){
            $reqDel->closeCursor();
            header("LOCATION:contact.php");
        }
        $reqDel->closeCursor();

        // je supprime 
        $delete = $bdd->prepare("DELETE FROM contact WHERE id=?");
        $delete->execute([$id]);
        $delete->closeCursor();
        header("LOCATION:contact.php?deleteSuccess=".$id);
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
        <h1>Les messages de contact</h1>
        <?php
            if(isset($_GET['deleteSuccess']))
            {
                echo "<div class='alert alert-danger'>Vous avez bien supprimé le message n°".$_GET['deleteSuccess']."</div>"; 
            }
        ?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                      $contact = $bdd->query("SELECT id,nom,email,DATE_FORMAT(date,'%d / %m / %Y %H h %i min') AS myDate FROM contact ORDER BY date DESC");
                      // ORDER BY en SQL permet de classer les données suivant un ordre via un champ de façon DESC ou ASC
                       while($donContact = $contact->fetch())
                       {
                            echo "<tr>";    
                                echo "<td>".$donContact['id']."</td>";
                                echo "<td><a href='contactShow.php?id=".$donContact['id']."'>".$donContact['nom']."</a></td>";
                                echo "<td>".$donContact['email']."</td>";
                                echo "<td>".$donContact['myDate']."</td>";
                                echo "<td>";
                                    echo "<a href='contact.php?delete=".$donContact['id']."' class='btn btn-danger mx-2'> <i class='fa-solid fa-trash'></i> Supprimer</a>";
                                echo "</td>";
                            echo "</tr>";
                       }
                       $contact->closeCursor();

                ?>
            </tbody>
        </table>
    </div>   
    
</body>
</html>