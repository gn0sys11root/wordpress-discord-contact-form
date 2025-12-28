/**
 * JavaScript para el editor de formulario del admin
 */

jQuery(document).ready(function($) {
    var fieldIndex = $('#dcf-fields-container .dcf-field-row').length;
    
    // Obtener traducciones
    var t = dcf_admin.translations || {};
    var fieldTypes = t.field_types || {
        text: 'Text',
        email: 'Email', 
        textarea: 'Text Area',
        tel: 'Phone',
        number: 'Number'
    };
    
    // Agregar nuevo campo
    $('#dcf-add-field').click(function() {
        var fieldNumber = (t.field_number || 'Field %d').replace('%d', fieldIndex + 1);
        var newField = `
        <div class="dcf-field-row" data-index="${fieldIndex}">
            <div class="dcf-field-header">
                <h3>${fieldNumber}</h3>
                <button type="button" class="dcf-remove-field button">${t.remove_field || 'Remove'}</button>
            </div>
            
            <table class="form-table">
                <tr>
                    <th><label>${t.field_type || 'Field Type'}</label></th>
                    <td>
                        <select name="form_fields[${fieldIndex}][type]" class="dcf-field-type">
                            <option value="text">${fieldTypes.text}</option>
                            <option value="email">${fieldTypes.email}</option>
                            <option value="textarea">${fieldTypes.textarea}</option>
                            <option value="tel">${fieldTypes.tel}</option>
                            <option value="number">${fieldTypes.number}</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label>${t.field_label || 'Label'}</label></th>
                    <td>
                        <input type="text" name="form_fields[${fieldIndex}][label]" value="" class="regular-text" />
                        <p class="description">${t.field_label_desc || 'Text that appears as field title'}</p>
                    </td>
                </tr>
                <tr>
                    <th><label>${t.field_name || 'Field Name'}</label></th>
                    <td>
                        <input type="text" name="form_fields[${fieldIndex}][name]" value="" class="regular-text" />
                        <p class="description">${t.field_name_desc || 'Technical field name (no spaces, only letters and hyphens)'}</p>
                    </td>
                </tr>
                <tr>
                    <th><label>${t.field_placeholder || 'Placeholder'}</label></th>
                    <td>
                        <input type="text" name="form_fields[${fieldIndex}][placeholder]" value="" class="regular-text" />
                        <p class="description">${t.field_placeholder_desc || 'Example: "Enter your name here"'}</p>
                    </td>
                </tr>
                <tr>
                    <th><label>${t.field_maxlength || 'Maximum Characters'}</label></th>
                    <td>
                        <input type="number" name="form_fields[${fieldIndex}][maxlength]" value="400" min="1" max="10000" />
                        <p class="description">${t.field_maxlength_desc || 'Character limit that user can type'}</p>
                    </td>
                </tr>
                <tr>
                    <th><label>${t.field_required || 'Required Field'}</label></th>
                    <td>
                        <label>
                            <input type="checkbox" name="form_fields[${fieldIndex}][required]" value="1" />
                            ${t.field_required_desc || 'Mark as required field'}
                        </label>
                    </td>
                </tr>
            </table>
        </div>`;
        
        $('#dcf-fields-container').append(newField);
        fieldIndex++;
        updatePreview();
    });
    
    // Eliminar campo
    $(document).on('click', '.dcf-remove-field', function() {
        $(this).closest('.dcf-field-row').remove();
        updateFieldNumbers();
        updatePreview();
    });
    
    // Actualizar números de campos
    function updateFieldNumbers() {
        $('.dcf-field-row').each(function(index) {
            var fieldNumber = (t.field_number || 'Field %d').replace('%d', index + 1);
            $(this).find('h3').text(fieldNumber);
        });
    }
    
    // Actualizar vista previa
    function updatePreview() {
        var preview = '<div class="dcf"><form class="dcf-form">';
        
        $('.dcf-field-row').each(function() {
            var type = $(this).find('select[name*="[type]"]').val() || 'text';
            var label = $(this).find('input[name*="[label]"]').val() || (t.field_untitled || 'Untitled Field');
            var placeholder = $(this).find('input[name*="[placeholder]"]').val() || '';
            var required = $(this).find('input[name*="[required]"]').is(':checked');
            var maxlength = $(this).find('input[name*="[maxlength]"]').val() || '400';
            
            preview += '<p><label>' + escapeHtml(label) + (required ? ' *' : '') + '<br>';
            
            if (type === 'textarea') {
                preview += '<span class="dcf-form-control-wrap"><textarea class="dcf-form-control dcf-textarea" placeholder="' + escapeHtml(placeholder) + '" maxlength="' + maxlength + '" cols="40" rows="10"></textarea></span>';
            } else {
                preview += '<span class="dcf-form-control-wrap"><input type="' + type + '" class="dcf-form-control dcf-' + type + '" placeholder="' + escapeHtml(placeholder) + '" maxlength="' + maxlength + '" size="40"></span>';
            }
            
            preview += '</label></p>';
        });
        
        var buttonText = dcf_admin.button_text || 'Send';
        preview += '<p><input type="submit" class="dcf-form-control dcf-submit" value="' + escapeHtml(buttonText) + '" onclick="return false;" style="pointer-events: none;"></p>';
        preview += '</form></div>';
        
        $('#dcf-preview-container').html(preview);
    }
    
    // Función para escapar HTML
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
    
    // Actualizar vista previa cuando cambien los campos
    $(document).on('input change', '#dcf-fields-container input, #dcf-fields-container select', function() {
        updatePreview();
    });
    
    // Generar vista previa inicial
    updatePreview();
});
