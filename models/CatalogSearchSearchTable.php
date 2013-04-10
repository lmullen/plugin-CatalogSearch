<?php 

/*
 * Catalog Search Plugin for Omeka
 *
 * */

class CatalogSearchSearchTable extends Omeka_Db_Table
{

  // Get all the catalog searches, ordered alphabetically by the catalog 
  // name.
  public function getAllCatalogSearches()
  {
    $select = $this->getSelect()->order('catalog_name');
    return $this->fetchObjects($select);
  }

}
?>

