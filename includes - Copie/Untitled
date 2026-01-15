<?php
/**
 * Gestion du formulaire de devis (front-end)
 */

if (!defined('ABSPATH')) exit;

class Devis_Form {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        add_action('wp_ajax_submit_devis', array($this, 'handle_submit'));
        add_action('wp_ajax_nopriv_submit_devis', array($this, 'handle_submit'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }
    
    /**
     * Enregistrer les scripts
     */
    public function enqueue_scripts() {
        wp_enqueue_style('devis-form-style', DEVIS_PLUGIN_URL . 'assets/css/form-style.css', array(), DEVIS_VERSION);
        wp_enqueue_script('devis-form-script', DEVIS_PLUGIN_URL . 'assets/js/form-script.js', array('jquery'), DEVIS_VERSION, true);
        
        wp_localize_script('devis-form-script', 'devisAjax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('devis_nonce')
        ));
    }
    
    /**
     * Afficher le formulaire
     */
    public static function display_form() {
        ob_start();
        ?>
        
        <div id="devis-form-container">
            <form id="devis-form" class="devis-form" method="post">
                <?php wp_nonce_field('devis_nonce_action', 'devis_nonce'); ?>
                
                <div class="form-group">
                    <input type="text" 
                           name="nom" 
                           id="devis_nom" 
                           placeholder="Nom complet *" 
                           required>
                </div>
                
                <div class="form-group">
                    <input type="email" 
                           name="email" 
                           id="devis_email" 
                           placeholder="Email professionnel *" 
                           required>
                </div>
                
                <div class="form-group">
                    <input type="tel" 
                           name="telephone" 
                           id="devis_telephone" 
                           placeholder="Téléphone">
                </div>
                
                <div class="form-group">
                    <input type="text" 
                           name="entreprise" 
                           id="devis_entreprise" 
                           placeholder="Nom de l'entreprise">
                </div>
                
                <div class="form-group">
                    <select name="service" id="devis_service" required>
                        <option value="">-- Sélectionnez un service *</option>
                        <option value="audit">Audit Énergétique</option>
                        <option value="panneaux">Panneaux Solaires</option>
                        <option value="optimisation">Optimisation</option>
                        <option value="autre">Autre service</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <textarea name="message" 
                              id="devis_message" 
                              rows="5" 
                              placeholder="Décrivez votre projet *" 
                              required></textarea>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn-submit">
                        <span class="btn-text">Envoyer ma demande</span>
                        <span class="btn-loading" style="display:none;">Envoi en cours...</span>
                    </button>
                </div>
                
                <div id="devis-message" class="form-message"></div>
            </form>
        </div>
        
        <?php
        return ob_get_clean();
    }
    
    /**
     * Traiter la soumission du formulaire
     */
    public function handle_submit() {
        
        // Vérifier le nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'devis_nonce')) {
            wp_send_json_error(array('message' => 'Erreur de sécurité'));
        }
        
        // Valider les champs requis
        if (empty($_POST['nom']) || empty($_POST['email']) || empty($_POST['service']) || empty($_POST['message'])) {
            wp_send_json_error(array('message' => 'Veuillez remplir tous les champs obligatoires'));
        }
        
        // Valider l'email
        if (!is_email($_POST['email'])) {
            wp_send_json_error(array('message' => 'Adresse email invalide'));
        }
        
        // Préparer les données
        $data = array(
            'nom' => sanitize_text_field($_POST['nom']),
            'email' => sanitize_email($_POST['email']),
            'telephone' => isset($_POST['telephone']) ? sanitize_text_field($_POST['telephone']) : '',
            'entreprise' => isset($_POST['entreprise']) ? sanitize_text_field($_POST['entreprise']) : '',
            'service' => sanitize_text_field($_POST['service']),
            'message' => sanitize_textarea_field($_POST['message'])
        );
        
        // Insérer dans la base de données
        $db = Devis_DB::get_instance();
        $result = $db->insert_devis($data);
        
        if ($result) {
            // Envoyer un email de notification (optionnel)
            $this->send_notification_email($data);
            
            wp_send_json_success(array(
                'message' => 'Votre demande a été envoyée avec succès ! Nous vous contacterons sous 24h.'
            ));
        } else {
            wp_send_json_error(array(
                'message' => 'Une erreur est survenue lors de l\'envoi. Veuillez réessayer.'
            ));
        }
    }
    
    /**
     * Envoyer un email de notification
     */
    private function send_notification_email($data) {
        $to = get_option('admin_email');
        $subject = 'Nouvelle demande de devis - GreenTech Solutions';
        
        $message = "Nouvelle demande de devis reçue :\n\n";
        $message .= "Nom : " . $data['nom'] . "\n";
        $message .= "Email : " . $data['email'] . "\n";
        $message .= "Téléphone : " . $data['telephone'] . "\n";
        $message .= "Entreprise : " . $data['entreprise'] . "\n";
        $message .= "Service : " . $data['service'] . "\n";
        $message .= "Message : " . $data['message'] . "\n";
        
        $headers = array('Content-Type: text/plain; charset=UTF-8');
        
        wp_mail($to, $subject, $message, $headers);
    }
}