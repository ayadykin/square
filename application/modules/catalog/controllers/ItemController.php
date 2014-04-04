<?php

class Catalog_ItemController extends Zend_Controller_Action
{
  public function init()
  {
       $this->view->doctype('XHTML1_STRICT');
  }

  // action to display a catalog item
  public function displayAction()
  {
    // set filters and validators for GET input
    $filters = array('id' => array('HtmlEntities', 'StripTags', 'StringTrim'));    
    $validators = array('id' => array('NotEmpty', 'Int'));

    // test if input is valid retrieve requested record attach to view
    $input = new Zend_Filter_Input($filters, $validators);
    $input->setData($this->getRequest()->getParams());        
    if ($input->isValid()) {
      $q = Doctrine_Query::create()
            ->from('Square_Model_Item i')
            ->leftJoin('i.Square_Model_Country c')
            ->leftJoin('i.Square_Model_Grade g')
            ->leftJoin('i.Square_Model_Type t')
            ->where('i.RecordID = ?', $input->id);
      $result = $q->fetchArray();
      if (count($result) == 1) {
        $this->view->item = $result[0];                
      } else {
        throw new Zend_Controller_Action_Exception('Page not found', 404);        
      }
    } else {
      throw new Zend_Controller_Action_Exception('Invalid input');              
    }
  }
    // action to add a catalog item
  public function addAction(){
      $form = new Square_Form_AddCountry();
      $this->view->form = $form;      
      if ($this->getRequest()->isPost()) {
          $values = $form->getValues();
          
          $country = new Square_Model_Country();
          $country->CountryName = $values['countryName'];
          $this->view->id = $country->save();
          
          $this->_redirect('/catalog/add');
      }
  }
    public function generateAction(){
      $this->view->g = Doctrine::generateModelsFromDb('tmp', array('doctrine'), array('classPrefix' => 'Square_Model_'));
  }
}
