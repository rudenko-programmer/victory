$ = jQuery;
$(function () {
    function AddFieldApi() {
        var data = {
                field_type_select:    'victory_add_new_element_select',
                add_new_field_button: 'victory_add_new_element_button',
                field_area:           'victory-add-block-area',
                field_delete_button:  'delete_field'
            };
        var name_create = 'victory_meta_block';
        var object = this;

        this.init = function () {
            object.initAddNewBlockButton();
            object.initDeleteButton();
            object.initDragable();
        };
        this.initDragable = function () {
            $('#victory-add-block-area').sortable({
                containment: 'parent',cursor:"pointer",placeholder:"sortable-js"
            });
        };
        this.addField = function () {
            var type_block = '';
            switch (object.getFieldType()){
                case 'text':
                    type_block = object.fieldText();
                    break;
                case 'textarea':
                    type_block = object.fieldTextarea();
                    break;
                case 'img':
                    type_block = object.fieldImg();
                    break;
                case 'checkbox':
                    type_block = object.fieldCheckbox();
                    break;
                case 'taxonomy':
                    type_block = object.fieldTaxonomy();
                    break;
            }
            if(type_block == '') return '';

            return ""+
                "<div id='field_item' class='field_item' el-number='"+object.getNextBlockNumber()+"'>"+
                type_block +
                "<button id='"+this.getDelButtonId()+"' type='button' class='field_item_delete_btn button' title='Удалить ?'>&times;</button>"+
                "</div>";
        };
        this.fieldText = function () {
            var name = name_create+"["+object.getNextBlockNumber()+"]";
            return "" +
                "<h2>Текстовое поле (однострочное)</h2>"+
                "<input type='hidden' name='"+name+"[type]' value='text'>"+
                "<label>Name (уникальный параметр): <input type='text' name='"+name+"[name]' value=''></label>"+
                "<label>Название поля: <input type='text' name='"+name+"[label]' value=''></label>";
        };
        this.fieldTextarea = function () {
            var name = name_create+"["+object.getNextBlockNumber()+"]";
            return "" +
                "<h2>Текстовое поле (многострочное)</h2>"+
                "<input type='hidden' name='"+name+"[type]' value='textarea'>"+
                "<label>Name (уникальный параметр): <input type='text' name='"+name+"[name]' value=''></label>"+
                "<label>Название поля: <input type='text' name='"+name+"[label]' value=''></label>";
        };
        this.fieldImg = function () {
            var name = name_create+"["+object.getNextBlockNumber()+"]";
            return "" +
                "<h2>Изображение</h2>"+
                "<input type='hidden' name='"+name+"[type]' value='img'>"+
                "<label>Name (уникальный параметр): <input type='text' name='"+name+"[name]' value=''></label>"+
                "<label>Название поля: <input type='text' name='"+name+"[label]' value=''></label>";
        };
        this.fieldCheckbox = function () {
            var name = name_create+"["+object.getNextBlockNumber()+"]";
            return "" +
                "<h2>Флажок</h2>"+
                "<input type='hidden' name='"+name+"[type]' value='checkbox'>"+
                "<label>Name (уникальный параметр): <input type='text' name='"+name+"[name]' value=''></label>"+
                "<label>Название поля: <input type='text' name='"+name+"[label]' value=''></label>";
        };
        this.fieldTaxonomy = function () {
            var name = name_create+"["+object.getNextBlockNumber()+"]";
            return "" +
                "<h2>Категория (category) <b>*demo</b></h2>"+
                "<input type='hidden' name='"+name+"[type]' value='taxonomy'>"+
                "<label>Name (уникальный параметр): <input type='text' name='"+name+"[name]' value=''></label>"+
                "<label>Название поля: <input type='text' name='"+name+"[label]' value=''></label>";
        };
        /**
         * Функция инициализации кнопки добавления блока
         */
        this.initAddNewBlockButton = function () {
            $('#'+object.getAddButtonId()).click(function () {
                $('#'+object.getAreaId()).prepend(object.addField());
            });
        };
        /**
         * Функция выводит значение типа елемента
         */
        this.getFieldType = function () {
            return $('#'+object.getAddSelectId()+' :selected').val();
        };
        /**
         * Функция выводит значение id площади колекции елементов
         */
        this.getAreaId = function () {
            return data.field_area;
        };
        /**
         * Функция выводит значение id кнопки добавления елемента
         */
        this.getAddButtonId = function () {
            return data.add_new_field_button;
        };
        /**
         * Функция выводит значение id поля выбора типа поля
         */
        this.getAddSelectId = function () {
            return data.field_type_select;
        };
        /**
         * Функция выводит значение id кнопки удаления блока
         */
        this.getDelButtonId = function () {
            return data.field_delete_button;
        };
        /**
         * Функция инициализации кнопок удаления блоков
         */
        this.initDeleteButton = function (){
            $('button#'+this.getDelButtonId()).live('click',function () {
                if(confirm('Вы уверены что хотите удалить ?')){
                    $(this).parent().remove();
                }
            });
        }
        this.getNextBlockNumber = function () {
            var block_col = $('#'+this.getAreaId()).find('div.field_item');
            if(block_col.length != 0){ return parseInt(block_col.length);}
            return 0;
        }
        return this;
    }

    function AdminAPI() {
        var data = {
            add_img_button_id:'victory_img_loader'
        };
        var object = this;

        this.init = function () {
            object.initImgLoadButton();
        };
        this.initImgLoadButton = function () {
          $('#'+object.getAddImgButtonId()).live('click',function () {
              object.imgLoader(this);
          });
        };
        /**
         * Функция отвечает за загрузку изображения
         * @param object кнопка загрузки изображения
         * @returns {boolean}
         */
        this.imgLoader = function (object) {
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = $(object);//Проверить на корректность
            wp.media.editor.send.attachment = function (props, attachment) {
                $(button).prev().prev().attr('src', attachment.url);
                $(button).prev().attr('value',attachment.id);
                wp.media.editor.send.attachment = send_attachment_bkp;
            }
            wp.media.editor.open(button);
            return false;
        };
        /**
         * Функция выводит значение id Кнопки добавления фото в к посту
         */
        this.getAddImgButtonId = function () {
            return data.add_img_button_id;
        };
    }
    var add_field_api = new AddFieldApi();
    add_field_api.init();
    var admin_api = new AdminAPI();
    admin_api.init();
});