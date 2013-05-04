<?php 

class CatalogSearch_SearchController extends Omeka_Controller_AbstractActionController
{
  public function showAction()
  {
    $searchId = $this->_getParam('id');
    $search = $this->_helper->db->getTable('CatalogSearchSearch')->find($searchId);

    $this->view->catalog_search_search = $search;
 
  }

}
 
?>
