<?php 

/* 
 * Catalog Search Plugin for Omeka
 *
 * */

// Construct the URL to the catalog using the query string and terms
function getCatalogSearchUrl($query_string, $query_terms)
{
  return preg_replace('/%s/', urlencode($query_terms), $query_string);
}

?>
