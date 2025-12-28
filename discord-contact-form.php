<?php
/**
 * Plugin Name: Discord Contact Form 
 * Plugin URI: https://github.com/gn0sys11root/wordpress-discord-contact-form
 * Description: Advanced contact form that sends submissions directly to Discord servers using webhooks API. Multilingual support with automatic language detection.
 * Version: 1.0.0
 * Author: Nahuel Rodriguez
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least: 5.0
 * Requires PHP: 7.4
 */

// Prevenir acceso directo
if (!defined('ABSPATH')) {
    exit;
}

// Definir constantes del plugin
define('DCF_VERSION', '1.0.0');
define('DCF_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('DCF_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Clase principal del plugin
 */
class DiscordContactForm {
    
    public function __construct() {
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_ajax_dcf_submit', array($this, 'handle_form_submission'));
        add_action('wp_ajax_nopriv_dcf_submit', array($this, 'handle_form_submission'));
        
        // Localizar descripción del plugin
        add_filter('all_plugins', array($this, 'localize_plugin_description'));
        
        // Agregar enlace de configuración en la lista de plugins
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'add_settings_link'));
        
        // Cargar administración solo en admin
        if (is_admin()) {
            $this->load_admin();
        }
    }
    
    /**
     * Inicializar el plugin
     */
    public function init() {
        // Registrar shortcode
        add_shortcode('discord_contact_form', array($this, 'shortcode_handler'));
    }
    
    /**
     * Cargar scripts y estilos
     */
    public function enqueue_scripts() {
        wp_enqueue_script('dcf-script', DCF_PLUGIN_URL . 'assets/js/script.js', array('jquery'), DCF_VERSION, true);
        
        // Agregar CSS dinámico basado en las opciones de color
        $this->add_dynamic_styles();
        
        // Localizar script para AJAX
        wp_localize_script('dcf-script', 'dcf_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('dcf_nonce')
        ));
    }
    
    /**
     * Agregar estilos dinámicos basados en las opciones de color
     */
    private function add_dynamic_styles() {
        $text_color = get_option('dcf_text_color', '#333333');
        $bg_color = get_option('dcf_bg_color', '#ffffff');
        $border_color = get_option('dcf_border_color', '#dddddd');
        $focus_border_color = get_option('dcf_focus_border_color', '#00a0d2');
        $button_bg_color = get_option('dcf_button_bg_color', '#0073aa');
        $button_text_color = get_option('dcf_button_text_color', '#ffffff');
        
        $custom_css = "
        /* Discord Contact Form - Estilos Personalizados */
        .dcf .dcf-form-control.dcf-text,
        .dcf .dcf-form-control.dcf-email,
        .dcf .dcf-form-control.dcf-textarea {
            color: {$text_color} !important;
            background-color: {$bg_color} !important;
            border: 1px solid {$border_color} !important;
            padding: 8px 12px !important;
            border-radius: 4px !important;
            font-family: inherit !important;
            font-size: inherit !important;
            line-height: inherit !important;
            transition: border-color 0.2s ease !important;
        }
        
        .dcf .dcf-form-control.dcf-text:focus,
        .dcf .dcf-form-control.dcf-email:focus,
        .dcf .dcf-form-control.dcf-textarea:focus {
            outline: none !important;
            border-color: {$focus_border_color} !important;
            box-shadow: 0 0 0 1px {$focus_border_color} !important;
        }
        
        .dcf .dcf-form-control.dcf-submit {
            background-color: {$button_bg_color} !important;
            color: {$button_text_color} !important;
            border: none !important;
            padding: 12px 24px !important;
            cursor: pointer !important;
            border-radius: 4px !important;
            font-family: inherit !important;
            font-size: inherit !important;
            transition: background-color 0.2s ease !important;
        }
        
        .dcf .dcf-form-control.dcf-submit:hover:not(:disabled) {
            background-color: " . $this->darken_color($button_bg_color, 10) . " !important;
        }
        
        .dcf .dcf-form-control.dcf-submit:disabled {
            opacity: 0.6 !important;
            cursor: not-allowed !important;
        }
        
        /* Estados del formulario */
        .dcf form.sent .dcf-response-output {
            border-color: #46b450 !important;
            background-color: rgba(70, 180, 80, 0.1) !important;
            color: #155724 !important;
            margin: 2em 0.5em 1em !important;
            padding: 0.2em 1em !important;
            border: 2px solid #46b450 !important;
        }
        
        .dcf form.failed .dcf-response-output,
        .dcf form.aborted .dcf-response-output {
            border-color: #dc3232 !important;
            background-color: rgba(220, 50, 50, 0.1) !important;
            color: #721c24 !important;
            margin: 2em 0.5em 1em !important;
            padding: 0.2em 1em !important;
            border: 2px solid #dc3232 !important;
        }
        
        /* Estados de formulario inicializado, enviando, etc */
        .dcf form.init .dcf-response-output,
        .dcf form.submitting .dcf-response-output {
            display: none;
        }
        
        /* Spinner */
        .dcf .dcf-spinner {
            visibility: hidden;
            display: inline-block;
            background-color: #23282d;
            opacity: 0.75;
            width: 24px;
            height: 24px;
            border: none;
            border-radius: 100%;
            padding: 0;
            margin: 0 0 0 24px;
            position: relative;
            vertical-align: middle;
        }
        
        .dcf form.submitting .dcf-spinner {
            visibility: visible;
        }
        
        .dcf-spinner::before {
            content: '';
            position: absolute;
            background-color: #fbfbfc;
            top: 4px;
            left: 4px;
            width: 6px;
            height: 6px;
            border: none;
            border-radius: 100%;
            transform-origin: 8px 8px;
            animation: dcf-spin 1000ms linear infinite;
        }
        
        @keyframes dcf-spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        ";
        
        wp_add_inline_style('wp-block-library', $custom_css);
    }
    
    /**
     * Oscurecer un color hexadecimal
     */
    private function darken_color($hex, $percent) {
        $hex = str_replace('#', '', $hex);
        
        if (strlen($hex) == 3) {
            $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
        }
        
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        
        $r = max(0, min(255, $r - ($r * $percent / 100)));
        $g = max(0, min(255, $g - ($g * $percent / 100)));
        $b = max(0, min(255, $b - ($b * $percent / 100)));
        
        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }
    
    /**
     * Manejar el shortcode
     */
    public function shortcode_handler($atts) {
        $atts = shortcode_atts(array(
            'id' => 'dcf-form-' . uniqid(),
            'class' => ''
        ), $atts);
        
        ob_start();
        $this->render_form($atts);
        return ob_get_clean();
    }
    
    /**
     * Renderizar el formulario
     */
    private function render_form($atts) {
        $form_id = esc_attr($atts['id']);
        $form_class = esc_attr($atts['class']);
        $form_fields = get_option('dcf_form_fields', $this->get_default_fields());
        ?>
        <div class="dcf" id="<?php echo esc_attr($form_id); ?>">
            <form class="dcf-form init" method="post" action="#" data-form-id="<?php echo esc_attr($form_id); ?>">
                <?php wp_nonce_field('dcf_submit', 'dcf_nonce'); ?>
                
                <?php foreach ($form_fields as $field): ?>
                    <p><label> <?php echo esc_html($field['label']); ?><?php echo $field['required'] ? ' *' : ''; ?><br>
                    <span class="dcf-form-control-wrap" data-name="<?php echo esc_attr($field['name']); ?>">
                        <?php if ($field['type'] === 'textarea'): ?>
                            <textarea 
                                name="<?php echo esc_attr($field['name']); ?>" 
                                class="dcf-form-control dcf-textarea<?php echo $field['required'] ? ' dcf-validates-as-required' : ''; ?>" 
                                cols="40" 
                                rows="10" 
                                maxlength="<?php echo intval($field['maxlength']); ?>"
                                <?php echo $field['placeholder'] ? 'placeholder="' . esc_attr($field['placeholder']) . '"' : ''; ?>
                                <?php echo $field['required'] ? 'aria-required="true" required' : ''; ?>
                                aria-invalid="false"></textarea>
                        <?php else: ?>
                            <input 
                                type="<?php echo esc_attr($field['type']); ?>" 
                                name="<?php echo esc_attr($field['name']); ?>" 
                                class="dcf-form-control dcf-<?php echo esc_attr($field['type']); ?><?php echo $field['required'] ? ' dcf-validates-as-required' : ''; ?><?php echo $field['type'] === 'email' ? ' dcf-validates-as-email' : ''; ?>" 
                                size="40" 
                                maxlength="<?php echo intval($field['maxlength']); ?>"
                                <?php echo $field['placeholder'] ? 'placeholder="' . esc_attr($field['placeholder']) . '"' : ''; ?>
                                <?php echo $field['required'] ? 'aria-required="true" required' : ''; ?>
                                aria-invalid="false" 
                                value="">
                        <?php endif; ?>
                    </span> </label>
                    </p>
                <?php endforeach; ?>

                <p><input class="dcf-form-control dcf-submit has-spinner" type="submit" value="<?php echo esc_attr(get_option('dcf_button_text', 'Enviar')); ?>"><span class="dcf-spinner"></span>
                </p>
                
                <div class="dcf-response-output" aria-hidden="true"></div>
            </form>
        </div>
        <?php
    }
    
    /**
     * Manejar el envío del formulario
     */
    public function handle_form_submission() {
            // Verificar nonce
            if (!wp_verify_nonce($_POST['dcf_nonce'], 'dcf_submit')) {
                wp_die('Error de seguridad');
            }
            
            // Obtener configuración de campos
            $form_fields = get_option('dcf_form_fields', $this->get_default_fields());
            
            // Sanitizar y validar datos dinámicamente
            $form_data = array();
            $errors = array();
            
            foreach ($form_fields as $field) {
                $field_name = $field['name'];
                $field_value = $_POST[$field_name] ?? '';
                
                // Sanitizar según el tipo de campo
                switch ($field['type']) {
                    case 'email':
                        $form_data[$field_name] = sanitize_email($field_value);
                        break;
                    case 'textarea':
                        $form_data[$field_name] = sanitize_textarea_field($field_value);
                        break;
                    case 'tel':
                    case 'number':
                        $form_data[$field_name] = sanitize_text_field($field_value);
                        break;
                    default:
                        $form_data[$field_name] = sanitize_text_field($field_value);
                        break;
                }
                
                // Validar campos obligatorios
                if ($field['required'] && empty($form_data[$field_name])) {
                    $errors[] = 'El campo "' . $field['label'] . '" es obligatorio';
                }
                
                // Validar email específicamente
                if ($field['type'] === 'email' && !empty($form_data[$field_name]) && !is_email($form_data[$field_name])) {
                    $errors[] = 'El campo "' . $field['label'] . '" debe ser un email válido';
                }
            }
            
            if (!empty($errors)) {
                wp_send_json_error(array(
                    'message' => 'Por favor, completa todos los campos obligatorios.',
                    'errors' => $errors
                ));
            }
            
            // Enviar a Discord
            $webhook_url = get_option('dcf_webhook_url');
            if (empty($webhook_url)) {
                wp_send_json_error(array(
                    'message' => 'El webhook de Discord no está configurado.'
                ));
            }
            
            // Crear campos para el embed de Discord
            $discord_fields = array();
            foreach ($form_fields as $field) {
                $field_value = $form_data[$field['name']] ?? '';
                if (!empty($field_value) || $field['required']) {
                    $discord_fields[] = array(
                        'name' => $field['label'],
                        'value' => !empty($field_value) ? $field_value : 'Sin especificar',
                        'inline' => $field['type'] !== 'textarea'
                    );
                }
            }
            
            // Obtener título traducido
            $message_title = $this->get_translation('discord_message_title');
            
            $discord_message = array(
                'embeds' => array(
                    array(
                        'title' => $message_title,
                        'color' => 3447003, // Azul
                        'fields' => $discord_fields,
                        'timestamp' => gmdate('c')
                    )
                )
            );
            
            $response = wp_remote_post($webhook_url, array(
                'body' => json_encode($discord_message),
                'headers' => array('Content-Type' => 'application/json'),
                'timeout' => 30
            ));
            
            if (is_wp_error($response)) {
                wp_send_json_error(array(
                    'message' => 'Error al enviar el mensaje. Por favor, inténtalo de nuevo.'
                ));
            }
            
            $response_code = wp_remote_retrieve_response_code($response);
            if ($response_code !== 200 && $response_code !== 204) {
                wp_send_json_error(array(
                    'message' => 'Error al enviar el mensaje. Código de respuesta: ' . $response_code
                ));
            }
            
            wp_send_json_success(array(
                'message' => '¡Mensaje enviado correctamente! Te responderemos pronto.'
            ));
        }
        
        /**
         * Enviar mensaje a Discord
         */
        private function send_to_discord($webhook_url, $name, $email, $subject, $message) {
            $embed = array(
                'title' => !empty($subject) ? $subject : 'Nuevo mensaje de contacto',
                'color' => 3447003, // Azul
                'fields' => array(
                    array(
                        'name' => 'Nombre',
                        'value' => $name,
                        'inline' => true
                    ),
                    array(
                        'name' => 'Email',
                        'value' => $email,
                        'inline' => true
                    ),
                    array(
                        'name' => 'Mensaje',
                        'value' => $message,
                        'inline' => false
                    )
                ),
                'timestamp' => gmdate('c'),
                'footer' => array(
                    'text' => get_bloginfo('name')
                )
            );
        }
    
    /**
     * Cargar funcionalidad de administración
     */
    private function load_admin() {
        require_once DCF_PLUGIN_DIR . 'admin/class-dcf-admin.php';
        new DCF_Admin();
    }
    
    /**
     * Obtener campos por defecto del formulario
     */
    public function get_default_fields() {
        // Obtener campos guardados o usar valores por defecto según idioma
        return get_option('dcf_form_fields', dcf_get_default_fields_by_language());
    }
    
    /**
     * Generar timestamp traducido para Discord
     */
    private function get_discord_timestamp() {
        $now = current_time('timestamp');
        $today = gmdate('Y-m-d', $now);
        $yesterday = gmdate('Y-m-d', strtotime('-1 day', $now));
        $current_date = gmdate('Y-m-d', $now);
        $time_format = gmdate('H:i', $now);
        
        if ($current_date === $today) {
            return sprintf($this->get_translation('discord_timestamp_today'), $time_format);
        } elseif ($current_date === $yesterday) {
            return sprintf($this->get_translation('discord_timestamp_yesterday'), $time_format);
        } else {
            $date_format = gmdate('d/m/Y', $now);
            return sprintf($this->get_translation('discord_timestamp_date'), $date_format, $time_format);
        }
    }
    
    /**
     * Obtener traducción para el frontend
     */
    private function get_translation($key) {
        static $translations = null;
        
        if ($translations === null) {
            $language = get_option('dcf_language', 'es_ES');
            $lang_file = DCF_PLUGIN_DIR . 'languages/discord-contact-form-' . $language . '.php';
            
            if (file_exists($lang_file)) {
                $translations = include $lang_file;
            } else {
                // Fallback a español si no existe el archivo
                $translations = include DCF_PLUGIN_DIR . 'languages/discord-contact-form-es_ES.php';
            }
        }
        
        return isset($translations[$key]) ? $translations[$key] : $key;
    }
    
    /**
     * Localizar descripción del plugin según idioma de WordPress
     */
    public function localize_plugin_description($plugins) {
        $plugin_file = plugin_basename(__FILE__);
        
        if (isset($plugins[$plugin_file])) {
            // Detectar si es idioma español
            $wp_locale = get_locale();
            $is_spanish = dcf_is_spanish_locale($wp_locale);
            
            // Cargar traducciones
            $translations = $this->get_translation('plugin_description');
            
            // Si hay traducción disponible, usarla
            if ($translations && $translations !== 'plugin_description') {
                $plugins[$plugin_file]['Description'] = $translations;
            } else {
                // Fallback según idioma detectado
                if ($is_spanish) {
                    $plugins[$plugin_file]['Description'] = 'Formulario de contacto avanzado que envía las consultas directamente a servidores de Discord mediante la API de webhooks. Soporte multiidioma con detección automática de idioma.';
                } else {
                    $plugins[$plugin_file]['Description'] = 'Advanced contact form that sends submissions directly to Discord servers using webhooks API. Multilingual support with automatic language detection.';
                }
            }
        }
        
        return $plugins;
    }
    
    /**
     * Agregar enlace de configuración en la lista de plugins
     */
    public function add_settings_link($links) {
        // Detectar idioma para mostrar texto apropiado
        $wp_locale = get_locale();
        $is_spanish = dcf_is_spanish_locale($wp_locale);
        
        // Texto del enlace según idioma
        $settings_text = $is_spanish ? 'Configuración' : 'Settings';
        
        // Crear enlace a la página de configuración
        $settings_link = '<a href="' . admin_url('admin.php?page=discord-contact-form') . '">' . $settings_text . '</a>';
        
        // Agregar al inicio del array de enlaces
        array_unshift($links, $settings_link);
        
        return $links;
    }
}

// Hook de activación para configuración inicial
register_activation_hook(__FILE__, 'dcf_activate_plugin');

/**
 * Función que se ejecuta al activar el plugin
 */
function dcf_activate_plugin() {
    $wp_locale = get_locale();
    $is_spanish = dcf_is_spanish_locale($wp_locale);
    
    // Solo configurar idioma si no existe ya una configuración previa
    if (get_option('dcf_language') === false) {
        // Detectar si es una variante de español
        if ($is_spanish) {
            update_option('dcf_language', 'es_ES');
        } else {
            // Para cualquier otro idioma, usar inglés por defecto
            update_option('dcf_language', 'en_US');
        }
    }
    
    // Configurar otros valores por defecto si no existen
    if (get_option('dcf_button_text') === false) {
        $default_button_text = $is_spanish ? 'Enviar' : 'Send';
        update_option('dcf_button_text', $default_button_text);
    }
    
    // Configurar campos por defecto según idioma si no existen
    if (get_option('dcf_form_fields') === false) {
        $default_fields = dcf_get_default_fields_by_language($is_spanish);
        update_option('dcf_form_fields', $default_fields);
    }
}

/**
 * Obtener campos por defecto según el idioma
 */
function dcf_get_default_fields_by_language($is_spanish = null) {
    if ($is_spanish === null) {
        $is_spanish = dcf_is_spanish_locale(get_locale());
    }
    
    if ($is_spanish) {
        // Campos en español
        return array(
            array(
                'type' => 'text',
                'label' => 'Tu nombre',
                'name' => 'dcf_name',
                'placeholder' => 'Escribe tu nombre aquí',
                'required' => 1,
                'maxlength' => 400
            ),
            array(
                'type' => 'email',
                'label' => 'Tu correo electrónico',
                'name' => 'dcf_email',
                'placeholder' => 'ejemplo@correo.com',
                'required' => 1,
                'maxlength' => 400
            ),
            array(
                'type' => 'textarea',
                'label' => 'Tu mensaje',
                'name' => 'dcf_message',
                'placeholder' => 'Escribe tu mensaje aquí...',
                'required' => 1,
                'maxlength' => 2000
            )
        );
    } else {
        // Campos en inglés
        return array(
            array(
                'type' => 'text',
                'label' => 'Your name',
                'name' => 'dcf_name',
                'placeholder' => 'Enter your name here',
                'required' => 1,
                'maxlength' => 400
            ),
            array(
                'type' => 'email',
                'label' => 'Your email',
                'name' => 'dcf_email',
                'placeholder' => 'example@email.com',
                'required' => 1,
                'maxlength' => 400
            ),
            array(
                'type' => 'textarea',
                'label' => 'Your message',
                'name' => 'dcf_message',
                'placeholder' => 'Write your message here...',
                'required' => 1,
                'maxlength' => 2000
            )
        );
    }
}

/**
 * Detectar si el locale es una variante de español
 */
function dcf_is_spanish_locale($locale) {
    // Lista de locales de español conocidos
    $spanish_locales = array(
        'es',       // Español genérico
        'es_ES',    // España
        'es_AR',    // Argentina
        'es_MX',    // México
        'es_CO',    // Colombia
        'es_VE',    // Venezuela
        'es_PE',    // Perú
        'es_CL',    // Chile
        'es_EC',    // Ecuador
        'es_GT',    // Guatemala
        'es_CU',    // Cuba
        'es_BO',    // Bolivia
        'es_DO',    // República Dominicana
        'es_HN',    // Honduras
        'es_PY',    // Paraguay
        'es_SV',    // El Salvador
        'es_NI',    // Nicaragua
        'es_CR',    // Costa Rica
        'es_PA',    // Panamá
        'es_UY',    // Uruguay
        'es_PR',    // Puerto Rico
        'es_US'     // Estados Unidos (español)
    );
    
    // Verificar si el locale completo está en la lista
    if (in_array($locale, $spanish_locales)) {
        return true;
    }
    
    // Verificar si empieza con 'es' (para cubrir variantes no listadas)
    if (strpos($locale, 'es') === 0) {
        return true;
    }
    
    return false;
}

// Inicializar el plugin
new DiscordContactForm();
