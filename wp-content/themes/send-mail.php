<?php
/**
 * Script d'envoi d'email depuis le formulaire de contact
 */

// Configuration
$destinataire = "eric.demonio@gmail.com";
$charset = "UTF-8";

// Headers pour la réponse JSON
header('Content-Type: application/json; charset=utf-8');

// Vérifier que la requête est en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

// Récupérer et nettoyer les données du formulaire
$objet = isset($_POST['objet']) ? trim($_POST['objet']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';
$nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';

// Validation basique
if (empty($objet)) {
    echo json_encode(['success' => false, 'message' => 'L\'objet est requis']);
    exit;
}

if (empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Le message est requis']);
    exit;
}

// Validation de l'email si fourni
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Adresse email invalide']);
    exit;
}

// Construire le message
$corps_message = "Nouveau message depuis le formulaire de contact\n\n";
if (!empty($nom)) {
    $corps_message .= "Nom : " . $nom . "\n";
}
if (!empty($email)) {
    $corps_message .= "Email : " . $email . "\n";
}
$corps_message .= "\nMessage :\n" . $message;

// Headers de l'email
$headers = array();
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/plain; charset=' . $charset;
$headers[] = 'From: Formulaire Contact <noreply@yence-consulting.com>';
if (!empty($email)) {
    $headers[] = 'Reply-To: ' . $email;
}
$headers[] = 'X-Mailer: PHP/' . phpversion();

// Encoder le sujet en UTF-8
$objet_encode = '=?UTF-8?B?' . base64_encode($objet) . '?=';

// Tentative d'envoi de l'email
$envoi_reussi = mail($destinataire, $objet_encode, $corps_message, implode("\r\n", $headers));

if ($envoi_reussi) {
    echo json_encode([
        'success' => true,
        'message' => 'Message envoyé avec succès'
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erreur lors de l\'envoi du message'
    ]);
}
?>
