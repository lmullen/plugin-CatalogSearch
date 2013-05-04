<table class="full">
    <thead>
        <tr>
            <?php echo browse_sort_links(array(
                __('Catalog Name') => 'catalog_name',
                __('Display') => 'display'));
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
                    <?php if(!metadata('catalog_search_search', 'display')): ?>
                        (<?php echo __('Not displayed'); ?>)
                    <?php endif; ?>
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
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
