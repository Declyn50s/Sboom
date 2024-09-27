<?php
session_start();
require_once 'config.php'; // Fichier de configuration pour la connexion à la base de données

if (isset($_POST['nom_utilisateur'], $_POST['mot_de_passe'])) {
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $mot_de_passe = $_POST['mot_de_passe'];
    // Préparation de la requête pour éviter les injections SQL
    $stmt = $conn->prepare("SELECT * FROM administrateurs WHERE nom_utilisateur = ?");
    $stmt->bind_param("s", $nom_utilisateur);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($mot_de_passe, $admin['mot_de_passe'])) {
        // Authentification réussie
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_nom'] = $admin['nom_utilisateur'];
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Authentification échouée
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
} else {
    echo "Veuillez remplir tous les champs.";
}
?>