<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        QUEL CINEMAS
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('reset.css') ?>
    <?= $this->Html->css('quel_cinemas.css') ?>
    <?= $this->Html->css('slick-theme.css') ?>
    <?= $this->Html->css('slick.css') ?>
    <?= $this->Html->css('toppage.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body>
    <header>
        <div class="header-container">
            <div class="header-left-box">
                <h1><span>QUEL</span> CINEMAS</h1>
            </div>
            <div class="header-right-box">
                <nav class="right-container">
                    <div class="menu-box">
                        <ul class="link-menu">
                            <li><a href="Toppage">トップ</a></li>
                            <li><a href="#">上映スケジュール</a></li>
                            <li><a href="BasicRateDiscountPage">料金・割引</a></li>
                        </ul>
                    </div>
                    <div class="log-box">
                        <div class="login-logout">
                            <?php if (!empty($auth)) : ?>
                                <a href=<?= $this->Url->build(['controller' => 'Mypage', 'action' => 'index']) ?>>マイページ</a>
                            <?php else : ?>
                                <a href="login">ログイン・新規会員登録</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <main>
        <div class="container clearfix">
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
        <div class="footer-container">
            <div class="footer-left-box">
                <p>QUEL CINEMAS</p>
            </div>
            <div class="footer-right-box">
                <nav>
                    <div>
                        <ul class="footer-right-container">
                            <li><a href="#">トップ</a></li>
                            <li><a href="#">上映スケジュール</a></li>
                            <li><a href="#">料金・割引</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </footer>
    <?= $this->Html->script('jquery-3.5.1.min.js') ?>
    <?= $this->Html->script('slick/slick.min.js') ?>
    <?= $this->Html->script('toppage.js') ?>
</body>

</html>
