<?php

class DefaultController extends DefaultControllerBase {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function actionIndex() {
        $this->Index();
    }

    public function actionBonusesprint() {
        $this->Bonusesprint();
    }
    
}
