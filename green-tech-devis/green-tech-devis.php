<?php

/**
 * Plugin Name: GreenTech Devis Manager
 * Plugin URI: https://greentech-solutions.fr
 * Description: Gère les demandes de devis pour GreenTech Solutions
 * Version: 1.0.0
 * Author: GreenTech Solutions
 * License: GPL v2 or later
 * Text Domain: greentech-devis
 */

if (! defined('ABSPATH')) {
    exit;
}

// Activation du plugin - Créer la table
register_activation_hook(__FILE__, 'greentech_create_table');

function greentech_create_table()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'greentech_devis';

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id BIGINT(20) NOT NULL AUTO_INCREMENT,
        nom VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        telephone VARCHAR(20),
        entreprise VARCHAR(100),
        service VARCHAR(50),
        message LONGTEXT,
        statut VARCHAR(20) DEFAULT 'nouveau',
        date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
        date_lecture DATETIME,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Enregistrer les menus d'administration
add_action('admin_menu', 'greentech_devis_admin_menu');

function greentech_devis_admin_menu()
{
    add_menu_page(
        'Demandes de Devis',
        'Devis',
        'manage_options',
        'greentech-devis',
        'greentech_devis_list_page',
        'dashicons-clipboard',
        30
    );

    add_submenu_page(
        'greentech-devis',
        'Tous les devis',
        'Tous les devis',
        'manage_options',
        'greentech-devis',
        'greentech_devis_list_page'
    );

    add_submenu_page(
        'greentech-devis',
        'Ajouter un devis',
        'Ajouter',
        'manage_options',
        'greentech-devis-new',
        'greentech_devis_edit_page'
    );
}

// Page liste des devis
function greentech_devis_list_page()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'greentech_devis';

    // Supprimer un devis
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        check_admin_referer('greentech_devis_nonce');
        $id = intval($_GET['id']);
        $wpdb->delete($table_name, array('id' => $id));
        echo '<div class="notice notice-success"><p>Devis supprimé !</p></div>';
    }

    // Changer le statut
    if (isset($_POST['greentech_change_status'])) {
        check_admin_referer('greentech_devis_status_nonce');
        $id = intval($_POST['devis_id']);
        $statut = sanitize_text_field($_POST['statut']);
        $wpdb->update(
            $table_name,
            array('statut' => $statut, 'date_lecture' => current_time('mysql')),
            array('id' => $id)
        );
        echo '<div class="notice notice-success"><p>Statut mis à jour !</p></div>';
    }

    $devis = $wpdb->get_results("SELECT * FROM $table_name ORDER BY date_creation DESC");

?>
    <div class="wrap">
        <h1>Demandes de Devis
            <a href="?page=greentech-devis-new" class="page-title-action">Ajouter un devis</a>
        </h1>

        <table class="wp-list-table widefat striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Entreprise</th>
                    <th>Service</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($devis) : ?>
                    <?php foreach ($devis as $item) : ?>
                        <tr>
                            <td><?php echo esc_html($item->id); ?></td>
                            <td><?php echo esc_html($item->nom); ?></td>
                            <td><?php echo esc_html($item->email); ?></td>
                            <td><?php echo esc_html($item->entreprise); ?></td>
                            <td><?php echo esc_html($item->service); ?></td>
                            <td>
                                <form method="post" style="display:inline;">
                                    <?php wp_nonce_field('greentech_devis_status_nonce'); ?>
                                    <input type="hidden" name="devis_id" value="<?php echo esc_attr($item->id); ?>">
                                    <select name="statut" onchange="this.form.submit()">
                                        <option value="nouveau" <?php selected($item->statut, 'nouveau'); ?>>Nouveau</option>
                                        <option value="en_cours" <?php selected($item->statut, 'en_cours'); ?>>En cours</option>
                                        <option value="devis_envoye" <?php selected($item->statut, 'devis_envoye'); ?>>Devis envoyé</option>
                                        <option value="converti" <?php selected($item->statut, 'converti'); ?>>Converti</option>
                                    </select>
                                    <input type="hidden" name="greentech_change_status" value="1">
                                </form>
                            </td>
                            <td><?php echo esc_html($item->date_creation); ?></td>
                            <td>
                                <a href="?page=greentech-devis-new&id=<?php echo esc_attr($item->id); ?>" class="button button-small">Voir</a>
                                <a href="<?php echo wp_nonce_url("?page=greentech-devis&action=delete&id={$item->id}", 'greentech_devis_nonce'); ?>" class="button button-small button-link-delete" onclick="return confirm('Êtes-vous sûr ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" style="text-align:center;">Aucun devis pour le moment</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php
}

// Page d'édition d'un devis
function greentech_devis_edit_page()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'greentech_devis';
    $devis = null;

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $devis = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));
    }

    if (isset($_POST['greentech_save_devis'])) {
        check_admin_referer('greentech_devis_form_nonce');

        $data = array(
            'nom'        => sanitize_text_field($_POST['nom']),
            'email'      => sanitize_email($_POST['email']),
            'telephone'  => sanitize_text_field($_POST['telephone']),
            'entreprise' => sanitize_text_field($_POST['entreprise']),
            'service'    => sanitize_text_field($_POST['service']),
            'message'    => sanitize_textarea_field($_POST['message']),
            'statut'     => sanitize_text_field($_POST['statut']),
        );

        if ($devis) {
            $wpdb->update($table_name, $data, array('id' => $devis->id));
            echo '<div class="notice notice-success"><p>Devis mis à jour !</p></div>';
        } else {
            $wpdb->insert($table_name, $data);
            echo '<div class="notice notice-success"><p>Devis créé !</p></div>';
        }
    }

    $nom = $devis ? $devis->nom : '';
    $email = $devis ? $devis->email : '';
    $telephone = $devis ? $devis->telephone : '';
    $entreprise = $devis ? $devis->entreprise : '';
    $service = $devis ? $devis->service : '';
    $message = $devis ? $devis->message : '';
    $statut = $devis ? $devis->statut : 'nouveau';
?>
    <div class="wrap">
        <h1><?php echo $devis ? 'Modifier le devis' : 'Nouveau devis'; ?></h1>
        <form method="post">
            <?php wp_nonce_field('greentech_devis_form_nonce'); ?>
            <table class="form-table">
                <tr>
                    <th><label for="nom">Nom *</label></th>
                    <td><input type="text" name="nom" id="nom" value="<?php echo esc_attr($nom); ?>" required></td>
                </tr>
                <tr>
                    <th><label for="email">Email *</label></th>
                    <td><input type="email" name="email" id="email" value="<?php echo esc_attr($email); ?>" required></td>
                </tr>
                <tr>
                    <th><label for="telephone">Téléphone</label></th>
                    <td><input type="tel" name="telephone" id="telephone" value="<?php echo esc_attr($telephone); ?>"></td>
                </tr>
                <tr>
                    <th><label for="entreprise">Entreprise</label></th>
                    <td><input type="text" name="entreprise" id="entreprise" value="<?php echo esc_attr($entreprise); ?>"></td>
                </tr>
                <tr>
                    <th><label for="service">Service *</label></th>
                    <td>
                        <select name="service" id="service" required>
                            <option value="">-- Sélectionner --</option>
                            <option value="audit" <?php selected($service, 'audit'); ?>>Audit Énergétique</option>
                            <option value="solaire" <?php selected($service, 'solaire'); ?>>Panneaux Solaires</option>
                            <option value="optimisation" <?php selected($service, 'optimisation'); ?>>Optimisation</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="message">Message</label></th>
                    <td><textarea name="message" id="message" rows="5"><?php echo esc_textarea($message); ?></textarea></td>
                </tr>
                <tr>
                    <th><label for="statut">Statut</label></th>
                    <td>
                        <select name="statut" id="statut">
                            <option value="nouveau" <?php selected($statut, 'nouveau'); ?>>Nouveau</option>
                            <option value="en_cours" <?php selected($statut, 'en_cours'); ?>>En cours</option>
                            <option value="devis_envoye" <?php selected($statut, 'devis_envoye'); ?>>Devis envoyé</option>
                            <option value="converti" <?php selected($statut, 'converti'); ?>>Converti</option>
                        </select>
                    </td>
                </tr>
            </table>
            <?php submit_button('Sauvegarder', 'primary', 'greentech_save_devis'); ?>
        </form>
    </div>
<?php
}

// Shortcode pour le formulaire frontend
add_shortcode('greentech_devis_form', 'greentech_devis_form_shortcode');

function greentech_devis_form_shortcode()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'greentech_devis';
    $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['greentech_devis_nonce'])) {
        if (wp_verify_nonce($_POST['greentech_devis_nonce'], 'greentech_devis_form')) {
            $data = array(
                'nom'        => sanitize_text_field($_POST['nom']),
                'email'      => sanitize_email($_POST['email']),
                'telephone'  => sanitize_text_field($_POST['telephone'] ?? ''),
                'entreprise' => sanitize_text_field($_POST['entreprise'] ?? ''),
                'service'    => sanitize_text_field($_POST['service']),
                'message'    => sanitize_textarea_field($_POST['message'] ?? ''),
                'statut'     => 'nouveau',
            );

            if ($wpdb->insert($table_name, $data)) {
                $message = '<div style="padding:15px; background:#d4edda; color:#155724; border-radius:8px; margin-bottom:20px;">✓ Merci ! Votre demande a bien été reçue. Nous vous contacterons sous 24h.</div>';
            }
        }
    }

    ob_start();
    echo $message;
?>
    <form method="post" style="display:flex; flex-direction:column;">
        <?php wp_nonce_field('greentech_devis_form', 'greentech_devis_nonce'); ?>
        <input type="text" name="nom" placeholder="Votre nom" required style="width:100%; padding:12px; margin-bottom:12px; border:1px solid #eee; background:#f8f9fa; border-radius:12px;">
        <input type="email" name="email" placeholder="Votre email" required style="width:100%; padding:12px; margin-bottom:12px; border:1px solid #eee; background:#f8f9fa; border-radius:12px;">
        <input type="tel" name="telephone" placeholder="Téléphone (optionnel)" style="width:100%; padding:12px; margin-bottom:12px; border:1px solid #eee; background:#f8f9fa; border-radius:12px;">
        <input type="text" name="entreprise" placeholder="Entreprise" style="width:100%; padding:12px; margin-bottom:12px; border:1px solid #eee; background:#f8f9fa; border-radius:12px;">
        <select name="service" required style="width:100%; padding:12px; margin-bottom:12px; border:1px solid #eee; background:#f8f9fa; border-radius:12px;">
            <option value="">-- Sélectionner un service --</option>
            <option value="audit">Audit Énergétique</option>
            <option value="solaire">Panneaux Solaires</option>
            <option value="optimisation">Optimisation</option>
        </select>
        <textarea name="message" placeholder="Votre message (optionnel)" rows="4" style="width:100%; padding:12px; margin-bottom:12px; border:1px solid #eee; background:#f8f9fa; border-radius:12px;"></textarea>
        <button type="submit" style="width:100%; padding:12px; background:#2d5a27; color:white; border:none; border-radius:12px; font-weight:700; cursor:pointer;">Envoyer ma demande</button>
    </form>
<?php
    return ob_get_clean();
}
