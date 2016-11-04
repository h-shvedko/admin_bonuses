<h3>
	<span class="wrapper-3"><?=Yii::t('app', 'Фильтр')?></span>
</h3>
<?=CHtml::beginForm()?>
	<table class="list" style="text-align: left; width: 500px;">
		<tbody>
			<tr>
				<td><?=Yii::t('app', 'Логин'); ?></td>
				<td><?=Chtml::textField('filter[username]', array_key_exists('username', $filter) ? $filter['username'] : '');?></td>
			</tr>
            <tr>
				<td><?=Yii::t('app', 'Номер телефона'); ?></td>
				<td><?=Chtml::textField('filter[phone]', array_key_exists('phone', $filter) ? $filter['phone'] : '');?></td>
			</tr>
            <tr>
				<td><?=Yii::t('app', 'Название бонуса'); ?></td>
				<td><?=CHtml::listBox('filter[bonuses_name]', array_key_exists('bonuses_name', $filter) ? $filter['bonuses_name'] : '', UsersBonuses::getBonusesNameForListBox(), array('size' => (int)TRUE, 'empty' => Yii::t('app', 'Выберите бонус')));?></td>
			</tr>
                        <tr>
				<td><?=Yii::t('app', 'Сумма, от которой рассчитывается бонус'); ?></td>
				<td><?=Chtml::textField('filter[amount]', array_key_exists('amount', $filter) ? $filter['amount'] : '');?></td>
			</tr>
                        <tr>
				<td><?=Yii::t('app', 'Сумма бонуса'); ?></td>
				<td><?=Chtml::textField('filter[points]', array_key_exists('points', $filter) ? $filter['points'] : '');?></td>
			</tr>
			<tr>
				<td><?=Chtml::hiddenField('location', $url);?>
					<a href="javascript: void(0)" onClick="location.href='<?=$url?>'"><?=Yii::t('app', 'Сбросить фильтр')?></a>
				</td>
				<td><?=Chtml::button(Yii::t('app', 'Найти'), array('name' => 'btn_filter', 'class' => 'btn100'));?></td>
			</tr>                
		</tbody>            
	</table>
<?=CHtml::endForm()?>