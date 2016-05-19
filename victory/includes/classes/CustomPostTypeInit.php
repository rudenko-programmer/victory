<?php

class CustomPostTypeInit{
    
    function __construct()
    {
        //Инициализация типа поста для хранения пользовательских типов записей
        add_action( 'init', array($this,'victory_register_post_type') );
        //Инициализация кастомных типов постов созданых пользователями
        add_action( 'init', array($this,'victory_custom_post_type_init') );
        //Добавляем мета бокс для добавления опций на страницу добавления пользовательского типа записи
        add_action( 'admin_menu', array($this,'victory_load_post_type_meta_box') );
        //Сохранение значений введённых в мета бокс
        add_action('save_post', array($this,'victory_post_type_meta_box_data_save'));
    }

    /**
     * Функция создаёт тип записи для хранения списка пользовательских типов записей
     */
    public function victory_register_post_type(){
        $args = array(
            'public' => true,
            'show_ui' => true, // показывать интерфейс в админке
            'show_in_menu' => 0,
            'has_archive' => false,
            'menu_icon' => 'dashicons-businessman', // иконка в меню
            'menu_position' => 82, // порядок в меню
            'supports' => array('title')
        );
        register_post_type('victory_post_type', $args);
    }

    /**
     * Функция загружает типы записей созданые пользователями
     */
    public function victory_custom_post_type_init() {

        global $post;
        global $wp_query;

        $temp = $wp_query;
        $wp_query = null;
        $args = array( 'post_type' => 'victory_post_type',
            'posts_per_page' => '-1',
            'order' => 'ASC'
        );
        $wp_query = new WP_Query($args);
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                $p_t_status  = get_post_meta($post->ID,'_p_t_status', true)?get_post_meta($post->ID,'_p_t_status', true):'0';
                $p_t_name  = get_post_meta($post->ID,'_p_t_name', true)?get_post_meta($post->ID,'_p_t_name', true):'';

                if(!post_type_exists($p_t_name) && $p_t_status == '1'){
                    $args = array();


                    $p_t_labels  = get_post_meta($post->ID,'_p_t_labels', true)?get_post_meta($post->ID,'_p_t_labels', true):'';
                    $p_t_supports  = get_post_meta($post->ID,'_p_t_supports', true)?get_post_meta($post->ID,'_p_t_supports', true):'';
                    $p_t_menu_position  = get_post_meta($post->ID,'_p_t_menu_position', true)?get_post_meta($post->ID,'_p_t_menu_position', true):'26';
                    $p_t_menu_icon  = get_post_meta($post->ID,'_p_t_menu_icon', true)?get_post_meta($post->ID,'_p_t_menu_icon', true):'dashicons-admin-post';
                    $p_t_public  = get_post_meta($post->ID,'_p_t_public', true)?get_post_meta($post->ID,'_p_t_public', true):'1';
                    $p_t_hierarchical  = get_post_meta($post->ID,'_p_t_hierarchical', true)?get_post_meta($post->ID,'_p_t_hierarchical', true):'0';
                    $p_t_exclude_from_search  = get_post_meta($post->ID,'_p_t_exclude_from_search', true)?get_post_meta($post->ID,'_p_t_exclude_from_search', true):'0';

                    if(is_array($p_t_labels) && $p_t_labels != ''){
                        $args['labels'] = array(
                            'name'          => isset($p_t_labels['name']) && $p_t_labels['name'] !='' ?$p_t_labels['name']:'Записи',
                            'singular_name' => isset($p_t_labels['singular_name'])  && $p_t_labels['singular_name'] !=''?$p_t_labels['singular_name']:'Запись',
                            'add_new'       => isset($p_t_labels['add_new']) && $p_t_labels['add_new'] !=''?$p_t_labels['add_new']:'Добавить новую',
                            'add_new_item'  => isset($p_t_labels['add_new_item']) && $p_t_labels['add_new_item'] !=''?$p_t_labels['add_new_item']:'Добавить новую запись',
                            'edit_item'     => isset($p_t_labels['edit_item']) && $p_t_labels['edit_item'] !=''?$p_t_labels['edit_item']:'Редактировать запись',
                            'new_item'      => isset($p_t_labels['new_item']) && $p_t_labels['new_item'] !=''?$p_t_labels['new_item']:'Новая запись',
                            'view_item'     => isset($p_t_labels['view_item']) && $p_t_labels['view_item'] !=''?$p_t_labels['view_item']:'Посмотреть запись',
                            'search_items'  => isset($p_t_labels['search_items']) && $p_t_labels['search_items'] !=''?$p_t_labels['search_items']:'Найти запись',
                            'not_found'     => isset($p_t_labels['not_found']) && $p_t_labels['not_found'] !=''?$p_t_labels['not_found']:'Запись не было найдено',
                            'not_found_in_trash'    => isset($p_t_labels['not_found_in_trash']) && $p_t_labels['not_found_in_trash'] !=''?$p_t_labels['not_found_in_trash']:'Запись не было найдено в корзине',
                            'parent_item_colon'     => isset($p_t_labels['parent_item_colon']) && $p_t_labels['parent_item_colon'] !=''?$p_t_labels['parent_item_colon']:'Родительская запись',
                            'menu_name'     => isset($p_t_labels['menu_name']) && $p_t_labels['menu_name'] !=''?$p_t_labels['menu_name']:'Записи'
                        );
                    }
                    if(is_array($p_t_supports) && $p_t_supports != ''){
                        $supports = array();
                        foreach ($p_t_supports as $item){
                            array_push($supports,$item);
                        }
                        $args['supports'] = $supports;
                    }

                    $args['menu_position'] = (int)$p_t_menu_position;
                    $args['menu_icon'] = $p_t_menu_icon;
                    $args['public'] = (bool)$p_t_public;
                    $args['hierarchical'] = (bool)$p_t_hierarchical;
                    $args['exclude_from_search'] = (bool)$p_t_exclude_from_search;
                    //Добавить фильтр в который будут передаватся параметры $p_t_name $args
                    //Регистрируем новый тип
                    register_post_type($p_t_name,$args);

                }
            endwhile;
        endif;
        $wp_query = null;
        $wp_query = $temp;
        wp_reset_postdata();

    }
    /**
     * Функция добавления дополнительных полей к типам записи
     */
    function victory_post_type_meta_box($post){
        /**
         * Поскольку файл с настройками опций вынесен в отдельный файл, то необходимо чтобы basename(__FILE__) функций совпадали
         */
        global $nonce_field_basename;
        $nonce_field_basename = basename(__FILE__);

        require_once VICTORY_DIR.'/includes/templates/post_type_create_page.php';
    }
    /**
     * Функция добавляет дополнительные поля на страницу создания типов записей
     */
    function victory_load_post_type_meta_box() {
        add_meta_box('post_type_meta_box_id', 'Настройки типа поста', array($this,'victory_post_type_meta_box'),'victory_post_type', 'normal', 'high');
    }
    /**
     * Функция сохранения дополнительных полей
     */
    function victory_post_type_meta_box_data_save ( $post_id ) {
        // проверяем, пришёл ли запрос со страницы с метабоксом
        if ( !isset( $_POST['victory_post_type_nonce_field'] )
            || !wp_verify_nonce( $_POST['victory_post_type_nonce_field'], basename( __FILE__ ) ) )
            return $post_id;
        // проверяем, является ли запрос автосохранением
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
            return $post_id;
        // проверяем, права пользователя, может ли он редактировать записи
        if ( !current_user_can( 'edit_post', $post_id ) )
            return $post_id;
        // теперь также проверим тип записи
        $post = get_post($post_id);

        if ($post->post_type == 'victory_post_type')
        {
            if(isset($_POST['p_t_status'])){ update_post_meta($post->ID,'_p_t_status', $_POST['p_t_status']); }
            else{ update_post_meta($post->ID,'_p_t_status', '0');}
            if(isset($_POST['p_t_name'])){
                update_post_meta($post->ID,'_p_t_name', trim($_POST['p_t_name']));
            }
            else{ update_post_meta($post->ID,'_p_t_name', '');}
            if(isset($_POST['p_t_menu_position'])){ update_post_meta($post->ID,'_p_t_menu_position', $_POST['p_t_menu_position']); }
            else{ update_post_meta($post->ID,'_p_t_menu_position', '26');}
            if(isset($_POST['p_t_supports'])){ update_post_meta($post->ID,'_p_t_supports', $_POST['p_t_supports']); }
            else{ update_post_meta($post->ID,'_p_t_supports', '');}
            if(isset($_POST['p_t_menu_icon'])){ update_post_meta($post->ID,'_p_t_menu_icon', $_POST['p_t_menu_icon']); }
            else{ update_post_meta($post->ID,'_p_t_menu_icon', '');}
            if(isset($_POST['p_t_labels'])){ update_post_meta($post->ID,'_p_t_labels', $_POST['p_t_labels']); }
            else{ update_post_meta($post->ID,'_p_t_labels', '');}
            if(isset($_POST['p_t_public'])){ update_post_meta($post->ID,'_p_t_public', $_POST['p_t_public']); }
            else{ update_post_meta($post->ID,'_p_t_public', '');}
            if(isset($_POST['p_t_hierarchical'])){ update_post_meta($post->ID,'_p_t_hierarchical', $_POST['p_t_hierarchical']); }
            else{ update_post_meta($post->ID,'_p_t_hierarchical', '');}
            if(isset($_POST['p_t_exclude_from_search'])){ update_post_meta($post->ID,'_p_t_exclude_from_search', $_POST['p_t_exclude_from_search']); }
            else{ update_post_meta($post->ID,'_p_t_exclude_from_search', '');}

        }
        return $post_id;
    }
}