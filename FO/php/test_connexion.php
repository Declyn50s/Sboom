<?php
// Informations de connexion
$host = 'localhost';
$dbname = 'sboom';
$username = 'root'; // Utilisez vos identifiants MySQL
$password = ''; // Remplacez par votre mot de passe MySQL (si vous en avez un)

try {
    // Connexion à la base de données
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Configurer PDO pour afficher les erreurs
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête simple pour vérifier la connexion
    $query = $db->query("SELECT * FROM utilisateurs");

    // Vérifier s'il y a des résultats (normalement, vous n'aurez aucun utilisateur à ce stade)
    if ($query) {
        echo "Connexion réussie à la base de données et accès à la table utilisateurs. <br>";

        // Compter le nombre d'enregistrements dans la table utilisateurs
        $result = $query->fetchAll();
        echo "Nombre d'utilisateurs trouvés : " . count($result);
    } else {
        echo "Erreur lors de l'exécution de la requête.";
    }

} catch (PDOException $e) {
    // Afficher l'erreur s'il y en a
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
