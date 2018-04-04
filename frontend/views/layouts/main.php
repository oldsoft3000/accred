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
<div class="wrap">
    <!-- <nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#/!">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#!particip/index">Каталог фильмов</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#!site/contact">Обратная связь</a>
                </li>
            </ul>
        </div>
    </nav> -->
    
    
    <!-- <div class="container">
        <div class="row">
            <div class="col-12 col-md-2 col-xl-2 bd-sidebar">
                <ul class="nav column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#!/login">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#!site/about">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#!site/contact">Link</a>
                    </li>
                 </ul>
            </div>
            <main class="col-12 col-md-9 col-xl-8 py-md-3 pl-md-5 bd-content" role="main">
                <div class="content">
                    <div ng-view></div>  
                </div>
            </main>
        </div>
    </div> -->
  <nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
    <a class="navbar-brand" href="#">Navbar</a>
    <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button> -->

    <!-- <div class="navbar-collapse justify-content-end" id="navbarsExampleDefault">
      <ul class="navbar-nav">
        <li class="nav-item"> 
          <a ng-show="loggedIn()" ng-click="logout()" href="" class="btn btn-primary" role="button" aria-disabled="false">Выйти</a>
        </li>
      </ul>
    </div> -->
  </nav>
  <div class="container-fluid">
    <div class="row flex-xl-nowrap">
      <div class="col-12 col-md-2 col-xl-2 sidebar">
        <div class="sidebar-sticky">
        <ul class="nav flex-column">
          <li ng-show="!loggedIn()" class="nav-item">
            <a class="nav-link" href="#!/login">Личный кабинет</a>
          </li>
          <li ng-show="loggedIn()" class="nav-item">
            <a class="nav-link" href="#/!">Соглашение</a>
          </li>
          <li ng-show="loggedIn()" class="nav-item">
            <a class="nav-link" href="#!site/about">Link</a>
          </li>
          <li ng-show="loggedIn()" class="nav-item">
            <a ng-click="logout()" class="nav-link" href="">Выход</a>
          </li>

        </ul>
        </div>
      </div> 

      <main class="col-12 col-md-9 col-xl-8 py-md-3 pl-md-5 bd-content" role="main">
        <div class="content">
          <!-- ngView: --><div ng-view="" class="ng-scope"><div class="jumbotron text-center ng-scope">
              <h1>Главная страница</h1>

              <p class="ng-binding">Everyone come and see how good I look!</p>
            </div></div>  
        </div>
      </main>
    </div>
  </div>

</div>

<!-- <footer class="footer">
    <div class="container">
        <p class="pull-right"><?= Yii::powered() ?> <?= Yii::getVersion() ?></p>
    </div>
</footer> -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>