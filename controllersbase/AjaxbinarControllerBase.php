<?php

class AjaxbinarControllerBase extends UTIController
{
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
    
    public function saveFilter()
    {
        $param = $_POST;
        $alias = '';
        if (array_key_exists('YII_CSRF_TOKEN', $param))
        {
            unset($param['YII_CSRF_TOKEN']);
        }
        if (array_key_exists('alias', $param))
        {
            $alias = $param['alias'];
            unset($param['alias']);
        }
        if (empty($alias))
        {
            echo CJSON::encode(array('success' => FALSE));
            return;
        }
        $this->subSession->saveParam($alias, array(
            'filter' => $param
        ));
        
        echo CJSON::encode(array('subsession' => $this->subSession->guid));
    }    
    
   
}