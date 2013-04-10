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
    'upgrade',
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

    $archive_grid = new CatalogSearchSearch;
    $archive_grid->query_string = 'http://archivegrid.org/web/jsp/s.jsp?q=%s';
    $archive_grid->catalog_name = 'Archive Grid';
    $archive_grid->display = 1;
    $archive_grid->query_type = 0;
    $archive_grid->editable = 0;
    $archive_grid->save();

    $google_books = new CatalogSearchSearch;
    $google_books->query_string = 'https://www.google.com/search?btnG=Search+Books&tbm=bks&tbo=1&q=%s';
    $google_books->catalog_name = 'Google Books';
    $google_books->display = 1;
    $google_books->query_type = 0;
    $google_books->editable = 0;
    $google_books->save();

    $google_scholar = new CatalogSearchSearch;
    $google_scholar->query_string = 'http://scholar.google.com/scholar?btnG=&as_sdt=1%2C22&as_sdtp=&q=%s';
    $google_scholar->catalog_name = 'Google Scholar';
    $google_scholar->display = 1;
    $google_scholar->query_type = 0;
    $google_scholar->editable = 0;
    $google_scholar->save();

    $worldcat = new CatalogSearchSearch;
    $worldcat->query_string = 'http://www.worldcat.org/search?qt=worldcat_org_all&q=%s';
    $worldcat->catalog_name = 'WorldCat';
    $worldcat->display = 1;
    $worldcat->query_type = 1;
    $worldcat->editable = 0;
    $worldcat->save();

    $library_of_congress = new CatalogSearchSearch;
    $library_of_congress->query_string = 'http://catalog2.loc.gov/vwebv/search?searchArg=%s&searchCode=GKEY%5E*&searchType=0';
    $library_of_congress->catalog_name = 'Library of Congress';
    $library_of_congress->display = 1;
    $library_of_congress->query_type = 1;
    $library_of_congress->editable = 0;
    $library_of_congress->save();
  }

  public function hookUpgrade($args)
  {
    $oldVersion = $args['old_version'];
    $newVersion = $args['new_version'];

    if ($oldVersion < '1.0') {
      // Earlier versions did not create a db table, so just run the 
      // install hook.
      $this->hookInstall();
    }

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
    $subject_full = strip_formatting(metadata($item, array('Dublin Core', 'Subject')));

    // Strip punctuation and dates for finicky or unsophisticated catalogs
    $patterns = array('/[^a-z\ ]/i', '/\s+/', '/\s+$/');
    $replacements = array(' ', ' ', '');
    $subject_simple = preg_replace($patterns, $replacements, $subject_full); 

    /* Only display the links if the item has a subject */
    if ($subject_full !== "") {

      echo "<div id='catalog-search' class='element'>";
      echo "<h3>" .__("Catalog Search") . "</h3>";
      echo "<p>" . __("Search for related records in these catalogs:") . "</p>";

      $searches = get_db()->getTable('CatalogSearchSearch')->getAllCatalogSearches();
      foreach ($searches as $search) {

        // Decide whether to use full or simple query terms. 
        if ($search->query_type == '1') {
          $subject_use = $subject_full;
        } elseif ($search->query_type == '0') {
          $subject_use = $subject_simple;
        }

        // Echo the search link to the catalog.
        echo "<div class='element-text'><a href='" . getCatalogSearchUrl($search->query_string, $subject_use) . "'>" . $search->catalog_name . "</a></div>";

      }

      echo "</div>";
    }
  }

}
?>

