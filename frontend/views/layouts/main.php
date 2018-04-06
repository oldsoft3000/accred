

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

    <nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#sidebar" aria-expanded="false" aria-controls="navbarsExampleDefault" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- <a class="navbar-brand" href="#">Navbar</a> -->
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


    <div class="sidebar collapse" id="sidebar">
      <ul class="nav"> 
        <li ng-show="!loggedIn()" class="nav-item">
          <!--ng-class="{'selected-style':isActivePath('/login')||isActivePath('/signup')}"-->
          <a  class="btn btn-outline-secondary nav-link" role="button" aria-disabled="true" href="#!/login">Вход в личный кабинет</a>
        </li>
        <li ng-show="loggedIn()" class="nav-item">
          <!--ng-class="{'selected-style':isActivePath('/agreement')}"--> 
          <a class="btn btn-outline-secondary nav-link" role="button" aria-disabled="true" href="#!/agreement">Соглашение</a>
        </li>
        <li ng-show="loggedIn()" class="nav-item">
          <!--ng-ng-class="{'selected-style':isActivePath('/particips')}"--> 
          <a class="btn btn-outline-secondary nav-link " role="button" aria-disabled="true" href="#!/particips">Список участников</a>
        </li>
        <li ng-show="loggedIn()" class="nav-item">
          <a ng-ng-click="logout()" class="btn btn-outline-secondary nav-link" role="button" aria-disabled="true" href="">Выход</a>
        </li>
      </ul>
    </div> 

    <div class="main" id="main">
      <div ng-view class="container-fluid">
      </div>
    </div>

    <?php $this->endBody() ?>
    
    <div class="device-sm" style="display:none;"></div>
    
    <script type="text/javascript">

       /*$(window).on('resize', function(){
            var container = document.getElementById ("main");
            if (container.scrollWidth > container.clientWidth) {
               $('#main').css('margin-left', '0px');
               $('#sidebar').css('position', 'relative');
               $('#sidebar').css('width', '100%');
            }
      });*/
        // Wrap IIFE around your code

        function isBreakpoint( alias ) {
            return $('.device-' + alias).is(':visible');
        }
        
        var intervalID = setInterval(function() {
            if( isBreakpoint('sm') ) {
                //$('#sidebar').collapse('hide');
                //$('navbar-toggler').last().addClass("collapsed");
                //$('#sidebar').last().removeClass("show");
                
            } else {
               //$('#sidebar').collapse('show');
               //$('navbar-toggler').last().removeClass("collapsed");
               //$('#sidebar').last().addClass("show");
            }
        }, 300 );
        
    </script>
  </body>
</html>
<?php $this->endPage() ?>