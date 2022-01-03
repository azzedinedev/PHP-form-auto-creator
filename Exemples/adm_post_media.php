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


$_SESSION['module-order-parent-post'] = "post";

/**
  * Configuration of the Form
 */

//Initialisation
$form->initialisation_update("post_medias","Id","id",$webvars['Post - Add media of article'],$webvars['Post - Update media of article']);
$form->form_title_adds = 'class="titleform"';

$form->openForm("addpostform", $form->form_action, $form->form_method);

//Information
$form->openFieldset($webvars['Post - media of article deatails']);

$form->add("Title",true,"title",array("title",$webvars['Post - Title of media'],"text","","","notempty",$webvars['Post - RMQ-Title of media'],"","","<b>","255"));

?>
<script>
$(document).ready(function () {			
    $("#parenttitle").autocomplete("index.php?m=posts", {
                    width: 260,
                    selectFirst: true,                    
                    matchContains: true,
                    highlightItem: false
    });
    $("#parenttitle").change(function() {
        $("#parentid").val("");
    });
    $("#parenttitle").result(function(event, data, formatted) {
                    $("#parentid").val(data[1]);
                    $.post('index.php?m=order-parent-post', { parent: $('#parentid').val()},
                    function success(data){
                       $('#order').html(data);
                    });

    }); 
});
</script>
<?php
//récuperer la valeur de l'id du parent from DB ou request ou par default : 0
$parent = $form->valueInsertOrUpdate("parentid","0",$form->sql,"Post_id",$form->IdRequest);
if( $parent != 0 ){
    //Récupérer le titre du parent
    $fetch_parent_title = $this->db->DB_fetch("SELECT m1.* FROM post_details AS m1 LEFT JOIN posts AS m2 ON m1.Post_id = m2.Id WHERE (Id ='".$form->escapeDB($parent)."')");
    $parent_title = $this->db->stripDB($fetch_parent_title["Title"]." (Id:".$fetch_parent_title["Id"]).")";
}
//Champs Titre et Id
$parent_field =  '<input id="parenttitle" name="parenttitle" type="text" value="'.$parent_title.'" autocomplete="off" class="ac_input"  style="width:300px;">'
               .  ' <b>Id :</b> <input id="parentid" name="parentid" type="text" value="'.$parent.'" style="width:50px;border:solid 1px #DDD;background:#EEE;" readonly="">';
//Validation Id : numérique non vide
$parent_validation = array("comparfields" => array(
                                                        array(
                                                            "parentid" 	=> "notempty"
                                                        ),
                                                        array(
                                                            "parentid" 	=> "number"
                                                        )
                                                     )
						);

$form->add("",true,"parent",array("parent",$webvars['Post - Parent of article'],"free",$parent_field,"",$parent_validation,$webvars['Post - RMQ-Parent of article'],"",""));

$file_option	= array(array("png","gif","jpg","jpeg","bmp"),array("rename",$form->request["postid"]."_".time(),"100000"),$this->configvars["path_posts_medias"]);
$form->add("",true,"file",array("file",$webvars['Post - File of media'],"file","",$file_option,"notempty",$webvars['Post - RMQ-File of media'],"",$display_file_media));

$sql_languages = $form->DB_fetch_list("SELECT * FROM language WHERE Status = 'active' ORDER BY Code ASC");
foreach ( $sql_languages as $row){
	$array_languages[$row["Code"]] = $row["Name"];
}

$form->add("Language",true,"language",array("language",$webvars['Language'],"select","",$array_languages,"notempty",$webvars['RMQ-Language'],$add_language,""));

$nbr_order = $form->DB_num_rows("SELECT * FROM post_documents WHERE Post_id ='".$form->escapeDB($parent)."' ");

$num_order = 0;

while( $num_order <= $nbr_order ){
	$num_order = $num_order+1;
	if( ( $form->is_to_update == false ) or ( ( $form->is_to_update == true ) and ( $num_order <= $nbr_order) ) ){
		$array_order[$num_order] = $num_order;
	}	 
}

$form->add("Order_media",true,"order",array("order",$webvars['Post - Media order'],"select","",$array_order,"notempty",$webvars['Post - RMQ-Media order'],"",""));

$form->closeFieldset();


$form->add_group_to_show("post_media_administration",$this->acces("post_media_administration"));

$form->openFieldset($webvars['Post - media of article administration']);

$array_status = array("inactive" => $webvars['Inactive'], "active" => $webvars['Active'], "archieve" => $webvars['Archive']);
$form->add("Status",true,"status",array("status",$webvars['Post - Media of article status'],"select","inactive",$array_status,"",$webvars['Post - RMQ-Media of article status'],"",""));

$form->closeFieldset();

$form->remove_group_to_show("post_media_administration");

$form->add_group_to_show("post_media_captcha",$this->acces("post_media_captcha"));
$form->openFieldset($webvars['Scurity']);
$form->add("",true,"scuritycode",array("scuritycode",$webvars['Scurity code'],"captcha","",array("height"=>"30","characters"=>"6"),"",$webvars['RMQ-Copy the scurity code from the media'],"",""));
$form->closeFieldset();
$form->remove_group_to_show("post_media_captcha");

$form->add("Id",true,"id",array("id","","hidden","","","","","",""));

$form->showSubmit($form->fieldSubmit,$webvars['Validate my choices']);
$form->showReset($form->fieldReset,$webvars['Reset my choices']);
$form->closeForm();


$file       = $this->configvars["path_posts_medias"].$form->request["file"];
$size       = filesize($file);
$extension  = $form->extractExtensionFile($file);

$form->add_action("Path",array(array($form->returnFileName("file")),array($form->returnFileName("file"))));
$form->add_action("Extension",array(array($extension),array($extension)));
$form->add_action("Post_id",array(array($form->request["parentid"]),array($form->request["parentid"])));
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
	$form->add_action("Update_Time",array(array(time()),array(time())));
	$form->add_action("Update_User_Id",array(array($this->user->id),array($this->user->id)));
	$form->add_action("Update_Host_Ip",array(array($_SERVER['REMOTE_ADDR']),array($_SERVER['REMOTE_ADDR'])));
	$form->add_action("Update_Host_Details",array(array(print_r($_SERVER, true)),array(print_r($_SERVER, true))));
}


if( $form->is_to_update ){
	if( !$form->is_error_OnUpdate ){
		$data_update_params = array($form->data_update, array(array("AND" , $form->IdSqlTable , $form->IdRequest, "=")) );
		$form->onSucces(array("sql",array("update",$form->sqlTable,$data_update_params)));
	//	if( $form->isSucces() ) { $form->printJsRedirection("index.php?p=list_posts_medias","3000"); }
	}
}else{
	$form->onSucces(array("sql",array("insert",$form->sqlTable,$form->data_insert)));
	//if( $form->isSucces() ) { $form->printJsRedirection("index.php?p=list_posts_medias","3000"); }
}

include_once 'modules/slidebar-post.php';

?>
