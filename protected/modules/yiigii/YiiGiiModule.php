<?php

class YiiGiiModule extends CWebModule {

    public function init() {
        $this->setImport(array(
            'yiigii.forms.*',
            'yiigii.controllers.*',
            'yiigii.*',
        ));
    }

    public static function onWebApplicationInit($event) {
        
        Yii::app()->setModules(array(
            'gii' => array(
                'class' => 'system.gii.GiiModule',
                'password' => HSetting::Get('password', 'yiigii'),
                // If removed, Gii defaults to localhost only. Edit carefully to taste.
                'ipFilters' => explode(",", HSetting::Get('ipFilters', 'yiigii')),
                'generatorPaths' => array(
                    'bootstrap.gii',
                ),
            ),
        ));
    }

}
