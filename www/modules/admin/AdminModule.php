<?php

namespace app\modules\admin;

class AdminModule extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\admin\controllers';

    public function init()
    {
        parent::init();
        $this->layout = '//main_panel';

        // custom initialization code goes here
    }
}
