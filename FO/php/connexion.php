<?php
session_start(); // Démarrer la session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connexion à la base de données
    try {
        $db = new PDO('mysql:host=localhost;dbname=sboom;charset=utf8', 'root', 'password');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die('Erreur de connexion : ' . $e->getMessage());
    }

    // Récupération des données du formulaire
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $mot_de_passe = $_POST['mot_de_passe'];

    if ($email && $mot_de_passe) {
        // Requête pour récupérer les informations de l'utilisateur
        $stmt = $db->prepare("SELECT id, email, mot_de_passe, prenom FROM utilisateurs WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
            // Authentification réussie
            $_SESSION['utilisateur_id'] = $utilisateur['id'];
            $_SESSION['email'] = $utilisateur['email'];
            $_SESSION['prenom'] = $utilisateur['prenom'];

            // Redirection vers la page d'accueil ou tableau de bord
            header('Location: index.php');
            exit;
        } else {
            // Authentification échouée
            $erreur = "Adresse e-mail ou mot de passe incorrect.";
        }
    } else {
        $erreur = "Veuillez remplir tous les champs.";
    }
}
?>