<?php

/**
 * Plugin Name: Simple contact formulaire
 * Description: A simple contact formulaire plugin for WordPress.
 * Version: 1.0
 */
//empecher l'acces direct au fichier
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

//affichage du formulaire
function display_form()
{
    ob_start(); // Demmarer la mémoire tampon
?>
    <form method="post" action="">
        <?php wp_nonce_field('fc_form_submit', 'fc_form_nonce'); ?>
        <p>
            <label for="fc-name">Nom:</label>
            <input type="text" id="fc-name" name="fc-name" required>
        </p>
        <p>
            <label for="fc-email">Email:</label>
            <input type="email" id="fc-email" name="fc-email" required>
        </p>
        <p>
            <label for="fc-email">Email:</label>
            <input type="email" id="fc-email" name="fc-email" required>
        </p>
        <p>
            <label for="fc-message">Message:</label>
            <textarea id="fc-message" name="fc-message" required></textarea>
        </p>
        <p>
            <label for="fc-message">Message:</label>
            <textarea id="fc-message" name="fc-message" required></textarea>
        </p>
        <p>
            <input type="submit" name="fc-submitted" value="Envoyer">
        </p>
    </form>
<?php
    return ob_get_clean(); // Retourner le contenu du tampon et l'effacer et nettoyer la mémoire tampon
}
add_shortcode('mon-joli-formulaire', 'display_form');
//[mon-joli-formulaire]

//traitement du formulaire
function treatment_form()
{
    if (isset($_POST['fc-submitted'])) {
        //verifier le nonce pour la securité
        //verifie si le formulaire est envoyé
        if (!isset($_POST['fc_form_nonce'])) {
            echo 'Erreur de sécurité. Veuillez réessayer.';
            exit;
        }
        //nettoyage
        $nom = sanitize_text_field($_POST['fc-name']);
        $email = sanitize_email($_POST['fc-email']);
        $message = sanitize_textarea_field($_POST['fc-message']);

        //envoyer l'email
        $to = get_option('admin_email'); //envoie a l'admin du site
        $subject = 'Nouveau message de ' . $nom;
        $headers = array('Content-Type: text/html; charset=UTF-8', 'From: ' . $nom . ' <' . $email . '>');

        //corps
        $body = '<h2>Nouveau message de contact</h2>';
        $body .= '<p><strong>Nom:</strong> ' . $nom . '</p>';
        $body .= '<p><strong>Email:</strong> ' . $email . '</p>';
        $body .= '<p><strong>Message:</strong><br>' . nl2br($message) . '</p>';
        wp_mail($to, $subject, $body, $headers);
        echo '<p>Merci pour votre message. Nous vous contacterons bientôt.</p>';
    }
}

add_action('wp_head', 'treatment_form');//attacher le traitement du formulaire a l'action wp_head
