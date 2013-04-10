<?php

/*
 * Catalog Search Plugin for Omeka 
 *
 * */

require_once dirname(__FILE__) . '/helpers/CatalogSearchFunctions.php';

class CatalogSearchPlugin extends Omeka_Plugin_AbstractPlugin {

  protected $_hooks = array(
    'install',
    'uninstall',
    'public_items_show'
  );

  public function hookInstall() {

    // Create the table.
    // -------------------------------------------------------------
    $db = $this->_db;
    $sql = "
      CREATE TABLE IF NOT EXISTS `$db->CatalogSearchSearch` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `query_string` tinytext COLLATE utf8_unicode_ci NOT NULL,
        `catalog_name` tinytext COLLATE utf8_unicode_ci NOT NULL,
        `display` tinyint(1) NOT NULL,
        `query_type` tinyint(1) NOT NULL,
        `editable` tinyint(1) NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
    $db->query($sql);

    // Add default queries to database
    // -------------------------------------------------------------
    // query_string is the search URL with %s for the search terms
    // catalog_name is the display name of the catalog
    // display is an option for whether to display the search link
    // query_type is 1 for full queries, 0 for short queries
    $jstor = new CatalogSearchSearch;
    $jstor->query_string = 'http://www.jstor.org/action/doBasicSearch?Query=%s';
    $jstor->catalog_name = 'JSTOR';
    $jstor->display = 1;
    $jstor->query_type = 0;
    $jstor->editable = 0;
    $jstor->save();

  }

  public function hookUninstall() {
    // Drop the table.
    $db = $this->_db;
    $sql = "DROP TABLE IF EXISTS `$db->CatalogSearchSearch`";
    $db->query($sql);

    $this->_uninstallOptions();
  }


  public function hookPublicItemsShow(){

    $item = get_current_record('item');
    $subject = strip_formatting(metadata($item, array('Dublin Core', 'Subject')));

    // Strip punctuation and dates for finicky or unsophisticated catalogs
    $subject_clean = preg_replace('/[^a-z\ ]/i', '', $subject); 

    /* Only display the links if the item has a subject */
    if ($subject !== "") {

      echo "<div id='catalog-search' class='element'>";
      echo "<h3>" .__("Catalog Search") . "</h3>";
      echo "<p>" . __("Search for related records in these catalogs:") . "</p>";

      $searches = get_db()->getTable('CatalogSearchSearch')->findAll();
      foreach ($searches as $search) {

        // Echo the search link to the catalog.
        echo "<div class='element-text'><a href='" . getCatalogSearchUrl($search->query_string, $subject_clean) . "'>" . $search->catalog_name . "</a></div>";

      }

      echo "</div>";
    }
  }

}
?>

