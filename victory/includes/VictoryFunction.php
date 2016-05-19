<?php
/**
 * @param $post_id id поста(пользовательского типа записи) данные которого необходимо извлечь
 * @param $field_name имя поля параметры которого нужно извлечь
 * @param null $params дополнительные параметры НЕ ИСПОЛЬЗУЕТСЯ
 * @return string значение запрошеного поля
 */
function v_get_field($post_id, $field_name, $params = null){
    $field_name = htmlspecialchars($field_name);
    if(is_int($post_id) && $post_id > 0 && is_string($field_name) && $field_name != ''){
        $arr = get_post_meta($post_id,'_victory_meta', true)?get_post_meta($post_id,'_victory_meta', true):'';
        if(!is_array($arr)) return '';
        if(isset($arr[$field_name])){
            return $arr[$field_name];
        }
    }
    return '';
}