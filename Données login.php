<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion-eau";

try {
    // Utilisation de PDO pour se connecter à la base de données
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Configuration des attributs PDO pour gérer les erreurs
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "La connexion est bien établie ";
} catch (PDOException $e) {
    echo "La connexion a échoué: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adresse_email = isset($_POST["email"]) ? $_POST["email"] : '';
    $mot_de_passe = isset($_POST["mot_de_passe"]) ? $_POST["mot_de_passe"] : '';
    $erreur = '';
    
    if(!empty($adresse_email) && !empty($mot_de_passe)){
        // Préparation de la requête SQL pour éviter les injections SQL
        $req = $conn->prepare("SELECT * FROM utilisateurs WHERE email = :email AND mot_de_passe = :mot_de_passe");
        $req->execute(array(':email' => $adresse_email, ':mot_de_passe' => $mot_de_passe));
        $rep = $req->fetch();
        
        // Vérification si un utilisateur correspond aux identifiants
        if($rep && $rep['id']){
            // Ouverture de la session
            session_start();
            $_SESSION['id_utilisateur'] = $rep['id'];
            $_SESSION['prenom'] = $rep['prenom'];
            $_SESSION['nom'] = $rep['nom'];
            echo "le nom de la session est". $_SESSION['id_utilisateur'];
            header("Location:tables.php");
            exit();
        }
        else{
            // Message d'erreur en cas d'identifiants incorrects
           $erreur = "Adresse email ou mot de passe incorrects !";
        }
    }
}
?>