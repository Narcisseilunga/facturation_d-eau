<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion-eau";
// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
