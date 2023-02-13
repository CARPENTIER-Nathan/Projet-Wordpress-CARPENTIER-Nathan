jQuery( document ).ready(function(){
    jQuery('#liste_pays').on('click', function(e){
        e.stopPropagation();
        e.preventDefault();

        var _this = jQuery(this);

        var select = document.getElementById("liste_pays");
        var valeur_select = null;

        nb_pays = select.length;
        for(nb_select = 0; nb_select < nb_pays; nb_select++){
            if(select[nb_select].selected){
                if(valeur_select == null){
                    valeur_select = select.options[nb_select].value;

                }
                else{
                    valeur_select = select.options[nb_select].value+","+valeur_select;
                }
            }
        }

        let formData = new FormData();
        formData.append('action', 'voyagesactif');
        formData.append('security', adminscript.security);
        formData.append('tableau_selected', valeur_select);
        formData.append('taille_tableau', select.length);


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

            success: function(reponse){
                console.log(reponse);
                return false;
            },
            error: function(reponse){
                console.log(reponse);
                return false;
            }
        });

        return;
    })

})