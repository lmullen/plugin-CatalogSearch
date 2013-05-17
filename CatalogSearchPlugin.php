<?php

/**
 * Catalog Search Plugin
 *
 * @copyright Copyright 2013 Lincoln A. Mullen
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 *
 */

require_once dirname(__FILE__) . '/helpers/CatalogSearchFunctions.php';

/**
 * Catalog Search Plugin
 *
 */
class CatalogSearchPlugin extends Omeka_Plugin_AbstractPlugin
{
  /**
   * @var array Hooks for the plugin.
   */
  protected $_hooks = array(
    'install',
    'uninstall',
    'upgrade',
    'define_acl',
    'public_items_show'
  );

  /**
   * @var array Filters for the plugin.
   */
  protected $_filters = array(
    'admin_navigation_main'
  );

  /**
   * Install the plugin.
   */
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
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
    $db->query($sql);

    // Add default queries to database
    // -------------------------------------------------------------
    // query_string is the search URL with %s for the search terms
    // catalog_name is the display name of the catalog
    // display is an option for whether to display the search link
    // query_type is 0 for full queries, 1 for short queries
    $archive_grid = new CatalogSearchSearch;
    $archive_grid->query_string = 'http://beta.worldcat.org/archivegrid/?q=%s';
    $archive_grid->catalog_name = 'Archive Grid';
    $archive_grid->display = 1;
    $archive_grid->query_type = 1;
    $archive_grid->save();

    $dpla = new CatalogSearchSearch;
    $dpla->query_string = 'http://dp.la/search?utf8=%E2%9C%93&q=%s';
    $dpla->catalog_name = 'Digital Public Library of America';
    $dpla->display = 1;
    $dpla->query_type = 0;
    $dpla->save();

    $google_books = new CatalogSearchSearch;
    $google_books->query_string = 'https://www.google.com/search?btnG=Search+Books&tbm=bks&tbo=1&q=%s';
    $google_books->catalog_name = 'Google Books';
    $google_books->display = 1;
    $google_books->query_type = 1;
    $google_books->save();

    $google_scholar = new CatalogSearchSearch;
    $google_scholar->query_string = 'http://scholar.google.com/scholar?btnG=&as_sdt=1%2C22&as_sdtp=&q=%s';
    $google_scholar->catalog_name = 'Google Scholar';
    $google_scholar->display = 1;
    $google_scholar->query_type = 1;
    $google_scholar->save();

    $hathi_trust = new CatalogSearchSearch;
    $hathi_trust->query_string = 'http://catalog.hathitrust.org/Search/Home?lookfor=%s&searchtype=all&ft=&setft=false';
    $hathi_trust->catalog_name = 'Hathi Trust';
    $hathi_trust->display = 1;
    $hathi_trust->query_type = 0;
    $hathi_trust->save();

    $jstor = new CatalogSearchSearch;
    $jstor->query_string = 'http://www.jstor.org/action/doBasicSearch?Query=%s';
    $jstor->catalog_name = 'JSTOR';
    $jstor->display = 1;
    $jstor->query_type = 1;
    $jstor->save();

    $library_of_congress = new CatalogSearchSearch;
    $library_of_congress->query_string = 'http://catalog2.loc.gov/vwebv/search?searchArg=%s&searchCode=GKEY%5E*&searchType=0';
    $library_of_congress->catalog_name = 'Library of Congress';
    $library_of_congress->display = 1;
    $library_of_congress->query_type = 0;
    $library_of_congress->save();

    $worldcat = new CatalogSearchSearch;
    $worldcat->query_string = 'http://www.worldcat.org/search?qt=worldcat_org_all&q=%s';
    $worldcat->catalog_name = 'WorldCat';
    $worldcat->display = 1;
    $worldcat->query_type = 0;
    $worldcat->save();
  }

  /**
   * Upgrade the plugin.
   *
   * @param array $args contains: 'old_version' and 'new_version'
   */
  public function hookUpgrade($args)
  {
    $oldVersion = $args['old_version'];
    $newVersion = $args['new_version'];

    if ($oldVersion < '1.0') {
      // Earlier versions did not create a db table, so just run the 
      // install hook.
      $this->hookInstall();
    }

    if ($oldVersion < '1.0.3' and $oldVersion > '1.0') {
      // Update the Archive Grid query string, but only if it is the same
      // string that used to be the default.
      $db = $this->_db;
      $sql = "UPDATE `$db->CatalogSearchSearch` 
              SET `query_string`='http://beta.worldcat.org/archivegrid/?q=%s'
              WHERE `query_string`='http://archivegrid.org/web/jsp/s.jsp?q=%s'";
      $db->query($sql);
    }

  }

  /**
   * Uninstall the plugin.
   */
  public function hookUninstall() {
    // Drop the table.
    $db = $this->_db;
    $sql = "DROP TABLE IF EXISTS `$db->CatalogSearchSearch`";
    $db->query($sql);

    $this->_uninstallOptions();
  }

  /**
   * Define the ACL.
   * 
   * @param Omeka_Acl
   */
  public function hookDefineAcl($args)
  {
    $acl = $args['acl'];

    $indexResource = new Zend_Acl_Resource('CatalogSearch_Index');
    $pageResource = new Zend_Acl_Resource('CatalogSearch_Page');
    $acl->add($indexResource);
    $acl->add($pageResource);

    $acl->allow(array('super', 'admin'), array('CatalogSearch_Index', 'CatalogSearch_Page'));
    $acl->allow(null, 'CatalogSearch_Page', 'show');
  }

  public function filterAdminNavigationMain($nav)
  {
    $nav[] = array(
      'label' => __('Catalog Search'),
      'uri' => url('catalog-search'),
      'resource' => 'CatalogSearch_Index',
      'privilege' => 'browse'
    );
    return $nav;
  }

  /**
   * Display the links to the catalogs on the public item page.
   */
  public function hookPublicItemsShow(){

    $item = get_current_record('item');
    $subject_full = strip_formatting(metadata($item, array('Dublin Core', 'Subject')));
    $subject_simple = cleanSubjectString($subject_full);

    /* Only display the links if the item has a subject */
    if ($subject_full !== "") {

      echo "<div id='catalog-search' class='element'>";
      echo "<h3>" .__("Catalog Search") . "</h3>";
      echo "<p>" . __("Search for related records in these catalogs:") . "</p>";

      $searches = get_db()->getTable('CatalogSearchSearch')->getAllCatalogSearches();
      foreach ($searches as $search) {

        // Decide whether to use full or simple query terms. 
        if ($search->query_type == '0') {
          $subject_use = $subject_full;
        } elseif ($search->query_type == '1') {
          $subject_use = $subject_simple;
        }

        // Echo the search link to the catalog.
        echo "<div class='element-text'><a href='" 
          . getCatalogSearchUrl($search->query_string, $subject_use) 
          . "'>" . $search->catalog_name 
          . "</a></div>";

      }

      echo "</div>";
    }
  }

}
?>
