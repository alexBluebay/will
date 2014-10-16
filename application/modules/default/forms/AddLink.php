<?php

class Default_Form_AddLink extends Zend_Form {
    
    
    public function init()
    {
        $inputClass = 'form-control';
        $this->setMethod('post');
        $this->setAction('');
        $this->setAttribs(array(
            'class' => 'form-horizontal',
            'role' => 'form'
        ));
                
        $decorator = new Default_Form_Decorators_DecoratorAddLink();
        if (!isset($_SESSION['captha']) || !isset($_POST['captainPlanet'])){
            $_SESSION['captha'] = rand(1000,9999);
        }
        
        $catModel = new Default_Model_Components_Categorii();
        $catArray = $catModel->getCategoriiStructure();
        
        // start definire validatoare
        $emailAddress = new Zend_Validate_EmailAddress();                
        
        $urlUnique = new Zend_Validate_Db_NoRecordExists(
            array(
                    'table' => 'links',
                    'field' => 'url'
                )
            );
        $urlUnique->setMessage('Url-ul a mai fost definit in director.');
        
        $notEmpty = new Zend_Validate_NotEmpty();
        $notEmpty->setMessage('Specificati link.');
        
        
        $isEqual = new Zend_Validate_Identical();

      
        $isEqual->setToken( $_SESSION['captha'] );
        $isEqual->setStrict(false);
        $isEqual->setMessage('Codul din imagine nu este corect!');
       
        
        // Tipul Linkului

//        $element = new Zend_Form_Element_Select('type', array(
//            'label' => 'Tip link:'
//        ));
//        $element->addDecorator($decorator);
//        $element->addMultiOptions(array(
//            'basic' => 'Basic',
//            'exchange' => 'Schimb de link'
//        ));
//        $element->setAttrib('class', $inputClass);
//        $element->addErrorMessage('Valoare invalida');
//        $this->addElement($element);
        
                                // Selector Categorii
        
        $element = new Zend_Form_Element_Select('category', array(
            'label' => 'Categorie:'
        ));                        
        $element->addDecorator($decorator);
        $element->addMultiOptions($catArray);
        $element->setRequired(true);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Selecteaza o categorie');
        $this->addElement($element);
        
                                // adresa URL 

        $element = new Zend_Form_Element_Text('url', array(
            'label' => 'URL:   (ex: www.1store.ro)'
        ));
        $element->addDecorator($decorator);
        $element->setAttrib('class', $inputClass);
        
        $element->setRequired()->addValidator($notEmpty, true);
        $element->addValidator($urlUnique, true);
        
        $element->addFilters(array('StringTrim', 'StripTags'));  
        $this->addElement($element);
        
                                //  Title

        $element = new Zend_Form_Element_Text('title', array(
            'label' => 'Titlu:    (max 50 caractere)',            
        ));
        $element->addDecorator($decorator);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Scrie titlul ');
        $element->setRequired(true);
        $element->addFilters(array('StringTrim', 'StripTags'));  
        $this->addElement($element);
        
                                //  Email

        $element = new Zend_Form_Element_Text('email', array(
            'label' => 'eMail:'
        ));
        $element->addValidator($emailAddress);
        $element->addFilters(array('StringTrim'));
        $element->addDecorator($decorator);
        $element->setAttrib('class', $inputClass);
        $element->setRequired(true);
        $element->addErrorMessage('Trebuie sa introduci o adresa de email valida');
        $this->addElement($element);
        
                                // Descriere scurta

        $element = new Zend_Form_Element_Textarea('short', array(
            'label' => 'Descriere scurta:    (max 350 caractere)',
            'rows' => '6'
            
        ));       
        $element->addDecorator($decorator);
        $element->setAttrib('class', $inputClass);
        $element->setRequired(true);        
        $element->addErrorMessage('Scrie o descriere scurta');
        $element->addFilters(array('StringTrim', 'StripTags'));        
        $this->addElement($element);
        
                                // Descriere lunga

        $element = new Zend_Form_Element_Textarea('long', array(
            'label' => 'Descriere: (max 1000 caractere)',
            'rows' => '6'
        ));
        $element->addDecorator($decorator);
        $element->setAttrib('class', $inputClass);
        $element->setRequired(true);
        $element->addFilters(array('StringTrim', 'StripTags'));  
        $element->addErrorMessage('Descrie site-ul tau');
        $this->addElement($element);
                                        
                                // keywords

        $element = new Zend_Form_Element_Textarea('keywords', array(
            'label' => 'Cuvinte cheie: (separate prin virgula)',
            'rows' => '2'
        ));
        $element->addDecorator($decorator);
        $element->setAttrib('class', $inputClass);
        $element->addFilters(array('StringTrim', 'StripTags'));  
        $element->addErrorMessage('Scrie cuvintele cheie');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Hidden('linkType', array(
            'value' => '0',
            'id' => 'linkType'
        ));
        $element->addDecorator($decorator);
        $element->addFilters(array('StringTrim', 'StripTags'));
        $this->addElement($element);
        
              
        $element = new Zend_Form_Element_Text('captainPlanet', array(
            'label' => "Scrie codul : <img src='/captcha'>",
            'placeholder' => 'Scrie codul din imaginea alaturata aici',
            'id' => 'linkType'
        ));
        
       
        $element->addDecorator('label', array('escape' => false) );
        $element->setRequired(true);
        $element->addFilters(array('StringTrim', 'StripTags'));  
        
        $element->addValidator($isEqual);
        
        //$element->addErrorMessage('Scrie codul din imagine');
        $element->setAttrib('class', $inputClass);
        $this->addElement($element);
        //
        $element = new Zend_Form_Element_Checkbox('agree', array(
            'label' => 'Sunt de acord cu Termeni si Conditii'
            
        ));
        $element->setCheckedValue(1);
        $element->setUncheckedValue(0);
        $element->addDecorator($decorator);
        $element->addValidator(new Zend_Validate_InArray(array(1)), true);
        $element->setRequired(true); 
        $element->addErrorMessage('bifeaza-ma');
        $this->addElement($element);
                                // Buton Submit

        $element = new Zend_Form_Element_Button('sendData', array(
            'label' => 'ADAUGA',
             'type' => 'submit'
        ));
//        $element->addDecorator($decorator);
        $element->setAttrib('class', 'btn btn-default');
        $this->addElement($element);
        
        
        
    }
    
    
    
}