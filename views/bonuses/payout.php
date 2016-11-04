<style>
#yt1, #yt0
{
	width :auto;
}
</style>
<? if(isset($guid) && isset($pass) && isset($user)) : ?>
<div>
    <h4><?= Yii::t('app', 'Введите пароль администратора'); ?></h4>
	<?= CHtml::beginForm('/admin/bonuses/bonuses/payout/guid/'.$guid, 'POST', array('style' => 'display: inline-block', 'id' => 'confirmpaid')) ?>
    <div>
    <?= CHtml::passwordField('pass', ''); ?>
	</div>
    <br>
    <div class="btn200">
    <?=CHtml::submitButton('Провести выплаты', array('name' => 'btn_pay', 'class' => 'btn200'));?>
</div>
	
    <?php echo CHtml::link('Отмена', '/admin/bonuses/', array('class' => 'btn200')); ?>
    <?= CHtml::endForm() ?>
</div>
<? elseif (Yii::app()->user->hasFlash('error')) : ?>
<div>
    <h4><?= Yii::t('app', 'Введите пароль администратора'); ?></h4>
    <?= CHtml::beginForm('/admin/bonuses/bonuses/payout/guid/'.$guid, 'POST', array('style' => 'display: inline-block', 'id' => 'confirmpaid')) ?>
    <div>
    <?= CHtml::passwordField('pass', ''); ?>
	</div>
    <br>
    <div class="btn200">
    <?=CHtml::submitButton('Провести выплаты', array('name' => 'btn_pay', 'class' => 'btn200'));?>
</div>

    <?php echo CHtml::link('Отмена', '/admin/bonuses/', array('class' => 'btn200')); ?>
    <?= CHtml::endForm() ?>
</div>
<? else : ?>
<h1><?= date("d.m.Y", strtotime($periode->date_begin))?> - <?= date("d.m.Y", strtotime($periode->date_end))?></h1>
<?= CHtml::hiddenField('asseturl', Yii::app()->assetManager->getPublishedUrl(Yii::getPathOfAlias('admin.modules.user.css')), array('id' => 'asseturl')) ?>
<br /><br />
<?=
$this->renderPartial('_filter', array(
    'binarFilter' => $binarFilter,
    'user' => $user,
    'profile' => $profile,
    'profileLang' => $profileLang,
    'url' => '/admin/bonuses/bonuses/payout/guid/'.$guid))
?>		

<br /><br />	

<div class="static">
    <div>
        <?= Yii::t('app', 'Общее количество выплат'); ?> : <?= $countAll; ?>
    </div>
    <br>
    <div>
        <?= Yii::t('app', 'Общая сумма всех выплат'); ?> : <?= $sumAll; ?>
    </div>
    <br>
    <div>
        <?= Yii::t('app', 'Сумма выплат линейных бонусов'); ?> : <?= $sumLinear; ?>
    </div><br>
    <div>
        <?= Yii::t('app', 'Сумма выплат ступенчатых бонусов'); ?> : <?= $sumStair; ?>
    </div><br>
    <div>
        <?= Yii::t('app', 'Сумма выплат директорских бонусов'); ?> : <?= $sumDirector; ?>
    </div><br>
    <div>
        <?= Yii::t('app', 'Сумма выплат автомобильных бонусов'); ?> : <?= $sumAuto; ?>
    </div><br>
    <div>
        <?= Yii::t('app', 'Сумма выплат жилищных бонусов'); ?> : <?= $sumHouse; ?>
    </div><br>
    <div>
        <?= Yii::t('app', 'Сумма выплат лидерских бонусов'); ?> : <?= $sumLeader; ?><br><br>
		<? if ($sumLeader > (int)FALSE) : ?>
		<a href="<?= $this->createUrl('/admin/invoice/turnover/summation/id/'.$report[0]->periode__id) ?>">Отчет по товарообороту складов</a>
		<? endif;?>
    </div><br>
</div>
<br>
<? if (!empty($report)) : ?>
<table style="text-align: center;">
    <tr>
        <th><?= Yii::t('app', 'Идентификатор бонуса'); ?></th>
        <th><?= Yii::t('app', 'Номер телефона'); ?></th>
		<th><?= Yii::t('app', 'Логин пользователя') ?></th>
        <th><?= Yii::t('app', 'ФИО') ?></th>
        <th><?= Yii::t('app', 'Название бонуса') ?></th>
        <th><?= Yii::t('app', 'Баллы') ?></th>
        <th><?= Yii::t('app', 'Сумма бонуса в руб') ?></th>
    </tr>
    <? $i= ($pages->currentPage)*30; ?>
	<? $sumAllval = (int)FALSE;?>
    <? foreach($report as $bonus) : ?>
	<? $i++; ?>
    <? if (!empty($bonus)) : ?>
    <tr>
        <td><?= $i; ?></td>
		<td><?= CHtml::encode($bonus->user->profile->phone); ?></td>
        <td><?= CHtml::encode($bonus->user->username); ?></td>
        <td><?= CHtml::encode($bonus->user->profile->lang->first_name); ?> <?= CHtml::encode($bonus->user->profile->lang->second_name); ?> <?= CHtml::encode($bonus->user->profile->lang->last_name); ?></td>
       <? if ($bonus->users_bonuses->alias == 'linear') : ?> 
		<td><?= CHtml::encode($bonus->users_bonuses->lang->bonuses_name); ?> ( c <?= CHtml::encode($bonus->level); ?> линии)</td>
		<? elseif($bonus->users_bonuses->alias == 'director') :  ?>
		<td><?= CHtml::encode($bonus->users_bonuses->lang->bonuses_name); ?> ( c <?= CHtml::encode($bonus->level); ?> линии)</td>
		<? else : ?>
		<td><?= CHtml::encode($bonus->users_bonuses->lang->bonuses_name); ?></td>
		<? endif; ?>

        <td><?= CHtml::encode($bonus->amount); ?></td>
		<td>
		<? if ($bonus->users_bonuses->alias == 'linear' || $bonus->users_bonuses->alias == 'director' || $bonus->users_bonuses->alias == 'stair' || $bonus->users_bonuses->alias == 'infinity') : ?>
        <?= CHtml::encode(round($bonus->amount*100)); ?>
		<? $sumAllval += round($bonus->amount*100)?>
		<? else : ?>
		<?= CHtml::encode($bonus->amount); ?>
		<? $sumAllval += $bonus->amount?>
		<? endif; ?>
		</td>
		
    </tr>
    <? endif; ?>
    <? endforeach; ?>

</table>
<div class="btn200">
    <?=CHtml::linkButton(Yii::t('app', 'Провести выплаты'), array(
        'submit' => array(
            'payout',
            'guid' => $guid,
        ),
        'params' => array(
            Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
            'btn_pass' => 'guid',
        ),
        //'confirm' => Yii::t('app', 'Подтвердить операцию? Отмена будет невозможна') . '.',
		'class' => 'btn200'
    ))?>
</div>
<div>
    <a class="btn200" href="javascript:void(0)" onClick="window.location = '<?= $this->createUrl('/admin/bonuses/default/index') ?>'"><?= Yii::t('app', 'Назад') ?></a>
</div>
<? else : ?>
<h2>Пусто</h2>
<a class="btn200" href="javascript:void(0)" onClick="window.location = '<?= $this->createUrl('/admin/bonuses/default/index') ?>'"><?= Yii::t('app', 'Назад') ?></a>
<? endif; ?><br /><br />
<? $this->widget('CLinkPager', array('pages' => $pages))?>


<? endif; ?>