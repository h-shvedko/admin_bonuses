<?= CHtml::hiddenField('asseturl', Yii::app()->assetManager->getPublishedUrl(Yii::getPathOfAlias('admin.modules.user.css')), array('id' => 'asseturl')) ?>
<br /><br />
<h1><?= date("d.m.Y", strtotime($periode->date_begin))?> - <?= date("d.m.Y", strtotime($periode->date_end))?></h1>
<?=
$this->renderPartial('_filter', array(
    'binarFilter' => $binarFilter,
    'user' => $user,
    'profile' => $profile,
    'profileLang' => $profileLang,
    'url' => '/admin/bonuses/binar/index'))
?>		

<br /><br />	

<div class="static">
    <h4><?= Yii::t('app', ' Блок со статистической информацией за текущий расчетный период по Бинару'); ?></h4>
    <div>
        <?= Yii::t('app', 'Общее количество выплат'); ?> : <?= $countBinar; ?>
    </div><br>
    <div>
        <?= Yii::t('app', 'Общая сумма выплат по бинару'); ?> : <?= $sumBinar; ?>
    </div>
</div>
<br>
<? if (!empty($periode)) : ?>
<table style="text-align: center;">
    <tr>
        <th><?= Yii::t('app', 'Идентификатор бонуса'); ?></th>
        <th><?= Yii::t('app', 'Логин пользователя') ?></th>
        <th><?= Yii::t('app', 'ФИО') ?></th>
        <th><?= Yii::t('app', 'Название бонуса') ?></th>
        <th><?= Yii::t('app', 'Баллы') ?></th>
        <th><?= Yii::t('app', 'Сумма бонуса') ?></th>
    </tr>
    <? $i=1; ?>
    <? foreach($periode->binar as $bonus) : ?>
    <? if (!empty($bonus)) : ?>
    <? if ($bonus->userbonuses->alias == ProfileBonuses::PRIVATE_INVITED_ALIAS) : ?>
    <tr>
        <td><?= $i; ?></td>
        <td><?= CHtml::encode($bonus->user->username); ?></td>        
        <td><?= CHtml::encode($bonus->user->profile->lang->first_name); ?> <?= CHtml::encode($bonus->user->profile->lang->second_name); ?> <?= CHtml::encode($bonus->user->profile->lang->last_name); ?></td>
        <td><?= Yii::t('app', 'Бонус за личное приглашение'); ?></td>
        <td><?= CHtml::encode($bonus->transactions->amount); ?></td>
        <td><?= CHtml::encode($bonus->amount); ?></td>
    </tr>
    <? else : ?>
    <tr>
        <td><?= $i; ?></td>
        <td><?= CHtml::encode($bonus->user->username); ?></td>
        <td><?= CHtml::encode($bonus->user->profile->lang->first_name); ?> <?= CHtml::encode($bonus->user->profile->lang->second_name); ?> <?= CHtml::encode($bonus->user->profile->lang->last_name); ?></td>
        <td><?= Yii::t('app', 'Структурный бонус'); ?></td>
        <td><?= CHtml::encode($bonus->transactions->amount); ?></td>
        <td><?= CHtml::encode($bonus->amount); ?></td>
    </tr>
    <? endif; ?>
    <? endif; ?>
    <? $i++; ?>
    <? endforeach; ?>
</table>
<div>
    <a class="btn200" href="javascript:void(0)" onClick="window.location = '<?= $this->createUrl('/admin/bonuses/default/index') ?>'"><?= Yii::t('app', 'Назад') ?></a>
</div>
<? else : ?>
<h2>Пусто</h2>
<? endif; ?>
<br /><br />
<? $this->widget('CLinkPager', array('pages' => $pages))?>

<div>
    <h4><?= Yii::t('app', 'Расчет бонусов'); ?></h4>
    <?= CHtml::beginForm('/admin/bonuses/binar/calculate', 'POST', array('style' => 'display: inline-block')) ?>
    <div>
    <?= CHtml::activeTextField($periode, 'date_begin', array('class' => 'forminput datepicker', 'readonly' => 'readonly', 'style' => 'width: 180px;')); ?>
    </div>
    <br>
     <div>
    <?= CHtml::hiddenField('guid', $guid); ?>
    </div>
    <div>
    <?= CHtml::activeTextField($periode, 'date_end', array('class' => 'forminput datepicker', 'readonly' => 'readonly', 'style' => 'width: 180px;')); ?>
    </div>
    <br>
    <?= CHtml::submitButton(Yii::t('app', 'Расчитать'), array('class' => 'btn200', 'name' => 'btn_clc')) ?>
    <?= CHtml::endForm() ?>
</div>