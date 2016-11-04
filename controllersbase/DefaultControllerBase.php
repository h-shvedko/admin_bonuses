<?php

class DefaultControllerBase extends UTIController
{

    public $breadcrumbs = array('Панель управления' => array('/admin'));
    public $layout = '';

    public function init()
    {
        $this->breadcrumbs['Расчет бонусов'] = $this->createUrl('index');
        parent::init();
    }

    public function Index()
    {
        //$this->checkAccess();
        $this->pageTitle = Yii::t('app', 'Расчет бонусов');
		$this->breadcrumbs = array(Yii::t('app', 'Расчет бонусов') => $this->createUrl('/'));
        $periodeBinar = ProfilePeriodeBinar::model()->findAll(array('order'=>'date_begin'));
		$criteria = new CDBCriteria();
		$criteria->condition = 'date_end IS NOT NULL';
		$criteria->order = 'date_begin';
        $periodeMLM = ProfilePeriode::model()->findAll($criteria);
        $periode = new ProfilePeriode();
        $periodeBin = new ProfilePeriodeBinar();
        $this->include_jquery_calendar();
        $this->include_jquery_ui();
        CHtml::asset(Yii::getPathOfAlias('admin.modules.user.css'));
        $this->render('index', array(
            'periodeBinar' => $periodeBinar,
            'periodeMLM' => $periodeMLM,
            'periode' => $periode,
            'periodeBin' => $periodeBin,
        ));
    }

    public function getBonusesValue($alias)
    {
        if (empty($alias))
        {
            throw new CHttpException(403, Yii::t('app', 'Такого бонуса не существует'));
        }
        if ($alias == 'Bonuses')
        {
            $periode = array();
            $end = strtotime("last day of 1 month ago");
            $monthOfLastPeriod = strftime('%m', $end);
            Yii::import('application.modules.office.models.*');
            $j = 0;
            for ($i = 1; $i <= (int) $monthOfLastPeriod; $i++)
            {
                $start = strtotime("first day of" . $i . " month ago");
                $end = strtotime("last day of" . $i . " month ago");
                $modelName = 'Profile' . $alias;
                $model = $modelName::model()->find('date_periode >= :date_periode and date_periode <= :date_end', array(':date_periode' => strftime('%Y-%m-%d', $start), ':date_end' => strftime('%Y-%m-%d', $end)));
                if ($model != NULL)
                {
                    $periode[] = [
                        'id' => $model->periode__id,
                        'start' => strftime('%Y-%m-%d', $start),
                        'end' => strftime('%Y-%m-%d', $end),
                        'is_full' => (int) TRUE,
                    ];
                }
                else
                {
                    $periode[] = [
                        'id' => $model->periode__id,
                        'start' => strftime('%Y-%m-%d', $start),
                        'end' => strftime('%Y-%m-%d', $end),
                        'is_full' => (int) FALSE,
                    ];
                }
                $j = $i;
            }
        }
        else
        {
            $periode = array();
            $end = strtotime("last day of 1 month ago");
            $monthOfLastPeriod = strftime('%m', $end);
            Yii::import('application.modules.office.models.*');
            $j = 0;
            for ($i = 1; $i <= (int) $monthOfLastPeriod; $i++)
            {
                $start = strtotime("first day of" . $i . " month ago");
                $end = strtotime("last day of" . $i . " month ago");
                $modelName = 'Profile' . $alias . 'Bonuses';
                $model = $modelName::model()->find('periode_date >= :date_periode and periode_date <= :date_end', array(':date_periode' => strftime('%Y-%m-%d', $start), ':date_end' => strftime('%Y-%m-%d', $end)));
                if ($model != NULL)
                {
                    $periode[] = [
                        'id' => $model->periode__id,
                        'start' => strftime('%Y-%m-%d', $start),
                        'end' => strftime('%Y-%m-%d', $end),
                        'is_full' => (int) TRUE,
                    ];
                }
                else
                {
                    $periode[] = [
                        'id' => $model->periode__id,
                        'start' => strftime('%Y-%m-%d', $start),
                        'end' => strftime('%Y-%m-%d', $end),
                        'is_full' => (int) FALSE,
                    ];
                }
                $j = $i;
            }
        }
        return $periode;
    }

    public function include_jquery_calendar()
    {
        $ScriptFile = $this->module->getBasePath() . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'jquery.calendar';

        if (file_exists($ScriptFile))
        {
            $path = Yii::app()->assetManager->publish($ScriptFile) . '/';

            Yii::app()->clientScript->registerCssFile(
                $path . 'css/ui-lightness/jquery-ui-1.8.16.custom.css', 'screen'
            );

            Yii::app()->clientScript->registerScriptFile(
                $path . 'jquery.ui.datepicker-ru.js', CClientScript::POS_HEAD
            );
        }
    }
}
