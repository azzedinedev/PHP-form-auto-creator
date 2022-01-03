<?php
//+---------------------------------------------------------------------+
//|	class.db.php														|
//+---------------------------------------------------------------------+
//|	Classe de gestion de la base de donnée								|
//|	Création de la classe par :											|
//|		SAR Azzeddine: azzedinedev@gmail.com							|
//|		Creation le : 04/04/2007										|
//+---------------------------------------------------------------------+
//|	Version 3 :															|
//|		* ajouter les balise de liste									|
//|		* Mise à jour du module de connection   						|
//+---------------------------------------------------------------------+
class db
{

	//Base de donn�e
	var $user;						//L'utilisateur de la base de donn�e
	var $pass;						//Le mot de passe de la base de donn�e
	var $host;						//Le serveur de base de donn�e
	var $connection;                                        //la connecion � la base de donn�ee
	var $id;						//L'identificateur de l'article
	var $db;						//La de la base de donn�e	
	var $_self;						//La page en cours

	var $DB_MSG_db_connection 		= "Il y a une erreur de connection avec la base de donn�e";
	var $DB_MSG_db_server_error             = "Il y a une erreur de connection au serveur de la base de donn�e";
	var $DB_MSG_db_selectDB_error           = "Il y a une erreur de selection de la base de donn�e";
	var $DB_MSG_db_sql_empty		= "Il faut sp�cifier la requ�te SQL";
	
	/**	
	 * db() :
	 * @desc Constructeur de la class eepad
	 * @param string $user : l'utilisateur de la base de donnée
	 * @param string $pass : Le mot de passe de l'utilisateur de la base de donn�e
	 * @param string $host : Le serveur de la base de donn�e
	 * @param string $db : Le nom de la base de donn�e
	**/	
	function db()
	{

		$this->id      		= NULL;
		$this->connection	= NULL;		
		$this->_self		= $_SERVER['PHP_SELF'];
									
		//Les textes pour DB
		$this->DB_MSG_db_connection 	= $GLOBALS["webvars"]["DB_MSG_db_connection"] ;
		$this->DB_MSG_db_server_error 	= $GLOBALS["webvars"]["DB_MSG_db_server_error"];
		$this->DB_MSG_db_selectDB_error	= $GLOBALS["webvars"]["DB_MSG_db_selectDB_error"];
		$this->DB_MSG_db_sql_empty	= $GLOBALS["webvars"]["DB_MSG_db_sql_empty"];
		
		return;
	}
        
    /**
	 * loadDBconnection($dbconnection):
         * @param $dbconnection : connection à la base de donnée
	 * Fonction permettant la connection à la base de donnée à partir d'une connection
         * added : 27 09 2011
	**/
	function loadDBconnection($dbconnection)
	{   
            $this->connection  = $dbconnection;
	}
        
	/**
	 * connectDB():
	 * Fonction permettant la connection à la base de donnée à partir des parmetres de connection
	**/
	function connectDB($user,$pass,$host,$db)
	{
		$this->user    		= $user;
		$this->pass    		= $pass;
		$this->host    		= $host;
		$this->db    		= $db;
				
		$this->connection = @mysql_connect($this->host,$this->user,$this->pass) or 
			die($this->DB_MSG_db_server_error.": {$this->host}");
		@mysql_select_db($this->db,$this->connection) or
			die($this->DB_MSG_db_selectDB_error.": {$this->db}");
		return;
	}

	/**
	 * deconnectDB():
	 * Fonction permettant la deconnection � la base de donn�e
	**/
	function deconnectDB()
	{
		if( $this->connection != NULL ){
                    mysql_close($this->connection);
		}
		return;
	}
	
    /**
     * Escapes a string according to the current DBMS's standards
     * @param string $str  the string to be escaped
     * @return string  the escaped string
    **/
    function escapeDB($str)
    {
        if (function_exists('mysql_real_escape_string')) {
            return @mysql_real_escape_string($str, $this->connection);
        } else {
            return @mysql_escape_string($str);
        }

    }

	/**
     * stripslashes of string from DB
     * @param string $str  the string to be escaped
     * @return string  the escaped string
    **/
	function stripDB($str)
    {
        return nl2br(stripslashes($str));
		//return utf8_encode(nl2br(stripslashes($str)));        
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
	 * DB_res($sql)
	 * function publique : appeller et ex�cuter la requ�te SQL
	 * @param string $sql la requ�te sql
	**/
   	function DB_res($sql,$die)
    {
    	//echo "<br /><br /><br /><br /><br /><br /><br /><br />".$sql."<br />";
		if( $this->connection == NULL ){
			echo $this->DB_MSG_db_connection; //"il faut se connecter � la base de donn�e";
			return "SQL error";
		}else{
			if( !empty($sql) ){
				if( $die == "" ){
					$res = mysql_query($sql,$this->connection);
				}else{
					$res = mysql_query($sql,$this->connection) or die($die);
				}
				return "SQL succes";
			}else{
				echo $this->DB_MSG_db_sql_empty;
			}
		}
		
    }
	
	/**
	 * DB_fetch($sql)
	 * function publique : rendre un tableau r�sultant de la req�te sp�cifi� dans ($sql) apres une seule operation d'apelle sql
	 * @param string $sql la requ�te sql
	 * @return array : un tableau r�sultant de la req�te sp�cifi� dans ($sql)
	**/
   	function DB_fetch($sql)
    {
		$row = array();
		if( $this->connection == NULL ){
			echo $this->DB_MSG_db_connection; //"il faut se connecter � la base de donn�e";
		}else{
			if( !empty($sql) ){
				$res = mysql_query($sql,$this->connection);
				$row = mysql_fetch_array($res);
			}else{
				echo $this->DB_MSG_db_sql_empty;
			} 
		}
		return $row;
    }
	
	/**
	 * DB_fetch_list($sql)
	 * function publique : rendre une liste de tableau r�sultant de la req�te sp�cifi� dans ($sql)
	 * @param string $sql la requ�te sql
	 * @return array : un tableau r�sultant de la req�te sp�cifi� dans ($sql)
	**/
   	function DB_fetch_list($sql)
    {
    	$list = array();
		if( $this->connection == NULL ){
			echo $this->DB_MSG_db_connection; //"il faut se connecter � la base de donn�e";
		}else{		
			
			if( !empty($sql) ){
				$list = array();
				$res = mysql_query($sql,$this->connection);
				
				while ($row = mysql_fetch_array($res)){
					$list[] = $row;
				}	
			}else{
				echo $this->DB_MSG_db_sql_empty;
			}
			
		}
		return $list;
    }
	
	/**
	 * DB_fetch_list($sql)
	 * function publique : rendre une liste de tableau r�sultant de la req�te sp�cifi� dans ($sql)
	 * @param string $sql la requ�te sql
	 * @return array : un tableau r�sultant de la req�te sp�cifi� dans ($sql)
	**/
   	function DB_num_rows($sql)
    {
		if( $this->connection == NULL ){
			echo $this->DB_MSG_db_connection; //"il faut se connecter � la base de donn�e";
		}else{		
			$num = 0;
			if( !empty($sql) ){
				$res = mysql_query($sql,$this->connection);
				$num = mysql_num_rows($res);
			}else{
				echo $this->DB_MSG_db_sql_empty;
			}
		}
		return $num;
    }	
    
    /**
     * DB_insert_id()
     * function publique : rendre une liste de tableau r�sultant de la req�te sp�cifi� dans ($sql)
     * @param string $sql la requ�te sql
     * @return array : un tableau r�sultant de la req�te sp�cifi� dans ($sql)
    **/
    function DB_insert_id()
    {
        return mysql_insert_id($this->connection);	
    }		

}//End Of Form Class 
?>