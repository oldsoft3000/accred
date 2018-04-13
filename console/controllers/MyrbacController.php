<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class MyrbacController extends Controller
{
    public function actionInit() {
        $authManager = Yii::$app->authManager;
        
        $authManager->removeAll(); 

        /*$admin = $authManager->createRole('admin');
        $editor = $authManager->createRole('editor');

        $authManager->add($admin);
        $authManager->add($editor);

        $participeRule = new \frontend\rbac\ParticipRule();
        $authManager->add($participeRule);

        $login  = $authManager->createPermission('login');
        $logout = $authManager->createPermission('logout');
        $error  = $authManager->createPermission('error');
        $signUp = $authManager->createPermission('signup');
        $index  = $authManager->createPermission('index');
        $view   = $authManager->createPermission('view');
        $update = $authManager->createPermission('update');
        $delete = $authManager->createPermission('delete');

        $admin->ruleName = $participeRule->name;
        $editor->ruleName = $participeRule->name;

        $authManager->add($login);
        $authManager->add($logout);
        $authManager->add($error);
        $authManager->add($signUp);
        $authManager->add($index);
        $authManager->add($view);
        $authManager->add($update);
        $authManager->add($delete);

        $authManager->addChild($editor, $login);
        $authManager->addChild($editor, $logout);
        $authManager->addChild($editor, $error);
        $authManager->addChild($editor, $signUp);
        $authManager->addChild($editor, $index);
        $authManager->addChild($editor, $view);

        $authManager->addChild($admin, $editor);
 
        $authManager->assign($admin, 1); */
    }
}