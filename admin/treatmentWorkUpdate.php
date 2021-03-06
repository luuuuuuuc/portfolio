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

    if(isset($_POST['titre']))
    {
        $err=0;
        if(empty($_POST['titre']))
        {
            $err=1;
        }else{
            $titre=htmlspecialchars($_POST['titre']);
        }
        if(empty($_POST['description']))
        {
            $err=2;
        }else{
            $description=$_POST['description'];
        }
        if(empty($_POST['logiciel']))
        {
            $err=3;
        }else{
            $logiciel=htmlspecialchars($_POST['logiciel']);
        }

        if(empty($_POST['categorie']))
        {
            $err=4;
        }else{
            $categorie=htmlspecialchars($_POST['categorie']);
        }

        if($err==0)
        {
           if(empty($_FILES['image']['tmp_name']))
           {

                $update = $bdd->prepare("UPDATE oeuvres SET titre=:titre, description=:description, logiciel=:logiciel, categorie=:categorie WHERE id=:id");
                $update->execute([
                    ":titre"=>$titre,
                    ":description"=>$description,
                    ":logiciel"=>$logiciel,
                    ":categorie"=>$categorie,
                    ":id"=>$id
                ]);
                $update->closeCursor();
                // redirection vers le tableau des voitures
                header("LOCATION:works.php?workUpdate=".$id);

           }else{

           
            $dossier = '../images/';
            $fichier = basename($_FILES['image']['name']);
            $taille_maxi = 800000;
            $taille = filesize($_FILES['image']['tmp_name']);
            $extensions = ['.png', '.gif', '.jpg', '.jpeg'];
            $extension = strrchr($_FILES['image']['name'], '.');

            if(!in_array($extension,$extensions)){
                $imgError = 2; // probl??me au niveau de l'extension
            }

            if($taille>$taille_maxi)
            {
                $imgError = 3; // probl??me pour la taille du fichier
            }

            // v??rif si prob avec  le fichier envoy??
            if(isset($imgError))
            {
                header("LOCATION:workUpdate.php?id=".$id."&imgerror=".$imgError);
            }else{
                //  pas de probl??me donc on va essayer de le d??placer et g??rer la syntaxe du nom de fichier
                //On formate le nom du fichier, strtr remplace tous les KK sp??ciaux en normaux suivant notre liste
                $fichier = strtr($fichier,
                '????????????????????????????????????????????????????????????????????????????????????????????????????????',
                'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier); // preg_replace remplace tout ce qui n'est pas un KK normal en tiret

                // gestion des conflits 

                $fichiercpt = rand().$fichier;

                // d??placement du fichier dans le bon dossier avec le bon nom
                if(move_uploaded_file($_FILES['image']['tmp_name'], $dossier.$fichiercpt))
                {
                    unlink("../images/".$don['images']);
                    // insertion ?? la base de donn??es 
                    $update = $bdd->prepare("UPDATE oeuvres SET titre=:titre, images=:image, description=:description, logiciel=:logiciel, categorie=:categorie WHERE id=:id");
                    $update->execute([
                        ":titre"=>$titre,
                        ":description"=>$description,
                        ":logiciel"=>$logiciel,
                        ":categorie"=>$categorie,
                        ":image"=>$fichiercpt,
                        ":id"=>$id
                    ]);
                    $update->closeCursor();
                    // redirection vers le tableau des voitures
                    header("LOCATION:works.php?workUpdate=".$id);
                    
                }else{
                    header("LOCATION:workUpdate.php?id=".$id."&imgerror=4");
                }

            }
           }

        }else{
            header("LOCATION:workUpdate.php?id=".$id."&error=".$err);
        }
    }else{
        header("LOCATION:workUpdate.php?id=".$id);
    }