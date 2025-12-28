<?php
/**
 * Template para la página de configuración del admin
 */

// Prevenir acceso directo
if (!defined('ABSPATH')) {
    exit;
}

// Obtener valores actuales
$webhook_url = get_option('dcf_webhook_url', '');
$text_color = get_option('dcf_text_color', '#333333');
$bg_color = get_option('dcf_bg_color', '#ffffff');
$border_color = get_option('dcf_border_color', '#dddddd');
$focus_border_color = get_option('dcf_focus_border_color', '#00a0d2');
$button_bg_color = get_option('dcf_button_bg_color', '#0073aa');
$button_text_color = get_option('dcf_button_text_color', '#ffffff');
$button_text = get_option('dcf_button_text', $this->get_translation('default_submit_text'));
$language = get_option('dcf_language', 'es_ES');
?>

<div class="wrap">
    <h1><?php $this->t('config_title'); ?></h1>
    
    <div class="notice notice-info">
        <p><strong><?php $this->t('shortcode_info'); ?></strong> <code>[discord_contact_form]</code></p>
    </div>
    
    <form method="post" action="">
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="dcf_webhook_url"><?php $this->t('webhook_url'); ?></label>
                </th>
                <td>
                    <input type="url" id="dcf_webhook_url" name="dcf_webhook_url" value="<?php echo esc_attr($webhook_url); ?>" class="regular-text" />
                    <p class="description">
                        <?php $this->t('webhook_url_desc'); ?><br>
                        <a href="https://support.discord.com/hc/en-us/articles/228383668-Intro-to-Webhooks" target="_blank"><?php $this->t('webhook_url_help'); ?></a>
                    </p>
                </td>
            </tr>
        </table>
        
        <h2><?php $this->t('color_customization'); ?></h2>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="dcf_text_color"><?php $this->t('text_color'); ?></label>
                </th>
                <td>
                    <input type="color" id="dcf_text_color" name="dcf_text_color" value="<?php echo esc_attr($text_color); ?>" />
                    <p class="description"><?php $this->t('text_color_desc'); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="dcf_bg_color"><?php $this->t('bg_color'); ?></label>
                </th>
                <td>
                    <input type="color" id="dcf_bg_color" name="dcf_bg_color" value="<?php echo esc_attr($bg_color); ?>" />
                    <p class="description"><?php $this->t('bg_color_desc'); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="dcf_border_color"><?php $this->t('border_color'); ?></label>
                </th>
                <td>
                    <input type="color" id="dcf_border_color" name="dcf_border_color" value="<?php echo esc_attr($border_color); ?>" />
                    <p class="description"><?php $this->t('border_color_desc'); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="dcf_focus_border_color"><?php $this->t('focus_border_color'); ?></label>
                </th>
                <td>
                    <input type="color" id="dcf_focus_border_color" name="dcf_focus_border_color" value="<?php echo esc_attr($focus_border_color); ?>" />
                    <p class="description"><?php $this->t('focus_border_color_desc'); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="dcf_button_bg_color"><?php $this->t('button_bg_color'); ?></label>
                </th>
                <td>
                    <input type="color" id="dcf_button_bg_color" name="dcf_button_bg_color" value="<?php echo esc_attr($button_bg_color); ?>" />
                    <p class="description"><?php $this->t('button_bg_color_desc'); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="dcf_button_text_color"><?php $this->t('button_text_color'); ?></label>
                </th>
                <td>
                    <input type="color" id="dcf_button_text_color" name="dcf_button_text_color" value="<?php echo esc_attr($button_text_color); ?>" />
                    <p class="description"><?php $this->t('button_text_color_desc'); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="dcf_button_text"><?php $this->t('button_text'); ?></label>
                </th>
                <td>
                    <input type="text" id="dcf_button_text" name="dcf_button_text" value="<?php echo esc_attr($button_text); ?>" class="regular-text" />
                    <p class="description"><?php $this->t('button_text_desc'); ?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="dcf_language"><?php $this->t('language'); ?></label>
                </th>
                <td>
                    <select id="dcf_language" name="dcf_language">
                        <option value="es_ES" <?php selected($language, 'es_ES'); ?>><?php $this->t('language_spanish'); ?></option>
                        <option value="en_US" <?php selected($language, 'en_US'); ?>><?php $this->t('language_english'); ?></option>
                    </select>
                    <p class="description"><?php $this->t('language_desc'); ?></p>
                </td>
            </tr>
        </table>
        
        <?php submit_button(); ?>
    </form>
    
    <h2><?php $this->t('plugin_usage'); ?></h2>
    <p><?php $this->t('plugin_usage_desc'); ?></p>
    <code>[discord_contact_form]</code>
</div>
