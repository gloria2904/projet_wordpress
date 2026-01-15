<?php
/* 
* Plugin Name: Personnalize Message
* Description: A simple plugin to personalize messages.
* Version: 1.0
* Author: Corentin
*/
//empecher l'acces direct au fichier
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
//ajouter une page de paramètres dans le menu reglages
function pm_add_settings_page()
{
    /*
    titre de la page
    titre du menu
    capacité requise
    slug du menu
    fonction de rappel pour afficher le contenu de la page
    */
    add_options_page(
        __('Parametres du message personnalise', 'message-personnalise'),
        __('Message Personnalise', 'message-personnalise'),
        'manage_options',
        'pm-settings',
        'pm_parameters_page'
    );
}
add_action('admin_menu', 'pm_add_settings_page');

//afficher le contenu de la page de paramètres

function pm_parameters_page()
{
?>
    <div class="wrap">
        <h1>Message personnalisé</h1>
        <form method='post' action="options.php">
            <?php
            //afficher les champs de paramètres
            settings_fields('pm_settings_group');
            //afficher les sections de paramètres
            do_settings_sections('pm-settings');
            //add_settings_fields();
            //afficher le bouton de soumission
            submit_button();
            ?>
        </form>
    </div>
<?php
}
//inikialiser les paramètres du plugin
function pm_initialize_settings()
{
    register_setting('pm_settings_group', 'pm_custom_message');
    //lier l'option pm_message au groupe de paramètres pm_settings_group
    add_settings_section(
        'pm_main_section', // ID de la section
        __('Paramètres principaux', 'message-personnalise'), // titre de la section
        null, // fonction de rappel pour afficher le contenu de la section
        'pm-settings' //slug de la page des paramètres
    );
    // ajouter un champ de saisies pour le champs personnalisé
    add_settings_field(
        'pm_custom_message', // ID du champ
        __('Message personnalisé', 'message-personnalise'), // titre du champ
        'pm_render_message_field', // fonction de rappel pour afficher le champ
        'pm-settings', // slug de la page des paramètres
        'pm_main_section' // ID de la section
    );
}
add_action('admin_init', 'pm_initialize_settings');

// Fonction 1 : Afficher le champ de saisie du message personnalisé
function pm_render_message_field()
{
    $message = get_option('pm_custom_message'); //Recuperer la valeur depuis la BDD
?>
    <input
        type="text"
        name="pm_custom_message"
        value="<?php echo esc_attr($message); ?>" />
    <p class="description">
        <?php _e('Ce message sera affiché sur le site.', 'message-personnalise'); ?>
    </p>
<?php
}

// Fonction 2 : Afficher le message personnalisé sur le site (frontend)
function pm_display_custom_message()
{
    $message = get_option('pm_custom_message');

    if (!empty($message)) {
        return '<p>' . esc_html($message) . '</p>';
    } else {
        return '<p>' . __('Aucun message personnalisé défini.', 'message-personnalise') . '</p>';
    }
}
add_shortcode('custom_message', 'pm_display_custom_message');
//[personalize_message] pour afficher le message personnalisé