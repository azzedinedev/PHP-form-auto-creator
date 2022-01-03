<?php
//+---------------------------------------------------------------------+
//|	class.form.php													 	|
//+---------------------------------------------------------------------+
//|	Forms handling class												|
//|	Création de la classe par :											|
//|		SAR Azzeddine: azzedinedev@gmail.com							|
//|		Creation le : 04/04/2007										|
//+---------------------------------------------------------------------+
//|	Version 3 :													 		|
//|		* add list trags												|
//+---------------------------------------------------------------------+

/*
if (!class_exists('FCKeditor')) {
	include(dirname(__FILE__)."/../editor/fckeditor.php");
}
*/

if (!class_exists('db')) {
	include(dirname(__FILE__)."/db/class.db.php");
}

class form
{

	//Base de donnée
	var $user;								//L'utilisateur de la base de donnée
	var $pass;								//Le mot de passe de la base de donnée
	var $host;								//Le serveur de base de donnée
	var $connection;						//la connecion à la base de donnéee
	var $id;								//L'identificateur de l'article
	var $db;								//La de la base de donnée	

	var $_self;								//La page en cours

	//Chemin
	var $nbrPage;							//Nombre de lignes par page
	
	//Formulaire
	var $request;		
	var $css_form_remarque_error;
	var $css_form_remarque_sucess;
	var $css_form_remarque;
	var $form_HTMLInsertQCM_action;
	var $form_HTMLInsertQCM_method;
	var $validFormList;
	var $fieldSubmit;
	var $fieldReset;
	var $txt_HTMLForm_0;
	var $labelSubmit;
	var $labelReset;
	var $Fields;
	var $table_data_to_render;
	var $data_insert;
	var $data_update;
	var $goups_to_show;
	var $sqlTable;
	var $sql;
	var $IdSqlTable;
	var $IdRequest;
	var $db_insert_value;
	var $form_enctype;
	var $form_attributs;
	var $FORM_list_errors_show;
	var $error_openForm;
	var $error_contentForm;
	var $error_closeForm;
	var $error_openForm_attName;
	var $error_openForm_attAction;
	var $error_openForm_attMethode;
	var $is_listOrParagrapheCount;
	var $error_closeTags;
	var $is_listOrParagraphe;
	var $form_title_tag;
	var $form_title;
	var $form_title_adds;
	var $validation_fields;
	var $css_SQLform_succes;
	var $css_SQLform_error;
	var $type_fieldset;	
	var $FormHTML;
	var $FORM_MSG_db_execution_sql;
	var $FORM_MSG_db_insertion;
	var $FORM_MSG_db_suppression_sql;
	var $FORM_MSG_db_update_sql;
	var $FORM_MSG_db_succes;
	var $FORM_MSG_db_connection;
	var $FORM_MSG_xml_encoding;
	var $FORM_MSG_file_error_1;
	var $FORM_MSG_file_error_2;
	var $FORM_MSG_mail_envoie_vers;
	var $FORM_MSG_mail_reussi;
	var $FORM_MSG_mail_echoue;
	var $FORM_MSG_mail_subject_error;
	var $FORM_MSGt_mail_message_error;
	var $FORM_MSG_mail_adresse_from_error;
	var $FORM_MSG_mail_adresse_to_error;
	var $FORM_MSG_mail_adresse_from_error_valid;
	var $FORM_MSG_mail_adresse_to_error_valid;
	var $FORM_MSG_on_succes_error_arg;
	var $FORM_MSG_on_succes_sql_error_arg;
	var $FORM_MSG_SQL_libre_args_errors;
	var $FORM_MSG_SQL_insert_args_errors;
	var $FORM_MSG_SQL_delete_args_errors;
	var $FORM_MSG_SQL_select_args_errors;
	var $FORM_MSG_SQL_update_args_errors;
	var $FORM_MSG_SQL_opField_args_errors;
	var $FORM_MSG_SQL_Field_args_errors;
	var $FORM_MSG_SQL_Value_args_errors;
	var $FORM_MSG_SQL_opValue_args_errors;
	var $FORM_MSG_SQL_dataArray_args_errors;
	var $FORM_MSG_on_succes_xmlfile_error_arg;
	var $FORM_MSG_on_succes_xmlmail_error_arg;
	var $FORM_MSG_on_succes_file_error_arg;
	var $FORM_MSG_on_succes_mail_error_arg;
	var $FORM_MSG_on_succes_message_error_arg;
	var $FORM_MSG_on_succes_func_error_arg;
	var $FORM_MSG_number_errors;
	var $FORM_MSG_copyFile_errors;
	var $FORM_MSG_requestFile_errors;
	var $FORM_MSG_ExtensionFile_errors;
	var $FORM_MSG_ExistFile_errors;
	var $FORM_MSG_sucess_copyFiles;
	var $FORM_MSG_number_errors_copyFiles;
	var $FORM_MSG_RenameFile_errors;
	var $FORM_MSG_DeclarationFile_errors;
	var $FORM_MSG_DeclarationFile_etarget_path_rrors;
        var $FORM_MSG_counter_decrement;
                
	/**	
	 * Constructeur de la class form
	**/	
	function form()
	{

		$this->id      				= NULL;
		$this->connection			= NULL;

		$this->_self				= $_SERVER['PHP_SELF'];
        $this->database = new db();
                
		$this->path_calendar_page 		= dirname(__FILE__)."/calandar/";
		$this->path_calendar_page_image 	= $this->path_calendar_page.'images/calendar.png';
		$this->path_captcha_page		= "../functions/form/captcha/captchasecurityimages.php";
		$this->request 				= $_POST;
		$this->form_title_tag 			= 'h1';
		$this->form_title			= "";
		$this->form_title_adds			= "";
        $this->is_utf8encode                    = false;
		$this->css_general_remarque_error	= 'class = "formfails"'; 
		$this->css_form_remarque_error		= 'class = "messageAlerte"'; //'class = "form_remarque_error"';
		$this->css_form_remarque_sucess		= 'class = "form_remarque_sucess"';		
		$this->css_form_remarque		= 'class = "form_remarque"';
		
		$this->form_remarque_balise_error	= 'class = "baliserror"';//'class = "form_remarque_balise_error"';
        
                $this->css_general_remarque_succes      = 'class = "formsucess"';
                $this->type_fieldset                    = "fieldset";
                $this->class_fieldset_as_div            = "fieldsetdiv";
                $this->class_legend_as_div              = "fieldsetdivhead";
        
		//calandrier
		$this->calandarOnCall = false;
		$this->calandarIsUsed = false;
		
		$this->form_action 					= $_SERVER['PHP_SELF'];		//Action de l'envoi du formulaire
		$this->form_method 					= "POST";					//Methode de l'envoi du formulaire
		$this->validFormList                                    = array();					//Tableau contenant les erreurs du formulaire	
		$this->Fields						= array();					//La liste des champs
		$this->FormHTML 					= "";						//Concatener le code HTML du champs
		$this->table_data_to_render                             = array();					//DEFAULT: $this->request
		$this->data_insert					= array();					//Tableau contenant les valeurs à inserer dans la base de donée
		$this->data_update					= array();					//Tableau contenant les valeurs à mise à jour dans la base de donée
		$this->groups_to_show                                   = array();					//Tableau groupes de sépartion d'affichage ou de masquage des portions de champs de formulaire selon le profile
		$this->sqlTable						= "";						//Nom de la table de la base de donnée
		$this->IdSqlTable					= "";						//Identificateur de la table de la base de donnée
		$this->IdRequest					= "id";						//Identificateur du request à comparer 
		$this->sql							= "";						//SQL query intialised afetr initialisation function;
		
		$this->form_enctype                 = '';	//s'il y a un fichier alors afficher l'encrypt => 'enctype="multipart/form-data"' sinon => ''
		$this->form_attributs               = array();
		$this->FORM_list_errors_show        = array();
                $this->form_attribut_class  = ""; //Class de la form sans l'atribut (class)
		$this->is_listOrParagrapheCount     = 0;
		$this->is_listOrParagraphe          = "";
		$this->is_to_update                 = false;
		$this->is_error_OnUpdate            = false;
		$this->FORM_list_errors_submit      = array();
		$this->validation_fields            = array();
		$this->db_insert_value              = "";
		
		$this->fieldSubmit 					= "submit"; 						//Nom du champs submit
		$this->fieldReset 					= "reset"; 							//Nom du champs reset
		$this->txt_HTMLForm_0                                   = "erreur dans le champs";
		
		$this->labelSubmit					= "Valider";
		$this->labelReset 					= "Annuler";

		$this->txt_HTMLForm_0                                   = "erreur dans le champs";
		$this->error_openForm                                   = "Il y a une erreur lors de l'ouverture du formulaire.";
		$this->error_contentForm                                = "Vous devez spécifier le contenue du formulaire.";
		$this->error_closeForm                                  = "Il y a une erreur lors de la fermeture du formulaire.";
		$this->error_openForm_attName                           = "Vous devez spécifier le nom du formulaire";
		$this->error_openForm_attAction                         = "Vous devez spécifier la page d'action du formulaire";
		$this->error_openForm_attMethode                        = "Vous devez spécifier la methode du formulaire";
		$this->error_closeTags                                  = "Il y des erreurs d'ouvrture et de fermeture des balises.";
		$this->mail_from_name                                   = "Webmaster";
		$this->FORM_MSG_db_execution_sql                        = "Le traitement dans la base de donnée à echoué";
		$this->FORM_MSG_db_insertion                            = "L'insertion dans la base de donnée à echoué";
		$this->FORM_MSG_db_suppression_sql                      = "La suppression dans la base de donnée à echoué";
		$this->FORM_MSG_db_update_sql                           = "La mise à jour dans la base de donnée à echoué";
		$this->FORM_MSG_db_succes                               = "Le traitement dans la base de donnée est éffectué avec succès";
		$this->FORM_MSG_db_connection                           = "Il faut se connecter à la base de donnée";
		$this->FORM_MSG_xml_encoding                            = "UTF-8";
		$this->FORM_MSG_file_error_1                            = "Pas possible d'ecrire dans le fichier [Vérifier les modes d'écriture]";
		$this->FORM_MSG_file_error_2                            = "Pas possible d'ecrire dans le fichier [pas de fichier | pas de contenue]";
		$this->FORM_MSG_mail_envoie_vers                        = "envoie vers ";
		$this->FORM_MSG_mail_reussi                             = " réussi";
		$this->FORM_MSG_mail_echoue                             = " echoué";
		$this->FORM_MSG_mail_subject_error                      = "Veuillez spécifier le sujet de l'envoie";
		$this->FORM_MSGt_mail_message_error                     = "Veuillez spécifier le message de l'envoie";
		$this->FORM_MSG_mail_adresse_from_error                 = "Veuillez spécifier l'adresse éléctronique de l'expiditeur de l'envoie";
		$this->FORM_MSG_mail_adresse_to_error                   = "Veuillez spécifier l'adresse éléctronique des distinataires de l'envoie";
		$this->FORM_MSG_mail_adresse_from_error_valid           = "L'adresse éléctronique du l'expéditeur est inavalide";
		$this->FORM_MSG_mail_adresse_to_error_valid             = "L'adresse éléctronique du distinataire est inavalide";
		$this->FORM_MSG_on_succes_error_arg                     = "Veuillez spécifier les arguments de la fonction générée dans le cas du succès de l'envoi du formulaire";
		$this->FORM_MSG_on_succes_sql_error_arg                 = "Veuillez spécifier les arguments de la requête SQL générée dans le cas du succès de l'envoi du formulaire";
		$this->FORM_MSG_SQL_libre_args_errors                   = "Vous devez spécifier la reqête dans la troisième case du tableau de l'argument ";
		$this->FORM_MSG_SQL_insert_args_errors                  = "Vous devez spécifier les arguments de la reqête d'insertion dans la troisième case du tableau de l'argument ";
		$this->FORM_MSG_SQL_delete_args_errors                  = "Vous devez spécifier les arguments de la reqête de suppression dans la troisième case du tableau de l'argument ";
		$this->FORM_MSG_SQL_select_args_errors                  = "Vous devez spécifier les arguments de la reqête de selection dans la troisième case du tableau de l'argument ";
		$this->FORM_MSG_SQL_update_args_errors                  = "Vous devez spécifier les arguments de la reqête d'insertion dans la troisième case du tableau de l'argument ";
		$this->FORM_MSG_SQL_opField_args_errors                 = "Il y a une erreur d'opérateur de clauses";
		$this->FORM_MSG_SQL_Field_args_errors                   = "Il y a une erreur de déclartion du nom du champs de la table de la base de donnée";
		$this->FORM_MSG_SQL_Value_args_errors                   = "Il y a une erreur de déclartion du nom du champs du formulaire";
		$this->FORM_MSG_SQL_opValue_args_errors                 = "Il y a une erreur d'opérateur de valeurs";
		$this->FORM_MSG_SQL_dataArray_args_errors               = "Vous devez spécifier la troisième case du tableau de l'argument comme tablau";
		$this->FORM_MSG_on_succes_xmlfile_error_arg             = "Veuillez spécifier un nom de fichier valide";
		$this->FORM_MSG_on_succes_xmlmail_error_arg             = "Veuillez spécifier le sujet, l'expiditeur et le distinataire du l'envoie";
		$this->FORM_MSG_on_succes_file_error_arg                = "Veuillez spécifier un nom de fichier valide et son contenue";
		$this->FORM_MSG_on_succes_mail_error_arg                = "Veuillez spécifier le sujet, le message, l'expiditeur et le distinataire du l'envoie";
		$this->FORM_MSG_on_succes_message_error_arg             = "Veuillez spécifier le message à afficher";
		$this->FORM_MSG_on_succes_func_error_arg                = "Veuillez spécifier le nom de la fonction et ses arguments";
		$this->FORM_MSG_number_errors                           = "Il y a des erreurs dans le formulaire. le nombre des erreurs est : ";
		$this->FORM_MSG_copyFile_errors                         = "Il y a une erreur lors copiage du fichier";
        $this->FORM_MSG_sizeFile_errors                         = "Il y a une erreur de la taille du fichier";
        $this->FORM_MSG_typeFile_errors                         = "Il y a une erreur dans le type du fichier";
		$this->FORM_MSG_requestFile_errors                      = "Il y a une erreur de récupération du fichier";
		$this->FORM_MSG_ExtensionFile_errors                    = "L'extension du fichier est invalide";
		$this->FORM_MSG_ExistFile_errors                        = "Le fichier existe déja";
		$this->FORM_MSG_sucess_copyFiles                        = "Le copiage des fichiers est éffectué avec succès.";
		$this->FORM_MSG_number_errors_copyFiles                 = "Il y des erreurs lors du copiage des fichiers. Le nombre d'erreur est : ";
		$this->FORM_MSG_RenameFile_errors                       = "Il y a une erreur de configuration du nouveau nom du fichier";
		$this->FORM_MSG_DeclarationFile_errors                  = "Il y aune erreur de déclaration du fichier";
		$this->FORM_MSG_DeclarationFile_etarget_path_rrors      = "Il y aune erreur de déclaration du chemin du fichier";
		$this->FORM_Editor_langauge				= "ar"; //Suffix du fichier de config [ ar OU fr }

		return;
	}

	/**
	 * loadDBconnection($dbconnection):
	 * Fonction permettant la connection à la base de donnée
	**/
	function loadDBconnection($dbconnection)
	{   
            $this->database->connection  = $dbconnection;
            $this->connection = $this->database->connection;
	}
        
        /**
	 * connectDB():
	 * Fonction permettant la connection à la base de donnée
	**/
	function connectDB($user,$pass,$host,$db)
	{   
            $this->database->connectDB($user,$pass,$host,$db);
            $this->connection = $this->database->connection;
	}
	
        /**
	 * deconnectDB():
	 * Fonction permettant la deconnection à la base de donnée
	**/
	function deconnectDB()
	{
            $this->database->deconnectDB();
            $this->connection = NULL;
	}
	
    /**
     * Escapes a string according to the current DBMS's standards
     * @param string $str  the string to be escaped
     * @return string  the escaped string
    **/
    function escapeDB($str)
    {
        return $this->database->escapeDB($str);
    }

    /**
     * stripslashes of string from DB
     * @param string $str  the string to be escaped
     * @return string  the escaped string
    **/
	function stripDB($str)
    {
        return $this->database->stripDB($str);
    }

    /**
     * DB_fetch($sql)
     * function publique : rendre un tableau résultant de la reqête spécifié dans ($sql) apres une seule operation d'apelle sql
     * @param string $sql la requête sql
     * @return array : un tableau résultant de la reqête spécifié dans ($sql)
    **/
    function DB_fetch($sql)
    {
	return $this->database->DB_fetch($sql);
    }
	
    /**
     * DB_fetch_list($sql)
     * function publique : rendre une liste de tableau résultant de la reqête spécifié dans ($sql)
     * @param string $sql la requête sql
     * @return array : un tableau résultant de la reqête spécifié dans ($sql)
    **/
   function DB_fetch_list($sql)
    {
	return $this->database->DB_fetch_list($sql);
    }
	
    /**
     * DB_fetch_list($sql)
     * function publique : rendre une liste de tableau résultant de la reqête spécifié dans ($sql)
     * @param string $sql la requête sql
     * @return array : un tableau résultant de la reqête spécifié dans ($sql)
    **/
    function DB_num_rows($sql)
    {
	return $this->database->DB_num_rows($sql);
    }

	/**
	 * DB_res($sql)
	 * function publique : appeller et exécuter la requête SQL
	 * @param string $sql la requête sql
	**/
   	function DB_res($sql)
        {
            return $this->database->DB_res($sql);
        }

	/**
	 * br2nl($text)
	 * @return text : remplace les [\n] par [<br>]
	**/
	function br2nl($text)
	{
    	return  preg_replace('/<br\\s*?\/??>/i', '', $text);
	}
	
	/**
	 * loadmessage($msg)
	 * @param array $msg : Tableau de variable de texte
	 * @return charger les variables de messages
	**/
	function loadmessage($msg)
	{
        $this->txt_HTMLForm_0 = $msg["txt_HTMLForm_0"];
		$this->error_openForm = $msg["error_openForm"];
		$this->error_contentForm = $msg["error_contentForm"];
		$this->error_closeForm = $msg["error_closeForm"];
		$this->error_openForm_attName = $msg["error_openForm_attName"];
		$this->error_openForm_attAction = $msg["error_openForm_attAction"];
		$this->error_openForm_attMethode = $msg["error_openForm_attMethode"];
		$this->error_closeTags = $msg["error_closeTags"];
		$this->mail_from_name = $msg["mail_from_name"];
		$this->FORM_MSG_db_execution_sql = $msg["FORM_MSG_db_execution_sql"];
		$this->FORM_MSG_db_insertion = $msg["FORM_MSG_db_insertion"];
		$this->FORM_MSG_db_suppression_sql = $msg["FORM_MSG_db_suppression_sql"];
		$this->FORM_MSG_db_update_sql = $msg["FORM_MSG_db_update_sql"];
		$this->FORM_MSG_db_succes = $msg["FORM_MSG_db_succes"];
		$this->FORM_MSG_db_connection = $msg["FORM_MSG_db_connection"];
		$this->FORM_MSG_xml_encoding = $msg["FORM_MSG_xml_encoding"];
		$this->FORM_MSG_file_error_1 = $msg["FORM_MSG_file_error_1"];
		$this->FORM_MSG_file_error_2 = $msg["FORM_MSG_file_error_2"];
		$this->FORM_MSG_mail_envoie_vers = $msg["FORM_MSG_mail_envoie_vers"];
		$this->FORM_MSG_mail_reussi = $msg["FORM_MSG_mail_reussi"];
		$this->FORM_MSG_mail_echoue = $msg["FORM_MSG_mail_echoue"];
		$this->FORM_MSG_mail_subject_error = $msg["FORM_MSG_mail_subject_error"];
		$this->FORM_MSGt_mail_message_error = $msg["FORM_MSGt_mail_message_error"];
		$this->FORM_MSG_mail_adresse_from_error = $msg["FORM_MSG_mail_adresse_from_error"];
		$this->FORM_MSG_mail_adresse_to_error = $msg["FORM_MSG_mail_adresse_to_error"];
		$this->FORM_MSG_mail_adresse_from_error_valid = $msg["FORM_MSG_mail_adresse_from_error_valid"];
		$this->FORM_MSG_mail_adresse_to_error_valid = $msg["FORM_MSG_mail_adresse_to_error_valid"];
		$this->FORM_MSG_on_succes_error_arg = $msg["FORM_MSG_on_succes_error_arg"];
		$this->FORM_MSG_on_succes_sql_error_arg = $msg["FORM_MSG_on_succes_sql_error_arg"];
		$this->FORM_MSG_SQL_libre_args_errors = $msg["FORM_MSG_SQL_libre_args_errors"];
		$this->FORM_MSG_SQL_insert_args_errors = $msg["FORM_MSG_SQL_insert_args_errors"];
		$this->FORM_MSG_SQL_delete_args_errors = $msg["FORM_MSG_SQL_delete_args_errors"];
		$this->FORM_MSG_SQL_select_args_errors = $msg["FORM_MSG_SQL_select_args_errors"];
		$this->FORM_MSG_SQL_update_args_errors = $msg["FORM_MSG_SQL_update_args_errors"];
		$this->FORM_MSG_SQL_opField_args_errors = $msg["FORM_MSG_SQL_opField_args_errors"];
		$this->FORM_MSG_SQL_Field_args_errors = $msg["FORM_MSG_SQL_Field_args_errors"];
		$this->FORM_MSG_SQL_Value_args_errors = $msg["FORM_MSG_SQL_Value_args_errors"];
		$this->FORM_MSG_SQL_opValue_args_errors = $msg["FORM_MSG_SQL_opValue_args_errors"];
		$this->FORM_MSG_SQL_dataArray_args_errors = $msg["FORM_MSG_SQL_dataArray_args_errors"];
		$this->FORM_MSG_on_succes_xmlfile_error_arg = $msg["FORM_MSG_on_succes_xmlfile_error_arg"];
		$this->FORM_MSG_on_succes_xmlmail_error_arg = $msg["FORM_MSG_on_succes_xmlmail_error_arg"];
		$this->FORM_MSG_on_succes_file_error_arg = $msg["FORM_MSG_on_succes_file_error_arg"];
		$this->FORM_MSG_on_succes_mail_error_arg = $msg["FORM_MSG_on_succes_mail_error_arg"];
		$this->FORM_MSG_on_succes_message_error_arg = $msg["FORM_MSG_on_succes_message_error_arg"];
		$this->FORM_MSG_on_succes_func_error_arg = $msg["FORM_MSG_on_succes_func_error_arg"];
		$this->FORM_MSG_number_errors = $msg["FORM_MSG_number_errors"];
		$this->FORM_MSG_copyFile_errors = $msg["FORM_MSG_copyFile_errors"];
		$this->FORM_MSG_sizeFile_errors   = $msg["FORM_MSG_sizeFile_errors"];
        $this->FORM_MSG_requestFile_errors = $msg["FORM_MSG_requestFile_errors"];
		$this->FORM_MSG_ExtensionFile_errors = $msg["FORM_MSG_ExtensionFile_errors"];
		$this->FORM_MSG_ExistFile_errors = $msg["FORM_MSG_ExistFile_errors"];
		$this->FORM_MSG_sucess_copyFiles = $msg["FORM_MSG_sucess_copyFiles"];
		$this->FORM_MSG_number_errors_copyFiles = $msg["FORM_MSG_number_errors_copyFiles"];
		$this->FORM_MSG_RenameFile_errors = $msg["FORM_MSG_RenameFile_errors"];
		$this->FORM_MSG_DeclarationFile_errors = $msg["FORM_MSG_DeclarationFile_errors"];
		$this->FORM_MSG_DeclarationFile_etarget_path_rrors = $msg["FORM_MSG_DeclarationFile_etarget_path_rrors"];
        $this->FORM_MSG_counter_decrement = $msg["FORM_MSG_counter_decrement"];
	}
			
		/**
		+-+---------------------------------------------------------------------------------------------------------------------------------------------------------+			
		| |		Example to creation of forms / Exemple de Création du formulaire :                                                                          |
		+-+---------------------------------------------------------------------------------------------------------------------------------------------------------+
		|   $this->openForm("html_qcm", $this->form_action, $this->form_method);                                                                                    |
		|   $this->openFieldset($this->txt_HTMLInsertQCM_1);                                                                                                        |
                |   $this->addHTMLForms("formation_qcm",$this->txt_HTMLInsertQCM_2,"text",$this->stripDB($this->request["formation_qcm"]),"","notempty","","");             |
		|   $this->closeFieldset();                                                                                                                                 |
		|   $this->openFieldset($this->txt_HTMLInsertQCM_3);                                                                                                        |
		|   $this->addHTMLForms("titre_qcm",$this->txt_HTMLInsertQCM_4,"text",$this->stripDB($this->request["titre_qcm"]),"","notempty",                            |
		|   $this->txt_HTMLInsertQCM_Aide_4,"");                                                                                                                    |
		|   $this->addHTMLForms("description_qcm",$this->txt_HTMLInsertQCM_5,"text",$this->stripDB($this->request["description_qcm"]),"","notempty",                |
		|   $this->txt_HTMLInsertQCM_Aide_5,"");                                                                                                                    |
		|   $this->closeFieldset();                                                                                                                                 |
		|   $this->openFieldset($this->txt_HTMLInsertQCM_6);                                                                                                        |
		|   $this->addHTMLForms("debut_qcm",$this->txt_HTMLInsertQCM_7,"text",$this->stripDB($this->request["debut_qcm"]),"","date",                                |
                |   $this->txt_HTMLInsertQCM_Aide_7,"");                                                                                                                    |
		|   $this->addHTMLForms("fin_qcm",$this->txt_HTMLInsertQCM_8,"text",$this->stripDB($this->request["fin_qcm"]),"","date",$this->txt_HTMLInsertQCM_Aide_8,"");|
		|   $this->addHTMLForms("duree_qcm",$this->txt_HTMLInsertQCM_9,"text",$this->stripDB($this->request["duree_qcm"]),"","number",                              |
		|   $this->txt_HTMLInsertQCM_Aide_9,"");                                                                                                                    |
		|   $this->closeFieldset();                                                                                                                                 |
		|   $this->showSubmit($this->fieldSubmit,$this->labelSubmit);                                                                                               |
		|   $this->showReset($this->fieldReset,$this->labelReset);                                                                                                  |
		|   $this->closeForm();                                                                                                                                     |
		+-----------------------------------------------------------------------------------------------------------------------------------------------------------+
		**/
		
		/**
		+-+---------------------------------------------------------------------------------------------------------------------------------------------------------+			
		| |		Exemple de traitement de la validation du formulaire :																								|
		+-+---------------------------------------------------------------------------------------------------------------------------------------------------------+			
		|	Example to use for function call / Exemple d'utilisation de l'appel de fonction :                                                                   |
		|       $this->onSucces(array("fonction", array(array("a" => 15, "b" => 15),'if($a == 15){ $c = $a/2;} return ($c*2)+$b;')));                               |
		+-----------------------------------------------------------------------------------------------------------------------------------------------------------+
		|	Example to use for XML show / Exemple d'utilisation de l'affichage du contenue XML :                                                                |
		| 	$this->onSucces(array("xmlshow"));                                                                                                                  |
		+-----------------------------------------------------------------------------------------------------------------------------------------------------------+
		**/

	/**
	 * isSucces()
	 * @fonction Publique: test la validité de l'envoie du formulaire   
	**/
	function isSucces()
	{
		if( $this->isValidSubmit() && (count($this->FORM_list_errors_submit) == 0) ){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * onSucces()
	 * @fonction Publique: générer le traitement à faire dans le cas de la validité de l'envoie du formulaire
	 * @param array $arrfunc :   
	**/
	function onSucces($arrfunc)
	{
		//Verifier le formulaire
		if( $this->isValidSubmit() ){
			/*
			+-----------------------------------------------------------------------+
			|		Format des fonctions :											|
			+-----------------------------------------------------------------------+
			| toSQL($sqlarr)														|
			| toXML()																|
			| toXMLFile($xml_file)													|
			| toXMLMail($subject, $adresse_from, $adresse_to, $attachement)			|
			| toXMLShow()															|
			| toTable()																|
			| toTableFile($Table_file)												|
			| toTableMail($subject, $adresse_from, $adresse_to, $attachement)		|
			| toTableShow()															|
			| toFile($file,$content)												|
			| toFunc($farr, $code)													|
			| toMessage($message)													|
			| toMail($subject, $message, $adresse_from, $adresse_to, $attachement)	|
			+-----------------------------------------------------------------------+
			*/

			if( !is_array($arrfunc) ){
				$this->FORM_list_errors_submit[] = $this->FORM_MSG_on_succes_error_arg;
			}else{
				$type_func = $arrfunc[0];
				$args_func = $arrfunc[1];

				switch($type_func){
					case "sql" :
						$this->verifArgstoSQL($args_func);
						break;
					case "xmlfile" :
						$this->verifArgstoXMLFile($args_func);
						break;
					case "xmlmail" :
						$this->verifArgstoXMLMail($args_func);
						break;
					case "xmlshow" :
						break;
					case "tablefile" :
						$this->verifArgstoXMLFile($args_func);
						break;
					case "tablemail" :
						$this->verifArgstoXMLMail($args_func);
						break;
					case "tableshow" :
						break;
					case "file" :
						$this->verifArgstoFile($args_func);
						break;
					case "fonction" :
						$this->verifArgstoFunc($args_func);
						break;
					case "message" :
						$this->verifArgstoMessage($args_func);
						break;
					case "mail" :
						$this->verifArgstoMail($args_func);
						break;
					case "mask" :
						$this->verifArgstoMask($args_func);
						break;
				}

			}

			if(count($this->FORM_list_errors_submit) == 0){

                if($this->is_not_editable == false ){
        			//Si pas d'erreur de fichier
        			$this->iscopyFiles();

    			    //Si pas d'erreurs d'argumets
    				$type_func = $arrfunc[0];
    				$args_func = $arrfunc[1];

    				switch($type_func){
    					case "sql" :
    						$this->toSQL($args_func);
    						break;
    					case "xmlfile" :
    						$this->toXMLFile($args_func);
    						break;
    					case "xmlmail" :
    						$this->toXMLMail($args_func[0],$args_func[1],$args_func[2],$args_func[3]);
    						break;
    					case "xmlshow" :
    						$this->toXMLShow();
    						break;
    					case "tablefile" :
    						$this->toXMLFile($args_func);
    						break;
    					case "tablemail" :
    						$this->toXMLMail($args_func[0],$args_func[1],$args_func[2],$args_func[3]);
    						break;
    					case "tableshow" :
    						$this->toTableShow();
    						break;
    					case "file" :
    						$this->toFile($args_func[0],$args_func[1]);
    						break;
    					case "fonction" :
    						$this->toFunc($args_func[0],$args_func[1]);
    						break;
    					case "message" :
    						$this->toMessage($args_func);
    						break;
    					case "mail" :
    						$this->toMail($args_func[0],$args_func[1],$args_func[2],$args_func[3],$args_func[4]);
    						break;
    					case "mask" :
    						$this->toMask($args_func[0],$args_func[1]);
    					
    						break;
    				}
                }
			}else{
				/*
				$output = $this->FORM_MSG_number_errors." ".count($this->FORM_list_errors_submit)."<br>";
				
				$output.= "<ol>";
				foreach ( $this->FORM_list_errors_submit as $key => $error ){
					$output.= "<li>".$error."</li>";
				}
				$output.= "</ol>";
				
				$this->FormHTML = $output.$this->FormHTML;
				*/
				$this->showForm();
			}
		}else{
			$this->showForm();
		}
	}

	/**
	 * verifArgstoMask($data)
	 * @fonction Privé: vérifier la validité du mask
	 * @param array $args : array(mask{string dedans des %s d'un nombre égale au count du tableau des valeurs},array(value,...))
	**/
	function verifArgstoMask($args){
		if( !is_array($args) ){
			$this->FORM_list_errors_submit[] = $this->FORM_MSG_on_succes_mask_error_arg;
		}else{
			if( empty($args[0]) ){
				$this->FORM_list_errors_submit[] = $this->FORM_MSG_on_succes_mask_error_arg;
			}else{

				//Nombre de valeurs qui doivent être remplacées à partir du tableau des valeurs $args[1]
				$nbr_val = substr_count($args,"%s");
				if( $nbr_val > 0 ){

					if( empty($args[1]) or !is_array($args[1]) ) {
						$this->FORM_list_errors_submit[] = $this->FORM_MSG_on_succes_mask_error_arg;
					}else{
						if( $nbr_val > 1 ){
							if( !is_array($args[1]) or ( is_array($args[1]) and ( $nbr_val != count($args[1]) ) ) ){
								$this->FORM_list_errors_submit[] = $this->FORM_MSG_on_succes_mask_error_arg;
							}
						}
					}
				}
			}
		}
	}

	/**
	 * verifArgstoMask($data)
	 * @fonction Privé: Afficher le mask en tant que chaine de carachtère
	 * @param string $mask 				: string dedans des %s d'un nombre égale au count du tableau des valeurs
	 * @param string or array  values 	: array(value,...)
	 * @return string
	**/
	function toMask($mask,$values){

		//Nombre de valeurs qui doivent être remplacées à partir du tableau des valeurs $args[1]
		$nbr_val = substr_count($args,"%s");

		if( $nbr_val == 0 ){
			$return = $mask;
		}

		if( $nbr_val == 1 ){
			if( !is_array($values) ){
				$return = sprintf($mask,$values);
			}else{
				if( !is_array($values[0]) ){
					$return = sprintf($mask, $this->request[$values[0]]);
				}else{
					$return = sprintf($mask,$values[0][0]);
				}
			}
		}
		
		if( $nbr_val > 1 ){
			$args_format = array();
			for($inc=0;$inc<$nbr_val;$inc++){
				if( !is_array($values[$inc]) ){
					$args_format[] = $this->request[$values[$inc]];
				}else{
					$args_format[] = $values[$inc][0];
				}	
			}
			$return = vsprintf($mask,$args_format);
		}
		
		return $return;
	}
	
	/**
	 * verifArgstoSQLdataArray($data)
	 * @fonction Privé: vérifier la validité du troisième argument pour le traitement en SQL
	 * @param array $data : array(op_field,field,value,op_value)
	**/	
	function verifArgstoSQLdataArray($data)
	{
	//@select string [type sql] : la structure de l'entrée est : array(type, tabl, array(array(op_field,field,value,op_value)) )
		if(!is_array($data)){
		//data doit être un tableau
			$this->FORM_list_errors_submit[] = $this->FORM_MSG_SQL_dataArray_args_errors;
		}else{
			$nb = 0;
			foreach( $data as $key => $data_array ){
				$nb++;
				
				//Vérification de l'opérateur entre les clauses
				$op_field = false;
				switch ($data_array[0]){
					case "": 
					case "and": 
					case "AND": 
					case "or": 
					case "OR":
						$op_field = true;
						break;
				}
				if( $op_field == false ){
				//erreur op_field dans data qui doit être dans la liste suivante : ["","and","AND","or","OR"}
					$this->FORM_list_errors_submit[] = $this->FORM_MSG_SQL_opField_args_errors." : [#".$nb." => ".$data_array[0]."]";
				}
				
				//Vérification de champs (field)
				if( $data_array[1] == "" ){
					$this->FORM_list_errors_submit[] = $this->FORM_MSG_SQL_Field_args_errors." : [#".$nb."]";
				}
				
				//Vérification de champs (field)
				if( $data_array[2] == "" ){
					$this->FORM_list_errors_submit[] = $this->FORM_MSG_SQL_Value_args_errors." : [#".$nb." => ".$data_array[2]."]";
				}
				
				//Vérification de l'opérateur entre les clauses
				$op_value = false;
				switch ($data_array[3]){
								case "=": 
								case "<>": 
								case "<":
								case ">":
								case "<=":
								case "=>":
								case "%like": 
								case "%LIKE": 
								case "%not like": 
								case "%NOT LIKE": 
								case "like%": 
								case "LIKE%": 
								case "not like%": 
								case "NOT LIKE%": 
								case "%like%": 
								case "%LIKE%": 
								case "%not like%": 
								case "%NOT LIKE%": 
									$op_value = true;
									break;
				}
				if( $op_value == false ){
				//erreur op_field dans data qui doit être dans la liste suivante : ["=","<>","<",">","<=","=>","%like","%LIKE","%not like","%NOT LIKE","like%","LIKE%","not like%","NOT LIKE%","%like%","%LIKE%","%not like%","%NOT LIKE%"]
					$this->FORM_list_errors_submit[] = $this->FORM_MSG_SQL_opValue_args_errors." : [#".$nb." => ".$data_array[3]."]";
				}
				
			}
		}	
	}
	
	/**
	 * verifArgstoSQL($sqlarr)
	 * @fonction Privé: vérifier la validité des argument pour le traitement en SQL
	 * @param array $sqlarr : 3 cases ( 0 => $type ; 1 => $tabl ; 2 => $data  )
	**/	
	function verifArgstoSQL($sqlarr)
	{
		if ( !is_array($sqlarr) ){
			$this->FORM_list_errors_submit[] = $this->FORM_MSG_on_succes_sql_error_arg;
		}else{

			$type = $sqlarr[0];
			$tabl = $sqlarr[1];
			$data = $sqlarr[2];

			//Vérification la validité des arguments du tableau sqlarr
			switch($type){
				case "" :
					if( ($data == "") || empty($data) ){
						$this->FORM_list_errors_submit[] = $this->FORM_MSG_SQL_libre_args_errors;
					}
					break;
				case "insert" :
					//@insert string [type sql] : la structure de l'entrée est : array(type, tabl, array(field => value) )
					if( !is_array($data) || empty($data) ){
						$this->FORM_list_errors_submit[] = $this->FORM_MSG_SQL_insert_args_errors;
					}
					break;
				case "delete" :
					//@delete string [type sql] : la structure de l'entrée est : array(type, tabl, array(array(op_field,field,value,op_value)) )
					if( !is_array($data) || empty($data) ){
						$this->FORM_list_errors_submit[] = $this->FORM_MSG_SQL_delete_args_errors;
					}else{
						$this->verifArgstoSQLdataArray($data);
					}
					break;
				case "select":
					//@select string [type sql] : la structure de l'entrée est : array(type, tabl, array(array(op_field,field,value,op_value)) )
					if( !is_array($data) || empty($data) ){
						$this->FORM_list_errors_submit[] = $this->FORM_MSG_SQL_select_args_errors;
					}else{
						$this->verifArgstoSQLdataArray($data);
					}
					break;
				case "update":
					//@update string [type sql] : la structure de l'entrée est :
					// -> array(type, tabl, array(array(field_set => value_set), array(op_field,field,value,op_value))
					if( !is_array($data) || empty($data) || ( is_array($data) && (  is_array($data[0]) && count($data[0]) == 0) ) || ( is_array($data) && (  !is_array($data[0]) || !is_array($data[1]) ) ) ){
						$this->FORM_list_errors_submit[] = $this->FORM_MSG_SQL_update_args_errors;
					}else{
						$this->verifArgstoSQLdataArray($data[1]);
					}
					break;
			}
		}
	}

	/**
	* verifArgstoXMLFile($args_func)
	* @param privé string $args_func
	**/
	function verifArgstoXMLFile($args_func)
	{
		if( empty($args_func) || ($args_func == "") ){
			$this->FORM_list_errors_submit[] = $this->FORM_MSG_on_succes_xmlfile_error_arg;
		}
	}
	
	/**
	* verifArgstoXMLMail($args_func)
	* @param privé array $args_func
	**/
	function verifArgstoXMLMail($args_func)
	{
		if( empty($args_func) || !is_array($args_func) || ( is_array($args_func) && ( empty($args_func[0]) || empty($args_func[1]) || empty($args_func[2]) ) ) ){
			$this->FORM_list_errors_submit[] = $this->FORM_MSG_on_succes_xmlmail_error_arg;
		}
	}

	/**
	* verifArgstoFile($args_func)
	* @param privé array $args_func
	**/
	function verifArgstoFile($args_func)
	{
		if( empty($args_func) || !is_array($args_func) || ( is_array($args_func) && ( empty($args_func[0]) || empty($args_func[1]) ) ) ){
			$this->FORM_list_errors_submit[] = $this->FORM_MSG_on_succes_file_error_arg;
		}
	}

	/**
	* verifArgstoMail($args_func)
	* @param privé array $args_func
	**/
	function verifArgstoMail($args_func)
	{
		if( empty($args_func) || !is_array($args_func) || ( is_array($args_func) && ( empty($args_func[0]) || empty($args_func[1]) || empty($args_func[2]) || empty($args_func[3]) ) ) ){
			$this->FORM_list_errors_submit[] = $this->FORM_MSG_on_succes_mail_error_arg;
		}
	}

	/**
	* verifArgstoMessage($args_func)
	* @param privé string $args_func
	**/
	function verifArgstoMessage($args_func)
	{
		if( empty($args_func) ){
			$this->FORM_list_errors_submit[] = $this->FORM_MSG_on_succes_message_error_arg;
		}
	}

	
	/**
	* verifArgstofunc($args_func)
	* @param privé string $args_func
	**/
	function verifArgstofunc($args_func)
	{
		if( empty($args_func) || !is_array($args_func) || ( is_array($args_func) && !is_array($args_func[0]) ) ||  ( is_array($args_func) && empty($args_func[1]) ) ) 	
		 {
			$this->FORM_list_errors_submit[] = $this->FORM_MSG_on_succes_func_error_arg;
		}
	}

	/**
	 * toSQL()
	 * @fonction Publique: générer le traitement SQL à faire dans le cas de la validité de l'envoie du formulaire
	 * @param array $sqlarr : 3 cases ( 0 => $type ; 1 => $tabl ; 2 => $data  )
	**/
	function toSQL($sqlarr)
	{
		if( $this->connection != NULL ){

			$type = $sqlarr[0];
			$tabl = $sqlarr[1];
			$data = $sqlarr[2];

			switch ( $type ){
				case "":
					//Requête libre : la structure de l'entrée est : array(type, tabl, $sql )
					// - @type string = "" : reqête libre dans la base de donnée
					// - @tabl string : nom de la table [ ICI la table n'est pas spécifiable donc le case est vide ]
					// - @sql string : le contenue de la requête 
					$sql = $data;
					$res = @mysql_query($sql,$this->connection)	or die($this->FORM_MSG_db_execution_sql);//"Le traitement dans la base de donnée à echoué";
					break;
				case "insert":
					//@insert string [type sql] : la structure de l'entrée est : array(type, tabl, array(field => value) )
					// - @type string = insert : insertion dans la base de donnée
					// - @tabl string : nom de la table
					// - @data array :	tableau des données d'nsertion dans la table : array($field => $value )
					// 		=> @field string :	le champs de la table de la base de donnée
					// 		=> @value string :	nom du champ du formulaire
					$fields = "";
					$values = "";
					//Récupérer les champs de la table de la base de donnée et les valers récupérées des champs du formulaire dans $fields et $values
					foreach ($data as $field => $value ) {
						if( $fields != "" ){
							$fields.= ", ";	
						}
						$fields.= $field;
						if( is_array($value) ){
							$value = $value[0]; 
						}else{
							$value  = $this->escapeDB($this->request[$value]);
						}
						if( $values != "" ){
							$values.= ", ";
						}
						$values.= "'".$value."'";
					}

					$sql = "
						INSERT INTO ".$tabl." ( ".$fields." )
						VALUES ( ".$values." );
					";
                              //echo 'AZZ SQL : '.$sql.'<hr>';          
                                        $res = @mysql_query($sql,$this->connection) or die($this->FORM_MSG_db_insertion);//"L'insertion dans la base de donnée à echoué";
					
                                        $this->db_insert_value = mysql_insert_id($this->connection);
					break;
				case "select":
					//@select string [type sql] : la structure de l'entrée est : array(type, tabl, array(array(op_field,field,value,op_value)) )
					// - @type string = select : selection dans la base de donnée
					// - @tabl string : nom de la table
					// - @op_field string :		les operations sur le champs de la table de la base de donnée
					// - @field string :		le champs de la table de la base de donnée
					// - @value string :		valeur du champ du formulaire
					// - @op_value string :  	l'operation entre le champs de la table de la base de donnée et la valeur du champ du formulaire
					$clauses = "";

					foreach ($data as $key => $arr_select ) {

						if( $arr_select[0] != "" ) {
						//les operations sur le champs de la table de la base de donnée
							$op_field = $arr_select[0];
						} else {
							$op_field = "AND";
						}

						if( $arr_select[3] != "" ) {
						//l'operation entre le champs de la table de la base de donnée et la valeur du champ du formulaire
							$op_value 	= $arr_select[3];
							$prefix_value = "";
							$suffix_value = "";
							switch ($arr_select[3]){
								case "%like":
								case "%LIKE":
									$op_value 		= "LIKE";
									$prefix_value 	= "%";
									break;

								case "%not like":
								case "%NOT LIKE":
									$op_value 		= "NOT LIKE";
									$prefix_value 	= "%";
									break;

								case "like%":
								case "LIKE%":
									$op_value 		= "LIKE";
									$suffix_value 	= "%";
									break;

								case "not like%":
								case "NOT LIKE%":
									$op_value 		= "NOT LIKE";
									$suffix_value 	= "%";
									break;

								case "%like%":
								case "%LIKE%":
									$op_value 		= "LIKE";
									$prefix_value 	= "%";
									$suffix_value 	= "%";
									break;

								case "%not like%":
								case "%NOT LIKE%":
									$op_value 		= "NOT LIKE";
									$prefix_value 	= "%";
									$suffix_value 	= "%";
									break;
							}

						} else {
							$op_value 	= "=";
						}
						$field 		 = $arr_select[1]; //le champs de la table de la base de donnée
						$value 		 = $arr_select[2]; //valeur du champ du formulaire
						$value  	 = $prefix_value.$this->escapeDB($this->request[$value]).$suffix_value;

						if( $clauses != "" ){
							$clauses.= $op_field;
						} else {
							$clauses.= " WHERE ";
						}
						$clauses 	.= " ( ".$field." ".$op_value." '".$value."' ) ";

					}

					$sql = "SELECT * FROM  ".$tabl." ".$clauses;

					$res = @mysql_query($sql,$this->connection)	or die($this->FORM_MSG_db_execution_sql);//"Le traitement dans la base de donnée à echoué";
					$this->table_data_to_render = array();
					while ( $row = mysql_fetch_array($res) ){
						$this->table_data_to_render = $row;
					}
					break;
				case "delete":
					//@delete string [type sql] : la structure de l'entrée est : array(type, tabl, array(array(op_field,field,value,op_value)) )
					// - @type string = delete : supression dans la base de donnée
					// - @tabl string : nom de la table
					// - @op_field string :		les operations sur le champs de la table de la base de donnée
					// - @field string :		le champs de la table de la base de donnée
					// - @value string :		valeur du champ du formulaire
					// - @op_field op_value :  	l'operation entre le champs de la table de la base de donnée et la valeur du champ du formulaire
					$clauses = "";

					foreach ($data as $key => $arr_select ) {
						if( $arr_select[0] != "" ) {
						//les operations sur le champs de la table de la base de donnée
							$op_field = $arr_select[0];
						} else {
							$op_field = "AND";
						}

						if( $arr_select[3] != "" ) {
						//l'operation entre le champs de la table de la base de donnée et la valeur du champ du formulaire
							$op_value 	= $arr_select[3];
							$prefix_value = "";
							$suffix_value = "";
							switch ($arr_select[3]){
								case "%like":
								case "%LIKE":
									$op_value 		= "LIKE";
									$prefix_value 	= "%";
									break;

								case "%not like":
								case "%NOT LIKE":
									$op_value 		= "NOT LIKE";
									$prefix_value 	= "%";
									break;

								case "like%":
								case "LIKE%":
									$op_value 		= "LIKE";
									$suffix_value 	= "%";
									break;

								case "not like%":
								case "NOT LIKE%":
									$op_value 		= "NOT LIKE";
									$suffix_value 	= "%";
									break;

								case "%like%":
								case "%LIKE%":
									$op_value 		= "LIKE";
									$prefix_value 	= "%";
									$suffix_value 	= "%";
									break;

								case "%not like%":
								case "%NOT LIKE%":
									$op_value 		= "NOT LIKE";
									$prefix_value 	= "%";
									$suffix_value 	= "%";
									break;
							}

						} else {
							$op_value 	= "=";
						}
						$field 		 = $arr_select[1]; //le champs de la table de la base de donnée
						$value 		 = $arr_select[2]; //valeur du champ du formulaire
						$value  	 = $prefix_value.$this->escapeDB($this->request[$value]).$suffix_value;

						if( $clauses != "" ){
							$clauses.= $op_field;
						} else {
							$clauses.= " WHERE ";
						}
						$clauses 	.= " ( ".$field." ".$op_value." '".$value."' ) ";

					}

					$sql = "DELETE FROM  ".$tabl." ".$clauses;
					$res = @mysql_query($sql,$this->connection)	or die($this->FORM_MSG_db_suppression_sql);//"La suppression dans la base de donnée à echoué";
					break;
				case "update":
					//@update string [type sql] : la structure de l'entrée est : array(type, tabl, array(array(field_set => value_set), array(op_field,field,value,op_value)) )
					// - @type string = update : mise à jour dans la base de donnée
					// - @tabl string : nom de la table
					// - @field_set string key of table : nom de champ à mettre à jour pour le set de la mise à jour
					// - @value_set string value of table : nouvelle valeur du champ à mettre à jour pour le set de la mise à jour [string => ( request du champs ) Or Array => valeur [0] du tableau ]
					// - @op_field string :		les operations sur le champs de la table de la base de donnée
					// - @field string :		le champs de la table de la base de donnée
					// - @value string :		valeur du champ du formulaire
					// - @op_field op_value :  	l'operation entre le champs de la table de la base de donnée et la valeur du champ du formulaire
					$clauses = "";
					$updates = "";

					foreach ($data[0] as $field_set => $value_set ) {
						if( $updates != "" ){
							$updates .= ", ";
						}

						if( !is_array($value_set) ){
							$value_set   = $this->escapeDB($this->request[$value_set]);
						}else{
							$value_set   = $this->escapeDB($value_set[0]);
						}
						$updates 	.= $field_set."='".$value_set."'";
					}

					foreach ($data[1] as $key => $arr_select ) {
						if( $arr_select[0] != "" ) {
						//les operations sur le champs de la table de la base de donnée
							$op_field = $arr_select[0];
						} else {
							$op_field = "AND";
						}

	    				if( $arr_select[3] != "" ) {
						//l'operation entre le champs de la table de la base de donnée et la valeur du champ du formulaire
							$op_value 	= $arr_select[3];
							$prefix_value = "";
							$suffix_value = "";
							switch ($arr_select[3]){
								case "%like":
								case "%LIKE":
									$op_value 		= "LIKE";
									$prefix_value 	= "%";
									break;

								case "%not like":
								case "%NOT LIKE":
									$op_value 		= "NOT LIKE";
									$prefix_value 	= "%";
									break;

								case "like%":
								case "LIKE%":
									$op_value 		= "LIKE";
									$suffix_value 	= "%";
									break;

								case "not like%":
								case "NOT LIKE%":
									$op_value 		= "NOT LIKE";
									$suffix_value 	= "%";
									break;

								case "%like%":
								case "%LIKE%":
									$op_value 		= "LIKE";
									$prefix_value 	= "%";
									$suffix_value 	= "%";
									break;

								case "%not like%":
								case "%NOT LIKE%":
									$op_value 		= "NOT LIKE";
									$prefix_value 	= "%";
									$suffix_value 	= "%";
									break;
							}

						} else {
							$op_value 	= "=";
						}

						$field 		 = $arr_select[1]; //le champs de la table de la base de donnée
						$value 		 = $arr_select[2]; //valeur du champ du formulaire

                        if( !is_array($value) ){
                            $value_requested = $this->escapeDB($this->request[$value]);
                        }else{
                            if( $value[0] != "" ){
                                $value_requested = $this->escapeDB($value[0]);
                            }
                        }
						$value  	 = $prefix_value.$value_requested.$suffix_value;

						if( $clauses != "" ){
							$clauses.= $op_field;
						} else {
							$clauses.= " WHERE ";
						}
						$clauses 	.= " ( ".$field." ".$op_value." '".$value."' ) ";

					}

					$sql = "UPDATE ".$tabl." SET ".$updates." ".$clauses;
					
					$res = @mysql_query($sql,$this->connection)	or die($this->FORM_MSG_db_update_sql);//"La mise à jour dans la base de donnée à echoué";
					break;
			}

                    echo '<div '.$this->css_general_remarque_succes.'>'.$this->FORM_MSG_db_succes.'</div>';//"Le traitement dans la base de donnée est éffectué avec succès";
		}else{
                    echo '<div '.$this->css_general_remarque_error.'>'.$this->FORM_MSG_db_connection.'</div>';//"il faut se connecter à la base de donnée";
		}

		return;
	}

	/**
	 * toXML()
	 * @fonction Privé: générer le contenu des valeurs en format XML
	**/
	function toXML()
	{
		$content = "<?xml version=\"1.0\" encoding=\"".$this->FORM_MSG_xml_encoding."\" ?>\n";
		$content.="<fields>\n";
		foreach ( $this->table_data_to_render as $tag => $val ) {
			$content.="<".$tag.">".$val."</".$tag.">\n";
		}
		$content.="</fields>\n";
		
		return $content;
	}

	/**
	 * toXMLFile()
	 * @fonction Publique: générer le fichier XML à faire dans le cas de la validité de l'envoie du formulaire
	 * @param string $XML : nom du fichier XML
	**/
	function toXMLFile($xml_file)
	{
		$content = $this->toXML();
		//créer le contenue XML dans le fichier $file
		$this->toFile($xml_file,$content);
		
		return;
	}

	/**
	 * toXMLMail()
	 * @fonction Publique: envoyer le contenue du fichier XML par mail, à faire dans le cas de la validité de l'envoie du formulaire
	 * @param string $subject : sujet du mail
	 * @param string $adresse_from : adresse_from du mail
	 * @param string OR array $adresse_to : adresse des distinataires du mail, si 1 seule adresse 	=> 		string Or array à 1 case contenant le mail du distinataire 
	 * 																								sinon 	array des mail des distinataires
	 * @param string $attachement : attachement des fichiers joints du mail: à spécifier les fichiers envoyés
	**/
	function toXMLMail($subject, $adresse_from, $adresse_to, $attachement)
	{
		$message = $this->toXML();
		//créer le contenue XML dans le fichier $file
		$this->toMail($subject, $message, $adresse_from, $adresse_to, $attachement);
		
		return;
	}
	

	/**
	 * toXMLShow()
	 * @fonction Publique: afficher le fichier XML, à faire dans le cas de la validité de l'envoie du formulaire
	**/
	function toXMLShow()
	{
		$message = $this->toXML();
		//créer le contenue XML dans le fichier $file
		$message = nl2br(htmlentities($message));
		$this->toMessage($message);
		return;
	}
		
	/**
	 * toTable()
	 * @fonction Privé: générer le contenu des valeurs en format tableau html
	**/
	function toTable()
	{
		if( $this->table_data_to_render == $this->request ){
			$content = "<table>";
			foreach ( $this->table_data_to_render as $tag => $val ) {
				$content.= "<tr>";
				$content.= "<td>";
				$content.= $tag;
				$content.="</td>";
				$content.= "<td>";
				$content.= $val;
				$content.="</td>";
				$content.="</tr>";
			}
			$content.="</table>";
		}else{
			$content = "<table>";
			for($inc=0; $inc<count($this->table_data_to_render); $inc++){
				if( $inc==0 ){
				//Afficher l'entête du tableau enspécifiant les noms des champs juste une fois
					$content.= "<tr>";
					foreach ( $this->table_data_to_render[$inc] as $field => $val ) {
						$content.= "<td>";
						$content.= "<b>".$field."</b>";
						$content.="</td>";
					}
					$content.="</tr>";
				}
				//afficher les données
				$content.= "<tr>";
				foreach ( $this->table_data_to_render[$inc] as $field => $val ) {
					$content.= "<td>";
					$content.= $val;
					$content.="</td>";
				}
				$content.="</tr>";
			}
			$content.="</table>";
		}
		return $content;
	}

	/**
	 * toTableFile()
	 * @fonction Publique: générer le fichier contenant le données en tableau, à faire dans le cas de la validité de l'envoie du formulaire
	 * @param string $Table_file : nom du fichier
	**/
	function toTableFile($Table_file)
	{
		$content = $this->toTable();
		//créer le contenue XML dans le fichier $file
		$this->toFile($Table_file,$content);
		
		return;
	}

	/**
	 * toTableMail()
	 * @fonction Publique: envoyer le tableau des données par mail, à faire dans le cas de la validité de l'envoie du formulaire
	 * @param string $subject : sujet du mail
	 * @param string $adresse_from : adresse_from du mail
	 * @param string OR array $adresse_to : adresse des distinataires du mail, si 1 seule adresse 	=> 		string Or array à 1 case contenant le mail du distinataire 
	 * 																								sinon 	array des mail des distinataires
	 * @param string $attachement : attachement des fichiers joints du mail: à spécifier les fichiers envoyés
	**/
	function toTableMail($subject, $adresse_from, $adresse_to, $attachement)
	{
		$message = $this->toTable();
		//créer le contenue XML dans le fichier $file
		$this->toMail($subject, $message, $adresse_from, $adresse_to, $attachement);
		
		return;
	}
	

	/**
	 * toXMLShow()
	 * @fonction Publique: afficher le tableau des données, à faire dans le cas de la validité de l'envoie du formulaire
	**/
	function toTableShow()
	{
		$message = $this->toTable();
		//créer le contenue du tableau des données dans le fichier $file
		$this->toMessage($message);
		
		return;
	}

	/**
	 * toFile()
	 * @fonction Publique: générer le fichier à faire dans le cas de la validité de l'envoie du formulaire
	 * @param string $file : nom du fichier où on sauvegarde le contenue
	**/
	function toFile($filename,$content)
	{
        if(!empty($filename) && !empty($content)){ 
            $fp = fopen($filename,"w"); 
            $b = fwrite($fp,$content);
            fclose($fp); 
            @chmod($filename,0777); 
            if($b != -1){ 
                return TRUE; 
            } else { 
              echo $this->FORM_MSG_file_error_1;
                return FALSE; 
            } 
        } else { 
            echo $this->FORM_MSG_file_error_2;
            return FALSE; 
        }
	}
	
	/**
	 * toFunc()
	 * @fonction Publique: générer le traitement de la fonction appelée dans l'attribut, à faire dans le cas de la validité de l'envoie du formulaire
	 * @param string $farr : tableau des argument avec leurs valeurs : array($arg => $val)
	 * @param string $code : le code de la fonction
	**/
	function toFunc($farr, $code)
	{
		//Créer une fonction en spécifiant : 
		// - les arguments dans la variable $args : les arguments sont des variables commançant par $ et il sont séparées par des virgules
		// - Le code de la fonction dans une chaine de charctère $code
		//Le nom de la nouvelle fonction est : $newfunc

		//Initialisation
		$args = '';
		$vals = array();
		//Récupérer les arguments et les valers dans $args et $vals
		foreach ($farr as $arg => $val ) {
			if($args != ''){$args.=',';}
			$args.= '$'.$arg;
			$vals[] = $val;
		}
		//création de la fonction
		$func = create_function($args, $code);
		//Appel de la fonction crée
		$return_func = call_user_func_array ( "$func" , $vals) ;
		//affichage du resultat
		echo $return_func;
		
		return ;
	}
	
	/**
	 * toMessage()
	 * @fonction Publique: générer et afficher un message, à faire dans le cas de la validité de l'envoie du formulaire
	 * @param string $message : le message texte à généré aprés la validation du formulaire
	**/
	function toMessage($message)
	{
		echo $message;
		return ; 
	}
	
	/**
	 * toMail($subject, $message, $adresse_from, $adresse_to, $attachement)
	 * @fonction Publique: générer l'envoi des messages éléctroniques pour les distinataires spécifiés, à faire dans le cas de la validité de l'envoie du formulaire
	 * @param string $subject : sujet du mail
	 * @param string $message : message du mail
	 * @param string $adresse_from : adresse_from du mail
	 * @param string OR array $adresse_to : adresse des distinataires du mail, si 1 seule adresse 	=> 		string Or array à 1 case contenant le mail du distinataire 
	 * 																								sinon 	array des mail des distinataires
	 * @param string $attachement : attachement des fichiers joints du mail: à spécifier les fichiers envoyés
	**/
	function toMail($subject, $message, $adresse_from, $adresse_to, $attachement)
	{	
		//initialisation
//		$mail_html = "<b>".$subject."</b><hr><br>".$message;
		$mail_html = "";
		$mail_subject = $subject;
		$mail_headers = '';
		$mail_message = '';
		$mail_attachement = $attachement;
		$mail_arrors = array();
		
		//Vérification des erreurs du mail
		if( empty($subject) || $subject == "" || $subject == NULL ){ $mail_arrors[] = $this->FORM_MSG_mail_subject_error; }
		if( empty($message) || $message == "" || $message == NULL ){ $mail_arrors[] = $this->FORM_MSGt_mail_message_error; }
		if( empty($adresse_from) || $adresse_from == "" || $adresse_from == NULL ){ $mail_arrors[] = $this->FORM_MSG_mail_adresse_from_error; }
		if( empty($adresse_to) || $adresse_to == "" || $adresse_to == NULL ){ $mail_arrors[] = $this->FORM_MSG_mail_adresse_to_error; }
		
		if( !$this->is_Mail($adresse_from) ){
			$mail_arrors[] = "<b>[ ".$adresse_from." ]</b> : ".$this->FORM_MSG_mail_adresse_from_error_valid;//"L'adresse éléctronique du l'expéditeur est inavalide";
		}

		if( !empty($adresse_to) ){
			$mail_recipientlist_1 = array();
			if( is_array($adresse_to) ){ $mail_recipientlist_1 = $adresse_to; }else{ $mail_recipientlist_1[] = $adresse_to; }
			foreach( $mail_recipientlist_1 as $key => $to ) {

				if ( !$this->is_Mail($to) ) { 
					$mail_arrors[] = "<b>[ ".$to." ]</b> : ".$this->FORM_MSG_mail_adresse_to_error_valid;//"L'adresse éléctronique du distinataire est inavalide";
				}
			}
		}
		
		if( count($mail_arrors) == 0 ){
		//Si pas d'erreur pour le mail alors faire traitement
			if( !empty($message) ){$mail_html.= "<br><u>".$message."</u>";}
		
			//Création du header du mail
			$mail_headers .= wordwrap("Subject".": ".$subject, 78, "\n ")."\r\n";
			$mail_headers .= wordwrap("Date".": ".date ('r'), 78, "\n ")."\r\n";
			$mail_headers .= wordwrap("X-Sender".": ".$adresse_from, 78, "\n ")."\r\n";
			$mail_headers .= wordwrap("From".": ".$adresse_from, 78, "\n ")."\r\n";
			$mail_headers .="MIME-Version: 1.0\r\n";

			//Création du message
			//Messages start with text/html alternatives in OB
			$mail_message.= "Content-Type: text/html; charset=\"windows-1256\"\n";
			$mail_message.= "Content-Transfer-Encoding: 8bit\n\n";
			// html goes here
//			$mail_message.= chunk_split(base64_encode($mail_html))."\n\n";
			$mail_message.= $mail_html."\n\n";
			// end of text
			
			// attachments
			if (empty($mail_attachement)) {
//				$mail_message.="\n--".$mail_B1B."--\n";
			} else {
				$attachement = $mail_attachement;
				if ( !empty($attachement) ) {
						foreach($attachement as $AttmFile){
							$patharray = explode ("/", $AttmFile['filename']);
							$FileName = $patharray[count($patharray)-1];
							
							$mail_message .= "\n--".$mail_B1B."\n";
							
							if (!empty($AttmFile['cid'])) {
									$mail_message .= "Content-Type: {$AttmFile['contenttype']};\n name=\"".$FileName."\"\n";
									$mail_message .= "Content-Transfer-Encoding: base64\n";
									$mail_message .= "Content-ID: <{$AttmFile['cid']}>\n";
									$mail_message .= "Content-Disposition: inline;\n filename=\"".$FileName."\"\n\n";
							} else {
									$mail_message .= "Content-Type: application/octetstream;\n name=\"".$FileName."\"\n";
									$mail_message .= "Content-Transfer-Encoding: base64\n";
									$mail_message .= "Content-Disposition: attachment;\n filename=\"".$FileName."\"\n\n";
							}
							
							$fd=fopen ($AttmFile['filename'], "rb");
							$FileContent=fread($fd,filesize($AttmFile['filename']));
							fclose ($fd);
							
							$FileContent = chunk_split(base64_encode($FileContent));
							$mail_message .= $FileContent;
					//		$mail_message .= "\n\n";
						}
				//		$mail_message .= "\n--".$mail_B1B."--\n";
				}
			
			}
			
			$mail_recipientlist = array();
			if( is_array($adresse_to) ){ $mail_recipientlist = $adresse_to; }else{ $mail_recipientlist[] = $adresse_to; }
			
			$mail_headers = "From: ".$this->mail_from_name." <".$adresse_to.">\r\n";
			$mail_headers.= 'To: '.$adresse_to.' <'.$adresse_to.'>'."\r\n";
			$mail_message = $message;
			
			foreach( $mail_recipientlist as $key => $to ) {
					if ( mail($to, $mail_subject, $mail_message, $mail_headers ) ) { 
						echo $this->FORM_MSG_mail_envoie_vers." ".$to." ".$this->FORM_MSG_mail_reussi;
					} else { 
						echo $this->FORM_MSG_mail_envoie_vers." ".$to." ".$this->FORM_MSG_mail_echoue ;
					}
			}
		
		}else{
			for ( $i=0; $i < count($mail_arrors); $i++){
				echo $mail_arrors[0]."<br>";
			}
		}
		return ; 
	}
	
	/**
	 * showForm()
	 * @fonction Publique: afficher le formulaire
	**/
	function showForm()
	{

		//Afficher un titre à afficher en haut du formulaire
		if( $this->form_title != ""){
			$output = '';
			if( in_array($this->form_title_tag,array("p","span","div","strong","i","u","label","h1","h2","h3","h4")) ){
				$output.=
					'<'.$this->form_title_tag." ".$this->form_title_adds.'>'."\n".'
					'.$this->form_title."\n".
					'</'.$this->form_title_tag.'>'."\n";
			}else{
				$output.= $this->form_title;
			}
			echo $output;
		}
		if( $this->isSubmit() ){
		//Si le formulaire est déja envoyé alors vérifier les erreurs et afficher la remarque
			if( count($this->validFormList) != 0 ){
				echo '<span '.$this->css_general_remarque_error.'>'."\n";
				echo $this->FORM_MSG_number_errors." <b>".count($this->validFormList)."</b>";
				echo '</span>'."\n";
			}
		}

		$this->contentFormHTML();

		return;
	}

	/**
	 * contentFormHTML()
	 * @fonction Publique: afficher le formulaire
	**/
	function contentFormHTML()
	{
		//traitement de l'ouverture du formulaire
                if( $this->form_attribut_class != '' ){
                    $this->form_attributs["class"] = $this->form_attribut_class;
                }
		if( count($this->form_attributs)!=0 ){
			$output = '<form ';
			foreach( $this->form_attributs as $key => $att){
				$output.= ' '.$key.'="'.$att.'" ';
			}
			$output.= ' >'."\n";
			if( ($this->form_attributs["name"] == "") || empty($this->form_attributs["name"]) ){
				$this->FORM_list_errors_show[] = $this->error_openForm_attName;
			}
			if( ($this->form_attributs["action"] == "") || empty($this->form_attributs["action"]) ){
				$this->FORM_list_errors_show[] = $this->error_openForm_attAction;
			}
			if( ($this->form_attributs["method"] == "") || empty($this->form_attributs["method"]) ){
				$this->FORM_list_errors_show[] = $this->error_openForm_attMethode;
			}

			if( $this->is_listOrParagraphe != "" ){
				//$this->is_listOrParagraphe => ["", "p":paragraphe, "ul":liste, "ol":liste numéroté] ::::> OUVERTURE DE LA BALISE
				$output.= '<'.trim($this->is_listOrParagraphe).' id="'.$this->form_attributs["name"].'">'."\n";
			}
			
		}else{
			//erreur d'ouverture du formulaire
			$this->FORM_list_errors_show[] = $this->error_openForm;
		}

		//traitement du contenue du formulaire
		if( empty($this->FormHTML) || ($this->FormHTML=="") ){
			$this->FORM_list_errors_show[] = $this->error_contentForm;
		}else{
			//erreur du contenue du formulaire
			$output.= $this->FormHTML;
		}
		
		if( $this->is_listOrParagrapheCount != 0 ){
			$this->FORM_list_errors_show[] = $this->error_closeTags;
		}
		
		//traitement de la fermeture du formulaire
		if($this->isFormClosed){
			if( $this->is_listOrParagraphe != "" ){
				//$this->is_listOrParagraphe => ["", "p":paragraphe, "ul":liste, "ol":liste numéroté] ::::> FERMETURE DE LA BALISE
				$output.= '</'.trim($this->is_listOrParagraphe).'>'."\n";
			}
			
			$output.= '</form>'."\n";
		}else{
			//erreur de fermeture du formulaire
			$this->FORM_list_errors_show[] = $this->error_closeForm;
		}
		if(count($this->FORM_list_errors_show) == 0){
		//Si pas d'erreurs d'argumets
			if ( ( $this->calandarOnCall == true ) && ( $this->calandarIsUsed == false ) ){
				$this->printJsCalandar();
			}
			echo $output;
		}else{
			echo "<ol>"."\n";
			foreach ( $this->FORM_list_errors_show as $key => $error ){
				echo "<li>".$error."</li>"."\n";
			}
			echo "</ol>"."\n";
		}
		
                //autocomplete
		$print_js_autocomplete = "";
		foreach( $this->autocomplete as $field => $data){
			$page 	= $data[0];
			$params = $data[1];
			$print_js_autocomplete.= "
			$('#".$field."').autocomplete('".$page."', {
					"."\n".$params."\n"."
				});"."\n";
		}
		if( $print_js_autocomplete != "" ){
			echo 	'<script type="text/javascript">
						$(document).ready(function () {'."\n".
							$print_js_autocomplete."\n".
						'});'."\n".
					'</script>';

		}
		/*
		//Exemple : autocomplete
		$this->form->autocomplete = array(
                                                    "title" => array(
                                                                    "index.php?m=autocomplete" ,
                                                                    "width: 394,"."\n".
                                                                    "multiple: true"."\n"
                                                                    )
						);
		*/
                
		return;
	}

	/**
	 * addHTMLForms($field_name,$field_label,$field_type,$field_value,$field_options,$type_validation,$remarque) :
	 * @fonction [Privé]: affichant les differentes champs de formulaire HTML
	 * @param string : $field_name 		-> nom du champs
	 * @param string : $field_label 	-> description du champs
	 * @param string : $field_type 		-> type du champs: {text | hidden | file | select | textarea | checkbox | radio | editor | button | submit | reset | date_time}
	 * @param string : $field_value 	-> valeur du champs
	 * @param array : $field_options 	-> options du champs pour le select , radio et les checkbox
	 * @param string : $type_validation -> nom du champs [Type de validation: notempty, number, email, et date]
	 * @param string : $remarque	 	-> nom du champs [remarque erreur]
	 * @param string : $add	 		-> attributs supplimentaire [par exemple : class, style, onclick, onchange, ... ]
         * @param string : $allow_tags          -> Les balises alouées dans le text
         * @param string : $max_caracters       ->
	 * @return string : le champs formaté 
	**/
	function addHTMLForms($field_name,$field_label,$field_type,$field_value,$field_options,$type_validation,$remarque, $field_add, $balise_add,$allowable_tags,$max_caracters)
        {
            $add = "";
            if( !empty($field_add) ){
                    if( is_array($field_add) ){
                            foreach( $field_add as $key => $att){
                                    if( ( $key != "" ) && ( $att != "" ) ){
                                            $add.= $key.'="'.$att.'" ';
                                    }

                                    if( ( $key == "" ) && ( $att != "" ) ){
                                            $add.= $att.' ';
                                    }
                            }
                    }else{
                            $add.= $field_add;
                    }
            }
            $add_msg_count = "";
            
            if( !empty($allowable_tags) ){
                //Non vide
                if( is_array($field_value) ){
                    foreach ( $field_value as $kv => $vv ){
                        $field_value[$kv] = strip_tags($vv, $allowable_tags);
                    }
                }else{
                    $field_value = strip_tags($field_value, $allowable_tags);
                }
            }
            
            
            //$allowable_tags,$max_caracters
            if( $max_caracters != '' ){
                $add .= ' onkeyup="compteur(\''.$max_caracters.'\',\''.$field_name.'\',\''.$field_name.'-counter\',\''.$this->FORM_MSG_counter_decrement.'\',\'%s\')" onkeypress="return checkMaxLength(event,\''.$field_name.'\',\''.$max_caracters.'\')" ';
                $add_msg_count = '<span class="form_decount" id="'.$field_name.'-counter"></span>';
            }
            //compteur(maxLength,elementId,elementReplaceId,chaine,str_mask)
            if($this->is_utf8encode){
                if( is_array($field_value) ){
                    foreach ( $field_value as $kv => $vv ){
                        $field_value[$kv] = utf8_encode($vv);
                    }
                }else{
                    $field_value = utf8_encode($field_value);
                }
            }
            switch ($field_type){
            case "free":
                $input = $field_value."\n";
                break;

            case "text":
                if( $this->is_not_editable == true ){
                    $input = '<span id="'.$field_name.'">'.$field_value.'</span>'."\n";
                }else{
                    $input = '<input id="'.$field_name.'" name="'.$field_name.'" type="text" value="'.$field_value.'" '.$add.' />'."\n";
                }
				break;
            case "password":
                if( $this->is_not_editable == true ){
                    $input = '<span id="'.$field_name.'">'.$field_value.'</span>'."\n";
                }else{
                    $input = '<input id="'.$field_name.'" name="'.$field_name.'" type="password" value="'.$field_value.'" '.$add.' />'."\n";
                }
				break;
			case "hidden":
                if( $this->is_not_editable == false ){
                    $input = '<input id="'.$field_name.'" name="'.$field_name.'" type="hidden" value="'.$field_value.'" '.$add.' />'."\n";
				}
                break;
            case "file":
				$input = '<input id="'.$field_name.'" name="'.$field_name.'" type="file" value="'.$field_value.'" '.$add.' />'."\n";
				$this->form_attributs["enctype"] 	= "multipart/form-data";
				break;
	case "select":
                if( $this->is_not_editable == true ){
                    $input = '<span id="'.$field_name.'">'.$field_options[$field_value].'</span>'."\n";                    
                }else{
                    
                    $vals_keys = array_keys($field_options);

                    if( $field_value == "" ){
                       $field_value = $vals_keys[0];  
                    }
                    $input = '<select id="'.$field_name.'" name="'.$field_name.'" '.$add.' >'."\n";
                    if( !empty($field_options) ){
                        foreach($field_options as $val_select => $text_select) {
                            $input .= '<option value="'.$val_select.'" ';
                            if($val_select == $field_value){ $input .= 'selected'; }
                            $input .= '>'.$text_select.'</option>'."\n";
                        }
                    }
                    $input .= '</select>'."\n";
				
                }
                break;
                
            case "multipleselect":
		if( $this->is_not_editable == true ){
                    $input = '<span id="'.$field_name.'">'."\n";
                    $input_val = '';
                    
                    foreach($field_options as $val_select => $text_select) {
			if( is_array($field_value) and in_array($val_select,$field_value) ){ 
                            if( $input_val != '' ){ $input_val.= '<br>'; }
                            $input_val .= $text_select; 
                        }
                    }
                    $input.=  $input_val;
                    $input.= '</span>'."\n";                    
                }else{
                    
                    $input = '<select id="'.$field_name.'" name="'.$field_name.'[]" multiple="multiple" '.$add.' >'."\n";
    				if( !empty($field_options) ){
    					foreach($field_options as $val_select => $text_select) {
    	                	$input .= '<option value="'.$val_select.'" ';
    						if( is_array($field_value) and in_array($val_select,$field_value) ){ $input .= 'selected'; }
    						$input .= '>'.$text_select.'</option>'."\n";
                		}
    				}
    
    				$input .= '</select>'."\n";
           		}
                break;

            case "textarea":
                if( $this->is_not_editable == true ){
                    $input = '<span id="'.$field_name.'">'.$field_value.'</span>'."\n";                    
                }else{
    				$input = '<textarea  id="'.$field_name.'" name="'.$field_name.'" cols="4" '.$add.' >'.$this->br2nl($field_value).'</textarea>'."\n";
	            }
    			break;

	case "checkbox":
                if( $this->is_not_editable == true ){
                    $input = '<span id="'.$field_name.'">'."\n";
                    $input_val = '';
                    foreach($field_options as $val_select => $text_select) {
						if( !is_array($field_value)  ){ 
                            if( $input_val != '' ){ $input_val.= '<br>'; }
				            $input_val .= $field_value; 
                        }else{
                            if( in_array($val_select,$field_value) ){ 
                                if( $input_val != '' ){ $input_val.= '<br>'; }
                                $input_val .= $text_select;
                            }
                        }
            		}
                    $input.=  $input_val;
                    $input.= '</span>'."\n";
                }else{
    				$i = 0;
    				foreach($field_options as $val_select => $text_select) {
    					$i++;
    					$input.= $text_select.' <input id="'.$field_name."_".$i.'" name="'.$field_name.'[]'.'" type="checkbox" value="'.$val_select.'" ';
    					if( !is_array($field_value) ){
    						if($val_select == $field_value){ $input.= ' checked="checked"'; }
    					}else{
    						if( in_array($val_select,$field_value) ){ $input.= ' checked="checked"'; }
    					}
    					$input.= ' '.$add.' />'."\n";
    				}
				}
                break;
            case "radio":
                if( $this->is_not_editable == true ){
                    $input = '<span id="'.$field_name.'">'."\n";
                    $input_val = '';
                    foreach($field_options as $val_select => $text_select) {
                        if($val_select == $field_value){
                            if( $input_val != '' ){ $input_val.= '<br>'; }
                            $input_val .= $text_select;
                        }
            		}
                    $input.=  $input_val;
                    $input.= '</span>'."\n";
                }else{
					$input = '';
    				foreach($field_options as $val_select => $text_select) {
						$input.= '<span id="radio-'.$field_name.'-'.$val_select.'">'."\n";
    					$input.= '<input id="'.$field_name.'" name="'.$field_name.'" type="radio" value="'.$val_select.'" ';
    					if($val_select == $field_value){ $input.= ' checked="checked"'; }
    					$input.= ' '.$add.' />'."\n";
						$input.= '<span class="radio-label">'.$text_select.'</span>';
						$input.= '</span>'."\n";
    				}
				}
                break;
            case "editor":
                if( $this->is_not_editable == true ){
                    $input = '<span id="'.$field_name.'">'.$field_value.'</span>'."\n";
                }else{
    				$oFCKeditor = new FCKeditor($field_name);
    				$oFCKeditor->BasePath = $GLOBALS["path_root"].'editor/';
    				$oFCKeditor->ToolbarSet = 'site';
    				$oFCKeditor->Config['CustomConfigurationsPath'] = $oFCKeditor->BasePath.'fckconfig_'.$this->FORM_Editor_langauge.'.js';
    				$oFCKeditor->Value    = stripslashes($field_value);
    				$oFCKeditor->Width    = '100%';
    				$oFCKeditor->Height   = '200';
//  				$oFCKeditor->Config->UserFilesPath = 'media/upload/editor';
    				$input = $oFCKeditor->CreateHtml();
				}
                break;

            case "button":
                if( $this->is_not_editable == false ){
                    $input = '<button name="'.$field_name.'" id="'.$field_name.'" '.$add.' type="button" >'.$field_value.'</button>';
                }
				break;

			case "submit":
                if( $this->is_not_editable == false ){
				    $input = '<button name="'.$field_name.'" id="'.$field_name.'" '.$add.' type="submit" >'.$field_value.'</button>';
				}
                break;

            case "reset":
                if( $this->is_not_editable == false ){
                    $input = '<button name="'.$field_name.'" id="'.$field_name.'" '.$add.' type="reset" >'.$field_value.'</button>';
				}
                break;

            case "date_time":
                if( $this->is_not_editable == true ){
                    $input = '<span id="'.$field_name.'">'.$field_value.'</span>'."\n";
                }else{
                    //$input = '<input id="'.$field_name.'" name="'.$field_name.'" type="text" value="'.$field_value.'" '.$add.' />'.'<img src="'.$this->path_calendar_page_image.'" value="Cal" onclick="displayCalendar(document.forms[0].'.$field_name.','."'yyyy-mm-dd hh:ii'".',this,true); ">'."\n";                    
                    $input = '<input id="'.$field_name.'" name="'.$field_name.'" type="text" value="'.$field_value.'" '.$add.' />'.'<span id="'.$field_name.'-datepicker" class="date-botton" value="Cal"></span>'."\n";
                    $input.='
                            <script type="text/javascript">
                              RANGE_CAL_1 = new Calendar({
                                      inputField: "'.$field_name.'",
                                      dateFormat: "%Y-%m-%d %H:%M",
                                      trigger: "'.$field_name.'-datepicker",
                                      showTime : true,
                                      bottomBar: false,
                                      onSelect: function() {
                                              var date = Calendar.intToDate(this.selection.get());
                                              LEFT_CAL.args.min = date;
                                              LEFT_CAL.redraw();
                                              this.hide();
                                      }
                              });
                            </script>                        
                            ';
                    
                    $this->calandarOnCall = true;
                    if( $type_validation == "" ){
                      $type_validation = "date_time";
                    }
                }
		break;

            case "date":
                if( $this->is_not_editable == true ){
                    $input = '<span id="'.$field_name.'">'.$field_value.'</span>'."\n";
                }else{                    
//                    $input = '<input id="'.$field_name.'" name="'.$field_name.'" type="text" value="'.$field_value.'" '.$add.' />'.'<img id="'.$field_name.'-datepicker" src="'.$this->path_calendar_page_image.'" class="date-botton" value="Cal" onclick="javascript: displayCalendar(document.forms[0].'.$field_name.','."'yyyy-mm-dd'".',this,true);">'."\n";                    
                    $input = '<input id="'.$field_name.'" name="'.$field_name.'" type="text" value="'.$field_value.'" '.$add.' />'.'<span id="'.$field_name.'-datepicker" class="date-botton" value="Cal"></span>'."\n";                    
                    $input.='
                            <script type="text/javascript">
                              RANGE_CAL_1 = new Calendar({
                                      inputField: "'.$field_name.'",
                                      dateFormat: "%Y-%m-%d",
                                      trigger: "'.$field_name.'",
                                      bottomBar: false,
                                      onSelect: function() {
                                              var date = Calendar.intToDate(this.selection.get());
                                              LEFT_CAL.args.min = date;
                                              LEFT_CAL.redraw();
                                              this.hide();
                                      }
                              });
                            </script>                        
                            ';
                    $this->calandarOnCall = true;
                    if( $type_validation == "" ){
                      $type_validation = "date";
                    }
                }
		break;

		case "time":
                if( $this->is_not_editable == true ){
                    $input = '<span id="'.$field_name.'">'.$field_value.'</span>'."\n";
                }else{
                    $input = '<input id="'.$field_name.'" name="'.$field_name.'" type="text" value="'.$field_value.'" '.$add.' />'."\n";
                    $this->calandarOnCall = true;
                    if( $type_validation == "" ){
                      $type_validation = "time";
                    }
                }
		break;

		case "captcha":

                if( $this->is_not_editable == false ){

                	//Initialisation of the params of the captcha

    				if(is_numeric($field_options["width"]) == true){$params_captcha="width=".$field_options["width"];}else{$params_captcha="";}

    				if(is_numeric($field_options["height"]) == true){
    					if( $params_captcha != "" ){
    						$params_captcha.="&";
    					}
    					$params_captcha.="height=".$field_options["height"];
    				}else{
    					$params_captcha.="";
    				}

    				if(is_numeric($field_options["characters"]) == true){
    					if( $params_captcha != "" ){
    						$params_captcha.="&";
    					}
    					$params_captcha.="characters=".$field_options["characters"];
    				}else{
    					$params_captcha.="";
    				}

    				if( $params_captcha != "" ){
    					$params_captcha.="&";
    				}
    				$params_captcha.="name=".$field_name;


    				if( $params_captcha != "" ){
    					$params_captcha = "?".$params_captcha;
    				}

    				//Generate the image & input
    				$input = '<input id="'.$field_name.'" name="'.$field_name.'" type="text" value="'.$field_value.'" '.$add.' />'.'<img src="'.$this->path_captcha_page.$params_captcha.'" />'."\n";
    				$type_validation = "captcha";
                }
				break;
		}
		/*
		$this->Form_ajax = true;
		if( $this->Form_ajax == true ){
			$start_field	= '<div class="form-row">';
			$end_field 		= '</div>';
			$start_label	= '<div class="field-label">';
			$end_label 		= '</div>';
			$start_input	= '<div class="field-widget">';
			$end_input 		= '</div>';
		}else{
			$start_field	= '';
			$end_field 		= '';
			$start_label	= '';
			$end_label 		= '';
			$start_input	= '';
			$end_input 		= '';
		}
		*/
		$output = '';

		$array_remarque = $this->showErrorHTMLForms($field_name,$type_validation,$remarque);
		$field_valid 	= $array_remarque[0];
		$field_remarque = $array_remarque[1];

		if($field_type == "file"){
			$file_remarque = $this->isValidFile($field_name,$field_options);
			if( $file_remarque != ""){
                            $field_remarque .= $file_remarque;
                            $field_valid = false;
			}
		}

		if( $field_valid == false ){ $style_balise = $this->form_remarque_balise_error; }else{ $style_balise = ''; }

			if( $this->is_listOrParagraphe != "" ){

				switch( trim($this->is_listOrParagraphe) ){
					case "ul":
					case "ol":
						$balise 	= 'li';
						break;
					case "p":
						$balise 	= 'p';
						break;
					case "span":
						$balise 	= 'span';
						break;
					case "div":
						$balise 	= 'div';
						break;
					case "default":
						$balise 	= trim($this->is_listOrParagraphe);
						break;
				}

			}else{
				$balise 	= 'p';
			}


			$add_balise = "";
			if( !empty($balise_add) ){
				if( is_array($balise_add) ){
					foreach( $balise_add as $key => $att){
						if( ( $key != "" ) && ( $att != "" ) ){
							$add_balise = $key.'="'.$att.'" ';
						}

						if( ( $key == "" ) && ( $att != "" ) ){
							$add_balise = $att.' ';
						}
					}
				}else{
					$add_balise = $balise_add;
				}
			}

			$start_balise 	= '<'.$balise.' id="field_'.$field_name.'" '.$style_balise.' '.$add_balise.'>';
			$end_balise 	= '</'.$balise.'>';


            if( $this->is_not_editable == true ){
                $field_remarque = '';
            }
            if ( ( $this->is_not_editable != true ) or ( ( $field_type != "captcha" ) and ( $this->is_not_editable == true ) ) ) {
                if( $add_msg_count != "" ){
                    $field_remarque = $add_msg_count.$field_remarque;                
                }
               
                                if( $field_label == "" ){
            				$output.= 	$start_balise."\n".''.$input.
            							''.$field_remarque."\n".
            							$end_balise."\n";
            			}else{
            				$label.= 	'<label>'."\n"
            							.''.$field_label.' :</label>'."\n";
            
            				$output.= 	$start_balise."\n".''.$label.
            							$input."\n".
            							''.$field_remarque."\n".
            							$end_balise."\n";
            			}
            }
		//Sauvegarder le champs

		$this->Fields[$field_name] = array(
										"name" 			=> $field_name,
										"validation" 	=> $type_validation,
										"html" 			=> $output,
										"label" 		=> $field_label,
										"type" 			=> $field_type,
										"value" 		=> $field_value,
										"options" 		=> $field_options,
										"remarque" 		=> $remarque,
										"add" 			=> $field_add
									);
		//Concatener le code HTML du champs
		$this->FormHTML = $this->FormHTML.$output;

		return ;
	}

	/**
	 * add($fieldDB,$show,$action,$field_details)
	 * @param string $fieldDB : Nom du champs dal base de donnée à récupérer pour la modification
	 * @param boolean $show : aficher le champs ou non dans le formulaire
	 * @param array $action : action à faire pour la requête SQL (Action_On_Insert,Action_On_Update)
	 * 						   -> string : field | array : value masked
	 * @param array $field_details : tableau de valeurs à ajouter au formulaire ->
	 * addHTMLForms($field_name,$field_label,$field_type,$field_value,$field_options,$type_validation,$remarque, $field_add, $balise_add)
	 * 		array@param string : $field_name 	-> nom du champs
	 * 		array@param string : $field_label 	-> description du champs
	 * 		array@param string : $field_type 	-> type du champs: {text | hidden | file | select | textarea | checkbox | radio | editor | button | submit | reset | date_time}
	 * 		array@param string or array : $field_value 	-> valeur du champs : S'il est array alors la valeur est toujour celle par default Sinon la valeur recuperera la valeurs du Post apres l'envoi du formulaire
	 * 		array@param array : $field_options 	-> options du champs pour le select , radio et les checkbox
	 * 		array@param string : $type_validation -> nom du champs [Type de validation: notempty, number, email, et date]
	 * 		array@param string : $remarque	 	-> nom du champs [remarque erreur]
	 * 		array@param string : $add	 		-> attributs supplimentaire [par exemple : class, style, onclick, onchange, ... ]
	 *
	 * Fonction permettant d'ajouter les détails d'un champs avec le traitement de son affichage ou non avec spécification de l'action
	**/
	function add($fieldDB,$show,$action,$field_details)
	{
		
            if( !in_array(false,$this->groups_to_show) ){
            if( $show == true ){
                
            if( $field_details[2]!= "free" ){
    			if( ($this->sqlTable != "") and ( $this->IdSqlTable != "" ) and ( $this->IdRequest != "") and ( $fieldDB != "" ) ){
    				if( $this->sql == "" ){
    					$sql = "SELECT * FROM ".$this->escapeDB($this->sqlTable)." WHERE ".$this->IdSqlTable." = '".$this->escapeDB($_GET[$this->IdRequest])."'";	
    				}else{
    					$sql = $this->sql;	
    				}
					
				$field_value = $this->valueInsertOrUpdate($field_details[0],$field_details[3],$sql,$fieldDB,$this->IdRequest);
                
                
    			}else{
    				if( $this->isSubmit() ){
    					if( !is_array($field_details[3])){
    						$field_value = $this->request[$field_details[0]];
    					}else{
                                                if( ($field_details[2] == "checkbox") or ($field_details[2] == "multipleselect") ){
                                                   $field_value = $field_details[3];
                                                }else{
                                                   $field_value = $field_details[3][0]; 
                                                }
    					}
    				}else{
    					if( !is_array($field_details[3])){
    						$field_value = $field_details[3];
    					}else{
                                            if( ($field_details[2] == "checkbox") or ($field_details[2] == "multipleselect") ){
                                               $field_value = $field_details[3];
                                            }else{
                                               $field_value = $field_details[3][0]; 
                                            }
    					}
    				}
                
    			}
            }else{
                 $field_value = $field_details[3];
            }
                
			$this->addHTMLForms($field_details[0],$field_details[1],$field_details[2],$field_value,$field_details[4],$field_details[5],$field_details[6], $field_details[7], $field_details[8], $field_details[9], $field_details[10]);
				if( !is_array($fieldDB) ){
					$this->add_action($fieldDB,$action);
				}else{
					//groped actions to update database fields
					foreach( $fieldDB as $keyfieldDB => $arrfieldDB ){						
						if( is_array($arrfieldDB) and (count($arrfieldDB) == 3) and ( count($arrfieldDB[1]) == 2 ) ){
							if( isset($this->request[$field_details[0]])){
								$array_values_field = $this->request[$field_details[0]];
							}else{
								$array_values_field = array();					
							}
							if( in_array($arrfieldDB[2],$array_values_field)==true){
								$act[$arrfieldDB[2]] = $arrfieldDB[1][0];
							}else{
								$act[$arrfieldDB[2]] = $arrfieldDB[1][1];
							}
							$this->add_action($arrfieldDB[0],array(array($act[$arrfieldDB[2]]),array($act[$arrfieldDB[2]])));
						}
					}					
				}
				
			}
		}
	}

	/**
	 * add_action($name,$action)
	 * @param string $name	: le nom de l'action du champs dans la basede donnée
	 * @param array $action : action à faire pour la requête SQL (Action_On_Insert,Action_On_Update)
	 * 						   -> string : field | array : value masked
	 * Fonction permettant d'ajouter une action en insertion ou en mise à jour
	**/
	function add_action($name,$action)
	{
		if( !in_array(false,$this->groups_to_show) ){
			if( $name != "" ){
				if( is_array($action) ){
					if( !empty($action[0]) ){
						//Add action on Insert
						$this->data_insert[$name] = $action[0];
						$this->table_data_to_render[$name]= $action[0];
						//Add action on Update
						if( !empty($action[1]) ){
							$this->data_update[$name] = $action[1];
						}
					}else{
                        if( !empty($action[1]) ){
                            $this->table_data_to_render[$name]= $action[0];
                            $this->data_update[$name] = $action[1];
						}
					}
				}else{
					if($action != "" ){
						$this->data_insert[$name] = $action;
						$this->data_update[$name] = $action;
					}
				}
			}
		}	
	}

	/**
	 * add_group_to_show($group,$show)
	 * @param string $group	: le nom du groupe
	 * @param boolean $show : aficher le champs ou non dans le formulaire
	 * Fonction permettant d'ajouter un groupe d'afichage ou de masquage selon le profile $show
	**/
	function add_group_to_show($group,$show)
	{
		$this->groups_to_show[$group] = $show;
	}

	/**
	 * add_group_to_show($group,$show)
	 * @param string $group	: le nom du groupe
	 * @param boolean $show : aficher le champs ou non dans le formulaire
	 * Fonction permettant d'ajouter un groupe d'afichage ou de masquage selon le profile $show
	**/
	function remove_group_to_show($group)
	{
		$this->groups_to_show[$group] = true;
	}
	
	/**
	 * showSubmitAndReset($field_submit,$field_reset)
	 * @param string $field_submit : nom du champ (submit)
	 * @param string $field_reset : nom du champ (reset)
	 * Fonction permettant de mettre les boutton de submit et du reset
	**/
	function showSubmit($field_name_submit,$label_submit)
	{
	    if($this->is_not_editable == false ){
    //		$output = '<input type="submit" name="'.$field_name_submit.'" id="'.$field_name_submit.'" value="'.$label_submit.'" />'."\n";
    		$this->fieldSubmit = $field_name_submit;
    		$output = '<button name="'.$field_name_submit.'" id="'.$field_name_submit.'" type="submit" >'.$label_submit.'</button>'."\n";
    		//Concatener le code HTML du champs
    		$this->FormHTML = $this->FormHTML.$output;
        }
		return;
	}

	/**
	 * showSubmitAndReset($field_submit,$field_reset)
	 * @param string $field_submit : nom du champ (submit)
	 * @param string $field_reset : nom du champ (reset)
	 * Fonction permettant de mettre les boutton de submit et du reset
	**/
	function showReset($field_name_reset,$label_reset)
	{
	    if($this->is_not_editable == false ){
    //		$output = '<input type="submit" name="'.$field_name_reset.'" id="'.$field_name_reset.'" value="'.$label_reset.'" />'."\n";
    		$output = '<button name="'.$field_name_reset.'" id="'.$field_name_reset.'" type="reset" >'.$label_reset.'</button>'."\n";
    		//Concatener le code HTML du champs
    		$this->FormHTML = $this->FormHTML.$output;
        }
		return ;
	}

	/**
	 * openForm($name, $action, $methode)
	 * Fonction permettant de fermer le formulaire
	 * @param string $name : nom du formulaire
	 * @param string $action : action du formulaire
	 * @param string $methode : methode du formulaire
	 * return la balise de 'overture du formulaire
	**/
	function openForm($name, $action, $methode )
	{
		if( !in_array(false,$this->groups_to_show) ){
			$this->form_attributs["name"] 	= $name;
			$this->form_attributs["id"] 	= $name;
			$getparams = "";
			foreach($_GET as $key => $val){
				if( $getparams == ""){ $getparams.="?"; }else{$getparams.= "&"; }
				$getparams .= $key."=".$val; 	
			}
			$this->form_attributs["action"] = $action.$getparams;
			$this->form_attributs["method"] = $methode;

			return;
		}
	}

	/**
	 * closeForm()
	 * Fonction permettant de fermer le formulaire
	 * return la balise de fermeture du formulaire
	**/
	function closeForm()
	{
		if( !in_array(false,$this->groups_to_show) ){
			$this->isFormClosed = true;
			return ;
		}
	}

	/**
	 * openFieldset($legend)
	 * Fonction permettant d'ouvrir le fieldset
	 * @param string $legend : legende 
	 * return la balise de ouverture du fieldset
	**/	
	function openFieldset($legend)
	{
		if( !in_array(false,$this->groups_to_show) ){
			
                        if( $this->type_fieldset == "div" ){
                            $tag_fieldset   = "div";
                            $tag_legend     = "div"; 
                            $class_fieldset = 'class="'.$this->class_fieldset_as_div.'"';
                            $class_legend   = 'class="'.$this->class_legend_as_div.'"';
                        }else{
                            $tag_fieldset   = "fieldset";
                            $tag_legend     = "legend"; 
                            $class_fieldset = 'class="'.$this->class_fieldset_as_div.'"';
                            $class_legend   = 'class="'.$this->class_legend_as_div.'"';
                        }
                        
			if( is_array($legend) and count($legend) == 2 ){ 
				$id = $legend[0]; $legend = $legend[1];
				$output = '<'.$tag_fieldset.' id="'.$id.'" '.$class_fieldset.'>'."\n";	
			}else{
				$output = '<'.$tag_fieldset.' '.$class_fieldset.'>'."\n";
			}
			if( ($legend != "") and  !is_array($legend) ){
			$output.= 
	  				'<'.$tag_legend.' '.$class_legend.'>'."\n".'
					'.$legend.'
					</'.$tag_legend.'>'."\n";
			}
                        
                        if( $this->type_fieldset == "div" ){
                            $output.= '<'.$tag_fieldset.'>'."\n";	
                        }
			
                        if( $this->is_listOrParagraphe != "" ){
				//$this->is_listOrParagraphe => ["", "p":paragraphe, "ul":liste, "ol":liste numéroté] ::::> OUVERTURE DE LA BALISE
				$output.= '<'.trim($this->is_listOrParagraphe).'>'."\n";
				$this->is_listOrParagrapheCount++; //pour pouvoir verifier l'ouverture et la fermeture des balises
			}
	
			//Concatener le code HTML du champs
			$this->FormHTML = $this->FormHTML.$output;
		}
		return;
	}

	/**
	 * closeFieldset()
	 * Fonction permettant de fermer le fieldset
	 * return la balise de fermeture du fieldset
	**/
	function closeFieldset(){

		if( !in_array(false,$this->groups_to_show) ){
                        if( $this->type_fieldset == "div" ){
                            $tag_fieldset   = "div";
                        }else{
                            $tag_fieldset   = "fieldset";
                        }
                        
			if( $this->is_listOrParagraphe != "" ){
				//$this->is_listOrParagraphe => ["", "p":paragraphe, "ul":liste, "ol":liste numéroté] ::::> FERMETURE DE LA BALISE
				$output.= '</'.trim($this->is_listOrParagraphe).'>'."\n";
				$this->is_listOrParagrapheCount--; //pour pouvoir verifier l'ouverture et la fermeture des balises
			}else{
				$output = '';
			}
			
			$output .= '</'.$tag_fieldset.'>'."\n";
                        if( $this->type_fieldset == "div" ){
                            $output.= '</'.$tag_fieldset.'>'."\n";	
                        }
			//Concatener le code HTML du champs
			$this->FormHTML = $this->FormHTML.$output;
		}
		return;
	}
	
	/**
	 * addtag($tag,$value)
	 * Fonction permettant d'ajouter un tag
	 * @param string $legend : legende 
	 * return la balise de ouverture du fieldset
	 */	
	function addtag($tag,$value,$adds="")
	{
		if( !in_array(false,$this->groups_to_show) ){
			$output = '';
			if( ($value != "") ){
				if( in_array($tag,array("p","span","div","strong","i","u","label","h1","h2","h3","h4")) ){
					$output.= 
	  					'<'.$tag." ".$adds.'>'."\n".'
						'.$value."\n".
						'</'.$tag.'>'."\n";
				}else{
					$output.= $value;
				}
			}

			//Concatener le code HTML du champs
			$this->FormHTML = $this->FormHTML.$output;
		}
		return;
	}
	
	/**
	 * testErrorHTMLForms($field,$type_validation,$remarque) :
	 * fonction : affichant les differentes erreurs du champs du formulaire HTML
	 * @param string : $field 			-> nom du champs
	 * @param string : $type_validation -> nom du champs [Type de validation: notempty, number, email, et date]
	 * @param boolean: $is_private		-> true : test privé récursive | false : test public
	**/
	function testErrorHTMLForms($field,$type_validation,$is_private)
    {		
		//Debut de la validation
		$value = trim($this->request[$field]);
		
		$valid = false;

		if( is_array($type_validation) ){
			foreach( $type_validation as $key_err => $val_err){
				switch ($key_err){
					case "regx":
						$regx	= $val_err;
						$val_err= "regx";
						break;
					case "sql"://added the 01/01/2011
						$regx	= $val_err;
						$val_err= "sql";
						break;
					case "=":
						$regx	= $val_err;
						$val_err= "=";
						break;	
					case ">":
						$regx	= $val_err;
						$val_err= ">";
						break;
					case ">=":
						$regx	= $val_err;
						$val_err= ">=";
						break;
					case "<":
						$regx	= $val_err;
						$val_err= "<";
						break;
					case "<=":
						$regx	= $val_err;
						$val_err= "<=";
						break;
					case "<>":
						$regx	= $val_err;
						$val_err= "<>";
						break;
					case "long>":
						$regx	= $val_err;
						$val_err= "long>";
						break;	
					case "long>=":
						$regx	= $val_err;
						$val_err= "long>=";
						break;	
					case "long<":
						$regx	= $val_err;
						$val_err= "long<";
						break;	
					case "long<=":
						$regx	= $val_err;
						$val_err= "long<=";
						break;	
					case "long=":
						$regx	= $val_err;
						$val_err= "long>";
						break;
					case "long<>":
						$regx	= $val_err;
						$val_err= "long>";
						break;
						
					case "comparfields":
					//vérifier la validation des autres champs
						$regx	= $val_err;
						$val_err= "comparfields";
						break;
				}
				
				switch ($val_err){
					case "":
							$valid = true;
							$this->validation_fields[$field][$val_err] = $valid;
							break;
					case "empty":
							if (empty($value) or strlen($value)==0 ){ 
								$valid = true;
							}
							$this->validation_fields[$field][$val_err] = $valid;
							break;
					case "notempty":
							if (!empty($value) && strlen($value)>0 ){
								$valid = true;
							}
							$this->validation_fields[$field][$val_err] = $valid;
							break;
					case "number":
							if ( is_numeric($value) and (!empty($value) && strlen($value)>0 ) ){
								$valid = true;
							}
							$this->validation_fields[$field][$val_err] = $valid;
								//$this->validation_fields[$field][$val_err] = $this->isNumber($number);
							break;
					case "email":
							if ( !empty($value) && strlen($value)>0 ){
			                	$valid = $this->is_Mail($value);
								$this->validation_fields[$field][$val_err] = $valid;
							}
							break;
					case "date":
							//Verifier la date
							if (!empty($value) && strlen($value)>0 ){
			                    $valid = $this->is_Date($value);
								$this->validation_fields[$field][$val_err] = $valid;
							}
							break;
					case "date_time":
							//Verifier la date avec temps
							if (!empty($value) && strlen($value)>0 ){
			                    $valid = $this->is_Date_Time($value);
								$this->validation_fields[$field][$val_err] = $valid;
							}
							break;

                    case "time":
							//Verifier la date avec temps
                            $regx = '/^(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9])(:([0-5][0-9]))?$/';
                    		if (preg_match($regx, $value) == true )
					        {
					            $valid = true;
							}
                            $this->validation_fields[$field][$val_err] = $valid;
							break;

                    case "url":
					//Verifier la date avec temps
			                if (!empty($value) && strlen($value)>0 ){
                                            $valid = $this->is_URL($value);
                                            $this->validation_fields[$field][$val_err] = $valid;
                                        }
                                        break;
                    case "ip":
                                            if (!empty($value) && strlen($value)>0 ){
                                                $valid = $this->isIPAddress($value);
                                                $this->validation_fields[$field][$val_err] = $valid;
                                            }
                                            break;
					case "alpha":
							if (!empty($value) && strlen($value)>0 ){
                                                            $valid = $this->isAlpha($value,'');
                                                            $this->validation_fields[$field][$val_err] = $valid;
							}
							break;
					case "alphanum":
							if (!empty($value) && strlen($value)>0 ){
								$valid = $this->isAlphaNumeric($value);
								$this->validation_fields[$field][$val_err] = $valid;
							}
							break;
					case "regx":
						if (preg_match($regx, $value) == true )
					        {
					            $valid = true;
						}
                                                $this->validation_fields[$field][$val_err] = $valid;
                                                break;
					case "sql"://added the 01/01/2011
                                                if (!empty($value) && strlen($value)>0 ){
                                                        if( $this->DB_num_rows($regx) == 0 ) { $valid = true; }
                                                }
                                                $this->validation_fields[$field][$val_err] = $valid;
						break;
					case "=":
						if ($value  == $regx ){
   							$valid = true;
        				}
        				$this->validation_fields[$field][$val_err] = $valid;
						break;
					case ">":
						if ($value > $regx ){
   							$valid = true;
        				}
      					$this->validation_fields[$field][$val_err] = $valid;
        				break;
					case ">=":
						if ($value >= $regx ){
   							$valid = true;
        				}
        				$this->validation_fields[$field][$val_err] = $valid;
						break;
					case "<":
						if ($value < $regx ){
							$valid = true;
    					}
    					$this->validation_fields[$field][$val_err] = $valid;
						break;
					case "<=":
						if ($value <= $regx ){
   							$valid = true;
        				}
        				$this->validation_fields[$field][$val_err] = $valid;
						break;
					case "<>":
						//if ( in_array("notempty",$type_validation) ){
                                                    if ($value != $regx ){
	   						$valid = true;
                                                    }else{
	   						$valid = false;
                                                    
                                                    }
	        				$this->validation_fields[$field][$val_err] = $valid;
						//}
                                                echo '<>$valid : '.$valid;
						break;	
					case "long>":
						if (strlen($value) > $regx ){
   							$valid = true;
        				}
        				$this->validation_fields[$field][$val_err] = $valid;
						break;
					case "long>=":
						if (strlen($value) >= $regx ){
   							$valid = true;
        				}
        				$this->validation_fields[$field][$val_err] = $valid;
						break;	
					case "long<":
						if (strlen($value) < $regx ){
   							$valid = true;
        				}
        				$this->validation_fields[$field][$val_err] = $valid;
						break;
					case "long<=":
						if (strlen($value) <= $regx ){
   							$valid = true;
        				}
        				$this->validation_fields[$field][$val_err] = $valid;
						break;	
					case "long=":
						if (strlen($value) == $regx ){
   							$valid = true;
        				}
        				$this->validation_fields[$field][$val_err] = $valid;
						break;	
					case "long<>":
						if (strlen($value) != $regx ){
   							$valid = true;
        				}
        				$this->validation_fields[$field][$val_err] = $valid;
						break;
						
					case "comparfields":
					//vérifier la validation des autres champs
					/*
					array(
					"comparfields" => array(
											array($field => $validation),
											array($field => $validation)
											)
					)
					// Vrai => au moin  un tableau : array($field => $validation) -> Vrai
					*/
						if( is_array($regx) ){
							$valid_compar = array();

							foreach( $regx as $key_validation => $val_validation ){
								$comparfields = array();
								foreach( $val_validation as $key_field => $val_field ){
                                                                    $comparfields[$key_field] = $this->testErrorHTMLForms($key_field,$val_field,true);
								}
								if( in_array(false,$comparfields) ){
                                                                    $valid_compar[$key_validation] = false;
								}else{
                                                                    $valid_compar[$key_validation] = true;
								}
							}
							if( in_array(true,$valid_compar) ){
								$valid = true;
							}

						}
						$this->validation_fields[$field][$val_err] = $valid;
						break;

					case "captcha":
							if( ($_SESSION[$field] == $value) && !empty($_SESSION[$field]) ) {
								$valid = true;
							}
							$this->validation_fields[$field][$val_err] = $valid;
								break;
				}	
				if( $this->validation_fields[$field] == false ){ $valid = false; }
			}
		}else{
			
			switch ($type_validation){
				case "":
						$valid = true;
						$this->validation_fields[$field] = $valid;
						break;
				case "notempty":
						if (!empty($value) && strlen($value)>0 ){ 
							$valid = true;
						}
						$this->validation_fields[$field][$type_validation] = $valid;
						break;
				case "empty":
						if (empty($value) and strlen($value)==0 ){
							$valid = true; 
						}
						$this->validation_fields[$field][$type_validation] = $valid;
						break;
				case "number":
						if ( is_numeric($value) ){
							$valid = true;
						}
						$this->validation_fields[$field][$type_validation] = $valid;
						//$valid = $this->isNumber($number);
						break;
				case "email":
						$valid = $this->is_Mail($value);
						$this->validation_fields[$field][$type_validation] = $valid;
						break;
				case "date":
						//Verifier la date
	                     $valid = $this->is_Date($value);
	                     $this->validation_fields[$field][$type_validation] = $valid;
						break;
				case "date_time":
						//Verifier la date avec temps
	                    $valid = $this->is_Date_Time($value);
	                    $this->validation_fields[$field][$type_validation] = $valid;
						break;
                        case "time":
  					//Verifier la date avec temps
                            $regx = '/^(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9])(:([0-5][0-9]))?$/';
                    		if (preg_match($regx, $value) == true )
  			        {
  			            $valid = true;
  					}
                            $this->validation_fields[$field][$val_err] = $valid;
  					break;
				case "url":
			//Verifier la date avec temps
	                    $valid = $this->is_URL($value);
	                    $this->validation_fields[$field][$type_validation] = $valid;
						break;
				case "ip":
						$valid = $this->isIPAddress($value);
						$this->validation_fields[$field][$type_validation] = $valid;
						break;
				case "alpha":
						$valid = $this->isAlpha($value,'');
						$this->validation_fields[$field][$type_validation] = $valid;
						break;
				case "alphanum":
						$valid = $this->isAlphaNumeric($value);
						$this->validation_fields[$field][$type_validation] = $valid;
						break;
				case "captcha":
						if( ($_SESSION[$field] == $value) && !empty($_SESSION[$field]) ) {
							$valid = true; 
						}
						$this->validation_fields[$field][$type_validation] = $valid;
						break;
			}

		}
		
		if( ($valid == false) and ($is_private == false) ){
			$this->validFormList[] = $field;
		}
		
		return $valid;
	}
	
	/**
	 * showErrorHTMLForms($field,$type_validation,$remarque) :
	 * fonction : affichant les differentes erreurs du champs du formulaire HTML
	 * @param string : $field 			-> nom du champs
	 * @param string : $type_validation -> nom du champs [Type de validation: notempty, number, email, et date]
	 * @param string : $remarque	 	-> nom du champs [remarque erreur]
	**/
	function showErrorHTMLForms($field,$type_validation,$remarque)
    {
		//Pour les remarques sur la validation des champs
		$span_RMQ_input_start_remarque		= '<span '.$this->css_form_remarque.'>'."\n";
		$span_RMQ_input_end_remarque 		= '</span>'."\n";
		if( $this->isSubmit() ){
			$span_RMQ_input_start_error 	= '<span '.$this->css_form_remarque.'>'.'<span '.$this->css_form_remarque_error.'>'."\n";
			$span_RMQ_input_start_sucess 	= '<span '.$this->css_form_remarque.'>'.'<span '.$this->css_form_remarque_sucess.'>'."\n";
			$span_RMQ_input_end 		= '</span>'."\n".'</span>'."\n";
		}else{
			$span_RMQ_input_start_error 	= $span_RMQ_input_start_remarque.'<span>'."\n";
			$span_RMQ_input_start_sucess 	= $span_RMQ_input_start_remarque.'<span>'."\n";
			$span_RMQ_input_end 		= '</span>'."\n</span>";
		}
		
		$valid = $this->testErrorHTMLForms($field,$type_validation,false);

		if( $valid == true ){
			if( $remarque != "" ){
				$remarque = $span_RMQ_input_start_sucess.$remarque.$span_RMQ_input_end;
			}
		}else{
			if( $remarque == "" ){
				if( is_array($type_validation) ){
					$remarque = $this->txt_HTMLForm_0." : (".print_r($this->validation_fields[$field],true).")";
				}else{
					$remarque = $this->txt_HTMLForm_0." : (".$type_validation.")";
				}
			}
			$remarque = $span_RMQ_input_start_error.$remarque.$span_RMQ_input_end;
		}
		
		return array( 0 => $valid, 1 => $remarque );
	}
	
	/**
	 * isFormValid()
	 * @fonction : permettant de vérifier si pas d'erreur dans le formulaire
	 * @return boolean : vrai-> si le formulaire est valide , faux-> si le formulaire est invalide
	**/
	function isFormValid()
	{
		if ( count($this->validFormList) == 0 ) { 
			return true;
		} else{ 
			return false; 
		}
	}

	/**
	 * isSubmit()
	 * Fonction permettant de verifier si l'envoi des champs et effectué avec succès et sans erreurs
	 * @return boolean : vrai -> si succès , faux -> sinon
	**/
	function isSubmit()
    {		
		if( isset($this->request[$this->fieldSubmit]) ){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * isValidSubmit()
	 * Fonction permettant de verifier si l'envoi des champs et effectué avec succès et sans erreurs
	 * @return boolean : vrai -> si succès , faux -> sinon
	**/
	function isValidSubmit()
    {		
		if( $this->isSubmit() && $this->isFormValid() ){
			return true;
		}else{
			return false;
		}
		
		
		
	}

	/**
	 * is_Date_Time($date_time)
	 * @Fonction private :  fonction permettant de vérifier si l'entrée est une date avec le temps dans le format (aaaa-mm-jj HH:MM:SS) ou pas
	 * @param string : $date_time
	 * @return boolean
	**/				
	function is_Date_Time($date_time)
	{
		$regex_date_time	= '/^(19|20)[0-9]{2}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01]) (0[0-9]|1[0-9]|2[0-3]):([0-5][0-9])(:([0-5][0-9]))?$/';
		
		if ( preg_match($regex_date_time, $date_time) ) {

			$part1 = explode(" ",$date_time);
			$date 	= str_replace(array('\'', '-', '.', ','), '-', $part1[0]);
			$part2 = explode("-",$date);
			if ( checkdate($part2[1], $part2[2], $part2[0]) ) 
			{
				$return = true;
			} else {
				$return =  false;
			}

		} else {
			$return = false;
		}
	
		return $return;
	}

	/**
	 * is_Date($date)
	 * @Fonction private :  fonction permettant de vérifier si l'entrée est une date ou pas [le format est: (aaaa-mm-jj) ou (aaaa mm jj) ou (aaaa/mm/jj) ]
	 * @param string : $date
	 * @return boolean
	**/
	function is_Date($date)
	{
		$regex_date	= '/^(19|20)[0-9]{2}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/';
		if ( preg_match($regex_date, $date) ) {
			$date_last 	= str_replace(array('\'', '-', '.', ',', ' '), '-', $date);
			$part = explode("-",$date_last);
			if ( checkdate($part[1], $part[2], $part[0]) ) 
			{
				$return = true;
			} else {
				$return = false;
			}
		} else {
			$return = false;
		}
		return $return;
	}

	/**
	 * is_Mail($mail)
	 * @Fonction private :  fonction permettant de vérifier si l'entrée est mail [le format est : mail@domaine.com]
	 * @param string : $mail
	 * @return boolean
	**/
	function is_Mail($mail)
	{
		if (strlen($mail)>0 && preg_match('/^(?:[a-z0-9_-]+?\.)*?[a-z0-9_-]+?@(?:[a-z0-9_-]+?\.)*?[a-z0-9_-]+?\.[a-z0-9]{2,5}$/i', $mail) ){ 
			return true;
		} else {	
	      	return false;
   	 	}
	}

	/**
	 * is_URL($url)
	 * @Fonction private :  fonction permettant de vérifier si l'entrée est adresse url [le format est : http://domaine.com]
	 * @param string : $url
	 * @return boolean
	**/
	function is_URL($url)
	{
		$regex_url	= "/^http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?$/i";
		$regex_url_ = '/\\A(?:(https?|ftps?|file|news|gopher):\\/\\/[\\w\\-_]+(\\.[\\w\\-_]+)+([\\w\\-\\.,\'@?^=%&:;\/~\\+#]*[\\w\\-\\@?^=%&\/~\\+#])?)\\z/i';
		if (strlen($url)>0 && preg_match($regex_url, $url) ){
			return true;
		} else {
    	  	return false;
    	}
	}

	/**
	 * is_regx($regx,$value)
	 * @Fonction public :  fonction permettant de vérifier si l'entrée est valide par rapport au test regx
	 * @param string $regx : test de regx
	 * @param string $value: valeur à tester
	 * @return boolean
	**/
	function is_regx($regx,$value)
	{
		if ( preg_match($regx, $value) ){ 
			return true;
		} else {
    	  	return false;
    	}
	}

	/**
	 * isIPAddress($value)
	 * @function private : Checks for a valid IP Address
	 * @param string $value The value to check
	 * @return boolean TRUE if the value is an IP address, FALSE if not
	**/
   function isIPAddress($value)
    {
        $pattern = "/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/i";
        if (preg_match($pattern, $value))
        {
            return true;
        } else {
            return false;
        }
    }

	/**
	 * isNumber($number)
	 * @function private : Checks to see if a variable is a number
	 * @param integer $number The value to check
	 * @return boolean TRUE if the value is a number, FALSE if not
	**/
	function isNumber($number)
    {
        if (preg_match("/^\-?\+?[0-9e1-9]+$/", $number))
        {
            return true;
        } else {
            return false;
        }
    }

	/**
	 * isAlpha($value, $allow = '')
	 * function private : Determines if a string is alpha only
	 * @param string $value The value to check for alpha (letters) only
	 * @param string $allow Any additional allowable characters
	 * @return boolean
	**/
    function isAlpha($value, $allow = '')
    {
        if (preg_match('/^[a-zA-Z' . $allow . ']+$/', $value))
        {
            return true;
        } else {
            return false;
        }
    }

	/**
	 * isAlphaNumeric($value)
	 * function private : Determines if a string is alpha-numeric
	 * @param string $value The value to check
	 * @return boolean TRUE if there are letters and numbers, FALSE if other
	**/
   function isAlphaNumeric($value)
    {
        if (preg_match("/^[A-Za-z0-9 ]+$/", $value))
        {
            return true;
        } else {
            return false;
        }
    }	
	
	/**
	 * returnValuesUpdateORInsert($sql,$methode,$id,$fields)
	 * @param string : 	$sql 		=> requete SQL
	 * @param string : 	$methode 	=> Tableau de la Mehode de récupération des donnée [$_POST Ou $_GET ]
	 * @param string : 	$id			=> identificateur de l'appel
	 * @param array  : 	$fields		=> array(array($fieldDB : champs de la Base de donnée, $default : Les valeurs par default des champs du formulaire))
	 * @return array : 	"values" 				=> tableau des valeurs des champs identifié par le nom
	 *					"is_update" 			=> : Mise à jour du champs de la base de donnée
	 *					"is_error_OnUpdate" 	=> S'il y a ne erreur lors de non existance de l'id dans la table de la Base de donnée
	**/
	function returnValuesUpdateORInsert($sql,$methode,$id,$fields){
		if( isset($methode[$id]) && ( !empty($methode[$id]) ) ){
			//La mise à jour
			$values = array();
			$is_update = true;
			$is_error_OnUpdate = false;
			$row = $this->form->DB_fetch($sql);
			$num = $this->form->DB_num_rows($sql);
			if( $num!=0 ){
				foreach($fields as $fieldForm => $value){
					$fieldDB = $value[0];
					$values[$fieldForm] = $this->stripDB($row[$fieldDB]);
				}
				$is_error_OnUpdate = false;
			}else{
				$is_error_OnUpdate = true;
			}
		}else{
			$is_update = false;
			if( $this->isSubmit() ){
				foreach($fields as $fieldForm => $value){
					$values[$fieldForm] = $this->stripDB($this->request[$fieldForm]);
				}
			}else{
				foreach($defaults as $fieldForm => $value){
					$default = $value[1];
					$values[$fieldForm] = $default;
				}
			}
		}
		
		return array( "values" => $values, "is_update" => $is_update, "is_error_OnUpdate" => $is_error_OnUpdate);

	}

	function printJsCalandar()
	{		
		//le script est déja afficher => donc ne pas le reaffiche
		$this->calandarIsUsed = true;
		$this->path_calendar_page_images = $this->path_calendar_page.'images/';
		$this->path_calendar_page_langue = 'fr';
		/*
		echo "\n".'<!-- CSS -->'."\n"
			.'<link rel="stylesheet" href="'.$this->path_calendar_page.'dhtmlgoodies_calendar/dhtmlgoodies_calendar.css" media="screen"></LINK>'."\n"
			.'<SCRIPT type="text/javascript" src="'.$this->path_calendar_page.'dhtmlgoodies_calendar/dhtmlgoodies_calendar.js"></script>'."\n";
		*/
		return ;
	}

	/**
	 *  isValidFile($Fieldname,$FileArr)
	 * @Fonction permettant le copiage des fichiers des question ou des propostions si le type est (img)
	 * @param string $Fieldname : le nom du champs du formulaire concernant le fichier
	 * @param array $FileExt : les exentions du fichier accépté pour le fichier
	 * @param array $FileCopyType : 	"" OU null	=> copier avec le nom d'origine et ecraser l'ansiene fichier portant le même nom
	 *									"rename"	=> renomer le fichier par la valeur de la case 2
	 *									"copy"		=> renomer le fichier par le prifix de la valeur de la case 2 et le nombre de fichier de même nom
	 *									"error"		=> renvoi une erreur de copiage
	 *									"time"		=> renomer pa concatination avec le temps de copiage et le prifixe de la case 2
	 *									"time_name"	=> renomer pa concatination avec le temps de copiage concatené au nom d'origine
	 * @param string $target_path : le chemain du dossier de distination le fichier
	 * @return string $new_name : ["" => erreur de copy , autre => renvoi le nouveau nom du fichier]
	**/
	function isValidFile($Fieldname,$FileArr)	//$Fieldname,$FileExt,$FileCopyType,$target_path
	{
		$errorFile 	= "";
		$new_name 	= "";

		if( $this->Fields[$Fieldname]["validation"] != "" )
		{
		if( !empty($_FILES[$Fieldname]) && $this->isValidSubmit() )
		{

			if( !is_array($FileArr) ){
				$errorFile = $this->FORM_MSG_DeclarationFile_errors." : ".$Fieldname ; //Il y aune erreur de déclaration du fichier
			}else{
				if( $FileArr[2] == "" ){
					$errorFile = $this->FORM_MSG_DeclarationFile_etarget_path_errors." : ".$Fieldname ; //Il y aune erreur de déclaration du chemin du fichier 
				}
			}

			$FileExt 		= $FileArr[0];
			$FileCopyType 	= $FileArr[1];
			$target_path 	= $FileArr[2];
		    $target_size 	= $FileArr[3];
            $target_width 	= $FileArr[4];
            $target_height 	= $FileArr[5];

			$fichier_source 	= $_FILES[$Fieldname];
			$nom_fichier_source = $fichier_source['name'];
			
			$array_base_ext = $this->extractExtensionFile($nom_fichier_source);
			$extension 	= $array_base_ext[1];

			if( ( $FileExt == "" ) || ( is_array($FileExt) && in_array(strtolower($extension),$FileExt) ) )
			{
				if( is_array($FileCopyType) ){
					if( $FileCopyType[0] == "error" ){
						while (file_exists($target_path)) {
							//error exist
							$errorFile = $this->FORM_MSG_ExistFile_errors;
						}
					}
				}
				
			}else{
				//erreur d'extension
				$errorFile = $this->FORM_MSG_ExtensionFile_errors;
			}
            
            //Traiter la taille du fichier
            if( $fichier_source['size'] > $target_size ){
                $errorFile = $this->FORM_MSG_sizeFile_errors;
            }

            //Traiter la largeur et la hauteur de l'image
            if( in_array($fichier_source['type'],array('image/jpeg','image/gif','image/png','image/tiff')) && in_array(strtolower($extension),array("png","gif","jpe","jpg","jpeg","bmp","tif","tiff"))  && ($target_width > ImageSX($fichier_source['tmp_name']))&& ( $target_height > ImageSY($fichier_source['tmp_name'])) ){
                $errorFile = $this->FORM_MSG_typeFile_errors;
            }
			//erreur de request
			$errorFile = $this->FORM_MSG_requestFile_errors;
		}
		}
		if( $errorFile != "" ){
			$this->form->errors_copyFiles[] = $errorFile;
			$this->FORM_list_errors_submit[]= $errorFile;
			return $errorFile;
		}else{
			return "";
		}
	}
		
	/**
	 * iscopyFiles($FormFieldType,$FormFieldImage,$FormFieldDB)
	 * @Fonction permettant le copiage des fichiers des question ou des propostions si le type est (img)
	 * @param string $Fieldname : le nom du champs du formulaire concernant le fichier
	 * @param array $FileExt : les exentions du fichier accépté our le fichier
	 * @param array $FileCopyType : 	"" OU null	=> copier avec le nom d'origine et ecraser l'ansiene fichier portant le même nom
	 *									"rename"	=> renomer le fichier par la valeur de la case 2
	 *									"copy"		=> renomer le fichier par le prifix de la valeur de la case 2 et le nombre de fichier de même nom
	 *									"error"		=> renvoi une erreur de copiage
	 *									"time"		=> renomer pa concatination avec le temps de copiage et le prifixe de la case 2
	 *									"time_name"	=> renomer pa concatination avec le temps de copiage concatené au nom d'origine
	 * @param string $target_path : le chemain du dossier de distination le fichier
	 * @return string $new_name : ["" => erreur de copy , autre => renvoi le nouveau nom du fichier]
	**/
	function iscopyFiles()
	{
		$errorFile 	= "";
		$new_name 	= "";

		foreach( $this->Fields as $key => $field ){
			if( $field["type"] == "file" && ( $_FILES[$key]['name'] != "" ) ){
				$Fieldname		= $field["name"];
				$FileCopyType 	= $field["options"][1];
				$target_path 	= $field["options"][2];
                $target_size 	= $field["options"][3];
                $target_width 	= $field["options"][4];
                $target_height 	= $field["options"][5];
				if( count($this->form->errors_copyFiles) == 0 )
				{
					$fichier_source 	= $_FILES[$Fieldname];
					$nom_fichier_source = $fichier_source['name'];
					if( !is_array($FileCopyType) || empty($FileCopyType) ){
						$new_name = $nom_fichier_source;
					}else{
						$array_base_file = $this->extractExtensionFile($nom_fichier_source);
						switch($FileCopyType[0]){
							case "":
								$new_name = $nom_fichier_source;
								break;
							case "rename":
								if( $FileCopyType[1] == "" ){
									$errorFile = $this->FORM_MSG_RenameFile_errors;
								}else{
									$new_name = $FileCopyType[1].".".$array_base_file[1];
								}
								break;
							case "copy":
								$nbcopy = 0;
								$name_copy = $target_path.$nom_fichier_source;
								while (file_exists($name_copy)) {
									$nbcopy++;
									$name_copy = $target_path.$FileCopyType[1].$nbcopy .'_'.$nom_fichier_source;
								}
								if( $nbcopy != 0 ){
									$new_name = $FileCopyType[1].$nbcopy .'_'.$nom_fichier_source;
								}else{
									$new_name = $nom_fichier_source;
								}
								break;
							case "copytime":
								$nbcopy = 0;
								$name_copy = $target_path.$nom_fichier_source;
								while (file_exists($name_copy)) {
									$nbcopy++;
									$name_copy = $target_path.$FileCopyType[1].time()."_".$nbcopy .'_'.$nom_fichier_source;
								}
								if( $nbcopy != 0 ){
									$new_name = $FileCopyType[1].time()."_".$nbcopy .'_'.$nom_fichier_source;
								}else{
									$new_name = $nom_fichier_source;
								}
								break;
							case "error":
								while (file_exists($target_path.$nom_fichier_source)) {
								//error exist
								$errorFile = $this->FORM_MSG_ExistFile_errors;
								}
								break;
							case "time":
								$new_name = time().$FileCopyType[1].".".$array_base_file[1];
						 		break;
							case "time_name":
								$new_name = time().$FileCopyType[1].$nom_fichier_source;
								break;
						}
					}
                    //Traiter la taille du fichier
                    if( $fichier_source['size'] > $target_size ){
                        $errorFile = $this->FORM_MSG_sizeFile_errors;
                    }
        			
                    $array_base_ext = $this->extractExtensionFile($Fieldname);
			        $extension 	= $array_base_ext[1];
					if( $errorFile == "" )
					{
						if( !move_uploaded_file($fichier_source['tmp_name'],$target_path.$new_name) )
						{
							//si l'image n'est bien copié
							$errorFile = $this->FORM_MSG_copyFile_errors." ".$FormFieldImage;
						}
					}
				}

				if( $errorFile != "" ){
					$this->form->errors_copyFiles[] = $errorFile;
					$this->FORM_list_errors_submit[]= $errorFile;
				}
				
			}//if file
		}//foreach
		
		return ;
	}
	
	/**
	 * returnFileName($fieldName)
	 * @Fonction permettant de retourner le nouveau nom du fichier
	**/
	function returnFileName($fieldName)
	{
		$field 				= $this->Fields[$fieldName];
		if( $field["type"] != "file" ){
			$new_name	= "";
		}else{		
			$Fieldname			= $fieldName;
			$FileCopyType 		= $field["options"][1];
			$target_path 		= $field["options"][2];
			$fichier_source 	= $_FILES[$fieldName];
			if( $_FILES[$fieldName] != "" ){
			$nom_fichier_source = $fichier_source['name'];
			if( !is_array($FileCopyType) || empty($FileCopyType) ){
				$new_name = $nom_fichier_source;
			}else{
				$array_base_file = $this->extractExtensionFile($nom_fichier_source);
				switch($FileCopyType[0]){
					case "":
						$new_name = $nom_fichier_source;
						break;
					case "rename":
						if( $FileCopyType[1] == "" ){
							$errorFile = $this->FORM_MSG_RenameFile_errors;
						}else{
							$new_name = $FileCopyType[1].".".$array_base_file[1];
						}
						break;
					case "copy":
						$nbcopy = 0;
						$name_copy = $target_path.$nom_fichier_source;
						while (file_exists($name_copy)) {
							$nbcopy++;
							$name_copy = $target_path.$FileCopyType[1].$nbcopy .'_'.$nom_fichier_source;
						}
						if( $nbcopy != 0 ){
							$new_name = $FileCopyType[1].$nbcopy .'_'.$nom_fichier_source;
						}else{
							$new_name = $nom_fichier_source;
						}
						break;
					case "copytime":
						$nbcopy = 0;
						$name_copy = $target_path.$nom_fichier_source;
						while (file_exists($name_copy)) {
							$nbcopy++;
							$name_copy = $target_path.$FileCopyType[1].time()."_".$nbcopy .'_'.$nom_fichier_source;
						}
						if( $nbcopy != 0 ){
							$new_name = $FileCopyType[1].time()."_".$nbcopy .'_'.$nom_fichier_source;
						}else{
							$new_name = $nom_fichier_source;
						}
						break;
					case "error":
						while (file_exists($target_path.$nom_fichier_source)) {
						//error exist
							$errorFile = $this->FORM_MSG_ExistFile_errors;
						}
						break;
					case "time":
						$new_name = time().$FileCopyType[1].".".$array_base_file[1];
						break;
					case "time_name":
						$new_name = time().$FileCopyType[1].$nom_fichier_source;
						break;
				}
			}
			}else{
				$new_name = "";
			}
		}
		return strtolower($new_name);
	}

	/**
	 * extractExtensionFile($file)
	 * @Fonction permettant de séparer l'extension de la base du fichier
	**/
	function extractExtensionFile($file)
	{
		$list = explode(".",$file);
		$base = array();
		$file_base 	= "";
		$file_ext 	= "";
		$last = count($list)-1;
		for($i=0;$i<$last;$i++){
			$base[$i] = $list[$i];
		}
		$file_base 	= implode(".",$base);
		$file_ext	=strtolower($list[$last]);
		return array($file_base,$file_ext);
	}
	
	/**
	 * showErrorFilesQCM()
	 * @Fonction permettant l'affichage la liste des erreurs du copiage des fichiers des question ou des propostions si le type est (img)
	**/
	function showErrorFiles()
	{
		if( $this->nb_file_to_copy != 0 ){
			if(count($this->QCM_list_errors_copyFiles) != 0){
				echo $this->QCM_MSG_number_errors_copyFiles." ".count($this->QCM_list_errors_copyFiles)."<br>";
					
				echo "<ol>";
				foreach ( $this->FORM_list_errors_copyFiles as $key => $error ){
					echo "<li>".$error."</li>";
				}
				echo "</ol>";
			}else{
				echo $this->FORM_MSG_sucess_copyFiles."<br>";
			}
		}
		return ;
	}

	/**
	 * initialisation_update($sqlTable,$IdSqlTable,$IdRequest,$msg_insert,$msg_update)
	 * @param string $sqlTable			: Name of DB table
	 * @param string $IdSqlTable		: Id field in DB
	 * @param string $id				: Id of Update On GET
	 * @param string $msg_insert		: Message à afficher dans le titre de la form en cas d'insertion
	 * @param string $msg_update		: Message à afficher dans le titre de la form en cas de mise à jour
	 * @Fonction permettant d'initialiser les valeurs de mise à jour et de verifier si lef formulaire est en mise à jour
	**/
	function initialisation_update($sqlTable,$IdSqlTable,$IdRequest,$msg_insert,$msg_update)
	{
		$this->sqlTable		= $sqlTable;
		$this->IdSqlTable	= $IdSqlTable;
		$this->IdRequest	= $IdRequest;
		if( !empty($this->IdSqlTable) and !empty($this->IdRequest) ){
		$this->sql		= "SELECT * FROM ".$this->escapeDB($this->sqlTable)." WHERE ".$this->IdSqlTable." = '".$this->escapeDB($_GET[$this->IdRequest])."'";
		}

                $id = $this->valueGetOrPost($this->IdRequest);

		if( !empty($this->IdRequest) and ( !empty($id) ) ){
			$this->is_to_update	= true;
			$this->form_title 	= $msg_update;
		}else{
			$this->is_to_update = false;
			$this->form_title 	= $msg_insert;
		}
	}

	/**
	 * valueInsertOrUpdate($fieldName,$default,$sql,$fieldDB,$id)
	 * @param string $fieldName			: Name of field
	 * @param string $default			: default value ofr field
	 * @param string $sql				: SQL to use for extracting the value on Update
	 * @param string | array $fieldDB	: String	=>	Name of field in DataBase
	 * 									  Array		=>	(Used for Multiple Select)
	 * 									  				array	(
	 * 																0=> Name of database field
	 * 																1=> Value to Compare
	 * 																3=> Returned value if True
	 * 															)
	 * @param string $id				: Id of Update On GET
	 * @Fonction permettant de retourner la valeur du champs soit pour insertion ou mise à jour
	**/
	function valueInsertOrUpdate($fieldName,$default,$sql,$fieldDB,$id)
	{
		$this->is_to_update 		= false;
		$this->is_error_OnUpdate	= false;

		$row = $this->DB_fetch($sql);
		$num = $this->DB_num_rows($sql);
		if( $this->isSubmit() ){
			$value = $this->request[$fieldName];
			if( $this->request[$id] != "" ){
				$this->is_to_update = true;
			}
                }else{
			if( isset($_GET[$id]) && ( !empty($_GET[$id]) ) ){
				$this->is_to_update = true;
				if( $num!=0 ){
					if( !is_array($fieldDB) ){
						//S'il n'est pas un tableau => champs simple
						$value = $this->stripDB($row[$fieldDB]);
					}else{
						if( is_array($fieldDB) ){
							//S'il est un tableau => champs multiple
							$value = array();
							foreach($fieldDB as $arrkey => $arr){
								if(count($arr) == 3 ){
									if( $this->stripDB($row[$arr[0]]) == $arr[1][0]){
										$value[] = $arr[2];
									}
								}
							}
						}else{
							$value = "";
						}
					}

				}else{
					$this->is_error_OnUpdate = true;
					$value = "";
				}
			}else{
				$value = $default;
			}
		}
                
		return $value;
	}

	/**
	 * valueSessionOrRequest($sessionName,$requestName)
	 * @param string $sessionName			: Name of session of the field
	 * @param string $requestName			: Name of the request of the field
	 * @Fonction permettant de retourner la valeur du champs soit à partir de : la session ou du post
	**/
	function valueSessionOrRequest($sessionName,$requestName)
	{
        $return = "";
        if( $this->isSubmit() ){
            if( isset($this->request[$requestName]) && ( !empty($this->request[$requestName]) ) ){
               $return = $this->request[$requestName];
            }
        }else{
            if( isset($_SESSION[$sessionName]) && ( !empty($_SESSION[$sessionName]) ) ){
                 $return = $_SESSION[$sessionName];
            }else{
                 $return = "";
            }
        }

		return $return;
	}

	/**
	 * valueSessionOrRequest($sessionName,$requestName)
	 * @param string $sessionName			: Name of session of the field
	 * @param string $requestName			: Name of the request of the field
	 * @Fonction permettant de retourner la valeur du champs soit à partir de : la session ou du post
	**/
	function valueGetOrPost($requestName)
	{
        $return = "";
        if( $this->isSubmit() ){
            if( isset($_POST[$requestName]) && ( !empty($_POST[$requestName]) ) ){
               $return = $_POST[$requestName];
            }
        }else{
            if( isset($_GET[$requestName]) && ( !empty($_GET[$requestName]) ) ){
                 $return = $_GET[$requestName];
            }else{
                 $return = "";
            }
        }

		return $return;
	}

	/**
	 * printJsRedirection($page,$time)
	 * @privé : générant le JavaScript pour la redirection aprés un certain temps
	 * @param string $page : le nom de la page de redirection
	 * @param string $time : le temps de redirection -> Si $temps = "" => redirection direct / Sinon redirection aprés le temps spécifié
	**/
	function printJsRedirection($page,$time)
	{

		if ( $time != "" ) {

			echo "\n"
				.'<SCRIPT LANGUAGE="JavaScript">'."\n"
				.'window.setTimeout("location=('."'".$page."'".');",'.$time.');'."\n"
				.'</script>'."\n";

		}else{

			echo "\n"
				.'<script language="JavaScript">'."\n"
				.'location.href = "'.$page.'";'."\n"
   				.'</script>'."\n";

		}

		return ;
	}

}//End Of Form Class
?>