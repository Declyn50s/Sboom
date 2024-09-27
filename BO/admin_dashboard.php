<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
    <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['admin_nom']); ?></h1>
    <nav>
        <ul>
            <li><a href="admin_produits.php">Gérer les Produits</a></li>
            <li><a href="admin_categories.php">Gérer les Catégories</a></li>
            <li><a href="admin_commandes.php">Gérer les Commandes</a></li>
            <li><a href="admin_commentaires.php">Modérer les Commentaires</a></li>
            <li><a href="php/admin_logout.php">Déconnexion</a></li>
        </ul>
    </nav>
    <!-- Contenu supplémentaire -->
</body>
</html>
