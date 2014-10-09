<?php


class Admin_Form_Advertising extends Zend_Form {
    
    
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
        $advModel = new Admin_Model_Components_AdvertisingModel();
        $advArray = $advModel->AdvertisingBuildSelect();
        
        $element = new Zend_Form_Element_Select('layoutType', array(
            'label' => 'Layout:'
        ));
        
        
        
        $element->addDecorator($decorator);
        $element->addMultiOptions(array(null => 'Selecteaza!') + $advArray);   
        $element->setRequired(true);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Selecteaza tipul reclamei');
        $this->addElement($element);
        
        
        
        $element = new Zend_Form_Element_Text('title', array(
            'label' => 'Tiltu:',
            'placeholder' => 'Titlu reclama'
        ));
        $element->addDecorator($decorator);
        $element->setRequired(true);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Adauga numele reclamei');
        $this->addElement($element);
        
        
        
        
        $element = new Zend_Form_Element_Textarea('advCode', array(
            'label' => 'Cod reclama:',
            'rows' => '6',
            'placeholder' => 'Cod reclama'
            
        ));
        $element->addDecorator($decorator);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Scrie codul pentru reclama');
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