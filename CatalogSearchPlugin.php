<?php

/*
 * Catalog Search Plugin for Omeka 
 *
 * */

class CatalogSearchPlugin extends Omeka_Plugin_AbstractPlugin {

  protected $_hooks = array(
    'public_items_show'
  );

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

      /* Archive Grid */
      $archivegrid_url = "http://archivegrid.org/web/jsp/s.jsp?q=" . urlencode($subject_clean);
      echo "<div class='element-text'><a href='" . $archivegrid_url . "'>" . __("Archive Grid") . "</a></div>";

      /* Google Books */
      $googlebooks_url = "https://www.google.com/search?btnG=Search+Books&tbm=bks&tbo=1&q=" . urlencode($subject_clean);
      echo "<div class='element-text'><a href='" . $googlebooks_url . "'>" . __("Google Books") . "</a></div>";

      /* Google Scholar */
      $googlescholar_url = "http://scholar.google.com/scholar?btnG=&as_sdt=1%2C22&as_sdtp=&q=" . urlencode($subject_clean);
      echo "<div class='element-text'><a href='" . $googlescholar_url . "'>" . __("Google Scholar") . "</a></div>";

      /* JSTOR */
      $jstor_url = "http://www.jstor.org/action/doBasicSearch?Query=" . urlencode($subject_clean);
      echo "<div class='element-text'><a href='" . $jstor_url . "'>" . __("JSTOR") . "</a></div>";

      /* Library of Congress */
      $loc_url = "http://catalog2.loc.gov/vwebv/search?searchArg=" . urlencode($subject) . "&searchCode=GKEY%5E*&searchType=0";
      echo "<div class='element-text'><a href='" . $loc_url . "'>" . __("Library of Congress") . "</a></div>";

      /* WorldCat */
      $worldcat_url = "http://www.worldcat.org/search?qt=worldcat_org_all&q=" . urlencode($subject);
      echo "<div class='element-text'><a href='" . $worldcat_url . "'>" . __("Worldcat") . "</a></div>";

      echo "</div>";
    }
  }
}

?>
