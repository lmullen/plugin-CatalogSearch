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
