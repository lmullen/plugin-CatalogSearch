<?php

/**
 * Catalog Search Plugin
 *
 * @copyright Copyright 2013 Lincoln A. Mullen
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 *
 */

/**
 * The Catalog Search index controller class.
 *
 */
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

  public function addAction()
  {
    // Create a new page.
    $search = new CatalogSearchSearch;

    // Set the created by user ID.
    $this->view->form = $this->_getForm($search);
    $this->_processCatalogSearchForm($search, 'add');
  }

  public function editAction()
  {
    // Get the requested page.
    $search = $this->_helper->db->findById();
    $this->view->form = $this->_getForm($search);
    $this->_processCatalogSearchForm($search, 'edit');
  }

  protected function _getForm($search = null)
  {

    $formOptions = array('type' => 'catalog_search_search');
    if ($search && $search->exists()) {
      $formOptions['record'] = $search;
    }

    $form = new Omeka_Form_Admin($formOptions);

    $form->addElementToEditGroup(
      'text', 'catalog_name',
      array(
        'id' => 'catalog-search-catalog-name',
        'value' => $search->catalog_name,
        'label' => __('Catalog Name'),
        'description' => __('The name of the catalog (used as the text of the link)'),
        'required' => true
      )
    );

    $form->addElementToEditGroup(
      'text', 'query_string',
      array(
        'id' => 'catalog-search-query-string',
        'value' => $search->query_string,
        'label' => __('Query String'),
        'description' => __(
          'The query string is the URL of a search at the catalog, '
          . 'with the characters <code>%s</code> replacing the '
          . 'search terms. <br/> '
          . 'Example: <code>https://www.google.com/search?q=%s</code><br/> '
          . 'See <a href="http://chronicle.com/blogs/profhacker/how-to-hack-urls-for-faster-searches-in-your-browser/42304">this ProfHacker post</a> for help.'
        ),
        'required' => true
      )
    );

    $form->addElementToEditGroup(
      'checkbox', 'query_type',
      array(
        'id' => 'catalog-search-query-type',
        'checked' => $search->query_type,
        'values' => array(1, 0),
        'label' => __('Use simple query?'),
        'description' => __(
          'Check this to use simplified query terms for catalogs that '
          . 'are finicky or unsophisticated.'
        )
      )
    );

    $form->addElementToSaveGroup(
      'checkbox', 'display',
      array(
        'id' => 'catalog-search-display',
        'values' => array(1, 0),
        'checked' => $search->display,
        'label' => __('Display this link?'),
        'description' => __(
          'Checking this box will make the link to the catalog ' 
          . 'appear on public item pages.'
        )
      )
    );

    return $form;
  }

  private function _processCatalogSearchForm($search, $action)
  {
    if ($this->getRequest()->isPost()) {
      // Attempt to save the form if there is a valid POST. If the form 
      // is successfully saved, set the flash message, unset the POST, 
      // and redirect to the browse action.
      try {
        $search->setPostData($_POST);
        if ($search->save()) {
          if ('add' == $action) {
            $this->_helper->flashMessenger(__('The search "%s" has been added.', $search->catalog_name), 'success');
          } else if ('edit' == $action) {
            $this->_helper->flashMessenger(__('The search "%s" has been edited.', $search->catalog_name), 'success');
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
    $this->view->catalog_search_search = $search;
  }

  protected function _getDeleteSuccessMessage($record)
  {
    return __('The search "%s" has been deleted.', $record->catalog_name);
  }

}
?>
