<?php

class CatalogSearch_IndexController extends Omeka_Controller_AbstractActionController
{    

    public function init()
    {
        // Set the model class so this controller can perform some functions, 
        // such as $this->findById()
        $this->_helper->db->setDefaultModelName('CatalogSearchSearch');
    }
    
    public function indexAction()
    {
        // Always go to browse.
        $this->_helper->redirector('browse');
        return;
    }
    
}
