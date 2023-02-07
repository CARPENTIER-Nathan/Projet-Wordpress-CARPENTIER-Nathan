jQuery( document ).ready(function() {

    jQuery('.deleted').on('click', function(e) {
    
        e.stopPropagation();
        e.preventDefault();

        var _this = jQuery(this);

        let formData = new FormData();
        formData.append('action', 'remove');
        formData.append('security', inssetscript.security);
        formData.append('id',_this.data('id'));

        jQuery.ajax({
            url: ajaxurl,
            xhrFields: {
                withCredentials: true
            },
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: 'post',
            success: function(response) {
                _this.closest('tr').fadeOut('slow');
                jQuery('.delete-confirmation').removeClass('hide');
                console.log(response);
                return false;
            }
        });

        return;
    });

    jQuery('#btnUpdate').on('click', function(e) {

        let formData = new FormData();
        
        // Empêche le reload de la page
        e.stopPropagation();
        e.preventDefault();
        
        formData.append('action', 'update');
        formData.append('security', inssetscript.security);
        
        jQuery('#insset_param_update input').each( function() {
        
            let id = jQuery(this).attr('id');
            let value = jQuery(this).val();
            formData.append(id, value);
    
        });
    
        // Requête ajax qui utilise les données de la variable 'formData'
        jQuery.ajax({
    
            url: ajaxurl,
            xhrFields: {
                withCredentials: true
            },
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: 'post',
    
            success: function(rs) {
                jQuery('.update-message').removeClass('hide');
                return false;
            },
    
        });
        
    });
});