<?php 

/**
 * Catalog Search Plugin
 *
 * @copyright Copyright 2013 Lincoln A. Mullen
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 *
 */

/**
 * The Catalog Search search table class.
 */
class CatalogSearchSearchTable extends Omeka_Db_Table
{
  /**
   * Get all the catalog searches that are set to be displayed, ordered 
   * alphabetically by the catalog name.
   */
  public function getAllCatalogSearches()
  {
    $select = $this->getSelectForFindBy(array('display' => '1'))->order('catalog_name');
    return $this->fetchObjects($select);
  }

}
?>
