<?php
/**
 * Add the offer
 * @name add_offer.php
 * @author SARIRETE Azzeddine
 * @copyright sarweb@gmail.com - 06 april 2010
 * @access Public
 * @license free
 * @version 1.0
 */
//Initilaisation
if( !defined('INDEX_INITIALISED') ){
	header("location: ../index.php?p=error_acces");
}

/**
  * Configuration of the Form
 */

//Initialisation
$this->form->initialisation_update("contact","Id","id",$webvars["Contact"],$webvars["Contact"]);
$this->form->form_title_adds = 'class="titleform"';

$this->form->is_not_editable = false;
$this->form->openForm("contactform", $this->form->form_action, $this->form->form_method);
//addHTMLForms($field_name,$field_label,$field_type,$field_value,$field_options,$type_validation,$remarque, $field_add, $balise_add)

//Information
$this->form->openFieldset($webvars['Content of message']);

$this->form->add("Firstname",true,"firstname",array("firstname",$webvars['First name'],"text","","","notempty",$webvars['RMQ-First name'],"",""));

$this->form->add("Lastname",true,"lastname",array("lastname",$webvars['Last name'],"text","","","notempty",$webvars['RMQ-Last name'],"",""));

$this->form->add("Mail",true,"mail",array("mail",$webvars['E-Mail'],"text","","","email",$webvars['RMQ-E-Mail'],"",""));

$phone_validation = array("comparfields" => array(
													array(
													"telephone" => "empty" 
													),array(
													"telephone" => "number" 
													)
												)	 
						);
                        
$this->form->add("Telephone",true,"telephone",array("telephone",$webvars['Telephone'],"text","","",$phone_validation,$webvars['RMQ-Telephone'],"",""));

$sql_type_contact = $this->form->DB_fetch_list("SELECT * FROM contact_type WHERE Status = 'active'");
foreach ( $sql_type_contact as $row){
	$array_type_contact[$row["Id"]] = $row["Title"];
}
$array_type_contact["0"] = $webvars['Website contact'];

$this->form->add("Type_Contact",true,"type_contact",array("type_contact",$webvars['Contact type'],"select","",$array_type_contact,"notempty",$webvars['RMQ-Contact type'],"",""));

$sql_countries = $this->form->DB_fetch_list("SELECT * FROM countries WHERE Status = 'active'");
foreach ( $sql_countries as $row){
	$array_countries[$row["iso3"]] = $row["french"];
}

$this->form->add("Country",true,"country",array("country",$webvars['Country'],"select","DZA",$array_countries,"notempty",$webvars['RMQ-Country'],"",""));

$this->form->add("Message",true,"message",array("message",$webvars['Message'],"textarea","","","notempty",$webvars['RMQ-Message'],"",""));

$this->form->addHTMLForms("scuritycode",$webvars['Scurity code'],"captcha","",array("height"=>"30","characters"=>"6"),"",$webvars['RMQ-Copy the scurity code from the image'],"","");

$this->form->closeFieldset();

$this->form->add("Id",true,"id",array("id","","hidden","","","","","",""));

$this->form->showSubmit($this->form->fieldSubmit,$webvars['Validate my choices']);
$this->form->showReset($this->form->fieldReset,$webvars['Reset my choices']);
$this->form->closeForm();

if( $this->form->is_to_update ){
	$this->form->add_action("Update_Time",array("",array(time())));
	$this->form->add_action("Update_User_Id",array("",array($this->user->id)));
	$this->form->add_action("Update_Host_Ip",array("",array($_SERVER['REMOTE_ADDR'])));
	$this->form->add_action("Update_Host_Details",array("",array(print_r($_SERVER, true))));
}else{
	$this->form->add_action("Add_Time",array(array(time()),""));
	$this->form->add_action("Add_User_Id",array(array($this->user->id),""));
	$this->form->add_action("Add_Host_Ip",array(array($_SERVER['REMOTE_ADDR']),""));
	$this->form->add_action("Add_Host_Details",array(array(print_r($_SERVER, true)),""));
}


if( !$this->form->is_to_update ){
/*
	if( !$this->form->is_error_OnUpdate ){
		$data_update_params = array($this->form->data_update, array(array("AND" , $this->form->IdSqlTable , $this->form->IdRequest, "=")) );
		$this->form->onSucces(array("sql",array("update",$this->form->sqlTable,$data_update_params)));
		//if( $this->form->isSucces() ) { $this->form->printJsRedirection($_SERVER['PHP_SELF'],"1500"); }
	}
}else{
	*/
	$this->form->onSucces(array("sql",array("insert",$this->form->sqlTable,$this->form->data_insert)));
	if( $this->form->isSucces() ) { $this->form->printJsRedirection($_SERVER['PHP_SELF']."","1500"); }
}
  
?>