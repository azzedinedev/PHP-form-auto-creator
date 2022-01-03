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

$form->initialisation_update("menu","Id","id",$webvars['Add a menu'],$webvars['Update a menu']);
$form->form_title_adds = 'class="titleform"';

$form->openForm("addtypeform", $form->form_action, $form->form_method);
//addHTMLForms($field_name,$field_label,$field_type,$field_value,$field_options,$type_validation,$remarque, $field_add, $balise_add)

//Information
$form->openFieldset($webvars['Menu information']);

$form->add("Title",true,"title",array("title",$webvars['Title of menu'],"text","","","notempty",$webvars['RMQ-Title of menu'],"",""));
$form->add("Description",true,"description",array("description",$webvars['Description of menu'],"textarea","","","notempty",$webvars['RMQ-Description of menu'],"",""));


$regex_link  = "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query 
$regex_link .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor 
	
$link_validation = array("comparfields" => array(
												array(
													"content" => "notempty",
													"type_link" => array("=" => "costume")
												),
												array(
													"link" => "empty",
													"type_link" => array("=" => "link")
												),
												array(
													"link" => "url",
													"type_link" => array("=" => "link") 
												),
												array(
													"link" => array("regx" => "/^".$regex_link."$/"),
													"type_link" => array("=" => "link")
												)
											)	 
						);
						
$array_type_link = array('costume' => $webvars['Costume'], 'link' => $webvars['Link']);

$add_type_link = array("onChange" =>
						 "
						 if( $('#type_link').val() == 'costume' ){
						 	$('#field_content').show();
						 	$('#field_link').hide();
						 }
                                                 if( $('#type_link').val() == 'link' ){
						 	$('#field_link').show();
                                                        $('#field_content').hide();
						 }
						 "
						);
			
$type_link_value = $form->valueInsertOrUpdate('type_link','link',$form->sql,'Type_Link',$form->IdRequest);

switch($type_link_value){
	case 'costume':	$display_link 	= 'style="display:none;"';
					$display_content= '';
					break;
	case 'link':	$display_link 	= '';
					$display_content= 'style="display:none;"';
					break;
	default: 		$display_link 	= 'style="display:none;"';
					$display_content= '';
					break;
}					

$form->add("Type_Link",true,"type_link",array("type_link",$webvars['Type of menu link'],"select",$type_link_value,$array_type_link,"",$webvars['RMQ-Type of menu link'],$add_type_link,""));

$form->add("Link",true,"link",array("link",$webvars['Menu link'],"text","","",$link_validation,$webvars['RMQ-Menu link'],'',$display_link));

$form->add("Content",true,"content",array("content",$webvars['Costum content of menu'],"textarea","","",$link_validation,$webvars['RMQ-Costum content of menu'],'class="editor"',$display_content));

$form->closeFieldset();

$form->add_group_to_show("menu_administration",$this->acces("menu_administration"));

$form->openFieldset($webvars['Menu administration']);

$parent = "0"; 
/*
$vals_parent = $this->menu->format_parent_array("0","1");
$keys_parent = array_keys($vals_parent);
$keys_parent = array_merge(array("0"=> "0"),$keys_parent);

$array_parent = array_merge(array("0"=>$webvars['Root of menu']), $vals_parent);

$array_parent = array_combine($keys_parent, $array_parent);
*/
$array_parent = $this->menu->merge_array(array("0"=>$webvars['Root of menu']),$this->menu->format_parent_array("0","1"));

if($_POST["id"] != "" ){
	$idp = $_POST["id"];
}else{
	if($_GET["id"] != "" ){
		$idp = $_GET["id"];
	}else{
		$idp = "";
	}
}
if($idp != "" ){
	$addajaxparent = ",id: '".$idp."'";
}

$add_parent = array("onChange" => 
						 "
						 $.post('index.php?m=order-parent-menu', { parent: $('#parent').val()},
							   function success(data){
								 $('#order').html(data);
							   });
						 "
						);
$form->add("Parent",true,"parent",array("parent",$webvars['Menu parent'],"select","",$array_parent,"",$webvars['RMQ-Menu parent'],$add_parent,""));


$parent = $form->valueInsertOrUpdate("parent","0",$form->sql,"Parent",$form->IdRequest);

//if( !isset($form->request["parent"]) or empty($form->request["parent"]) ){ $parent = "0"; }

$nbr_order = $form->DB_num_rows("SELECT * FROM menu WHERE Parent ='".$form->escapeDB($parent)."' ");

$num_order = 0;

while( $num_order <= $nbr_order ){
	$num_order = $num_order+1;
	if( ( $form->is_to_update == false ) or ( ( $form->is_to_update == true ) and ( $num_order <= $nbr_order) ) ){
		$array_order[$num_order] = $num_order;
	}	 
}

$form->add("Order_Menu",true,"order",array("order",$webvars['Menu order'],"select","",$array_order,"notempty",$webvars['RMQ-Menu order'],"",""));

$add_privacy = array("onChange" =>
						 "
						 if( $('#privacy').val() == 'public' ){
						 	$('#field_privacy_choices').hide();
						 }else{
						 	$('#field_privacy_choices').show();
						 }

						 "
						);


$array_privacy = array("no"=>$webvars['Public'],"yes"=>$webvars['Private']);
$form->add("Is_Registred",true,"privacy",array("privacy",$webvars['Menu privacy'],"select",$value["Privacy"],$array_privacy,"",$webvars['RMQ-Menu privacy'],$add_privacy,''));

$array_privacy_sql = array();
$array_privacy_sql = $form->DB_fetch_list("SELECT * FROM level WHERE Status = 'active'");

$array_privacy = array();
foreach( $array_privacy_sql as $row){
		$array_privacy[$form->stripDB($row["Id"])]	= $form->stripDB($row["Title"]);
}
$privacy = $form->valueInsertOrUpdate("privacy","",$form->sql,"Is_Registred",$form->IdRequest);
if( $privacy != 'yes' ){
	$add_privacy_choices = 'style="display:none;"';
}
if( count($array_privacy) != 0 ){
	$privacy_choices = $form->valueInsertOrUpdate("privacy_choices","",$form->sql,"Registration",$form->IdRequest);
    $form->add('',true,"privacy_choices",array("privacy_choices",$webvars['Level acces'],"multipleselect",$privacy_choices,$array_privacy,"",$webvars['RMQ-Level acces'],'size="13"',$add_privacy_choices));    
}else{
    $form->add("",true,"privacy_choices",array("privacy_choices",$webvars['Level acces'],"free",'<span class="messageAlerte">'.$webvars['No Level acces'].'</span>',"","","","",$add_privacy_choices));
}                            

$array_status = array("inactive" => $webvars['Inactive'], "active" => $webvars['Active'], "archieve" => $webvars['Archive']);
$form->add("Status",true,"status",array("status",$webvars['Status of menu'],"select",$value["status"],$array_status,"",$webvars['RMQ-Status of menu'],"",""));


$form->closeFieldset();

$form->remove_group_to_show("menu_administration");

$form->openFieldset($webvars['Scurity']);
//$form->add("",true,"scuritycode",array("scuritycode",$webvars['Scurity code'],"captcha","",array("height"=>"30","characters"=>"6"),"",$webvars['RMQ-Copy the scurity code from the image'],"",""));
$form->closeFieldset();

$form->add("Id",true,"id",array("id","","hidden","","","","","",""));

$form->showSubmit($form->fieldSubmit,$webvars['Validate my choices']);
$form->showReset($form->fieldReset,$webvars['Reset my choices']);
$form->closeForm();


$form->add_action("Registration",array(array(implode(",",$privacy_choices)),array(implode(",",$privacy_choices))));
/*
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
*/
if( $form->is_to_update ){
	if( !$form->is_error_OnUpdate ){
		$this->update_order_row($form->sqlTable,$form->IdSqlTable,"Order_Menu",$form->request["order"],$form->request[$form->IdRequest],true,"Parent = ".$form->request["parent"]);
		$data_update_params = array($form->data_update, array(array("AND" , $form->IdSqlTable , $form->IdRequest, "=")) );
		$form->onSucces(array("sql",array("update",$form->sqlTable,$data_update_params)));
		
		if( $form->isSucces() ) { /*$form->printJsRedirection($_SERVER['PHP_SELF']."?p=list_menus","1500");*/ }
	}
}else{
	$form->onSucces(array("sql",array("insert",$form->sqlTable,$form->data_insert)));
	
	$this->new_order_row($form->sqlTable,$form->IdSqlTable,"Order_Menu",$form->request["order"],$this->db_insert_value,"Parent = ".$form->request["parent"]);
	
	if( $form->isSucces() ) { /*$form->printJsRedirection($_SERVER['PHP_SELF']."?p=list_menus","1500");*/ }
}  
?>
