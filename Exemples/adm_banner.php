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
$form->initialisation_update("banner_content","Id","id",$webvars['Add banner'],$webvars['Update banner']);
$form->form_title_adds = 'class="titleform"';

$form->openForm("addbannerform", $form->form_action, $form->form_method);

//Information
$form->openFieldset($webvars['Information on banner']);

$form->add("Name",true,"name",array("name",$webvars['Name of banner'],"text","","","notempty",$webvars['RMQ-Name of banner'],"",""));
$form->add("Description",true,"description",array("description",$webvars['Description of banner'],"textarea","","","notempty",$webvars['RMQ-Description of banner'],"",""));

$sql_clients = $form->DB_fetch_list("SELECT * FROM banner_client WHERE Status = 'active' ORDER BY Name ASC");
foreach ( $sql_clients as $row){
	$array_clients[$row["Id"]] = $row["Name"];
}

$form->add("Client",true,"client",array("client",$webvars['Name of banner client'],"select","",$array_clients,"notempty",$webvars['RMQ-Name of banner client'],"",""));

$array_type = array('costume' => $webvars['Costume'], 'image' => $webvars['Image'], 'flash' => $webvars['Flash']);

$add_type = array("onChange" =>
						 "
						 if( $('#type').val() == 'costume' ){
						 	$('#field_content').show();
						 	$('#field_file_image').hide();
                            $('#field_file_flash').hide();
						 }
                         if( $('#type').val() == 'image' ){
						 	$('#field_file_image').show();
                            $('#field_file_flash').hide();
						 	$('#field_content').hide();
						 }
                         if( $('#type').val() == 'flash' ){
                            $('#field_file_flash').show();
						 	$('#field_file_image').hide();
							$('#field_content').hide();
						 }

						 "
						);
						
$display_file_image = 'style="display:none;"';
$display_file_flash = 'style="display:none;"';
$display_content 	= '';

$type_content_value = $form->valueInsertOrUpdate('type','costume',$form->sql,'Type',$form->IdRequest);

switch($type_content_value){

	case 'costume':	$display_file_image = 'style="display:none;"';
				$display_file_flash = 'style="display:none;"';
				$display_content 	= '';
				break;
	case 'image':	$display_file_image = '';
				$display_file_flash = 'style="display:none;"';
				$display_content 	= 'style="display:none;"';
				break;
	case 'flash':	$display_file_image = 'style="display:none;"';
				$display_file_flash = '';
				$display_content 	= 'style="display:none;"';
				break;
	default: 	$display_file_image = 'style="display:none;"';
				$display_file_flash = 'style="display:none;"';
				$display_content 	= '';
				break;
}					

$content_validation = array("comparfields" => array(
												array(
													"content" => "notempty",
													"type" => array("=" => "costume")
												),
												array(
													"file_image" => "empty",
													"type" => array("=" => "image")
												),
												array(
													"file_flash" => "url",
													"type" => array("=" => "flash") 
												),
												array(
													"hidden_content" => "notempty"
												)
											)	 
						);
											
$file_option_i	= array(array("png","gif","jpg","jpeg","bmp"),array("copytime","","100000"),$this->configvars["path_banner_images"]);
$file_option_f	= array(array("swf"),array("copytime","","200000"),$this->configvars["path_banner_flash"]);

$form->add("Type",true,"type",array("type",$webvars['Type of banner'],"select","",$array_type,"",$webvars['RMQ-Type of banner'],$add_type,""));

$form->add("",true,"file_image",array("file_image",$webvars['Image file of banner'],"file","",$file_option_i,$content_validation,$webvars['RMQ-Image file of banner'],"",$display_file_image));
$form->add("",true,"file_flash",array("file_flash",$webvars['Flash file of banner'],"file","",$file_option_f,$content_validation,$webvars['RMQ-Flash file of banner'],"",$display_file_flash));
$form->add("",true,"content",array("content",$webvars['Costume content of banner'],"textarea","","",$content_validation,$webvars['RMQ-Costume content of banner'],"",$display_content));

$content_value = $form->valueInsertOrUpdate('hidden_content','',$form->sql,'Content',$form->IdRequest);
$form->add("",true,"hidden_content",array("hidden_content","","hidden",$content_value,"","","","",""));

$form->add("Link",true,"link",array("link",$webvars['Link of banner'],"text","","","",$webvars['RMQ-Link of banner'],"",""));

$form->closeFieldset();

$form->add_group_to_show("banner_status",$this->acces("banner_status"));

$form->openFieldset($webvars['Administration of banner']);
$array_status = array("inactive" => $webvars['Inactive'], "active" => $webvars['Active'], "archieve" => $webvars['Archive']);
$form->add("Status",true,"status",array("status",$webvars['Status of banner'],"select",$value["status"],$array_status,"",$webvars['RMQ-Status of banner'],"",""));
$form->closeFieldset();

$form->remove_group_to_show("banner_status");

$form->openFieldset($webvars['Scurity']);
$form->add("",true,"scuritycode",array("scuritycode",$webvars['Scurity code'],"captcha","",array("height"=>"30","characters"=>"6"),"",$webvars['RMQ-Copy the scurity code from the image'],"",""));
$form->closeFieldset();

$form->add("Id",true,"id",array("id","","hidden","","","","","",""));

$form->showSubmit($form->fieldSubmit,$webvars['Validate my choices']);
$form->showReset($form->fieldReset,$webvars['Reset my choices']);
$form->closeForm();

switch($form->request["type"]){
	case "image": 
		$form->add_action("Content",array(array($form->returnFileName("file_image")),array($form->returnFileName("file_image"))));
		break;
	case "flash": 
		$form->add_action("Content",array(array($form->returnFileName("file_flash")),array($form->returnFileName("file_flash"))));
		break;
	case "costume":
		$form->add_action("Content",array(array($form->request["content"]),array($form->request["content"])));

		break;
}

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
		//if( $form->isSucces() ) { $form->printJsRedirection($_SERVER['PHP_SELF'],"3000"); }
	}
}else{
	$form->onSucces(array("sql",array("insert",$form->sqlTable,$form->data_insert)));
	//if( $form->isSucces() ) { $form->printJsRedirection($_SERVER['PHP_SELF'],"3000"); }
}

?>