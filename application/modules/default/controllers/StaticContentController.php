<?php

class StaticContentController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function displayAction()
    { 
        $page = $this->getRequest()->getParam('page');
        if(file_exists($this->view->getScriptPath(null) . "/" . $this->getRequest()->getControllerName() .
            "/$page." . $this->viewSuffix)){
            $this->render($page);
        }else{
            throw new Zend_Controller_Action_Exception("My Erro page", 404);
        }
    }
}