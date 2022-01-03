/**
 * This file is JavaScript functions of form class
 * @name js-form.php
 * @author SARIRETE Azzeddine
 * @copyright azzedinedev@gmail.com - 12 SEP 2011
 * @access Private
 * @license free
 * @version 1.0
 */

function replace_string(chaine,str_mask,str_replace){
    var reg=new RegExp("("+str_mask+")", "g");
    var replaed = chaine.replace(reg,str_replace);
    return replaed;
}

function compteur(maxLength,elementId,elementReplaceId,chaine,str_mask) {
    var text        = document.getElementById(elementId).value;  
    var val_replace = maxLength-text.length;
    var str_replace = val_replace+"/"+maxLength;   
    var reg         = new RegExp("("+str_mask+")", "g");
    var replaced    = chaine.replace(reg,str_replace);    
    document.getElementById(elementReplaceId).innerHTML=replaced;
} 

function checkMaxLength(e,element_id,maxLength){
 if(e.which==118){return false;}else{   
    var text=document.getElementById(element_id).value;
     if(maxLength - text.length > 0){
        return true;
     }else{
        if(e.which==0 || e.which==8){
            return true;
        }else{
            return false;
        }
     }
 }
}