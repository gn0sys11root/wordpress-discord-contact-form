<?php
/**
 * Traducciones en español para Discord Contact Form
 */

// Prevenir acceso directo
if (!defined('ABSPATH')) {
    exit;
}

return array(
    // General
    'plugin_name' => 'Discord Contact Form',
    'configuration' => 'Configuración',
    'form_editor' => 'Editor de Formulario',
    
    // Página de configuración
    'config_title' => 'Discord Contact Form - Configuración',
    'shortcode_info' => 'Cómo usar el formulario: Para mostrar el formulario de contacto en cualquier página o post, utiliza el shortcode:',
    'webhook_url' => 'URL del Webhook de Discord',
    'webhook_url_desc' => 'Ingresa la URL del webhook de Discord donde se enviarán los mensajes.',
    'webhook_url_help' => '¿Cómo crear un webhook de Discord?',
    'color_customization' => 'Personalización de Colores',
    'text_color' => 'Color del Texto',
    'text_color_desc' => 'Color del texto dentro de los campos del formulario.',
    'bg_color' => 'Color de Fondo',
    'bg_color_desc' => 'Color de fondo de los campos del formulario.',
    'border_color' => 'Color del Borde',
    'border_color_desc' => 'Color del borde de los campos del formulario.',
    'focus_border_color' => 'Color del Borde (Enfocado)',
    'focus_border_color_desc' => 'Color del borde cuando el campo está enfocado.',
    'button_bg_color' => 'Color de Fondo del Botón',
    'button_bg_color_desc' => 'Color de fondo del botón de envío.',
    'button_text_color' => 'Color del Texto del Botón',
    'button_text_color_desc' => 'Color del texto del botón de envío.',
    'button_text' => 'Texto del Botón',
    'button_text_desc' => 'Texto que aparecerá en el botón de envío (ej: "Enviar a nuestro Discord").',
    'language' => 'Idioma',
    'language_desc' => 'Elige el idioma para el panel de administración.',
    'language_spanish' => 'Español',
    'language_english' => 'Inglés',
    'plugin_usage' => 'Uso del Plugin',
    'plugin_usage_desc' => 'Para mostrar el formulario de contacto, usa el siguiente shortcode en cualquier página o post:',
    'configuration_saved' => 'Configuración guardada.',
    
    // Página del editor de formulario
    'form_editor_title' => 'Editor de Formulario - Discord Contact Form',
    'form_editor_desc' => 'Configura los campos de tu formulario de contacto. Puedes agregar, eliminar y personalizar cada campo.',
    'field_type' => 'Tipo de Campo',
    'field_label' => 'Etiqueta',
    'field_label_desc' => 'Texto que aparece como título del campo',
    'field_name' => 'Nombre del Campo',
    'field_name_desc' => 'Nombre técnico del campo (sin espacios, solo letras y guiones)',
    'field_placeholder' => 'Texto de Ayuda (Placeholder)',
    'field_placeholder_desc' => 'Ejemplo: "Escribe tu nombre aquí"',
    'field_maxlength' => 'Máximo de Caracteres',
    'field_maxlength_desc' => 'Límite de caracteres que puede escribir el usuario',
    'field_required' => 'Campo Obligatorio',
    'field_required_desc' => 'Marcar como campo obligatorio',
    'field_types' => array(
        'text' => 'Texto',
        'email' => 'Email',
        'textarea' => 'Área de Texto',
        'tel' => 'Teléfono',
        'number' => 'Número'
    ),
    'add_field' => '+ Agregar Campo',
    'remove_field' => 'Eliminar',
    'save_form' => 'Guardar Formulario',
    'preview' => 'Vista Previa',
    'field_untitled' => 'Campo sin título',
    'form_saved' => 'Formulario guardado correctamente.',
    
    // Campos por defecto del formulario
    'default_name_label' => 'Tu nombre',
    'default_name_placeholder' => 'Escribe tu nombre aquí',
    'default_email_label' => 'Tu correo electrónico',
    'default_email_placeholder' => 'ejemplo@correo.com',
    'default_message_label' => 'Tu mensaje',
    'default_message_placeholder' => 'Escribe tu mensaje aquí...',
    'default_submit_text' => 'Enviar',
    
    // Números de campo
    'field_number' => 'Campo %d',
    
    // Mensajes de Discord
    'discord_message_title' => 'Nuevo mensaje de contacto',
    'discord_timestamp_today' => 'hoy a las %s',
    'discord_timestamp_yesterday' => 'ayer a las %s',
    'discord_timestamp_date' => 'el %s a las %s',
    
    // Descripciones del plugin
    'plugin_description' => 'Formulario de contacto avanzado que envía las consultas directamente a servidores de Discord mediante la API de webhooks. Soporte multiidioma con detección automática de idioma.',
    'plugin_short_description' => 'Formulario de contacto que envía datos directamente a Discord mediante webhooks API de servidores.'
);
