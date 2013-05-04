<?php 

/**
 * Catalog Search Plugin
 *
 * @copyright Copyright 2013 Lincoln A. Mullen
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 *
 */

/**
 * Construct the URL to the catalog using the query string and terms.
 */
function getCatalogSearchUrl($query_string, $query_terms)
{
  return preg_replace('/%s/', urlencode($query_terms), $query_string);
}

?>

