<?php
/*
  Name: Specification
 */
use ContentEgg\application\helpers\TemplateHelper;  
?>

<?php foreach ($items as $item): ?>

    <?php if(!empty($item['extra']['specificationList'])):?>
        <div class="wpsm-table wpsm-icecat-spec">
            <table>
                <?php foreach($item['extra']['specificationList'] as $specarray): ?>
                    <?php if(!empty($specarray['values']) && !empty($specarray['key']) && $specarray['key'] !='Important Note'):?>
                        <tr class="heading-th-spec-line">
                            <th colspan="2"></th>
                        </tr>            
                        <tr class="heading-th-spec">
                            <th colspan="2"><?php echo $specarray['key'];?></th>
                        </tr>
                        <?php $i = 0; foreach($specarray['values'] as $id=>$f): ?>
                        <?php $i++; $odd = ($i % 2 == 1) ? ' class="odd"' : '';?>
                            <tr<?php echo $odd;?>>
                                <?php if (!empty($f['key'])):?>
                                    <td class="icecat-spec-val"><?php echo $f['key'];?></td>
                                    <td>
                                        <?php foreach ($f['value'] as $key => $value) :?>
                                            <?php echo $value;?>
                                        <?php endforeach;?>
                                    </td>
                                <?php else:?>
                                	<?php if(!empty($f['value']) && is_array($f['value'])):?>
                                		<td colspan="2">
		                                    <?php foreach ($f['value'] as $key => $value) :?>
		                                        <?php echo $value;?>                                       
		                                    <?php endforeach;?>
	                                    </td>
                                    <?php endif;?>                                    
                                <?php endif;?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif;?>
                <?php endforeach; ?>
            </table> 
        </div>
    <?php endif;?>
<?php endforeach; ?>                 