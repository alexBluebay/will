<?php


class Admin_Form_Categories extends Zend_Form {
    
    
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
        
        $catModel = new Admin_Model_Components_CategoryModel();
        $catArray = $catModel->CategoriesBuildSelect();
        
       
        
        $element = new Zend_Form_Element_Select('category', array(
            'label' => 'Categorie:'
        ));
        
        
        
        $element->addDecorator($decorator);
        $element->addMultiOptions(array(null => 'Este Parinte!') + $catArray);   
        //$element->setRequired(true);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Selecteaza o categorie');
        $this->addElement($element);
        
        
        
        $element = new Zend_Form_Element_Text('CatName', array(
            'label' => 'Nume:',
            'placeholder' => 'Nume categorie'
        ));
        $element->addDecorator($decorator);
        $element->setRequired(true);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Agauga numele categoriei');
        $this->addElement($element);
        
        
        
        
        $element = new Zend_Form_Element_Textarea('description', array(
            'label' => 'Descriere:',
            'rows' => '6',
            'placeholder' => 'Descriere'
            
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