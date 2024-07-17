<?php

// Connexion à la base de données
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
    // Récupération des données POST
    $prenom = $_POST["prenom"] ?? '';
    $nom = $_POST["nom"] ?? '';
    $adresse = $_POST["adresse"] ?? '';
    $adresse_email = $_POST["email"] ?? '';
    $mot_de_passe = $_POST["mot_de_passe"] ?? '';
    $mot_de_passe_conf = $_POST["mot_de_passe_conf"] ?? '';
    $type = "employe";
    // Conversion de la date en chaîne de caractères
    $date_creation = date('Y-m-d H:i:s');

    // Vérifier si l'e-mail existe déjà
    $checkEmail = $conn->prepare("SELECT * FROM utilisateurs WHERE email = :email");
    $checkEmail->bindParam(':email', $adresse_email);
    $checkEmail->execute();
    if ($checkEmail->rowCount() > 0) {
        echo 'Erreur : L\'adresse e-mail existe déjà.';
    } else {
        if ($mot_de_passe !== $mot_de_passe_conf) {
            echo 'Erreur, veuillez réessayer ! Le mot de passe d\'utilisateur doit correspondre au mot de passe de confirmation.';
        } else {
            // Préparation de la requête SQL
            $sql = "INSERT INTO utilisateurs (prenom, nom, adresse, email, mot_de_passe, date_creation, type_mode) VALUES (:prenom, :nom, :adresse, :email, :mot_de_passe, :date_creation, :type_mode)";
            $stmt = $conn->prepare($sql);

            // Liaison des paramètres
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':adresse', $adresse);
            $stmt->bindParam(':email', $adresse_email);
            $stmt->bindParam(':mot_de_passe', $mot_de_passe);
            $stmt->bindParam(':date_creation', $date_creation);
            $stmt->bindParam(':type_mode', $type);

            // Exécution de la requête préparée
            $stmt->execute();
            echo 'Utilisateur enregistré avec succès';
            header("Location: register_admin.php");       
            exit; 
        }
    }
} else {
    echo 'Méthode de requête non autorisée';
}

?>
