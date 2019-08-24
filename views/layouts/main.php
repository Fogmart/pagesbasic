<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);



    $menuItems = [
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php
                if (!Yii::$app->user->isGuest) {
                    $menuItems =  [
                            ['label' => 'Личный кабинет ', 'options' => ['class' => 'header']],
                            ['label' => 'Мой настройки', 'options' => ['class' => 'header']],
                            ['label' => 'Админка', 'icon' => 'dashboard', 'url' => ['/apage'],
                                'visible' => Yii::$app->user->can('admin'),
                                'items'=>[
                                        ['label' => 'Работа с PHP', 'icon' => 'dashboard', 'url' => ['/php'],
                                            'items'=>[['label' => 'Создать php', 'icon' => 'dashboard', 'url' => ['/php/create'],]
                                            ]
                                        ],
                                        ['label' => 'Работа с TXT', 'icon' => 'dashboard', 'url' => ['/apage'],
                                            'items'=>[['label' => 'Создать TXT', 'icon' => 'dashboard', 'url' => ['/apage/create'],]
                                            ]
                                        ],
                                        ['label' => 'Пользователи', 'icon' => 'dashboard', 'url' => ['/user']],
                                        ['label' => 'Категории статей', 'icon' => 'dashboard', 'url' => ['/category']],
                                        ['label' => 'Группы пользователей', 'icon' => 'dashboard', 'url' => ['/group']],
                                        ['label' => 'Присовоение групп', 'icon' => 'dashboard', 'url' => ['/category/assign']],
                            ]],
                            ['label' => 'Все статьи', 'icon' => 'dashboard', 'url' => ['/page/alltext']],
                            ['label' => 'Все страницы', 'icon' => 'dashboard', 'url' => ['/page/allphp']],
                    ];

                    ?>
                    <?= \yii\widgets\Menu::widget(['items' => $menuItems,]);
                }
                ?>

            </div>
            <div class="col-md-9">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">

    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
