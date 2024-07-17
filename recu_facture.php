<?php
session_start();
$title = "Facture";
require_once 'header.php';
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion-eau";

$conn = new mysqli($servername, $username, $password, $dbname);
echo $_SESSION['id_utilisateur'];
// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Récupérer les informations de facturation
$sql = "SELECT * FROM paiements WHERE id_facture = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id);
$customer_id = "1"; // Remplacer par l'ID du client
$stmt->execute();
$result = $stmt->get_result();
$bill = $result->fetch_assoc();

// Afficher l'interface web
?>

<!DOCTYPE html>
<html>
<head>
    <title>Facture d'eau</title>
    <!-- Inclure le CDN de Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h1 class="card-title">Facture d'eau</h1>
            </div>
            <div class="card-body">
                <p><strong>Numero de facture :</strong> <?php echo $bill['id_facture']; ?></p>
                <p><strong>Nom du client :</strong> <?php echo $bill['nom']; ?></p>
                <p><strong>Adresse :</strong> <?php echo $bill['address']; ?></p>
                <p><strong>Période de facturation :</strong> <?php echo $bill['date_paiement']; ?></p>
                <p><strong>Consommation d'eau :</strong> <?php echo $bill['conso']; ?> m³</p>
                <p><strong>Montant à payer :</strong> <?php echo $bill['montant']; ?> €</p>
            </div>
            <div class="card-footer">
                <!-- Bouton de téléchargement -->
                <a href="download_bill.php?id=<?php echo $bill['id']; ?>" class="btn btn-success">Télécharger la facture</a>
            </div>
        </div>
    </div>

    <!-- Inclure les scripts JavaScript de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Fermer la connexion à la base de données
$stmt->close();
$conn->close();
?>