<?php 

$head = array('bodyclass' => 'catalog-search primary', 
              'title' => html_escape(__('Catalog Search | Add Search')));
echo head($head);
echo flash();
echo $form;
echo foot();
 
?>
