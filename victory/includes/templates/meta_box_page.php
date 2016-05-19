<div class="wrap">
    <h1>Блоки <a href="<?php echo get_site_url();?>/wp-admin/post-new.php?post_type=victory_meta_type" class="page-title-action">Добавить новый</a></h1>
</div>
<?php
global $post;
global $wp_query;

$temp = $wp_query;
$wp_query = null;
$args = array( 'post_type' => 'victory_meta_type',
    'posts_per_page' => '-1',
    'order' => 'ASC'
);
$wp_query = new WP_Query($args);
?>
<table class="wp-list-table widefat fixed striped posts">
    <thead>
    <tr>
        <th scope="col" class="manage-column">Заголовок</th>
        <th scope="col" class="manage-column">Название блока</th>
        <th scope="col" class="manage-column">Активность</th>
        <th scope="col" class="manage-column">Удалить</th>
    </tr>
    </thead>
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            ?>
            <tr class="iedit">
                <td><h2><a href="<?php echo get_edit_post_link(); ?>"><?php echo get_the_title(); ?></a></h2></td>
                <td></td>
                <td></td>
                <td class="type-delete"><a href="<?php echo get_delete_post_link(); ?>">Удалить</a></td>
            </tr>
            <?php
        endwhile;
    endif;
    ?>
</table>
<?php
$wp_query = null;
$wp_query = $temp;
wp_reset_postdata();