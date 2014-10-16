<?php


class Admin_Form_SearchForm extends Zend_Form {
    
    
    public function init()
    {
        $inputClass = 'form-control';
        $this->setMethod('post');
        $this->setAction('');
        $this->setAttribs(array(
            'class' => 'form-inline text-center',
            'method' => 'get',
            'role' => 'form'
        ));
                
        $decorator = new Admin_Form_Decorators_LinkSearchDecorator();
        
        $catModel = new Admin_Model_Components_Links();
        $catArray = $catModel->getCategoriesStructure();
        $enumArray = $catModel->linkTypeStructure();
        
       
        
        $element = new Zend_Form_Element_Select('category', array(
            'label' => 'Categorie:'
        ));
        
                
        $element->addDecorator($decorator);
        $element->addMultiOptions(array(
            '' => 'Selecteaza  categorie'
        ) + $catArray);
        $element->setAttrib('class', $inputClass);
        $this->addElement($element);
        
        
        $element = new Zend_Form_Element_Select('type', array(
            'label' => 'Tip link:'
        ));
        $element->addDecorator($decorator);
        $element->addMultiOptions(array(
            '' => 'Tip link'
            ) + $enumArray
            );
        $element->setAttrib('class', $inputClass);
        $this->addElement($element);
        
        
        $element = new Zend_Form_Element_Text('search', array(
            'placeholder' => 'Titlu'
        ));
        $element->addDecorator($decorator);
        $element->setAttrib('class', $inputClass);

        $this->addElement($element);
        
        
        $element = new Zend_Form_Element_Text('keys', array(
            'placeholder' => 'cuvinte cheie',            
        ));
        $element->addDecorator($decorator);
        $element->setAttrib('class', $inputClass);
        $this->addElement($element);
        
        
        
         $element = new Zend_Form_Element_Button('s', array(
            'label' => 'Cauta',
             'type' => 'submit'
        ));
        $element->addDecorator($decorator);
        $element->setAttrib('class', 'btn btn-default');
        $this->addElement($element);
        
    }
    
    
    
}