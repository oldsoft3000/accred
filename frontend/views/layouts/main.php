

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
        <script>paceOptions = {ajax: {trackMethods: ['GET', 'POST']}};</script>
        <?php $this->head() ?>
    </head>
    <body ng-controller="MainController">
        <?php $this->beginBody() ?>

          <div class="topnav">
              <img class="logo" src="../images/logo_1.png" >
          </div>
          <div class="sidebar">
              <li ng-class="{'sidebar-loaded': true}" ng-if="!isLoggedIn()" class="nav-item sidebar-loading">
                <a  class="btn btn-primary nav-link" role="button" aria-disabled="true" href="#!/login">Вход в личный кабинет</a> 
              </li> 
              <li ng-class="{'sidebar-loaded': true}" ng-if="isLoggedIn()" class="nav-item sidebar-loading"> 
                <a class="btn btn-primary nav-link" role="button" aria-disabled="true" href="#!/agreement">Соглашение</a> 
              </li> 
              <li ng-class="{'sidebar-loaded': true}" ng-if="isLoggedIn() && isUserAgreed()" class="nav-item sidebar-loading"> 
                <a class="btn btn-primary nav-link " role="button" aria-disabled="true" href="#!/particip/view">Список участников</a> 
              </li> 
              <li ng-class="{'sidebar-loaded': true}" ng-if="isLoggedIn() && isUserAgreed()" class="nav-item sidebar-loading"> 
                <a class="btn btn-primary nav-link " role="button" aria-disabled="true" href="#!/hotel/view">Размещение</a> 
              </li> 
              <li ng-class="{'sidebar-loaded': true}" ng-if="isLoggedIn()" class="nav-item sidebar-loading"> 
                <a ng-click="logout()" class="btn btn-primary nav-link" role="button" aria-disabled="true" href="">Выход</a> 
              </li> 
          </div>


        <div class="content">
          <div ng-view class="container-fluid ">
          </div>
        </div>



        <!-- <header class="navbar navbar-expand navbar-dark flex-column flex-md-row bd-navbar">
            <img class="logo" src="../images/logo_1.png" >
        </header>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-3 col-xl-3 bd-sidebar">
                        <li ng-class="{'sidebar-loaded': true}" ng-show="!isLoggedIn()" class="nav-item sidebar-loading"> 
                          <a  class="btn btn-secondary nav-link" role="button" aria-disabled="true" href="#!/login">Вход в личный кабинет</a> 
                        </li> 
                        <li ng-class="{'sidebar-loaded': true}" ng-show="isLoggedIn()" class="nav-item sidebar-loading"> 
                          <a class="btn btn-secondary nav-link" role="button" aria-disabled="true" href="#!/agreement">Соглашение</a> 
                        </li> 
                        <li ng-class="{'sidebar-loaded': true}" ng-show="isLoggedIn()" class="nav-item sidebar-loading"> 
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
        </div> -->


        <?php $this->endBody() ?>

        <div class="device-sm" style="display:none;"></div>

        <script type="text/javascript">

        </script>
    </body>
</html>
<?php $this->endPage() ?>