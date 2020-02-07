USE annonces;

/*------------------------*/
/*---------INSERT---------*/
/*------------------------*/

CALL `insert_utilisateur`('Admin','sandrine','admin@mail.fr','Mady','admin',TRUE);
CALL `insert_utilisateur`('Michel','Michel','mimi@mail.fr','Mimi','saucisse',FALSE);
CALL `insert_utilisateur`('Pastour','Patrick','papat@mail.fr','Papate','patate',FALSE);
CALL `insert_utilisateur`('LeGrand','Franklin','tortue@mail.fr','Franklin','tortue',FALSE);
CALL `insert_utilisateur`('Blanc','Lelain','lelain@mail.fr','Blanc','secret',FALSE);
CALL `insert_utilisateur`('Exploratrice','Dora','dora@mail.fr','Dora','Dora',FALSE);

CALL `insert_rubrique`('Maison');
CALL `insert_rubrique`('Véhicules');
CALL `insert_rubrique`('Loisirs');
CALL `insert_rubrique`('Mode');
CALL `insert_rubrique`('Multimédia');
CALL `insert_rubrique`('Animaux');

CALL `insert_annonce`('3','3','Appel à offre pour baies de bonne qualité.','Looooooooongue introduction sur la valeur des baies en société...',CURDATE()-5);
CALL `insert_annonce`('5','2','Jai perdu Sophie','Besoin d aide pour retrouver ma pelle, Sophie',CURDATE()-4);
CALL `insert_annonce`('4','5','Sac à dos !','Il chante ... sac à dos sac à dos ...',CURDATE()-1);
CALL `insert_annonce`('2','2','scooter','il roule  roule .... mais ne freine plus ',CURDATE());

