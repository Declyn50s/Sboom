<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin_login.html");
    exit();
}
require_once 'config.php';

if (isset($_POST['nom'], $_POST['description'], $_POST['prix'], $_POST['categorie_id'])) {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $categorie_id = $_POST['categorie_id'];

    // Gestion de l'upload de l'image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_name = basename($_FILES['image']['name']);
        $image_destination = '../images/produits/' . $image_name;

        // Déplacer le fichier téléchargé
        if (move_uploaded_file($image_tmp, $image_destination)) {
            // Insérer le produit dans la base de données
            $stmt = $conn->prepare("INSERT INTO produits (nom, description, prix, image, categorie_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdsi", $nom, $description, $prix, $image_name, $categorie_id);
            if ($stmt->execute()) {
                header("Location: ../admin_produits.php");
                exit();
            } else {
                echo "Erreur lors de l'ajout du produit.";
            }
        } else {
            echo "Erreur lors du téléchargement de l'image.";
        }
    } else {
        echo "Veuillez sélectionner une image.";
    }
} else {
    echo "Veuillez remplir tous les champs.";
}
?>