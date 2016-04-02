<?php
/**
 * Функция добавления дополнительных полей к типам записи
 */
function post_type_meta_box($post){
    wp_nonce_field( basename( __FILE__ ), 'post_type_nonce_field' );
    $p_t_name  = get_post_meta($post->ID,'_p_t_name', true)?get_post_meta($post->ID,'_p_t_name', true):'';
    $p_t_menu_position  = get_post_meta($post->ID,'_p_t_menu_position', true)?get_post_meta($post->ID,'_p_t_menu_position', true):'26';
    $p_t_supports  = get_post_meta($post->ID,'_p_t_supports', true)?get_post_meta($post->ID,'_p_t_supports', true):'';
    $p_t_menu_icon  = get_post_meta($post->ID,'_p_t_menu_icon', true)?get_post_meta($post->ID,'_p_t_menu_icon', true):'dashicons-admin-post';

    ?>
    <table class="add-box" >
        <tr valign="top">
            <td colspan="3">
                <span><b>Название поста:</b></span>
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
        <tr valign="top">
            <td colspan="1">
                <span><b>Позиция в меню:</b></span>
                <input id="p_t_menu_position" type="number" min="1" max="199" step="1" style="width: 100px;" name="p_t_menu_position" placeholder="1-199" value="<?php echo esc_attr($p_t_menu_position); ?>">
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
                <span><b>Вспомогательные поля на странице создания/редактирования этого типа записи:</span>
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
            <span><b>Иконка пункта меню:</span><br>
                <span class="dashicons-before dashicons-admin-post" >
                <input id="p_t_menu_icon" type="radio" name="p_t_menu_icon" <?php checked($p_t_menu_icon,'dashicons-admin-post')?>  value="dashicons-admin-post">
                </span>

            </td>
        </tr>
    </table>

    <?php
}
/**
 * Функция добавляет дополнительные поля на страницу создания мастера
 */
function load_post_type_meta_box() {
    add_meta_box('post_type_meta_box_id', 'Настройки типа поста', 'post_type_meta_box','victory_post_type', 'normal', 'high');
}
add_action( 'admin_menu', 'load_post_type_meta_box' );