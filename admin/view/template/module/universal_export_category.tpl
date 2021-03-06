  <div class="row">
    <div class="col-sm-4">
      <div class="form-group">
        <label class="control-label"><?php echo $_language->get('filter_language'); ?></label>
        <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-flag"></i></span>
        <select class="form-control" name="filter_language">
          <option value=""><?php echo $_language->get('export_all'); ?></option>
          <?php foreach ($languages as $language) { ?>
            <option value="<?php echo $language['language_id']; ?>"><?php echo $language['name']; ?></option>
          <?php } ?>
        </select>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
        <label class="control-label"><?php echo $_language->get('filter_store'); ?></label>
        <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-home"></i></span>
        <select class="form-control" name="filter_store">
          <?php foreach ($stores as $store) { ?>
            <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
          <?php } ?>
        </select>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
        <label class="control-label"><span data-toggle="tooltip" title="<?php echo $_language->get('filter_limit_i'); ?>"><?php echo $_language->get('filter_limit'); ?></span></label>
        <div class="input-group">
        <input type="text" class="form-control" name="filter-start" placeholder="<?php echo $_language->get('filter_limit_start'); ?>" />
        <span class="input-group-addon">-</span>
        <input type="text" class="form-control" name="filter-limit" placeholder="<?php echo $_language->get('filter_limit_limit'); ?>"/>
        </div>
      </div>
    </div>
  </div>
   <hr />
   <!--
  <div class="row">
    <div class="col-sm-4">
      <div class="form-group">
        <label class="control-label"><span data-toggle="tooltip" title="<?php echo $_language->get('filter_limit_i'); ?>"><?php echo $_language->get('filter_limit'); ?></span></label>
        <div class="input-group">
        <input type="text" class="form-control" name="filter-start" placeholder="<?php echo $_language->get('filter_limit_start'); ?>" />
        <span class="input-group-addon">-</span>
        <input type="text" class="form-control" name="filter-limit" placeholder="<?php echo $_language->get('filter_limit_limit'); ?>"/>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
        <label class="control-label"><span data-toggle="tooltip" title="<?php echo $_language->get('entry_export_type_i'); ?>"><?php echo $_language->get('entry_export_type'); ?></span></label>
        <input type="text" class="form-control" />
      </div>
    </div>
  </div>
  <hr />
  -->

  
<div class="spacer"></div>