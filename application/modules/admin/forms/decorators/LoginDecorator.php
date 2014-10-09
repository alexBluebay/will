<?php
class Admin_Form_Decorators_LoginDecorator extends Admin_Form_Decorators_DefaultDecorator
{
    
    protected function getTemplate(){
        $var = '<div class="form-group">
            <div class="col-sm-10">';
        
        $var .= $this->buildInput();
        
        $var .= $this->buildErrors();
        
        $var .= '</div>
        </div>';
        
        return $var;
    }
}