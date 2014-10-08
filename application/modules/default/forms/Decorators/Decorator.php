<?php

class Default_Form_Decorators_Decorator extends Zend_Form_Decorator_Abstract
{
    
    private $descriptionPlacement = 'APPEND';
    
    private $buildInputFullyQualifiedName = true;
    
    private $appendFile = null;
    
	public function buildLabel()
    {
        $element = $this->getElement();
        $label = $element->getLabel();

        if ($translator = $element->getTranslator()) {
            $label = $translator->translate($label);
        }
        if ($element->isRequired()) {
            $label .= '';
        }
        $label .= '';
        

        
        return $element->getView()
                       ->formLabel($element->getName(), $label, array(
                           'class' => 'control-label'
                       ));
    }
 
    public function buildInput()
    {
        $element = $this->getElement();
        $helper  = $element->helper;
        
        if( $this->buildInputFullyQualifiedName )
            $inputName = $element->getFullyQualifiedName(); 
        else 
            $inputName = $element->getName ();
        
        
        return $element->getView()->$helper(
            $inputName,
       	    $element->getValue(),
            $element->getAttribs(),
            $element->options
        );
    }
    
    public function getIdInput()
    {
    	$element = $this->getElement();
    	
    	return $element->getId();
    }
 
    public function buildErrors()
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
 
    public function buildDescription()
    {
        $element = $this->getElement();
        $desc    = $element->getDescription();
        if (empty($desc)) {
            return '';
        }
        //return '<div class="description">' . $desc . '</div>';
        return $desc;
    }
 
    public function render($content)
    {
        $element = $this->getElement();
        if (!$element instanceof Zend_Form_Element) {
            return $content;
        }
        if (null === $element->getView()) {
            return $content;
        }
 
        $separator = $this->getSeparator();
        $placement = $this->getPlacement();
        $label     = $this->buildLabel();
        $input     = $this->buildInput();
        $errors    = $this->buildErrors();
        $desc      = $this->buildDescription();
        
        $wrapperElementClasses = $this->getOption('wrapperElementClasses');
        
        
        $output  = '<div class="control-group ' . $this->getIdInput() . ' ' .$wrapperElementClasses.'">';
            $output .= $label;                    
        $output .= '<div class="controls">';     
            if($desc && $this->descriptionPlacement == 'PREPEND') {
                $output .= '<span class="desc" style="margin-left: 5px;">' . $desc . '</span>';
            }
            
            $output .= $input;
            
            if($desc && $this->descriptionPlacement == 'APPEND') {
                $output .= '<span class="desc" style="margin-left: 5px;">' . $desc . '</span>';
            }
            
            if($this->appendFile) {
                $view = new Zend_View();
                
                $view->setScriptPath(APPLICATION_PATH . '/modules/admin/views/scripts/_view_templates/form/');
                foreach($this->appendFile['params'] as $kParam => $vParam) {
                    $view->assign($kParam, $vParam);
                }
                $output .= $view->render($this->appendFile['fileLocation']);
            }
            
            $output .= $errors;
        $output .= '</div>';
        $output .= '</div>';
 
        switch ($placement) {
            case (self::PREPEND):
                return $output . $separator . $content;
                
            case (self::APPEND):
            default:
                return $content . $separator . $output;
        }
    }
    
    
    public function setDescriptionPlacement($placement)
    {
        if( !in_array($placement, array(
            'PREPEND',
            'APPEND'
        )) )
    throw new Exception('Desciption placement trebuie sa aiba una dintre valorile `PREPEND`, `APPEND`');
        
        $this->descriptionPlacement = $placement;
    }
    
    public function setBuildInputFullyQualifiedName($flag)
    {
        $this->buildInputFullyQualifiedName = (bool)$flag;
    }
    
    public function setAppendFile($fileLocation, $params = array()) {
        $this->appendFile = array(
            'fileLocation' => $fileLocation,
            'params' => $params
        );
    }
}