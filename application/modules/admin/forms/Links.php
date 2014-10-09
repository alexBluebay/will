<?php


class Admin_Form_Links extends Zend_Form {
    
    
    public function init()
    {
        $inputClass = 'form-control';
        $this->setMethod('post');
        $this->setAction('');
        $this->setAttribs(array(
            'class' => 'form-horizontal',
            'role' => 'form'
        ));
                
        $decorator = new Admin_Form_Decorators_DefaultDecorator();
        
        $catModel = new Admin_Model_Components_Links();
        $catArray = $catModel->getCategoriesStructure();
        
       
        
        $element = new Zend_Form_Element_Select('category', array(
            'label' => 'Categorie:'
        ));
        
                
        $element->addDecorator($decorator);
        $element->addMultiOptions($catArray);   
        $element->setRequired(true);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Selecteaza o categorie');
        $this->addElement($element);
        
        
        $element = new Zend_Form_Element_Text('url', array(
            'label' => 'URL:'
        ));
        $element->setRequired(true);
        $element->addDecorator($decorator);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Valoare invalida');

        $this->addElement($element);
        
        
        $element = new Zend_Form_Element_Text('title', array(
            'label' => 'Titlu:',            
        ));
        $element->setRequired(true);
        $element->addDecorator($decorator);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Valoare invalida');
        $this->addElement($element);
        
        
        $element = new Zend_Form_Element_Text('email', array(
            'label' => 'eMail:'
        ));
        $element->addDecorator($decorator);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Valoare invalida');
        $this->addElement($element);
        
        $element = new Zend_Form_Element_Textarea('short', array(
            'label' => 'Descriere scurta:',
            'rows' => '6'
            
        ));
        $element->addDecorator($decorator);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Valoare invalida');
        $this->addElement($element);
        
        
        $element = new Zend_Form_Element_Textarea('long', array(
            'label' => 'Descriere:',
            'rows' => '6'
        ));
        $element->addDecorator($decorator);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Valoare invalida');
        $this->addElement($element);
        
        
        $element = new Zend_Form_Element_Select('type', array(
            'label' => 'Tip link:'
        ));
        $element->addDecorator($decorator);
        $element->addMultiOptions(array(
            'basic' => 'Basic',
            'exchange' => 'Schimb de link'
        ));
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Valoare invalida');
        $this->addElement($element);
        
        
        $element = new Zend_Form_Element_Select('status', array(
            'label' => 'Activ:'
        ));
        $element->addMultiOptions(array(
            'N' => 'NU',
            'Y' => 'DA'
        ));
        $element->addDecorator($decorator);
        $element->setAttrib('class', $inputClass);
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