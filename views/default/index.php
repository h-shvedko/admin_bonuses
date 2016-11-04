<script>
$(document).ready(function(){
	
	$("#recount").submit(function() {
	  var start = Date.parse($('#start').val());
	  var end = Date.parse($('#end').val());
		
	   if(isNaN(start) || isNaN(end))
	   {
		   $("span.error").text("Дата не может быть пустой").show();
			return false;
	   }
	  if( start > end)
	  {
		$("span.error").text("Дата начала не может быть меньше даты конца расчетного периода").show();
		return false;
	  }
	});

	$("#recountbinar").submit(function() {
	  var start = new Date(Date.parse($('#startbinar').val()));
	  var end = new Date (Date.parse($('#endbinar').val()));
		
	   if(isNaN(start) || isNaN(end))
	   {
		   $("span.errorbinar").text("Дата не может быть пустой").show();
			return false;
	   }
	  if( start > end)
	  {
		$("span.errorbinar").text("Дата начала не может быть меньше даты конца расчетного периода").show();
		return false;
	  }
	});
})
</script>
<?= CHtml::hiddenField('asseturl', Yii::app()->assetManager->getPublishedUrl(Yii::getPathOfAlias('admin.modules.user.css')), array('id' => 'asseturl')) ?>
<div>
<h3><?= Yii::t('app', 'Таблица с расчетными периодами по бинару'); ?></h3>
<table style="width: 50%;">
    <tr>
        <th><?= Yii::t('app', '№пп'); ?></th>
        <th><?= Yii::t('app', 'Дата начала расчетного периода'); ?></th>
        <th><?= Yii::t('app', 'Дата окончания расчетного периода'); ?></th>
        <th><?= Yii::t('app', 'История начисления бонусов'); ?></th>
    </tr>
    <? $i = 1;?>
    <? foreach($periodeBinar as $period) : ?>
       
    <tr style="text-align: center;">
        <td><?= CHtml::encode($i) ?></td>
        <? $dateStart = date_create($period->date_begin); ?>
		<input type="hidden" class="startdatebinar" value="<?= app_date("Y/m/d", strtotime($period->date_begin)); ?>" />
        <td><?= CHtml::encode(date_format($dateStart, "d.m.Y")) ?></td>
        <? if (!empty($period->date_end)) : ?>
        <? $dateEnd = date_create($period->date_end); ?>
        <td><?= CHtml::encode(date_format($dateEnd, "d.m.Y")) ?></td>
        <td><?php echo CHtml::link('Просмотреть', '/admin/bonuses/binar/history/guid/'.sha1($period['id'])); ?></td>
        <? else : ?>
        <td></td>
        <td></td>
        <? endif; ?>
        <? $i++; ?>
    </tr> 
   <? $end = strtotime(app_date("Y", strtotime($period->date_begin))."-".app_date("m",strtotime($period->date_begin))."-".(app_date("d",strtotime($period->date_begin))+1)); ?>
   
   <? $start_binar = app_date("Y/m/d 00:00:00",strtotime($period->date_begin)); ?>
	

    <? endforeach; ?>
	<? if ((app_date("d", $end)+(7-app_date("N", $end))) > app_date("t", $end) ) : ?>  
		<? if ((app_date("m", $end)+1) <= 12) : ?>
			<? $end_binar = app_date("Y/m/d 23:59:59",  strtotime(app_date("Y", $end)."-".(app_date("m", $end)+1)."-".(app_date("d", $end)+(7-app_date("N", $end)) - app_date("t", $end)))); ?>
		<? else : ?>
			<? $end_binar = app_date("Y/m/d 23:59:59",  strtotime((app_date("Y", $end)+1)."-".(app_date("m", $end)+1 -12)."-".(app_date("d", $end)+(7-app_date("N", $end)) - app_date("t", $end)))); ?>
		<? endif; ?>
	<? else : ?>
		<? $end_binar = app_date("Y/m/d 23:59:59",   strtotime(app_date("Y", $end)."-".app_date("m", $end)."-".(app_date("d", $end)+(7-app_date("N", $end))))); ?>
	<? endif; ?>
</table>
<div>
    <div><h4><?= Yii::t('app', 'Расчет бонусов'); ?></h4><span style="display: none; color: red;" class="errorbinar"></span></div>
    <?= CHtml::beginForm('/admin/bonuses/binar/calculate', 'POST', array('style' => 'display: inline-block', 'id' => 'recountbinar')) ?>
    <div>
    <?= CHtml::textField('date_begin', $start_binar, array('readonly' => 'readonly', 'style' => 'width: 180px;', 'id' => 'startbinar')); ?>
    </div>
    <br>
    <div>
    <?= CHtml::textField('date_end', $end_binar, array('readonly' => 'readonly', 'style' => 'width: 180px;', 'id' => 'endbinar')); ?>
    </div>
    <br>
    <?=CHtml::button(Yii::t('app', 'Расчитать'), array(
        'submit' => array(
            'binar/calculate',
        ),
        'params' => array(
            Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
            'btn_clc' => 'guid',
        ),
        'confirm' => Yii::t('app', 'Подтвердить операцию? Отмена будет невозможна') . '.',
		'class' => 'btn100',
		'type' => 'submin',
    ))
    ?>
    <?= CHtml::endForm() ?>
</div>
</div>

<div>
<h3><?= Yii::t('app', ' Таблица с расчетными периодами по сетевой структуре'); ?></h3>
<table style="width: 50%;">
    <tr>
        <th><?= Yii::t('app', '№пп'); ?></th>
        <th><?= Yii::t('app', 'Дата начала расчетного периода'); ?></th>
        <th><?= Yii::t('app', 'Дата окончания расчетного периода'); ?></th>
        <th><?= Yii::t('app', 'История начисления бонусов'); ?></th>
    </tr>
    <? $i = 1;?>
	<? $cnt = count($periodeMLM);?>
    <? foreach($periodeMLM as $period) : ?>
    <tr style="text-align: center;">
        <td><?= CHtml::encode($i) ?></td>
		<input type="hidden" class="startdate" value="<?= app_date("Y/m/d", strtotime($period->date_begin)); ?>" />
        <td><?= CHtml::encode(app_date("d.m.Y", strtotime($period->date_begin))) ?></td>
        <? if (!empty($period->date_end)) : ?>
        <td><?= CHtml::encode(app_date("d.m.Y", strtotime($period->date_end))) ?></td>
        <td>
		<? if($period->paid == 1 || $period->paid == 2) : ?>
		<?php echo CHtml::link('Просмотреть', '/admin/bonuses/bonuses/history/guid/'.sha1($period['id'])); ?>
		<? endif;?>
		</td>

        <? else : ?>
        <td></td>
        <td></td>
        <? endif; ?>
        <? $i++; ?>
    </tr> 
	<? $start = app_date("Y/m/d 00:00:00",strtotime($period->date_begin)); ?>
    <? endforeach; ?>
	<? if ((app_date("m", strtotime($start))+1) == 13 ) : ?>
		<? $end = app_date("Y/m/d 23:59:59",  strtotime((app_date("Y", strtotime($start))+1). "-01-01")); ?>
	<? else : ?>
		<? $end = app_date("Y/m/d 23:59:59",  strtotime(app_date("Y", strtotime($start))."-".(app_date("m", strtotime($start))+1)."-". 1)); ?>
	<? endif; ?>
</table>
<div>
    <div><h4><?= Yii::t('app', 'Расчет бонусов'); ?></h4><span style="display: none; color: red;" class="error"></span></div>
    <?= CHtml::beginForm('/admin/bonuses/bonuses/calculate', 'POST', array('style' => 'display: inline-block', 'id' => 'recount')) ?>
    <div>
    <?= CHtml::textField('date_begin', $start, array('readonly' => 'readonly', 'style' => 'width: 180px;', 'id' => 'start')); ?>
    </div>
    <br>
    <div>
    <?= CHtml::textField('date_end', $end, array('readonly' => 'readonly', 'style' => 'width: 180px;', 'id' => 'end')); ?>
    </div>
    <br>
	<?=CHtml::button(Yii::t('app', 'Расчитать'), array(
        'submit' => array(
            'bonuses/calculate',
        ),
        'params' => array(
            Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
            'btn_clc' => 'guid',
        ),
        'confirm' => Yii::t('app', 'Подтвердить операцию? Отмена будет невозможна') . '.',
		'class' => 'btn100',
		'type' => 'submin',
    ))
    ?>
    <?= CHtml::endForm() ?>
</div>
</div>