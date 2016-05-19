<?php
global $post;
global $nonce_field_basename;

wp_nonce_field( $nonce_field_basename, 'victory_post_type_nonce_field' );
$p_t_status  = get_post_meta($post->ID,'_p_t_status', true)?get_post_meta($post->ID,'_p_t_status', true):'0';
$p_t_name  = get_post_meta($post->ID,'_p_t_name', true)?get_post_meta($post->ID,'_p_t_name', true):'';
$p_t_menu_position  = get_post_meta($post->ID,'_p_t_menu_position', true)?get_post_meta($post->ID,'_p_t_menu_position', true):'26';
$p_t_supports  = get_post_meta($post->ID,'_p_t_supports', true)?get_post_meta($post->ID,'_p_t_supports', true):'';
$p_t_menu_icon  = get_post_meta($post->ID,'_p_t_menu_icon', true)?get_post_meta($post->ID,'_p_t_menu_icon', true):'dashicons-admin-post';
$p_t_labels  = get_post_meta($post->ID,'_p_t_labels', true)?get_post_meta($post->ID,'_p_t_labels', true):'';
$p_t_public  = get_post_meta($post->ID,'_p_t_public', true)?get_post_meta($post->ID,'_p_t_public', true):'1';
$p_t_hierarchical  = get_post_meta($post->ID,'_p_t_hierarchical', true)?get_post_meta($post->ID,'_p_t_hierarchical', true):'0';
$p_t_exclude_from_search  = get_post_meta($post->ID,'_p_t_exclude_from_search', true)?get_post_meta($post->ID,'_p_t_exclude_from_search', true):'0';

?>
<table class="add-box" >
    <tr valign="top">
        <td colspan="3">
            <span id="status_container"><b>Статус видимости типа поста:</b></span>
            <select id="p_t_status" name="p_t_status">
                <option value="0" <?php selected($p_t_status,'0'); ?>>Не активен</option>
                <option value="1" <?php selected($p_t_status,'1'); ?>>Активен</option>
            </select>
            <br/><span class="description"><?php _e('Укажите статус видимости типа поста'); ?></span>
            <script>
                jQuery('#p_t_status').bind("change click", function() {
                    console.log($(this).val());
                    if($(this).val() == 1){
                        $('#status_container').css({'color':'green'});
                    }
                    if($(this).val() == 0){
                        $('#status_container').css({'color':'red'});
                    }
                });
                jQuery('#p_t_status').click();
            </script>
        </td>
    </tr>
</table>
<table class="add-box" >
    <tr valign="top">
        <td colspan="3">
            <span><b>Название типа поста:</b></span>
            <input id="p_t_name" type="text" style="width: 300px;" name="p_t_name" placeholder="Название типа поста" value="<?php echo esc_attr($p_t_name); ?>">
            <br/><span class="description"><?php _e('Укажите название типа поста максимум 20 символов'); ?></span>
            <script>
                jQuery('#p_t_name').bind("change keyup input click", function() {
                    if (this.value.match(/[^A-Za-z_]/g)) {
                        this.value = this.value.replace(/[^A-Za-z_]/g, '');
                    }
                    if(this.value.length > 20){
                        this.value = this.value.substring(0,20);
                    }
                });
            </script>
        </td>
    </tr>
</table>
<table class="add-box" >
    <tr valign="top">
        <td colspan="3">
            <span><b>Названия ярлыков для типа записи <var>labels</var></span>
        </td>
        <?php
        if($p_t_labels == ""){
            $p_t_labels = array(
                'name' => '',
                'singular_name' => '',
                'add_new' => '',
                'add_new_item' => '',
                'edit_item' => '',
                'new_item' => '',
                'view_item' => '',
                'search_items' => '',
                'not_found' => '',
                'not_found_in_trash' => '',
                'parent_item_colon' => '',
                'menu_name' => '',
            );
        }
        ?>
    </tr>
    <tr valign="top">
        <td colspan="1">
            <input type="input" style="width: 300px;" name="p_t_labels[name]" placeholder="Записи" value="<?php echo esc_attr($p_t_labels['name']); ?>">
            <br/><span class="description" ><?php _e('Укажите основное название для типа записи, обычно во множественном числе'); ?><var>name</var></span>
        </td>
        <td colspan="1">
            <input type="input" style="width: 300px;" name="p_t_labels[singular_name]" placeholder="Запись" value="<?php echo esc_attr($p_t_labels['singular_name']); ?>">
            <br/><span class="description" ><?php _e('Укажите название для одной записи этого типа'); ?><var>singular_name</var></span>
        </td>
    </tr>
    <tr valign="top">
        <td>
            <input type="input" style="width: 300px;" name="p_t_labels[add_new]" placeholder="Добавить новую" value="<?php echo esc_attr($p_t_labels['add_new']); ?>">
            <br/><span class="description" ><?php _e('Укажите текст для добавления новой записи, как "добавить новый" у постов в админ-панели'); ?><var>add_new</var></span>
        </td>
        <td>
            <input type="input" style="width: 300px;" name="p_t_labels[add_new_item]" placeholder="Добавить новую запись" value="<?php echo esc_attr($p_t_labels['add_new_item']); ?>">
            <br/><span class="description" ><?php _e('Укажите текст заголовка у вновь создаваемой записи в админ-панели'); ?><var>add_new_item</var></span>
        </td>
    </tr>
    <tr valign="top">
        <td>
            <input type="input" style="width: 300px;" name="p_t_labels[edit_item]" placeholder="Редактировать запись" value="<?php echo esc_attr($p_t_labels['edit_item']); ?>">
            <br/><span class="description" ><?php _e('Укажите текст для редактирования типа записи'); ?><var>edit_item</var></span>
        </td>
        <td>
            <input type="input" style="width: 300px;" name="p_t_labels[new_item]" placeholder="Новая запись" value="<?php echo esc_attr($p_t_labels['new_item']); ?>">
            <br/><span class="description" ><?php _e('Укажите текст новой записи'); ?><var>new_item</var></span>
        </td>
    </tr>
    <tr valign="top">
        <td>
            <input type="input" style="width: 300px;" name="p_t_labels[view_item]" placeholder="Посмотреть запись" value="<?php echo esc_attr($p_t_labels['view_item']); ?>">
            <br/><span class="description" ><?php _e('Укажите текст для просмотра записи этого типа'); ?><var>view_item</var></span>
        </td>
        <td>
            <input type="input" style="width: 300px;" name="p_t_labels[search_items]" placeholder="Найти запись" value="<?php echo esc_attr($p_t_labels['search_items']); ?>">
            <br/><span class="description" ><?php _e('Укажите текст для поиска по этим типам записи'); ?><var>search_items</var></span>
        </td>
    </tr>
    <tr valign="top">
        <td>
            <input type="input" style="width: 300px;" name="p_t_labels[not_found]" placeholder="Запись не было найдено" value="<?php echo esc_attr($p_t_labels['not_found']); ?>">
            <br/><span class="description" ><?php _e('Укажите текст, если в результате поиска ничего не было найдено'); ?><var>not_found</var></span>
        </td>
        <td>
            <input type="input" style="width: 300px;" name="p_t_labels[not_found_in_trash]" placeholder="Запись не было найдено в корзине" value="<?php echo esc_attr($p_t_labels['not_found_in_trash']); ?>">
            <br/><span class="description" ><?php _e('Укажите текст, если не было найдено в корзине'); ?><var>not_found_in_trash</var></span>
        </td>
    </tr>
    <tr valign="top">
        <td>
            <input type="input" style="width: 300px;" name="p_t_labels[parent_item_colon]" placeholder="Родительская запись" value="<?php echo esc_attr($p_t_labels['parent_item_colon']); ?>">
            <br/><span class="description" ><?php _e('Укажите текст для родительских типов. Этот параметр не используется для не древовидных типов записей'); ?><var>parent_item_colon</var></span>
        </td>
        <td>
            <input type="input" style="width: 300px;" name="p_t_labels[menu_name]" placeholder="Записи" value="<?php echo esc_attr($p_t_labels['menu_name']); ?>">
            <br/><span class="description" ><?php _e('Укажите название меню'); ?><var>menu_name</var></span>
        </td>
    </tr>
</table>
<table class="add-box" >
    <tr valign="top">
        <td colspan="1">
            <span><b>Позиция в меню:</b></span>
            <input id="p_t_menu_position" type="number" min="1" max="199" step="1" style="width: 100px;" name="p_t_menu_position" placeholder="1-199" value="<?php echo esc_attr($p_t_menu_position); ?>">
            <br><var>menu_position</var>
            <script>
                jQuery('#p_t_name').bind("change keyup input click", function() {
                    if (this.value.match(/[0-9]/g)) {
                        this.value = this.value.replace(/[^0-9]/g, '');
                    }
                    if(this.value.length > 20){
                        this.value = this.value.substring(0,3);
                    }
                });
            </script>
        </td>
        <td colspan="2" style="padding-left: 25px;">
            <span><b>Дополнительная информация:</b></span>
            <p>
                <var>1</var> — в самом верху меню<br>
                <var>2-3</var> — под «Консоль»<br>
                <var>4-9</var> — под «Записи»<br>
                <var>10-14</var> — под «Медиафайлы»<br>
                <var>15-19</var> — под «Ссылки»<br>
                <var>20-24</var> — под «Страницы»<br>
                <var>25-59</var> — под «Комментарии» (по умолчанию)<br>
                <var>60-64</var> — под «Внешний вид»<br>
                <var>65-69</var> — под «Плагины»<br>
                <var>70-74</var> — под «Пользователи»<br>
                <var>75-79</var> — под «Инструменты»<br>
                <var>80-99</var> — под «Параметры»<br>
                <var>100+</var> — под разделителем после «Параметры»<br>
            </p>
        </td>
    </tr>

</table>
<table class="add-box" >
    <tr valign="top">
        <td colspan="4">
            <span><b>Вспомогательные поля на странице создания/редактирования этого типа записи<var>supports</var></span>
        </td>
    </tr>
    <tr valign="top">
        <td colspan="3">
            <?php
            $supports_title = isset($p_t_supports['title'])?$p_t_supports['title']:0;
            $supports_editor = isset($p_t_supports['editor'])?$p_t_supports['editor']:0;
            $supports_author = isset($p_t_supports['author'])?$p_t_supports['author']:0;
            $supports_thumbnail = isset($p_t_supports['thumbnail'])?$p_t_supports['thumbnail']:0;
            ?>
            <input id="p_t_supports" type="checkbox" name="p_t_supports[title]" <?php checked($supports_title,'title')?>  value="title">
            <var>title</var> - блок заголовка (рекомендуется)(по умолчанию);<br>
            <input id="p_t_supports" type="checkbox" name="p_t_supports[editor]" <?php checked($supports_editor,'editor')?>  value="editor">
            <var>editor</var> - блок для ввода контента(по умолчанию);<br>
            <input id="p_t_supports" type="checkbox" name="p_t_supports[author]" <?php checked($supports_author,'author')?>  value="author">
            <var>author</var> - блок выбора автора;<br>
            <input id="p_t_supports" type="checkbox" name="p_t_supports[thumbnail]" <?php checked($supports_thumbnail,'thumbnail')?>  value="thumbnail">
            <var>thumbnail</var> - блок выбора миниатюры записи;<br>
        </td>
    </tr>

    <tr valign="top">
        <td colspan="3">
            <?php
            $supports_excerpt = isset($p_t_supports['excerpt'])?$p_t_supports['excerpt']:0;
            $supports_trackbacks = isset($p_t_supports['trackbacks'])?$p_t_supports['trackbacks']:0;
            $supports_custom_fields = isset($p_t_supports['custom-fields'])?$p_t_supports['custom-fields']:0;
            $supports_comments = isset($p_t_supports['comments'])?$p_t_supports['comments']:0;
            ?>
            <input id="p_t_supports" type="checkbox" name="p_t_supports[excerpt]" <?php checked($supports_excerpt,'excerpt')?>  value="excerpt">
            <var>excerpt</var> - блок ввода цитаты;<br>
            <input id="p_t_supports" type="checkbox" name="p_t_supports[trackbacks]" <?php checked($supports_trackbacks,'trackbacks')?>  value="trackbacks">
            <var>trackbacks</var> - блок уведомлений;<br>
            <input id="p_t_supports" type="checkbox" name="p_t_supports[custom-fields]" <?php checked($supports_custom_fields,'custom-fields')?>  value="custom-fields">
            <var>custom-fields</var> - блок установки произвольных полей;<br>
            <input id="p_t_supports" type="checkbox" name="p_t_supports[comments]" <?php checked($supports_comments,'comments')?>  value="comments">
            <var>comments</var> - блок комментариев;<br>
        </td>
    </tr>
    <tr valign="top">
        <td colspan="3">
            <?php
            $supports_revisions = isset($p_t_supports['revisions'])?$p_t_supports['revisions']:0;
            $supports_page_attributes = isset($p_t_supports['page-attributes'])?$p_t_supports['page-attributes']:0;
            $supports_post_formats = isset($p_t_supports['post-formats'])?$p_t_supports['post-formats']:0;
            ?>
            <input id="p_t_supports" type="checkbox" name="p_t_supports[revisions]" <?php checked($supports_revisions,'revisions')?>  value="revisions">
            <var>revisions</var> - блок ревизий (не отображается пока нет ревизий);<br>
            <input id="p_t_supports" type="checkbox" name="p_t_supports[page-attributes]" <?php checked($supports_page_attributes,'page-attributes')?>  value="page-attributes">
            <var>page-attributes</var> - блок блок атрибутов постоянных страниц (шаблон и древовидная связь записей, древовидность должна быть включена). Может быть использовано вместо;<br>
            <input id="p_t_supports" type="checkbox" name="p_t_supports[post-formats]" <?php checked($supports_post_formats,'post-formats')?>  value="post-formats">
            <var>post-formats</var> - блок форматов записи, если они включены в теме.<br>
        </td>
    </tr>
    <tr valign="top">
        <td colspan="3">
            <span><b>Иконка пункта меню <var>menu_icon</var></span><br>
            <br>

            <var><span class="dashicons-before dashicons-admin-post" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-admin-post')?>  value="dashicons-admin-post">
                </span></var>
            <var><span class="dashicons-before dashicons-menu" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-menu')?>  value="dashicons-menu">
                </span></var>
            <var><span class="dashicons-before dashicons-admin-site" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-admin-site')?>  value="dashicons-admin-site">
                </span></var>
            <var><span class="dashicons-before dashicons-admin-media" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-admin-media')?>  value="dashicons-admin-media">
                </span></var>
            <var><span class="dashicons-before dashicons-admin-links" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-admin-links')?>  value="dashicons-admin-links">
                </span></var>
            <var><span class="dashicons-before dashicons-admin-page" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-admin-page')?>  value="dashicons-admin-page">
                </span></var>
            <var><span class="dashicons-before dashicons-admin-comments" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-admin-comments')?>  value="dashicons-admin-comments">
                </span></var>
            <var><span class="dashicons-before dashicons-admin-appearance" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-admin-appearance')?>  value="dashicons-admin-appearance">
                </span></var>
            <var><span class="dashicons-before dashicons-admin-plugins" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-admin-plugins')?>  value="dashicons-admin-plugins">
                </span></var>
            <var><span class="dashicons-before dashicons-admin-users" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-admin-users')?>  value="dashicons-admin-users">
                </span></var>
            <var><span class="dashicons-before dashicons-admin-tools" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-admin-tools')?>  value="dashicons-admin-tools">
                </span></var>
            <var><span class="dashicons-before dashicons-admin-settings" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-admin-settings')?>  value="dashicons-admin-settings">
                </span></var>
            <var><span class="dashicons-before dashicons-admin-network" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-admin-network')?>  value="dashicons-admin-network">
                </span></var>
            <var><span class="dashicons-before dashicons-admin-home" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-admin-home')?>  value="dashicons-admin-home">
                </span></var>
            <var><span class="dashicons-before dashicons-admin-generic" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-admin-generic')?>  value="dashicons-admin-generic">
                </span></var>
            <var><span class="dashicons-before dashicons-admin-collapse" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-admin-collapse')?>  value="dashicons-admin-collapse">
                </span></var>
            <var><span class="dashicons-before dashicons-welcome-write-blog" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-welcome-write-blog')?>  value="dashicons-welcome-write-blog">
                </span></var>
            <var><span class="dashicons-before dashicons-welcome-add-page" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-welcome-add-page')?>  value="dashicons-welcome-add-page">
                </span></var>
            <var><span class="dashicons-before dashicons-welcome-view-site" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-welcome-view-site')?>  value="dashicons-welcome-view-site">
                </span></var>
            <var><span class="dashicons-before dashicons-welcome-widgets-menus" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-welcome-widgets-menus')?>  value="dashicons-welcome-widgets-menus">
                </span></var>
            <var><span class="dashicons-before dashicons-welcome-comments" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-welcome-comments')?>  value="dashicons-welcome-comments">
                </span></var>
            <var><span class="dashicons-before dashicons-welcome-learn-more" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-welcome-learn-more')?>  value="dashicons-welcome-learn-more">
                </span></var>
            <var><span class="dashicons-before dashicons-format-aside" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-format-aside')?>  value="dashicons-format-aside">
                </span></var>
            <var><span class="dashicons-before dashicons-format-image" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-format-image')?>  value="dashicons-format-image">
                </span></var>
            <var><span class="dashicons-before dashicons-format-gallery" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-format-gallery')?>  value="dashicons-format-gallery">
                </span></var>
            <var><span class="dashicons-before dashicons-format-video" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-format-video')?>  value="dashicons-format-video">
                </span></var>
            <var><span class="dashicons-before dashicons-format-status" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-format-status')?>  value="dashicons-format-status">
                </span></var>
            <var><span class="dashicons-before dashicons-format-quote" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-format-quote')?>  value="dashicons-format-quote">
                </span></var>
            <var><span class="dashicons-before dashicons-format-chat" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-format-chat')?>  value="dashicons-format-chat">
                </span></var>
            <var><span class="dashicons-before dashicons-format-audio" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-format-audio')?>  value="dashicons-format-audio">
                </span></var>
            <var><span class="dashicons-before dashicons-camera" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-camera')?>  value="dashicons-camera">
                </span></var>
            <var><span class="dashicons-before dashicons-images-alt" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-images-alt')?>  value="dashicons-images-alt">
                </span></var>
            <var><span class="dashicons-before dashicons-images-alt2" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-images-alt2')?>  value="dashicons-images-alt2">
                </span></var>
            <var><span class="dashicons-before dashicons-video-alt" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-video-alt')?>  value="dashicons-video-alt">
                </span></var>
            <var><span class="dashicons-before dashicons-video-alt2" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-video-alt2')?>  value="dashicons-video-alt2">
                </span></var>
            <var><span class="dashicons-before dashicons-video-alt3" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-video-alt3')?>  value="dashicons-video-alt3">
                </span></var>
            <var><span class="dashicons-before dashicons-image-crop" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-image-crop')?>  value="dashicons-image-crop">
                </span></var>
            <var><span class="dashicons-before dashicons-image-rotate-left" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-image-rotate-left')?>  value="dashicons-image-rotate-left">
                </span></var>
            <var><span class="dashicons-before dashicons-image-rotate-right" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-image-rotate-right')?>  value="dashicons-image-rotate-right">
                </span></var>
            <var><span class="dashicons-before dashicons-image-flip-vertical" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-image-flip-vertical')?>  value="dashicons-image-flip-vertical">
                </span></var>
            <var><span class="dashicons-before dashicons-image-flip-horizontal" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-image-flip-horizontal')?>  value="dashicons-image-flip-horizontal">
                </span></var>
            <var><span class="dashicons-before dashicons-undo" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-undo')?>  value="dashicons-undo">
                </span></var>
            <var><span class="dashicons-before dashicons-redo" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-redo')?>  value="dashicons-redo">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-bold" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-bold')?>  value="dashicons-editor-bold">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-italic" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-italic')?>  value="dashicons-editor-italic">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-ul" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-ul')?>  value="dashicons-editor-ul">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-ol" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-ol')?>  value="dashicons-editor-ol">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-quote" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-quote')?>  value="dashicons-editor-quote">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-alignleft" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-alignleft')?>  value="dashicons-editor-alignleft">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-aligncenter" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-aligncenter')?>  value="dashicons-editor-aligncenter">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-alignright" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-alignright')?>  value="dashicons-editor-alignright">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-insertmore" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-insertmore')?>  value="dashicons-editor-insertmore">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-spellcheck" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-spellcheck')?>  value="dashicons-editor-spellcheck">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-distractionfree" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-distractionfree')?>  value="dashicons-editor-distractionfree">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-kitchensink" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-kitchensink')?>  value="dashicons-editor-kitchensink">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-underline" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-underline')?>  value="dashicons-editor-underline">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-justify" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-justify')?>  value="dashicons-editor-justify">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-textcolor" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-textcolor')?>  value="dashicons-editor-textcolor">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-paste-word" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-paste-word')?>  value="dashicons-editor-paste-word">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-paste-text" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-paste-text')?>  value="dashicons-editor-paste-text">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-removeformatting" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-removeformatting')?>  value="dashicons-editor-removeformatting">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-video" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-video')?>  value="dashicons-editor-video">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-customchar" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-customchar')?>  value="dashicons-editor-customchar">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-outdent" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-outdent')?>  value="dashicons-editor-outdent">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-indent" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-indent')?>  value="dashicons-editor-indent">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-help" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-help')?>  value="dashicons-editor-help">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-strikethrough" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-strikethrough')?>  value="dashicons-editor-strikethrough">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-unlink" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-unlink')?>  value="dashicons-editor-unlink">
                </span></var>
            <var><span class="dashicons-before dashicons-editor-rtl" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-editor-rtl')?>  value="dashicons-editor-rtl">
                </span></var>
            <var><span class="dashicons-before dashicons-align-left" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-align-left')?>  value="dashicons-align-left">
                </span></var>
            <var><span class="dashicons-before dashicons-align-right" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-align-right')?>  value="dashicons-align-right">
                </span></var>
            <var><span class="dashicons-before dashicons-align-center" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-align-center')?>  value="dashicons-align-center">
                </span></var>
            <var><span class="dashicons-before dashicons-align-none" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-align-none')?>  value="dashicons-align-none">
                </span></var>
            <var><span class="dashicons-before dashicons-lock" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-lock')?>  value="dashicons-lock">
                </span></var>
            <var><span class="dashicons-before dashicons-calendar" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-calendar')?>  value="dashicons-calendar">
                </span></var>
            <var><span class="dashicons-before dashicons-visibility" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-visibility')?>  value="dashicons-visibility">
                </span></var>
            <var><span class="dashicons-before dashicons-post-status" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-post-status')?>  value="dashicons-post-status">
                </span></var>
            <var><span class="dashicons-before dashicons-edit" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-edit')?>  value="dashicons-edit">
                </span></var>
            <var><span class="dashicons-before dashicons-trash" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-trash')?>  value="dashicons-trash">
                </span></var>
            <var><span class="dashicons-before dashicons-arrow-up" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-arrow-up')?>  value="dashicons-arrow-up">
                </span></var>
            <var><span class="dashicons-before dashicons-arrow-down" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-arrow-down')?>  value="dashicons-arrow-down">
                </span></var>
            <var><span class="dashicons-before dashicons-arrow-right" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-arrow-right')?>  value="dashicons-arrow-right">
                </span></var>
            <var><span class="dashicons-before dashicons-arrow-left" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-arrow-left')?>  value="dashicons-arrow-left">
                </span></var>
            <var><span class="dashicons-before dashicons-arrow-up-alt" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-arrow-up-alt')?>  value="dashicons-arrow-up-alt">
                </span></var>
            <var><span class="dashicons-before dashicons-arrow-down-alt" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-arrow-down-alt')?>  value="dashicons-arrow-down-alt">
                </span></var>
            <var><span class="dashicons-before dashicons-arrow-right-alt" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-arrow-right-alt')?>  value="dashicons-arrow-right-alt">
                </span></var>
            <var><span class="dashicons-before dashicons-arrow-left-alt" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-arrow-left-alt')?>  value="dashicons-arrow-left-alt">
                </span></var>
            <var><span class="dashicons-before dashicons-arrow-up-alt2" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-arrow-up-alt2')?>  value="dashicons-arrow-up-alt2">
                </span></var>
            <var><span class="dashicons-before dashicons-arrow-down-alt2" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-arrow-down-alt2')?>  value="dashicons-arrow-down-alt2">
                </span></var>
            <var><span class="dashicons-before dashicons-arrow-right-alt2" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-arrow-right-alt2')?>  value="dashicons-arrow-right-alt2">
                </span></var>
            <var><span class="dashicons-before dashicons-arrow-left-alt2" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-arrow-left-alt2')?>  value="dashicons-arrow-left-alt2">
                </span></var>
            <var><span class="dashicons-before dashicons-sort" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-sort')?>  value="dashicons-sort">
                </span></var>
            <var><span class="dashicons-before dashicons-leftright" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-leftright')?>  value="dashicons-leftright">
                </span></var>
            <var><span class="dashicons-before dashicons-list-view" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-list-view')?>  value="dashicons-list-view">
                </span></var>
            <var><span class="dashicons-before dashicons-exerpt-view" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-exerpt-view')?>  value="dashicons-exerpt-view">
                </span></var>
            <var><span class="dashicons-before dashicons-share" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-share')?>  value="dashicons-share">
                </span></var>
            <var><span class="dashicons-before dashicons-share-alt" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-share-alt')?>  value="dashicons-share-alt">
                </span></var>
            <var><span class="dashicons-before dashicons-share-alt2" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-share-alt2')?>  value="dashicons-share-alt2">
                </span></var>
            <var><span class="dashicons-before dashicons-twitter" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-twitter')?>  value="dashicons-twitter">
                </span></var>
            <var><span class="dashicons-before dashicons-rss" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-rss')?>  value="dashicons-rss">
                </span></var>
            <var><span class="dashicons-before dashicons-facebook" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-facebook')?>  value="dashicons-facebook">
                </span></var>
            <var><span class="dashicons-before dashicons-facebook-alt" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-facebook-alt')?>  value="dashicons-facebook-alt">
                </span></var>
            <var><span class="dashicons-before dashicons-googleplus" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-googleplus')?>  value="dashicons-googleplus">
                </span></var>
            <var><span class="dashicons-before dashicons-networking" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-networking')?>  value="dashicons-networking">
                </span></var>
            <var><span class="dashicons-before dashicons-hammer" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-hammer')?>  value="dashicons-hammer">
                </span></var>
            <var><span class="dashicons-before dashicons-art" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-art')?>  value="dashicons-art">
                </span></var>
            <var><span class="dashicons-before dashicons-migrate" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-migrate')?>  value="dashicons-migrate">
                </span></var>
            <var><span class="dashicons-before dashicons-performance" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-performance')?>  value="dashicons-performance">
                </span></var>
            <var><span class="dashicons-before dashicons-wordpress" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-wordpress')?>  value="dashicons-wordpress">
                </span></var>
            <var><span class="dashicons-before dashicons-wordpress-alt" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-wordpress-alt')?>  value="dashicons-wordpress-alt">
                </span></var>
            <var><span class="dashicons-before dashicons-pressthis" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-pressthis')?>  value="dashicons-pressthis">
                </span></var>
            <var><span class="dashicons-before dashicons-update" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-update')?>  value="dashicons-update">
                </span></var>
            <var><span class="dashicons-before dashicons-screenoptions" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-screenoptions')?>  value="dashicons-screenoptions">
                </span></var>
            <var><span class="dashicons-before dashicons-info" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-info')?>  value="dashicons-info">
                </span></var>
            <var><span class="dashicons-before dashicons-cart" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-cart')?>  value="dashicons-cart">
                </span></var>
            <var><span class="dashicons-before dashicons-feedback" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-feedback')?>  value="dashicons-feedback">
                </span></var>
            <var><span class="dashicons-before dashicons-cloud" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-cloud')?>  value="dashicons-cloud">
                </span></var>
            <var><span class="dashicons-before dashicons-translation" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-translation')?>  value="dashicons-translation">
                </span></var>
            <var><span class="dashicons-before dashicons-tag" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-tag')?>  value="dashicons-tag">
                </span></var>
            <var><span class="dashicons-before dashicons-category" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-category')?>  value="dashicons-category">
                </span></var>
            <var><span class="dashicons-before dashicons-yes" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-yes')?>  value="dashicons-yes">
                </span></var>
            <var><span class="dashicons-before dashicons-no" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-no')?>  value="dashicons-no">
                </span></var>
            <var><span class="dashicons-before dashicons-no-alt" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-no-alt')?>  value="dashicons-no-alt">
                </span></var>
            <var><span class="dashicons-before dashicons-plus" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-plus')?>  value="dashicons-plus">
                </span></var>
            <var><span class="dashicons-before dashicons-minus" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-minus')?>  value="dashicons-minus">
                </span></var>
            <var><span class="dashicons-before dashicons-dismiss" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-dismiss')?>  value="dashicons-dismiss">
                </span></var>
            <var><span class="dashicons-before dashicons-marker" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-marker')?>  value="dashicons-marker">
                </span></var>
            <var><span class="dashicons-before dashicons-star-filled" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-star-filled')?>  value="dashicons-star-filled">
                </span></var>
            <var><span class="dashicons-before dashicons-star-half" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-star-half')?>  value="dashicons-star-half">
                </span></var>
            <var><span class="dashicons-before dashicons-star-empty" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-star-empty')?>  value="dashicons-star-empty">
                </span></var>
            <var><span class="dashicons-before dashicons-flag" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-flag')?>  value="dashicons-flag">
                </span></var>
            <var><span class="dashicons-before dashicons-location" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-location')?>  value="dashicons-location">
                </span></var>
            <var><span class="dashicons-before dashicons-location-alt" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-location-alt')?>  value="dashicons-location-alt">
                </span></var>
            <var><span class="dashicons-before dashicons-vault" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-vault')?>  value="dashicons-vault">
                </span></var>
            <var><span class="dashicons-before dashicons-shield" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-shield')?>  value="dashicons-shield">
                </span></var>
            <var><span class="dashicons-before dashicons-shield-alt" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-shield-alt')?>  value="dashicons-shield-alt">
                </span></var>
            <var><span class="dashicons-before dashicons-search" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-search')?>  value="dashicons-search">
                </span></var>
            <var><span class="dashicons-before dashicons-slides" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-slides')?>  value="dashicons-slides">
                </span></var>
            <var><span class="dashicons-before dashicons-analytics" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-analytics')?>  value="dashicons-analytics">
                </span></var>
            <var><span class="dashicons-before dashicons-chart-pie" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-chart-pie')?>  value="dashicons-chart-pie">
                </span></var>
            <var><span class="dashicons-before dashicons-chart-bar" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-chart-bar')?>  value="dashicons-chart-bar">
                </span></var>
            <var><span class="dashicons-before dashicons-chart-line" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-chart-line')?>  value="dashicons-chart-line">
                </span></var>
            <var><span class="dashicons-before dashicons-chart-area" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-chart-area')?>  value="dashicons-chart-area">
                </span></var>
            <var><span class="dashicons-before dashicons-groups" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-groups')?>  value="dashicons-groups">
                </span></var>
            <var><span class="dashicons-before dashicons-businessman" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-businessman')?>  value="dashicons-businessman">
                </span></var>
            <var><span class="dashicons-before dashicons-id" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-id')?>  value="dashicons-id">
                </span></var>
            <var><span class="dashicons-before dashicons-id-alt" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-id-alt')?>  value="dashicons-id-alt">
                </span></var>
            <var><span class="dashicons-before dashicons-products" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-products')?>  value="dashicons-products">
                </span></var>
            <var><span class="dashicons-before dashicons-awards" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-awards')?>  value="dashicons-awards">
                </span></var>
            <var><span class="dashicons-before dashicons-forms" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-forms')?>  value="dashicons-forms">
                </span></var>
            <var><span class="dashicons-before dashicons-portfolio" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-portfolio')?>  value="dashicons-portfolio">
                </span></var>
            <var><span class="dashicons-before dashicons-book" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-book')?>  value="dashicons-book">
                </span></var>
            <var><span class="dashicons-before dashicons-book-alt" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-book-alt')?>  value="dashicons-book-alt">
                </span></var>
            <var><span class="dashicons-before dashicons-download" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-download')?>  value="dashicons-download">
                </span></var>
            <var><span class="dashicons-before dashicons-upload" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-upload')?>  value="dashicons-upload">
                </span></var>
            <var><span class="dashicons-before dashicons-backup" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-backup')?>  value="dashicons-backup">
                </span></var>
            <var><span class="dashicons-before dashicons-lightbulb" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-lightbulb')?>  value="dashicons-lightbulb">
                </span></var>
            <var><span class="dashicons-before dashicons-smiley" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-smiley')?>  value="dashicons-smiley">
                </span></var>


        </td>
    </tr>

</table>
<table class="add-box" >
    <tr valign="top">
        <td colspan="4">
            <span><b>Дополнительные опции:</span>
        </td>
    </tr>
    <tr valign="top">
        <td colspan="3">
            <input type="checkbox" name="p_t_public" <?php checked($p_t_public,'1')?>  value="1">
            <var>public</var> - Аргумент определяющий показ пользовательского интерфейса этой менюшки, т.е. показывать ли эту менюшку в админ-панели;<br>
        </td>
    </tr>
    <tr valign="top">
        <td colspan="3">
            <input type="checkbox" name="p_t_hierarchical" <?php checked($p_t_hierarchical,'1')?>  value="1">
            <var>hierarchical</var> - Будут ли записи этого типа иметь древовидную структуру;<br>
        </td>
    </tr>
    <tr valign="top">
        <td colspan="3">
            <input type="checkbox" name="p_t_exclude_from_search" <?php checked($p_t_exclude_from_search,'1')?>  value="1">
            <var>exclude_from_search</var> - Исключить ли этот тип записей из поиска по сайту;<br>
        </td>
    </tr>
</table>