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
<table class="full">
    <thead>
        <tr>
<?php echo browse_sort_links(array(
  __('Catalog Name') => 'catalog_name',
  __('Display') => 'display'), array('link_tag' => 'th scope="col"', 'list_tag' => ''));
?>
        </tr>
    </thead>
    <tbody>
    <?php foreach (loop('catalog_search_searches') as $catalogSearch): ?>
        <tr>
            <td>
                <span class="title">
                    <a href="<?php echo html_escape(record_url('catalog_search_search')); ?>">
                        <?php echo metadata('catalog_search_search', 'catalog_name'); ?>
                    </a>
                </span>
                <ul class="action-links group">
                    <li><a class="edit" href="<?php echo html_escape(record_url('catalog_search_search', 'edit')); ?>">
                        <?php echo __('Edit'); ?>
                    </a></li>
                    <li><a class="delete-confirm" href="<?php echo html_escape(record_url('catalog_search_search', 'delete-confirm')); ?>">
                        <?php echo __('Delete'); ?>
                    </a></li>
                </ul>
            </td>
            <td>
<?php 
if(!metadata('catalog_search_search', 'display')): 
  echo __('Not displayed');
else:
  echo __('Displayed');
endif;
?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
<?php echo foot(); ?>
