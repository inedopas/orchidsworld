<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-seo-tags-generator" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div><!-- /page-header -->
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if (!empty($success)) { ?>
    <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h2 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h2>
      </div>



      <!-- Customization.Begin -->
      <div class="panel-body">
				<!-- Loader.Begin -->
				<link href="view/stylesheet/load-bar.css" type="text/css" rel="stylesheet" media="screen" />
				<link href="view/stylesheet/seo-tags-generator.css" type="text/css" rel="stylesheet" media="screen" />


				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-seo-tags-generator" class="form-horizontal">

					<?php if ($show_licence_entry) { ?>
					<!-- licence -->
					<div class="form-group" style="margin-bottom: 20px;">
						<label class="col-sm-2 control-label"	for="input-licence"><?=$entry_licence?>:</label>
						<div class="col-sm-10">
							<input id="input-licence" type="text"	name="seo_tags_generator_licence"	value="<?= isset($seo_tags_generator_licence) ? $seo_tags_generator_licence : ''; ?>" class="form-control" />
							<?php if (isset($errors['licence'])) { ?><div class="text-danger"><?=$errors['licence']?></div><?php } ?>
							<?php if (isset($warning['licence'])) { ?><div class="text-warning"><?=$warning['licence']?></div><?php } ?>
						</div>
					</div>
					<?php } ?>

					<?php if ($show_temp_licence_button) { ?>
					<div class="form-group">
						<label class="col-sm-2 control-label" ><?php echo $entry_temp_licence; ?>: <span data-toggle="tooltip" title="<?=$entry_temp_licence_tooltip?>"></span></label>
						<div class="col-sm-10">
							<div id="alert-temp-licence"></div>

							<div id="temp-licence-button-container">
								<button id="get-temp-licence" class="btn btn-primary" style="position: relative;"><?=$button_get_temp_licence?>
									<div class="load-bar">
										<div class="spinner">
											<div class="bounce1"></div>
											<div class="bounce2"></div>
											<div class="bounce3"></div>
										</div>
									</div>
								</button>
							</div>
						</div>
					</div>
					<?php } ?>

					<div id="module-work-area"<?=$show_work_area ? '' : 'class="hidden"' ?> >

						<fieldset>
							<h3><?=$fieldset_setting?></h3>

							<!-- module status -->

							<div class="form-group option-selector option-status" style="padding-bottom: 0; <?=!$show_licence_entry ? 'padding-top: 0' : ''?> ">
								<label class="col-sm-2 control-label" for="input-status-mod"><?php echo $entry_status; ?>:</label>
								<div class="col-sm-2">
									<select name="seo_tags_generator_status" id="input-status-mod" class="form-control">
										<?php if ($seo_tags_generator_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
										<?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<hr />

							<!-- generate mode for category -->

							<div class="form-group option-selector">
								<label class="col-sm-2 control-label" for="seo_tags_generator_generate_mode_category"><?=$entry_generate_mode_category?>:</label>
								<div class="col-sm-3">
									<select name="seo_tags_generator_generate_mode_category" id="seo_tags_generator_generate_mode_category" class="form-control">
                    <?php foreach ($a_generate_mode as $key => $item) { ?>
                    <option value="<?=$key?>" <?=$key == $seo_tags_generator_generate_mode_category ? 'selected="selected"' : ''?>><?=$item?></option>
                    <?php } ?>
									</select>
								</div>
							</div>
							<hr />

							<!-- generate mode for product -->

							<div class="form-group option-selector">
								<label class="col-sm-2 control-label" for="seo_tags_generator_generate_mode_product"><?=$entry_generate_mode_product?>:</label>
								<div class="col-sm-3">
									<select name="seo_tags_generator_generate_mode_product" id="seo_tags_generator_generate_mode_product" class="form-control">
                    <?php foreach ($a_generate_mode as $key => $item) { ?>
                    <option value="<?=$key?>" <?=$key == $seo_tags_generator_generate_mode_product ? 'selected="selected"' : ''?>><?=$item?></option>
                    <?php } ?>
									</select>
								</div>
							</div>
							<hr />

							<!-- generate mode for product : h1 -->

							<div class="form-group option-selector">
								<label class="col-sm-2 control-label" for="seo_tags_generator_status_product_h1"><?=$entry_status_product_h1?>: <span data-toggle="tooltip" title="<?=$entry_status_product_h1_tooltip?>"></span></label>
								<div class="col-sm-2">
									<select name="seo_tags_generator_status_product_h1" id="seo_tags_generator_status_product_h1" class="form-control">
										<?php if ($seo_tags_generator_status_product_h1) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
										<?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<hr />

							<!-- generate mode for manufacturer -->

							<div class="form-group option-selector">
								<label class="col-sm-2 control-label" for="seo_tags_generator_generate_mode_manufacturer"><?=$entry_generate_mode_manufacturer?>: <span data-toggle="tooltip" title="<?=$entry_generate_mode_manufacturer_tooltip?>"></span></label>
								<div class="col-sm-3">
									<select name="seo_tags_generator_generate_mode_manufacturer" id="seo_tags_generator_generate_mode_manufacturer" class="form-control">
                    <?php foreach ($a_generate_mode as $key => $item) { ?>
                    <option value="<?=$key?>" <?=$key == $seo_tags_generator_generate_mode_manufacturer ? 'selected="selected"' : ''?>><?=$item?></option>
                    <?php } ?>
									</select>
								</div>
							</div>
              <hr />

							<!-- inheritance -->

							<div class="form-group option-selector">
								<label class="col-sm-2 control-label" for="seo_tags_generator_inheritance"><?=$entry_inheritance?>: <span data-toggle="tooltip" title="<?=$entry_inheritance_tooltip?>"></span></label>
								<div class="col-sm-3">
									<select name="seo_tags_generator_inheritance" id="seo_tags_generator_inheritance" class="form-control">
                    <?php if ($seo_tags_generator_inheritance) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
										<?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
              <hr />

              <!-- declension -->

              <div class="form-group option-selector">
								<label class="col-sm-2 control-label" for="seo_tags_generator_declension"><?=$entry_declension?>: <span data-toggle="tooltip" title="<?=$entry_declension_tooltip?>"></span></label>
								<div class="col-sm-3">
									<select name="seo_tags_generator_declension" id="seo_tags_generator_declension" class="form-control">
                    <?php if ($seo_tags_generator_declension) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
										<?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

						</fieldset>

						<fieldset>
							<h3><?=$fieldset_formula_common?></h3>
							<div class="row formula-row">
								<div class="col-sm-12">
									<!-- language -->
									<div class="tab-pane">
										<ul class="nav nav-tabs" id="language">
											<?php foreach ($languages as $language) { ?>
												<li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
											<?php } ?>
										</ul>
										<!-- tab-content languages.begin-->
										<div class="tab-content">
											<?php foreach ($languages as $language) { ?>
												<!-- language pane.begin-->
												<div class="tab-pane" id="language<?php echo $language['language_id']; ?>">

                          <!-- category.begin
                          ============================================================================================= -->
													<div class="row formula-row_group">
														<div class="col-sm-12">
															<h4><?=$tab_category?></h4>

															<!-- title -->
															<div class="form-group">
																<label class="col-sm-2 control-label" for="input-category-formula-title-lang<?=$language['language_id']?>"><?=$entry_category_title?>:</label>
																<div class="col-sm-10">
																	<input id="input-category-formula-title-lang<?=$language['language_id']?>" type="text" name="seo_tags_generator_category_title[<?=$language['language_id']?>]" value="<?= isset($seo_tags_generator_category_title[$language['language_id']]) ? $seo_tags_generator_category_title[$language['language_id']] : ''; ?>" class="form-control" />
																	<div class="vars-main row">
                                    <div class="col-sm-2"><?= $text_available_vars ?>: </div>
                                    <div class="col-sm-10 vars-container" data-target="#input-category-formula-title-lang<?=$language['language_id']?>">
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
                                  <div class="text-danger"><?=$errors['category_title'][$language['language_id']] ?></div>
																	<?php } ?>
																</div>
															</div>

															<!-- description -->
															<div class="form-group">
																<label class="col-sm-2 control-label" for="input-category-formula-description-lang<?=$language['language_id']?>"><?=$entry_category_description?>:</label>
																<div class="col-sm-10">
																	<textarea id="input-category-formula-description-lang<?=$language['language_id']?>" type="text" name="seo_tags_generator_category_description[<?=$language['language_id']?>]" class="form-control" rows="3"><?= isset($seo_tags_generator_category_description[$language['language_id']]) ? $seo_tags_generator_category_description[$language['language_id']] : ''; ?></textarea>
																	<div class="vars-main row">
                                    <div class="col-sm-2"><?= $text_available_vars ?>: </div>
                                    <div class="col-sm-10 vars-container" data-target="#input-category-formula-description-lang<?= $language['language_id'] ?>">
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
                                  <div class="text-danger"><?=$errors['category_description'][$language['language_id']] ?></div>
																	<?php } ?>
																</div>
															</div>

															<!-- keyword -->
															<div class="form-group">
																<label class="col-sm-2 control-label" for="input-category-formula-keyword-lang<?=$language['language_id']?>"><?=$entry_category_keyword?>:</label>
																<div class="col-sm-10">
																	<input id="input-category-formula-keyword-lang<?=$language['language_id']?>" type="text"
																	name="seo_tags_generator_category_keyword[<?=$language['language_id']?>]" value="<?= isset($seo_tags_generator_category_keyword[$language['language_id']]) ? $seo_tags_generator_category_keyword[$language['language_id']] : ''; ?>" class="form-control" />
																	<div class="vars-main row">
                                    <div class="col-sm-2"><?= $text_available_vars ?>: </div>
                                    <div class="col-sm-10 vars-container" data-target="#input-category-formula-keyword-lang<?= $language['language_id'] ?>">
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
                                  <div class="text-danger"><?=$errors['category_keyword'][$language['language_id']] ?></div>
																	<?php } ?>
																</div>
															</div>

														</div><!-- /col-sm-12 -->
													</div><!-- /row-->
													<!-- /category.end -->

													<!-- product.begin
                          ============================================================================================= -->
													<div class="row formula-row_group">
														<div class="col-sm-12">
															<h4><?=$tab_product?></h4>

															<!-- title -->
															<div class="form-group">
																<label class="col-sm-2 control-label" for="input-product-formula-title-lang<?=$language['language_id']?>"><?=$entry_product_title?>:</label>
																<div class="col-sm-10">
																	<input id="input-product-formula-title-lang<?=$language['language_id']?>" type="text" name="seo_tags_generator_product_title[<?=$language['language_id']?>]" value="<?= isset($seo_tags_generator_product_title[$language['language_id']]) ? $seo_tags_generator_product_title[$language['language_id']] : ''; ?>" class="form-control" />
																	<div class="vars-main row">
                                    <div class="col-sm-2"><?= $text_available_vars ?>: </div>
                                    <div class="col-sm-10 vars-container" data-target="#input-product-formula-title-lang<?= $language['language_id'] ?>">
                                      <div class="vars-item">
                                        <span class="var">[product_name]</span>
                                        <span class="var">[model]</span>
                                        <span class="var var_mod-synonyms">[model_synonym]</span>
                                        <span class="var">[sku]</span>
                                        <span class="var">[manufacturer]</span>
                                        <span class="var">[price]</span>
                                      </div>
                                      <?php if ($seo_tags_generator_declension) { ?>
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
                                  <div class="text-danger"><?=$errors['product_title'][$language['language_id']] ?></div>
																	<?php } ?>
																</div>
															</div>

															<!-- description -->
															<div class="form-group">
																<label class="col-sm-2 control-label" for="input-product-formula-description-lang<?=$language['language_id']?>"><?=$entry_product_description?>:</label>
																<div class="col-sm-10">
																	<textarea id="input-product-formula-description-lang<?=$language['language_id']?>" type="text" name="seo_tags_generator_product_description[<?=$language['language_id']?>]" class="form-control" rows="3"><?= isset($seo_tags_generator_product_description[$language['language_id']]) ? $seo_tags_generator_product_description[$language['language_id']] : ''; ?></textarea>
																	<div class="vars-main row">
                                    <div class="col-sm-2"><?= $text_available_vars ?>: </div>
                                    <div class="col-sm-10 vars-container" data-target="#input-product-formula-description-lang<?= $language['language_id'] ?>">
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
                                  <div class="text-danger"><?=$errors['product_description'][$language['language_id']] ?></div>
																	<?php } ?>
																</div>
															</div>

															<!-- keyword -->
															<div class="form-group">
																<label class="col-sm-2 control-label" for="input-product-formula-keyword-lang<?=$language['language_id']?>"><?=$entry_product_keyword?>:</label>
																<div class="col-sm-10">
																	<input id="input-product-formula-keyword-lang<?=$language['language_id']?>" type="text" name="seo_tags_generator_product_keyword[<?=$language['language_id']?>]" value="<?= isset($seo_tags_generator_product_keyword[$language['language_id']]) ? $seo_tags_generator_product_keyword[$language['language_id']] : ''; ?>" class="form-control" />
																	<div class="vars-main row">
                                    <div class="col-sm-2"><?= $text_available_vars ?>: </div>
                                    <div class="col-sm-10 vars-container" data-target="#input-product-formula-keyword-lang<?= $language['language_id'] ?>">
                                      <div class="vars-item">
                                        <span class="var">[product_name]</span>
                                        <span class="var">[model]</span>
                                        <span class="var var_mod-synonyms">[model_synonym]</span>
                                        <span class="var">[sku]</span>
                                        <span class="var">[manufacturer]</span>
                                      </div>
                                      <?php if ($seo_tags_generator_declension) { ?>
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
                                  <div class="text-danger"><?=$errors['product_keyword'][$language['language_id']] ?></div>
																	<?php } ?>
																</div>
															</div>

															<!-- h1 -->
															<div class="form-group">
																<label class="col-sm-2 control-label" for="input-product-formula-h1-lang<?=$language['language_id']?>"><?=$entry_product_h1?>:</label>
																<div class="col-sm-10">
																	<input id="input-product-formula-h1-lang<?=$language['language_id']?>" type="text" name="seo_tags_generator_product_h1[<?=$language['language_id']?>]" value="<?= isset($seo_tags_generator_product_h1[$language['language_id']]) ? $seo_tags_generator_product_h1[$language['language_id']] : ''; ?>" class="form-control" />
																	<div class="vars-main row">
                                    <div class="col-sm-2"><?= $text_available_vars ?>: </div>
                                    <div class="col-sm-10 vars-container" data-target="#input-product-formula-h1-lang<?= $language['language_id'] ?>">
                                      <div class="vars-item">
                                        <span class="var">[product_name]</span>
                                        <span class="var">[model]</span>
                                        <span class="var var_mod-synonyms">[model_synonym]</span>
                                        <span class="var">[sku]</span>
                                        <span class="var">[manufacturer]</span>
                                        <span class="var">[price]</span>
                                      </div>
                                      <?php if ($seo_tags_generator_declension) { ?>
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
                                  <div class="text-danger"><?=$errors['product_h1'][$language['language_id']] ?></div>
																	<?php } ?>
																</div>
															</div>
														</div><!-- /col-sm-12 -->
													</div>
													<!-- /product.end -->

													<!-- manufacturer.begin
                          ============================================================================================= -->
													<div class="row formula-row_group">
														<div class="col-sm-12">
															<h4><?=$tab_manufacturer?></h4>

															<!-- title -->
															<div class="form-group">
																<label class="col-sm-2 control-label" for="input-manufacturer-formula-title-lang<?=$language['language_id']?>"><?=$entry_manufacturer_title?>:</label>
																<div class="col-sm-10">
																	<input id="input-manufacturer-formula-title-lang<?=$language['language_id']?>" type="text"
																	name="seo_tags_generator_manufacturer_title[<?=$language['language_id']?>]" value="<?= isset($seo_tags_generator_manufacturer_title[$language['language_id']]) ? $seo_tags_generator_manufacturer_title[$language['language_id']] : ''; ?>" class="form-control" />
                                  <div class="vars-main row">
                                    <div class="col-sm-2"><?= $text_available_vars ?>: </div>
                                    <div class="col-sm-10 vars-container" data-target="#input-manufacturer-formula-title-lang<?= $language['language_id'] ?>">
                                      <div class="vars-item">
                                        <span class="var">[manufacturer_name]</span>
                                        <span class="var">[shop_name]</span>
                                        <span class="var">[config_telephone]</span>
                                      </div>
                                      <div class="vars-item custom-variables">
                                        <!-- <span class="var var_custom-variables">[custom]</span> -->
                                      </div>
                                    </div>
                                  </div>
																	<?php if (isset($errors['manufacturer_title'][$language['language_id']])) { ?>
                                  <div class="text-danger"><?=$errors['manufacturer_title'][$language['language_id']] ?></div>
																	<?php } ?>
																</div>
															</div>

															<!-- description -->
															<div class="form-group">
																<label class="col-sm-2 control-label" for="input-manufacturer-formula-description-lang<?=$language['language_id']?>"><?=$entry_manufacturer_description?>:</label>
																<div class="col-sm-10">
																	<textarea id="input-manufacturer-formula-description-lang<?=$language['language_id']?>" type="text" name="seo_tags_generator_manufacturer_description[<?=$language['language_id']?>]" class="form-control" rows="3"><?= isset($seo_tags_generator_manufacturer_description[$language['language_id']]) ? $seo_tags_generator_manufacturer_description[$language['language_id']] : ''; ?></textarea>
																	<div class="vars-main row">
                                    <div class="col-sm-2"><?= $text_available_vars ?>: </div>
                                    <div class="col-sm-10 vars-container" data-target="#input-manufacturer-formula-description-lang<?= $language['language_id'] ?>">
                                      <div class="vars-item">
                                        <span class="var">[manufacturer_name]</span>
                                        <span class="var">[shop_name]</span>
                                        <span class="var">[config_telephone]</span>
                                      </div>
                                      <div class="vars-item custom-variables">
                                        <!-- <span class="var var_custom-variables">[custom]</span> -->
                                      </div>
                                    </div>
                                  </div>
																	<?php if (isset($errors['manufacturer_description'][$language['language_id']])) { ?>
                                  <div class="text-danger"><?=$errors['manufacturer_description'][$language['language_id']] ?></div>
																	<?php } ?>
																</div>
															</div>

															<!-- keyword -->
															<div class="form-group">
																<label class="col-sm-2 control-label" for="input-manufacturer-formula-keyword-lang<?=$language['language_id']?>"><?=$entry_manufacturer_keyword?>:</label>
																<div class="col-sm-10">
																	<input id="input-manufacturer-formula-keyword-lang<?=$language['language_id']?>" type="text"
																	name="seo_tags_generator_manufacturer_keyword[<?=$language['language_id']?>]" value="<?= isset($seo_tags_generator_manufacturer_keyword[$language['language_id']]) ? $seo_tags_generator_manufacturer_keyword[$language['language_id']] : ''; ?>" class="form-control" />
																	<div class="vars-main row">
                                    <div class="col-sm-2"><?= $text_available_vars ?>: </div>
                                    <div class="col-sm-10 vars-container" data-target="#input-manufacturer-formula-keyword-lang<?= $language['language_id'] ?>">
                                      <div class="vars-item">
                                        <span class="var">[manufacturer_name]</span>
                                        <span class="var">[shop_name]</span>
                                        <span class="var">[config_telephone]</span>
                                      </div>
                                      <div class="vars-item custom-variables">
                                        <!-- <span class="var var_custom-variables">[custom]</span> -->
                                      </div>
                                    </div>
                                  </div>
																	<?php if (isset($errors['manufacturer_keyword'][$language['language_id']])) { ?>
                                  <div class="text-danger"><?=$errors['manufacturer_keyword'][$language['language_id']] ?></div>
																	<?php } ?>
																</div>
															</div>
														</div><!-- /col-sm-12 -->
													</div><!-- /row -->
													<!-- /manufacturer.end -->

												</div>
												<!-- /language pane.end-->
											<?php } ?>
										</div>
										<!-- tab-content languages.end-->
									</div>
									<!-- /language -->
								</div><!-- /col-sm-12-->
							</div><!-- /formula-row-->
						</fieldset>
					</div><!-- /module-work-area-->
        </form>
      </div><!-- /panel-body-->
      <!-- /Customization.End -->


    </div><!-- /panel-default-->

    <div class="copywrite" style="padding: 10px 10px 0 10px; border: 1px dashed #ccc;">
    	<p>
    		&copy; <?=$text_author?>: <a href="http://web-jump.in.ua/link/272" target="_blank">Serge Tkach</a>
    		<br/>
				<?=$text_author_support?>: <a href="mailto:sergheitkach@gmail.com">sergheitkach@gmail.com</a>
    	</p>
    </div>

  </div><!-- /container-fluid-->
</div><!-- /content-->


<!-- js.begin-->
<script type="text/javascript">
	$('#language a:first').tab('show');

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


  /* licence tmp
  --------------------------------------------------------------------------- */
	$('#get-temp-licence').on('click', function(e){
		e.preventDefault();

		$('#alert-temp-licence').removeClass('alert-success alert-danger');
		$('#alert-temp-licence').empty();
		$('#get-temp-licence .load-bar').css('display', 'block');

		$.ajax({
			url: 'index.php?route=extension/module/seo_tags_generator/getTempLicence&token=<?php echo $token; ?>',
			dataType: 'json',
			type:"POST",
			//data:{'key': 'value'},
			success: function(json) {
				$("#alert-temp-licence").html(json.answer);
				$("#alert-temp-licence").addClass('alert ' + json.type);
				$('#get-temp-licence .load-bar').css('display', 'none');

				if ('alert-success' == json.type) {
					$("#alert-temp-licence").css('margin-bottom', '0');
					$('#temp-licence-button-container').empty();


					setTimeout(function () {
						$(location).attr('href','<?=HTTPS_SERVER?>index.php?route=extension/module/seo_tags_generator&token=<?=$token?>')
					}, 2000);

				} else {
					$("#alert-temp-licence").css('margin-bottom', '17px');
				}
			}
		});
	});

</script>
<!-- /js.end -->
<?php echo $footer; ?>