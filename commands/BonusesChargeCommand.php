<?php

define('SECRET_PASSWORD_FOR_TESTING_MODE', 'wearecool');

class BonusesChargeCommand extends UTIConsoleCommand
{
    public function actionQuarter()
    {
		if (($this->_is_run_quarter(0, 00)) && (date('d') == '01'))
        {
            $this->_matchingBonusCharge();
        }
    }

    protected function _matchingBonusCharge()
    {
        Yii::import('application.modules.admin.modules.bonuses.models.*');
        
		$result = BonusesClose::closePeriode();
		
        if (!$result)
        {
            print 'bad';
        }
        
        print 'ok';
    }
}    
