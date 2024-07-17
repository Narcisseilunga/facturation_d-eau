<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion-eau";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo " ";
} catch (PDOException $e) {
    echo "La connexion a échoué: " . $e->getMessage();
}
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adresse_email = isset($_POST["email"]) ? $_POST["email"] : '';
    $mot_de_passe = isset($_POST["mot_de_passe"]) ? $_POST["mot_de_passe"] : '';
    $erreur = '';
    
    if(!empty($adresse_email) && !empty($mot_de_passe)){
        // Préparation de la requête SQL pour éviter les injections SQL
        $req = $conn->prepare("SELECT * FROM utilisateurs WHERE email = :email AND mot_de_passe = :mot_de_passe");

        $req->execute(array(':email' => $adresse_email, ':mot_de_passe' => $mot_de_passe));
        $rep = $req->fetch();
        
        // Vérification si un utilisateur correspond aux identifiants
        if($rep && $rep['id']){
            session_start();
            $_SESSION['id_utilisateur'] = $rep['id'];
            $_SESSION['prenom'] = $rep['prenom'];
            $_SESSION['nom'] = $rep['nom'];
            $_SESSION['type_mode'] = $rep['type_mode'];
            if ($rep['type_mode'] == "employe") {
                header("Location:conso.php");
                exit();
            }
            elseif ($rep['type_mode'] == "Admin") {
                header("Location:index.php");
                exit();
            }
            
        }
        else{
            // Message d'erreur en cas d'identifiants incorrects
            $erreur = "Adresse email ou mot de passe incorrects !";
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Bienvenue !</h1>
                                        <?php 
                                        if(isset($erreur)){
                                            echo '<span style  = "color : red ;">'.$erreur.'</span>';
                                        }
                                        ?>
                                    </div>
                                    <form action="" method="post" class="user">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Entrez votre adresse email">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="mot_de_passe" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Mot de passe">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" name = "checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Rappelez moi </label>
                                            </div>
                                        </div>
                                        <div>
                                            <input type="submit" value="Se connecter" class="btn btn-primary btn-user btn-block">
                                        </div>
                                        <hr>
                                        <a href="index.php" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> se connecter avec Google
                                        </a>
                                        <a href="index.php" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> se connecter avec Facebook
                                        </a>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.php">vous avez oublié votre mot de passe?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Créer un compte!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>