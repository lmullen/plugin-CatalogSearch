<?php 

/**
 * Catalog Search Plugin
 *
 * @copyright Copyright 2013 Lincoln A. Mullen
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 *
 */

/**
 * The Catalog Search search controller class.
 */
class CatalogSearch_SearchController extends Omeka_Controller_AbstractActionController
{

  public function showAction()
  {
    // Get the search object from the passed id.
    $searchId = $this->_getParam('id');
    $search = $this->_helper->db->getTable('CatalogSearchSearch')->find($searchId);

    // Set the view.
    $this->view->catalog_search_search = $search;
  }

}
?>
