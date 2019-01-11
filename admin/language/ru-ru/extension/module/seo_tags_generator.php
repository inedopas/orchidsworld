<?php
/**
 * @category   OpenCart
 * @package    SEO Tags Generator
 * @copyright  © Serge Tkach, 2017, https://opencartforum.com/profile/717101-sergetkach/
 */
// Heading
$_['heading_title'] = 'Seo Tags Generator';


// Text
$_['text_extension']      = 'Модули';
$_['text_success']        = 'Настройки модуля обновлены!';
$_['text_edit']           = 'Редактирование модуля';
$_['text_available_vars'] = 'Доступные переменные';

$_['text_author']         = 'Автор';  // v1.3
$_['text_author_support'] = 'Поддержка';  // v1.3
// Fieldsets
$_['fieldset_setting']          = 'Настройки'; // v1.3
$_['fieldset_formula_common']   = 'Общая формула'; // v1.3

// Tab
$_['tab_category']     = 'Формулы для категории';
$_['tab_product']      = 'Формулы для товаров этой категории';
$_['tab_manufacturer'] = 'Производители';


// Entry
$_['entry_licence']              = 'Код лицензии';
$_['entry_temp_licence']         = 'Код временной лицензии';
$_['entry_temp_licence_tooltip'] = 'Временная лицензия позволяет начать работу с модулем пока Вы ожидаете постоянной';

$_['entry_status'] = 'Статус модуля';

$_['entry_generate_mode_category']             = 'Генерировать мета-теги для категорий';
$_['entry_generate_mode_product']              = 'Генерировать мета-теги для товаров';
$_['entry_generate_mode_manufacturer']         = 'Генерировать мета-теги для производителей';
$_['entry_generate_mode_manufacturer_tooltip'] = 'Мета-теги производителей на сайте будет сгенерированы по формулам для производителей, даже если будет заполнено в админке';

$_['text_generate_mode_nofollow'] = 'Не генерировать';
$_['text_generate_mode_empty']    = 'Только, если мета-теги пусты';
$_['text_generate_mode_forced']   = 'Даже, если мета-теги уже заполнены в админке';

$_['entry_status_product_h1']         = 'Генерировать H1 товара принудительно';
$_['entry_status_product_h1_tooltip'] = 'Название товара на сайте будет сгенерировано по формуле H1 для товаров, даже если будет заполнено в админке';

$_['entry_inheritance']         = 'Наследование формул от родительской категории к дочерней';
$_['entry_inheritance_tooltip'] = 'Если для родительской категории MP3-плееры указана специфическая (недефолтная) формула, то как поступать, если для ее дочерней категории MP3-плееры Transcend формула не указана?<br> Считать ли, что раз эта категория дочерняя, то использовать формулу родителя?';

$_['entry_declension']         = 'Использовать падежи для названия категорий';
$_['entry_declension_tooltip'] = 'Если опция включена, то для всех категорий необходимо вручную вписать падежи. Если Вы не готовы это сделать, то лучше не включайте данную опцию';




$_['entry_category_title']       = 'Тег Title';
$_['entry_category_description'] = 'Тег Description';
$_['entry_category_keyword']     = 'Тег Keywords'; // v1.4

$_['entry_product_h1']          = 'Тег H1';
$_['entry_product_title']       = 'Тег Title';
$_['entry_product_description'] = 'Тег Description';
$_['entry_product_keyword']     = 'Тег Keywords'; // v1.4

$_['entry_manufacturer_title']       = 'Тег Title';
$_['entry_manufacturer_description'] = 'Тег Description';
$_['entry_manufacturer_keyword']     = 'Тег Keywords'; // v1.4


$_['entry_category'] = 'Использовать данную формулу в категории:'; // v1.3
$_['help_category']  = '(Автозаполнение)'; // v1.3



// Для админки категорий

$_['fieldset_seo_tags_generator']             = 'Склонение названия категории (для модуля SEO Tags Generator)'; // v2.0.x
$_['entry_category_name_plural_nominative']   = 'Полное название категории (в мн.ч. им.пад):';
$_['entry_category_name_plural_genitive']     = 'Название категории в мн.ч. род.пад:';
$_['entry_category_name_singular_nominative'] = 'Определяющее слово товара (Название категории в ед.ч. им.пад):';

$_['entry_category_meta_stg_no_auto']      = 'Использовать вручную вписанные мета-теги для данной категории';
$_['entry_category_meta_stg_no_auto_help'] = 'Мета-теги генерируются по формуле в момент создания страницы. Отмеченная галочка означает, что мета-теги данной категории будут браться из базы данных и будут соответствовать тому, что сохранено в админке.';
$_['text_category_explain_stg_no_auto']    = 'Модуль <b>SEO Tags Generator</b> генерирует <i>title</i>, <i>мета-тег description</i>, <i>мета-тег keywords</i>'; // v2.0.x

$_['text_stg_preview']      = 'Какие мета-теги генерирует модуль SEO Tags Generator?'; // v2.1

$_['tab_seo_tags_generator']      = 'SEO Формулы'; // v2.0.x
$_['tab_seo_tags_generator_info'] = '<i class="fa fa-info-circle"></i> Внимание!<br>Используйте данную вкладку только в тех случаях:<br>'
        . '- если Вы хотите задать для отдельно взятой категории специфические формулы генерации мета-тегов<br>'
        . '- если Вы хотите задать отдельные форумлы для всех товаров данной категории'; // v2.0.x

$_['tab_category_setting']               = 'Настройки категории'; // v2.0.x
$_['entry_category_setting_inheritance'] = 'Наследование формул в дочерних категориях, если те будут пусты'; // v2.0.x
$_['text_inheritance_yes']               = 'Наследовать'; // v2.0.x
$_['text_inheritance_no']                = 'Не наследовать'; // v2.0.x

$_['entry_category_setting_inheritance_copy'] = 'Скопировать данные формулы в дочерние подкатегории, чтобы в дальнейшем слегка подправить их'; // v2.0.x
$_['text_inheritance_copy_yes']               = 'Да'; // v2.0.x
$_['text_inheritance_copy_warning']           = 'Будьте осторожны!<br>'
        . 'Вы уже копировали эти формулы. И, возможно, там внесены изменения, которые не стоит перезаписывать'; // v2.0.x

$_['entry_category_setting_copy_to_others'] = 'Скопировать данные формулы в другие категории сайта'; // v2.0.x
$_['text_copy_to_others_yes']               = 'Да'; // v2.0.x
$_['text_copy_to_others_warning']           = 'Будьте осторожны!<br>'
        . 'Вы уже копировали эти формулы. И, возможно, там внесены изменения, которые не стоит перезаписывать'; // v2.0.x

$_['entry_categories']  = 'Выберите категории'; // v2.0.x
$_['text_select_all']   = 'Выбрать все'; // v2.0.x
$_['text_unselect_all'] = 'Снять выбор со всех'; // v2.0.x
// Для админки товара

$_['entry_product_meta_stg_no_auto']      = 'Использовать вручную вписанные мета-теги для данного товара';
$_['entry_product_meta_stg_no_auto_help'] = 'Мета-теги генерируются по формуле в момент создания страницы. Отмеченная галочка означает, что мета-теги данного товара будут браться из базы данных и будут соответствовать тому, что сохранено в админке.';
$_['text_product_explain_stg_no_auto']    = 'Модуль <b>SEO Tags Generator</b> генерирует <i>title</i>, <i>мета-тег description</i>, <i>мета-тег keywords</i> и <i>h1</i> для товара. <span style="color: red; ">Поле "Теги товара" НЕ генерируется</span>. <br><br>Галочка находится здесь потому что, именно здесь заканчивается разделение языковых версий'; // v2.0.x

$_['entry_model_synonym'] = 'Синоним модели';


//button
$_['button_save']   = 'Сохранить';
$_['button_cancel'] = 'Отмена';


// success
$_['success'] = 'Настройки модуля обновлены';


// warning
$_['warning_licence'] = 'Активирована временная лицензия на [x] дней! Для получения постоянной лицензии, обратитесь к авторму модуля по адресу <b>sergheitkach@gmail.com</b>!';


// Error
$_['error_permission'] = 'У вас нет прав для управления этим модулем!';
$_['error_warning']    = 'Ошибка! Настройки не сохранены. Исправьте указанные в форме ошибки и попробуйте сохранить снова! ';

$_['error_licence']           = 'Введите код лицензии!';
$_['error_licence_empty']     = 'Введите код лицензии!';
$_['error_licence_not_valid'] = 'Код лицензии не действителен!';


// Temp licence
$_['button_get_temp_licence']  = 'Запросить временную лицензию';
$_['success_get_temp_licence'] = 'Временная лицензия получена! Для продолжения работы с модулем обновите страницу!';
$_['error_get_temp_licence']   = 'Не удалось получить временную лицензию! Попробуйте получить ее еще раз!';

$_['error_get_temp_licence_server_off'] = 'Не найден сервер для получения лицензии! Обратитесь к автору модуля!';
$_['error_get_temp_licence_waiting']    = 'Время ожидания ответа от сервера получения лицензии превысило 5 секунд и было сброшено. Попробуйте позже еще раз!';
$_['error_get_temp_licence_404']        = 'Страница получения лицензии не найдена! Обратитесь к автору модуля!';
$_['error_get_temp_licence_expired']    = 'У временной лицензии истек срок действия!';

$_['error_valid_temp_licence'] = 'Недействительная временная лицензия!';
