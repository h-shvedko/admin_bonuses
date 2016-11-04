<style>
#yt1, #yt0
{
	width :auto;
}
</style>
<?= CHtml::hiddenField('asseturl', Yii::app()->assetManager->getPublishedUrl(Yii::getPathOfAlias('admin.modules.user.css')), array('id' => 'asseturl')) ?>
<br /><br />
<h1><?= date("d.m.Y", strtotime($periode->date_begin))?> - <?= date("d.m.Y", strtotime($periode->date_end))?></h1>
<?=
$this->renderPartial('_filter', array(
    'binarFilter' => $binarFilter,
    'user' => $user,
    'profile' => $profile,
    'profileLang' => $profileLang,
    'url' => '/admin/bonuses/binar/history/guid/'.$guid))
?>		

<br /><br />	

<div class="static">
    <div>
        <?= Yii::t('app', 'Общее количество выплат'); ?> : <?= $page; ?>
    </div><br>
    <div>
        <?= Yii::t('app', 'Общая сумма выплат по бинару'); ?> : <?= $sumBinar; ?>
    </div>
	 <div>
        <?= Yii::t('app', 'Общее кол-во шагов по бинару'); ?> : <?= $stepBinar; ?>
    </div>
</div>
<br>
<? if (!empty($binarAll)) : ?>
<table style="text-align: center;">
    <tr>
        <th><?= Yii::t('app', 'Идентификатор бонуса'); ?></th>
		<th><?= Yii::t('app', 'Номер телефона') ?></th>
        <th><?= Yii::t('app', 'Логин пользователя') ?></th>
        <th><?= Yii::t('app', 'ФИО') ?></th>
        <th><?= Yii::t('app', 'Название бонуса') ?></th>
        <th><?= Yii::t('app', 'Баллы') ?></th>
        <th><?= Yii::t('app', 'Сумма бонуса') ?></th>
		<th><?= Yii::t('app', 'Кол-во шагов') ?></th>
    </tr>
    <? $i= ($pages->currentPage)*30; ?>
    <? foreach($binarAll as $bonus) : ?>
	<? $i++; ?>
    <? if ($bonus->users_bonuses->alias == ProfileBonuses::PRIVATE_INVITED_ALIAS) : ?>
    <tr>
        <td><?= $i; ?></td>
		<td><?= CHtml::encode($bonus->user->profile->phone); ?></td>
        <td><?= CHtml::encode($bonus->user->username); ?></td>
        <td><?= CHtml::encode($bonus->user->profile->lang->first_name); ?> <?= CHtml::encode($bonus->user->profile->lang->second_name); ?> <?= CHtml::encode($bonus->user->profile->lang->last_name); ?></td>
        <td><?= Yii::t('app', 'Бонус за личное приглашение'); ?></td>
        <td><?= CHtml::encode($bonus->transactions->amount); ?></td>
        <td colspan="2"><?= CHtml::encode($bonus->amount); ?></td>
    </tr>
    <? else : ?>
    <tr>
        <td><?= $i; ?></td>
		<td><?= CHtml::encode($bonus->user->profile->phone); ?></td>
        <td><?= CHtml::encode($bonus->user->username); ?></td>
        <td><?= CHtml::encode($bonus->user->profile->lang->first_name); ?> <?= CHtml::encode($bonus->user->profile->lang->second_name); ?> <?= CHtml::encode($bonus->user->profile->lang->last_name); ?></td>
        <td><?= Yii::t('app', 'Структурный бонус'); ?></td>
        <td><?= CHtml::encode($bonus->transactions->amount); ?></td>
        <td><?= CHtml::encode($bonus->amount); ?></td>
		<td><?= CHtml::encode($bonus->step); ?></td>
    </tr>
    <? endif; ?>
       
    <? endforeach; ?>
</table>
<? if ($periode->paid != (int) TRUE) : ?>
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
      //  'confirm' => Yii::t('app', 'Подтвердить операцию? Отмена будет невозможна') . '.',
		'class' => 'btn200'
    ))?>
</div>
<? endif; ?>
<div>
    <a class="btn200" href="javascript:void(0)" onClick="window.location = '<?= $this->createUrl('/admin/bonuses/default/index') ?>'"><?= Yii::t('app', 'Назад') ?></a>
</div>
<? else : ?>
<h2>Пусто</h2>
<div>
    <a class="btn200" href="javascript:void(0)" onClick="window.location = '<?= $this->createUrl('/admin/bonuses/default/index') ?>'"><?= Yii::t('app', 'Назад') ?></a>
</div>
<? endif; ?>
<br /><br />
<? $this->widget('CLinkPager', array('pages' => $pages))?>
