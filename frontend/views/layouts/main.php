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
      <div class="sidebar" id="sidebar">
        <ul class="nav flex-column"> 
          <li ng-show="!loggedIn()" class="nav-item">
            <a class="nav-link" href="#!/login">Вход в личный кабинет</a>
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

     <!-- <main class="col-sm-12 col-md-8 col-lg-9 col-xl-9" role="main" id="main"> -->
      <!-- <main class=" col-xl-10 col-lg-10 col-md-10 col-sm-12" role="main" id="main">  -->

       <main class="" role="main" id="main">
        <div class="content">
          <div ng-view="" class="ng-scope">
          </div>  
        </div>
      </main>
    </div>
  </div>
</div>
  
  <!-- <div id="wrapper">

    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="#">
                    Brand
                </a>
            </li>
            <li>
                <a href="#">Link 1</a>
            </li>
            <li>
                <a href="#">Link 2</a>
            </li>
        </ul>
    </div>

    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Content</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo dolore, exercitationem saepe omnis quibusdam ipsum culpa voluptatum, quam magni tenetur architecto minus facilis sapiente impedit libero tempora harum consequuntur? Necessitatibus.</p>
                    <a href class="btn btn-primary" data-toggle="sidebar">Toggle Menu</a>
                </div>
            </div>
        </div>
    </div>

  </div> -->


<!-- <footer class="footer">
    <div class="container">
        <p class="pull-right"><?= Yii::powered() ?> <?= Yii::getVersion() ?></p>
    </div>
</footer> -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>