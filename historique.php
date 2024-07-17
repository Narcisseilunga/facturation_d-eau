<?php
session_start();
$title = "page d'historique";
require_once 'header.php';
$log_file = 'user_activity.txt';

function log_activity($action, $user_id) {
    global $log_file;
    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "$timestamp | User ID: $user_id | Action: $action\n";
    file_put_contents($log_file, $log_entry, FILE_APPEND);
}

if (isset($_SESSION['id_utilisateur'])) {
    $user_id = $_SESSION['id_utilisateur'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_name = $_POST['name'];
        $new_email = $_POST['email'];

        log_activity('Updated account information', $user_id);
    }

    log_activity('User logged in', $user_id);

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        log_activity("Viewed page: $page", $user_id);
    }

    if (isset($_POST['view_history'])) {
        echo "User activity history:\n";
        if (file_exists($log_file)) {
            $log_contents = file_get_contents($log_file);
            echo $log_contents;
        } else {
            echo "No activity history available.";
        }
    }

    if (isset($_POST['delete_history'])) {
        if (file_exists($log_file)) {
            unlink($log_file);
            echo "Activity history deleted.";
        } else {
            echo "No activity history to delete.";
        }
    }

    $title = "Historique d'activité";
    require_once 'header.php';
?>             
    <div class="container-fluid">

        <form method="post">
            <button type="submit" name="view_history">Voir l'historique</button>
            <button type="submit" name="delete_history">Supprimer l'historique</button>
        </form>
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
<?php
}else {
    header("Location: login.php"); exit; 
}
?>
