<?php 

/**
 * Catalog Search Plugin
 *
 * @copyright Copyright 2013 Lincoln A. Mullen
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 *
 */

$head = array('bodyclass' => 'catalog-search primary', 
              'title' => html_escape(__('Catalog Search | Add Search')));
echo head($head);
echo flash();
echo $form;
echo foot();
 
?>
