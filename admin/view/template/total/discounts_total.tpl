<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-credit" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-info"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-credit" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="discounts_total_status">
              <?php echo $entry_status; ?>
            </label>
            <div class="col-sm-10">
              <select name="discounts_total_status" class="form-control">
                <?php if ($discounts_total_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="discounts_total_sort_order">
                <?php echo $entry_sort_order; ?>
            </label>
            <div class="col-sm-10">
                <input class="form-control" type="text" name="discounts_total_sort_order" value="<?php echo $discounts_total_sort_order; ?>" size="1" />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label" for="discounts_total_order_status_id">
              <?php echo $entry_order_status; ?>
            </label>
            <div class="col-sm-10">
            <select name="discounts_total_order_status_id" class="form-control">
              <?php foreach ($order_statuses as $order_statuses) { ?>
              <?php if ($order_statuses['order_status_id'] == $discounts_total_order_status_id) { ?>
              <option value="<?php echo $order_statuses['order_status_id']; ?>" selected="selected"><?php echo $order_statuses['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_statuses['order_status_id']; ?>"><?php echo $order_statuses['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
            </div>
          </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="discounts_total_last_days">
                    <?php echo $entry_last_days; ?>
                </label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" name="discounts_total_last_days" value="<?php echo $discounts_total_last_days; ?>"  />
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-2 control-label" for="discounts_total_calc_type_id">
                    <?php echo $entry_calc_type; ?>
                </label>
                <div class="col-sm-10">
                    <select name="discounts_total_calc_type_id" class="form-control">
                        <?php foreach ($calc_types as $i=>$ct) { ?>
                        <?php if ($i == $discounts_total_calc_type_id) { ?>
                        <option value="<?php echo $i; ?>" selected="selected"><?php echo $ct; ?></option>
                        <?php } else { ?>
                        <option value="<?php echo $i; ?>"><?php echo $ct; ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">
                    <?php echo $entry_discounts_table; ?>
                </label>
                <div class="col-sm-10">
                    <table id='discounts_total_discounts_table_list'>
                        <?php foreach ($discounts_table as $key => $value) { ?>
                        <tr class="discounts_total_discounts_table_row" id="discounts_total_discounts_table_row_<?php echo $key; ?>">
                            <td><?php echo $entry_discounts_from; ?><br /><input class="discounts_total_discounts_table" type="text" name="discounts_total_discounts_table[<?php echo $key; ?>][summ]" value="<?php echo $value['summ']; ?>" /></td>
                            <td><?php echo $entry_discounts_discount; ?><br /><input type="text" name="discounts_total_discounts_table[<?php echo $key; ?>][value]" value="<?php echo $value['value']; ?>" /></td>
                            <td>&nbsp;<br /><a class="btn btn-info discounts_total_discounts_table_del"><span><?php echo $entry_discounts_delete; ?></span></a></td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
                <div style='text-align: left'>
                    <a class="btn btn-info" href="#" id='discounts_total_discounts_table_insert'><?php echo $entry_discounts_add; ?></a>
                </div>
            </div>
        </form>
          <div class="note">
              <?php echo $note; ?>
          </div>

      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>




<script type="text/javascript"><!--
  $(document).ready(function() {
    $('#discounts_total_discounts_table_insert').click(function() {
      var list = $(this).attr('id').replace('insert', 'list');
      var name = $(this).attr('id').replace('_insert', '');
      var row_id = $('.' + name).toArray().length;

      var html = '<tr class="' + name + '_row" id="' + name + '_row_' + row_id + '"><td><?php echo $entry_discounts_from; ?><br /><input class="' + name + '" type="text" name="' + name + '[' + row_id + '][summ]" /></td><td><?php echo $entry_discounts_discount; ?><br /><input type="text" name="' + name + '[' + row_id + '][value]" /></td><td>&nbsp;<br /><a class="btn btn-info ' + name + '_del"><span><?php echo $entry_discounts_delete; ?></span></a></td></tr>';
      $('#' + list).append(html);

      return false;
    })

    $('.discounts_total_discounts_table_del').click(function() {
      $(this).parent().parent().remove();
    });

  })
  //--></script>


<?php echo $footer; ?>