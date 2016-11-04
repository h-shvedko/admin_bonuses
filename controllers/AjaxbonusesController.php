<?php

class AjaxbonusesController extends AjaxbonusesControllerBase
{
    public function actiongetSponsorInfo()
    {
		$this->getSponsorInfo();
    }
    
    public function actiongetNewPicture()
    {
		$this->getNewPicture();
    }
	
    public function actiondeletePicture()
    {
		$this->deletePicture();
    }	

    public function actionsaveFilter()
    {
		$this->saveFilter();
    }    
    
    public function actiongetStructure()
    {
		$this->getStructure();
    } 
    
    public function actionGetList()
    {
		$this->GetList();
    }	
	
}