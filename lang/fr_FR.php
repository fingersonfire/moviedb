<?php
/**
 * This is the language file. If you want the website to be in your own language, translate the following lines and
 * change the configuration settings where you add the new language and update the default language:
 * 
 * config.php:
 * $settings["languages"] = array("English" => "en_US"); -> $settings["languages"] = array("English" => "en_US", "Nederlands" => "nl_NL");
 * $settings["defaultlanguage"] = "en_US" -> $settings["defaultlanguage"] = "nl_NL";
 * 
 * When you want your translation to be included in the next php4dvd release, please send me a message on http://sourceforge.net/projects/php4dvd/
 */

/**
 * Title
 */
define("_TITLE",									"Ma Collection de Films");

/**
 * Menu
 */
define("MY_COLLECTION",								"Ma collection");
define("HOME",										"Accueil");
define("MY_PROFILE",								"Mon Profil");
define("USER_MANAGEMENT",							"Gestion des utilisateurs");
define("LOG_IN", 									"Connexion");
define("LOG_OUT",									"Deconnexion");
define("ARE_YOU_SURE_YOU_WANT_TO_LOG_OUT",			"Êtes-vous sûr de vouloir vous déconnecter ?");

/**
 * Log in page
 */
define("USER_NAME",									"Nom d'utilisateur");
define("PASSWORD",									"Mot de passe");
define("INCORRECT_USERNAME_OR_PASSWORD",			"Utilisateur ou mot de passe incorrect");

/**
 * Home
 */
// Menu
define("ADD_MOVIE",									"Ajouter un film");
define("UPDATE_ALL_MOVIE_INFORMATION",				"Tout mettre à jour");
define("EXPORT_TO_CSV",								"Exporter");
// Search
define("SEARCH_DEFAULT_TEXT",						"Recherche de films...");
define("ALL_CATEGORIES",							"Toutes les catégories");
define("SORT_BY",									"Trier par");
define("name asc",									"nom (A-Z)");
define("name desc",									"nom (Z-A)");
define("year asc",									"année (0-9)");
define("year desc",									"année (9-0)");
define("rating asc",								"note (0-9)");
define("rating desc",								"note (9-0)");
define("format asc",								"format (A-Z)");
define("format desc",								"format (Z-A)");
define("seen asc",									"vu");
define("seen desc",									"vu inversé");
define("own asc",									"possédé");
define("own desc",									"possédé inverse");
define("added asc",									"date d'ajout (de ancien à récent)");
define("added desc",								"date d'ajout (de récent à ancien)");
define("loaned asc",								"prété (de ancien à récent");
define("loaned desc",								"prété (de récent à ancien)");
define("ALL", 										"Tout");
define("RESULTS_PER_PAGE",							"résultats par page");
// Results
define("NO_RESULTS_FOUND",							"Aucun film trouvé.");
define("NO_COVER",									"Aucune couverture");

/**
 * Movie
 */
// Menu
define("VISIT_IMDB",								"Visiter IMDb");
define("VIEW_TRAILER",								"Voir le lancement");
define("DOWNLOAD_COVER",							"Télécharger la couverture");
define("OWN",										"Possédé");
define("NOT_OWN",									"Non possédé");
define("SEEN",										"Vu");
define("UNSEEN",									"Non vu");
define("EDIT",										"Editer");
define("REMOVE",									"Supprimer");
// Movie information
define("LOANED_OUT",								"Prêté");
define("TO",										"à");
define("ON",										"le");
define("MINUTES",									"minutes");

/**
* Add/edit movie
*/
// Menu
define("SAVE",										"Enregistrer");
define("UPDATE",									"Mettre à jour");
define("REMOVE_COVER",								"Enlever la couverture");
// IMDb search
define("ADD_FROM_IMDB",								"Ajouter depuis IMDb");
define("SEARCH",									"Rechercher");
define("RESULTS_FROM_IMDB",							"Résultats depuis IMDb");
// Movie information
define("MOVIE_INFORMATION",							"Information du film");
define("IMDB_NUMBER",								"Identifiant IMDb");
define("TITLE",										"Titre");
define("AKA_TITLES",								"Aussi connu comme");
define("YEAR",										"Année");
define("DURATION_MINUTES",							"Durée (minutes)");
define("RATING",									"Note");
define("FORMAT",									"Format");
define("DVD",										"DVD");
define("I_HAVE_SEEN_THIS_MOVIE",					"J'ai vu ce film");
define("I_OWN_THIS_MOVIE",							"Je possède ce film");
define("LOANED_OUT_TO",								"Prêté à");
define("LOANED_OUT_SINCE",							"Prêté depuis le");
define("YES",										"Oui");
define("NO",										"Non");
define("COVER",										"Couverture");
define("SEARCH_FOR_COVER",							"Recherche de couverture");
define("TRAILER_URL",								"Adresse du lancement");
define("SEARCH_FOR_TRAILER",						"Recherche de lancement");
define("PERSONAL_NOTES",							"Note personnelle");
define("TAGLINES",									"Slogans");
define("PLOT_OUTLINE",								"Intrigue courte");
define("PLOTS",										"Intrigue");
define("LANGUAGES",									"Langues");
define("SUBTITLES",									"Sous-Titres");
define("AUDIO",										"Audio");
define("VIDEO",										"Video");
define("COUNTRY",									"Pays");
define("GENRES",									"Genres");
define("DIRECTOR",									"Metteur en scène");
define("WRITER",									"Ecrivain");
define("PRODUCER",									"Producteur");
define("MUSIC",										"Musique");
define("CAST",										"Casting");
// Automatic update
define("AUTOUPDATE_INFO",							"Vos films sont automatiquement mis-à-jour depuis IMDb. Ceci peut prendre un certain temps, alors merci d'être patient...");
define("STOP_UPDATE",								"Arrêter la mise-à-jour");

/**
* User management
*/
define("NEW_USER",									"Nouvel utilisateur");
define("EMAIL",										"Courriel");
define("AGAIN",										"encore");
define("ROLE",										"Role");
define("GUEST",										"Invité (vue seulement)");
define("EDITOR",									"Editeur");
define("ADMIN",										"Administrateur");
define("USERS",										"Utilisateurs");
define("LAST_LOGGED_IN",							"Dernière connexion");
define("DUPLICATE_USER_NAME_OR_EMAIL",				"Un utilisateur avec le même pseudonyme ou courriel existe déjà!");

/**
 * Messages
 */
define("REMOVE_INSTALL_DIR",						"Pour des raison de sécurité, merci d'enlever le répertoire install/ !");
define("CONFIRM_REMOVE",							"Êtes-vous sûr de vouloir enlever celà?");
define("CONFIRM_REMOVE_COVER",						"Êtes-vous sûr de vouloir enlever cette couverture?");
// Validation
define("VALIDATOR_REQUIRED",						"Ce champ est requis");
define("VALIDATOR_NUMBER",							"Merci d'entrer un nombre valide");
define("VALIDATOR_DIGITS",							"Merci d'entrer des chiffres valides");
define("VALIDATOR_EMAIL",							"Merci d'entrer une adresse courriel valide");
define("VALIDATOR_URL",								"Merci d'entrer une URL valide (http://...)");
define("VALIDATOR_DATE",							"Merci d'entrer une date valide (yyyy-mm-dd)");
define("VALIDATOR_ACCEPT_JPG",						"Merci d'utiliser un format d'image supporté (jpg)");
define("VALIDATOR_EQUAL_TO",						"Les deux valeurs devraient être identique");

/**
 * Installer
 */
define("INSTALLATION",								"Installation");
define("WELCOME",									"Bienvenue");
define("WELCOME_TEXT",								"Bienvenue dans l'assistant d'installation.");
define("NEXT",										"Suivant");
define("PERMISSIONS",								"Permissions");
define("PERMISSIONS_TEXT",							"Les répertoires suivant doivent être créé et requièrent des droits d'écriture:");
define("OK",										"ok");
define("FAILED",									"échec");
define("FIX_PERMISSIONS",							"Changer les droits d'accès sur les répertoires suivant à l'aide de votre client FTP (chmod 0777).");
define("REFRESH",									"Actualiser");
define("CONFIGURATION",								"Configuration");
define("CONFIGURATION_TEXT",						"Remplir ce formulaire de configuration.");
define("DATABASE",									"Base de donnée");
define("HOST",										"Hôte");
define("PORT",										"Port");
define("WEBSITE",									"Site web");
define("URL",										"Url");
define("TEMPLATE",									"Mise en page");
define("LANGUAGE",									"Langue");
define("GUEST_USERS_CAN_SEE_COLLECTION",			"Les utilisateurs Invités peuvent voir ma collection de films");
define("FAILED_TO_WRITE_FILE",						"Echec de l'écriture du fichier");
define("DATABASE_NEW_TEXT",							"Une nouvelle version de la base de donnée va être installée. Toutes tables déjà existantes seront supprimées.!");
define("DATABASE_UPGRADE_TEXT",						"Votre base de donnée va être mise à jour vers la dernière version. Aucune information ne sera supprimée (Une sauvegarde est néanmoins fortement conseillée)..");
define("ACCEPT",									"J'accèpte");
define("FINISHED",									"Terminé");
define("FINISHED_TEXT",								"Votre installation est presque terminée. Cliquez sur le bouton Terminer ci-dessous.");
define("FINISH",									"Terminer");
?>