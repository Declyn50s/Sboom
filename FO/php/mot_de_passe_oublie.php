<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connexion à la base de données
    try {
        $db = new PDO('mysql:host=localhost;dbname=sboom;charset=utf8', 'root', 'password');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die('Erreur de connexion : ' . $e->getMessage());
    }

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if ($email) {
        // Vérifier si l'utilisateur existe
        $stmt = $db->prepare("SELECT id FROM utilisateurs WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Générer un token sécurisé
            $token = bin2hex(random_bytes(50));

            // Enregistrer le token en base de données avec une date d'expiration
            $stmt = $db->prepare("INSERT INTO reset_mot_de_passe (email, token, expire) VALUES (:email, :token, DATE_ADD(NOW(), INTERVAL 1 HOUR))");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':token', $token);
            $stmt->execute();

            // Envoyer l'e-mail de réinitialisation
            $reset_link = "http://votre-site.com/reinitialiser_mot_de_passe.php?token=" . $token;

            $to = $email;
            $subject = "Réinitialisation de votre mot de passe";
            $message = "Bonjour,\n\nCliquez sur le lien suivant pour réinitialiser votre mot de passe :\n" . $reset_link . "\n\nCe lien est valable pendant 1 heure.";
            $headers = "From: no-reply@sboom.com";

            mail($to, $subject, $message, $headers);

            $message_success = "Un e-mail de réinitialisation a été envoyé à votre adresse.";
        } else {
            $erreur = "Aucun compte n'est associé à cet e-mail.";
        }
    } else {
        $erreur = "Veuillez entrer une adresse e-mail valide.";
    }
}
?>