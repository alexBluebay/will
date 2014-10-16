<?php
class Default_Form_Decorators_DecoratorAddLink extends Zend_Form_Decorator_Abstract
{
    public function render($content)
    {
        $element = $this->getElement();
        $name    = htmlentities($element->getFullyQualifiedName());
        $label   = htmlentities($element->getLabel());
        $id      = htmlentities($element->getId());
        $value   = htmlentities($element->getValue());
 
        $markup  = sprintf($this->getTemplate(), $name, $label);
        return $markup;
    }
    
    protected function buildInput()
    {
        $element = $this->getElement();
        $helper  = $element->helper;
            
        $inputName = $element->getFullyQualifiedName();
                
        return $element->getView()->$helper(
            $inputName,
       	    $element->getValue(),
            $element->getAttribs(),
            $element->options
        );
    }
    
    protected function buildErrors()
    {
        $element  = $this->getElement();
        $messages = $element->getMessages();
        $view = $element->getView();
        if (empty($messages)) {
            return '';
        }
        
        $formErrors = $view->getHelper('formErrors');
        $formErrors->setElementStart('<span class="help-block error" style="color: #b94a48;">')
                    ->setElementSeparator('')
                    ->setElementEnd('</span>');
        
        return $view->formErrors($messages);
    }
    
    public function getIdInput()
    {
    	$element = $this->getElement();
    	
    	return $element->getId();
    }
    
    
    protected function getTemplate(){

        $isErrors = $this->getElement()->getMessages();
        
        $var = '<dt id="'.$this->getIdInput().'-label"><label for="%s">%s</label></dt>';
        
      
        $var .= '<dd id="'.$this->getIdInput().'-element" '. (($isErrors) ? 'class="errors"' : '') .'>';
        
            $var .= $this->buildInput();

        
        $var .= $this->buildErrors();
        
        $var .= '</dd>';
        
        return $var;
    }
}