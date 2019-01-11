<?php

class ModelExtensionModuleSeoTagsGenerator extends Controller {

  private $stg;


  function __construct($registry) {

    parent::__construct($registry);

    require_once DIR_SYSTEM . 'library/seo_tags_generator/seo_tags_generator.php';

    $licence = $this->config->get('seo_tags_generator_licence');
    if (!$licence) {
      $licence = $this->config->get('seo_tags_generator_temp_licence');
    }

    $this->stg = new SeoTagsGenerator($licence);

  }



  /* Base methods
  --------------------------------------------------------------------------- */
  public function getCategoryTags($category_info){

    if ($this->config->get('seo_tags_generator_status')) {

      $lang_id = $this->config->get('config_language_id');

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

        $filter_data = array(
          'filter_category_id'  => $category_info['category_id'],
          'filter_sub_category' => true
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


  public function getProductTags($product_info){

    if ($this->config->get('seo_tags_generator_status')) {

      $lang_id = $this->config->get('config_language_id');

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


  public function getManufacturerTags($manufacturer_info){

    if ($this->config->get('seo_tags_generator_status')) {
      $lang_id = $this->config->get('config_language_id');

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


  public function getProductModelSynonym($product_id){
    $query = "SELECT `model_synonym` FROM `".DB_PREFIX."product` WHERE `product_id`=".(int)$product_id.";";
    $result = $this->db->query($query);
    if ($result->rows) {
      if($result->row) {
        return $result->row['model_synonym'];
      }
    }
    return false;
  }


  public function getProductManufacturerSynonym($manufacturer_id){
    $query = "SELECT `name_synonym` FROM `".DB_PREFIX."manufacturer` WHERE `manufacturer_id`=".(int)$manufacturer_id.";";
    $result = $this->db->query($query);
    if ($result->rows) {
      if($result->row) {
        return $result->row['name_synonym'];
      }
    }
    return false;
  }


}
