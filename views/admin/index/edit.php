<?php 

$head = array('bodyclass' => 'catalog-search primary',
              'title' => __('Catalog Search | Edit "%s"', metadata('catalog_search_search', 'catalog_name' )));

echo head($head);
echo $form; 
echo foot();

?>
