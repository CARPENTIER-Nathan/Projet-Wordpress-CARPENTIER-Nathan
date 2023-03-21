jQuery( document ).ready(function(s){
    
    //  Formulaire - Utilisateur //
    if(window.location.pathname == "/Cours/wordpress/2023/02/21/65/"){
        if(window.sessionStorage.getItem("JSON") == null){
            let formData = new FormData();
            formData.append('action', 'affichageinscription');
            formData.append('security', front_script.security);
            jQuery.ajax({
                url: front_script.ajax_url,
                xhrFields: {
                    withCredentials: true
                },
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'post',
                success: function(reponse){
                    jQuery('#inscription_utilisateur').html(reponse);
                    jQuery('#submit_utilisateur').on('click', function(e){
                        e.stopPropagation();
                        e.preventDefault();

                        let prenom =  document.getElementById("prenom").value;
                        let nom =  document.getElementById("nom").value;
                        let civilite =  document.getElementById("sexe").value;
                        let email =  document.getElementById("email").value;
                        let date_naissance =  document.getElementById("date-naissance").value;

                        formData.append('action', 'formulaireutilisateur');

                        console.log(prenom);
                        console.log(nom);
                        console.log(email);
                        console.log(civilite);
                        console.log(date_naissance);

                        if( (prenom != "") && (nom != "") && (civilite != "") && (email != "") && (date_naissance != "")){
                            formData.append('prenom', prenom);
                            formData.append('nom', nom);
                            formData.append('civilite', civilite);
                            formData.append('email', email);
                            formData.append('date-naissance', date_naissance);
                            formData.append('error', "Aucune Erreur");
                        }
                        else{
                            formData.append('prenom', null);
                            formData.append('nom', null);
                            formData.append('civilite', null);
                            formData.append('email', null);
                            formData.append('date-naissance', null);
                            formData.append('error', "Manque d'information");
                        }

                        jQuery.ajax({
                            url: front_script.ajax_url,
                            xhrFields: {
                                withCredentials: true
                            },
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            type: 'post',

                            success: function(reponse){
                                if(reponse != null){
                                    window.sessionStorage.setItem('Id_User', reponse);
                                    window.location.replace("http://localhost/Cours/wordpress/2023/02/21/73/");
                                    console.log(reponse);
                                }
                                else{
                                    console.log(reponse);
                                }
                                return false;
                            },
                            error: function(reponse){
                                window.location.replace("http://localhost/Cours/wordpress/2023/02/21/65/");
                                console.log(reponse);
                                return false;
                            }
                        });
            });
                }
            });
        }
        else{
            let formData = new FormData();
            formData.append('action', 'affichagecarte');
            formData.append('security', front_script.security);
            formData.append('JSON', window.sessionStorage.getItem('JSON'));
            jQuery.ajax({
                url: front_script.ajax_url,
                xhrFields: {
                    withCredentials: true
                },
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'post',
                success: function(reponse){
                    jQuery('#carte').html(reponse);
                }
            });
        }
    }
    //---------------------------//

    // Formulaire - Liste Pays //
    if(window.location.pathname == "/Cours/wordpress/2023/02/21/73/"){
        if(window.sessionStorage.getItem('Id_User') !== null){
            // Formulaire - Liste Pays //
            let formData = new FormData();
            formData.append('action', 'affichagelistepays');
            formData.append('security', front_script.security);
            formData.append('Id_User', window.sessionStorage.getItem('Id_User'));

            jQuery.ajax({
                url: front_script.ajax_url,
                xhrFields: {
                    withCredentials: true
                },
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'post',

                success: function(rp){
                    jQuery('#affichage_liste_pays').html(rp);
                    jQuery('.submit_liste_pays').on('click', function(e){
                        e.stopPropagation();
                        e.preventDefault();

                        var ListePaysSelectionner = null;
                        for(var boucle = 0 ; boucle < document.getElementsByClassName('ListePays').length ; boucle++){

                            if( document.getElementsByClassName('ListePays')[boucle].value == "Rien" ){
                                boucle = document.getElementsByClassName('ListePays').length;
                            }
                            else{
                                if(ListePaysSelectionner == null){
                                    ListePaysSelectionner = document.getElementsByClassName('ListePays')[boucle].value;
                                }
                                else{
                                    ListePaysSelectionner = ListePaysSelectionner+","+document.getElementsByClassName('ListePays')[boucle].value;
                                }
                            }
                        }

                        formData.append('action', 'formulairelistepays');

                        if(ListePaysSelectionner != null){
                            formData.append('Liste_Pays', ListePaysSelectionner);
                            formData.append('Id_User', window.sessionStorage.getItem('Id_User'));
                            formData.append('Error', "Aucune Erreur");
                        }
                        else{
                            formData.append('Liste_Pays', null);
                            formData.append('Id_User', null);
                            formData.append('Error', "Pas de pays selectionner");
                        }

                        console.log(ListePaysSelectionner);
                        console.log(window.sessionStorage.getItem('Id_User'));

                        jQuery.ajax({
                            url: front_script.ajax_url,
                            xhrFields: {
                                withCredentials: true
                            },
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            type: 'post',

                            success: function(reponse){
                                if(reponse != null){
                                    window.sessionStorage.setItem('Id_Voyages_Effectuer', reponse);
                                    window.location.replace("http://localhost/Cours/wordpress/2023/03/01/85/");
                                    console.log(reponse);
                                }
                                else{
                                    console.log(reponse);
                                }
                                return false;
                            },
                            error: function(reponse){
                                window.location.replace("http://localhost/Cours/wordpress/2023/02/21/73/");
                                console.log(reponse);
                                return false;
                            }
                        });
                    })

                    jQuery('.ListePays').on('change', function(e){
                        e.stopPropagation();
                        e.preventDefault();

                        var pays_select = null;
                        var verif_value = 0;

                        for(var boucle = 0 ; boucle < document.getElementsByClassName('ListePays').length ; boucle++){

                            if( (document.getElementsByClassName('ListePays')[boucle].value != "Rien") && (boucle == verif_value)){
                                document.getElementsByClassName('ListePays')[boucle+1].hidden = false;
                                verif_value++;
                            }
                            else{
                                document.getElementsByClassName('ListePays')[boucle+1].hidden = true;
                                document.getElementsByClassName('ListePays')[boucle+1].value = "Rien";
                            }
                        }
                    })
                }
            });
        }
        else{
            window.location.replace("http://localhost/Cours/wordpress/2023/02/21/65/");
        }
    }
    //-------------------------//

    // Récapitulatif Final //
    if(window.location.pathname == "/Cours/wordpress/2023/03/01/85/"){
        if(window.sessionStorage.getItem('Id_Voyages_Effectuer') !== null){
            let formData = new FormData();
            formData.append('action', 'getvalue');
            formData.append('security', front_script.security);
            formData.append('Id_Utilisateur', window.sessionStorage.getItem('Id_User'));
            jQuery.ajax({
                url: front_script.ajax_url,
                xhrFields: {
                    withCredentials: true
                },
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: 'post',
                success: function(rp){
                    formData.append('action', 'affichageresultat');
                    formData.append('data', rp);
                    jQuery.ajax({
                        url: front_script.ajax_url,
                        xhrFields: {
                            withCredentials: true
                        },
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        type: 'post',

                        success: function(reponse){
                            jQuery("#resultat_final").html(reponse);
                            let hbs = jQuery('#Script_Modal').attr('src');

                            jQuery.ajax({
                                dataType: "html",
                                url: hbs,

                                success: function(source){
                                    var modal = Handlebars.compile(source);
                                    jQuery("#Modal").html(modal(JSON.parse(rp)));

                                    console.log(rp);

                                    jQuery('#hd-from-final').on('click', function(e){
                                        document.getElementById('Modal').style.display = "block";
                                    });
                        
                                    jQuery('#submit_valider').on('click', function(e){
                                        window.sessionStorage.setItem('JSON', rp);
                                        window.location.replace("http://localhost/Cours/wordpress/2023/02/21/65/");
                                    });
                                }
                            });
                        },
                        error: function(reponse){
                            console.log(reponse);
                        }
                    });
                }
            });
        }
        else{
            window.location.replace("http://localhost/Cours/wordpress/2023/02/21/65/");
        }

    }
    //--------------------//
})