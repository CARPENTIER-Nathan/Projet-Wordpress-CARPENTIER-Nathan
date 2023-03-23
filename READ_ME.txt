Projet Wordpress de CARPENTIER Nathan

Nom Extension : NC_Projet

Pour faire fonctionner correctement mon plugin, il faut :
  1- 3 Articles : • Page Utilisateur contenant [FORMULAIRE_UTILISATEUR]
                  • Page Liste Pays contenant [FORMULAIRE_LISTE_PAYS]
                  • Page Récapitulatif contenant [FORMULAIRE_RESULTAT]
                  
  2- Dans le fichier nommé "NC_Projet_Front.js" qui se trouve wp-content\plugins\NC_Projet\Assets\JS , il faut changer quelque ligne :
      • Au ligne 4, 79, 222, 276 et 289 → changer "/Cours/wordpress/2023/02/21/65/" par l'URL de votre Page Utilisateur
      • Au ligne 70, 112 et 192 → changer "/Cours/wordpress/2023/02/21/73/" par l'URL de votre Page Liste Pays
      • Au ligne 183 et 228 → changer "/Cours/wordpress/2023/03/01/85/" par l'URL de votre Page Récapitulatif
      
Voilà, normalement le plugin devrait fonctionner sans problème.
