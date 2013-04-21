<?php
$head = array('bodyclass' => 'catalog-search primary',
  'title' => html_escape(__('Catalog Search | Browse')),
  'content_class' => 'horizontal-nav');
echo head($head);
?>

<a class="add-page button small green" href="<?php echo html_escape(url('catalog-search/index/add')); ?>"><?php echo __('Add a search'); ?></a>
<?php if (!has_loop_records('catalog_search_search')): ?>
    <p><?php echo __('There are no searches.'); ?> <a href="<?php echo html_escape(url('catalog-search/index/add')); ?>"><?php echo __('Add a search.'); ?></a></p>
<?php else: ?>
<table class="full">
    <thead>
        <tr>
          <td>Catalog Name</td>
          <td>Displayed</td>
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
            <td><?php echo metadata('catalog_search_search', 'display'); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
<?php echo foot(); ?>
