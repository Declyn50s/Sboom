<?php
$host = 'localhost';
$user = 'Derval';
$password = '$2y$10$FoxkdK/Fq7fDIFL56J7M0uvgTXST1R5ai4ejNJ7yewaUfStJm4XXi';
$dbname = 'sboom';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die('Erreur de connexion : ' . $conn->connect_error);
}
?>
