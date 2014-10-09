<?php


class Admin_Form_Pages extends Zend_Form {
    
    
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
        
        $catModel = new Admin_Model_Components_PagesModel();
        $catArray = $catModel->PagesBuildSelect();
        
       
        
        $element = new Zend_Form_Element_Select('type', array(
            'label' => 'Tip pagina:'
        ));
        
        
        
        $element->addDecorator($decorator);
        $element->addMultiOptions(array(null => 'Selecteaza tip') + $catArray);   
        $element->setRequired(true);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Selecteaza tipul paginii');
        $this->addElement($element);
        
        
        
        $element = new Zend_Form_Element_Text('metaTitle', array(
            'label' => 'Titlu meta:',
            'placeholder' => 'Tag meta title head'
        ));
        $element->addDecorator($decorator);
        $element->setRequired(true);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Scrie un titlu meta (tag in head)');
        $this->addElement($element);
        
        
        $element = new Zend_Form_Element_Text('metaKeys', array(
            'label' => 'Keyword meta:',
            'placeholder' => 'Tag meta keyword head'
        ));
        $element->addDecorator($decorator);
        $element->setRequired(true);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Scrie keywords meta (tag in head)');
        $this->addElement($element);
        
        
        $element = new Zend_Form_Element_Textarea('descriptionMeta', array(
            'label' => 'Descriere meta:',
            'rows' => '4',
            'placeholder' => 'Descriere meta head'
            
        ));
        $element->addDecorator($decorator);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Adauga o descriere meta (pentru head)');
        $this->addElement($element);
        
        
        $element = new Zend_Form_Element_Textarea('pageContent', array(
            'label' => 'Continut pagina:',
            'rows' => '7',
            'placeholder' => 'Continutul paginii'
            
        ));
        $element->addDecorator($decorator);
        $element->setAttrib('class', $inputClass);
        $element->addErrorMessage('Scrie continutul paginii!!!');
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