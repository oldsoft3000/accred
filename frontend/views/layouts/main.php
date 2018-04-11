

<?php
use frontend\assets\AppAsset;

/* @var $this \yii\web\View */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" ng-app="App">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>My Angular Yii Application</title>
        <?php $this->head() ?>

        <script>paceOptions = {ajax: {trackMethods: ['GET', 'POST']}};</script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/red/pace-theme-minimal.css" rel="stylesheet" />
    </head>
    <body ng-controller="MainController">
        <?php $this->beginBody() ?>

        <header class="navbar navbar-expand navbar-dark flex-column flex-md-row bd-navbar">
            <img class="logo" src="../images/logo_1.png" >
        </header>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-3 col-xl-3 bd-sidebar">
                        <li ng-class="{'sidebar-loaded': true}" ng-show="!isLoggedIn()" class="nav-item sidebar-loading"> 
                          <!--ng-class="{'selected-style':isActivePath('/login')||isActivePath('/signup')}"--> 
                          <a  class="btn btn-secondary nav-link" role="button" aria-disabled="true" href="#!/login">Вход в личный кабинет</a> 
                        </li> 
                        <li ng-class="{'sidebar-loaded': true}" ng-show="isLoggedIn()" class="nav-item sidebar-loading"> 
                          <!--ng-class="{'selected-style':isActivePath('/agreement')}"-->  
                          <a class="btn btn-secondary nav-link" role="button" aria-disabled="true" href="#!/agreement">Соглашение</a> 
                        </li> 
                        <li ng-class="{'sidebar-loaded': true}" ng-show="isLoggedIn()" class="nav-item sidebar-loading"> 
                          <!--ng-ng-class="{'selected-style':isActivePath('/particips')}"-->  
                          <a class="btn btn-secondary nav-link " role="button" aria-disabled="true" href="#!/particip/view">Список участников</a> 
                        </li> 
                        <li ng-class="{'sidebar-loaded': true}" ng-show="isLoggedIn()" class="nav-item sidebar-loading"> 
                          <a ng-click="logout()" class="btn btn-secondary nav-link" role="button" aria-disabled="true" href="">Выход</a> 
                        </li> 
                </div>

                <main class="col-12 col-md-9 col-xl-9 py-md-3 pl-md-5 bd-content" role="main">
                    <div ng-view class="container-fluid ">
                    </div>
                </main>
            </div>
        </div>

        <!--<div class="main" id="main">
          <div ng-view class="container-fluid">
          </div>
        </div>-->

        <?php $this->endBody() ?>

        <div class="device-sm" style="display:none;"></div>

        <script type="text/javascript">


        </script>
    </body>
</html>
<?php $this->endPage() ?>