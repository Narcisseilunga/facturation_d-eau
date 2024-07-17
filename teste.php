<?php
session_start();
$_SESSION['nom'] = "narcisse";
if (isset($_SESSION['nom'])) {
    echo "User ID: " . $_SESSION['nom'];
} else {
    echo "User ID not set in session";
}
?>