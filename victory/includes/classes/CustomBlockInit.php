<?php

class CustomBlockInit{
    public $fields_type;

    public function __construct()
    {
        $this->init_fields_type();
        //Инициализация типа поста для хранения блоков с дополнительными полями
        add_action( 'init', array($this,'victory_register_post_type') );
        //Добавляем мета бокс для добавления опций на страницу добавления пользовательского типа записи
        add_action( 'admin_menu', array($this,'victory_load_post_type_meta_box') );
        //Сохранение значений введённых в мета бокс
        add_action('save_post', array($this,'victory_meta_type_meta_box_data_save'));
        //Добавляем мета бокс для выбраных типов записей
        add_action( 'admin_menu', array($this,'init_additional_meta_box') );
        //Сохранение значений введённых в мета бокс блоков в пользовательской (созданой) записи
        //add_action('save_post', array($this,'victory_save_added_box'));
    }

    /**
     * Функция прикрепляет блоки к постам
     */
    public function init_additional_meta_box(){

        global $post;
        global $wp_query;

        $temp = $wp_query;
        $wp_query = null;
        $args = array( 'post_type' => 'victory_meta_type',
                        'posts_per_page' => '-1',
                        'order' => 'ASC'
        );
        $wp_query = new WP_Query($args);
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();

                $post_type = get_post_meta($post->ID,'_victory_meta_box_to_post', true)?get_post_meta($post->ID,'_victory_meta_box_to_post', true):0;
                if($post_type ):
                    $id = $post->ID;
                    foreach ($post_type as $item):
                    add_meta_box('meta_box_meta_box_id', $post->post_title, array($this,'view_current_box'),$item, 'normal', 'high',array('id' => $id));
                    endforeach;
                endif;
            endwhile;
        endif;

        $wp_query = null;
        $wp_query = $temp;
        wp_reset_postdata();
        
    }

    /**
     * Функция вывода елементов на страницу поста
     */
    public function view_current_box($post, $data){
        wp_nonce_field( basename(__FILE__), 'victory_meta_nonce_field' );
        $template = '';
        $field  = get_post_meta($data['args']['id'],'_victory_meta_block', true);
        if(is_array($field)){
            echo "<div class='victory-main-post-block'>";
            foreach ($field as $item){
                $html_element = new HtmlElement(0, $item);
                $html_element->view_for_post_meta_box($post->ID);
                //$template .= "<div class='victory-main-post-element-block'>".$field_type."</div>";
            }
            echo "</div>";
        }
    }

    public function init_fields_type(){
        $this->fields_type = array(
            array(
                'type' => 'text',
                'desc' => 'Текстовое поле (однострочное)'
            ),
            array(
                'type' => 'textarea',
                'desc' => 'Текстовое поле (многострочное)'
            ),
            array(
                'type' => 'checkbox',
                'desc' => 'Флажок'
            ),
            array(
                'type' => 'radio',
                'desc' => 'Переключатель'
            ),
            array(
                'type' => 'select',
                'desc' => 'Выпадающий список'
            ),
            array(
                'type' => 'img',
                'desc' => 'Изображение'
            ),
            array(
                'type' => 'taxonomy',
                'desc' => 'Категория *demo'
            ),
        );
    }
    /**
     * Функция создаёт тип записи для хранения списка блоков с дополнительными полями
     */
    public function victory_register_post_type(){
        $args = array(
            'public' => true,
            'show_ui' => true, // показывать интерфейс в админке
            'show_in_menu' => 0,
            'has_archive' => false,
            'menu_position' => 83, // порядок в меню
            'supports' => array('title')
        );
        register_post_type('victory_meta_type', $args);
    }
    /**
     * Функция добавления дополнительных полей к типам записи
     */
    public function victory_post_type_meta_box($post){
        wp_nonce_field( basename(__FILE__), 'victory_meta_nonce_field' );
    ?>
        <div class="victory-meta-block" >
            <div class="victory-meta-block-v1">
                <div class="victory-meta-block-add-el">
                    <select id="victory_add_new_element_select" class="">
                        <?php foreach ($this->fields_type as $item):?>
                            <option value="<?php echo $item['type'];?>"><?php echo $item['desc'];?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="button" id="victory_add_new_element_button" value="Добавить выбраный елемент">
                </div>
                <div id="victory-add-block-area" class="victory-add-block-area">
                    <?php echo $this->view_meta_box(); ?>
                </div>
            </div>
        </div>
    <?php
    }

    /**
     * Функция вывода постов для их выбора
     */
    public function victory_post_type_box(){
        global $post;
        ?>
        <div class="victory-meta-block" >
            <?php
                $args = array(
                    'public'   => true
                );

                $output = 'object'; // names or objects, note names is the default
                $operator = 'and'; // 'and' or 'or'

                $post_types = get_post_types( $args, $output, $operator );
            $post_type_save = get_post_meta($post->ID,'_victory_meta_box_to_post', true)?get_post_meta($post->ID,'_victory_meta_box_to_post', true):0;

            foreach ( $post_types as $key => $post_type ) {
                if(strcmp($key,'victory_meta_type') != 0 && strcmp($key,'victory_post_type') != 0){
                    $selected = '';
                    if(is_array($post_type_save)){
                        if(isset($post_type_save[$key])){
                            $selected = 'checked';
                        }
                    }
                    echo "<p><label><input $selected type='checkbox' name='victory_meta_box_to_post[$key]' value='$key'>{$post_type->labels->name} ($key)</label></p>";
                }

            }?>

        </div>
        <?php
    }
    /**
     * Функция добавляет дополнительные поля на страницу создания типов записей
     */
    public function victory_load_post_type_meta_box() {
        add_meta_box('meta_box_meta_box_id', 'Создание дополнительных полей', array($this,'victory_post_type_meta_box'),'victory_meta_type', 'normal', 'high');
        add_meta_box('victory_post_type_box_id', 'Прикрепить к типу записей', array($this,'victory_post_type_box'),'victory_meta_type', 'side', 'low');
    }
    /**
     * Функция сохранения дополнительных полей
     */
    public function victory_meta_type_meta_box_data_save ( $post_id ) {
        // проверяем, пришёл ли запрос со страницы с метабоксом
        if ( !isset( $_POST['victory_meta_nonce_field'] )
            || !wp_verify_nonce( $_POST['victory_meta_nonce_field'], basename( __FILE__ ) ) )
           return $post_id;
        // проверяем, является ли запрос автосохранением
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
            return $post_id;
        // проверяем, права пользователя, может ли он редактировать записи
        if ( !current_user_can( 'edit_post', $post_id ) )
            return $post_id;
        // теперь также проверим тип записи
        $post = get_post($post_id);

        if ($post->post_type == 'victory_meta_type')
        {
            if(isset($_POST['victory_meta_block']) && is_array($_POST['victory_meta_block'])){
                $arr = $_POST['victory_meta_block'];
                update_post_meta($post_id,'_victory_meta_block', $arr);
            }
            if(isset($_POST['victory_meta_box_to_post']) && is_array($_POST['victory_meta_box_to_post']) ){
                update_post_meta($post_id,'_victory_meta_box_to_post', $_POST['victory_meta_box_to_post']);
            }else{
                update_post_meta($post_id,'_victory_meta_box_to_post', 0);
            }
        }
        if(isset($_POST['victory_meta'])){
            update_post_meta($post_id,'_victory_meta', $_POST['victory_meta']);
            //Сохранение данных метаполей поста
        }
        return $post_id;
    }
    /**
     * Функция вывода елементов в панель администратора
     */
    public function view_meta_box(){
        global $post;
        $template = '';
        $field  = get_post_meta($post->ID,'_victory_meta_block', true);
        if(is_array($field)){
            $count = count($field)-1;
            foreach ($field as $item){
                $html_element = new HtmlElement($count, $item);
                    $field_type = $html_element->view_for_add_block();
                    $template .="
                 <div id='field_item' class='field_item' el-number='$count'> 
                    $field_type
                 <button id='delete_field' type='button' class='field_item_delete_btn button' title='Удалить ?'>&times;</button>
                 </div>
                    ";
                $count --;
            }
        }
        return $template;
    }
}

class HtmlElement{
    public $element_type;
    public $element_number;
    public $fields;
    public $name_use      = 'victory_meta'; //Имя используется для хранения метаданных поста
    public $name_create   = 'victory_meta_block';
    public $id_use_prefix = 'victory_meta_id_';

    public $prefix = 'victory_meta';

    /**
     * HtmlElement constructor.
     * @param $num Номер блока по очереди
     * @param $args
     */
    public function __construct($num, $args)
    {
        $this->element_type = (isset($args['type']) && $args['type'] != '')?$args['type']:'text';
        $this->element_number = $num;
        unset($args['type']);
        $this->fields = $args;
    }

    //Вывод елементов для созданого пользователями постов
    public function view_for_post_meta_box($post_id){

        $template = '';
        $value = '';
        switch ($this->element_type){
            case 'text':
                $name = $this->name_use.'['.$this->fields['name'].']';
                $id = $this->id_use_prefix.$name;
                $class = $this->prefix.'_text';
                $value = get_post_meta($post_id,'_victory_meta', true)?get_post_meta($post_id,'_victory_meta', true):'';
                if(is_array($value)){
                    $value = $value[$this->fields['name']];
                }
                echo "<div class='victory-main-post-element-block'>";
                echo "<h2>".$this->fields['label']."</h2>";
                echo "<input type='text' name='$name' class='$class' value='$value'>";
                echo "</div>";

                break;
            case 'textarea':
                $name = $this->name_use.'['.$this->fields['name'].']';
                $id = $this->id_use_prefix.$name;
                $class = $this->prefix.'_textarea';
                $value = get_post_meta($post_id,'_victory_meta', true)?get_post_meta($post_id,'_victory_meta', true):'';
                if(is_array($value)){
                    $value = $value[$this->fields['name']];
                }

                echo "<div class='victory-main-post-element-block'>";
                echo "<h2>".$this->fields['label']."</h2>";
                wp_editor($value, ($this->fields['name']).'_id', array(
                    'wpautop' => 1,
                    'media_buttons' => 1,
                    'textarea_name' => $name,
                    'textarea_rows' => 8,
                    'tabindex'      => null,
                    'editor_css'    => '',
                    'editor_class'  => '',
                    'teeny'         => 0,
                    'dfw'           => 0,
                    'tinymce'       => 1,
                    'quicktags'     => 1,
                    'drag_drop_upload' => false
                ) );
                echo "</div>";
                break;
            case 'img':
                $name = $this->name_use.'['.$this->fields['name'].']';
                $id = $this->id_use_prefix.$name;
                $class = $this->prefix.'_img';
                $value = get_post_meta($post_id,'_victory_meta', true)?get_post_meta($post_id,'_victory_meta', true):'';
                $img_src = '';
                if(is_array($value)){
                    $value = $value[$this->fields['name']];
                    $img_src = wp_get_attachment_url($value);
                }

                echo "<div class='victory-main-post-element-block'>";
                echo "<h2>".$this->fields['label']."</h2>";
                echo "<img src='$img_src'>";
                echo "<input type='hidden' name='$name' value='$value'>";
                echo "<input type='button' id='victory_img_loader' value='Загрузить'>";
                echo "</div>";
                break;
            case 'checkbox':
                $name = $this->name_use.'['.$this->fields['name'].']';
                $id = $this->id_use_prefix.$name;
                $class = $this->prefix.'_text';
                $value = get_post_meta($post_id,'_victory_meta', true)?get_post_meta($post_id,'_victory_meta', true):'';
                $checked = '';
                if(is_array($value)){
                    $value = $value[$this->fields['name']];
                    $checked = 'checked';
                }
                echo "<div class='victory-main-post-element-block'>";
                echo "<h2>".$this->fields['label']."</h2>";
                echo "<input type='checkbox' name='$name' class='$class' value='1' $checked>";
                echo "</div>";
                break;
            case 'taxonomy':
                $name = $this->name_use.'['.$this->fields['name'].']';
                $value = get_post_meta($post_id,'_victory_meta', true)?get_post_meta($post_id,'_victory_meta', true):'';

                if(is_array($value)){
                    $value = $value[$this->fields['name']];
                }

                echo "<div class='victory-main-post-element-block'>";
                echo "<h2>".$this->fields['label']."</h2>";
                echo $this->view_taxonomy_select_by_param($name, $value);
                echo "</div>";
                break;
        }

    }
    //Вывод елементов ввода для плагина при создании нового блока
    public function view_for_add_block(){
        $template = '';
        switch ($this->element_type){
            case 'text':
                $name['name']  = $this->name_create.'['.$this->element_number.'][name]';
                $name['type']  = $this->name_create.'['.$this->element_number.'][type]';
                $name['label'] = $this->name_create.'['.$this->element_number.'][label]';
                $value = $this->fields;

                $template = "
                <h2>Текстовое поле (однострочное)</h2>
                <input type='hidden' name='{$name['type']}' value='text'>
                <label>Name (уникальный параметр): <input type='text' name='{$name['name']}' value='{$value['name']}'></label>
                <label>Название поля: <input type='text' name='{$name['label']}' value='{$value['label']}'></label>
                ";
                break;
            case 'textarea':
                $name['name']  = $this->name_create.'['.$this->element_number.'][name]';
                $name['type']  = $this->name_create.'['.$this->element_number.'][type]';
                $name['label'] = $this->name_create.'['.$this->element_number.'][label]';
                $value = $this->fields;

                $template = "
                <h2>Текстовое поле (многострочное)</h2>
                <input type='hidden' name='{$name['type']}' value='textarea'>
                <label>Name (уникальный параметр): <input type='text' name='{$name['name']}' value='{$value['name']}'></label>
                <label>Название поля: <input type='text' name='{$name['label']}' value='{$value['label']}'></label>
                ";
                break;
            case 'img':
                $name['name']  = $this->name_create.'['.$this->element_number.'][name]';
                $name['type']  = $this->name_create.'['.$this->element_number.'][type]';
                $name['label'] = $this->name_create.'['.$this->element_number.'][label]';
                $value = $this->fields;

                $template = "
                <h2>Изображение</h2>
                <input type='hidden' name='{$name['type']}' value='img'>
                <label>Name (уникальный параметр): <input type='text' name='{$name['name']}' value='{$value['name']}'></label>
                <label>Название поля: <input type='text' name='{$name['label']}' value='{$value['label']}'></label>
                ";
                break;
            case 'checkbox':
                $name['name']  = $this->name_create.'['.$this->element_number.'][name]';
                $name['type']  = $this->name_create.'['.$this->element_number.'][type]';
                $name['label'] = $this->name_create.'['.$this->element_number.'][label]';
                $value = $this->fields;

                $template = "
                <h2>Флажок</h2>
                <input type='hidden' name='{$name['type']}' value='checkbox'>
                <label>Name (уникальный параметр): <input type='text' name='{$name['name']}' value='{$value['name']}'></label>
                <label>Название поля: <input type='text' name='{$name['label']}' value='{$value['label']}'></label>
                ";
                break;
            case 'taxonomy':
                $name['name']  = $this->name_create.'['.$this->element_number.'][name]';
                $name['type']  = $this->name_create.'['.$this->element_number.'][type]';
                $name['label'] = $this->name_create.'['.$this->element_number.'][label]';
                $value = $this->fields;

                $template = "
                <h2>Категория (category) <b>*demo</b></h2>
                <input type='hidden' name='{$name['type']}' value='taxonomy'>
                <label>Name (уникальный параметр): <input type='text' name='{$name['name']}' value='{$value['name']}'></label>
                <label>Название поля: <input type='text' name='{$name['label']}' value='{$value['label']}'></label>
                ";
                break;
        }

        return $template;
    }
    //Функция вывода елементов для выбора рубрик поста - доработать, добавить динамику
    function view_taxonomy_select_by_param($name, $value, $param = array('type'=>'post','taxonomy'=>'category')){
            if(!is_array($param)){
                $param = array('type'=>'post','taxonomy'=>'category');
            }
            if(!isset($param['type']) && !post_type_exists($param['type'])){
                $param['type'] = 'post';
            }
            if(!isset($param['taxonomy']) && taxonomy_exists($param['taxonomy'])){

            }

            $value = isset($value)?$value:'';
            $args = array(
            'type'         => $param['type'],
            'orderby'      => 'name',
            'order'        => 'ASC',
            'hide_empty'   => 1,
            'hierarchical' => 'true',
            'exclude'      => '',
            'include'      => '',
            'number'       => 0,
            'taxonomy'     => $param['taxonomy']
                // полный список параметров смотрите в описании функции http://wp-kama.ru/function/get_terms
            );


            $categories = get_categories( $args );

            if(strcmp($value,  '') == 0){
            $select = 'select = "selected"';
            }
            $option = '<option value="" '.$select.'>Не выбрано</option>';

            if( $categories ){
                foreach( $categories as $cat ){
                    $url = get_term_link($cat->slug, 'product_cat');
                    $select = '';
                    if(strcmp($value,  $url) == 0){
                        $select = 'selected = "selected"';
                    }
                    $option .= '<option '.$select.' value="' .$url. '">';
                    $option .= $cat->name;;
                    $option .= '</option>';

                }
                return '<select name="'.$name.'">
                                  '.$option.'
                                </select>
                              ';

            }else{
                return 0;
            }

}
}