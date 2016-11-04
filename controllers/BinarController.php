<?php

class BinarController extends BinarControllerBase {

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function actionIndex($guid) {
        $this->Index($guid);
    }
    
    public function actionHistory($guid) {
        $this->History($guid);
    }
    
    public function actionCalculate() {
        $this->Calculate();
    }
    
    public function actionPayout($guid) {
        $this->Payout($guid);
    }
}
