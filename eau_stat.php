<?php require_once 'config.php';
 // Récupérer le nombre de volume et de débit depuis la table "LECTURE"
  $sql_count = "SELECT COUNT(volume) AS volume_count, COUNT(debit) AS debit_count FROM lectures";
  $result_count = $conn->query($sql_count);
 // Préparer les données pour le graphique
  $labels = array(); $volume_data = array(); $debit_data = array();
   if ($result_count->num_rows > 0) {
     $row = $result_count->fetch_assoc();
     $volume_data = $row['volume_count'];
     $debit_data = $row['debit_count']; } 
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

    <script>
        // Configurer le graphique
        var ctx = document.getElementById('myWaterChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Volume (m³)',
                    data: <?php echo json_encode($volume_data); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'Débit',
                    data: <?php echo json_encode($debit_data); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
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
