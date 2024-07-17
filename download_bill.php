<?php
require('vendor/autoload.php');

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion-eau";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

$id = 1;

// Récupérer les informations de facturation
$sql = "SELECT * FROM paiements WHERE id_facture = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$bill = $result->fetch_assoc();

if (!$bill) {
    die("Facture non trouvée.");
}

// Créer un nouveau PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Ajouter le contenu de la facture
$pdf->Cell(40, 10, 'Facture d\'eau');
$pdf->Ln();
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 10, 'Numero de facture: ' . $bill['id_facture']);
$pdf->Ln();
$pdf->Cell(40, 10, 'Nom du client: ' . $bill['nom']);
$pdf->Ln();
$pdf->Cell(40, 10, 'Adresse: ' . $bill['address']);
$pdf->Ln();
$pdf->Cell(40, 10, 'Periode de facturation: ' . $bill['date_paiement']);
$pdf->Ln();
$pdf->Cell(40, 10, 'Consommation d\'eau: ' . $bill['conso'] . ' m³');
$pdf->Ln();
$pdf->Cell(40, 10, 'Montant a payer: ' . $bill['montant'] . ' €');

// Envoyer le PDF au navigateur pour téléchargement
$pdf->Output('D', 'facture_' . $bill['id_facture'] . '.pdf');

// Fermer la connexion à la base de données
$stmt->close();
$conn->close();
?>