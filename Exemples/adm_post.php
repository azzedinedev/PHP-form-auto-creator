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

$_SESSION['module-order-parent-post'] = "post";

/**
  * Configuration of the Form
 */

//Initialisation
$sqlTable_posts             = "posts";
$sqlTable_map               = "map";
$sqlTable_post_details      = "post_details";
$sqlTable_post_categories   = "post_categories";

$this->form->initialisation_update($this->form->escapeDB($sqlTable_posts),"Id","id",$webvars['Post - Add article'],$webvars['Post - Update article']);
//modifiy the SQL
if( $this->form->is_to_update ){
    $sql = "SELECT m1.*,
        m2.Title AS detail_Title,
        m2.Resume AS detail_Resume,
        m2.Content AS detail_Content,
        m2.Tags AS detail_Tags,
        m2.Author AS detail_Author,
        m2.Link_author AS detail_Link_author,
        m2.Place AS detail_Place,
        m2.Status AS detail_Status,
        m2.Rights AS detail_Rights,
        m2.Meta_description AS detail_Meta_description,
        m2.Meta_keywords AS detail_Meta_keywords 
        FROM ".$this->form->escapeDB($sqlTable_posts)." AS m1 LEFT JOIN ".$this->form->escapeDB($sqlTable_post_details)." AS m2 ON (m1.Id = m2.Post_id) AND (m1.Language = m2.language) WHERE m1.Id = '".$this->form->escapeDB($_GET[$this->form->IdRequest])."'";
    $post_detail = $this->form->DB_fetch($sql);
}else{
    $post_detail = array();
}
$this->form->form_title_adds = 'class="titleform"';
$this->form->type_fieldset   = "div";

$this->form->class_legend_as_div = "fieldsetdivhead headbloc";
        
$this->form->openForm("addpostform", $this->form->form_action, $this->form->form_method);

//Information
$this->form->openFieldset($webvars['Post - Article deatails']);

$this->form->add("",true,"title",array("title",$webvars['Post - Title of article'],"text",$this->form->stripDB($post_detail["detail_Title"]),"","notempty",$webvars['Post - RMQ-Title of article'],"","","<b>","255"));
$this->form->add("",true,"resume",array("resume",$webvars['Post - Resume of article'],"textarea",$this->form->stripDB($post_detail["detail_Resume"]),"","notempty",$webvars['Post - RMQ-Resume of article'],"","","<b>","255"));
$this->form->add("",true,"content",array("content",$webvars['Post - Content of article'],"textarea",$this->form->stripDB($post_detail["detail_Content"]),"","notempty",$webvars['Post - RMQ-Content of article'],'class="editor"',""));

$sql_parents = $this->form->DB_fetch_list("SELECT * FROM posts WHERE Status = 'active' ORDER BY Name ASC");
foreach ( $sql_parents as $row){
	$array_parents[$row["Id"]] = $row["Name"];
}

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
        $.post('index.php?m=order-parent-post', { parent: $('#parentid').val()},
        function success(data){
           $('#order').html(data);
        });
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
$parent = intval($this->form->valueInsertOrUpdate("parentid","0",$this->form->sql,"Parent",$this->form->IdRequest));

if( $parent != 0 ){
    //Récupérer le titre du parent
    $fetch_parent_title = $this->db->DB_fetch("SELECT m1.* FROM post_details AS m1 LEFT JOIN posts AS m2 ON m1.Post_id = m2.Id WHERE (m2.Id ='".$this->form->escapeDB($parent)."')");
    $parent_title = $this->db->stripDB($fetch_parent_title["Title"]." (Id:".$fetch_parent_title["Id"]).")";
}else{
    $parent_title = $this->form->request["parenttitle"];
}

//Champs Titre et Id
$parent_field =  '<input id="parenttitle" name="parenttitle" type="text" value="'.$parent_title.'" autocomplete="off" class="ac_input"  style="width:300px;">'
               .  ' <b>Id :</b> <input id="parentid" name="parentid" type="text" value="'.$parent.'" style="width:50px;border:solid 1px #DDD;background:#EEE;" readonly="">';
//Validation Id : numérique non vide
$id = $this->form->valueGetOrPost($this->form->IdRequest);
$parent_validation = array("comparfields" => array(
                                                        array(
                                                            "parentid" 	=> "empty"
                                                        ),
                                                        array(
                                                            "parentid" 	=> array("=","0")
                                                        )
                                                     )
						);

if( $this->form->is_to_update ){
    $parent_validation["comparfields"][] = array("parentid" 	=> array("<>" => $id) );
}else{
    $parent_validation["comparfields"][] = array("parentid" 	=> "number" );
}

$this->form->add("",true,"parent",array("parent",$webvars['Post - Parent of article'],"free",$parent_field,"",$parent_validation,$webvars['Post - RMQ-Parent of article'],"",""));

$this->form->add("",true,"tags",array("tags",$webvars['Post - Tags of article'],"textarea",$this->form->stripDB($post_detail["detail_Tags"]),"","",$webvars['Post - RMQ-Tags of article'],"","","<b>","255"));

$this->form->add("",true,"author",array("author",$webvars['Post - Author of article'],"text",$this->form->stripDB($post_detail["detail_Author"]),"","",$webvars['Post - RMQ-Author of article'],"","","<b>","255"));

$this->form->add("",true,"link_author",array("link_author",$webvars['Post - Link to author of article'],"text",$this->form->stripDB($post_detail["detail_Link_author"]),"","",$webvars['Post - RMQ-Link to author of article'],"","","<b>","255"));
        
$this->form->add("Date_event",true,"date",array("date",$webvars['Post - Date of article'],"date","","","date",$webvars['Post - RMQ-Date of article'],"",""));

$array_subpost = array("none" => $webvars['Post - None sub-articles'], "category" => $webvars['Post - sub-articles as category'], "sub_posts" => $webvars['Post - sub-articles as sub-posts']);
$this->form->add("Categorization",true,"subarticles",array("subarticles",$webvars['Post - Categorisation of article'],"select","none",$array_subpost,"",$webvars['Post - RMQ-Categorisation of article'],"",""));


$sql_languages = $this->form->DB_fetch_list("SELECT * FROM language WHERE Status = 'active' ORDER BY Code ASC");
foreach ( $sql_languages as $row){
	$array_languages[$this->db->stripDB($row["Code"])] = $this->db->stripDB($row["Name"]);
}

$this->form->add("Language",true,"language",array("language",$webvars['Language'],"select","",$array_languages,"notempty",$webvars['RMQ-Language'],$add_language,""));

$nbr_order = $this->form->DB_num_rows("SELECT * FROM posts WHERE Parent ='".$this->form->escapeDB($parent)."' ");

$num_order = 0;

while( $num_order <= $nbr_order ){
	$num_order = $num_order+1;
	if( ( $this->form->is_to_update == false ) or ( ( $this->form->is_to_update == true ) and ( $num_order <= $nbr_order) ) ){
		$array_order[$num_order] = $num_order;
	}	 
}

$this->form->add("Order_post",true,"order",array("order",$webvars['Post - Document order'],"select","",$array_order,"notempty",$webvars['Post - RMQ-Document order'],"",""));


$this->form->closeFieldset();

$this->form->openFieldset($webvars['Post - Classification of article']);
$array_categories = array();
$array_categories = $this->form->DB_fetch_list("SELECT * FROM postcategories WHERE Status = 'active'");

$array_all_categories = array();
foreach( $array_categories as $row){
    $array_all_categories[$this->form->stripDB($row["Id"])]	= $this->form->stripDB($row["Title"]);
}

//$values_categories = array();
/*
if( $this->form->is_to_update ){
    $fetch_categories = $this->form->DB_fetch_list("SELECT * FROM post_categories WHERE Post_id = ".$this->form->escapeDB($id)."");
    $values_categories[] = '0';
    foreach( $fetch_categories as $key => $row ){
        $values_categories[] = $this->form->stripDB($row["Category_id"]);
    }
    echo 'Cat : <HR><pre>'.print_r($values_categories,true).'</pre>';
}
*/
if( $this->form->isSubmit() ){
    $values_categories = $this->form->request["categories"];
}else{   
    if($this->form->is_to_update ){
        $fetch_categories = $this->form->DB_fetch_list("SELECT * FROM post_categories WHERE Post_id = ".$this->form->escapeDB($id)."");
        $values_categories[] = '0';
        foreach( $fetch_categories as $key => $row ){
            $values_categories[] = $this->form->stripDB($row["Category_id"]);
        }
    }
}
        
$this->form->add("",true,"categories",array("categories",$webvars['Post - Categories of article'],"multipleselect",$values_categories,$array_all_categories,"",$webvars['Post - RMQ-Categories of article'],'size="5"',""));

$this->form->closeFieldset();

$this->form->openFieldset($webvars['Post - Localization of article']);
?>
<script>
$(document).ready(function () {			
    $("#place").autocomplete("index.php?m=place", {
                    width: 390,
                    selectFirst: true,                    
                    matchContains: true,
                    highlightItem: false
    });
    $("#place").result(function(event, data, formatted) {                   
                    if (data){
                        $data = true;
                        $("#field_country").show();
                        $("#field_latbox").show();
                        $("#field_lonbox").show();
                        $("#field_map").show();
                        $("#country").val(data[1]);
                    }
    });
});
</script>
<?php

$add_to_place_map = 'OnChange="showAddress(this.value);"';
$this->form->add("",true,"place",array("place",$webvars['Post - Place of article'],"text",$this->form->stripDB($post_detail["detail_Place"]),"","",$webvars['Post - RMQ-Place of article'],$add_to_place_map,""));

$array_countries_sql = $this->form->DB_fetch_list("SELECT * FROM countries WHERE Status = 'active'");
$array_countries = array();
foreach( $array_countries_sql as $row){
    $array_countries[$this->form->stripDB($row["iso2"])]	= $this->form->stripDB($row["name"]);
}

if( $this->form->stripDB($post_detail["detail_Place"]) == "" ){
    $default_display_place = 'style="display:none;"';
    $map_detail  = array();
}else{
    $default_display_place = '';
    //Select values of the place in the map
    $sql = "SELECT m1.* FROM ".$this->form->escapeDB($sqlTable_map)." AS m1 WHERE m1.Title = '".$this->form->escapeDB($this->form->stripDB($post_detail["detail_Place"]))."'";
    $exist_map = $this->form->DB_num_rows($sql);
    if( $exist_map != 0 ){
        $map_detail = $this->form->DB_fetch($sql);
        $add_map    = "<script>showLatLong(".$this->form->stripDB($map_detail["Latitude"]).",".$this->form->stripDB($map_detail["Latitude"]).");</script>";
    }else{    
        $default_display_place = 'style="display:none;"';
        $map_detail  = array();
    }    
}


$add_to_show_map = 'OnChange="showLatLong(document.getElementById(\'latbox\').value,document.getElementById(\'lonbox\').value);"';

$this->form->add("",true,"country",array("country",$webvars['Post - Country of article'],"select",$this->form->stripDB($map_detail["Country_iso2"]),$array_countries,"",$webvars['Post - RMQ-Country of article'],"",$default_display_place));
$this->form->add("",true,"latbox",array("latbox",$webvars['Post - Latitude of article'],"text",$this->form->stripDB($map_detail["Latitude"]),"","",$webvars['Post - RMQ-Latitude of article'],$add_to_show_map,$default_display_place));
$this->form->add("",true,"lonbox",array("lonbox",$webvars['Post - Longitude of article'],"text",$this->form->stripDB($map_detail["Longitude"]),"","",$webvars['Post - RMQ-Longitude of article'],$add_to_show_map,$default_display_place));

$this->form->add("",true,"latboxm",array("latboxm",$webvars['Post - Latitude of article']." (Degres)","text","","","","",$add_to_show_map,'style="display:none;"'));
$this->form->add("",true,"latboxmd",array("latboxmd",$webvars['Post - Latitude of article']." (Minutes)","text","","","","",$add_to_show_map,'style="display:none;"'));
$this->form->add("",true,"latboxms",array("latboxms",$webvars['Post - Latitude of article']." (Seconds)","text","","","","",$add_to_show_map,'style="display:none;"'));

$this->form->add("",true,"lonboxm",array("lonboxm",$webvars['Post - Longitude of article']." (Degres)","text","","","","",$add_to_show_map,'style="display:none;"'));
$this->form->add("",true,"lonboxmd",array("lonboxmd",$webvars['Post - Longitude of article']." (Minutes)","text","","","","",$add_to_show_map,'style="display:none;"'));
$this->form->add("",true,"lonboxms",array("lonboxms",$webvars['Post - Longitude of article']." (Seconds)","text","","","","",$add_to_show_map,'style="display:none;"'));

$this->form->add("",true,"map",array("map",$webvars['Post - Map of article'],"free",'<div id="map" style="width:390px;height:300px;margin-left: 230px;"></div>'.$add_map,"","",$webvars['Post - RMQ-Map of article'],"",$default_display_place));

$this->form->closeFieldset();

$this->form->openFieldset($webvars['Post - Publication parameter']);

$this->form->add("Publish_from",true,"publish_from",array("publish_from",$webvars['Post - Publication start of article'],"date_time","","","date_time",$webvars['Post - RMQ-Publication start of article'],"",""));

$this->form->add("Publish_to",true,"publish_to",array("publish_to",$webvars['Post - Publication end of article'],"date_time","","","date_time",$webvars['Post - RMQ-Publication end of article'],"",""));

$this->form->add("Password",true,"password",array("password",$webvars['Post - Password of article'],"text","","","",$webvars['Post - RMQ-Password of article'],"",""));

$this->form->closeFieldset();

$this->form->openFieldset($webvars['Post - Other informations']);

$this->form->add("",true,"meta_keywords",array("meta_keywords",$webvars['Post - Meta keywords'],"textarea",$this->form->stripDB($post_detail["detail_Meta_keywords"]),"","",$webvars['Post - RMQ-Meta keywords'],"",""));

$this->form->add("",true,"meta_description",array("meta_description",$webvars['Post - Meta description'],"textarea",$this->form->stripDB($post_detail["detail_Meta_description"]),"","",$webvars['Post - RMQ-Meta description'],"",""));

$this->form->add("",true,"rights",array("rights",$webvars['Post - Rights'],"textarea",$this->form->stripDB($post_detail["detail_Rights"]),"","",$webvars['Post - RMQ-Rights'],"",""));
        
$this->form->closeFieldset();


$this->form->add_group_to_show("content_status",$this->acces("post_administration"));

$this->form->openFieldset($webvars['Post - Article administration']);

$add_status_comment = array("onChange" =>
						 "
                                                    if( $('#status_comment').val() == 'restricted' ){
						 	$('#field_max_comment').show();
                                                    }else{
                                                 	$('#field_max_comment').hide();   
                                                    }
						 "
						);
$array_status_comment = array("opened" => $webvars['Post - Comments opened'], "closed" => $webvars['Post - Comments closed'], "restricted" => $webvars['Post - Comments restricted']);
$this->form->add("Status_comment",true,"status_comment",array("status_comment",$webvars['Post - Status of comments of article'],"select","0",$array_status_comment,"",$webvars['Post - RMQ-Status of comments of article'],$add_status_comment,""));


$restrected = $this->form->valueInsertOrUpdate("status_comment","opened",$this->form->sql,"Status_comment",$this->form->IdRequest);

if( $restrected == "restricted"){
    $add_tag_max_comments = '';
}else{
    $add_tag_max_comments = 'style="display:none;"';
}
$this->form->add("Count_comment",true,"max_comment",array("max_comment",$webvars['Post - Max comments of article'],"text","0","","",$webvars['Post - RMQ-Max comments of article'],"",$add_tag_max_comments));

$array_status = array("inactive" => $webvars['Inactive'], "active" => $webvars['Active'], "archieve" => $webvars['Archieve']);
$this->form->add("Status",true,"status",array("status",$webvars['Post - Status of article'],"select","inactive",$array_status,"",$webvars['Post - RMQ-Status of article'],"",""));
$this->form->closeFieldset();

$this->form->remove_group_to_show("content_status");

$this->form->add_group_to_show("captcha",$this->acces("post_captcha"));
$this->form->openFieldset($webvars['Scurity']);
$this->form->add("",true,"scuritycode",array("scuritycode",$webvars['Scurity code'],"captcha","",array("height"=>"30","characters"=>"6"),"",$webvars['RMQ-Copy the scurity code from the image'],"",""));
$this->form->closeFieldset();
$this->form->remove_group_to_show("captcha");


$this->form->add("Id",true,"id",array("id","","hidden","","","","","",""));

$this->form->showSubmit($this->form->fieldSubmit,$webvars['Validate my choices']);
$this->form->showReset($this->form->fieldReset,$webvars['Reset my choices']);
echo '<div class="span8">';
$this->form->closeForm();

//Si Aucune catégorie n'est choisis
if( !isset($this->form->request["categories"])){
	$categories = array();
}else{
    $categories = $this->form->request["categories"];
}

$this->form->add_action("Parent",array(array($this->form->request["parentid"]),array($this->form->request["parentid"])));
        
if( $this->form->is_to_update ){
	$this->form->add_action("Update_Time",array(array(time()),array(time())));
	$this->form->add_action("Update_User_Id",array(array($this->user->id),array($this->user->id)));
	$this->form->add_action("Update_Host_Ip",array(array($_SERVER['REMOTE_ADDR']),array($_SERVER['REMOTE_ADDR'])));
	$this->form->add_action("Update_Host_Details",array(array(print_r($_SERVER, true)),array(print_r($_SERVER, true))));
}else{
	$this->form->add_action("Add_Time",array(array(time()),array(time())));
	$this->form->add_action("Add_User_Id",array(array($this->user->id),array($this->user->id)));
	$this->form->add_action("Add_Host_Ip",array(array($_SERVER['REMOTE_ADDR']),array($_SERVER['REMOTE_ADDR'])));
	$this->form->add_action("Add_Host_Details",array(array(print_r($_SERVER, true)),""));
	$this->form->add_action("Update_Time",array(array(time()),array(time())));
	$this->form->add_action("Update_User_Id",array(array($this->user->id),array($this->user->id)));
	$this->form->add_action("Update_Host_Ip",array(array($_SERVER['REMOTE_ADDR']),array($_SERVER['REMOTE_ADDR'])));
	$this->form->add_action("Update_Host_Details",array(array(print_r($_SERVER, true)),array(print_r($_SERVER, true))));
}

if( $this->form->is_to_update ){
	if( !$this->form->is_error_OnUpdate ){
            $data_update_params = array($this->form->data_update, array(array("AND" , $this->form->IdSqlTable , $this->form->IdRequest, "=")) );
            $this->form->onSucces(array("sql",array("update",$this->form->sqlTable,$data_update_params)));
            if( $this->form->isSucces() ) { 
                
                $post_parent  = $this->form->request["id"]; //updated post
                
                //manage the category
                if( count($categories) == 0 ){
                    $cat_imploded = "";
                    $sql_cat_add = "";
                }else{
                    $cat_imploded = "('".implode("','", $categories)."')";
                    $sql_cat_add = " AND Category_id NOT IN ".$cat_imploded." ";
                }
                //Delete all categories those not selected
                $delete_inexisted_cat = "DELETE * FROM ".$this->form->escapeDB($sqlTable_post_categories)." WHERE Post_id = '".$this->form->escapeDB($post_parent)."'".$sql_cat_add;
                //Insert links of all selected categories for the post
                foreach ( $categories as $key => $val ){
                    //If the category don't existe => Insert the category
                    $exist_cat = "SELECT * FROM ".$this->form->escapeDB($sqlTable_post_categories)." WHERE Category_id = '".$this->form->escapeDB($val)."' AND Post_id = '".$this->form->escapeDB($post_parent)."'";
                    if( $this->form->DB_num_rows($exist_cat) == 0 ){
                        //Insert the category
                        $sql_cat = "INSERT INTO ".$this->form->escapeDB($sqlTable_post_categories)." (Id, Category_id, Post_id, Add_time, Add_User_Id, Add_Host_Ip, Add_Host_Details ) "
                                ."VALUES ('',"
                                ."'".$this->form->escapeDB($val)."',"
                                ."'".$this->form->escapeDB($post_parent)."',"
                                ."'".$this->form->escapeDB(time())."',"
                                ."'".$this->form->escapeDB($this->user->id)."',"
                                ."'".$this->form->escapeDB($_SERVER['REMOTE_ADDR'])."',"
                                ."'".$this->form->escapeDB(print_r($_SERVER,true))."'"
                                .")";
                        $this->form->DB_res($sql_cat);
                    }else{
                        //Update the category
                        $sql_cat = "UPDATE ".$this->form->escapeDB($sqlTable_post_categories)
                                ." SET Update_time = '".$this->form->escapeDB(time())."',"
                                ." Update_User_Id = '".$this->form->escapeDB($this->user->id)."',"
                                ." Update_Host_Ip = '".$this->form->escapeDB($_SERVER['REMOTE_ADDR'])."',"
                                ." Update_Host_Details = '".$this->form->escapeDB(print_r($_SERVER,true))."'"
                                ." WHERE Post_id = '".$this->form->escapeDB($post_parent)."'"
                                ." AND Category_id = '".$this->form->escapeDB($val)."'";

                        $this->form->DB_res($sql_cat);
                    }
                }
                
                //Insert the map details in map table
                if( $this->form->request["place"] != "" ){   
                    $sql_exist_map = "SELECT * FROM ".$this->form->escapeDB($sqlTable_map)." WHERE Title='".$this->form->escapeDB(trim($this->form->request["place"]))."'";
                    if( $this->form->DB_num_rows($sql_exist_map) == 0 ){
                        $sql_map = "INSERT INTO ".$this->form->escapeDB($sqlTable_map)."(Id,Title,Country_iso2,Latitude,Longitude,Status,Add_time,Add_User_Id,Add_Host_Ip,Add_Host_Details) "
                            ." VALUES("
                            ."'',"
                            ."'".$this->form->escapeDB(trim($this->form->request["place"]))."',"
                            ."'".$this->form->escapeDB($this->form->request["country"])."',"
                            ."'".$this->form->escapeDB($this->form->request["latbox"])."',"
                            ."'".$this->form->escapeDB($this->form->request["lonbox"])."',"
                            ."'active',"
                            ."'".$this->form->escapeDB(time())."',"
                            ."'".$this->form->escapeDB($this->user->id)."',"
                            ."'".$this->form->escapeDB($_SERVER['REMOTE_ADDR'])."',"
                            ."'".$this->form->escapeDB(print_r($_SERVER,true))."'"
                            .")";
                        $this->form->DB_res($sql_map);
                    }
                }
                
                //Insert the details of the post
                $sql_exist_details = "SELECT * FROM ".$this->form->escapeDB($sqlTable_post_details)." WHERE ( Parent='".$this->form->escapeDB($post_parent)."' AND Language='".$this->form->escapeDB($this->form->request["language"])."' ) ";
                if( $this->form->DB_num_rows($sql_exist_details) == 0 ){
                    $sql_deatails = "INSERT INTO ".$this->form->escapeDB($sqlTable_post_details)."(
                    Id,Post_id,Language,Title,Resume,Content,Tags,Author,Link_author,Place,Rights,Meta_description,Meta_keywords,Status,Add_time,Add_User_Id,Add_Host_Ip,Add_Host_Details) "
                            ."VALUES("
                            ."'',"
                            ."'".$this->form->escapeDB($post_parent)."',"
                            ."'".$this->form->escapeDB($this->form->request["language"])."',"
                            ."'".$this->form->escapeDB(trim($this->form->request["title"]))."',"
                            ."'".$this->form->escapeDB(trim($this->form->request["resume"]))."',"
                            ."'".$this->form->escapeDB($this->form->request["content"])."',"
                            ."'".$this->form->escapeDB(trim($this->form->request["tags"]))."',"
                            ."'".$this->form->escapeDB(trim($this->form->request["author"]))."',"
                            ."'".$this->form->escapeDB(trim($this->form->request["link_author"]))."',"
                            ."'".$this->form->escapeDB(trim($this->form->request["place"]))."',"
                            ."'".$this->form->escapeDB(trim($this->form->request["rights"]))."',"
                            ."'".$this->form->escapeDB(trim($this->form->request["meta_description"]))."',"
                            ."'".$this->form->escapeDB(trim($this->form->request["meta_keywords"]))."',"
                            ."'active',"
                            ."'".$this->form->escapeDB(time())."',"
                            ."'".$this->form->escapeDB($this->user->id)."',"
                            ."'".$this->form->escapeDB($_SERVER['REMOTE_ADDR'])."',"
                            ."'".$this->form->escapeDB(print_r($_SERVER,true))."'"
                            .")";
                    $this->form->DB_res($sql_deatails);
                }else{
                    $sql_deatails = "UPDATE ".$this->form->escapeDB($sqlTable_post_details)
                            ." SET Post_id = '".$this->form->escapeDB($post_parent)."',"
                            ." Title = '".$this->form->escapeDB(trim($this->form->request["title"]))."',"
                            ." Resume = '".$this->form->escapeDB(trim($this->form->request["resume"]))."',"
                            ." Content = '".$this->form->escapeDB($this->form->request["content"])."',"
                            ." Tags = '".$this->form->escapeDB(trim($this->form->request["tags"]))."',"
                            ." Author = '".$this->form->escapeDB(trim($this->form->request["author"]))."',"
                            ." Link_author = '".$this->form->escapeDB($this->form->request["link_author"])."',"
                            ." Place = '".$this->form->escapeDB(trim($this->form->request["place"]))."',"
                            ." Rights = '".$this->form->escapeDB(trim($this->form->request["rights"]))."',"
                            ." Meta_keywords = '".$this->form->escapeDB(trim($this->form->request["meta_keywords"]))."',"
                            ." Meta_description = '".$this->form->escapeDB(trim($this->form->request["meta_description"]))."',"
                            ." Status = 'active',"
                            ." Add_time = '".$this->form->escapeDB(time())."',"
                            ." Add_User_Id = '".$this->form->escapeDB($this->user->id)."',"
                            ." Add_Host_Ip = '".$this->form->escapeDB($_SERVER['REMOTE_ADDR'])."',"
                            ." Add_Host_Details = '".$this->form->escapeDB(print_r($_SERVER,true))."'"
                            ." WHERE ( Parent='".$this->form->escapeDB($post_parent)."' ) AND ( Language='".$this->form->escapeDB($this->form->request["language"])."' ) ";
                    $this->form->DB_res($sql_deatails);
                }                        
                $this->form->printJsRedirection("index.php?p=list_posts","3000");     
            }
	}
}else{
	$this->form->onSucces(array("sql",array("insert",$this->form->sqlTable,$this->form->data_insert)));
	if( $this->form->isSucces() ) {
                            
                $post_parent  = $this->form->db_insert_value;
                
                //manage the category
                if( count($categories) == 0 ){
                    $cat_imploded = "";
                    $sql_cat_add = "";
                }else{
                    $cat_imploded = "('".implode("','", $categories)."')";
                    $sql_cat_add = " AND Category_id NOT IN ".$cat_imploded." ";
                }
                //Delete all categories those not selected
                $delete_inexisted_cat = "DELETE * FROM ".$this->form->escapeDB($sqlTable_post_categories)." WHERE Post_id = '".$this->form->escapeDB($post_parent)."'".$sql_cat_add;
                //Insert links of all selected categories for the post
                foreach ( $categories as $key => $val ){
                    //If the category don't existe => Insert the category
                    $exist_cat = "SELECT * FROM ".$this->form->escapeDB($sqlTable_post_categories)." WHERE Category_id = '".$this->form->escapeDB($val)."' AND Post_id = '".$this->form->escapeDB($post_parent)."'";
                    if( $this->form->DB_num_rows($exist_cat) == 0 ){
                        //Insert the category
                        $sql_cat = "INSERT INTO ".$this->form->escapeDB($sqlTable_post_categories)." (Id, Category_id, Post_id, Add_time, Add_User_Id, Add_Host_Ip, Add_Host_Details ) "
                                ."VALUES ('',"
                                ."'".$this->form->escapeDB($val)."',"
                                ."'".$this->form->escapeDB($post_parent)."',"
                                ."'".$this->form->escapeDB(time())."',"
                                ."'".$this->form->escapeDB($this->user->id)."',"
                                ."'".$this->form->escapeDB($_SERVER['REMOTE_ADDR'])."',"
                                ."'".$this->form->escapeDB(print_r($_SERVER,true))."'"
                                .")";
                        $this->form->DB_res($sql_cat);
                    }else{
                        //Update the category
                        $sql_cat = "UPDATE ".$this->form->escapeDB($sqlTable_post_categories)
                                ." SET Update_time = '".$this->form->escapeDB(time())."',"
                                ." Update_User_Id = '".$this->form->escapeDB($this->user->id)."',"
                                ." Update_Host_Ip = '".$this->form->escapeDB($_SERVER['REMOTE_ADDR'])."',"
                                ." Update_Host_Details = '".$this->form->escapeDB(print_r($_SERVER,true))."'"
                                ." WHERE Post_id = '".$this->form->escapeDB($post_parent)."'"
                                ." AND Category_id = '".$this->form->escapeDB($val)."'";

                        $this->form->DB_res($sql_cat);
                    }
                }
                
                //Insert the map details in map table
                $sql_exist_map = "SELECT * FROM ".$this->form->escapeDB($sqlTable_map)." WHERE Title='".$this->form->escapeDB(trim($this->form->request["place"]))."'";
                if( $this->form->DB_num_rows($sql_exist_map) == 0 ){
                    $sql_map = "INSERT INTO ".$this->form->escapeDB($sqlTable_map)."(Id,Title,Country_iso2,Latitude,Longitude,Status,Add_time,Add_User_Id,Add_Host_Ip,Add_Host_Details) 
                        VALUES(
                        '',
                        '".$this->form->escapeDB(trim($this->form->request["place"]))."',
                        '".$this->form->escapeDB($this->form->request["country"])."',
                        '".$this->form->escapeDB($this->form->request["latbox"])."',
                        '".$this->form->escapeDB($this->form->request["lonbox"])."',
                        'active','".$this->form->escapeDB(time())."',
                        '".$this->form->escapeDB($this->user->id)."',
                        '".$this->form->escapeDB($_SERVER['REMOTE_ADDR'])."',
                        '".$this->form->escapeDB($_SERVER)."'
                        )";
                    $this->form->DB_res($sql_map);
                }
                
                //Insert the details of the post
                $sql_deatails = "INSERT INTO ".$this->form->escapeDB($sqlTable_post_details)."(Id,Post_id,Language,Title,Resume,Content,Tags,Author,Link_author,Place,Rights,Meta_description,Meta_keywords,Status,Add_time,Add_User_Id,Add_Host_Ip,Add_Host_Details) "
                        ."VALUES("
                        ."'',"
                        ."'".$this->form->escapeDB($post_parent)."',"
                        ."'".$this->form->escapeDB($this->form->request["language"])."',"
                        ."'".$this->form->escapeDB(trim($this->form->request["title"]))."',"
                        ."'".$this->form->escapeDB(trim($this->form->request["resume"]))."',"
                        ."'".$this->form->escapeDB($this->form->request["content"])."',"
                        ."'".$this->form->escapeDB(trim($this->form->request["tags"]))."',"
                        ."'".$this->form->escapeDB(trim($this->form->request["author"]))."',"
                        ."'".$this->form->escapeDB(trim($this->form->request["link_author"]))."',"
                        ."'".$this->form->escapeDB(trim($this->form->request["place"]))."',"
                        ."'".$this->form->escapeDB(trim($this->form->request["rights"]))."',"
                        ."'".$this->form->escapeDB(trim($this->form->request["meta_description"]))."',"
                        ."'".$this->form->escapeDB(trim($this->form->request["meta_keywords"]))."',"
                        ."'active',"
                        ."'".$this->form->escapeDB(time())."',"
                        ."'".$this->form->escapeDB($this->user->id)."',"
                        ."'".$this->form->escapeDB($_SERVER['REMOTE_ADDR'])."',"
                        ."'".$this->form->escapeDB(print_r($_SERVER,true))."'"
                        .")";
                $this->form->DB_res($sql_deatails);

                $this->form->printJsRedirection("index.php?p=list_posts","3000");     
            }
}
echo '</div>';
include_once 'modules/slidebar-post.php';

?>