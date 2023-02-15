jQuery( document ).ready(function(){
    jQuery('#liste_pays').on('click', function(e){
        e.stopPropagation();
        e.preventDefault();

        var select_pays = document.getElementById("liste_pays");
        var valeur_select = null;

        nb_pays = select_pays.length;
        for(nb_select = 0; nb_select < nb_pays; nb_select++){
            if(select_pays[nb_select].selected){
                if(valeur_select == null){
                    valeur_select = select_pays.options[nb_select].value;

                }
                else{
                    valeur_select = select_pays.options[nb_select].value+","+valeur_select;
                }
            }
        }

        let formData = new FormData();
        formData.append('action', 'voyagesactif');
        formData.append('security', adminscript.security);
        formData.append('tableau_selected', valeur_select);
        formData.append('taille_tableau', select_pays.length);


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

    jQuery('.PaysNote').on('change', function(e){
        e.stopPropagation();
        e.preventDefault();

        var select_note = null;
        for(var boucle = 0 ; boucle < document.getElementsByClassName('PaysNote').length ; boucle++){
            if(select_note == null){
                select_note = document.querySelectorAll('.PaysNote')[boucle].value;
            }
            else{
                select_note = select_note+","+document.querySelectorAll('.PaysNote')[boucle].value;
            }
        }

        let formData = new FormData();
        formData.append('action', 'voyagesnote');
        formData.append('security', adminscript.security);
        formData.append('tableau_note', select_note);
        formData.append('taille_tableau', document.getElementsByClassName('PaysNote').length);

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

    })

    jQuery('.DispoMajeur').on('change', function(e){
        e.stopPropagation();
        e.preventDefault();

        var select_dispomajeur = null;
        for(var boucle = 0 ; boucle < document.getElementsByClassName('DispoMajeur').length ; boucle++){
            if(document.querySelectorAll('.DispoMajeur')[boucle].checked == true){ 
                if(select_dispomajeur == null){
                    select_dispomajeur = document.querySelectorAll('.DispoMajeur')[boucle].value;
                }
                else{
                    select_dispomajeur = select_dispomajeur+","+document.querySelectorAll('.DispoMajeur')[boucle].value;
                }
            }
        }

        let formData = new FormData();
        formData.append('action', 'voyagesmajeur');
        formData.append('security', adminscript.security);
        formData.append('tableau_dispomajeur', select_dispomajeur);
        formData.append('taille_tableau', document.getElementsByClassName('DispoMajeur').length);

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
    })
    
})