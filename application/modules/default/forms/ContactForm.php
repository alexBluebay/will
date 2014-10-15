<?php

class Default_Form_ContactForm extends Zend_Form {
    
    
    public function init()
    {
        $inputClass = 'form-control';
        $this->setMethod('post');
        $this->setAction('');
        $this->setAttribs(array(
            'class' => 'form-horizontal',
            'role' => 'form'
        ));
                
        //$decorator = new Default_Form_Decorators_Decorator();

        
        // start definire validatoare
        $emailAddress = new Zend_Validate_EmailAddress();
        
        
        $element = new Zend_Form_Element_Text('name', array(
            'label' => 'Nume:'
        ));
//        $element->addDecorator($decorator);
        $element->setAttrib('class', $inputClass);
        
        $element->setRequired(true);
        $element->addFilters(array('StringTrim', 'StripTags'));  
        $this->addElement($element);
        
        //  Email

        $element = new Zend_Form_Element_Text('email', array(
            'label' => 'eMail:'
        ));
        $element->addValidator($emailAddress);
        $element->addFilters(array('StringTrim'));
//        $element->addDecorator($decorator);
        $element->setAttrib('class', $inputClass);
        $element->setRequired(true);
        $element->addErrorMessage('Trebuie sa introduci o adresa de email valida');
        $this->addElement($element);
        
       

        $element = new Zend_Form_Element_Text('phone', array(
            'label' => 'Telefon:',            
        ));
//        $element->addDecorator($decorator);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Scrie titlul ');
        $element->setRequired(true);
        $element->addFilters(array('StringTrim', 'StripTags'));  
        $this->addElement($element);
        

        $element = new Zend_Form_Element_Textarea('message', array(
            'label' => 'Mesaj:',
            'rows' => '6'
        ));
//        $element->addDecorator($decorator);
        $element->setAttrib('class', $inputClass);
        $element->setRequired(true);
        $element->addFilters(array('StringTrim', 'StripTags'));  
        $element->addErrorMessage('Scrie mesajul');
        $this->addElement($element);
        

        $element = new Zend_Form_Element_Button('sendData', array(
            'label' => 'Trimite mesaj',
             'type' => 'submit'
        ));
//        $element->addDecorator($decorator);
        $element->setAttrib('class', 'btn btn-default');
        $this->addElement($element);
        

        
    }
    
    
    
}