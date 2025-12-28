<?php
/**
 * Template para el editor de formulario del admin
 */

// Prevenir acceso directo
if (!defined('ABSPATH')) {
    exit;
}

// Obtener instancia del admin para acceder a get_default_fields
$admin = new DCF_Admin();
$form_fields = get_option('dcf_form_fields', $admin->get_default_fields());
?>

<div class="wrap">
    <h1><?php $this->t('form_editor_title'); ?></h1>
    
    <div class="notice notice-info">
        <p><strong><?php $this->t('shortcode_info'); ?></strong> <code>[discord_contact_form]</code></p>
    </div>
    
    <p><?php $this->t('form_editor_desc'); ?></p>
    
    <form method="post" action="" id="dcf-form-editor">
        <div id="dcf-fields-container">
            <?php foreach ($form_fields as $index => $field): ?>
                <div class="dcf-field-row" data-index="<?php echo esc_attr($index); ?>">
                    <div class="dcf-field-header">
                        <h3><?php printf(esc_html($this->get_translation('field_number')), esc_html($index + 1)); ?></h3>
                        <button type="button" class="dcf-remove-field button"><?php $this->t('remove_field'); ?></button>
                    </div>
                    
                    <table class="form-table">
                        <tr>
                            <th><label><?php $this->t('field_type'); ?></label></th>
                            <td>
                                <select name="form_fields[<?php echo esc_attr($index); ?>][type]" class="dcf-field-type">
                                    <?php $field_types = $this->get_translation('field_types'); ?>
                                    <option value="text" <?php selected($field['type'], 'text'); ?>><?php echo esc_html($field_types['text']); ?></option>
                                    <option value="email" <?php selected($field['type'], 'email'); ?>><?php echo esc_html($field_types['email']); ?></option>
                                    <option value="textarea" <?php selected($field['type'], 'textarea'); ?>><?php echo esc_html($field_types['textarea']); ?></option>
                                    <option value="tel" <?php selected($field['type'], 'tel'); ?>><?php echo esc_html($field_types['tel']); ?></option>
                                    <option value="number" <?php selected($field['type'], 'number'); ?>><?php echo esc_html($field_types['number']); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th><label><?php $this->t('field_label'); ?></label></th>
                            <td>
                                <input type="text" name="form_fields[<?php echo esc_attr($index); ?>][label]" value="<?php echo esc_attr($field['label']); ?>" class="regular-text" />
                                <p class="description"><?php $this->t('field_label_desc'); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th><label><?php $this->t('field_name'); ?></label></th>
                            <td>
                                <input type="text" name="form_fields[<?php echo esc_attr($index); ?>][name]" value="<?php echo esc_attr($field['name']); ?>" class="regular-text" />
                                <p class="description"><?php $this->t('field_name_desc'); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th><label><?php $this->t('field_placeholder'); ?></label></th>
                            <td>
                                <input type="text" name="form_fields[<?php echo esc_attr($index); ?>][placeholder]" value="<?php echo esc_attr($field['placeholder']); ?>" class="regular-text" />
                                <p class="description"><?php $this->t('field_placeholder_desc'); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th><label><?php $this->t('field_maxlength'); ?></label></th>
                            <td>
                                <input type="number" name="form_fields[<?php echo esc_attr($index); ?>][maxlength]" value="<?php echo esc_attr($field['maxlength']); ?>" min="1" max="10000" />
                                <p class="description"><?php $this->t('field_maxlength_desc'); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th><label><?php $this->t('field_required'); ?></label></th>
                            <td>
                                <label>
                                    <input type="checkbox" name="form_fields[<?php echo esc_attr($index); ?>][required]" value="1" <?php checked($field['required'], 1); ?> />
                                    <?php $this->t('field_required_desc'); ?>
                                </label>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="dcf-editor-actions">
            <button type="button" id="dcf-add-field" class="button button-secondary"><?php $this->t('add_field'); ?></button>
            <?php submit_button($this->get_translation('save_form'), 'primary', 'save_form'); ?>
        </div>
    </form>
    
    <div class="dcf-preview-section">
        <h2><?php $this->t('preview'); ?></h2>
        <div id="dcf-preview-container">
            <!-- La vista previa se generará aquí con JavaScript -->
        </div>
    </div>
</div>
