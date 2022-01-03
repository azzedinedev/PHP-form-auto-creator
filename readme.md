<h3 align="center">PHP form auto creator</h3>

---

<p align="center"> The form creator in PHP is autamatic and any input can be created in one line with all validations and configuartion prerequies
    <br> 
</p>

# How to use it

## Dependencies

Database class class.db.php an ORM based on this version on MySql


## Example to creation of forms / Exemple de Création du formulaire : 

```

$this->openForm("html_qcm", $this->form_action, $this->form_method);           

$this->openFieldset($this->txt_HTMLInsertQCM_1);

$this->addHTMLForms("formation_qcm",$this->txt_HTMLInsertQCM_2,"text",$this->stripDB($this->request["formation_qcm"]),"","notempty","","");             |

$this->closeFieldset();                                                                                  

$this->openFieldset($this->txt_HTMLInsertQCM_3); 

$this->addHTMLForms("titre_qcm",$this->txt_HTMLInsertQCM_4,"text",$this->stripDB($this->request["titre_qcm"]),"","notempty", $this->txt_HTMLInsertQCM_Aide_4,"");     
$this->addHTMLForms("description_qcm",$this->txt_HTMLInsertQCM_5,"text",$this->stripDB($this->request["description_qcm"]),"","notempty", $this->txt_HTMLInsertQCM_Aide_5,"");     

$this->closeFieldset();                                                         

$this->openFieldset($this->txt_HTMLInsertQCM_6);                                            

$this->addHTMLForms("debut_qcm",$this->txt_HTMLInsertQCM_7,"text",$this->stripDB($this->request["debut_qcm"]),"","date",$this->txt_HTMLInsertQCM_Aide_7,"");
$this->addHTMLForms("fin_qcm",$this->txt_HTMLInsertQCM_8,"text",$this->stripDB($this->request["fin_qcm"]),"","date",$this->txt_HTMLInsertQCM_Aide_8,"");
$this->addHTMLForms("duree_qcm",$this->txt_HTMLInsertQCM_9,"text",$this->stripDB($this->request["duree_qcm"]),"","number", $this->txt_HTMLInsertQCM_Aide_9,"");

$this->closeFieldset();

$this->showSubmit($this->fieldSubmit,$this->labelSubmit);
$this->showReset($this->fieldReset,$this->labelReset);

$this->closeForm(); 
 
```

## Example to process the form validation  / Exemple de traitement de la validation du formulaire :

### Example to use for function call / Exemple d'utilisation de l'appel de fonction :

```
$this->onSucces(array("fonction", array(array("a" => 15, "b" => 15),'if($a == 15){ $c = $a/2;} return ($c*2)+$b;')));
```

### Example to use for XML show / Exemple d'utilisation de l'affichage du contenue XML :

```
$this->onSucces(array("xmlshow")); 
```
