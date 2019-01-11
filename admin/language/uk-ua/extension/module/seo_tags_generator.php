<?php

/**
 * @category   OpenCart
 * @package    SEO Tags Generator
 * @copyright  © Serge Tkach, 2017, https://opencartforum.com/profile/717101-sergetkach/
 */

// Heading
$_['heading_title'] = 'Seo Tags Generator';


// Text
$_['text_extension']   = 'Модулі';
$_['text_success']     = 'Налаштування модуля оновлені!';
$_['text_edit']        = 'Редагування модуля';
$_['text_available_vars'] = 'Доступні змінні';

$_['text_author']        = 'Автор';  // v1.3
$_['text_author_support'] = 'Підтримка';  // v1.3


// Fieldsets
$_['fieldset_setting'] = 'Налаштування'; // v1.3
$_['fieldset_formula_common'] = 'Загальна формула'; // v1.3
$_['fieldset_formula_specific'] = 'Формули для специфічних категорій'; // v1.3


// Tab
$_['tab_category']     = 'Категорії';
$_['tab_product']      = 'Товари';
$_['tab_manufacturer'] = 'Виробники';


// Entry
$_['entry_licence']    = 'Код ліцензії';
$_['entry_temp_licence'] = 'Код тимачасової ліцензії';
$_['entry_temp_licence_tooltip'] = 'Тимчасова ліцензія дозволяє почати роботу з модулем, поки ви очикуєте реальний код ліцензії';

$_['entry_status']     = 'Статус модуля';

$_['entry_generate_mode_category']     = 'Генерировать мета-теги для категорий';
$_['entry_generate_mode_product']      = 'Генерировать мета-теги для товаров';
$_['entry_generate_mode_manufacturer'] = 'Генерировать мета-теги для производителей';
$_['entry_generate_mode_manufacturer_tooltip'] = 'Мета-теги производителей на сайте будет сгенерированы по формулам для производителей, даже если будет заполнено в админке';

$_['text_generate_mode_nofollow'] = 'Не генерировать';
$_['text_generate_mode_empty']    = 'Только, если мета-теги пусты';
$_['text_generate_mode_forced']   = 'Даже, если мета-теги уже заполнены в админке';

$_['entry_status_product_h1']  = 'Генерировать H1 товара принудительно';
$_['entry_status_product_h1_tooltip'] = 'Название товара на сайте будет сгенерировано по формуле H1 для товаров, даже если будет заполнено в админке';

$_['entry_inheritance'] = 'Наследование формул от родительской категории к дочерней';
$_['entry_inheritance_tooltip'] = 'Если для родительской категории MP3-плееры указана специфическая (недефолтная) формула, то как поступать, если для ее дочерней категории MP3-плееры Transcend формула не указана?<br> Считать ли, что раз эта категория дочерняя, то использовать формулу родителя?';


$_['entry_category_title'] = 'Тег Title';
$_['entry_category_description'] = 'Тег Description';
$_['entry_category_keyword'] = 'Тег Keywords'; // v1.4

$_['entry_product_h1'] = 'Тег H1';
$_['entry_product_title'] = 'Тег Title';
$_['entry_product_description'] = 'Тег Description';
$_['entry_product_keyword'] = 'Тег Keywords'; // v1.4

$_['entry_manufacturer_title'] = 'Тег Title';
$_['entry_manufacturer_description'] = 'Тег Description';
$_['entry_manufacturer_keyword'] = 'Тег Keywords'; // v1.4


$_['entry_category'] = 'Використовувати дану формулу в категорії:'; // v1.3
$_['help_category'] = '(Автоматичне заповнення)'; // v1.3

// Для админки категорий

$_['fieldset_seo_tags_generator'] = 'Склонение названия категории (для модуля SEO Tags Generator)'; // v1.6
$_['entry_category_name_plural_nominative']   = 'Полное название категории (в мн.ч. им.пад):';
$_['entry_category_name_plural_genitive']     = 'Название категории в мн.ч. род.пад:';
$_['entry_category_name_singular_nominative'] = 'Определяющее слово товара (Название категории в ед.ч. им.пад):';

$_['entry_category_meta_stg_no_auto']   	    = 'Использовать вручную вписанные мета-теги для данной категории';
$_['entry_category_meta_stg_no_auto_help']   = 'Мета-теги генерируются по формуле в момент создания страницы. Отмеченная галочка означает, что мета-теги данной категории будут браться из базы данных и будут соответствовать тому, что сохранено в админке.';
$_['text_category_explain_stg_no_auto'] = 'Модуль <b>SEO Tags Generator</b> генрирует <i>title</i>, <i>мета-тег description</i>, <i>мета-тег keywords</i>'; // v1.6

$_['tab_seo_tags_generator'] = 'SEO Формулы'; // v1.6
$_['tab_seo_tags_generator_info'] = '<i class="fa fa-info-circle"></i> Внимание!<br>Используйте данную вкладку только в тех случаях:<br>'
  . '- если Вы хотите задать для отдельно взятой категории специфические формулы генерации мета-тегов<br>'
  . '- если Вы хотите задать отдельные форумлы для всех товаров данной категории'; // v1.6

$_['tab_category_setting'] = 'Настройки категории'; // v1.6
$_['entry_category_setting_inheritance'] = 'Наследование формул в дочерних категориях, если те будут пусты'; // v1.6
$_['text_inheritance_yes'] = 'Наследовать'; // v1.6
$_['text_inheritance_no']  = 'Не наследовать'; // v1.6

$_['entry_category_setting_inheritance_copy'] = 'Скопировать данные формулы в дочерние подкатегории, чтобы в дальнейшем слегка подправить их'; // v1.6
$_['text_inheritance_copy_yes']  = 'Да'; // v1.6
$_['text_inheritance_copy_warning']  = 'Будьте осторожны!<br>'
  . 'Вы уже копировали эти формулы. И, возможно, там внесены изменения, которые не стоит перезаписывать'; // v1.6

$_['entry_category_setting_copy_to_others'] = 'Скопировать данные формулы в другие категории сайта'; // v1.6
$_['text_copy_to_others_yes']  = 'Да'; // v1.6
$_['text_copy_to_others_warning']  = 'Будьте осторожны!<br>'
  . 'Вы уже копировали эти формулы. И, возможно, там внесены изменения, которые не стоит перезаписывать'; // v1.6

$_['entry_categories'] = 'Выберите категории'; // v1.6
$_['text_select_all'] = 'Выбрать все'; // v1.6
$_['text_unselect_all'] = 'Снять выбор со всех'; // v1.6


// Для админки товара

$_['entry_product_meta_stg_no_auto']   	    = 'Использовать вручную вписанные мета-теги для данного товара';
$_['entry_product_meta_stg_no_auto_help']   = 'Мета-теги генерируются по формуле в момент создания страницы. Отмеченная галочка означает, что мета-теги данного товара будут браться из базы данных и будут соответствовать тому, что сохранено в админке.';
$_['text_product_explain_stg_no_auto'] = 'Модуль <b>SEO Tags Generator</b> генрирует <i>title</i>, <i>мета-тег description</i>, <i>мета-тег keywords</i> и <i>h1</i> для товара. <span style="color: red; ">Поле "Теги товара" НЕ генерируется</span>. <br><br>Галочка находится здесь потому что, именно здесь заканчивается разделение языковых версий'; // v1.6

$_['entry_model_synonym']   = 'Синоним модели'; 


//button
$_['button_save'] = 'Зберегти';
$_['button_cancel'] = 'Відміна';


// success
$_['success'] = 'Налаштування модуля оновлені';


// warning
$_['warning_licence'] = 'Активована тимчасова ліцензія на [x] днів! Для отримання постійної ліцензії, зверніться до автора модуля за адресою <b>sergheitkach@gmail.com</b>!';


// Error
$_['error_permission'] = 'У вас немає прав для управління цим модулем!';
$_['error_warning'] = 'Помилка! Параметри не збережені. Виправте зазначені в формі помилки і спробуйте зберегти знову! ';

$_['error_licence'] = 'Введіть код ліцензії!';
$_['error_licence_empty'] = 'Введіть код ліцензії!';
$_['error_licence_not_valid'] = 'Код ліцензії недійсний!';


// Temp licence
$_['button_get_temp_licence'] = 'Запросити тимчасову ліцензію';
$_['success_get_temp_licence'] = 'Тимчасова ліцензія отримана! Для продовження роботи з модулем поновіть сторінку!';
$_['error_get_temp_licence'] = 'Не удалось получить временную лицензию! Попробуйте получить ее еще раз!';

$_['error_get_temp_licence_server_off'] = 'Не найден сервер для получения лицензии! Обратитесь к автору модуля!';
$_['error_get_temp_licence_waiting'] = 'Время ожидания ответа от сервера получения лицензии превысило 5 секунд и было сброшено. Попробуйте позже еще раз!';
$_['error_get_temp_licence_404'] = 'Страница получения лицензии не найдена! Обратитесь к автору модуля!';
$_['error_get_temp_licence_expired'] = 'Закінчився термін тимчасової ліцензії!';

$_['error_valid_temp_licence'] = 'Недействительная временная лицензия!';