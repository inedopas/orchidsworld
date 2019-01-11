<div class="box sf-attribute sf-attribute-<?php echo $attribute['attribute_id']; ?> sf-<?php echo $attribute['type']; ?> <?php echo $is_collapsed ? 'is-collapsed' : ''; ?>" data-id="attribute-<?php echo $attribute['attribute_id']; ?>">
    <div class="box-heading"><?php echo $attribute['attribute_name']; ?></div>
    <div class="box-content">
        <ul class="<?php echo $this->journal2->settings->get('filter_show_box') ? '' : 'hide-checkbox'; ?>">
            <?php $z=0; asort($attribute['values']); foreach ($attribute['values'] as $value) {
              if($attribute['attribute_id']==24){   if( $z===0){$z++;
              $cn=(count($attribute['values']));
              for($j=0; $j<$cn;$j++)
                for($i=0;$i<$cn-1;$i++){
                  while((float)$attribute['values'][$i]['text'] > (float)$attribute['values'][$i+1]['text']){
                    list($attribute['values'][$i], $attribute['values'][$i+1]) = array($attribute['values'][$i+1], $attribute['values'][$i]);
                  }       }
                foreach ($attribute['values'] as $value) {
                  ?>
                <li><label><input data-keyword="<?php echo $value['keyword']?>" type="checkbox" name="attribute[<?php echo $attribute['attribute_id']?>]" value="<?php echo $value['text']; ?>"><?php echo $value['name']; ?></label></li>
            <?php } ?>
<?php }} else{
 ?>            <li><label><input data-keyword="<?php echo $value['keyword']?>" type="checkbox" name="attribute[<?php echo $attribute['attribute_id']?>]" value="<?php echo $value['text']; ?>"><?php echo $value['name']; ?></label></li>
          <?php }} ?>
        </ul>
    </div>
</div>
