<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html");
    exit();
}
require_once 'php/config.php';

// Récupérer la liste des produits
$result = $conn->query("SELECT p.*, c.nom AS nom_categorie FROM produits p LEFT JOIN categories c ON p.categorie_id = c.id");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les Produits</title>
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
    <h2>Liste des Produits</h2>
    <a href="admin_ajouter_produit.php">Ajouter un Produit</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Prix</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($produit = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $produit['id']; ?></td>
                <td><?php echo htmlspecialchars($produit['nom']); ?></td>
                <td><?php echo htmlspecialchars($produit['nom_categorie']); ?></td>
                <td><?php echo $produit['prix']; ?> CHF</td>
                <td>
                    <a href="admin_modifier_produit.php?id=<?php echo $produit['id']; ?>">Modifier</a>
                    <a href="php/admin_supprimer_produit.php?id=<?php echo $produit['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">Supprimer</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>