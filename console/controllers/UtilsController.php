<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class UtilsController extends Controller
{
    public $password;
    
    public function options($actionID)
    {
        return ['password'];
    }

    public function actionPasswordHash()
    {
        echo $this->password . "\n";
        $hash = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        echo $hash . "\n";
    }

    public function actionGenerateString()
    {
        echo \Yii::$app->security->generateRandomString() . "\n";
    }




    public function actionRbac() {
        $authManager = Yii::$app->authManager;
        
        $authManager->removeAll(); 

        $admin = $authManager->createRole('admin');
        $editor = $authManager->createRole('editor');

        $authManager->add($admin);
        $authManager->add($editor);

        $participeRule = new \common\rbac\ParticipRule; 
        $authManager->add($participeRule);

        $login  = $authManager->createPermission('login');
        $logout = $authManager->createPermission('logout');
        $signUp = $authManager->createPermission('signup');
        $index  = $authManager->createPermission('index');
        $view   = $authManager->createPermission('view');
        $update = $authManager->createPermission('update');
        $delete = $authManager->createPermission('delete');

        $index->ruleName = $participeRule->name;
        $view->ruleName = $participeRule->name;
        $update->ruleName = $participeRule->name;
        $delete->ruleName = $participeRule->name;

        $authManager->add($login);
        $authManager->add($logout);
        $authManager->add($signUp);
        $authManager->add($index);
        $authManager->add($view);
        $authManager->add($update);
        $authManager->add($delete);

        $authManager->addChild($editor, $login);
        $authManager->addChild($editor, $logout);
        $authManager->addChild($editor, $signUp);
        $authManager->addChild($editor, $index);
        $authManager->addChild($editor, $view);
        $authManager->addChild($editor, $update);
        $authManager->addChild($editor, $delete);

        $authManager->addChild($admin, $editor);
 
        $authManager->assign($admin, 1); 
    }
}