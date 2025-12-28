<?php
/**
 * English translations for Discord Contact Form
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

return array(
    // General
    'plugin_name' => 'Discord Contact Form',
    'configuration' => 'Configuration',
    'form_editor' => 'Form Editor',
    
    // Configuration page
    'config_title' => 'Discord Contact Form - Configuration',
    'shortcode_info' => 'How to use the form: To show the contact form on any page or post, use the shortcode:',
    'webhook_url' => 'Discord Webhook URL',
    'webhook_url_desc' => 'Enter the Discord webhook URL where messages will be sent.',
    'webhook_url_help' => 'How to create a Discord webhook?',
    'color_customization' => 'Color Customization',
    'text_color' => 'Text Color',
    'text_color_desc' => 'Text color inside form fields.',
    'bg_color' => 'Background Color',
    'bg_color_desc' => 'Background color of form fields.',
    'border_color' => 'Border Color',
    'border_color_desc' => 'Border color of form fields.',
    'focus_border_color' => 'Border Color (Focused)',
    'focus_border_color_desc' => 'Border color when field is focused.',
    'button_bg_color' => 'Button Background Color',
    'button_bg_color_desc' => 'Background color of submit button.',
    'button_text_color' => 'Button Text Color',
    'button_text_color_desc' => 'Text color of submit button.',
    'button_text' => 'Button Text',
    'button_text_desc' => 'Text that will appear on the submit button (e.g., "Send to our Discord").',
    'language' => 'Language',
    'language_desc' => 'Choose the language for the admin panel.',
    'language_spanish' => 'Spanish',
    'language_english' => 'English',
    'plugin_usage' => 'Plugin Usage',
    'plugin_usage_desc' => 'To display the contact form, use the following shortcode on any page or post:',
    'configuration_saved' => 'Configuration saved.',
    
    // Form Editor page
    'form_editor_title' => 'Form Editor - Discord Contact Form',
    'form_editor_desc' => 'Configure your contact form fields. You can add, remove and customize each field.',
    'field_type' => 'Field Type',
    'field_label' => 'Label',
    'field_label_desc' => 'Text that appears as field title',
    'field_name' => 'Field Name',
    'field_name_desc' => 'Technical field name (no spaces, only letters and hyphens)',
    'field_placeholder' => 'Help Text (Placeholder)',
    'field_placeholder_desc' => 'Example: "Enter your name here"',
    'field_maxlength' => 'Maximum Characters',
    'field_maxlength_desc' => 'Character limit that user can type',
    'field_required' => 'Required Field',
    'field_required_desc' => 'Mark as required field',
    'field_types' => array(
        'text' => 'Text',
        'email' => 'Email',
        'textarea' => 'Text Area',
        'tel' => 'Phone',
        'number' => 'Number'
    ),
    'add_field' => '+ Add Field',
    'remove_field' => 'Remove',
    'save_form' => 'Save Form',
    'preview' => 'Preview',
    'field_untitled' => 'Untitled Field',
    'form_saved' => 'Form saved successfully.',
    
    // Default form fields
    'default_name_label' => 'Your name',
    'default_name_placeholder' => 'Enter your name here',
    'default_email_label' => 'Your email',
    'default_email_placeholder' => 'example@email.com',
    'default_message_label' => 'Your message',
    'default_message_placeholder' => 'Write your message here...',
    'default_submit_text' => 'Send',
    
    // Field numbers
    'field_number' => 'Field %d',
    
    // Discord messages
    'discord_message_title' => 'New contact message',
    'discord_timestamp_today' => 'today at %s',
    'discord_timestamp_yesterday' => 'yesterday at %s',
    'discord_timestamp_date' => 'on %s at %s',
    
    // Plugin descriptions
    'plugin_description' => 'Advanced contact form that sends submissions directly to Discord servers using webhooks API. Multilingual support with automatic language detection.',
    'plugin_short_description' => 'Contact form that sends data directly to Discord using server webhooks API.'
);
