<?php
/**
 * Interface d'administration pour les demandes de devis
 */

if (!defined('ABSPATH')) exit;

class Devis_Admin {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('admin_post_delete_devis', array($this, 'handle_delete'));
        add_action('admin_post_update_devis_status', array($this, 'handle_status_update'));
    }
    
    /**
     * Ajouter le menu dans l'admin
     */
    public function add_admin_menu() {
        add_menu_page(
            'Demandes de Devis',
            'Demandes Devis',
            'view_devis',
            'demandes-devis',
            array($this, 'display_list_page'),
            'dashicons-email-alt',
            26
        );
        
        add_submenu_page(
            'demandes-devis',
            'Toutes les demandes',
            'Toutes les demandes',
            'view_devis',
            'demandes-devis',
            array($this, 'display_list_page')
        );
        
        add_submenu_page(
            'demandes-devis',
            'Voir la demande',
            null,
            'view_devis',
            'view-devis',
            array($this, 'display_single_page')
        );
    }
    
    /**
     * Enregistrer les scripts admin
     */
    public function enqueue_admin_scripts($hook) {
        if (strpos($hook, 'demandes-devis') === false && strpos($hook, 'view-devis') === false) {
            return;
        }
        
        wp_enqueue_style('devis-admin-style', DEVIS_PLUGIN_URL . 'assets/css/admin-style.css', array(), DEVIS_VERSION);
    }
    
    /**
     * Afficher la liste des demandes
     */
    public function display_list_page() {
        
        if (!current_user_can('view_devis')) {
            wp_die('Vous n\'avez pas les permissions nécessaires.');
        }
        
        $db = Devis_DB::get_instance();
        $demandes = $db->get_all_devis();
        
        // Statistiques
        $total = $db->count_by_status();
        $nouveaux = $db->count_by_status('nouveau');
        $en_cours = $db->count_by_status('en_cours');
        $traites = $db->count_by_status('traite');
        
        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">Demandes de Devis</h1>
            
            <div class="devis-stats" style="margin: 20px 0;">
                <div style="display: flex; gap: 20px;">
                    <div class="stat-box" style="background: #fff; padding: 15px; border-left: 4px solid #2271b1; flex: 1;">
                        <strong style="font-size: 24px;"><?php echo $total; ?></strong>
                        <p style="margin: 5px 0 0;">Total</p>
                    </div>
                    <div class="stat-box" style="background: #fff; padding: 15px; border-left: 4px solid #00a32a; flex: 1;">
                        <strong style="font-size: 24px;"><?php echo $nouveaux; ?></strong>
                        <p style="margin: 5px 0 0;">Nouveaux</p>
                    </div>
                    <div class="stat-box" style="background: #fff; padding: 15px; border-left: 4px solid #dba617; flex: 1;">
                        <strong style="font-size: 24px;"><?php echo $en_cours; ?></strong>
                        <p style="margin: 5px 0 0;">En cours</p>
                    </div>
                    <div class="stat-box" style="background: #fff; padding: 15px; border-left: 4px solid #646970; flex: 1;">
                        <strong style="font-size: 24px;"><?php echo $traites; ?></strong>
                        <p style="margin: 5px 0 0;">Traités</p>
                    </div>
                </div>
            </div>
            
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Entreprise</th>
                        <th>Service</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($demandes)) : ?>
                        <?php foreach ($demandes as $demande) : ?>
                            <tr>
                                <td><?php echo $demande->id; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($demande->date_creation)); ?></td>
                                <td><strong><?php echo esc_html($demande->nom); ?></strong></td>
                                <td><?php echo esc_html($demande->email); ?></td>
                                <td><?php echo esc_html($demande->entreprise); ?></td>
                                <td><?php echo esc_html($demande->service); ?></td>
                                <td>
                                    <?php
                                    $status_colors = array(
                                        'nouveau' => '#00a32a',
                                        'en_cours' => '#dba617',
                                        'traite' => '#646970'
                                    );
                                    $color = isset($status_colors[$demande->statut]) ? $status_colors[$demande->statut] : '#000';
                                    ?>
                                    <span style="background: <?php echo $color; ?>; color: white; padding: 4px 8px; border-radius: 3px; font-size: 12px;">
                                        <?php echo ucfirst(str_replace('_', ' ', $demande->statut)); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo admin_url('admin.php?page=view-devis&id=' . $demande->id); ?>" class="button button-small">Voir</a>
                                    <?php if (current_user_can('manage_options')) : ?>
                                        <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" style="display: inline;">
                                            <input type="hidden" name="action" value="delete_devis">
                                            <input type="hidden" name="devis_id" value="<?php echo $demande->id; ?>">
                                            <?php wp_nonce_field('delete_devis_' . $demande->id); ?>
                                            <button type="submit" class="button button-small" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 40px;">
                                <p>Aucune demande de devis pour le moment.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
    
    /**
     * Afficher une demande individuelle
     */
    public function display_single_page() {
        
        if (!current_user_can('view_devis')) {
            wp_die('Vous n\'avez pas les permissions nécessaires.');
        }
        
        $devis_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        if (!$devis_id) {
            wp_die('ID de demande invalide');
        }
        
        $db = Devis_DB::get_instance();
        $demande = $db->get_devis_by_id($devis_id);
        
        if (!$demande) {
            wp_die('Demande introuvable');
        }
        
        ?>
        <div class="wrap">
            <h1>Demande de Devis #<?php echo $demande->id; ?></h1>
            
            <div style="background: white; padding: 20px; margin: 20px 0; border: 1px solid #ccc;">
                
                <h2>Informations du client</h2>
                <table class="form-table">
                    <tr>
                        <th>Nom</th>
                        <td><?php echo esc_html($demande->nom); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><a href="mailto:<?php echo esc_attr($demande->email); ?>"><?php echo esc_html($demande->email); ?></a></td>
                    </tr>
                    <tr>
                        <th>Téléphone</th>
                        <td><?php echo esc_html($demande->telephone); ?></td>
                    </tr>
                    <tr>
                        <th>Entreprise</th>
                        <td><?php echo esc_html($demande->entreprise); ?></td>
                    </tr>
                    <tr>
                        <th>Service demandé</th>
                        <td><strong><?php echo esc_html($demande->service); ?></strong></td>
                    </tr>
                    <tr>
                        <th>Date de la demande</th>
                        <td><?php echo date('d/m/Y à H:i', strtotime($demande->date_creation)); ?></td>
                    </tr>
                </table>
                
                <h2>Message</h2>
                <div style="background: #f5f5f5; padding: 15px; border-radius: 5px;">
                    <?php echo nl2br(esc_html($demande->message)); ?>
                </div>
                
                <h2>Modifier le statut</h2>
                <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                    <input type="hidden" name="action" value="update_devis_status">
                    <input type="hidden" name="devis_id" value="<?php echo $demande->id; ?>">
                    <?php wp_nonce_field('update_status_' . $demande->id); ?>
                    
                    <select name="statut" style="padding: 5px;">
                        <option value="nouveau" <?php selected($demande->statut, 'nouveau'); ?>>Nouveau</option>
                        <option value="en_cours" <?php selected($demande->statut, 'en_cours'); ?>>En cours</option>
                        <option value="traite" <?php selected($demande->statut, 'traite'); ?>>Traité</option>
                    </select>
                    
                    <button type="submit" class="button button-primary">Mettre à jour</button>
                </form>
                
            </div>
            
            <a href="<?php echo admin_url('admin.php?page=demandes-devis'); ?>" class="button">← Retour à la liste</a>
        </div>
        <?php
    }
    
    /**
     * Gérer la suppression
     */
    public function handle_delete() {
        
        if (!current_user_can('manage_options')) {
            wp_die('Permission refusée');
        }
        
        $devis_id = isset($_POST['devis_id']) ? intval($_POST['devis_id']) : 0;
        
        if (!$devis_id || !wp_verify_nonce($_POST['_wpnonce'], 'delete_devis_' . $devis_id)) {
            wp_die('Erreur de sécurité');
        }
        
        $db = Devis_DB::get_instance();
        $db->delete_devis($devis_id);
        
        wp_redirect(admin_url('admin.php?page=demandes-devis&deleted=1'));
        exit;
    }
    
    /**
     * Gérer la mise à jour du statut
     */
    public function handle_status_update() {
        
        if (!current_user_can('view_devis')) {
            wp_die('Permission refusée');
        }
        
        $devis_id = isset($_POST['devis_id']) ? intval($_POST['devis_id']) : 0;
        $statut = isset($_POST['statut']) ? sanitize_text_field($_POST['statut']) : '';
        
        if (!$devis_id || !wp_verify_nonce($_POST['_wpnonce'], 'update_status_' . $devis_id)) {
            wp_die('Erreur de sécurité');
        }
        
        $db = Devis_DB::get_instance();
        $db->update_statut($devis_id, $statut);
        
        wp_redirect(admin_url('admin.php?page=view-devis&id=' . $devis_id . '&updated=1'));
        exit;
    }
}