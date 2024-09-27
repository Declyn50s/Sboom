<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connexion à la base de données
    try {
        $db = new PDO('mysql:host=localhost;dbname=sboom;charset=utf8', 'root', 'password');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die('Erreur de connexion : ' . $e->getMessage());
    }

    $token = $_POST['token'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $confirmer_mot_de_passe = $_POST['confirmer_mot_de_passe'];

    if ($mot_de_passe === $confirmer_mot_de_passe) {
        // Vérifier le token
        $stmt = $db->prepare("SELECT email FROM reset_mot_de_passe WHERE token = :token AND expire > NOW()");
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $email = $row['email'];
            // Mettre à jour le mot de passe de l'utilisateur
            $nouveau_mot_de_passe = password_hash($mot_de_passe, PASSWORD_DEFAULT);

            $stmt = $db->prepare("UPDATE utilisateurs SET mot_de_passe = :mot_de_passe WHERE email = :email");
            $stmt->bindParam(':mot_de_passe', $nouveau_mot_de_passe);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Supprimer le token après utilisation
            $stmt = $db->prepare("DELETE FROM reset_mot_de_passe WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $message_success = "Votre mot de passe a été réinitialisé avec succès.";
        } else {
            $erreur = "Le lien de réinitialisation est invalide ou a expiré.";
        }
    } else {
        $erreur = "Les mots de passe ne correspondent pas.";
    }
}
?>