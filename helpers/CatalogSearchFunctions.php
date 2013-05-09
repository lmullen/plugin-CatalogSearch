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

/**
 * Clean the full subject string into a simple subject.
 */
function cleanSubjectString($subject_full)
{
  // Strip punctuation and dates for finicky or unsophisticated catalogs
  // Explanation of the patterns and replacements:
  // 1. Replace anything in parentheses (usually an elaboration of 
  //    a name) with a space.
  // 2. Replace any characters that are not letters or spaces with a 
  //    space.
  // 3. Replace multiple spaces with a single space.
  // 4. Strip trailing spaces.
  $patterns = array('/\(.+\)/', '/[^a-z\ ]/i', '/\s+/', '/\s+$/');
  $replacements = array(' ',' ', ' ', '');
  return $subject_simple = preg_replace($patterns, $replacements, $subject_full); 
}

?>
