<?php

/**
 * Catalog Search Plugin
 *
 * @copyright Copyright 2013 Lincoln A. Mullen
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 *
 */

$head = array('bodyclass' => 'catalog-search primary',
  'title' => html_escape(__('Catalog Search | Browse')),
  'content_class' => 'horizontal-nav');
echo head($head);
?>

<?php echo flash(); ?>

<a class="add-page button small green" href="<?php echo html_escape(url('catalog-search/index/add')); ?>"><?php echo __('Add a Search'); ?></a>
<?php if (!has_loop_records('catalog_search_search')): ?>
    <p><?php echo __('There are no searches.'); ?> <a href="<?php echo html_escape(url('catalog-search/index/add')); ?>"><?php echo __('Add a search.'); ?></a></p>
<?php else: ?>
        <?php echo $this->partial('index/browse-list.php', array('catalogSearch' => $catalog_search_searches)); ?>
<?php endif; ?>
<?php echo foot(); ?>
