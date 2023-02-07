jQuery( document ).ready(function() {

    jQuery('#formulaire').on('submit', function(e) {
        e.stopPropagation();
        e.preventDefault();


        jQuery('#formulaire').find('input, textarea, select').each( function(i){
            let id = jQuery(this).attr('id');
            if (typeof id !== 'undefined'){
                formData.append(id, jQuery(this).val());
            }
        });
    

        jQuery("#loading").show();

        jQuery.ajax({
            url: inssetscript.ajax_url,
            xhrFields: {
                withCredentials: true
            },
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            type: 'post',
            success: function(rs, textStatus, jqXHR) {
                jQuery("#loading").hide();
                return false;                
            }
        })

    });

});