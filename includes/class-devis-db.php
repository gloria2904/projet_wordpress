<?php
/**
 * Gestion de la base de données pour les demandes de devis
 */

if (!defined('ABSPATH')) exit;

class Devis_DB {
    
    private static $instance = null;
    private $table_name;
    
    public static function get_instance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'demandes_devis';
    }
    
    /**
     * Créer la table à l'activation
     */
    public static function create_table() {
        global $wpdb;
        
        $table_name = $wpdb->prefix . 'demandes_devis';
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            nom varchar(100) NOT NULL,
            email varchar(100) NOT NULL,
            telephone varchar(20) DEFAULT '',
            entreprise varchar(100) DEFAULT '',
            service varchar(50) NOT NULL,
            message text NOT NULL,
            statut varchar(20) DEFAULT 'nouveau',
            date_creation datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
    /**
     * Insérer une demande de devis
     */
    public function insert_devis($data) {
        global $wpdb;
        
        $result = $wpdb->insert(
            $this->table_name,
            array(
                'nom' => sanitize_text_field($data['nom']),
                'email' => sanitize_email($data['email']),
                'telephone' => sanitize_text_field($data['telephone']),
                'entreprise' => sanitize_text_field($data['entreprise']),
                'service' => sanitize_text_field($data['service']),
                'message' => sanitize_textarea_field($data['message']),
                'statut' => 'nouveau'
            ),
            array('%s', '%s', '%s', '%s', '%s', '%s', '%s')
        );
        
        return $result !== false ? $wpdb->insert_id : false;
    }
    
    /**
     * Récupérer toutes les demandes
     */
    public function get_all_devis($orderby = 'date_creation', $order = 'DESC') {
        global $wpdb;
        
        $orderby = sanitize_sql_orderby($orderby);
        $order = ($order === 'ASC') ? 'ASC' : 'DESC';
        
        $query = "SELECT * FROM {$this->table_name} ORDER BY {$orderby} {$order}";
        
        return $wpdb->get_results($query);
    }
    
    /**
     * Récupérer une demande par ID
     */
    public function get_devis_by_id($id) {
        global $wpdb;
        
        return $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM {$this->table_name} WHERE id = %d", $id)
        );
    }
    
    /**
     * Mettre à jour le statut
     */
    public function update_statut($id, $statut) {
        global $wpdb;
        
        return $wpdb->update(
            $this->table_name,
            array('statut' => sanitize_text_field($statut)),
            array('id' => $id),
            array('%s'),
            array('%d')
        );
    }
    
    /**
     * Supprimer une demande
     */
    public function delete_devis($id) {
        global $wpdb;
        
        return $wpdb->delete(
            $this->table_name,
            array('id' => $id),
            array('%d')
        );
    }
    
    /**
     * Compter les demandes par statut
     */
    public function count_by_status($statut = null) {
        global $wpdb;
        
        if ($statut) {
            return $wpdb->get_var(
                $wpdb->prepare("SELECT COUNT(*) FROM {$this->table_name} WHERE statut = %s", $statut)
            );
        }
        
        return $wpdb->get_var("SELECT COUNT(*) FROM {$this->table_name}");
    }
}