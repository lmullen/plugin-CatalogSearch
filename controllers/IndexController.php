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

    public function editAction()
    {
      // Get the requested page.
      $search = $this->_helper->db->findById();
      $this->view->form = $this->_getForm($search);
      $this->_processSearchForm($search, 'edit');
    }

    protected function _getForm($search = null)
    {
      return $form;
    }

    private function _processSearchForm($search, $action)
    {
        if ($this->getRequest()->isPost()) {
            // Attempt to save the form if there is a valid POST. If the form 
            // is successfully saved, set the flash message, unset the POST, 
            // and redirect to the browse action.
            try {
                $search->setPostData($_POST);
                if ($search->save()) {
                    if ('add' == $action) {
                        $this->_helper->flashMessenger(__('The search "%s" has been added.', $page->title), 'success');
                    } else if ('edit' == $action) {
                        $this->_helper->flashMessenger(__('The search "%s" has been edited.', $page->title), 'success');
                    }

                    $this->_helper->redirector('browse');
                    return;
                }
            // Catch validation errors.
            } catch (Omeka_Validate_Exception $e) {
                $this->_helper->flashMessenger($e);
            }
        }


    // Set the page object to the view.
    $this->view->simple_pages_page = $page;

    }


}
