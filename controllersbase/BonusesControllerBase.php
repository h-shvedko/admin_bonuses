<?php

class BonusesControllerBase extends UTIController
{

    public function __construct($id, $module = null)
    {
        parent::__construct($id, $module);

        $this->layout = '';
    }

    public function Index($guid)
    {
        $this->pageTitle = 'Таблица бонусов по сетевой структуре';
        $this->breadcrumbs = array(Yii::t('app', 'Расчет бонусов') => $this->createUrl('/admin/bonuses'));
        Yii::import('application.modules.admin.modules.user.models.*');
        $criteria = new CDbCriteria();
        $criteria->with = array();
        $filter = array();

        $this->include_jquery_calendar();
        $this->include_jquery_ui();
        CHtml::asset(Yii::getPathOfAlias('admin.modules.user.css'));

        $binarFilter = new ProfileActivity();
        $user = new Users();
        $profile = new Profile();
        $profileLang = new ProfileLang();
        $profileBonamor = new ProfileBonamor();
        CHtml::asset(Yii::getPathOfAlias('admin.modules.bonuses.css'));

        $periode = ProfilePeriode::model()->findbySha1($guid);

        $sumDirector = $this->getSum($periode->director);
        $sumAuto = $this->getSum($periode->auto);
        $sumHouse = $this->getSum($periode->house);
        $sumInstant = $this->getSum($periode->instant);
        $sumLeader = $this->getSum($periode->leader);
        $sumLinear = $this->getSum($periode->linear);
        $sumStair = $this->getSum($periode->stair);
        $sumAll = $sumDirector + $sumAuto + $sumHouse + $sumInstant + $sumLeader + $sumLinear + $sumStair;

        $countAll = count($periode->director) + count($periode->directorinfinity) + count($periode->auto) +
            count($periode->gifts) + count($periode->house) + count($periode->instant) + count($periode->leader) +
            count($periode->linear) + count($periode->stair);
        $this->render('index', array(
            'periode' => $periode,
            'pages' => $pages,
            'binarFilter' => $binarFilter,
            'user' => $user,
            'profile' => $profile,
            'profileBonamor' => $profileBonamor,
            'profileLang' => $profileLang,
            'filter' => $filter,
            'countAll' => $countAll,
            'sumDirector' => $sumDirector,
            'sumAuto' => $sumAuto,
            'sumHouse' => $sumHouse,
            'sumInstant' => $sumInstant,
            'sumLeader' => $sumLeader,
            'sumLinear' => $sumLinear,
            'sumStair' => $sumStair,
            'sumAll' => $sumAll,
            'guid' => $guid,
        ));
    }

    public function History($guid)
    {
        $this->pageTitle = 'Таблица бонусов по сетевой структуре';
        $this->breadcrumbs = array(Yii::t('app', 'Расчет бонусов') => $this->createUrl('/admin/bonuses'));
        Yii::import('application.modules.admin.modules.user.models.*');
		$periode = ProfilePeriode::model()->findbySha1($guid);
		
        $criteria = new CDbCriteria();
		$criteria->condition = 'periode__id = :periode__id';
		$criteria->params = array(':periode__id' => $periode->id);
		$result = $criteria->with = array();
        $filter = array();

        $this->include_jquery_calendar();
        $this->include_jquery_ui();
        CHtml::asset(Yii::getPathOfAlias('admin.modules.user.css'));

        $sessionfilter = $this->subSession->getParam('admin_bonuses_bonuses');

        if (($sessionfilter != NULL) && (array_key_exists('filter', $sessionfilter)))
        {
            $filter = $sessionfilter['filter'];
        }

        if ((array_key_exists('username', $filter)) && (!empty($filter['username'])))
        {
            $this->filter($criteria, 'username', $filter['username'], 'username', ' = ', 'user');
        }
		if ((array_key_exists('phone', $filter)) && (!empty($filter['phone'])))
        {
            $this->filter($criteria, 'phone', $filter['phone'], 'phone', ' = ', array('user', 'profile'));
        }
		
		if ((array_key_exists('bonuses_name', $filter)) && (!empty($filter['bonuses_name'])))
        {
            $this->filter($criteria, 'bonuses_name', $filter['bonuses_name'], 'bonuses__id', ' = ', array('users_bonuses', 'lang'));
        }
		
		if ((array_key_exists('amount', $filter)) && (!empty($filter['amount'])))
        {
            $this->filter($criteria, 'amount', $filter['amount'], 'amount', ' = ');
        }
		
		if ((array_key_exists('points', $filter)) && (!empty($filter['points'])))
        {
            $this->filter($criteria, 'points', $filter['points'], 'amount', ' = ');
        }
     //   vg($criteria,7); die;
		
        $count = ProfileReportFinal::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 30;
        $pages->applyLimit($criteria);

        $binarFilter = new ProfileActivity();
        $user = new Users();
        $profile = new Profile();
        $profileLang = new ProfileLang();
        $profileBonamor = new ProfileBonamor();
        CHtml::asset(Yii::getPathOfAlias('admin.modules.bonuses.css'));

        $sumDirector = $this->getSum($periode->director)*100;
        $sumAuto = $this->getSum($periode->auto);
        $sumHouse = $this->getSum($periode->house);
        $sumInstant = $this->getSum($periode->instant);
        $sumLeader = $this->getSum($periode->leader);
        $sumLinear = $this->getSum($periode->linear) *100;
        $sumStair = $this->getSum($periode->stair) *100;
        $sumAll = $sumDirector + $sumAuto + $sumHouse + $sumInstant + $sumLeader + $sumLinear + $sumStair;
		
		$report = ProfileReportFinal::model()->findAll($criteria);
		
        $countAll = count($periode->director) + count($periode->directorinfinity) + count($periode->auto) +
            count($periode->gifts) + count($periode->house) + count($periode->instant) + count($periode->leader) +
            count($periode->linear) + count($periode->stair);
        $this->render('history', array(
			'report' => $report,
            'periode' => $periode,
            'pages' => $pages,
            'binarFilter' => $binarFilter,
            'user' => $user,
            'profile' => $profile,
            'profileBonamor' => $profileBonamor,
            'profileLang' => $profileLang,
            'filter' => $filter,
            'countAll' => $countAll,
            'sumDirector' => $sumDirector,
            'sumAuto' => $sumAuto,
            'sumHouse' => $sumHouse,
            'sumInstant' => $sumInstant,
            'sumLeader' => $sumLeader,
            'sumLinear' => $sumLinear,
            'sumStair' => $sumStair,
            'sumAll' => $sumAll,
            'guid' => $guid,
        ));
    }

    public function Payout($guid)
    {
        $this->pageTitle = 'Таблица бонусов по сетевой структуре';
        $this->breadcrumbs = array(Yii::t('app', 'Расчет бонусов') => $this->createUrl('/admin/bonuses'));
        Yii::import('application.modules.admin.modules.user.models.*');

        if (isset($_POST) && array_key_exists('btn_pass', $_POST) && array_key_exists('YII_CSRF_TOKEN', $_POST))
        {
            $user = new Users();
            $pass = $_POST['YII_CSRF_TOKEN'];
            $this->render('payout', array(
                'guid' => $guid,
                'pass' => $pass,
                'user' => $user,
            ));
            return;
        }

        if (isset($_POST) && array_key_exists('btn_pay', $_POST) && array_key_exists('pass', $_POST) && array_key_exists('YII_CSRF_TOKEN', $_POST))
        {
            $user = Users::model()->find('username = :username', array(':username' => 'admin'));
            if ($user->password != $_POST['pass'])//sha1($_POST['pass']))
            {
				Yii::app()->user->setFlash('error', "Неправильный пароль Администратора");
				$this->redirect($this->createUrl('/admin/bonuses/bonuses/payout/guid/'.$guid));
            }
            $periode = ProfilePeriode::model()->findbySha1($guid);

            $binarTransaction = Yii::app()->db->beginTransaction();
            try
            {
                foreach ($periode->report as $value)
                {
                    if ($value->transactions->status_alias == 'open')
                    {
                        $transaction = new FinanceTransaction('admin');
                        $transaction->initAllByTransactionId($value->transactions__id);

                        if (!$transaction->confirmAdmin())
                        {
							vg($value->transactions->id);
                            throw new CHttpException(403, Yii::t('app', 'Ошибка создания финансовых операций для выплат бонусов1'));
                        }
                    }
                }
				$periode->paid = (int)TRUE;
                if(!$periode->validate())
				{
					throw new CHttpException(403, Yii::t('app', 'Ошибка создания финансовых операций для выплат бонусов2'));
				}
				if(!$periode->save())
				{
					throw new CHttpException(403, Yii::t('app', 'Ошибка создания финансовых операций для выплат бонусов3'));
				}
                $binarTransaction->commit();
            }
            catch (Exception $e)
            {
                if ($binarTransaction->getActive())
                {
                    $binarTransaction->rollback();
                }
                throw new CException($e->getMessage());
            }
            $this->redirect($this->createUrl('/admin/bonuses/'));
        }

       
		$periode = ProfilePeriode::model()->findBySha1($guid);
        $criteria = new CDbCriteria();
		$criteria->condition = 'periode__id = :periode__id';
		$criteria->params = array(':periode__id' => $periode->id);
		$result = $criteria->with = array();
        $filter = array();

        $this->include_jquery_calendar();
        $this->include_jquery_ui();
        CHtml::asset(Yii::getPathOfAlias('admin.modules.user.css'));

        $sessionfilter = $this->subSession->getParam('admin_bonuses_bonuses');

        if (($sessionfilter != NULL) && (array_key_exists('filter', $sessionfilter)))
        {
            $filter = $sessionfilter['filter'];
        }
		if ((array_key_exists('phone', $filter)) && (!empty($filter['phone'])))
        {
            $this->filter($criteria, 'phone', $filter['phone'], 'phone', ' = ', array('user', 'profile'));
        }

        if ((array_key_exists('username', $filter)) && (!empty($filter['username'])))
        {
            $this->filter($criteria, 'username', $filter['username'], 'username', ' = ', 'user');
        }
		
		if ((array_key_exists('bonuses_name', $filter)) && (!empty($filter['bonuses_name'])))
        {
            $this->filter($criteria, 'bonuses_name', '%' . trim($filter['bonuses_name']) . '%', 'bonuses_name', ' LIKE ', array('users_bonuses', 'lang'));
        }
		
		if ((array_key_exists('amount', $filter)) && (!empty($filter['amount'])))
        {
            $this->filter($criteria, 'amount', $filter['amount'], 'amount', ' = ');
        }
		
		if ((array_key_exists('points', $filter)) && (!empty($filter['points'])))
        {
            $this->filter($criteria, 'points', $filter['points'], 'amount', ' = ');
        }
        //vg($this->subSession,7); die;
		
        $count = ProfileReportFinal::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 30;
        $pages->applyLimit($criteria);

        $binarFilter = new ProfileActivity();
        $user = new Users();
        $profile = new Profile();
        $profileLang = new ProfileLang();
        $profileBonamor = new ProfileBonamor();
        CHtml::asset(Yii::getPathOfAlias('admin.modules.bonuses.css'));

        $sumDirector = $this->getSum($periode->director)*100;
        $sumAuto = $this->getSum($periode->auto);
        $sumHouse = $this->getSum($periode->house);
        $sumInstant = $this->getSum($periode->instant);
        $sumLeader = $this->getSum($periode->leader);
        $sumLinear = $this->getSum($periode->linear)*100;
        $sumStair = $this->getSum($periode->stair)*100;
        $sumAll = $sumDirector + $sumAuto + $sumHouse + $sumInstant + $sumLeader + $sumLinear + $sumStair;
		
		$report = ProfileReportFinal::model()->findAll($criteria);
		
        $countAll = count($periode->director) + count($periode->directorinfinity) + count($periode->auto) +
            count($periode->gifts) + count($periode->house) + count($periode->instant) + count($periode->leader) +
            count($periode->linear) + count($periode->stair);
        $this->render('payout', array(
			'report' => $report,
            'periode' => $periode,
            'pages' => $pages,
            'binarFilter' => $binarFilter,
            'user' => $user,
            'profile' => $profile,
            'profileBonamor' => $profileBonamor,
            'profileLang' => $profileLang,
            'filter' => $filter,
            'countAll' => $countAll,
            'sumDirector' => $sumDirector,
            'sumAuto' => $sumAuto,
            'sumHouse' => $sumHouse,
            'sumInstant' => $sumInstant,
            'sumLeader' => $sumLeader,
            'sumLinear' => $sumLinear,
            'sumStair' => $sumStair,
            'sumAll' => $sumAll,
            'guid' => $guid,
        ));
    }

    public function Calculate()
    {
        Yii::import('application.modules.admin.modules.user.models.*');
        Yii::import('application.modules.admin.modules.matrix.models.*');
        Yii::import('application.modules.admin.modules.finance.models.*');
		Yii::import('application.modules.office.models.*');
        if (isset($_POST) && array_key_exists('btn_clc', $_POST) && array_key_exists('YII_CSRF_TOKEN', $_POST))
        { 
			$guid = sha1(ProfileBonuses::model()->getPeriode()->id);
			$periode = ProfilePeriode::model()->findBySha1($guid);
			
			if($periode->paid >= (int)TRUE)
			{
				Yii::app()->user->setFlash('error', "Этот период уже закрыт");
				$this->redirect($this->createUrl('/admin/bonuses/bonuses/history/guid/'.$guid));
			}
		    $date_ = date_create($_POST['date_begin']);
            $dateBegin = date_format($date_, "Y-m-d");
            $date__ = date_create($_POST['date_end']);
            $dateEnd = date("Y-m-d H:i:s", strtotime("-1 day", strtotime($_POST['date_end'])));
			
			ini_set('memory_limit', '512M');
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
			
			//$guid = $this->createNewPeriode($dateBegin, $dateEnd);

            if (!ProfileBonuses::model()->addBonusesLinear(NULL, $dateBegin, $dateEnd))
            {
                throw new CException('Ошибка Начисления линейного бонуса', E_USER_ERROR);
            } 
			if (!ProfileBonuses::model()->addBonusesStair())
            {
                throw new CException('Ошибка Начисления линейного бонуса', E_USER_ERROR);
            }
			if (!ProfileBonuses::model()->addBonusesDirector())
            {
                throw new CException('Ошибка Начисления линейного бонуса', E_USER_ERROR);
            }
			if (!ProfileBonuses::model()->addBonusesDirectorInfinity())
            {
                throw new CException('Ошибка Начисления линейного бонуса', E_USER_ERROR);
            }
			if (!ProfileBonuses::model()->setAutoBonusValue())
            {
                throw new CException('Ошибка Начисления линейного бонуса', E_USER_ERROR);
            }
			if (!ProfileBonuses::model()->setHouseBonusValue())
            {
                throw new CException('Ошибка Начисления линейного бонуса', E_USER_ERROR);
            }
			if (!ProfileBonuses::model()->setLeaderBonusesValue(NULL, $dateBegin, $dateEnd))
            {
                throw new CException('Ошибка Начисления линейного бонуса', E_USER_ERROR);
            }
			if (!ProfileBonuses::model()->setAutoBonusForDirectors())
            {
                throw new CException('Ошибка Начисления авто- и жилищного бонуса', E_USER_ERROR);
            }
			
			$periode = ProfilePeriode::model()->findBySha1($guid);
			$periode->paid = 2;
			$periode->save();
            
			
			$transaction->commit();
			}
			catch (Exception $e)
            {
                if ($transaction->getActive())
                {
                    $transaction->rollback();
                }
				
                throw new CException($e->getMessage());
            }
			$url = $this->createUrl('/admin/bonuses/bonuses/payout/guid/' . $guid);
            $this->redirect($url);
        }
    }

    public function createNewPeriode($dateStart, $dateEnd)
    {
	
        Yii::import('application.modules.office.models.*');
        Yii::import('application.modules.register.models.*');
		
        $periodeExist = ProfilePeriode::model()->findAll('date_end > :date_end', array(':date_end' => $dateStart));
        if (!empty($periodeExist))
        {
            throw new CException('Данный период не может быть создат, т.к. уже существует период с такими  датами', E_USER_ERROR);
        }
        $periode = ProfilePeriode::model()->find('date_end is NULL');
        if (!empty($periode))
        {
            $periode->date_end = $dateEnd;

                if (!ProfileBonuses::model()->closePersonalVolume($dateEnd))
				{
					throw new CException('Старый период не сохранен1', E_USER_ERROR);
				}
				if(!ProfileBonuses::model()->createNewPersonalVolume($dateStart, $dateEnd) )
				{
					throw new CException('Старый период не сохранен2', E_USER_ERROR);
				}
				if(!ProfileBonuses::model()->closePersonalVolumeOfPersonalGroup($dateEnd))
				{
					throw new CException('Старый период не сохранен3', E_USER_ERROR);
				}
				if(!ProfileBonuses::model()->createNewVolumeOfPersonalGroup($dateStart, $dateEnd))
				{
					throw new CException('Старый период не сохранен4', E_USER_ERROR);
				}
				if(!ProfileBonuses::model()->setRankToUser($dateStart, $dateEnd))
				{
					throw new CException('Старый период не сохранен5', E_USER_ERROR);
				}
				if(!ProfileBonuses::model()->setDirectorRankToUser($dateStart, $dateEnd))
				{
					throw new CException('Старый период не сохранен6', E_USER_ERROR);
				}
				if(!ProfileBonuses::model()->setEnergyRankToUser($dateStart, $dateEnd))
				{
					throw new CException('Старый период не сохранен7', E_USER_ERROR);
				}
				if(!ProfileBonuses::model()->updateEnergyRankToUser($dateStart, $dateEnd))
				{
					throw new CException('Старый период не сохранен70', E_USER_ERROR);
				}
				if(!ProfileBonuses::model()->setRankHistory())
				{
					throw new CException('Старый период не сохранен71', E_USER_ERROR);
				}
				
				if ($periode->validate())
				{
					if (!$periode->save())
					{
						throw new CException('Старый период не сохранен', E_USER_ERROR);
					}
				}
				else
				{
					throw new CException('Старый период не сохраненVal', E_USER_ERROR);
				}
        }
        $profilePeriode = new ProfilePeriode();
        $profilePeriode->date_begin = date("Y-m-d", strtotime("+1 day", strtotime($dateEnd)));

        if ($profilePeriode->validate())
        {
            if (!$profilePeriode->save())
            {
                throw new CException('Новый период не создан', E_USER_ERROR);
            }
        }
		
		
        if (!empty($periode))
        {
            return sha1($periode->id);
        }
		
    }

    public function getSum($model)
    {
        $sum = 0;
        if (empty($model))
        {
            return $sum;
        }

        foreach ($model as $value)
        {
            $sum+= $value->amount;
        }
        return $sum;
    }

    public function filter(&$criteria, $param_name, $param, $column_name = null, $merge = ' = ', $with = null)
    {
        if ($column_name == null)
            $column_name = $param_name;
        if (($with != NULL) && (!is_array($with)) && ($column_name != 'MONTH(birthday)') && ($column_name != 'CONCAT(last_name, " ", first_name)') && ($column_name != '`alias-user`.created_at'))
        {
            $column_name = $with . '.' . $column_name;
        }
        $escape_param = ':' . $param_name;
        if ($with != null)
        {
            if (is_array($with))
            {
                if ($criteria->with == NULL)
                {
                    $criteria->with = array();
                }
                $with_array = &$criteria->with;

                foreach ($with as $relation)
                {
                    if ($relation != end($with))
                    {
                        if ($with_array == NULL)
                        {
                            $with_array = array();
                        }
                        if (!array_key_exists($relation, $with_array))
                        {
                            $with_array = array(
                                $relation => array(
                                    'with' => array(),
                                    'alias' => 'alias-' . $relation
                                )
                            );
                        }

                        if (!array_key_exists('with', $with_array[$relation]))
                        {
                            $with_array[$relation]['with'] = array();
                        }

                        $with_array = &$with_array[$relation]['with'];

                        continue;
                    }

                    if ($column_name == 'CONCAT(last_name, " ", first_name)')
                    {
                        if (array_key_exists($relation, $with_array))
                        {
                            $with_array[$relation]['condition'] .= ' AND ' . $column_name . $merge . $escape_param;
                            $with_array[$relation]['params'] = array_merge($with_array[$relation]['params'], array($escape_param => $param));
                        }
                        else
                        {
                            $with_array = array(
                                $relation => array(
                                    'condition' => $column_name . $merge . $escape_param,
                                    'params' => array($escape_param => $param))
                            );
                        }
                    }
                    elseif ($column_name == 'rank__id')
                    {
                        if ($merge == ' IS NULL ')
                        {
                            if (array_key_exists($relation, $with_array))
                            {
                                $with_array[$relation]['condition'] .= ' AND ' . $column_name . $merge;
                            }
                            else
                            {
                                $with_array = array(
                                    $relation => array(
                                        'condition' => $column_name . $merge,
                                        'params' => array($escape_param => $param))
                                );
                            }
                        }
                        else
                        {
                            if (array_key_exists($relation, $with_array))
                            {
                                $with_array[$relation]['condition'] .= ' AND ' . $column_name . $merge . $escape_param;
                                $with_array[$relation]['params'] = array_merge($with_array[$relation]['params'], array($escape_param => $param));
                            }
                            else
                            {
                                $with_array = array(
                                    $relation => array(
                                        'condition' => $column_name . $merge . $escape_param,
                                        'params' => array($escape_param => $param))
                                );
                            }
                        }
                    }
                    else
                    {
                        if (array_key_exists($relation, $with_array))
                        {
                            $with_array[$relation]['condition'] .= ' AND ' . $relation . '.' . $column_name . $merge . $escape_param;
                            $with_array[$relation]['params'] = array_merge($with_array[$relation]['params'], array($escape_param => $param));
                        }
                        else
                        {
                            $with_array = array(
                                $relation => array(
                                    'condition' => $relation . '.' . $column_name . $merge . $escape_param,
                                    'params' => array($escape_param => $param))
                            );
                        }
                    }
                }
            }
            else
            {
                if (array_key_exists($with, $criteria->with))
                {
                    if (array_key_exists('condition', $criteria->with[$with]))
                    {
                        $criteria->with[$with]['condition'] .= ' AND ' . $column_name . $merge . $escape_param;
                        $criteria->with[$with]['params'] = array_merge($criteria->with[$with]['params'], array($escape_param => $param));
                    }
                    else
                    {
                        $criteria->with[$with]['condition'] = $column_name . $merge . $escape_param;
                        $criteria->with[$with]['params'] = array($escape_param => $param);
                    }
                }
                else
                {
                    if (empty($criteria->with))
                    {
                        $criteria->with = array(
                            $with => array(
                                'select' => FALSE,
                                'condition' => $column_name . $merge . $escape_param,
                                'params' => array($escape_param => $param))
                        );
                    }
                    else
                    {
                        $criteria->with = array_merge($criteria->with, array($with => array('select' => FALSE, 'condition' => $column_name . $merge . $escape_param, 'params' => array($escape_param => $param))));
                    }
                }
            }
            return;
        }
        if ($criteria->condition == '')
        {
            $criteria->condition = $column_name . $merge . $escape_param;
            $criteria->params = array($escape_param => $param);
        }
        else
        {
            $criteria->condition .= ' AND ' . $column_name . $merge . $escape_param;
            $criteria->params = array_merge($criteria->params, array($escape_param => $param));
        }
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
