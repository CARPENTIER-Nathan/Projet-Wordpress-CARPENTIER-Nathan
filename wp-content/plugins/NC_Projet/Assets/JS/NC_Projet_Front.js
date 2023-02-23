jQuery( document ).ready(function(){

    console.log("Console log");

    //  Formulaire - Utilisateur //
    jQuery('.test').on('click', function(e){
        e.stopPropagation();
        e.preventDefault();

        let formData = new FormData();

        let prenom =  document.getElementById("prenom").value;
        let nom =  document.getElementById("nom").value;
        let civilite =  document.getElementById("sexe").value;
        let email =  document.getElementById("email").value;
        let date_naissance =  document.getElementById("date-naissance").value;

        formData.append('action', 'formulaireutilisateur');
        formData.append('security', front_script.security);

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
            formData.append('error', null);
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
                window.location.replace("http://localhost/Cours/wordpress/2023/02/21/73/");
                return false;
            },
            error: function(reponse){
                console.log(reponse);
                return false;
            }
        });
    })
    //---------------------------//

})