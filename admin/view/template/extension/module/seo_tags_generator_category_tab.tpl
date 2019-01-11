<?php // FOR NETBEANS + CentOS ?>
<style>
  #stg-formulas .form-control{
    background: #f1f1f1;
    font-weight: 600;
    /*font-weight: bold;*/
  }
  .vars-item {
    margin-bottom: 4px;
  }
  .vars-item:first-child {
    margin-top: 4px;
  }


  .var {
    display: inline-block;
    line-height: 1;
    font-style: italic;

    color: #5f426e;
    background: #bda3cc;

    padding: 2px 5px 3px 5px;
    border-radius: 13px;

    /*margin-bottom: 1px;*/
    margin-right: 2px;
  }

  .var:hover {
    cursor: pointer;
    color: #500a74;
    background: #ad8ebe;
  }

  /*
  .var-alias {
    color: #9876aa;
    background: pink;
  }
  */

  .vars-notice {

  }

  .var_mod-city-by-shop {
    color: #906107;
    background: #fdc83a;
  }

  .var_mod-city-by-shop:hover {
    color: #906107;
    background: #e0ae28;
  }

  .var_mod-synonyms {
    color: #906107;
    background: #fdc83a;
  }

  .var_mod-synonyms:hover {
    color: #906107;
    background: #e0ae28;
  }

  .var_custom-variables {
    color: #888;
    background: #ddd;
  }

  .var_custom-variables:hover {
    color: #555;
    background: #ccc;
  }

  /* categories list */

  .categories-selector ul {
    padding: 0;
  }

  .categories-selector ul li {
    list-style: none;
    border-left: 1px solid red;
    padding-left: 7px;
    margin-left: 11px;
  }

  .categories-selector ul ul {
    padding-left: 26px;
    padding-bottom: 5px;
  }

  .categories-selector input[type="checkbox"] {
    margin-right: 7px;
    margin-left: -7px;
  }

  .li-space {
    display: inline-block;
    width: 24px;
    font-size: 15px;
    font-weight: bold;
    border-radius: 2px;
    line-height: 1;
    padding: 3px 0 3px 0;
    margin-right: 10px;
  }

  .li-space.toggle-item {
    text-align: center;
  }
  .li-space.toggle-item:hover {
    cursor: pointer;
    background: #ccc;
  }

  .categories-selector ul li label {
    height: 20px;
  }

  .category-item_1 > label {
    text-transform: uppercase;
    font-weight: 600;
    font-size: 13px;
  }

  .category-item_2 > label {
    font-weight: 700;
    font-size: 13px;
  }

  .category-item_3 label {
    font-weight: normal;
    font-style: italic;
  }

  .categories-selector label._inactive {
    color: #9f9f9f;
  }

  a:hover {
    cursor: pointer;
  }

</style>

<div class="alert alert-info">
  <?= $tab_seo_tags_generator_info ?>
</div>

<ul class="nav nav-tabs" id="language-stg">
  <?php foreach ($languages as $language) { ?>
  <li><a href="#language-stg<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
  <?php } ?>
</ul>
<div class="tab-content">
  <?php foreach ($languages as $language) { ?>
  <div class="tab-pane" id="language-stg<?php echo $language['language_id']; ?>">



    <div class="row1">
      <br>
      <div class="col-sm-12" id="stg-formulas">

        <!-- category . begin -->

        <div class="row formula-row_group" style="border: 1px dashed #ccc; padding: 10px 0; ">
          <div class="col-sm-12">
            <h4><?= $tab_category ?></h4>

            <!-- title -->

            <div class="form-group">
              <label class="col-sm-2 control-label" for="formulas-category-title<?= $language['language_id'] ?>"><?= $entry_category_title ?>:</label>
              <div class="col-sm-10">
                <input id="formulas-category-title<?= $language['language_id'] ?>" type="text" name="stg_specific[formulas][<?= $language['language_id'] ?>][category][title]" value="<?= isset($stg_specific['formulas'][$language['language_id']]['category']['title']) ? $stg_specific['formulas'][$language['language_id']]['category']['title'] : ''; ?>" class="form-control" />
                <div class="vars-main row">
                  <div class="col-sm-2"><?= $text_available_vars ?>: </div>
                  <div class="col-sm-10 vars-container" data-target="#formulas-category-title<?= $language['language_id'] ?>">
                    <div class="vars-item">
                      <span class="var">[category_name]</span>
                      <?php if($seo_tags_generator_declension) { ?>
                      <span class="var">[category_name_plural_nominative]</span>
                      <!-- <span class="var var-alias">[category_name_full]</span> -->
                      <span class="var">[category_name_plural_genitive]</span>
                      <span class="var">[category_name_singular_nominative]</span>
                      <!-- <span class="var var-alias">[category_definition]</span> -->
                      <?php } ?>
                      <span class="var">[count_products]</span>
                      <span class="var">[min_price]</span>
                      <span class="var">[max_price]</span>
                    </div>
                    <div class="vars-item">
                      <span class="var">[shop_name]</span>
                    </div>
                    <div class="vars-item custom-variables">
                      <!-- <span class="var var_custom-variables">[custom]</span> -->
                    </div>
                  </div>
                </div>
                <?php if (isset($errors['category_title'][$language['language_id']])) { ?>
                <div class="text-danger"><?= $errors['category_title'][$language['language_id']] ?></div>
                <?php } ?>
              </div>
            </div>

            <!-- description -->

            <div class="form-group">
              <label class="col-sm-2 control-label" for="formulas-category-description<?= $language['language_id'] ?>"><?= $entry_category_description ?>:</label>
              <div class="col-sm-10">
                <textarea id="formulas-category-description<?= $language['language_id'] ?>" type="text" name="stg_specific[formulas][<?= $language['language_id'] ?>][category][description]" class="form-control" rows="3"><?= isset($stg_specific['formulas'][$language['language_id']]['category']['description']) ? $stg_specific['formulas'][$language['language_id']]['category']['description'] : ''; ?></textarea>
                <div class="vars-main row">
                  <div class="col-sm-2"><?= $text_available_vars ?>: </div>
                  <div class="col-sm-10 vars-container" data-target="#formulas-category-description<?= $language['language_id'] ?>">
                    <div class="vars-item">
                      <span class="var">[category_name]</span>
                      <?php if($seo_tags_generator_declension) { ?>
                      <span class="var">[category_name_plural_nominative]</span>
                      <!-- <span class="var var-alias">[category_name_full]</span> -->
                      <span class="var">[category_name_plural_genitive]</span>
                      <span class="var">[category_name_singular_nominative]</span>
                      <!-- <span class="var var-alias">[category_definition]</span> -->
                      <?php } ?>
                      <span class="var">[count_products]</span>
                      <span class="var">[min_price]</span>
                      <span class="var">[max_price]</span>
                    </div>
                    <div class="vars-item">
                      <span class="var">[shop_name]</span>
                      <span class="var">[config_telephone]</span>
                    </div>
                    <div class="vars-item custom-variables">
                      <!-- <span class="var var_custom-variables">[custom]</span> -->
                    </div>
                  </div>
                </div>
                <?php if (isset($errors['category_description'][$language['language_id']])) { ?>
                <div class="text-danger"><?= $errors['category_description'][$language['language_id']] ?></div>
                <?php } ?>
              </div>
            </div>

            <!-- keyword -->

            <div class="form-group">
              <label class="col-sm-2 control-label" for="formulas-category-keyword<?= $language['language_id'] ?>"><?= $entry_category_keyword ?>:</label>
              <div class="col-sm-10">
                <input id="formulas-category-keyword<?= $language['language_id'] ?>"
                  type="text" name="stg_specific[formulas][<?= $language['language_id'] ?>][category][keyword]" value="<?= isset($stg_specific['formulas'][$language['language_id']]['category']['keyword']) ? $stg_specific['formulas'][$language['language_id']]['category']['keyword'] : ''; ?>" class="form-control" />
                <div class="vars-main row">
                  <div class="col-sm-2"><?= $text_available_vars ?>: </div>
                  <div class="col-sm-10 vars-container" data-target="#formulas-category-keyword<?= $language['language_id'] ?>">
                    <div class="vars-item">
                      <span class="var">[category_name]</span>
                      <?php if($seo_tags_generator_declension) { ?>
                      <span class="var">[category_name_plural_nominative]</span>
                      <!-- <span class="var var-alias">[category_name_full]</span> -->
                      <span class="var">[category_name_plural_genitive]</span>
                      <span class="var">[category_name_singular_nominative]</span>
                      <!-- <span class="var var-alias">[category_definition]</span> -->
                      <?php } ?>
                    </div>
                    <div class="vars-item custom-variables">
                      <!-- <span class="var var_custom-variables">[custom]</span> -->
                    </div>
                  </div>
                </div>
                <?php if (isset($errors['category_keyword'][$language['language_id']])) { ?>
                <div class="text-danger"><?= $errors['category_keyword'][$language['language_id']] ?></div>
                <?php } ?>
              </div>
            </div>

          </div><!-- /col-sm-12 -->
        </div>

        <!-- /category . end -->


        <!-- product . begin -->

        <div class="row formula-row_group" style="border: 1px dashed #ccc; padding: 10px 0; margin-top: 15px;">
          <div class="col-sm-12">
            <h4><?= $tab_product ?></h4>

            <!-- title -->

            <div class="form-group">
              <label class="col-sm-2 control-label" for="formulas-product-title<?= $language['language_id'] ?>"><?= $entry_product_title ?>:</label>
              <div class="col-sm-10">
                <input id="formulas-product-title<?= $language['language_id'] ?>" type="text" name="stg_specific[formulas][<?= $language['language_id'] ?>][product][title]" value="<?= isset($stg_specific['formulas'][$language['language_id']]['product']['title']) ? $stg_specific['formulas'][$language['language_id']]['product']['title'] : ''; ?>" class="form-control" />
                <div class="vars-main row">
                  <div class="col-sm-2"><?= $text_available_vars ?>: </div>
                  <div class="col-sm-10 vars-container" data-target="#formulas-product-title<?= $language['language_id'] ?>">
                    <div class="vars-item">
                      <span class="var">[product_name]</span>
                      <span class="var">[model]</span>
                      <span class="var var_mod-synonyms">[model_synonym]</span>
                      <span class="var">[sku]</span>
                      <span class="var">[manufacturer]</span>
                      <span class="var">[price]</span>
                    </div>
                    <?php if($seo_tags_generator_declension) { ?>
                    <div class="vars-item">
                    <span class="var">[category_name_singular_nominative]</span>
                    <!-- <span class="var var-alias">[category_definition]</span> -->
                     </div>
                    <?php } ?>
                    <div class="vars-item custom-variables">
                      <!-- <span class="var var_custom-variables">[custom]</span> -->
                    </div>
                  </div>
                </div>
                <?php if (isset($errors['product_title'][$language['language_id']])) { ?>
                <div class="text-danger"><?= $errors['product_title'][$language['language_id']] ?></div>
                <?php } ?>
              </div>
            </div>

            <!-- description -->

            <div class="form-group">
              <label class="col-sm-2 control-label" for="formulas-product-description<?= $language['language_id'] ?>"><?= $entry_product_description ?>:</label>
              <div class="col-sm-10">
                <textarea id="formulas-product-description<?= $language['language_id'] ?>" type="text" name="stg_specific[formulas][<?= $language['language_id'] ?>][product][description]" class="form-control" rows="3"><?= isset($stg_specific['formulas'][$language['language_id']]['product']['description']) ? $stg_specific['formulas'][$language['language_id']]['product']['description'] : ''; ?></textarea>
                <div class="vars-main row">
                  <div class="col-sm-2"><?= $text_available_vars ?>: </div>
                  <div class="col-sm-10 vars-container" data-target="#formulas-product-description<?= $language['language_id'] ?>">
                    <div class="vars-item">
                      <span class="var">[product_name]</span>
                      <span class="var">[model]</span>
                      <span class="var var_mod-synonyms">[model_synonym]</span>
                      <span class="var">[sku]</span>
                      <span class="var">[manufacturer]</span>
                      <span class="var">[price]</span>
                    </div>
                    <div class="vars-item">
                      <span class="var">[category_name]</span>
                      <?php if($seo_tags_generator_declension) { ?>
                      <span class="var">[category_name_plural_nominative]</span>
                      <!-- <span class="var var-alias">[category_name_full]</span> -->
                      <span class="var">[category_name_plural_genitive]</span>
                      <span class="var">[category_name_singular_nominative]</span>
                      <!-- <span class="var var-alias">[category_definition]</span> -->
                      <?php } ?>
                    </div>
                    <div class="vars-item">
                      <span class="var">[shop_name]</span>
                      <span class="var">[config_telephone]</span>
                    </div>
                    <div class="vars-item custom-variables">
                      <!-- <span class="var var_custom-variables">[custom]</span> -->
                    </div>
                  </div>
                </div>
                <?php if (isset($errors['product_description'][$language['language_id']])) { ?>
                <div class="text-danger"><?= $errors['product_description'][$language['language_id']] ?></div>
                <?php } ?>
              </div>
            </div>

            <!-- keyword -->

            <div class="form-group">
              <label class="col-sm-2 control-label" for="formulas-product-keyword<?= $language['language_id'] ?>"><?= $entry_product_keyword ?>:</label>
              <div class="col-sm-10">
                <input id="formulas-product-keyword<?= $language['language_id'] ?>" type="text" name="stg_specific[formulas][<?= $language['language_id'] ?>][product][keyword]" value="<?= isset($stg_specific['formulas'][$language['language_id']]['product']['keyword']) ? $stg_specific['formulas'][$language['language_id']]['product']['keyword'] : ''; ?>" class="form-control" />
                <div class="vars-main row">
                  <div class="col-sm-2"><?= $text_available_vars ?>: </div>
                  <div class="col-sm-10 vars-container" data-target="#formulas-product-keyword<?= $language['language_id'] ?>">
                    <div class="vars-item">
                      <span class="var">[product_name]</span>
                      <span class="var">[model]</span>
                      <span class="var var_mod-synonyms">[model_synonym]</span>
                      <span class="var">[sku]</span>
                      <span class="var">[manufacturer]</span>
                    </div>
                    <?php if($seo_tags_generator_declension) { ?>
                    <div class="vars-item">
                    <span class="var">[category_name_singular_nominative]</span>
                    <!-- <span class="var var-alias">[category_definition]</span> -->
                     </div>
                    <?php } ?>
                    <div class="vars-item custom-variables">
                      <!-- <span class="var var_custom-variables">[custom]</span> -->
                    </div>
                  </div>
                </div>
                <?php if (isset($errors['product_keyword'][$language['language_id']])) { ?>
                <div class="text-danger"><?= $errors['product_keyword'][$language['language_id']] ?></div>
                <?php } ?>
              </div>
            </div>

            <!-- h1 -->

            <div class="form-group">
              <label class="col-sm-2 control-label" for="formulas-product-h1<?= $language['language_id'] ?>"><?= $entry_product_h1 ?>:</label>
              <div class="col-sm-10">
                <input id="formulas-product-h1<?= $language['language_id'] ?>" type="text" name="stg_specific[formulas][<?= $language['language_id'] ?>][product][h1]" value="<?= isset($stg_specific['formulas'][$language['language_id']]['product']['h1']) ? $stg_specific['formulas'][$language['language_id']]['product']['h1'] : ''; ?>" class="form-control" />
                <div class="vars-main row">
                  <div class="col-sm-2"><?= $text_available_vars ?>: </div>
                  <div class="col-sm-10 vars-container" data-target="#formulas-product-h1<?= $language['language_id'] ?>">
                    <div class="vars-item">
                      <span class="var">[product_name]</span>
                      <span class="var">[model]</span>
                      <span class="var var_mod-synonyms">[model_synonym]</span>
                      <span class="var">[sku]</span>
                      <span class="var">[manufacturer]</span>
                      <span class="var">[price]</span>
                    </div>
                    <?php if($seo_tags_generator_declension) { ?>
                    <div class="vars-item">
                    <span class="var">[category_name_singular_nominative]</span>
                    <!-- <span class="var var-alias">[category_definition]</span> -->
                     </div>
                    <?php } ?>
                    <div class="vars-item custom-variables">
                      <!-- <span class="var var_custom-variables">[custom]</span> -->
                    </div>
                  </div>
                </div>
                <?php if (isset($errors['product_h1'][$language['language_id']])) { ?>
                <div class="text-danger"><?= $errors['product_h1'][$language['language_id']] ?></div>
                <?php } ?>
              </div>
            </div>

          </div><!-- /col-sm-12 -->
        </div>
        <!-- /product . end -->

      </div>
    </div>
  </div>
  <?php } ?>
</div>

<script>$('#language-stg a:first').tab('show');</script>

<script>
  // init global
  var cursorPosition  = false;
  var last_identifier = false;

  $('.formula-row_group .form-control').click(function(){
    cursorPosition  = caretPosition($(this));
    last_identifier = "#" + $(this).attr('id');
  });


  //$('.var').each(function() {
    $('.var').click(function(){
      var target = $(this).parent('.vars-item').parent('.vars-container').data('target');

      if (last_identifier !== target) {
        cursorPosition = false;
      }

      last_identifier      = target;

      var value            = $(target).val();
      var newElement       = $(this).html();
      var partBeforeCursor = value.slice(0, cursorPosition);
      var partAfterCursor  = value.slice(cursorPosition, value.length);

      if (cursorPosition === false) {
        if (value.length > 1) {
          var last_char = value.slice(-1);
          if (last_char != ' ') {
            value += ' ';
          }
        }
        $(target).val(value + newElement);
      } else {
        if (partBeforeCursor.length > 1) {
          var last_char = partBeforeCursor.slice(-1);
          if (last_char != ' ') {
            partBeforeCursor += ' ';
          }
        }
        last_char = partAfterCursor.slice(0, 1);
        if (last_char != ' ') {
          partAfterCursor = ' ' + partAfterCursor;
        }
        $(target).val(partBeforeCursor  + newElement + partAfterCursor);
      }
    });
  //});


  /* Caret Position
  --------------------------------------------------------------------------- */
  // http://qaru.site/questions/42834/get-cursor-position-in-characters-within-a-text-input-field
  function caretPosition(input) {
    var start = input[0].selectionStart,
      end = input[0].selectionEnd,
      diff = end - start;

    if (start >= 0 && start == end) {
      // do cursor position actions, example:
      //console.log('Cursor Position: ' + start);
    } else if (start >= 0) {
      // do ranged select actions, example:
      //console.log('Cursor Position: ' + start + ' to ' + end + ' (' + diff + ' selected chars)');
    }

    return start;
  }

</script>

<div class="col-sm-12">
  <div class="row formula-row_group" style="border: 1px dashed #ccc; padding: 10px 0; margin-top: 15px;">
    <div class="col-sm-12">
      <h4><?= $tab_category_setting ?></h4>

      <!-- setting inheritance -->

      <div class="form-group">
        <label class="col-sm-2 control-label"><?= $entry_category_setting_inheritance ?>:</label>
        <div class="col-sm-10">
          <label style="margin-right: 10px;"><input type="radio" name="stg_specific[setting][inheritance]" value="1" class="" <?= $stg_specific['setting']['inheritance'] ? 'checked="checked"' : '' ?> /> <?= $text_inheritance_yes ?></label>
          <label><input type="radio" name="stg_specific[setting][inheritance]" value="0" class="" <?= isset($stg_specific['setting']['inheritance']) && !$stg_specific['setting']['inheritance'] ? 'checked="checked"' : '' ?> /> <?= $text_inheritance_no ?></label>
        </div>
      </div>

      <!-- setting inheritance copy -->

      <div class="form-group">
        <label class="col-sm-2 control-label"><?= $entry_category_setting_inheritance_copy ?>:</label>
        <div class="col-sm-10 radio">
          <label style="margin-right: 10px;" class="checkbox-inline"><input type="checkbox" name="stg_specific[setting][inheritance_copy]" value="1" class="" /> <?= $text_inheritance_copy_yes ?></label>
          <?php if ( isset($stg_specific['setting']['inheritance_copy']) ) { ?>
          <p class="text-warning">
            <?= $text_inheritance_copy_warning ?>
          </p>
          <?php } ?>
        </div>
      </div>

      <!-- setting copy to others -->

      <div class="form-group">
        <label class="col-sm-2 control-label"><?= $entry_category_setting_copy_to_others ?>:</label>
        <div class="col-sm-10 radio">
          <label style="margin-right: 10px;" class="checkbox-inline"><input id="copy-to-others" type="checkbox" name="stg_specific[setting][copy_to_others]" value="1" class="" /> <?= $text_copy_to_others_yes ?></label>
          <?php if ( isset($stg_specific['setting']['copy_to_others']) ) { ?>
          <p class="text-warning">
            <?= $text_copy_to_others_warning ?>
          </p>
          <?php } ?>
        </div>
      </div>

      <!-- category select from ocStore -->

      <div class="form-group" id="categoy-selector_container">
        <label class="col-sm-2 control-label" for="input-category"><?php echo $entry_categories; ?></label>
        <div class="col-sm-10">
          <div class="categories-selector">
            <?= $categories_list ?>
          </div>
          <a onclick="$(this).parent().find(':checkbox:not(:disabled)').prop('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox:not(:disabled)').prop('checked', false);"><?php echo $text_unselect_all; ?></a>
        </div>

        <script>
          $(function() {
            if ($('#copy-to-others').is(':checked')) {
              $('#categoy-selector_container').show(200);
            } else {
              $('#categoy-selector_container').hide(200);
            }
          });

          $('#copy-to-others').click(function(){
            if ($('#copy-to-others').is(':checked')) {
              $('#categoy-selector_container').show(200);
            } else {
              $('#categoy-selector_container').hide(200);
            }
          });



          $(function() {
            $('.categories-selector .has-children').each(function() {
              $(this).children('ul').hide();
            });
          });

          $(function() {
            $('.categories-selector .toggle-item').each(function() {
              $(this).click(function(){
                if($(this).hasClass('closed')) {
                  $(this).html('-');
                  $(this).removeClass('closed');
                  $(this).parent('.has-children').children('ul').show(100);
                } else {
                  $(this).html('+');
                  $(this).addClass('closed');
                  $(this).parent('.has-children').children('ul').hide(100);
                }

              });
            });
          });

          $('.categories-selector input').each(function() {
            $(this).click(function(){
              if ($(this).is(':checked')) {
                // check
                $(this).parent('label').parent('.has-children').find(':checkbox:not(:disabled)').prop('checked', true);

              } else {
                // uncheck
                $(this).parent('label').parent('.has-children').find(':checkbox:not(:disabled)').prop('checked', false);

              }
            });
          });

        </script>
      </div>

    </div><!-- /col-sm-12 -->
  </div>
</div>