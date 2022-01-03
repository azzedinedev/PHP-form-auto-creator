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

//Initialisation
$form->initialisation_update("content","Id","id",$webvars['Add article'],$webvars['Update article']);
$form->form_title_adds = 'class="titleform"';

$form->openForm("addcontentform", $form->form_action, $form->form_method);

//Information
$form->openFieldset($webvars['Information on article']);

$form->add("Title",true,"title",array("title",$webvars['Title of article'],"text","","","notempty",$webvars['RMQ-Title of article'],"",""));
$form->add("Description",true,"description",array("description",$webvars['Description of article'],"textarea","","","notempty",$webvars['RMQ-Description article'],"",""));

$form->closeFieldset();

$form->add_group_to_show("content_status",$this->acces("content_status"));

$form->openFieldset($webvars['Article administration']);
$array_status = array("inactive" => $webvars['Inactive'], "active" => $webvars['Active'], "archieve" => $webvars['Archive']);
$form->add("Status",true,"status",array("status",$webvars['Status of article'],"select",$value["status"],$array_status,"",$webvars['RMQ-Status of article'],"",""));
$form->closeFieldset();

$form->remove_group_to_show("content_status");

$form->openFieldset($webvars['Scurity']);
$form->add("",true,"scuritycode",array("scuritycode",$webvars['Scurity code'],"captcha","",array("height"=>"30","characters"=>"6"),"",$webvars['RMQ-Copy the scurity code from the image'],"",""));
$form->closeFieldset();

$form->add("Id",true,"id",array("id","","hidden","","","","","",""));

$form->showSubmit($form->fieldSubmit,$webvars['Validate my choices']);
$form->showReset($form->fieldReset,$webvars['Reset my choices']);
$form->closeForm();

if( $form->is_to_update ){
	$form->add_action("Update_Time",array("",array(time())));
	$form->add_action("Update_User_Id",array("",array($this->user->id)));
	$form->add_action("Update_Host_Ip",array("",array($_SERVER['REMOTE_ADDR'])));
	$form->add_action("Update_Host_Details",array("",array(print_r($_SERVER, true))));
}else{
	$form->add_action("Add_Time",array(array(time()),""));
	$form->add_action("Add_User_Id",array(array($this->user->id),""));
	$form->add_action("Add_Host_Ip",array(array($_SERVER['REMOTE_ADDR']),""));
	$form->add_action("Add_Host_Details",array(array(print_r($_SERVER, true)),""));
	$form->add_action("Update_Time",array("",array(time())));
	$form->add_action("Update_User_Id",array("",array($this->user->id)));
	$form->add_action("Update_Host_Ip",array("",array($_SERVER['REMOTE_ADDR'])));
	$form->add_action("Update_Host_Details",array("",array(print_r($_SERVER, true))));
}


if( $form->is_to_update ){
	if( !$form->is_error_OnUpdate ){
		$data_update_params = array($form->data_update, array(array("AND" , $form->IdSqlTable , $form->IdRequest, "=")) );
		$form->onSucces(array("sql",array("update",$form->sqlTable,$data_update_params)));
		if( $form->isSucces() ) { $form->printJsRedirection("index.php?p=list_articles","3000"); }
	}
}else{
	$form->onSucces(array("sql",array("insert",$form->sqlTable,$form->data_insert)));
	if( $form->isSucces() ) { $form->printJsRedirection("index.php?p=list_articles","3000"); }
}

?>