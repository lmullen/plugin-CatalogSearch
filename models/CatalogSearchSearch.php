<?php

/**
 * Catalog Search Plugin
 *
 * @copyright Copyright 2013 Lincoln A. Mullen
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 *
 */

/*
 * The Catalog Search search record class.
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

  /**
   * Validate form input.
   */
  protected function _validate()
  {
    if (empty($this->catalog_name)) {
      $this->addError('catalog_name', __('The catalog must be given a name.'));
    }

    if (255 < strlen($this->catalog_name)) {
      $this->addError('catalog_name', __('The catalog name must be 255 characters or fewer'));
    }

    if (255 < strlen($this->query_string)) {
      $this->adderror('query_string', __('The query string must be 255 characters or fewer.'));
    }

    if (!strpos($this->query_string, '%s')) {
      $this->adderror('query_string', __('The query string must contain %s.'));
    }

    if (substr($this->query_string, 0, 4) !== 'http') {
      $this->adderror('query_string', __('The query string must be a valid URL.'));
    }

    if (empty($this->query_string)) {
      $this->addError('query_string', __('You must provide a query string.'));
    }

  }

}
?>
