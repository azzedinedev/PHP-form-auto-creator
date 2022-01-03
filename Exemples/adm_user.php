<?php
/**
 * Add the offer
 * @name add_offer.php
 * @author SARIRETE Azzeddine
 * @copyright azzedinedev@gmail.com - 06 april 2010
 * @access Public
 * @license free
 * @version 1.0
 */

include("../class.form.php");

$form = new form();


/**
  * Configuration of the Form
 */
if( isset($_GET["my"]) ){
	$_GET["id"] = $this->user->id;
}

//Initialisation
$form->initialisation_update("user","Id","id",$webvars['Add a user'],$webvars['Update a user']);
$form->form_title_adds = 'class="titleform"';

//La table des champs ou inserer les valeurs des champs

$form->path_calendar_page_image = $configvars['WEB_path_to_root']."functions/form/calandar/images/calendar.png";

$form->openForm("adduserform", $form->form_action, $form->form_method);

//--------------------------------------------

$form->add_group_to_show("level_acess_code",$this->acces("user_acess_code"));
//Information
$form->openFieldset($webvars['Acess code']);

$form->add("Username",true,"username",array("username",$webvars['Username'],"text",$value["username"],"","notempty",$webvars['RMQ-Username'],"",""));

$password_validation = array("comparfields" => array(
													array(
													"password" 			=> "notempty",
													"password_confirm" 	=> array("=" => $form->request["password"])
													)
												)
						);
if( $form->is_to_update ){
	$password_validation["comparfields"][] = array(
													"password" 			=> "empty",
													"password_confirm"	=> "empty"
													);
}	

$form->add("",true,"password",array("password",$webvars['Password'],"password",$value["password"],"",$password_validation,$webvars['RMQ-Password'],"",""));

$form->add("",true,"password_confirm",array("password_confirm",$webvars['Password confirm'],"password",$form->request["password_confim"],"",$password_validation,$webvars['RMQ-Password confirm'],"",""));
$form->closeFieldset();

$form->remove_group_to_show("user_acess_code");

//--------------------------------------------

$form->add_group_to_show("user_personel_information",$this->acces("user_personel_information"));

$form->openFieldset($webvars['Personel information']);
$form->add("Displayname",true,"displayname",array("displayname",$webvars['Display name'],"text",$value["displayname"],"","notempty",$webvars['RMQ-Display name'],"",""));

$form->add("Firstname",true,"firstname",array("firstname",$webvars['First name'],"text",$value["firstname"],"","notempty",$webvars['RMQ-First name'],"",""));

$form->add("Lastname",true,"lastname",array("lastname",$webvars['Last name'],"text",$value["lastname"],"","notempty",$webvars['RMQ-Last name'],"",""));

$arr_civility = array("man" => $webvars['Man'],"woman" => $webvars['Woman']);
$form->add("Civility",true,"civility",array("civility",$webvars['Civility'],"select",$value["civility"],$arr_civility,"notempty",$webvars['RMQ-Civility'],"",""));

$form->add("Birthday",true,"birthday",array("birthday",$webvars['Birthday'],"date",$value["birthday"],"","date",$webvars['RMQ-Birthday'],"",""));


$form->add("Description",true,"description",array("description",$webvars['User description'],"textarea",$value["description"],"","",$webvars['RMQ-User description'],"",""));

$form->closeFieldset();

$form->remove_group_to_show("user_personel_information");

//--------------------------------------------

$form->add_group_to_show("user_personel_coordinates",$this->acces("user_personel_coordinates"));

$form->openFieldset($webvars['Personel coordinates']);
$form->add("Mail",true,"mail",array("mail",$webvars['E-Mail'],"text",$value["mail"],"","email",$webvars['RMQ-E-Mail'],"",""));

$form->add("Address",true,"address",array("address",$webvars['Address'],"textarea",$value["address"],"","notempty",$webvars['RMQ-Address'],"",""));

$sql_countries = $form->DB_fetch_list("SELECT * FROM countries WHERE Published = '1' AND Status = 'active'");
foreach ( $sql_countries as $row){
	$array_countries[$row["iso3"]] = $row["french"];
}

$add_country = array("onChange" =>
						 "
						  $.post('index.php?m=module-region', { country: $('#country').val() },
							   function success(data){
								 //alert('Data Loaded: ' + data);
								 $('#region').html(data);
							   });
						 "
						);
$form->add("Country",true,"country",array("country",$webvars['Country'],"select",$value["country"],$array_countries,"notempty",$webvars['RMQ-Country'],$add_country,""));

//region
if($value["country"] == "" ){
	$country = "DZA";
}else{
	$country = $form->request["country"];
}

$sql_regions = $form->DB_fetch_list("SELECT * FROM region WHERE Country ='".$form->escapeDB($country)."' AND Status 	= 'active'");
foreach ( $sql_regions as $row){
	$array_regions[$row["Id"]] = $row["French_Name"];
}

$form->add("Region",true,"region",array("region",$webvars['Region'],"select",$value["region"],$array_regions,"notempty",$webvars['RMQ-Region'],"",""));

$sql_timezone = $form->DB_fetch_list("SELECT * FROM timezone");
foreach ( $sql_timezone as $row){
	$array_timezone[$row["Diffrence_Time"]] = $row["French_Description"];
}

$value["timezone"] = "1";

$form->add("Timezone",true,"timezone",array("timezone",$webvars['Timezone'],"select",$value["timezone"],$array_timezone,"notempty",$webvars['RMQ-Timezone'],"",""));

$form->add("Telephone1",true,"telephone1",array("telephone1",$webvars['Telephone #1'],"text",$value["mail"],"","number",$webvars['RMQ-Telephone #1'],"",""));
$form->add("Telephone2",true,"telephone2",array("telephone2",$webvars['Telephone #2'],"text",$value["mail"],"","",$webvars['RMQ-Telephone #2'],"",""));
$form->add("Fax",true,"fax",array("fax",$webvars['Fax'],"text",$value["fax"],"","",$webvars['RMQ-Fax'],"",""));
$form->closeFieldset();

$form->remove_group_to_show("user_personel_coordinates");
//--------------------------------------------

$form->add_group_to_show("user_account_recovery",$this->acces("user_account_recovery"));

//Procédures de récupération du compte
$form->openFieldset($webvars['Recovery of the account']);

$form->add("Security_Question",true,"security_question",array("security_question",$webvars['Security Question'],"text",$value["security_question"],"","notempty",$webvars['RMQ-Security Question'],"",""));
$form->add("Answer",true,"answer",array("answer",$webvars['Answer'],"text",$value["answer"],"","notempty",$webvars['RMQ-Answer'],"",""));

$form->closeFieldset();

$form->remove_group_to_show("user_account_recovery");
//--------------------------------------------

$form->add_group_to_show("user_privacy_administration",$this->acces("user_privacy_administration"));

 //Privilèges de publication
$form->openFieldset($webvars['Publication privileges']);

if( $form->is_to_update ){

	$sql_template = $form->DB_fetch_list("SELECT * FROM templates WHERE Status = 'active' AND User = '".$user_id."'");
	foreach ( $sql_template as $row){
		$array_template[$row["Id"]] = $row["Name"];
	}

	if( count($array_template) != 0 ){
		$form->add("Template",true,"template",array("template",$webvars['Template'],"select",$value["privacy"],$array_template,"notempty",$webvars['RMQ-Template'],$add_privacy,""));
	}
}

$add_privacy = array("onChange" =>
						 "
						 if( $('#privacy').val() == 'private' ){
						 	$('#field_profile').hide();
						 	$('#field_privacy_choices').hide();
							$('#fieldset_privacy_1').hide();
						 	$('#fieldset_privacy_2').hide();
						 	$('#fieldset_privacy_3').hide();
						 }else{
						 	$('#field_profile').show();
						 	$('#field_privacy_choices').show();
						 	$('#fieldset_privacy_1').show();
							$('#fieldset_privacy_2').show();
							$('#fieldset_privacy_3').show();
						 }

						 "
						);

$array_privacy = array("public"=>$webvars['Public'],"private"=>$webvars['Private']);
$form->add("Privacy",true,"privacy",array("privacy",$webvars['Privacy'],"select","public",$array_privacy,"notempty",$webvars['RMQ-Privacy'],$add_privacy,""));

//--------------------------------------------

$form->add_group_to_show("user_profile_administration",$this->acces("user_profile_administration"));

$array_profile = array("yes" => $webvars['Yes'], "no" => $webvars['No']);
$form->add("Privacy_Profile",true,"profile",array("profile",$webvars['Profile show'],"select","yes",$array_profile,"",$webvars['RMQ-Profile show'],"",""));

$array_privacy_choices = array(
							"name"=>$webvars['Firstname and Lastname'],
							"civility"=>$webvars['Civility'],
							"birthday"=>$webvars['Birthday'],
							"description"=>$webvars['User description'],
							"photo"=>$webvars['Photo'],
							"mail"=>$webvars['E-Mail'],
							"address"=>$webvars['Address'],
							"country"=>$webvars['Country'],
							"region"=>$webvars['Region'],
							"timezone"=>$webvars['Timezone'],
							"telephone1"=>$webvars['Telephone #1'],
							"telephone2"=>$webvars['Telephone #2'],
							"fax"=>$webvars['Fax']
							);

$values_privacy_choices = array(
							array("Privacy_Name","1","name"),
							array("Privacy_Civility","1","civility"),
							array("Privacy_ Birthday","1","birthday"),
							array("Privacy_Description","1","description"),
							array("Privacy_Photo","1","photo"),
							array("Privacy_Mail","1","mail"),
							array("Privacy_Adress","1","address"),
							array("Privacy_Country","1","country"),
							array("Privacy_region","1","region"),
							array("Privacy_Timezone","1","timezone"),
							array("Privacy_Telephone1","1","telephone1"),
							array("Privacy_Telephone2","1","telephone2"),
							array("Privacy_Fax","1","fax")
							);
$form->add($values_privacy_choices,true,"privacy_choices",array("privacy_choices",$webvars['Masked information'],"multipleselect","",$array_privacy_choices,"",$webvars['RMQ-Masked information'],'size="13"',""));

$form->remove_group_to_show("user_profile_administration");

$form->closeFieldset();

//--------------------------------------------

$form->add_group_to_show("user_users_administration",$this->acces("user_users_administration"));

//parametres détaillées pour le privilège
$form->openFieldset(array("fieldset_privacy_1",$webvars['Privacy details of users']));



$validation_allowed_users = array("comparfields" =>
									array(
										array("allowed_users" => "empty"),
										array("allowed_users" => array("regx" => "/^([a-zA-Z]([0-9a-zA-Z_\-]*\.{0,1}[0-9a-zA-Z_\-]*))(\,[a-zA-Z]([0-9a-zA-Z_\-]*\.{0,1}[0-9a-zA-Z_\-]*))*$/"))
									)
								);

$add_allowed_users	= array("onKeyUp" => "
		var re = new RegExp(/^([a-zA-Z]([0-9a-zA-Z_\-]*\.{0,1}[0-9a-zA-Z_\-]*))(\,[a-zA-Z]([0-9a-zA-Z_\-]*\.{0,1}[0-9a-zA-Z_\-]*))*$/);

		if (re.test($('#allowed_users').val()) || $('#allowed_users').val() == '') {
		  	  $('#allowed_users').css({color:'green'});
		 } else {
		  	$('#allowed_users').css({color:'red'});
		 }

"	);

$form->add("Privacy_Allow_Users",true,"allowed_users",array("allowed_users",$webvars['Allowed users'],"textarea","",$array_allowed_users,$validation_allowed_users,$webvars['RMQ-Allowed users'],$add_allowed_users,""));

$validation_baned_users = array("comparfields" =>
									array(
										array("baned_users" => "empty"),
										array("baned_users" => array("regx" => "/^([a-zA-Z]([0-9a-zA-Z_\-]*\.{0,1}[0-9a-zA-Z_\-]*))(\,[a-zA-Z]([0-9a-zA-Z_\-]*\.{0,1}[0-9a-zA-Z_\-]*))*$/"))
									)
								);

$add_baned_users	= array("onKeyUp" => "
		var re = new RegExp(/^([a-zA-Z]([0-9a-zA-Z_\-]*\.{0,1}[0-9a-zA-Z_\-]*))(\,[a-zA-Z]([0-9a-zA-Z_\-]*\.{0,1}[0-9a-zA-Z_\-]*))*$/);

		if (re.test($('#baned_users').val()) || $('#baned_users').val() == '') {
		  	  $('#baned_users').css({color:'green'});
		 } else {
		  	$('#baned_users').css({color:'red'});
		 }

"	);

$form->add("Privacy_Ban_Users",true,"baned_users",array("baned_users",$webvars['baned users'],"textarea","",$array_baned_users,$validation_baned_users,$webvars['RMQ-baned users'],$add_baned_users,""));

$form->closeFieldset();

$form->remove_group_to_show("user_users_administration");


//--------------------------------------------

$form->add_group_to_show("user_ip_administration",$this->acces("user_ip_administration"));


$form->openFieldset(array("fieldset_privacy_2",$webvars['Privacy details of IPs']));

$validation_allowed_ips = array("comparfields" =>
									array(
										array("allowed_ips" => "empty"),
										array("allowed_ips" => array("regx" => "/^((25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[1-9])(\.(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[0-9])){0,3})(\,(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[1-9])(\.(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[0-9])){0,3})*$/"))
									)
								);

$add_allowed_ips	= array("onKeyUp" => "
		var re = new RegExp(/^((25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[1-9])(\.(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[0-9])){0,3})(\,(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[1-9])(\.(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[0-9])){0,3})*$/);

		if (re.test($('#allowed_ips').val()) || $('#allowed_ips').val() == '') {
		  	  $('#allowed_ips').css({color:'green'});
		 } else {
		  	$('#allowed_ips').css({color:'red'});
		 }

"	);

$form->add("Privacy_Allow_Ips",true,"allowed_ips",array("allowed_ips",$webvars['Allowed IPs address'],"textarea","",$array_allowed_ips,$validation_allowed_ips,$webvars['RMQ-Allowed IPs address'],$add_allowed_ips,""));

$validation_baned_ips = array("comparfields" =>
									array(
										array("baned_ips" => "empty"),
										array("baned_ips" => array("regx" => "/^((25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[1-9])(\.(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[0-9])){0,3})(\,(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[1-9])(\.(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[0-9])){0,3})*$/"))
									)
								);

$add_baned_ips	= array("onKeyUp" => "
		var re = new RegExp(/^((25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[1-9])(\.(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[0-9])){0,3})(\,(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[1-9])(\.(25[0-5]|2[0-4][0-9]|1[0-9][0-9]|[1-9][0-9]|[0-9])){0,3})*$/);

		if (re.test($('#baned_ips').val()) || $('#baned_ips').val() == '') {
		  	  $('#baned_ips').css({color:'green'});
		 } else {
		  	$('#baned_ips').css({color:'red'});
		 }

"	);

$form->add("Privacy_Ban_Ips",true,"baned_ips",array("baned_ips",$webvars['baned IPs address'],"textarea","",$array_baned_ips,$validation_baned_ips,$webvars['RMQ-baned IPs address'],$add_baned_ips,""));

$form->closeFieldset();

$form->remove_group_to_show("user_ip_administration");

//--------------------------------------------

$form->add_group_to_show("user_countries_administration",$this->acces("user_countries"));

$array_countries = array();
$array_countries = $form->DB_fetch_list("SELECT * FROM countries WHERE Status = 'active'");

$array_allowed_countries = array();
foreach( $array_countries as $row){
		$array_allowed_countries[$form->stripDB($row["iso3"])]	= $form->stripDB($row["french"]);
}

$add_ban_countries	= array("onClick" => " $('#allowed_countries option:selected').remove().appendTo('#baned_countries'); "	);
$add_allow_countries= array("onClick" => " $('#baned_countries option:selected').remove().appendTo('#allowed_countries'); "	);

$form->openFieldset(array("fieldset_privacy_3",$webvars['Privacy details of countries']));

$form->add("Privacy_Allow_Countries",true,"allowed_countries",array("allowed_countries",$webvars['Allowed countries'],"multipleselect","",$array_allowed_countries,"",$webvars['RMQ-Allowed countries'],'size="5"',""));

$form->add("",true,"ban_countries",array("ban_countries","","button",array($webvars["Ban selected >>"]),"","","",$add_ban_countries,""));

$form->add("Privacy_Ban_Countries",true,"baned_countries",array("baned_countries",$webvars['baned countries'],"multipleselect","","","",$webvars['RMQ-baned countries'],'size="5"',""));

$form->add("",true,"allow_countries",array("allow_countries","","button",array($webvars["<< Allow selected"]),"","","",$add_allow_countries,""));
$form->closeFieldset();

$form->remove_group_to_show("user_countries_administration");

//--------------------------------------------

$form->add_group_to_show("user_status",$this->acces("user_status"));

$form->openFieldset($webvars['User administration']);
$array_status = array("inactive" => $webvars['Inactive'], "active" => $webvars['Active'], "archieve" => $webvars['Archive']);

$form->add("Id",true,"id",array("status",$webvars['User status'],"select",$value["status"],$array_status,"",$webvars['RMQ-User status'],"",""));
$form->closeFieldset();

$form->remove_group_to_show("user_status");

$add_terms_service	= array("onfocus" => "this.rows='10'; this.cols='80'; this.style.height='400px' ", "readonly" => "readonly"	);

$form->remove_group_to_show("user_privacy_administration");

//--------------------------------------------

$form->openFieldset($webvars['Terms of Service']);

$form->add("",true,"terms_service",array("terms_service",$webvars['Terms of Service'],"textarea",stripslashes($webvars['terms_service']),"","",$webvars['RMQ-Terms of Service'],$add_terms_service,""));
$form->closeFieldset();

$form->openFieldset($webvars['Scurity']);

$form->add("",true,"scuritycode",array("scuritycode",$webvars['Scurity code'],"captcha","",array("height"=>"30","characters"=>"6"),"",$webvars['RMQ-Copy the scurity code from the image'],"",""));
$form->closeFieldset();

$form->add("Id",true,"id",array("id","","hidden","","","","","",""));

if( !$form->is_to_update ){
	$webvars_submit = $webvars['I accept. Create my account.'];
}else{
	$webvars_submit = $webvars['I accept. Modify my account.'];
}

$form->showSubmit($form->fieldSubmit,$webvars_submit);
$form->showReset($form->fieldReset,$webvars['Reset my choices']);
$form->closeForm();

//la table des champs ou inserer les valeurs des champs
//Initialisation
$p_c_sql = array();
if( !isset($form->request["privacy_choices"])){
	$form->request["privacy_choices"] = array();
}
if(in_array("name",$form->request["privacy_choices"])==true){$p_c_sql["name"] = "1";}else{$p_c_sql["name"] = "0";}
if(in_array("civility",$form->request["privacy_choices"])==true){$p_c_sql["civility"] = "1";}else{$p_c_sql["civility"] = "0";}
if(in_array("birthday",$form->request["privacy_choices"])==true){$p_c_sql["birthday"] = "1";}else{$p_c_sql["birthday"] = "0";}
if(in_array("description",$form->request["privacy_choices"])==true){$p_c_sql["description"] = "1";}else{$p_c_sql["description"] = "0";}
if(in_array("mail",$form->request["privacy_choices"])==true){$p_c_sql["mail"] = "1";}else{$p_c_sql["mail"] = "0";}
if(in_array("address",$form->request["privacy_choices"])==true){$p_c_sql["address"] = "1";}else{$p_c_sql["address"] = "0";}
if(in_array("country",$form->request["privacy_choices"])==true){$p_c_sql["country"] = "1";}else{$p_c_sql["country"] = "0";}
if(in_array("region",$form->request["privacy_choices"])==true){$p_c_sql["region"] = "1";}else{$p_c_sql["region"] = "0";}
if(in_array("timezone",$form->request["privacy_choices"])==true){$p_c_sql["timezone"] = "1";}else{$p_c_sql["timezone"] = "0";}
if(in_array("telephone1",$form->request["privacy_choices"])==true){$p_c_sql["telephone1"] = "1";}else{$p_c_sql["telephone1"] = "0";}
if(in_array("telephone2",$form->request["privacy_choices"])==true){$p_c_sql["telephone2"] = "1";}else{$p_c_sql["telephone2"] = "0";}
if(in_array("fax",$form->request["privacy_choices"])==true){$p_c_sql["fax"] = "1";}else{$p_c_sql["fax"] = "0";}

//Si Aucun payés n'est alloué
if( !isset($form->request["allowed_countries"])){
	$allowed_countries = array();
}
//Si Aucun payés n'est ou bani
if( !isset($form->request["baned_countries"])){
	$baned_countries = array();
}

$form->add_action("Privacy_Name",array(array($p_c_sql["name"]),array($p_c_sql["name"])));
$form->add_action("Privacy_Civility",array(array($p_c_sql["civility"]),array($p_c_sql["civility"])));
$form->add_action("Privacy_Birthday",array(array($p_c_sql["birthday"]),array($p_c_sql["birthday"])));
$form->add_action("Privacy_Description",array(array($p_c_sql["description"]),array($p_c_sql["description"])));
$form->add_action("Privacy_Mail",array(array($p_c_sql["mail"]),array($p_c_sql["mail"])));
$form->add_action("Privacy_Address",array(array($p_c_sql["address"]),array($p_c_sql["address"])));
$form->add_action("Privacy_Country",array(array($p_c_sql["country"]),array($p_c_sql["country"])));
$form->add_action("Privacy_Region",array(array($p_c_sql["region"]),array($p_c_sql["region"])));
$form->add_action("Privacy_Timezone",array(array($p_c_sql["timezone"]),array($p_c_sql["timezone"])));
$form->add_action("Privacy_Telephone1",array(array($p_c_sql["telephone1"]),array($p_c_sql["telephone1"])));
$form->add_action("Privacy_Telephone2",array(array($p_c_sql["telephone2"]),array($p_c_sql["telephone2"])));
$form->add_action("Privacy_Fax",array(array($p_c_sql["fax"]),array($p_c_sql["fax"])));

$form->add_action("Privacy_Allow_Countries",array(array(implode(",",$allowed_countries)),array(implode(",",$allowed_countries))));
$form->add_action("Privacy_Ban_Countries",array(array(implode(",",$baned_countries)),array(implode(",",$baned_countries))));

if( $form->is_to_update ){
	if( $form->request["password"] != "" ){
		$form->add_action("Password",array("",array($this->user->codify_password($form->request["password"]))));
	}	
	$form->add_action("Update_Time",array("",array(time())));
	$form->add_action("Update_User_Id",array("",array($this->user->id)));
	$form->add_action("Update_Host_Ip",array("",array($_SERVER['REMOTE_ADDR'])));
	$form->add_action("Update_Host_Details",array("",array(print_r($_SERVER, true))));
}else{
	$form->add_action("Password",array(array($this->user->codify_password($form->request["password"])),""));
	$form->add_action("Add_Time",array(array(time()),""));
	$form->add_action("Add_User_Id",array(array($this->user->id),""));
	$form->add_action("Add_Host_Ip",array(array($_SERVER['REMOTE_ADDR']),""));
	$form->add_action("Add_Host_Details",array(array(print_r($_SERVER, true)),""));
	$form->add_action("Update_Time",array("",array(time())));
	$form->add_action("Update_User_Id",array("",array($this->user->id)));
	$form->add_action("Update_Host_Ip",array("",array($_SERVER['REMOTE_ADDR'])));
	$form->add_action("Update_Host_Details",array("",array(print_r($_SERVER, true))));
}

//--------------------------------------------

$form->add_group_to_show("user_status",$this->acces("user_status"));
	$form->add_action("Activation_Time",array("",array(time())));
	$form->add_action("Activation_User_Id",array("",array($this->user->id)));
	$form->add_action("Activation_Host_Ip",array("",array($_SERVER['REMOTE_ADDR'])));
	$form->add_action("Activation_Host_Details",array("",array(print_r($_SERVER, true))));
$form->remove_group_to_show("user_status");


if( $form->is_to_update ){
	if( !$form->is_error_OnUpdate ){
		$data_update_params = array($form->data_update, array(array("AND" , $form->IdSqlTable , $form->IdRequest, "=")) );
		$form->onSucces(array("sql",array("update",$form->sqlTable,$data_update_params)));
		if( $form->isSucces() ) { $form->printJsRedirection($_SERVER['PHP_SELF'],"3000"); }
	}
}else{
	$form->onSucces(array("sql",array("insert",$form->sqlTable,$form->data_insert)));
	if( $form->isSucces() ) { $form->printJsRedirection($_SERVER['PHP_SELF'],"3000"); }
}
?>