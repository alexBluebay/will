<?php
class Admin_Form_Decorators_DefaultDecorator extends Zend_Form_Decorator_Abstract
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
    
    protected function getTemplate(){
        
        $var = '<div class="form-group">
        <label for="%s" class="col-sm-2 control-label">%s</label>
            <div class="col-sm-10">';
        
        $var .= $this->buildInput();
        
        $var .= $this->buildErrors();
        
        $var .= '</div>
        </div>';
        
        return $var;
    }
}