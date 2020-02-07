<?php

//A supprimer ( reste en model pour le moment)
//connection
require_once 'dao/ConnexionBdd.php';
require_once 'dao/MySQLUtilisateurDAO.php';
require_once 'dao/MySQLRubriqueDAO.php';
require_once 'dao/MySQLAnnonceDAO.php';
require_once 'dao/UtilisateurDAO.php';
require_once 'dao/RubriqueDAO.php';
require_once 'dao/AnnonceDAO.php';
require_once 'domain/Utilisateur.php';
require_once 'domain/Rubrique.php';
require_once 'domain/Annonce.php';

//connexion à la BDD `annonces`
$cnx = ConnexionBdd::getConnexion();

 echo '======= Rubrique =======';
 echo "\n";
 // dao
 $dao = new MySQLRubriqueDAO();

 echo '----- Liste -----';
 echo "\n";
 $ru=$dao->getAll();
 if ($ru!= null){
     foreach($ru as $ru){
         echo($ru."\n");
     }
 }
//**jusque là c bon**
echo "\n";
echo '----- Inserer -----';
echo "\n";
//  $u=new Rubrique('A DELETE');
//  $rub=$dao->insert($u);
//      if ($rub != null){
//          echo($rub." est inséré\n");
//      }
//      else{
//          echo("0 ligne insérée\n");
//    }
//**jusque là c bon**
echo "\n";
echo '----- Delete -----';
echo "\n";
//  $u=new Rubrique('A DELETE', 7);
//  $rub=$dao->delete($u);
//      if ($rub = $u){
//          echo($rub." est supprimée\n");
//      }
//      else{
//          echo("suppression échouée\n");
//      }

echo "\n";
echo '----- Update -----';
echo "\n";
// $u=new Rubrique('Location', 6);
// $rub=$dao->update($u);
// echo($u." à bien été modifiée en " . $rub . "\n");

 echo "\n";
 echo '======= Utilisateurs =======';
 echo "\n";
 // dao
 $dao = new MySQLUtilisateurDAO();

echo '----- Liste -----';
echo "\n";
$ut=$dao->getAll();
if ($ut!= null){
    foreach($ut as $ut){
        echo($ut."\n");
    }
}
echo "\n";
echo '----- Inserer -----';
echo "\n";

// $u=new Utilisateur('Dora', 'Dora'); 
// $utilisateur=$dao->insert($u);
//     if ($utilisateur != null){
//         echo($utilisateur." est inséré\n");
//     }
//     else{
//         echo("0 ligne insérée\n");
//   } 
  
echo "\n";
echo '======= Annonce =======';
echo "\n";
// // dao
$dao = new MySQLAnnonceDAO();
// echo '----- Liste -----';
echo "\n";

echo "\n";
echo '----- Inserer -----';
echo "\n";
// $da=new Datetime("now");
// $db=new Datetime("now");
// $r=new Rubrique("ccc",3);
// $u=new Utilisateur ('aaa','bbb' ,3);
// $a=new Annonce('Sac à dos', 'Il chante ... sac à dos sac à dos ... ', $da,$db, $r, $u);
// $a1=$dao->insert($a);
// if ($a1 != null){
//     echo("1 ligne inséré\n");
// }
// else{
//     echo("0 ligne insérée\n");
// }

?>