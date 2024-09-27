<?php
$mot_de_passe_en_clair = 'Botuna'; // Remplacez par le mot de passe que vous souhaitez utiliser
$mot_de_passe_hache = password_hash($mot_de_passe_en_clair, PASSWORD_DEFAULT);
echo 'Mot de passe haché : ' . $mot_de_passe_hache;
?>