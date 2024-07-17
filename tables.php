<?php
session_start();
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

$requete = "SELECT * FROM utilisateurs ORDER BY id ASC";
$req = $conn->query($requete);

if (!$req) {
    echo "Erreur: la récupération des données a échoué.";
} else {
    $nbr_utilisqteur = $req->rowCount();
}
?>

<?php 
$title = "Admin 2 tables";
require_once 'header.php';
?>

<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>
    <p class="mb-4">DataTables est un plugin tiers utilisé pour générer le tableau de démonstration ci-dessous.
        Pour plus d'informations sur DataTables, veuillez visiter la <a target="_blank"
            href="https://datatables.net">documentation officielle de DataTables</a>.</p>

            <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Liste des utilisateurs</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Numéro utilisateur</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Adresse</th>
                        <th>Email</th>
                        <th>Mot de passe</th>
                        <th>Paiement</th>
                        <th>Date de création</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Numéro utilisateur</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Adresse</th>
                        <th>Email</th>
                        <th>Mot de passe</th>
                        <th>Paiement</th>
                        <th>Date de création</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    while ($lign = $req->fetch(PDO::FETCH_NUM)) {
                        echo "<tr>";
                        foreach ($lign as $valeur) {
                            echo "<td>$valeur</td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<?php
$req->closeCursor();
require_once 'footer.php';
?>

                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php require_once 'footer.php' ?>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>