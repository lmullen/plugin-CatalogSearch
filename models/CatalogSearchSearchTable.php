<?php 

/*
 * Catalog Search Plugin for Omeka
 *
 * */

class CatalogSearchSearchTable extends Omeka_Db_Table
{

  // Get all the catalog searches that are set to be displayed, ordered 
  // alphabetically by the catalog name.
  public function getAllCatalogSearches()
  {
    $select = $this->getSelectForFindBy(array('display' => '1'))->order('catalog_name');
    return $this->fetchObjects($select);
  }

}
?>

