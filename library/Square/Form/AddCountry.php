<?php
class Square_Form_AddCountry extends Zend_Form
{
    public function init()
    {
        $this->setAction('/catalog/add')->setMethod('post');
        
       $name = new Zend_Form_Element_Text('countryName');
        $name->setLabel('Country:')
         ->setOptions(array('size' => '35'))
         ->setRequired(true)
         ->addValidator('NotEmpty', true)
         ->addValidator('Alpha', false, array('messages' => array(Zend_Validate_Alpha::NOT_ALPHA => 'Print characters')))            
         ->addFilter('HTMLEntities')            
         ->addFilter('StringTrim');       
        
        // create submit button
    $submit = new Zend_Form_Element_Submit('submit');
    $submit->setLabel('Add country')
           ->setOptions(array('class' => 'submit'));
        
        $this->addElement($name)
            ->addElement($submit);
    }
}