/**
 * Discord Contact Form - JavaScript
 * Maneja la funcionalidad AJAX del formulario
 */

(function($) {
    'use strict';
    
    // Inicializar cuando el DOM esté listo
    $(document).ready(function() {
        initContactForms();
    });
    
    /**
     * Inicializar todos los formularios de contacto
     */
    function initContactForms() {
        $('.dcf form').each(function() {
            var $form = $(this);
            var $wrapper = $form.closest('.dcf');
            
            // Configurar el envío del formulario
            $form.on('submit', function(e) {
                e.preventDefault();
                handleFormSubmission($form, $wrapper);
            });
            
            // Limpiar mensajes de error al escribir
            $form.find('input, textarea').on('input', function() {
                clearFieldError($(this));
            });
        });
    }
    
    /**
     * Manejar el envío del formulario
     */
    function handleFormSubmission($form, $wrapper) {
        // Prevenir múltiples envíos
        if ($form.hasClass('submitting')) {
            return;
        }
        
        // Limpiar estados previos
        clearFormMessages($form);
        clearAllFieldErrors($form);
        
        // Establecer estado de envío
        setFormState($form, 'submitting');
        
        // Preparar datos del formulario
        var formData = new FormData($form[0]);
        formData.append('action', 'dcf_submit');
        
        // Enviar vía AJAX
        $.ajax({
            url: dcf_ajax.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            timeout: 30000,
            success: function(response) {
                handleFormSuccess($form, response);
            },
            error: function(xhr, status, error) {
                handleFormError($form, {
                    data: {
                        message: 'Error de conexión. Por favor, inténtalo de nuevo.'
                    }
                });
            },
            complete: function() {
                setFormState($form, 'init');
            }
        });
    }
    
    /**
     * Manejar respuesta exitosa
     */
    function handleFormSuccess($form, response) {
        if (response.success) {
            setFormState($form, 'sent');
            showFormMessage($form, response.data.message, 'success');
            resetForm($form);
            
            // Opcional: scroll al mensaje
            scrollToMessage($form);
            
        } else {
            handleFormError($form, response);
        }
    }
    
    /**
     * Manejar errores del formulario
     */
    function handleFormError($form, response) {
        setFormState($form, 'failed');
        
        var message = 'Hubo un error al procesar tu solicitud.';
        if (response.data && response.data.message) {
            message = response.data.message;
        }
        
        showFormMessage($form, message, 'error');
        scrollToMessage($form);
    }
    
    /**
     * Establecer estado del formulario
     */
    function setFormState($form, state) {
        // Remover todos los estados
        $form.removeClass('init submitting sent failed invalid');
        
        // Agregar nuevo estado
        $form.addClass(state);
        
        // Manejar el botón de envío
        var $submitBtn = $form.find('input[type="submit"]');
        if (state === 'submitting') {
            $submitBtn.prop('disabled', true);
        } else {
            $submitBtn.prop('disabled', false);
        }
    }
    
    /**
     * Mostrar mensaje del formulario
     */
    function showFormMessage($form, message, type) {
        var $output = $form.find('.dcf-response-output');
        $output.html(escapeHtml(message))
               .attr('aria-hidden', 'false')
               .show();
    }
    
    /**
     * Limpiar mensajes del formulario
     */
    function clearFormMessages($form) {
        var $output = $form.find('.dcf-response-output');
        $output.empty()
               .attr('aria-hidden', 'true')
               .hide();
    }
    
    /**
     * Resetear el formulario
     */
    function resetForm($form) {
        $form[0].reset();
        clearAllFieldErrors($form);
    }
    
    /**
     * Limpiar todos los errores de campo
     */
    function clearAllFieldErrors($form) {
        $form.find('input, textarea').removeClass('dcf-not-valid');
        $form.find('.dcf-not-valid-tip').remove();
    }
    
    /**
     * Limpiar error de un campo específico
     */
    function clearFieldError($field) {
        $field.removeClass('dcf-not-valid');
        $field.closest('span').find('.dcf-not-valid-tip').remove();
    }
    
    /**
     * Mostrar error en un campo específico
     */
    function showFieldError($field, message) {
        $field.addClass('dcf-not-valid');
        
        var $wrap = $field.closest('span');
        var $existingTip = $wrap.find('.dcf-not-valid-tip');
        
        if ($existingTip.length) {
            $existingTip.text(message);
        } else {
            $('<span class="dcf-not-valid-tip">' + escapeHtml(message) + '</span>')
                .insertAfter($field);
        }
    }
    
    /**
     * Hacer scroll al mensaje
     */
    function scrollToMessage($form) {
        var $output = $form.find('.dcf-response-output');
        if ($output.length && $output.is(':visible')) {
            $('html, body').animate({
                scrollTop: $output.offset().top - 100
            }, 500);
        }
    }
    
    /**
     * Escapar HTML para prevenir XSS
     */
    function escapeHtml(text) {
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }
    
    /**
     * Validación en tiempo real (opcional)
     */
    function setupRealTimeValidation($form) {
        // Validar email
        $form.find('input[type="email"]').on('blur', function() {
            var $field = $(this);
            var email = $field.val().trim();
            
            if (email && !isValidEmail(email)) {
                showFieldError($field, 'Por favor, ingresa un email válido');
            }
        });
        
        // Validar campos requeridos
        $form.find('[required]').on('blur', function() {
            var $field = $(this);
            var value = $field.val().trim();
            
            if (!value) {
                showFieldError($field, 'Este campo es requerido');
            }
        });
    }
    
    /**
     * Validar formato de email
     */
    function isValidEmail(email) {
        var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    
    // Exponer funciones públicas si es necesario
    window.DCF = {
        init: initContactForms,
        resetForm: function(formId) {
            var $form = $('#' + formId + ' form');
            if ($form.length) {
                resetForm($form);
                setFormState($form, 'init');
            }
        }
    };
    
})(jQuery);
