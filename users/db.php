<?php
// Connexion à la base de données MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cv";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}
?>
