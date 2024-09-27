<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connexion à la base de données
    $db = new PDO('mysql:host=localhost;dbname=sboom', 'root', 'password'); // Remplacez par vos informations de connexion

    // Récupération et sécurisation des données du formulaire
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING);
    $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
    $date_naissance = $_POST['date_naissance']; // Vous pouvez ajouter une validation pour la date
    $telephone = $_POST['indicatif'] . filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_STRING);
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
    $adresse = filter_input(INPUT_POST, 'adresse', FILTER_SANITIZE_STRING);
    $code_postal = filter_input(INPUT_POST, 'code_postal', FILTER_SANITIZE_STRING);
    $localite = filter_input(INPUT_POST, 'localite', FILTER_SANITIZE_STRING);
    $newsletter = isset($_POST['newsletter']) ? 1 : 0;

    // Préparation de la requête SQL
    $stmt = $db->prepare("INSERT INTO utilisateurs (email, prenom, nom, date_naissance, telephone, mot_de_passe, adresse, code_postal, localite, newsletter) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Exécution de la requête avec les données
    if ($stmt->execute([$email, $prenom, $nom, $date_naissance, $telephone, $mot_de_passe, $adresse, $code_postal, $localite, $newsletter])) {
        echo "Inscription réussie !";
    } else {
        echo "Erreur lors de l'inscription.";
    }
}
?>
