<?php
/**
 * Clase para manejar la administración del plugin Discord Contact Form
 */

// Prevenir acceso directo
if (!defined('ABSPATH')) {
    exit;
}

class DCF_Admin {
    
    private $translations = array();
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        $this->load_translations();
    }
    
    /**
     * Agregar menú de administración
     */
    public function add_admin_menu() {
        // Icono de Discord en SVG base64
        $discord_icon = 'data:image/svg+xml;base64,' . base64_encode('
        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="black">
            <path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028c.462-.63.874-1.295 1.226-1.994a.076.076 0 0 0-.041-.106 13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.010c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.892.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.956-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419 0-1.333.955-2.419 2.157-2.419 1.21 0 2.176 1.096 2.157 2.42 0 1.333-.946 2.418-2.157 2.418z"/>
        </svg>');
        
        // Agregar menú principal
        add_menu_page(
            'Discord Form',
            'Discord Form',
            'manage_options',
            'discord-contact-form',
            array($this, 'admin_page'),
            $discord_icon,
            30
        );
        
        // Agregar submenú para configuración
        add_submenu_page(
            'discord-contact-form',
            $this->get_translation('configuration'),
            $this->get_translation('configuration'),
            'manage_options',
            'discord-contact-form',
            array($this, 'admin_page')
        );
        
        // Agregar submenú para el editor
        add_submenu_page(
            'discord-contact-form',
            $this->get_translation('form_editor'),
            $this->get_translation('form_editor'),
            'manage_options',
            'discord-contact-form-editor',
            array($this, 'form_editor_page')
        );
    }
    
    /**
     * Cargar scripts y estilos del admin
     */
    public function enqueue_admin_scripts($hook) {
        // Solo cargar en nuestras páginas
        if (strpos($hook, 'discord-contact-form') === false) {
            return;
        }
        
        wp_enqueue_style(
            'dcf-admin-style',
            DCF_PLUGIN_URL . 'admin/assets/css/admin.css',
            array(),
            DCF_VERSION
        );
        
        if ($hook === 'discord-form_page_discord-contact-form-editor') {
            wp_enqueue_script(
                'dcf-admin-editor',
                DCF_PLUGIN_URL . 'admin/assets/js/form-editor.js',
                array('jquery'),
                DCF_VERSION,
                true
            );
            
            wp_localize_script('dcf-admin-editor', 'dcf_admin', array(
                'button_text' => get_option('dcf_button_text', $this->get_translation('default_submit_text')),
                'translations' => array(
                    'field_number' => $this->get_translation('field_number'),
                    'remove_field' => $this->get_translation('remove_field'),
                    'field_types' => $this->get_translation('field_types'),
                    'field_untitled' => $this->get_translation('field_untitled'),
                    'field_type' => $this->get_translation('field_type'),
                    'field_label' => $this->get_translation('field_label'),
                    'field_label_desc' => $this->get_translation('field_label_desc'),
                    'field_name' => $this->get_translation('field_name'),
                    'field_name_desc' => $this->get_translation('field_name_desc'),
                    'field_placeholder' => $this->get_translation('field_placeholder'),
                    'field_placeholder_desc' => $this->get_translation('field_placeholder_desc'),
                    'field_maxlength' => $this->get_translation('field_maxlength'),
                    'field_maxlength_desc' => $this->get_translation('field_maxlength_desc'),
                    'field_required' => $this->get_translation('field_required'),
                    'field_required_desc' => $this->get_translation('field_required_desc')
                )
            ));
        }
    }
    
    /**
     * Página de administración principal
     */
    public function admin_page() {
        // Procesar formulario si se envió
        if (isset($_POST['submit'])) {
            $this->process_admin_form();
        }
        
        // Cargar template
        $this->load_template('config-page.php');
    }
    
    /**
     * Página del editor de formulario
     */
    public function form_editor_page() {
        // Procesar formulario si se envió
        if (isset($_POST['save_form'])) {
            $this->process_form_editor();
        }
        
        // Cargar template
        $this->load_template('form-editor.php');
    }
    
    /**
     * Procesar el formulario de configuración
     */
    private function process_admin_form() {
        $webhook_url = esc_url_raw($_POST['dcf_webhook_url']);
        $text_color = sanitize_hex_color($_POST['dcf_text_color']);
        $bg_color = sanitize_hex_color($_POST['dcf_bg_color']);
        $border_color = sanitize_hex_color($_POST['dcf_border_color']);
        $focus_border_color = sanitize_hex_color($_POST['dcf_focus_border_color']);
        $button_bg_color = sanitize_hex_color($_POST['dcf_button_bg_color']);
        $button_text_color = sanitize_hex_color($_POST['dcf_button_text_color']);
        $button_text = sanitize_text_field($_POST['dcf_button_text']);
        
        update_option('dcf_webhook_url', $webhook_url);
        update_option('dcf_text_color', $text_color);
        update_option('dcf_bg_color', $bg_color);
        update_option('dcf_border_color', $border_color);
        update_option('dcf_focus_border_color', $focus_border_color);
        update_option('dcf_button_bg_color', $button_bg_color);
        update_option('dcf_button_text_color', $button_text_color);
        update_option('dcf_button_text', $button_text);
        
        // Procesar cambio de idioma
        if (isset($_POST['dcf_language'])) {
            $language = sanitize_text_field($_POST['dcf_language']);
            update_option('dcf_language', $language);
            $this->load_translations();
        }
        
        add_action('admin_notices', function() {
            echo '<div class="notice notice-success"><p>' . esc_html($this->get_translation('configuration_saved')) . '</p></div>';
        });
    }
    
    /**
     * Procesar el editor de formulario
     */
    private function process_form_editor() {
        $form_fields = $_POST['form_fields'] ?? [];
        $sanitized_fields = array();
        
        foreach ($form_fields as $field) {
            $sanitized_fields[] = array(
                'type' => sanitize_text_field($field['type']),
                'label' => sanitize_text_field($field['label']),
                'name' => sanitize_text_field($field['name']),
                'placeholder' => sanitize_text_field($field['placeholder']),
                'required' => isset($field['required']) ? 1 : 0,
                'maxlength' => intval($field['maxlength'])
            );
        }
        
        update_option('dcf_form_fields', $sanitized_fields);
        add_action('admin_notices', function() {
            echo '<div class="notice notice-success"><p>' . esc_html($this->get_translation('form_saved')) . '</p></div>';
        });
    }
    
    /**
     * Cargar un template del admin
     */
    private function load_template($template_name) {
        $template_path = DCF_PLUGIN_DIR . 'admin/templates/' . $template_name;
        if (file_exists($template_path)) {
            include $template_path;
        }
    }
    
    /**
     * Cargar traducciones según el idioma seleccionado
     */
    private function load_translations() {
        $language = get_option('dcf_language', 'es_ES');
        $lang_file = DCF_PLUGIN_DIR . 'languages/discord-contact-form-' . $language . '.php';
        
        if (file_exists($lang_file)) {
            $this->translations = include $lang_file;
        } else {
            // Fallback a español si no existe el archivo
            $this->translations = include DCF_PLUGIN_DIR . 'languages/discord-contact-form-es_ES.php';
        }
    }
    
    /**
     * Obtener traducción
     */
    public function get_translation($key) {
        return isset($this->translations[$key]) ? $this->translations[$key] : $key;
    }
    
    /**
     * Imprimir traducción (helper para templates)
     */
    public function t($key) {
        echo esc_html($this->get_translation($key));
    }
    
    /**
     * Obtener traducción escapada para atributos
     */
    public function t_attr($key) {
        return esc_attr($this->get_translation($key));
    }
    
    /**
     * Obtener campos por defecto del formulario
     */
    public function get_default_fields() {
        // Usar la función global que detecta idioma automáticamente
        return dcf_get_default_fields_by_language();
    }
}
