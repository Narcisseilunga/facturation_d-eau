<?php
// Activation du rapport d'erreurs pour un meilleur débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);
var_dump($_POST);

// Informations de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion-eau";

try {
    
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "La connexion est bien établie ";
} catch (PDOException $e) {
    
    echo "La connexion a échoué: " . $e->getMessage();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $adresse_email = $_POST["email"] ?? '';
    
    if (!empty($adresse_email)) {
        
        $req = $conn->prepare("SELECT * FROM utilisateurs WHERE email = :email");
        
        $req->bindParam(':email', $adresse_email, PDO::PARAM_STR);
        
        $req->execute();
        
        $rep = $req->fetch(PDO::FETCH_ASSOC);

        if ($rep && $rep['id']) {
            // Génération d'un mot de passe aléatoire avec 6 caractères
            $nouveau_mot_de_passe = substr(md5(uniqid()), 0, 6);

            // Mise à jour du mot de passe dans la base de données
            $req_update = $conn->prepare("UPDATE utilisateurs SET mot_de_passe = :mot_de_passe WHERE id = :id");
            $req_update->bindParam(':mot_de_passe', $nouveau_mot_de_passe, PDO::PARAM_STR);
            $req_update->bindParam(':id', $rep['id'], PDO::PARAM_INT);
            $req_update->execute();

            // Envoi du mot de passe par email
            $sujet = "Nouveau mot de passe";
            $message = "Votre nouveau mot de passe est : " . $nouveau_mot_de_passe;
            $headers = "From: webmaster@example.com";

            if (mail($adresse_email, $sujet, $message, $headers)) {
                echo "Un nouveau mot de passe a été envoyé à votre adresse email.";
            } else {
                echo "Une erreur est survenue lors de l'envoi du mot de passe.";
            }
        } else {
            // Message d'erreur en cas d'adresse email incorrecte
            echo "email incorrect";
        }
    } else {
        // Message d'erreur si l'adresse email est vide
        echo "L'adresse email est requise.";
    }
}
?>