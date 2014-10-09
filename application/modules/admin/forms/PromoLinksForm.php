<?php


class Admin_Form_PromoLinksForm extends Zend_Form {
    
    
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
        $PromoLinksModel = new Admin_Model_Components_PromoLinkModel();
        $PromoLinksArray = $PromoLinksModel->enumBuildSelect();
        
        $element = new Zend_Form_Element_Select('layout', array(
            'label' => 'Layout:'
        ));
        
        
        
        $element->addDecorator($decorator);
        $element->addMultiOptions(array(null => 'Selecteaza!') + $PromoLinksArray);   
        $element->setRequired(true);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Selecteaza tipul linkului');
        $this->addElement($element);
        
        
        $element = new Zend_Form_Element_Text('title', array(
            'label' => 'Tiltu:',
            'placeholder' => 'Titlu link'
        ));
        $element->addDecorator($decorator);
        $element->setRequired(true);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Adauga titlul linkului');
        $this->addElement($element);
        
        
        $element = new Zend_Form_Element_Text('url', array(
            'label' => 'URL:',
            'placeholder' => 'Adresa URL'
        ));
        $element->addDecorator($decorator);
        $element->setRequired(true);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Adauga adresa URL');
        $this->addElement($element);
        
        
        $element = new Zend_Form_Element_Textarea('desc', array(
            'label' => 'Descriere:',
            'rows' => '6',
            'placeholder' => 'Descriere link'
            
        ));
        $element->addDecorator($decorator);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Adauga o descriere');
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