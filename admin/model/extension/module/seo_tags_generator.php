<?php

/**
 * @category   OpenCart
 * @package    SEO Tags Generator
 * @copyright  © Serge Tkach, 2017, https://opencartforum.com/profile/717101-sergetkach/
 */

class ModelExtensionModuleSeoTagsGenerator extends Model {

  /* Category Declension
  --------------------------------------------------------------------------- */
  public function getCategoryDeclensionForEdit($category_id) {
    // is different from function getCategoryDeclension() for generate
    $query = "SELECT `language_id`, `category_name_plural_nominative`, `category_name_plural_genitive`, `category_name_singular_nominative` FROM `".DB_PREFIX."seo_tags_generator_category_declension` WHERE `category_id` = '" . (int) $category_id. "' ORDER BY `language_id` ASC";
    $result = $this->db->query($query);

      $array = array();

      foreach ($result->rows as $value) {
        $array[$value['language_id']] = array(
          'category_name_plural_nominative'   => $value['category_name_plural_nominative'],
          'category_name_plural_genitive'     => $value['category_name_plural_genitive'],
          'category_name_singular_nominative' => $value['category_name_singular_nominative'],
        );
      }

      return $array;


    return false;
  }


  public function addCategoryDeclension($category_id, $data) {
    foreach ($data as $language_id => $value) {
      $this->db->query("INSERT INTO `".DB_PREFIX."seo_tags_generator_category_declension` SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', `category_name_plural_nominative` = '" . $this->db->escape($value['category_name_plural_nominative']) . "', `category_name_plural_genitive` = '" . $this->db->escape($value['category_name_plural_genitive']) . "', `category_name_singular_nominative` = '" . $this->db->escape($value['category_name_singular_nominative']) . "'");
    }
  }


  public function editCategoryDeclension($category_id, $data) {
    $this->db->query("DELETE FROM `".DB_PREFIX."seo_tags_generator_category_declension` WHERE `category_id` = '" . (int)$category_id . "'");

    foreach ($data as $language_id => $value) {

      $sql = "INSERT INTO `".DB_PREFIX."seo_tags_generator_category_declension` SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', `category_name_plural_nominative` = '" . $this->db->escape($value['category_name_plural_nominative']) . "', `category_name_plural_genitive` = '" . $this->db->escape($value['category_name_plural_genitive']) . "', `category_name_singular_nominative` = '" . $this->db->escape($value['category_name_singular_nominative']) . "'";

      $this->db->query($sql);
    }


  }



  /* Meta Tags Formulas In Category
  --------------------------------------------------------------------------- */
  public function getCategoryFormulas($category_id) {
    $final_array = array();

    $query = "SELECT `category_id`, `language_id`, `key`, `value` FROM `".DB_PREFIX."seo_tags_generator` WHERE `category_id` = '" . (int)$category_id . "'";
    $result = $this->db->query($query);

    if ($result->num_rows){
      foreach ($result->rows as $row) {
        $value_array = json_decode($row['value'], true);

        foreach ($value_array as $key => $value){
          $final_array[$row['language_id']][$row['key']][$key] = $value;
        }
      }
    }

    return $final_array;
  }


  public function addCategoryFormulas($category_id, $data) {
    // Check if not empty formual !!
    if($this->isEmptyFormulas($data['formulas'])) {
      // Чистить настройки еще нечего
    } else {
      $this->saveFormulasToCategory($category_id, $data['formulas']);

      // Настройки меняются только при наличии формул. Иначе они бессмысленны...
      $this->addCategorySetting($category_id, $data['setting']);

      // To descendants copy
      if (isset($data['setting']['inheritance_copy'])) {
        $descendants_categories = $this->getDescendantsLinear($category_id);

        foreach ($descendants_categories as $descendants_category_id) {
          $this->saveFormulasToCategory($descendants_category_id, $data['formulas']);
        }
      }

      // copy formulas to others catgories
      if (isset($data['setting']['copy_to_others'])) {

        // Могут галочку отметить, а категории не выбрать
        if (isset($data['copy_to_categories'])) {
          foreach ($data['copy_to_categories'] as $copy_category_id) {
            $this->saveFormulasToCategory($copy_category_id, $data['formulas']);

            // save dependens
            $this->db->query("INSERT INTO `".DB_PREFIX."seo_tags_generator_category_copy` SET category_id = '" . (int)$category_id . "', copy_category_id = '" . (int)$copy_category_id . "'");

          }
        } else {
          // Если категории не выбраны, значит ли это, что необходимо удалить все формулы ?
          // Нет не значит!
          // Может случиться так, что категорий было выбрано 10, а теперь только 5 - как я буду знать, не хочет ли пользователь удалить те 5 категорий ?
          // Функционал предназначен для облегчения копирования однотипной информации, но не для полноценного менеджмента !
        }
      }

    }

  }


  public function editCategoryFormulas($category_id, $data) {
    // reset all data for this category
    $this->db->query("DELETE FROM `".DB_PREFIX."seo_tags_generator` WHERE category_id = '" . (int)$category_id . "'");

    // Check if not empty formual !!
    if($this->isEmptyFormulas($data['formulas'])) {
      // ...
      // Не очищаем настройки. Потому как даже если родительской категории необходимо снести формулу, всегда остается открытым вопрос,
      // к чему приведет снос в дочерних...
    } else {
      $this->saveFormulasToCategory($category_id, $data['formulas']);

      // Настройки меняются только при наличии формул. Иначе они бессмысленны...
      $this->editCategorySetting($category_id, $data['setting']);

      // To descendants copy
      if (isset($data['setting']['inheritance_copy'])) {
        $descendants_categories = $this->getDescendantsLinear($category_id);

        foreach ($descendants_categories as $descendants_category_id) {
          $this->db->query("DELETE FROM `".DB_PREFIX."seo_tags_generator` WHERE category_id = '" . (int)$descendants_category_id . "'");
          $this->saveFormulasToCategory($descendants_category_id, $data['formulas']);
        }
      }

      // copy formulas to others catgories
      if (isset($data['setting']['copy_to_others'])) {
        // delete old dependence
        $this->db->query("DELETE FROM `".DB_PREFIX."seo_tags_generator_category_copy` WHERE category_id = '" . (int)$category_id . "'");

        // Могут галочку отметить, а категории не выбрать. Или наоборот снять категории
        if (isset($data['copy_to_categories'])) {
          foreach ($data['copy_to_categories'] as $copy_category_id) {
            $this->db->query("DELETE FROM `".DB_PREFIX."seo_tags_generator` WHERE category_id = '" . (int)$copy_category_id . "'");
            $this->saveFormulasToCategory($copy_category_id, $data['formulas']);

            // save dependens
            $this->db->query("INSERT INTO `".DB_PREFIX."seo_tags_generator_category_copy` SET category_id = '" . (int)$category_id . "', copy_category_id = '" . (int)$copy_category_id . "'");

          }
        } else {
          // Если категории не выбраны, значит ли это, что необходимо удалить все формулы ?
          // Нет не значит!
          // Может случиться так, что категорий было выбрано 10, а теперь только 5 - как я буду знать, не хочет ли пользователь удалить те 5 категорий ?
          // Функционал предназначен для облегчения копирования однотипной информации, но не для полноценного менеджмента !
        }
      }

    }

  }


  public function isEmptyFormulas($data) {
    foreach ($data as $language_id => $value) {
      foreach ($value as $key => $item) {
        foreach ($item as $result) {
          if ($result) {
            return false; // not empty
          }
        }
      }
    }
    return true; // empty
  }


  public function saveFormulasToCategory($category_id, $data) {
    foreach ($data as $language_id => $value) {
      foreach ($value as $key => $item) {
        $sql = "INSERT INTO `".DB_PREFIX."seo_tags_generator` SET category_id = '" . (int)$category_id . "', language_id = '" . (int)$language_id . "', `key` = '" . $this->db->escape($key) . "', `value` = '" . $this->db->escape( json_encode($item) ) . "'";

        $this->db->query($sql);
      }
    }
  }


  public function getCategorySetting($category_id) {
    $query = "SELECT `setting` FROM `".DB_PREFIX."seo_tags_generator_category_setting` WHERE `category_id` = '" . (int)$category_id . "'";
    $result = $this->db->query($query);

    if ($result->num_rows){
      return json_decode($result->row['setting'], true);
    }

    return false;
  }

  public function addCategorySetting($category_id, $data) {
    $sql = "INSERT INTO `".DB_PREFIX."seo_tags_generator_category_setting` SET category_id = '" . (int)$category_id . "', `setting` = '" . $this->db->escape( json_encode($data) ) . "'";

    $this->db->query($sql);

  }

  public function editCategorySetting($category_id, $data) {
    // Учитывать, если однажды уже применялось копировани формул в дочерние или другие категории
    $data_was = $this->getCategorySetting($category_id);

    // $data['inheritance'] - наследовать или нет
    // не вмешиваемся

    // копировать в дочерние
    if (isset($data_was['inheritance_copy'])) {
      $data['inheritance_copy'] = 1;
    }

    // копировать в другие категори
    if (isset($data_was['copy_to_others'])) {
      $data['copy_to_others'] = 1;
    }

    // Delete old setting
    $this->db->query("DELETE FROM `".DB_PREFIX."seo_tags_generator_category_setting` WHERE category_id = '" . (int)$category_id . "'");

    $sql = "INSERT INTO `".DB_PREFIX."seo_tags_generator_category_setting` SET category_id = '" . (int)$category_id . "', `setting` = '" . $this->db->escape( json_encode($data) ) . "'";

    $this->db->query($sql);

  }

  public function getCategoryCopy($category_id) {
    $array  = array();
    $sql   = "SELECT `copy_category_id` FROM `".DB_PREFIX."seo_tags_generator_category_copy` WHERE `category_id` = '" . (int)$category_id . "'";
    $query = $this->db->query($sql);

    if ($query->rows){
      foreach ($query->rows as $result) {
        $array[] = $result['copy_category_id'];
      }
      return $array;
    }

    return false;
  }

  public function getCategoryCopyExist($a_exclude) {
    $array  = array();
    $sql   = "SELECT `copy_category_id` FROM `".DB_PREFIX."seo_tags_generator_category_copy`";
    $query = $this->db->query($sql);

    if ($query->rows){
      foreach ($query->rows as $result) {
        if (is_array($a_exclude)) {
          if (!in_array($result['copy_category_id'], $a_exclude)) {
            $array[] = $result['copy_category_id'];
          }
        } else {
          $array[] = $result['copy_category_id'];
        }


      }

    }

    return $array;
  }


  /* Copy to Categories
  --------------------------------------------------------------------------- */
  public function getCopyCategories($category_id) {
    $copy_to_categories_data = array();

    $query = $this->db->query("SELECT `copy_category_id` FROM " . DB_PREFIX . "seo_tags_generator_category_copy WHERE category_id = '" . (int)$category_id . "'");

    foreach ($query->rows as $result) {
      $copy_to_categories_data[] = $result['copy_category_id'];
    }

    return $copy_to_categories_data;
  }




  /* Category Dauthers
  --------------------------------------------------------------------------- */
  public function getDescendantsTreeForCategory($category_id) {
    $array = array(
      'category_id'   => $category_id,
      'category_name' => $this->getCategoryName($category_id)
    );

    // dauthers
    $sql = "SELECT `category_id` FROM " . DB_PREFIX . "category WHERE parent_id = '" . (int)$category_id . "'";

    $query = $this->db->query($sql);

    if ($query->num_rows > 0) {
      $array['has_children'] = 1;

      foreach ($query->rows as $result) {
        $array['children'][] = $this->getDescendantsTreeForCategory($result['category_id']);
      }
    } else {
      $array['has_children'] = false;
    }

    return $array;
  }


  public function getDescendantsLinear($category_id) {
    $array = array();

    $sql = "SELECT `category_id` FROM `" . DB_PREFIX . "category_path` WHERE `path_id` = '" . (int)$category_id . "' AND `category_id` != '" . (int)$category_id . "'";

    $query = $this->db->query($sql);

    if ($query->num_rows > 0) {
      foreach ($query->rows as $result) {
        $array[] = $result['category_id'];
      }
    }

    return $array;
  }


  public function getCategoriesMain() {
    $array = array();

    $sql = "SELECT `category_id` FROM `" . DB_PREFIX . "category` WHERE `parent_id` = '0' ";

    $query = $this->db->query($sql);

    foreach ($query->rows as $result) {
      $array[] = $result['category_id'];
    }

    return $array;
  }


  public function getCategoryName($category_id) {
    $sql = "SELECT `name` FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'";

    $query = $this->db->query($sql);

    if (isset($query->row['name'])) {
      return $query->row['name'];
    }

    return 'No Category Name';
  }



  /* Meta Tags Generation
  --------------------------------------------------------------------------- */

  public function getGenerateMode() {
    return array(
      'nofollow', 'empty', 'forced'
    );
  }


  public function getSpecificFormulas(){
    $final_array = array();
    // Сортируем по категории по возрастанию, ведь категории у нас будут использоваться для ключей ??
    $query = "SELECT `category_id`, `language_id`, `key`, `value` FROM `".DB_PREFIX."seo_tags_generator` ORDER BY `category_id` ASC";
    $result = $this->db->query($query);

    if ($result->num_rows){
      $i = 0;
      foreach ($result->rows as $row) {
        $value_array = json_decode($row['value'], true);
        foreach ($value_array as $key => $value){
          if (isset($final_array[$i]) && $row['category_id'] != $final_array[$i]['category_id']) {
            $i++; // Прибавлять ключ к массиву, когда увеличивается меняется значение id категории
          }

          $final_array[$i]['category_id'] = $row['category_id'];
          $final_array[$i]['category_name'] = $this->getCategoryNameById($row['category_id']);
          $final_array[$i]['langs'][$row['language_id']][$row['key']][$key] = $value;
        }
      }

    }

    return $final_array;
  }


  private function getCategoryNameById($category_id){
    $sql = "SELECT `name` FROM `".DB_PREFIX."category_description` WHERE `category_id`='" . (int)$category_id . "' AND `language_id` = '".  $this->config->get('config_language_id') ."'";
    $result = $this->db->query($sql);
    if($result->row){
      return $result->row['name'];
    }
    return false;

  }


  public function setSpecificFormulas($data){

    $final_array = array();
    $i = 0;

    if (count($data) > 0) {
      foreach ($data as $key => $item) {
        foreach ($item['langs'] as $lang_id => $value_array_for_lang) {
          foreach ($value_array_for_lang as $key_entity => $value_entity) {
            if (!empty($value_entity['title']) && !empty($value_entity['description'])) {
              $final_array[$i]['category_id'] = $item['category_id'];
              $final_array[$i]['language_id'] = $lang_id;
              $final_array[$i]['key'] = $key_entity;
              $final_array[$i]['value']['title'] = $value_entity['title'];
              $final_array[$i]['value']['description'] = $value_entity['description'];
              $final_array[$i]['value']['keyword'] = $value_entity['keyword'];
              if ('product' == $key_entity) {
                if (!empty($value_entity['h1'])){
                  $final_array[$i]['value']['h1'] = $value_entity['h1']; // for products only
                }
              }
              $i++;
            }
          }
        }
      }
    }

    $this->db->query("DELETE FROM `".DB_PREFIX."seo_tags_generator`");

    foreach ($final_array as $item) {
      $sql = "INSERT INTO `".DB_PREFIX."seo_tags_generator` SET
        `category_id` = '".(int)$item['category_id']."',
        `language_id` = '".(int)$item['language_id']."',
        `key` = '".$this->db->escape($item['key'])."',
        `value` = '".$this->db->escape( json_encode($item['value']) )."'
      ";

      $this->db->query($sql);
    }

  }


  public function setStgNotUse($id, $essence) {
    require_once DIR_SYSTEM . 'library/seo_tags_generator/seo_tags_generator.php';
    $stg = new SeoTagsGenerator();
    return $stg->setStgNotUse($id, $essence);
  }


  public function setStgNotUseOff($id, $essence) {
    require_once DIR_SYSTEM . 'library/seo_tags_generator/seo_tags_generator.php';
    $stg = new SeoTagsGenerator();
    return $stg->setStgNotUseOff($id, $essence);
  }


  public function getCategoryTags($category_info, $lang_id){

    require_once DIR_SYSTEM . 'library/seo_tags_generator/seo_tags_generator.php';

    $licence = $this->config->get('seo_tags_generator_licence');
    if (!$licence) {
      $licence = $this->config->get('seo_tags_generator_temp_licence');
    }

    $this->stg = new SeoTagsGenerator($licence);

    if ($this->config->get('seo_tags_generator_status')) {

      if (!$this->stg->notUseAutoCategory($category_info['category_id'])) {
        $a_specific_formula = $this->stg->getSTGSettingsByCatId($category_info['category_id'], $lang_id, 'category');
      } else {
        return $category_info;
      }

      // Внимание!
      // В специфических формулах может быть такое, что задан только title или только description (!)
      // В админке не проверяется на заполненность всех полей для специфических формул

      if (isset($a_specific_formula['title']) && !empty($a_specific_formula['title'])) {
        $stg_formula_title = $a_specific_formula['title'];
      } else {
        $stg_formula_title = $this->config->get('seo_tags_generator_category_title');
        $stg_formula_title = $stg_formula_title[$lang_id];
      }

      if (isset($a_specific_formula['description']) && !empty($a_specific_formula['description'])) {
        $stg_formula_description = $a_specific_formula['description'];
      } else {
        $stg_formula_description = $this->config->get('seo_tags_generator_category_description');
        $stg_formula_description = $stg_formula_description[$lang_id];
      }

      if (isset($a_specific_formula['keyword']) && !empty($a_specific_formula['keyword'])) {
        $stg_formula_keyword = $a_specific_formula['keyword'];
      } else {
        $stg_formula_keyword = $this->config->get('seo_tags_generator_category_keyword');
        $stg_formula_keyword = $stg_formula_keyword[$lang_id];
      }


      // Подготовка перменных для замены
      $search = array(
        '[category_name]',
      );

      $replace = array(
        $category_info['name'],
      );


      // Вариантивные данные
      if (false !== strpos($stg_formula_title, '[city') || false !== strpos($stg_formula_description, '[city') || false !== strpos($stg_formula_keyword, '[city') ) {
        $config_store = $this->config->get('config_store');
        $config_store = $config_store[$lang_id];

        $search  = array_merge($search, array('[city]', '[city_genitive]', '[city_dative]', '[city_prepositional]'));
        $replace = array_merge($replace, array($config_store['city'], $config_store['city_genitive'], $config_store['city_dative'], $config_store['city_prepositional']));
      }

      if (false !== strpos($stg_formula_title, '[shop_name]') || false !== strpos($stg_formula_description, '[shop_name]') || false !== strpos($stg_formula_keyword, '[shop_name]') ) {
        $search[]  = '[shop_name]';
        $replace[] = $this->config->get('config_name');
      }

      if (false !== strpos($stg_formula_title, '[config_telephone]') || false !== strpos($stg_formula_description, '[config_telephone]') || false !== strpos($stg_formula_keyword, '[config_telephone]') ) {
        $search[]  = '[config_telephone]';
        $replace[] = $this->config->get('config_telephone');
      }

      // category name - already exist
      //
      // category declension
      if (false !== strpos($stg_formula_title, '[category_name_') || false !== strpos($stg_formula_description, '[category_name_') || false !== strpos($stg_formula_keyword, '[category_name_') ) {
        $category_declension = $this->getCategoryDeclension($category_info['category_id'], $lang_id);

        if (is_array($category_declension)) {
          $search = array_merge($search, array(
            '[category_name_plural_nominative]',
            '[category_name_plural_genitive]',
            '[category_name_singular_nominative]'
          ));

          $replace = array_merge($replace, array(
            $category_declension['category_name_plural_nominative'],
            $category_declension['category_name_plural_genitive'],
            $category_declension['category_name_singular_nominative'],
          ));
        } else {
          // Юзеру сразу видно, что он не заполнил переменные
        }
      }

      // count products in cat
      if (false !== strpos($stg_formula_title, '[count_products]') || false !== strpos($stg_formula_description, '[count_products]') || false !== strpos($stg_formula_keyword, '[count_products]') ) {

        $this->load->model('catalog/product');

        $filter_data = array(
          'filter_category'  => $category_info['category_id'],
        );

        $search[]  = '[count_products]';
        $replace[] = $this->model_catalog_product->getTotalProducts($filter_data);
      }

      // get min price in this category
      if (false !== strpos($stg_formula_title, '[min_price]') || false !== strpos($stg_formula_description, '[min_price]') || false !== strpos($stg_formula_keyword, '[min_price]') ) {
        $min_price = $this->getMinPriceInCat($category_info['category_id']);

        $search[]  = '[min_price]';

        if ($min_price) {
          $replace[] = $min_price;
        } else {
          $replace[] = '0';
        }
      }

      // get max price in this category
      if (false !== strpos($stg_formula_title, '[max_price]') || false !== strpos($stg_formula_description, '[max_price]') || false !== strpos($stg_formula_keyword, '[max_price]') ) {
        $max_price = $this->getMaxPriceInCat($category_info['category_id']);

        $search[]  = '[max_price]';

        if ($max_price) {
          $replace[] = $max_price;
        } else {
          $replace[] = '0';
        }
      }


      // Генерация мета-тегов в зависимости от настроек модуля
      $generate_mode = $this->config->get('seo_tags_generator_generate_mode_category');

      if ('nofollow' == $generate_mode) {
        // no action
      }

      if ('empty' == $generate_mode) {
        if (empty($category_info['meta_title'])) {
          $category_info['meta_title'] = str_replace($search, $replace, $stg_formula_title);
        }
        if (empty($category_info['meta_description'])) {
          $category_info['meta_description'] = str_replace($search, $replace, $stg_formula_description);
        }
        if (empty($category_info['meta_keyword'])) {
          $category_info['meta_keyword'] = str_replace($search, $replace, $stg_formula_keyword);
        }
      }

      if ('forced' == $generate_mode) {
        $category_info['meta_title']       = str_replace($search, $replace, $stg_formula_title);
        $category_info['meta_description'] = str_replace($search, $replace, $stg_formula_description);
        $category_info['meta_keyword']     = str_replace($search, $replace, $stg_formula_keyword);
      }

    }

    return $category_info;
  }


  public function getProductTags($product_info, $lang_id){

    require_once DIR_SYSTEM . 'library/seo_tags_generator/seo_tags_generator.php';

    $licence = $this->config->get('seo_tags_generator_licence');
    if (!$licence) {
      $licence = $this->config->get('seo_tags_generator_temp_licence');
    }

    $this->stg = new SeoTagsGenerator($licence);

    if ($this->config->get('seo_tags_generator_status')) {

      $parent_category_id = $this->stg->getParentCategoryByProductId($product_info['product_id']);

      if (!$this->stg->notUseAutoProduct($product_info['product_id'])) {
        $a_specific_formula = $this->stg->getSTGSettingsByCatId($parent_category_id, $lang_id, 'product');
      }	else {
        return $product_info;
      }


      // Внимание!
      // В специфических формула может быть такое, что задан только title или только description (!)
      // В админке не проверяется на заполненность всех полей для специфических формул

      if (isset($a_specific_formula['title']) && !empty($a_specific_formula['title'])) {
        $stg_formula_title = $a_specific_formula['title'];
      } else {
        $stg_formula_title = $this->config->get('seo_tags_generator_product_title');
        $stg_formula_title = $stg_formula_title[$lang_id];
        $stg_formula_title = str_replace(array('([', '])'), array('{', '}'), $stg_formula_title);
      }

      if (isset($a_specific_formula['description']) && !empty($a_specific_formula['description'])) {
        $stg_formula_description = $a_specific_formula['description'];
      } else {
        $stg_formula_description = $this->config->get('seo_tags_generator_product_description');
        $stg_formula_description = $stg_formula_description[$lang_id];
        $stg_formula_description = str_replace(array('([', '])'), array('{', '}'), $stg_formula_description);
      }

      if (isset($a_specific_formula['keyword']) && !empty($a_specific_formula['keyword'])) {
        $stg_formula_keyword = $a_specific_formula['keyword'];
      } else {
        $stg_formula_keyword = $this->config->get('seo_tags_generator_product_keyword');
        $stg_formula_keyword = $stg_formula_keyword[$lang_id];
        $stg_formula_keyword = str_replace(array('([', '])'), array('{', '}'), $stg_formula_keyword);
      }

      if (isset($a_specific_formula['h1']) && !empty($a_specific_formula['h1'])) {
        $stg_formula_h1 = $a_specific_formula['h1'];
      } else {
        $stg_formula_h1 = $this->config->get('seo_tags_generator_product_h1');
        $stg_formula_h1 = $stg_formula_h1[$lang_id];
        $stg_formula_h1 = str_replace(array('([', '])'), array('{', '}'), $stg_formula_h1);
      }

      // Подготовка перменных для замены
      $model_synonym = $this->getProductModelSynonym($product_info['product_id']);
      if($model_synonym) $model_synonym_brackets = "(" . $model_synonym . ")"; else $model_synonym_brackets = '';
      $manufacturer_synonym = $this->getProductManufacturerSynonym($product_info['manufacturer_id']);
      if($manufacturer_synonym) $manufacturer_synonym_brackets = "(" . $manufacturer_synonym . ")"; else $manufacturer_synonym_brackets = '';


      // Знак валюты - tax-calculate не работает в админке
      $this->load->model('localisation/currency');

      $results = $this->model_localisation_currency->getCurrencies();

      if ($results[$this->config->get('config_currency')]['symbol_right']) {
        $currency_value = $results[$this->config->get('config_currency')]['symbol_right'];
      } else {
        $currency_value = $this->config->get('config_currency');
      }

      $search = array(
        '[product_name]',
        '[model]',
        '[model_synonym]',
        '{model_synonym}',
        '[sku]',
        '[price]',
        '[manufacturer]',
        '[manufacturer_synonym]',
        '{manufacturer_synonym}',
      );

      $replace = array(
        $product_info['name'],
        $product_info['model'],
        $model_synonym,
        $model_synonym_brackets,
        $product_info['sku'],
        (float)$product_info['special'] ? $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']) : $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']),
        $product_info['manufacturer'],
        $manufacturer_synonym,
        $manufacturer_synonym_brackets,
      );


      // Вариантивные данные
      if (false !== strpos($stg_formula_title, '[city') || false !== strpos($stg_formula_description, '[city') || false !== strpos($stg_formula_keyword, '[city') ) {
        $config_store = $this->config->get('config_store');
        $config_store = $config_store[$lang_id];

        $search  = array_merge($search, array('[city]', '[city_genitive]', '[city_dative]', '[city_prepositional]'));
        $replace = array_merge($replace, array($config_store['city'], $config_store['city_genitive'], $config_store['city_dative'], $config_store['city_prepositional']));
      }

      if (false !== strpos($stg_formula_title, '[shop_name]') || false !== strpos($stg_formula_description, '[shop_name]') || false !== strpos($stg_formula_keyword, '[shop_name]') ) {
        $search[]  = '[shop_name]';
        $replace[] = $this->config->get('config_name');
      }

      if (false !== strpos($stg_formula_title, '[config_telephone]') || false !== strpos($stg_formula_description, '[config_telephone]') || false !== strpos($stg_formula_keyword, '[config_telephone]') ) {
        $search[]  = '[config_telephone]';
        $replace[] = $this->config->get('config_telephone');
      }

      // category name
      if (false !== strpos($stg_formula_title, '[category_name]') || false !== strpos($stg_formula_description, '[category_name]') || false !== strpos($stg_formula_keyword, '[category_name]')) {
        $category_name = $this->getCategoryNameByIdAndLang($parent_category_id, $lang_id);

        if ($category_name) {
          $search = array_merge($search, array('[category_name]'));
          $replace = array_merge($replace, array($category_name));
        }
      }

      // category declension
      if (false !== strpos($stg_formula_title, '[category_name_') || false !== strpos($stg_formula_description, '[category_name_') || false !== strpos($stg_formula_keyword, '[category_name_') ) {
        $category_declension = $this->getCategoryDeclension($parent_category_id, $lang_id);

        if (is_array($category_declension)) {
          $search = array_merge($search, array(
            '[category_name_plural_nominative]',
            '[category_name_plural_genitive]',
            '[category_name_singular_nominative]'
          ));

          $replace = array_merge($replace, array(
            $category_declension['category_name_plural_nominative'],
            $category_declension['category_name_plural_genitive'],
            $category_declension['category_name_singular_nominative'],
          ));
        } else {
          // Юзеру сразу видно, что он не заполнил переменные
        }
      }


      // Генерация мета-тегов в зависимости от настроек модуля
      $generate_mode = $this->config->get('seo_tags_generator_generate_mode_product');

      if ('nofollow' == $generate_mode) {
        // no action - h1 is separated
      }

      if ('empty' == $generate_mode) {
        if (empty($product_info['meta_title'])) {
          $product_info['meta_title'] = str_replace($search, $replace, $stg_formula_title);
        }
        if (empty($product_info['meta_description'])) {
          $product_info['meta_description'] = str_replace($search, $replace, $stg_formula_description);
        }
        if (empty($product_info['meta_keyword'])) {
          $product_info['meta_keyword'] = str_replace($search, $replace, $stg_formula_keyword);
        }
      }

      if ('forced' == $generate_mode) {
        $product_info['meta_title']       = str_replace($search, $replace, $stg_formula_title);
        $product_info['meta_description'] = str_replace($search, $replace, $stg_formula_description);
        $product_info['meta_keyword']     = str_replace($search, $replace, $stg_formula_keyword);
      }

      if ($this->config->get('seo_tags_generator_status_product_h1')) {

        // Заголовок в OpenCart Initial отсутствует, а name (из которого он берется) обязателен

        if (isset($product_info['h1'])){
          $product_info['h1'] = str_replace($search, $replace, $stg_formula_h1); // Мой модификатор
        } elseif (isset($product_info['meta_h1'])) {
          $product_info['meta_h1'] = str_replace($search, $replace, $stg_formula_h1); // ocStore
        } else {
          $product_info['name'] = str_replace($search, $replace, $stg_formula_h1); // OpenCart Initial
        }
      }
    }

    return $product_info;
  }


  public function getManufacturerTags($manufacturer_info, $lang_id){

    if ($this->config->get('seo_tags_generator_status')) {

      $stg_formula_title = $this->config->get('seo_tags_generator_manufacturer_title');
      $stg_formula_title = $stg_formula_title[$lang_id];

      $stg_formula_description = $this->config->get('seo_tags_generator_manufacturer_description');
      $stg_formula_description = $stg_formula_description[$lang_id];

      $stg_formula_keyword = $this->config->get('seo_tags_generator_manufacturer_keyword');
      $stg_formula_keyword = $stg_formula_keyword[$lang_id];


      // Подготовка перменных для замены
      $search = array(
        '[manufacturer_name]',
      );

      $replace = array(
        $manufacturer_info['name'],
      );


      // Вариантивные данные
      if (false !== strpos($stg_formula_title, '[city') || false !== strpos($stg_formula_description, '[city') || false !== strpos($stg_formula_keyword, '[city') ) {
        $config_store = $this->config->get('config_store');
        $config_store = $config_store[$lang_id];

        $search  = array_merge($search, array('[city]', '[city_genitive]', '[city_dative]', '[city_prepositional]'));
        $replace = array_merge($replace, array($config_store['city'], $config_store['city_genitive'], $config_store['city_dative'], $config_store['city_prepositional']));
      }

      if (false !== strpos($stg_formula_title, '[shop_name]') || false !== strpos($stg_formula_description, '[shop_name]') || false !== strpos($stg_formula_keyword, '[shop_name]') ) {
        $search[]  = '[shop_name]';
        $replace[] = $this->config->get('config_name');
      }

      if (false !== strpos($stg_formula_title, '[config_telephone]') || false !== strpos($stg_formula_description, '[config_telephone]') || false !== strpos($stg_formula_keyword, '[config_telephone]') ) {
        $search[]  = '[config_telephone]';
        $replace[] = $this->config->get('config_telephone');
      }


      // Генерация мета-тегов в зависимости от настроек модуля
      $generate_mode = $this->config->get('seo_tags_generator_generate_mode_manufacturer');

      if ('nofollow' == $generate_mode) {
        // no action - but for no error after modificator
        $manufacturer_info['meta_title'] = $manufacturer_info['name'];
      }

      if ('empty' == $generate_mode) {
        if (empty($manufacturer_info['meta_title'])) {
          $manufacturer_info['meta_title'] = str_replace($search, $replace, $stg_formula_title);
        }
        if (empty($manufacturer_info['meta_description'])) {
          $manufacturer_info['meta_description'] = str_replace($search, $replace, $stg_formula_description);
        }
        if (empty($manufacturer_info['meta_keyword'])) {
          $manufacturer_info['meta_keyword'] = str_replace($search, $replace, $stg_formula_keyword);
        }
      }

      if ('forced' == $generate_mode) {
        $manufacturer_info['meta_title']       = str_replace($search, $replace, $stg_formula_title);
        $manufacturer_info['meta_description'] = str_replace($search, $replace, $stg_formula_description);
        $manufacturer_info['meta_keyword']     = str_replace($search, $replace, $stg_formula_keyword);
      }

    }

    return $manufacturer_info;
  }




  /* Helpers
  --------------------------------------------------------------------------- */
  public function getSpecial($product_id) {
    $sql = "SELECT price AS special FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = " . (int)$product_id . " AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1 ";

    $query = $this->db->query($sql);

    if (isset($query->row['special'])) {
      return $query->row['special'];
    } else {
      return false;
    }
  }


  public function getMinPriceInCat($category_id) {
    $res = false;

    // Самая дешевая базовая цена среди товаров этой категории
    $sql = "SELECT"
      . " p2c.category_id,"
      . " p2c.product_id,"
      . " p.price,"
      . " p.tax_class_id"

      // if from this cat only - error if category contain subcategories only
      //. " FROM " . DB_PREFIX . "product_to_category p2c"
      //. " LEFT JOIN  " . DB_PREFIX . "product p ON p.product_id = p2c.product_id"
      //. " WHERE p2c.category_id = " . (int)$category_id . ""

      //if from this cat and her dautger subcats - is dependence with special!!
      . " FROM " . DB_PREFIX . "product_to_category p2c"
      . " LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = p2c.product_id)"
      . " WHERE p2c.category_id IN ( (SELECT cp.category_id FROM " . DB_PREFIX . "category_path cp WHERE path_id = '" . (int)$category_id . "') )"

      . " ORDER BY p.price ASC"
      . " LIMIT 1";

    $query = $this->db->query($sql);

    $a_min_price = array();

    if(isset($query->row['price'])) {
      $a_min_price['product_id'] = $query->row['product_id'];
      $a_min_price['price'] = $query->row['price'];
      $tax_class_id = $query->row['tax_class_id'];

      $res = $a_min_price['price'];
    } else {
      $res = false;
    }


    if(count($a_min_price) > 0) {
      // Самая дешевая цена со скидкой среди товаров этой же категории
      /*
      $sql = "SELECT"
        . " p2c.product_id,"
        . " ps.price AS special"
        . " FROM " . DB_PREFIX . "product_to_category p2c"
        . " LEFT JOIN  " . DB_PREFIX . "product_special ps"
        . " ON ps.product_id = p2c.product_id"
        . " AND p2c.category_id = " . (int)$category_id . " AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))"
        . " ORDER BY ps.priority ASC, ps.price ASC"
        . " LIMIT 1";
       *
       */

      $sql = "SELECT"
        . " p2c.product_id,"
        . " ps.price AS special"
        . " FROM " . DB_PREFIX . "product_to_category p2c"
        . " LEFT JOIN  " . DB_PREFIX . "product_special ps ON ps.product_id = p2c.product_id"
        . " WHERE p2c.category_id IN ( (SELECT cp.category_id FROM " . DB_PREFIX . "category_path cp WHERE path_id = '" . (int)$category_id . "') )"
        . " AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))"
        . " ORDER BY ps.priority ASC, ps.price ASC"
        . " LIMIT 1";

      $query = $this->db->query($sql);

      if(isset($query->row['special'])) {
        $a_min_special['product_id'] = $query->row['product_id'];
        $a_min_special['special'] = $query->row['special'];
      }

      // Что меньше - минимальная цена или цена со скидкой?
      if (isset($a_min_special['special'])) {
        if ($a_min_special['special'] < $a_min_price['price']) {
          $res = $a_min_special['special'];

          // Если это разные товары, то нам нужен tax_class_id более дешевого товара со скидкой
          if ($a_min_special['product_id'] != $a_min_price['product_id']) {
            $sql = "SELECT tax_class_id FROM " . DB_PREFIX . "product WHERE product_id = " . (int)$a_min_special['product_id'] . " ";

            $query = $this->db->query($sql);

            $tax_class_id = $query->row['tax_class_id'];
          }
        }
      }

    }

    if ($res) {
      $res = $this->currency->format($this->tax->calculate($res, $tax_class_id, $this->config->get('config_tax')), $this->session->data['currency']);
    }

    return $res;
  }


  public function getMaxPriceInCat($category_id) {
    $res = false;

    // Самая дорогая базовая цена среди товаров этой категории
    $sql = "SELECT"
      . " p2c.category_id,"
      . " p2c.product_id,"
      . " p.price,"
      . " p.tax_class_id,"
      . " ps.price AS special"

      // if from this cat only - error if category contain subcategories only
      //. " FROM " . DB_PREFIX . "product_to_category p2c"
      //. " LEFT JOIN  " . DB_PREFIX . "product p ON p.product_id = p2c.product_id"
      //. " WHERE p2c.category_id = " . (int)$category_id . ""

      //if from this cat and her dautger subcats - есть зависимость с поиском самой дорогой цены по скидке
      . " FROM " . DB_PREFIX . "product_to_category p2c"
      . " LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = p2c.product_id)"
      . " LEFT JOIN " . DB_PREFIX . "product_special ps ON (ps.product_id = p2c.product_id)"
      . " WHERE p2c.category_id IN ( (SELECT cp.category_id FROM " . DB_PREFIX . "category_path cp WHERE path_id = '" . (int)$category_id . "') )"
      . " AND ps.price IS NULL"
      . " ORDER BY p.price DESC"
      . " LIMIT 1";

    $query = $this->db->query($sql);

    $a_max_price = array();

    if(isset($query->row['price'])) {
      $a_max_price['product_id'] = $query->row['product_id'];
      $a_max_price['price'] = $query->row['price'];
      $tax_class_id = $query->row['tax_class_id'];

      $res = $a_max_price['price'];
    } else {
      $res = false;
    }

    if(count($a_max_price) > 0) {
      // Самая дешевая цена со скидкой среди товаров этой же категории
      /*
      $sql = "SELECT"
        . " p2c.product_id,"
        . " ps.price AS special"
        . " FROM " . DB_PREFIX . "product_to_category p2c"
        . " LEFT JOIN  " . DB_PREFIX . "product_special ps"
        . " ON ps.product_id = p2c.product_id"
        . " AND p2c.category_id = " . (int)$category_id . " AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))"
        . " ORDER BY ps.priority ASC, ps.price DESC"
        . " LIMIT 1";
       *
       */

      $sql = "SELECT"
        . " p2c.product_id,"
        . " ps.price AS special"
        . " FROM " . DB_PREFIX . "product_to_category p2c"
        . " LEFT JOIN  " . DB_PREFIX . "product_special ps ON ps.product_id = p2c.product_id"
        . " WHERE p2c.category_id IN ( (SELECT cp.category_id FROM " . DB_PREFIX . "category_path cp WHERE path_id = '" . (int)$category_id . "') )"
        . " AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))"
        . " ORDER BY ps.priority ASC, ps.price DESC"
        . " LIMIT 1";

      $query = $this->db->query($sql);

      if(isset($query->row['special'])) {
        $a_max_special['product_id'] = $query->row['product_id'];
        $a_max_special['special'] = $query->row['special'];
      }

      // Что больше - максимальная базовая цена или максимальная цена со скидкой?
      if (isset($a_max_special['special'])) {
        if ($a_max_special['special'] > $a_max_price['price']) {
          echo 'special больше'; exit;
          $res = $a_max_special['special'];

          // Если это разные товары, то нам нужен tax_class_id более дешевого товара со скидкой
          if ($a_max_special['product_id'] != $a_max_price['product_id']) {
            $sql = "SELECT tax_class_id FROM " . DB_PREFIX . "product WHERE product_id = " . (int)$a_max_special['product_id'] . " ";

            $query = $this->db->query($sql);

            $tax_class_id = $query->row['tax_class_id'];
          }
        }
      }

    }

    if ($res) {
      $res = $this->currency->format($this->tax->calculate($res, $tax_class_id, $this->config->get('config_tax')), $this->session->data['currency']);
    }

    return $res;
  }


  public function getCategoryNameByIdAndLang($category_id, $lang_id) {
    // is different from admin getCategoryName() without lang parameter
    $sql = "SELECT `name` FROM  `".DB_PREFIX."category_description` WHERE`category_id` = '" . (int) $category_id. "' AND `language_id` = '" . (int) $lang_id . "'";
    $query = $this->db->query($sql);

    if ($query->row) {
      return $query->row['name'];
    }

    return false;
  }


  public function getCategoryDeclension($category_id, $lang_id) {
    // is different from admin getCategoryDeclensionForEdit()
    $query = "SELECT "
      . "`category_name_plural_nominative`, "
      . "`category_name_plural_genitive`, "
      . "`category_name_singular_nominative` "
      . "FROM `".DB_PREFIX."seo_tags_generator_category_declension`"
      . "WHERE `category_id` = '" . (int) $category_id. "' AND `language_id` = '" . (int) $lang_id . "' ";

    $result = $this->db->query($query);

    if ($result->row) {
      // Проверяем падежи на пустоту
      if (empty($result->row['category_name_plural_nominative'])
        || empty($result->row['category_name_plural_genitive'])
        || empty($result->row['category_name_singular_nominative'])) {
        return false;
      }

      return $result->row;
    }

    return false;
  }


  private function getProductModelSynonym($product_id){
    $query = "SELECT `model_synonym` FROM `".DB_PREFIX."product` WHERE `product_id`=".(int)$product_id.";";
    $result = $this->db->query($query);
    if ($result->rows) {
      if($result->row) {
        return $result->row['model_synonym'];
      }
    }
    return false;
  }


  private function getProductManufacturerSynonym($manufacturer_id){
    $query = "SELECT `name_synonym` FROM `".DB_PREFIX."manufacturer` WHERE `manufacturer_id`=".(int)$manufacturer_id.";";
    $result = $this->db->query($query);
    if ($result->rows) {
      if($result->row) {
        return $result->row['name_synonym'];
      }
    }
    return false;
  }


  public function getManufacturerNameById($manufacturer_id){
    $sql = "SELECT `name` FROM `".DB_PREFIX."manufacturer` WHERE `manufacturer_id`='" . (int)$manufacturer_id . "'";
    $result = $this->db->query($sql);
    if($result->row){
      return $result->row['name'];
    }
    return false;

  }


}
