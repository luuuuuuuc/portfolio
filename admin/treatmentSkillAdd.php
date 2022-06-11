<?php
    // securité 
    session_start();
    if(!isset($_SESSION['login'])){
        header("LOCATION:403.php");
    }

    if(isset($_FILES['competence']['tmp_name']))
    {
        $err=0;
       

        if($err==0)
        {

            $dossier = '../images/';
            $fichier = basename($_FILES['competence']['name']);
            $taille_maxi = 800000;
            $taille = filesize($_FILES['competence']['tmp_name']);
            $extensions = ['.png', '.gif', '.jpg', '.jpeg'];
            $extension = strrchr($_FILES['competence']['name'], '.');

            if(!in_array($extension,$extensions)){
                $imgError = 2; // problème au niveau de l'extension
            }

            if($taille>$taille_maxi)
            {
                $imgError = 3; // problème pour la taille du fichier
            }

            // vérif si prob avec  le fichier envoyé
            if(isset($imgError))
            {
                header("LOCATION:skillAdd.php?imgerror=".$imgError);
            }else{
                //  pas de problème donc on va essayer de le déplacer et gérer la syntaxe du nom de fichier
                //On formate le nom du fichier, strtr remplace tous les KK spéciaux en normaux suivant notre liste
                $fichier = strtr($fichier,
                'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
                'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier); // preg_replace remplace tout ce qui n'est pas un KK normal en tiret

                // gestion des conflits 

                $fichiercpt = rand().$fichier;

                // déplacement du fichier dans le bon dossier avec le bon nom
                if(move_uploaded_file($_FILES['competence']['tmp_name'], $dossier.$fichiercpt))
                {
                 
                    require "../connexion.php";
                    // insertion à la base de données 
                    $insert = $bdd->prepare("INSERT INTO competence(image) VALUES(:image)");
                    $insert->execute([
                        ":image"=>$fichiercpt
                    ]);
                    $insert->closeCursor();
                    // redirection vers le tableau des voitures
                    header("LOCATION:skills.php?skillAdd=success");
                    
                }else{
                    header("LOCATION:skillAdd.php?imgerror=4");
                }

            }


               
                    

        }else{
            header("LOCATION:skillAdd.php?error=".$err);
        }
    }else{
        header("LOCATION:skillAdd.php");
    }