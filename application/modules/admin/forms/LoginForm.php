<?php


class Admin_Form_LoginForm extends Zend_Form {
    
    public function init()
    {
        $inputClass = 'form-control';
        $this->setMethod('post');
        $this->setAction('');
        $this->setAttribs(array(
            'class' => 'form-horizontal',
            'role' => 'form'
        ));
                
        $decorator = new Admin_Form_Decorators_LoginDecorator();        
        $valStrlLen = new Zend_Validate_StringLength(array('min' => 3));
        
        
        $element = new Zend_Form_Element_Text('usrName', array(
            'placeholder' => 'Nume utilizator'
        ));
        $element->addDecorator($decorator);
        $element->setRequired(true);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Adauga numele de utilizator');
        $this->addElement($element);
        
        
        
        
        $element = new Zend_Form_Element_Password('passwrd', array(
            'placeholder' => 'Parola'            
        ));
        $element->addValidator($valStrlLen);
        $element->addDecorator($decorator);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Adauga o parola');
        $this->addElement($element);
        
        
         $element = new Zend_Form_Element_Button('sendData', array(
            'label' => 'Trimite',
             'type' => 'submit'
        ));
        $element->addDecorator($decorator);
        $element->setAttrib('class', 'btn btn-default');
        $this->addElement($element);
        
    }
    
}