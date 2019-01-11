<!--<h2><?php echo $text_instruction; ?></h2> -->
<!--<p><b><?php echo $text_description; ?></b></p> -->
<div class="well well-sm">
  <!--<p><?php echo $bank; ?></p>-->
  <p style="padding-top:0px">Спасибо за заказ! В ближайшее время на ваш e-mail, мы вышлем фото каждого растения. А после подтверждения покупки – предоставим реквизиты для оплаты.</p>
  <p>Обратите, пожалуйста, внимание, что мы не делаем фото <a href=' https://orchidsworld.com.ua/podrostki-orchidey' target='_blank'>подростков орхидей</a>. Поэтому ожидайте от нас фото или сразу счет.</p>
  <p>Спасибо, что вы с нами!</p>

</div>
<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn btn-primary" data-loading-text="<?php echo $text_loading; ?>" />
  </div>
</div>
<script type="text/javascript"><!--
$('#button-confirm').on('click', function() {
	$.ajax({
		type: 'get',
		url: 'index.php?route=extension/payment/bank_transfer/confirm',
		cache: false,
		beforeSend: function() {
			$('#button-confirm').button('loading');
		},
		complete: function() {
			$('#button-confirm').button('reset');
		},
		success: function() {
			location = '<?php echo $continue; ?>';
		}
	});
});
//--></script>
