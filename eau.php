<?php
require_once 'config.php';

// Récupérer les données envoyées par Arduino
if(!isset($_POST)) die("aucune dTATA");
$capteur_id = $_POST['capteur_id'];
$debit = $_POST['debit'];
$volume = $_POST['volume'];
$timestamp = date('Y-m-d H:i:s');


$requete = "SELECT COUNT(*) FROM $nom_table";
$resultat = $conn->query($requete);

if ($resultat->num_rows > 0) {
    // La table contient des enregistrements
    // Faites ce que vous devez faire ici
    echo "La table contient des enregistrements.";
    //mettre à jour les élément de la table lecture 
    $sql = "UPDATE LECTURES SET horodatage = '$timestamp', debit = '$debit', volume = '$volume' WHERE identifiant_capteur = '$capteur_id'";

    
} else {
    // La table est vide
    // Faites ce que vous devez faire ici
    echo "La table est vide.";
    // Insérer les données dans la table readings
    $sql = "INSERT INTO LECTURES (identifiant_capteur, horodatage, debit, volume) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdd", $capteur_id, $timestamp, $debit, $volume);
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Consommation d'eau du compte <?php echo $capteur_id;?></title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<h1>Consommation liée à l'utilisateur</h1>
    <canvas id="myPieChart"></canvas>
<script>
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Debit", "Volume"],
    datasets: [{
      data: [<?php echo $debit; ?>, <?php echo $volume; ?>],
      backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
      hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});
</script>
</body>
</html>