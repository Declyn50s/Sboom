<?php
// Informations de connexion
$host = 'localhost';
$dbname = 'sboom';
$username = 'root';
$password = ''; // Remplacez par votre mot de passe MySQL si nécessaire

try {
    // Connexion à la base de données
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insertion d'un utilisateur test
    $stmt = $db->prepare("INSERT INTO utilisateurs (email, prenom, nom, date_naissance, telephone, mot_de_passe, adresse, code_postal, localite, newsletter) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Données de test
    $email = "test@example.com";
    $prenom = "Jean";
    $nom = "Dupont";
    $date_naissance = "1990-01-01";
    $telephone = "+41791234567";
    $mot_de_passe = password_hash("motdepasse123", PASSWORD_DEFAULT);
    $adresse = "Rue de Lausanne 10";
    $code_postal = "1000";
    $localite = "Lausanne";
    $newsletter = 1; // Inscrit à la newsletter

    // Exécuter la requête d'insertion
    $stmt->execute([$email, $prenom, $nom, $date_naissance, $telephone, $mot_de_passe, $adresse, $code_postal, $localite, $newsletter]);

    echo "Utilisateur inséré avec succès.";

} catch (PDOException $e) {
    echo "Erreur lors de l'insertion : " . $e->getMessage();
}
?>
