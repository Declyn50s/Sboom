<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.html");
    exit();
}
require_once 'php/config.php';

// Récupérer les catégories pour le menu déroulant
$result_categorie = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Produit</title>
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
    <h2>Ajouter un Produit</h2>
    <form action="php/admin_ajouter_produit.php" method="post" enctype="multipart/form-data">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" required>

        <label for="description">Description :</label>
        <textarea name="description" required></textarea>

        <label for="prix">Prix :</label>
        <input type="number" step="0.05" name="prix" required>

        <label for="categorie_id">Catégorie :</label>
        <select name="categorie_id" required>
            <?php while ($categorie = $result_categorie->fetch_assoc()) { ?>
                <option value="<?php echo $categorie['id']; ?>"><?php echo htmlspecialchars($categorie['nom']); ?></option>
            <?php } ?>
        </select>

        <label for="image">Image :</label>
        <input type="file" name="image" accept="image/*" required>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>