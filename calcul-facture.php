<?php
require_once 'config.php';
// Définir le tarif de l'eau par litre
$tarif_par_litre = 1; // Par exemple, 0.002 dollars par litre

// Récupérer tous les utilisateurs
$sql_users = "SELECT * FROM ABONNEES";
$result_users = $conn->query($sql_users);

if ($result_users->num_rows > 0) {
    while ($user = $result_users->fetch_assoc()) {
        $user_id = $user['id'];
        
        // Calculer la consommation totale pour le mois en cours
        $sql_volume = "SELECT SUM(volume) as total_volume FROM LECTURES WHERE capteur_id IN (SELECT capteur_id FROM CAPTEURS WHERE utilisateur_id = $user_id) AND MONTH(timestamp) = MONTH(CURRENT_DATE()) AND YEAR(timestamp) = YEAR(CURRENT_DATE())";
        $result_volume = $conn->query($sql_volume);
        $row_volume = $result_volume->fetch_assoc();
        $total_volume = $row_volume['total_volume'];

        // Calculer le montant de la facture
        $amount = $total_volume * $tarif_par_litre;

        // Insérer la facture dans la table bills
        $month = date('Y-m-01');
        $sql_bill = "INSERT INTO FACTURES (user_id, month, volume, amount, paid, created_at) VALUES ($user_id, '$month', $total_volume, $amount, 0, NOW())";
        $conn->query($sql_bill);
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Consommation d'eau</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Consommation d'eau</h1>
    <canvas id="myWaterChart"></canvas>

    <?php
    // Données de consommation d'eau (exemple)
    $water_consumption = array(
        array('Janvier', 100),
        array('Février', 150),
        array('Mars', 120),
        array('Avril', 180),
        array('Mai', 160),
        array('Juin', 190),
        array('Juillet', 220),
        array('Août', 180),
        array('Septembre', 150),
        array('Octobre', 130),
        array('Novembre', 110),
        array('Décembre', 100)
    );

    // Préparer les données pour le graphique
    $labels = array();
    $data = array();
    foreach ($water_consumption as $entry) {
        $labels[] = $entry[0];
        $data[] = $entry[1];
    }
    ?>

    <script>
        // Configurer le graphique
        var ctx = document.getElementById('myWaterChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Consommation d\'eau (m³)',
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value, index, ticks) {
                                return value + ' m³';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
