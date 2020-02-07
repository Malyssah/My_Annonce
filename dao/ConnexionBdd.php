<?php 
/** Classe ConnexionBdd */

class ConnexionBdd{
    private static $cnx;

    // Singleton pour connecter db.
    private static $instance = null;

    
    // La connexion à la base de données est établie dans le constructeur.
    private function __construct()
    {
        $host = '127.0.0.1';
        $db   = 'annonces';
        $user = 'root';
        $pass = '';
		$charset = 'utf8';
		
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,
            PDO::ATTR_EMULATE_PREPARES   => false,
            ];
        try {
            self::$cnx = new PDO($dsn, $user, $pass, $options);
        } 
        catch (PDOException $e) {
			echo ("erreur de connexion");
        }
    }
    
    public static function getConnexion(){
    	if(!self::$instance){
        	self::$instance = new ConnexionBdd();
    	}
    	return self::$cnx;
    }
}
