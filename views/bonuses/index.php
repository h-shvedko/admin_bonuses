<?= CHtml::hiddenField('asseturl', Yii::app()->assetManager->getPublishedUrl(Yii::getPathOfAlias('admin.modules.user.css')), array('id' => 'asseturl')) ?>
<br /><br />
<h1><?= date("d.m.Y", strtotime($periode->date_begin))?> - <?= date("d.m.Y", strtotime($periode->date_end))?></h1>
<?=
$this->renderPartial('_filter', array(
    'binarFilter' => $binarFilter,
    'user' => $user,
    'profile' => $profile,
    'profileLang' => $profileLang,
    'url' => '/admin/bonuses/bonuses/index'))
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
        <?= Yii::t('app', 'Сумма выплат лидерских бонусов'); ?> : <?= $sumLeader; ?>
    </div><br>
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
    <? foreach($periode->linear as $bonus) : ?>
    <? if (!empty($bonus)) : ?>
    <tr>
        <td><?= $i; ?></td>
        <td><?= CHtml::encode($bonus->user->username); ?></td>
        <td><?= CHtml::encode($bonus->user->profile->lang->first_name); ?> <?= CHtml::encode($bonus->user->profile->lang->second_name); ?> <?= CHtml::encode($bonus->user->profile->lang->last_name); ?></td>
        <td><?= Yii::t('app', 'Линейный бонус'); ?></td>
        <td><?= CHtml::encode($bonus->transactions->amount); ?></td>
        <td><?= CHtml::encode($bonus->amount); ?></td>
    </tr><? $i++; ?>
    <? endif; ?>
    <? endforeach; ?>

    <? foreach($periode->leader as $bonus) : ?>
    <? if (!empty($bonus)) : ?>
    <tr>
        <td><?= $i; ?></td>
        <td><?= CHtml::encode($bonus->user->username); ?></td>
        <td><?= CHtml::encode($bonus->user->profile->lang->first_name); ?> <?= CHtml::encode($bonus->user->profile->lang->second_name); ?> <?= CHtml::encode($bonus->user->profile->lang->last_name); ?></td>
        <td><?= Yii::t('app', 'Лидерский бонус'); ?></td>
        <td><?= CHtml::encode($bonus->transactions->amount); ?></td>
        <td><?= CHtml::encode($bonus->amount); ?></td>
    </tr><? $i++; ?>
    <? endif; ?>
    <? endforeach; ?>

    <? foreach($periode->stair as $bonus) : ?>
    <? if (!empty($bonus)) : ?>
    <tr>
        <td><?= $i; ?></td>
        <td><?= CHtml::encode($bonus->user->username); ?></td>
        <td><?= CHtml::encode($bonus->user->profile->lang->first_name); ?> <?= CHtml::encode($bonus->user->profile->lang->second_name); ?> <?= CHtml::encode($bonus->user->profile->lang->last_name); ?></td>
        <td><?= Yii::t('app', 'Ступенчатый бонус'); ?></td>
        <td><?= CHtml::encode($bonus->transactions->amount); ?></td>
        <td><?= CHtml::encode($bonus->amount); ?></td>
    </tr><? $i++; ?>
    <? endif; ?>
    <? endforeach; ?>

    <? foreach($periode->instant as $bonus) : ?>
    <? if (!empty($bonus)) : ?>
    <tr>
        <td><?= $i; ?></td>
        <td><?= CHtml::encode($bonus->user->username); ?></td>
        <td><?= CHtml::encode($bonus->user->profile->lang->first_name); ?> <?= CHtml::encode($bonus->user->profile->lang->second_name); ?> <?= CHtml::encode($bonus->user->profile->lang->last_name); ?></td>
        <td><?= Yii::t('app', 'Мгновенный бонус'); ?></td>
        <td><?= CHtml::encode($bonus->transactions->amount); ?></td>
        <td><?= CHtml::encode($bonus->amount); ?></td>
    </tr><? $i++; ?>
    <? endif; ?>
    <? endforeach; ?>

    <? foreach($periode->house as $bonus) : ?>
    <? if (!empty($bonus)) : ?>
    <tr>
        <td><?= $i; ?></td>
        <td><?= CHtml::encode($bonus->user->username); ?></td>
        <td><?= CHtml::encode($bonus->user->profile->lang->first_name); ?> <?= CHtml::encode($bonus->user->profile->lang->second_name); ?> <?= CHtml::encode($bonus->user->profile->lang->last_name); ?></td>
        <td><?= Yii::t('app', 'Жилищный бонус'); ?></td>
        <td><?= CHtml::encode($bonus->transactions->amount); ?></td>
        <td><?= CHtml::encode($bonus->amount); ?></td>
    </tr><? $i++; ?>
    <? endif; ?>
    <? endforeach; ?>

    <? foreach($periode->auto as $bonus) : ?>
    <? if (!empty($bonus)) : ?>
    <tr>
        <td><?= $i; ?></td>
        <td><?= CHtml::encode($bonus->user->username); ?></td>
        <td><?= CHtml::encode($bonus->user->profile->lang->first_name); ?> <?= CHtml::encode($bonus->user->profile->lang->second_name); ?> <?= CHtml::encode($bonus->user->profile->lang->last_name); ?></td>
        <td><?= Yii::t('app', 'Автомобильный бонус'); ?></td>
        <td><?= CHtml::encode($bonus->transactions->amount); ?></td>
        <td><?= CHtml::encode($bonus->amount); ?></td>
    </tr><? $i++; ?>
    <? endif; ?>
    <? endforeach; ?>

    <? foreach($periode->gifts as $bonus) : ?>
    <? if (!empty($bonus)) : ?>
    <tr>
        <td><?= $i; ?></td>
        <td><?= CHtml::encode($bonus->user->username); ?></td>
        <td><?= CHtml::encode($bonus->user->profile->lang->first_name); ?> <?= CHtml::encode($bonus->user->profile->lang->second_name); ?> <?= CHtml::encode($bonus->user->profile->lang->last_name); ?></td>
        <td><?= Yii::t('app', 'Гифт бонус'); ?></td>
        <td><?= CHtml::encode($bonus->transactions->amount); ?></td>
        <td><?= CHtml::encode($bonus->amount); ?></td>
    </tr><? $i++; ?>
    <? endif; ?>
    <? endforeach; ?>

    <? foreach($periode->director as $bonus) : ?>
    <? if (!empty($bonus)) : ?>
    <tr>
        <td><?= $i; ?></td>
        <td><?= CHtml::encode($bonus->user->username); ?></td>
        <td><?= CHtml::encode($bonus->user->profile->lang->first_name); ?> <?= CHtml::encode($bonus->user->profile->lang->second_name); ?> <?= CHtml::encode($bonus->user->profile->lang->last_name); ?></td>
        <td><?= Yii::t('app', 'Директорский бонус'); ?></td>
        <td><?= CHtml::encode($bonus->transactions->amount); ?></td>
        <td><?= CHtml::encode($bonus->amount); ?></td>
    </tr><? $i++; ?>
    <? endif; ?>
    <? endforeach; ?>

    <? foreach($periode->directorinfinity as $bonus) : ?>
    <? if (!empty($bonus)) : ?>
    <tr>
        <td><?= $i; ?></td>
        <td><?= CHtml::encode($bonus->user->username); ?></td>
        <td><?= CHtml::encode($bonus->user->profile->lang->first_name); ?> <?= CHtml::encode($bonus->user->profile->lang->second_name); ?> <?= CHtml::encode($bonus->user->profile->lang->last_name); ?></td>
        <td><?= Yii::t('app', 'Бонус бесконечности'); ?></td>
        <td><?= CHtml::encode($bonus->transactions->amount); ?></td>
        <td><?= CHtml::encode($bonus->amount); ?></td>
    </tr><? $i++; ?>
    <? endif; ?>
    <? endforeach; ?>
</table>
<div>
    <a class="btn200" href="javascript:void(0)" onClick="window.location = '<?= $this->createUrl('/admin/bonuses/default/index') ?>'"><?= Yii::t('app', 'Назад') ?></a>
</div>
<? else : ?>
<h2>Пусто</h2>
<a class="btn200" href="javascript:void(0)" onClick="window.location = '<?= $this->createUrl('/admin/bonuses/default/index') ?>'"><?= Yii::t('app', 'Назад') ?></a>
<? endif; ?>
<br /><br />
<? $this->widget('CLinkPager', array('pages' => $pages))?>
