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

 $page_en_cours = "index.php?p=inscription";
 
		//Inscription
		if( isset($_POST["signup_submit"]) ){
			$connection_status = "inscription";
			
			$signup_numpolice 			= $_POST["signup_numpolice"];
			$signup_mail 				= $_POST["signup_mail"];
			$signup_password 			= $_POST["signup_password"];
			$signup_password_confirm 	= $_POST["signup_password_confirm"];
			$signup_name 				= $_POST["signup_name"];
			$signup_lastname 			= $_POST["signup_lastname"];
			$signup_addresse 			= $_POST["signup_addresse"];
			$signup_tel 				= $_POST["signup_tel"];
			$signup_condition 			= $_POST["signup_condition"];
			$signup_captcha 			= $_POST["signup_captcha"];
			$signup_numpolice_start		= $_POST["signup_numpolice_start"];
			$signup_numpolice_end		= $_POST["signup_numpolice_end"];
			
			//errors check						
			if( $signup_numpolice == "" ){
				$error["signup_numpolice"] 			= $webvars['Subscriber - numpolice - MSG - Empty'];
				$class_error["signup_numpolice"]		= " input_error";				
			}else{
				$regex_numpolice	= '/^16096-[0-9]{2}-[0-9]{4}-[0-9]{4}$/';
				if( !preg_match($regex_numpolice, $signup_numpolice) ){ 			
					$error["signup_numpolice"] 				= $webvars['Subscriber - numpolice - MSG - Invalid'];
					$class_error["signup_numpolice"]		= " input_error";
				}else{
					$sql_exist = "SELECT * FROM subscriber WHERE ( Num_police_subscriber = '".$this->db->escapeDB($signup_numpolice)."' ) ";
					$row_exist = $this->db->DB_fetch($sql_exist);		
					if( $row_exist["Id_subscriber"] != "" ){
						$error["signup_numpolice"] 				= $webvars['Subscriber - numpolice - MSG - Exist'];
						$class_error["signup_numpolice"]		= " input_error";
					}					
				}
			}
			if( $signup_mail == "" ){
				//$error["signup_mail"] 				= $webvars['Subscriber - Email - MSG - Empty'];
				//$class_error["signup_mail"]		= " input_error";
			}else{
				if( !$this->form->is_Mail($signup_mail) ){
					$error["signup_mail"] 				= $webvars['Subscriber - Email - MSG - Invalid'];
					$class_error["signup_mail"]		= " input_error";
				}else{
					$sql_exist = "SELECT * FROM subscriber WHERE ( Mail_subscriber = '".$this->db->escapeDB($signup_mail)."' ) ";
					$row_exist = $this->db->DB_fetch($sql_exist);		
					if( $row_exist["Id_subscriber"] != "" ){
						$error["signup_mail"] 			= $webvars['Subscriber - Email - MSG - Exist'];
						$class_error["signup_mail"]		= " input_error";
					}

				}
			}
			if( $signup_password == "" ){
				$error["signup_password"] 			= $webvars['Subscriber - Password - MSG - Empty'];
				$class_error["signup_password"]		= " input_error";
			}
			if( strlen($signup_password) < 6 ){
				$error["signup_password"] 			= $webvars['Subscriber - Password - MSG - Length'];
				$class_error["signup_password"]		= " input_error";
			}
			
			if( $signup_password_confirm == "" ){
				$error["signup_password_confirm"] 	= $webvars['Subscriber - Password - Confirm - MSG - Empty'];
				$class_error["signup_password_confirm"]		= " input_error";
			}
			if( ( $signup_password != '' ) and ( $signup_password_confirm != "" ) ){	
				if( $signup_password != $signup_password_confirm ){
					$error["signup_password_confirm"] 		= $webvars['Subscriber - Password - MSG - Confirm'];
					$class_error["signup_password"]			= " input_error";
					$class_error["signup_password_confirm"]	= " input_error";
				}	
			}
			
			$regex_date	= '/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[012])\/(19|20)[0-9]{2}$/';
					
			if( !preg_match($regex_date, $signup_numpolice_start) ){ 			
				$error["signup_numpolice_start"] 		= $webvars['Subscriber - numpolice - Date - Start - MSG - Invalid'];
				$class_error["signup_numpolice_start"]	= " input_error";
			}
			if( !preg_match($regex_date, $signup_numpolice_end) ){ 			
				$error["signup_numpolice_end"] 			= $webvars['Subscriber - numpolice - Date - End - MSG - Invalid'];
				$class_error["signup_numpolice_end"]	= " input_error";
			}
								
							
			if( ( $class_error["signup_numpolice_end"] == "" ) and ( $class_error["signup_numpolice_end"] == "" ) ) {			
				$today = date("Y-m-d");
				$exploded_date_start = explode("/",$signup_numpolice_start);
				$signup_numpolice_start_y = $exploded_date_start[0]; 
				$signup_numpolice_start_m = $exploded_date_start[1];
				$signup_numpolice_start_d = $exploded_date_start[2];
				
				$exploded_date_end = explode("/",$signup_numpolice_end);
				$signup_numpolice_end_y = $exploded_date_end[2]; 
				$signup_numpolice_end_m = $exploded_date_end[1];
				$signup_numpolice_end_d = $exploded_date_end[0];

				if( $today > $signup_numpolice_end_y.'-'.$signup_numpolice_end_m.'-'.$signup_numpolice_end_d ){
					$error["signup_numpolice_end"] 			= $webvars['Subscriber - numpolice - Date - End - MSG - Today Invalid'];
					$class_error["signup_numpolice_start"]	= " input_error";
					$class_error["signup_numpolice_end"]	= " input_error";
				}
			}
			
			
			if( $signup_name == "" ){
				$error["signup_name"] 				= $webvars['Subscriber - Name - MSG - Empty'];
				$class_error["signup_name"]		= " input_error";
			}
			if( $signup_lastname == "" ){
				$error["signup_lastname"] 			= $webvars['Subscriber - Lastame - MSG - Empty'];
				$class_error["signup_lastname"]		= " input_error";
			}
			if( $signup_condition == "" ){
				$error["signup_condition"] 			= $webvars['Subscriber - Condition - MSG - Empty'];
				$class_error["signup_condition"]		= " input_error";
			}
			if( $signup_tel == "" ){
				$error["signup_tel"] 			= $webvars['Subscriber - Tel Mobile - MSG - Empty'];
				$class_error["signup_tel"]		= " input_error";
			}
  			/*
			if( $signup_captcha == "" ){
				$error["signup_captcha"] 		= $webvars['Subscriber - captcha - MSG - Empty'];
				$class_error["signup_captcha"]= ' input_error'; 
				$connection_status = "invalide";
			}elseif( $signup_captcha != $_SESSION['connect2'] ){
				$error["signup_captcha"] 		= $webvars['Subscriber - captcha - MSG - Invalide'];
				$class_error["signup_captcha"]= ' input_error'; 
				$connection_status = "invalide";
			}*/

			$activation_Code    = $this->returnNewPass();

			if( count($error) == 0  ){
				//Inscription - BD
				$sql_insert = "INSERT INTO subscriber ";
				$sql_insert.= "SET Id_subscriber='', ";
				$sql_insert.= "Num_police_subscriber='".$this->db->escapeDB(trim($signup_numpolice))."', ";
				$sql_insert.= "Date_start='".$this->db->escapeDB(trim($signup_numpolice_start))."', ";
				$sql_insert.= "Date_end='".$this->db->escapeDB(trim($signup_numpolice_end))."', ";
				$sql_insert.= "Password_subscriber='".$this->db->escapeDB(trim($this->codify_password($signup_password)))."', ";
				$sql_insert.= "Name_subscriber='".$this->db->escapeDB(trim($signup_name))."', ";
				$sql_insert.= "Lastname_subscriber='".$this->db->escapeDB(trim($signup_lastname))."', ";
				$sql_insert.= "Job_subscriber='".$this->db->escapeDB(trim($signup_job))."', ";
				$sql_insert.= "Mail_subscriber='".$this->db->escapeDB(trim($signup_mail))."', ";
				$sql_insert.= "Addresse_subscriber='".$this->db->escapeDB(trim($signup_addresse))."', ";
				$sql_insert.= "Tel_subscriber='".$this->db->escapeDB(trim($signup_tel))."', ";
				$sql_insert.= "Status_subscriber='active', ";
				$sql_insert.= "Activation_Code='".$this->db->escapeDB(trim($activation_Code))."', ";
				$sql_insert.= "Ajout_date='".$this->db->escapeDB(date("Y-m-d H:i:s"))."', ";
				$sql_insert.= "Ajout_utilisateur='".$this->db->escapeDB($user->id)."', ";	
				$sql_insert.= "Ajout_ip='".$this->db->escapeDB($_SERVER['REMOTE_ADDR'])."' ";
				
				
				$exec= $this->db->DB_res($sql_insert,"");
				$id_subscriber = $this->db->DB_insert_id($sql_insert);
				$_SESSION["connect_subscriber_session"] = $id_subscriber.'|'.$signup_name.'|'.$signup_lastname.'|'.$signup_numpolice.'|'.$signup_addresse.'|'.$signup_tel.'|'.$signup_job.'|'.$signup_mail.'|'.time();
				
			if( $signup_mail != "" ){
			
/*		
						$select_id 	= "SELECT Id_subscriber FROM subscriber WHERE Num_police_subscriber = '".$this->db->escapeDB(trim($signup_numpolice))."' ";				
			
						$row_id 	= $this->db->DB_fetch($select_id);				
						
			//				$id_subscriber2 = $this->db->DB_insert_id($sql_insert);
			
						//récupérer l'identfiant de l'article
						$id_subscriber = $row_id["Id_subscriber"];
						
						$link_activation		= '<a href="'.$this->return_Current_Host()."activation/".$id_subscriber."/".$this->db->stripDB(trim($activation_Code)).".html".'" target="_blank">'.$this->return_Current_Host()."activation/".$id_subscriber."/".$this->db->stripDB(trim($activation_Code)).".html".'</a>';
			
						//C0lvlPET1T10lv
						//Envoi email    
						$this->email->destinationEmail 	= $signup_mail;
						$this->email->from             	= $configvars['WEB_mail_from_name'].'<'.$configvars['WEB_mail_from_mail'].'>';
						$this->email->subject          	= $webvars["Subscriber - Inscription - Subject"];
						$info                       	= sprintf($webvars["Subscriber - Inscription - Message"], $signup_name,$link_activation, $signup_password);
						$footer                     	= date("Y-m-d"); 
						$this->email->message          	= $this->get_include_contents('includes/mail-information.php',$webvars["Information"],$info,$footer);
						$this->email->send();
*/
			}
				$connection_status = "registred";
			}
	
		}else{
			$signup_numpolice 			= "";
			$signup_password 			= "";
			$signup_password_confirm 	= "";
			$signup_numpolice_start 	= "";
			$signup_numpolice_end 		= "";
			$signup_mail 				= "";
			$signup_name 				= "";
			$signup_lastname			= "";
			$signup_job					= "";
			$signup_addresse			= "";
			$signup_tel					= "";
			$signup_condition 			= "";			
		}


?>
<div class="row">
<?php			
		if( $connection_status == "registred"){
	?>	
<div class="span12">    
        <div class="connection_message"><?php echo $webvars["Subscriber - Connection - connected"]; ?></div>
</div>    
  <SCRIPT LANGUAGE="JavaScript">
		window.setTimeout("location=('index.php?p=monespace');",3000);
		</script>
	<?php			
		}else{
	?>
<div class="span6 inscriptionleft">
	<span class="inscription-title">Inscription au service de déclaration d'accident en ligne</span>
    <p class="inscription-description">Pour s'inscrire à notre service veuillez remplir les champs du formulaire à coté et accépter les condition d'utilisation de notre service.
    </p>   
			<?php										
			
				if( count($error) > 0 ){
					echo '<ul class="error">';
					foreach( $error as $err ){				
					echo '<li>';
					echo $err;
					echo '</li>';
					}
					echo '</ul>';
				}
	?>			
        
<ol>
        	<li>Votre numéro de police d'assurance est obligatoire. Il se trouve dans votre contrat ou dans le carte d'assurance livrées lors de l'assurance de votre véhicule.</li>
            <li>Veuillez spécifier votre mot de passe et de le confirmer en formulant un mot de passe fort et facile à le mémoriser.</li>
        	<li>Veuillez formulez votre nom et prénom afin d'être identifié</li>
        	<li>Veuillez formulez votre addresse pour vous contacter ainsi que votre téléphone</li>
        	<li>L'addresse de messagerie éléctronique est optionnelle mais elle est importante pour avoir des informations sur vos demande en ligne.</li>
        </ol>    
</div>

<div class="span6">
	<div id="signup">
                        <h1><?php echo $webvars["Subscriber - Not yet registered"]; ?></h1>
                        <form name="signupform" id="signupform" action="<?php echo $page_en_cours; ?>" method="post">
                            <p>
                                <label><?php echo $webvars['Subscriber - Your Assurance number']; ?><span class="required">*</span></label>
                                <input type="text" name="signup_numpolice" id="signup_numpolice" class="input mask_np <?php echo $class_error["signup_numpolice"]; ?>" value="<?php echo $signup_numpolice; ?>" size="20" tabindex="14" />
                            </p>
                            
                            <p class="half">
                                <label><?php echo $webvars['Subscriber - Your Assurance number - Date - Start']; ?><span class="required">*</span></label>
                                <input type="text" name="signup_numpolice_start" id="signup_numpolice_start" class="input mask_date_dmy <?php echo $class_error["signup_numpolice_start"]; ?>" value="<?php echo $signup_numpolice_start; ?>" size="20" tabindex="15" />
                            </p>
                            
                            <p class="half right">
                                <label><?php echo $webvars['Subscriber - Your Assurance number - Date - End']; ?><span class="required">*</span></label>
                                <input type="text" name="signup_numpolice_end" id="signup_numpolice_end" class="input mask_date_dmy <?php echo $class_error["signup_numpolice_end"]; ?>" value="<?php echo $signup_numpolice_end; ?>" size="20" tabindex="16" />
                            </p>
                            
                            <p>
                                <label><?php echo $webvars['Subscriber - Password - login']; ?><span class="required">*</span></label>
                                <input type="password" name="signup_password" id="signup_password" class="input <?php echo $class_error["signup_password"]; ?>" value="<?php echo $signup_password; ?>" size="20" tabindex="17" />
                            </p>
                            <p>
                                <label><?php echo $webvars['Subscriber - Password - Confirm']; ?><span class="required">*</span></label>
                                <input type="password" name="signup_password_confirm" id="signup_password_confirm" class="input <?php echo $class_error["signup_password_confirm"]; ?>" value="<?php echo $signup_password_confirm; ?>" size="20" tabindex="18" />
                            </p>
                            <p class="half">
                                <label><?php echo $webvars['Subscriber - Name']; ?><span class="required">*</span></label>
                                <input type="text" name="signup_name" id="signup_name" class="input <?php echo $class_error["signup_name"]; ?>" value="<?php echo $signup_name; ?>" size="20" tabindex="19" />
                            </p>
                            <p class="half right">
                                <label><?php echo $webvars['Subscriber - Lastname']; ?><span class="required">*</span></label>
                                <input type="text" name="signup_lastname" id="signup_lastname" class="input <?php echo $class_error["signup_lastname"]; ?>" value="<?php echo $signup_lastname; ?>" size="20" tabindex="20" />
                            </p>
                            <p>
                                <label><?php echo $webvars['Subscriber - Email']; ?></label>
                                <input type="text" name="signup_mail" id="signup_mail" class="input <?php echo $class_error["signup_mail"]; ?>" value="<?php echo $signup_mail; ?>" size="20" tabindex="21" />
                            </p>
                            <p>
                                <label><?php echo $webvars['Subscriber - Addresse']; ?></label>
                                <input type="text" name="signup_addresse" id="signup_addresse" class="input" value="<?php echo $signup_addresse; ?>" size="20" tabindex="22" />
                            </p>
                            <p class="half">
                                <label><?php echo $webvars['Subscriber - Tel Mobile']; ?><span class="required">*</span></label>
                                <input type="text" name="signup_tel" id="signup_tel" class="input mask_phone <?php echo $class_error["signup_tel"]; ?>" value="<?php echo $signup_tel; ?>" size="15" tabindex="23" />
                            </p>
                            <p class="half right">
                                <label><?php echo $webvars['Subscriber - Job']; ?></label>
                                <input type="text" name="signup_job" id="signup_job" class="input" value="<?php echo $signup_job; ?>" size="15" tabindex="24" />
                            </p>
                            <p>
                                <label><?php echo $webvars['Subscriber - Captcha']; ?> <span class="required">*</span></label>
                                <input id="signup_captcha" name="signup_captcha" type="text" value="" class="input <?php echo $class_error["signup_captcha"]; ?>" size="15" tabindex="25" />
                                <img src="includes/captcha/captchasecurityimages.php?name=connect2" class="captcha" />
                            </p>
                            <p>
                                <label>
                                <input type="checkbox" name="signup_condition" id="signup_condition" class="<?php echo $class_error["signup_condition"]; ?>" value="1" <?php if( $signup_condition == "1") { echo 'checked'; }  ?> tabindex="24" />
                                <?php echo $webvars["Subscriber - Condition of use"]; ?></label>
                            </p>
                            <p class="submit">
                                <input type="submit" name="signup_submit" id="signup_submit" class="button-primary" value="<?php echo $webvars["Home - Sign up"]; ?>" tabindex="25" />
                            </p>          
                            <div class="message_required"><span class="required">*</span> : <?php echo $webvars["Subscriber - MSG - Required"]; ?></div>  
                        </form>
                    </div>
</div>   
	<?php			
		}
	?>
                 
</div>