
<?php
session_start(); // demarre la session


require_once '../vendor/autoload.php';
require_once '../dao/ConnexionBdd.php';
//connection BDD
$cnx = ConnexionBdd::getConnexion();
// TWIG
$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader);

// afficherAccueil();
//test $_GET et POST, et on les mets dans une variable
$action=null;
if (isset($_GET['action'])) {
    $action=$_GET['action'];
}
if (isset($_POST['action'])) {
    $action=$_POST['action'];
}
//détermine la valeur de action et appelle le traitement correspondant
switch ($action){
    case NULL:
        afficherAccueil();
    break;
    // Rubriques
    case "listerRubriques":
        afficherRubriques();
    break;
    case "ajouterRubrique":
        ajouterRubrique();
    break;
    case "modifierRubrique":
        modifierRubrique();
    break;
    // Utilisateurs
    case "inscrireUtilisateur":
        inscrireUtilisateur();
    break;
    case "identifierUtilisateur":
        identifierUtilisateur();
    break;
    case "deconnecterUtilisateur":
        session_destroy();
        afficherAccueil();
    break;
    // Annonces

    case "listerAnnonces": // par rubrique
        listerAnnonces($_GET['idRub']);
    break;
    
    case "publierAnnonce":
        publierAnnonce();
    break;
    case "listerAnnoncesUtilisateur":
        listerAnnoncesUtilisateur();
    break;
    case "afficherDetailAnnonce": // pour visiteurs
        afficherDetailAnnonce($_GET['idAnnonce']);
    break;
}
/***********************************************************************
 * afficher accueil  //OK
 */
function afficherAccueil(){
    $url=$_SERVER['PHP_SELF'];
    $loader = new \Twig\Loader\FilesystemLoader('../templates');
    $twig = new \Twig\Environment($loader);

    // Affichage des rubriques
    // J'instancie le MySQLRubriqueDAO
    require_once '../dao/MySQLRubriqueDAO.php';
    require_once '../domain/Rubrique.php';
    $dao = new MySQLRubriqueDAO();
    //tableau des rubriques
    $ru=$dao->getAll();
    if (!isset($_SESSION["username"])){
        echo $twig->render('base.html.twig',['url'=> $url,'rubriques'=> $ru]);
    }
    else {
        echo $twig->render('base.html.twig',['pseudo'=>$_SESSION["username"],'url'=> $url,'rubriques'=> $ru]);
    }
}
    
/********************************************************************* 
 *   Afficher rubriques  //OK
 */
function afficherRubriques(){
    $url=$_SERVER['PHP_SELF'];
    $loader = new \Twig\Loader\FilesystemLoader('../templates');
    $twig = new \Twig\Environment($loader);

    // J'instancie le MySQLRubriqueDAO
    require_once '../dao/MySQLRubriqueDAO.php';
    require_once '../domain/Rubrique.php';

    $dao = new MySQLRubriqueDAO();

    //tableau des rubriques
    $rubs=$dao->getAll();
    //afficher la vue + listerRubrique
    echo $twig->render('base.html.twig', ['pseudo'=>$_SESSION["username"],'rubriques'=> $rubs]);
}

/************************************************************************* 
 *   Ajouter rubriques  //OK
 */
function ajouterRubrique(){
    $url=$_SERVER['PHP_SELF'];
    $loader = new \Twig\Loader\FilesystemLoader('../templates');
    $twig = new \Twig\Environment($loader);

     //j'inclue mon dao/MySQLRubriqueDAO et domain/Rubrique.php
    require_once '../dao/MySQLRubriqueDAO.php';
    require_once '../domain/Rubrique.php';

        //j'instancie Rubrique
        $dao = new  MySQLRubriqueDAO();
        //tableau des rubriques
        $rubs=$dao->getAll();

    if (!isset($_POST['libelle'])){  //Cas 1- si la variable $_POST n'est pas positionnée

        //j'inclue la vue ajouterRubrique 
        echo $twig->render('VueAjouterRubrique.html.twig', ['rubriques'=> $rubs,'pseudo'=>$_SESSION["username"]]);
        
    } else{
         //Cas 2- si la variable $_POST est positionnée
        //j'appelle insert() en lui passant le libellé récupéré par POST
         $nouvRub = new Rubrique($_POST['libelle']);
         $lastid=$dao->insert($nouvRub);
         $rubs=$dao->getAll();
        echo $twig->render('VueAjouterRubrique.html.twig', ['pseudo'=>$_SESSION["username"], 'rubriques'=> $rubs]);
        echo 'Rubrique ajoutée avec succes';

    }
}

/************************************************************************* 
 *   Modifier rubrique
 */
function modifierRubrique(){
    $url=$_SERVER['PHP_SELF'];
    $loader = new \Twig\Loader\FilesystemLoader('../templates');
    $twig = new \Twig\Environment($loader);

    //j'inclue mon dao/MySQLRubriqueDAO et domain/Rubrique.php
    require_once '../dao/MySQLRubriqueDAO.php';
    require_once '../domain/Rubrique.php';

    //j'instancie Rubrique
    $dao = new  MySQLRubriqueDAO();
    //tableau des rubriques
    $rubs=$dao->getAll();

    $u=new Rubrique('Location');
    $rub=$dao->update($u);

    if (!isset($_SESSION["username"])){
        echo $twig->render('VueDetailAnnonce.html.twig',['url'=> $url,'rubriques'=> $ru, 'annonce'=>$a]);
    }
    else{
        echo $twig->render('VueDetailAnnonce.html.twig',['pseudo'=>$_SESSION["username"],'url'=> $url,'rubriques'=> $ru, 'annonce'=>$a]);
    }


}

/*************************************************************************
 * supprimer rubrique
 */


/************************************************************************ 
 *   Inscrire Utilisateur  // ok
 */
function inscrireUtilisateur(){
    $url=$_SERVER['PHP_SELF'];
    $loader = new \Twig\Loader\FilesystemLoader('../templates');
    $twig = new \Twig\Environment($loader);

    // Affichage des rubriques
    // J'instancie le MySQLRubriqueDAO
    require_once '../dao/MySQLRubriqueDAO.php';
    require_once '../domain/Rubrique.php';
    $dao = new MySQLRubriqueDAO();
    //tableau des rubriques
    $ru=$dao->getAll();

    //Cas 1 - Utilisateur non inscrit (vérification d'un email existant)
    if (!isset($_POST['email'])){  
        //j'inclue la vueInscrireUtilisateur + listerRubrique
        echo $twig->render('VueInscrireUtilisateur.html.twig',['rubriques'=> $ru]);

    } else {  //Cas 2
        //j'inclue mon dao/MySQLUtilisateurDAO et domain/Utilisateur.php
        require_once '../dao/MySQLUtilisateurDAO.php';
        require_once '../domain/Utilisateur.php';

        //j'instancie une inscription Utilisateur
        $dao = new  MySQLUtilisateurDAO();

        //j'appelle ajouter() en lui passant le libellé récupéré par POST
        
        $nouvelUtilisateur = new Utilisateur($_POST['nom'],$_POST['prenom'], $_POST['email'], $_POST['username'], $_POST['mdp']);
        $newUtilisateur=$dao->insert($nouvelUtilisateur);
        if (!empty($newUtilisateur)){
            echo ('<br> Inscription réussie , bienvenue '.$_POST['username']);
            echo $twig->render ('VueIdentifierUtilisateur.html.twig');
            

        } else {
            echo $twig->render ('VueInscrireUtilisateur.html.twig');
            echo "Il semblerais que cet email soit déjà utilisé";
        }
    }
}

/******************************************************************* 
 *   Identifier Utilisateur  // OK
 */
function identifierUtilisateur(){ 
    $url=$_SERVER['PHP_SELF'];
    $loader = new \Twig\Loader\FilesystemLoader('../templates');
    $twig = new \Twig\Environment($loader);

    // Affichage des rubriques
    // J'instancie le MySQLRubriqueDAO
    require_once '../dao/MySQLRubriqueDAO.php';
    require_once '../domain/Rubrique.php';
    $dao = new MySQLRubriqueDAO();
    //tableau des rubriques
    $ru=$dao->getAll();

        if (!isset($_POST['email'])){  //Cas 1- si $_POST[email] n'est pas positionnée
            //j'affiche le formulaire d'identification
                echo $twig->render('VueIdentifierUtilisateur.html.twig',['rubriques'=> $ru]);
            
        } 
        else{  //Cas 2- si la variable $_POST[email] est positionnée
            
            // j'inclue dao/MySQLUtilisateur + domain
            require_once '../dao/MySQLUtilisateurDAO.php';
            require_once '../domain/Utilisateur.php';

            //j'instancie une connexion Utilisateur
            $dao = new  MySQLUtilisateurDAO();
            $u = new Utilisateur('','',$_POST['email'],$_POST['username'], $_POST['mdp']);
            $retour=$dao->identifier($u);
            
            if (!empty($retour)){ 
                 //Si identification réussie , mettre les données en session
                $_SESSION["username"]=$_POST['username'];
                $_SESSION["idUser"]= $retour -> getID();
            
                echo $twig->render ('VueAccueil.html.twig', ['pseudo'=>$_SESSION["username"],'rubriques'=> $ru]); 

            } else {
            echo $twig->render ('VueIdentifierUtilisateur.html.twig'); 
            echo "Email, Pseudo ou mot de passe inconnus";
                
            }
        }
    }

/*************************************************************************
 * publierannonce
 */
function publierAnnonce(){
    $url=$_SERVER['PHP_SELF'];
    $loader = new \Twig\Loader\FilesystemLoader('../templates');
    $twig = new \Twig\Environment($loader);

     // Affichage des rubriques
    // J'instancie le MySQLRubriqueDAO
    require_once '../dao/MySQLRubriqueDAO.php';
    require_once '../domain/Rubrique.php';
    $rubdao = new MySQLRubriqueDAO();
    //tableau des rubriques
    $ru=$rubdao->getAll();

    if(empty($_POST)){
    //affiche la page publier annonce
    echo $twig->render ('VuePublierAnnonce.html.twig',['rubriques'=> $ru, 'pseudo'=>$_SESSION["username"]]);
    }
    else{

     // j'inclue dao/MySQLUtilisateur + domain
     require_once '../dao/MySQLUtilisateurDAO.php';
     require_once '../domain/Utilisateur.php';
    // J'instancie le MySQLAnnonceDAO 
    require_once '../dao/MySQLAnnonceDAO.php';
    require_once '../domain/Annonce.php';
    // Affichage des rubriques
    // J'instancie le MySQLRubriqueDAO
    require_once '../dao/MySQLRubriqueDAO.php';
    require_once '../domain/Rubrique.php';
    $annonceDAO= new MySQLAnnonceDAO();


    $pseudo = $_SESSION["username"];
    $da=null;
    $db=null;
    $r=new Rubrique('',$_POST["select"]);
    $u=new Utilisateur ('','','','','','',$_SESSION["idUser"]);
    $a=new Annonce($_POST['entete'], $_POST['corp'], $da,$db, $r, $u);
    $annonce=$annonceDAO->insert($a);
}

    if ($annonce != null){
        echo("Annonce crée avec succès\n");
        echo $twig->render ('VueListerAnnoncesUtilisateur.html.twig',['rubriques'=> $ru, 'pseudo'=>$_SESSION["username"], 'annonces'=>$a]);
        
    }
    else{
        echo $twig->render ('VuePublierAnnonces.html.twig');
        echo("oups ....  \n");
    }
}

/*************************************************************************
 * Lister Annonce page accueil
 */

/*************************************************************************
 * Lister Annonce par rubrique
 */
function listerAnnonces($idRub){
    $url=$_SERVER['PHP_SELF'];
    $loader = new \Twig\Loader\FilesystemLoader('../templates');
    $twig = new \Twig\Environment($loader);

    // J'instancie le MySQLAnnonceDAO + rubrique
    require_once '../dao/MySQLAnnonceDAO.php';
    require_once '../domain/Annonce.php';
    // Affichage des rubriques
    // J'instancie le MySQLRubriqueDAO
    require_once '../dao/MySQLRubriqueDAO.php';
    require_once '../domain/Rubrique.php';
    $listerubdao = new MySQLRubriqueDAO();
    //tableau des rubriques
    $ru=$listerubdao->getAll();
    $annoncedao = new MySQLAnnonceDAO();
    $rub = new rubrique('',$idRub);
    //tableau des rubriquesannonces par rubrique
    $a=$annoncedao->getByCategory($rub);
    //afficher la vue + listerAnnonce
    echo $twig->render('VueListerAnnonce.html.twig',['rubriques'=> $ru, 'pseudo'=>$_SESSION["username"], 'annonces'=>$a]);
}

/*************************************************************************
 * Lister annonce utilisateur
 */ 
function listerAnnoncesUtilisateur(){
    $url=$_SERVER['PHP_SELF'];
    $loader = new \Twig\Loader\FilesystemLoader('../templates');
    $twig = new \Twig\Environment($loader);


    // Affichage des rubriques
    // J'instancie le MySQLRubriqueDAO
    require_once '../dao/MySQLRubriqueDAO.php';
    require_once '../domain/Rubrique.php';
    $rubdao = new MySQLRubriqueDAO();
    //tableau des rubriques
    $ru=$rubdao->getAll();

    // J'instancie le MySQLAnnonceDAO 
    require_once '../dao/MySQLAnnonceDAO.php';
    require_once '../domain/Annonce.php';
    $annoncesdao = new MySQLAnnonceDAO();
    
    //tableau des annonces utilisateur
    require_once '../dao/MySQLUtilisateurDAO.php';
    require_once '../domain/Utilisateur.php';
    $u=new Utilisateur ('','','','','','',$_SESSION["idUser"]);
    $a=$annoncesdao->getByUser($u);

    if(empty($_POST)){
        //affiche la page publier annonce
        echo $twig->render ('VuelisterAnnoncesUtilisateur.html.twig',['rubriques'=> $ru, 'pseudo'=>$_SESSION["username"], 'annonces'=>$a, 'redacteur'=>$u]);
        }
    else{
    }
}

/*************************************************************************
 * afficher détail  annonce 
 */
function afficherDetailAnnonce($idAnnonce){
    $url=$_SERVER['PHP_SELF'];
    $loader = new \Twig\Loader\FilesystemLoader('../templates');
    $twig = new \Twig\Environment($loader);

    // Affichage des rubriques
    // J'instancie le MySQLRubriqueDAO
    require_once '../dao/MySQLRubriqueDAO.php';
    require_once '../domain/Rubrique.php';
    $rubdao = new MySQLRubriqueDAO();
    //tableau des rubriques
    $ru=$rubdao->getAll();

    // J'instancie le MySQLAnnonceDAO 
    require_once '../dao/MySQLAnnonceDAO.php';
    require_once '../domain/Annonce.php';
    $annoncedao = new MySQLAnnonceDAO();

    require_once '../dao/MySQLUtilisateurDAO.php';
    require_once '../domain/Utilisateur.php';
    $u=new Utilisateur ('','','','','','',$_SESSION["idUser"]);
    $a=$annoncedao->getByIdAnnonce($idAnnonce);

    if (!isset($_SESSION["username"])){
        echo $twig->render('VueDetailAnnonce.html.twig',['url'=> $url,'rubriques'=> $ru, 'annonce'=>$a]);
    }
    else {
        echo $twig->render('VueDetailAnnonce.html.twig',['pseudo'=>$_SESSION["username"],'url'=> $url,'rubriques'=> $ru, 'annonce'=>$a]);
    }
    
}



 /*************************************************************************
 * supprimer Annonce
 */



 