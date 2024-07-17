<?php require_once 'config.php'; 
session_start();
// Récupérer l'ID de l'utilisateur depuis la session
$user_id = $_SESSION['id_utilisateur']; 
// Récupérer les factures de l'utilisateur 
$sql_bills = "SELECT * FROM FACTURES WHERE id_utilisateur = ?"; 
$stmt = $conn->prepare($sql_bills); $stmt->bind_param("i", $user_id); 
$stmt->execute(); $result_bills = $stmt->get_result();
// Tableau pour stocker la consommation d'eau par mois 
$water_consumption = array(); if ($result_bills->num_rows > 0)
 { while ($bill = $result_bills->fetch_assoc())
  { $month = date('n', strtotime($bill['month']));
   $volume = $bill['volume'];
// Vérifier si le mois existe déjà dans le tableau
 $found = false; for ($i = 0; $i < count($water_consumption); $i++)
  { if ($water_consumption[$i][0] == date('F', mktime(0, 0, 0, $month, 1)))
   { $water_consumption[$i][1] += $volume; $found = true; break; } } 
// Si le mois n'existe pas encore, l'ajouter au tableau if (!$found) 
{ $water_consumption[] = array( date('F', mktime(0, 0, 0, $month, 1)), $volume ); } } } 
$stmt->close(); $conn->close(); 
 $title = "Consommation d'eau";
 $lien_js = '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
 echo $lien_js;
 require_once 'header.php';?>
 <div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Rapport de Consommation d'eau Pour Mr <?php echo $_SESSION['prenom'] ." ". $_SESSION['nom'];?></h1>
</div>

<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Debit actuelle</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Annual) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Volume actuelle</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Consommation 
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar"
                                        style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

<h1>Consommation d'eau</h1>
<canvas id="myWaterChart"></canvas>
  </div>
<script>
    // Préparer les données pour le graphique
    var labels = [];
    var data = [];
    <?php
    foreach ($water_consumption as $entry) {
        echo "labels.push('" . $entry[0] . "');";
        echo "data.push(" . $entry[1] . ");";
    }
    ?>

    // Configurer le graphique
    var ctx = document.getElementById('myWaterChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Consommation d\'eau (m³)',
                data: data,
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
</div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
        <?php require_once 'footer.php'; ?>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    
</body>
</html>