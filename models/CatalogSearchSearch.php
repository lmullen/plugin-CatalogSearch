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
  public $editable;

}

