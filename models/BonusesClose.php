<?php

class BonusesClose
{

	public static function closePeriode()
	{
		Yii::import('application.modules.register.models.*');
		Yii::import('application.modules.office.models.*');
		
		$per = ProfileBonuses::model()->getPeriodeCurrent();
		
		 $dateStart = app_date("Y-m-d 00:00:00",strtotime($per->date_begin));
		if((app_date("m",strtotime($per->date_begin))+1) > 12)
		{
			$dateEnd = app_date("Y-m-d 23:59:59",  strtotime((app_date("Y", strtotime($dateStart)))."-12-31"));
			$nextStart = app_date("Y-m-d 00:00:00",  strtotime((app_date("Y", strtotime($dateStart))+1)."-01-01"));
		}
		else
		{
			$dateEnd = app_date("Y-m-d 23:59:59",  strtotime(app_date("Y", strtotime($dateStart))."-".app_date("m", strtotime($dateStart))."-".self::getDay(app_date("m", strtotime($dateStart)))));
			$nextStart = app_date("Y-m-d 00:00:00",  strtotime((app_date("Y",strtotime($per->date_begin)))."-".(app_date("m",strtotime($per->date_begin))+1)."-01"));
		}


		$transaction = Yii::app()->db->beginTransaction();
		try
		{
				
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
				
				if(!ProfileBonuses::model()->setEnergyRankToUser($dateStart, $dateEnd))
				{
					throw new CException('Старый период не сохранен7', E_USER_ERROR);
				}
				if(!ProfileBonuses::model()->updateEnergyRankToUser($dateStart, $dateEnd))
				{
					throw new CException('Старый период не сохранен70', E_USER_ERROR);
				}
				if(!ProfileBonuses::model()->setDirectorRankToUser($dateStart, $dateEnd))
				{
					throw new CException('Старый период не сохранен6', E_USER_ERROR);
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
			$profilePeriode->date_begin = $nextStart;

			if ($profilePeriode->validate())
			{
				if (!$profilePeriode->save())
				{
					throw new CException('Новый период не создан', E_USER_ERROR);
				}
			}

			$transaction->commit();
			
		}
		catch (Exception $e)
		{
			if ($transaction->getActive())
			{
				$transaction->rollback();
			}
			
			return FALSE;
		} 
		return TRUE;
	}
	
	public static function getDay($month)
	{
		switch ($month) 
		{
			case 1: 
				return 31;
			case 2: 
				return 28;
			case 3:
				return 31;
			case 4:
				return 30;
			case 5:
				return 31;
			case 6:
				return 30;
			case 7:
				return 31;
			case 8:
				return 31;
			case 9:
				return 30;
			case 10:
				return 31;
			case 11:
				return 30;
			case 12:
				return 31;
		}
	}
}
