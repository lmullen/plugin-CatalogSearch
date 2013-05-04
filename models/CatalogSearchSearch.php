<?php

/*
 * Catalog Search Plugin for Omeka 
 *
 * */

/*
 * The Catalog Search search record class
 *
 * */
class CatalogSearchSearch extends Omeka_Record_AbstractRecord
{

  public $query_string;
  public $catalog_name;
  public $display;
  public $query_type;

  public function getRecordUrl($action = 'show')
  {
    if ('show' == $action) {
      return public_url($this->slug);
    }
    return array('module' => 'catalog-search', 'controller' => 'index', 
      'action' => $action, 'id' => $this->id);
  }

}

