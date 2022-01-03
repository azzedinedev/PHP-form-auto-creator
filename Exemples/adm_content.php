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
$this->form->initialisation_update("content","Id","id",$webvars['Add article'],$webvars['Update article']);
$this->form->form_title_adds = 'class="titleform"';

$this->form->openForm("addcontentform", $this->form->form_action, $this->form->form_method);

//Information
$this->form->openFieldset($webvars['Information on article']);

$this->form->add("Title",true,"title",array("title",$webvars['Title of article'],"text","","","notempty",$webvars['RMQ-Title of article'],"",""));
$this->form->add("Description",true,"description",array("description",$webvars['Description of article'],"textarea","","","notempty",$webvars['RMQ-Description article'],"",""));

$this->form->closeFieldset();

$this->form->add_group_to_show("content_status",$this->acces("content_status"));

$this->form->openFieldset($webvars['Article administration']);
$array_status = array("inactive" => $webvars['Inactive'], "active" => $webvars['Active'], "archieve" => $webvars['Archive']);
$this->form->add("Status",true,"status",array("status",$webvars['Status of article'],"select",$value["status"],$array_status,"",$webvars['RMQ-Status of article'],"",""));
$this->form->closeFieldset();

$this->form->remove_group_to_show("content_status");

$this->form->openFieldset($webvars['Scurity']);
$this->form->add("",true,"scuritycode",array("scuritycode",$webvars['Scurity code'],"captcha","",array("height"=>"30","characters"=>"6"),"",$webvars['RMQ-Copy the scurity code from the image'],"",""));
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
	$this->form->add_action("Update_Time",array("",array(time())));
	$this->form->add_action("Update_User_Id",array("",array($this->user->id)));
	$this->form->add_action("Update_Host_Ip",array("",array($_SERVER['REMOTE_ADDR'])));
	$this->form->add_action("Update_Host_Details",array("",array(print_r($_SERVER, true))));
}


if( $this->form->is_to_update ){
	if( !$this->form->is_error_OnUpdate ){
		$data_update_params = array($this->form->data_update, array(array("AND" , $this->form->IdSqlTable , $this->form->IdRequest, "=")) );
		$this->form->onSucces(array("sql",array("update",$this->form->sqlTable,$data_update_params)));
		if( $this->form->isSucces() ) { $this->form->printJsRedirection("index.php?p=list_articles","3000"); }
	}
}else{
	$this->form->onSucces(array("sql",array("insert",$this->form->sqlTable,$this->form->data_insert)));
	if( $this->form->isSucces() ) { $this->form->printJsRedirection("index.php?p=list_articles","3000"); }
}

?>