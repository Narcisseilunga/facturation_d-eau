<?php
require_once 'config.php';
// Récupérer les factures non payées
$sql_bills = "SELECT * FROM FACTURES WHERE paye = 0";
$result_bills = $conn->query($sql_bills);

if ($result_bills->num_rows > 0) {
    while ($bill = $result_bills->fetch_assoc()) {
        $user_id = $bill['user_id'];
        $amount = $bill['amount'];
        $month = $bill['month'];

        // Récupérer l'email de l'utilisateur
        $sql_user = "SELECT email FROM ABONNEES WHERE id = $user_id";
        $result_user = $conn->query($sql_user);
        $user = $result_user->fetch_assoc();
        $email = $user['email'];

        // Envoyer l'email
        $subject = "Votre facture d'eau pour le mois de " . date('F Y', strtotime($month));
        $message = "Bonjour,\n\nVotre facture d'eau pour le mois de " . date('F Y', strtotime($month)) . " est de $" . number_format($amount, 2) . ".\n\nVeuillez payer cette facture dès que possible.\n\nCordialement,\nVotre fournisseur d'eau.";
        $headers = "From: no-reply@yourdomain.com";

        mail($email, $subject, $message, $headers);
    }
}

$conn->close();
?>
`